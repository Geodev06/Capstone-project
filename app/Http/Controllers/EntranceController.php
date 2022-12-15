<?php

namespace App\Http\Controllers;

use App\Models\Entrance;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Omnipay\Omnipay;

class EntranceController extends Controller
{

    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId('AaC575VT_i0PlHwzkWdheBetoe6J5cm83ihBiB9gERWSUmSknJxfN46ldm4X8_uYGHXHgYJ9jVJ8gWCt');
        $this->gateway->setSecret('EEIXG0-ngYU1QYGiffKEbKKu6SOsJ_199qgGA-Kl3PsuU0e3bjlZ6lrVopXj21dV5ozlOxKFvVQMlLLa');
        $this->gateway->setTestMode(true);
    }

    public function pay(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'no_of_person' => 'required|integer|min:1|max:99999',
            'amount' => 'required'
        ], [
            'date.required' => 'please pick a target'
        ]);

        $amount = ($request->amount * $request->no_of_person);
        try {

            $response = $this->gateway->purchase(array(
                'amount' => $amount,
                'currency' => 'PHP',
                'returnUrl' => url('success',  [$request->date, $request->no_of_person]),
                'cancelUrl' => url('error')
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request, $date, $no_of_person)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {

                $arr = $response->getData();

                $payment = new Payment();
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = 'PHP';
                // $payment->payment_status = $arr['state'];
                $payment->payment_status = 'to-approve';
                $payment->user_id = Auth::user()->id;
                $payment->type = 'entrance';
                $payment->save();

                Entrance::create([
                    'payment_id' => $arr['id'],
                    'user_id' => Auth::user()->id,
                    'target_date' => Carbon::parse($date)->format(' jS, \of F, Y'),
                    'no_of_person' => $no_of_person,
                    'amount' => $arr['transactions'][0]['amount']['total'],
                    'status' => 'to-approve'
                ]);

                $admin_id = User::where('role', 1)->get();
                Notification::create([
                    'receiver_id' => $admin_id[0]->id,
                    'receiver' => 'admin',
                    'content' => 'Entrance payment has arrived [PAYMENT-ID] - ' . $arr['id']
                ]);

                return Redirect::route('user.entrance')->with('success', 'Payment success!');
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Payment declined!!';
        }
    }

    public function error()
    {
        return Redirect::route('user.dashboard');
    }

    public function getdata()
    {
        if (Auth::check()) {

            $entrance = Payment::where('user_id', Auth::user()->id)
                ->where('type', 'entrance')->get();


            $data = [];
            for ($i = 0; $i < count($entrance); $i++) {
                array_push($data, [
                    'payment_id' => $entrance[$i]->payment_id,
                    'payer_email' => $entrance[$i]->payer_email,
                    'amount' => $entrance[$i]->amount,
                    'payment_status' => $entrance[$i]->payment_status,
                    'date' => $entrance[$i]->created_at->format('M d Y g:i  A')

                ]);
            }
            return response()->json(['status' => 200, 'entrance' => $data]);
        }
        abort(404);
    }

    public function entrancedetails($payment_id)
    {
        if (Auth::check()) {

            $data = Entrance::where('payment_id', $payment_id)
                ->where('user_id', Auth::user()->id)
                ->get();
            return response()->json(['status' => 200, 'details' => $data]);
        }
        abort(404);
    }
    public function receipt($payment_id)
    {
        $payment = Payment::where('payment_id', $payment_id)->get();
        $entrance_Details = Entrance::where('payment_id', $payment_id)->get();

        $data = [];
        array_push($data, [
            'payment' => $payment,
            'details' => $entrance_Details
        ]);
        return view('user.entrance_receipt', compact('data'));
    }
}
