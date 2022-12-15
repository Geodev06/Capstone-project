<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Omnipay\Omnipay;

class PaymentController extends Controller
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
            'date' => 'required'
        ]);
        try {

            $response = $this->gateway->purchase(array(
                'amount' => $request->amount,
                'currency' => 'PHP',
                'returnUrl' => url('success', [$request->user_id, Carbon::parse($request->date)->format('M d Y'), $request->plan, $request->room_no, $request->hour]),
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

    public function success(Request $request, $userid, $tdate, $plan, $room_no, $hour)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {

                $arr = $response->getData();

                $userdata = User::where('id', $userid)->get();

                Room::where('room_no', $room_no)->update([
                    'status' => 'reserved'
                ]);

                $payment = new Payment();
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = 'PHP';
                // $payment->payment_status = $arr['state'];
                $payment->payment_status = 'to-approve';
                $payment->user_id = Auth::user()->id;
                $payment->save();

                PaymentDetail::create(
                    [
                        'payment_id' => $arr['id'],
                        'checker_name' => $userdata[0]->name,
                        'address' => $userdata[0]->address,
                        'email' => $userdata[0]->email,
                        'mobile' => $userdata[0]->phone,
                        'target_date' => $tdate,
                        'plan' => $plan,
                        'user_id' => $userid,
                        'room_no' => $room_no,
                        'validity' => $tdate,
                    ]
                );

                $NO_OF_DAYS = round($hour / 24);

                Booking::create(
                    [
                        'payment_id' => $arr['id'],
                        'checker_name' => $userdata[0]->name,
                        'address' => $userdata[0]->address,
                        'email' => $userdata[0]->email,
                        'mobile' => $userdata[0]->phone,
                        'target_date' => $tdate,
                        'plan' => $plan,
                        'check_out_date' => Carbon::parse($tdate)->addDays($NO_OF_DAYS)->format('M d Y'),
                        'hour' => $hour,
                        'user_id' => $userid,
                        'room_no' => $room_no,
                        'validity' => $tdate,
                        'status' => 'reserved'
                    ]
                );

                $admin_id = User::where('role', 1)->get();

                Notification::create([
                    'receiver_id' => $admin_id[0]->id,
                    'receiver' => 'admin',
                    'content' => 'Booking payment has arrived [PAYMENT-ID] - ' . $arr['id']
                ]);

                return Redirect::route('check_in.receipt', $arr['id'])->with('success', 'Payment success!');
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

    public function check_in_receipt($payment_id)
    {
        $payment = Payment::where('payment_id', $payment_id)->get();
        $details = PaymentDetail::where('payment_id', $payment_id)->get();
        return view('user.check_in_receipt', compact('payment', 'details'));
    }
}
