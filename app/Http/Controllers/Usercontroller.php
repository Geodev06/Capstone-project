<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bookinghistory;
use App\Models\Content;
use App\Models\Entrance;
use App\Models\Establishment;
use App\Models\FAQ;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Price;
use App\Models\Rating;
use App\Models\Room;
use App\Models\Roomimage;
use App\Models\Unread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Return_;

class Usercontroller extends Controller
{

    public function __contruct()
    {
        $this->middleware(['auth', 'user']);
    }

    public function index()
    {
        # code...
        if (Auth::user()->email_verified_at === null) {
            return redirect()->route('verification.notice');
        }
        if (Auth::check()) {
            $userdata = Auth::user();
            $rooms = Room::where('status', 'free')->get();
            $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();

            $has_history = Booking::where('status', 'expired')
                ->where('user_id', Auth::user()->id)->count();
            $has_rating = Rating::where('user_id', Auth::user()->id)->count();



            $eligible_for_rating = false;

            if ($has_history > 0 && $has_rating <= 0) {
                $eligible_for_rating = true;
            }

            $notifications = Notification::where('status', 'unread')
                ->where('receiver_id', Auth::user()->id)
                ->count();

            $dashboard_data = [
                'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                'nearby' => Establishment::count(),
                'notifications' => $notifications
            ];

            return view('user.dashboard', compact('userdata', 'rooms', 'unread_count', 'notifications', 'dashboard_data'))
                ->with('eligible', $eligible_for_rating);
        }
        return Redirect::route('index');
    }

    public function tanaw_map()
    {
        # code...

        if (Auth::check()) {
            $userdata = Auth::user();
            $rooms = Room::all();
            $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();


            $notifications = Notification::where('status', 'unread')
                ->where('receiver_id', Auth::user()->id)
                ->count();

            $dashboard_data = [
                'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                'nearby' => Establishment::count(),
                'notifications' => $notifications
            ];

            $map_data = Content::where('type', 'tanaw-map')->take(1)->get();
            return view('user.tanaw_map', compact('userdata', 'rooms', 'unread_count', 'notifications', 'dashboard_data', 'map_data'));
        }
        return Redirect::route('index');
    }
    public function rating_store(Request $request)
    {
        if ($request->ajax()) {


            Rating::create([
                'user_id' => Auth::user()->id,
                'feedback' => $request->feedback,
                'comment' => $request->comment
            ]);

            return response()->json(['status' => 200, 'msg' => 'Thank you for your feedback :)']);
        }
    }
    public function booking()
    {
        if (Auth::check()) {
            $userdata = Auth::user();
            $rooms = Room::all();
            $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();


            $notifications = Notification::where('status', 'unread')
                ->where('receiver_id', Auth::user()->id)
                ->count();

            $dashboard_data = [
                'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                'nearby' => Establishment::count(),
                'notifications' => $notifications
            ];
            return view('user.user_booking', compact('userdata', 'rooms', 'unread_count', 'notifications', 'dashboard_data'));
        }
        return Redirect::route('index');
    }

    public function userBooking()
    {
        if (Auth::check()) {
            $Booking = PaymentDetail::where('user_id', Auth::user()->id)->get();
            return response()->json(['status' => 200, 'content' => $Booking]);
        }
        return response()->json(['status' => 0, 'msg' => 'Error']);
    }

    public function userBooking_detail($pay_id)
    {
        if (Auth::check()) {
            $Booking = Booking::where('user_id', Auth::user()->id)
                ->where('payment_id', $pay_id)
                ->get();

            return response()->json(['status' => 200, 'content' => $Booking]);
        }
        return response()->json(['status' => 0, 'msg' => 'Error']);
    }

    public function updateinfo(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|max:11|min:11',
        ]);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        User::where('id', $request->id)->update($data);

        if (Auth::user()->role == 1) {
            return Redirect::route('admin.setting')->with('success', 'Changes has been saved!.');
        }

        if (Auth::user()->role == 0) {
            return Redirect::route('user.setting')->with('success', 'Changes has been saved!.');
        }
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'old_pass' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);


        if (Auth::user()->role == 1) {
            if (!Hash::check($request->input('old_pass'), Auth::user()->password)) {
                return Redirect::route('admin.setting')->with('error', 'Incorrect old password.');
            }
        }
        if (Auth::user()->role == 0) {
            if (!Hash::check($request->input('old_pass'), Auth::user()->password)) {
                return Redirect::route('user.setting')->with('error', 'Incorrect old password.');
            }
        }


        User::where('id', $request->id)->update([
            'password' => Hash::make($request->password)
        ]);

        if (Auth::user()->role == 1) {
            return Redirect::route('admin.setting')->with('success', 'Changes has been saved!.');
        }

        if (Auth::user()->role == 0) {
            return Redirect::route('user.setting')->with('success', 'Changes has been saved!.');
        }
    }

    public function userdelete($id)
    {
        # code...
        User::where('id', $id)->delete();
        return Redirect::route('index');
    }

    public function setting()
    {
        $userdata = Auth::user();
        $isLoggedin = Auth::check();
        $rooms = Room::all();
        $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();


        $notifications = Notification::where('status', 'unread')
            ->where('receiver_id', Auth::user()->id)
            ->count();

        $dashboard_data = [
            'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
            'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
            'nearby' => Establishment::count(),
            'notifications' => $notifications
        ];
        return view('user_settings', compact('userdata', 'isLoggedin', 'rooms', 'unread_count', 'notifications', 'dashboard_data'));
    }

    public function showRoomDetail($room_no)
    {
        if (Room::where('room_no', $room_no)->count() > 0 && Room::where('status', 'free')->count() > 0) {
            $userdata = Auth::user();
            $rooms = Room::where('room_no', $room_no)->get();
            $images = Roomimage::where('room_no', $room_no)->get();
            $prices = Price::orderBy('hour', 'asc')->get();
            $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();

            $notifications = Notification::where('status', 'unread')
                ->where('receiver_id', Auth::user()->id)
                ->count();

            $dashboard_data = [
                'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                'nearby' => Establishment::count(),
                'notifications' => $notifications
            ];
            return view('user.view_room', compact('userdata', 'rooms', 'images', 'prices', 'unread_count', 'notifications', 'dashboard_data'));
        }
        abort(404);
    }

    public function checkInForm($room_no)
    {
        if (Auth::check()) {
            if (Room::where('room_no', $room_no)->count() > 0 && Room::where('status', 'free')->count() > 0) {
                $userdata = Auth::user();
                $rooms = Room::where('room_no', $room_no)->get();
                $prices = Price::orderBy('hour', 'asc')->get();
                $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();

                $notifications = Notification::where('status', 'unread')
                    ->where('receiver_id', Auth::user()->id)
                    ->count();

                $gcash_content = Content::where('type', 'gcash-payment')->take(1)->get();

                $dashboard_data = [
                    'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                    'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                    'nearby' => Establishment::count(),
                    'notifications' => $notifications
                ];

                return view('user.check_in_form', compact('userdata', 'rooms', 'prices', 'unread_count', 'notifications', 'gcash_content', 'dashboard_data'));
            } else {
                abort(404);
            }
        }
        return Redirect::route('index');
    }

    public function nearby()
    {
        if (Auth::check()) {
            $userdata = Auth::user();
            $rooms = Room::all();
            $establishments = Establishment::all();
            $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();

            $notifications = Notification::where('status', 'unread')
                ->where('receiver_id', Auth::user()->id)
                ->count();

            $dashboard_data = [
                'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                'nearby' => Establishment::count(),
                'notifications' => $notifications
            ];

            return view('user.nearby', compact('userdata', 'rooms', 'establishments', 'unread_count', 'notifications', 'dashboard_data'));
        }
        return Redirect::route('index');
    }

    public function payments()
    {
        if (Auth::check()) {
            $userdata = Auth::user();
            $rooms = Room::all();
            $establishments = Establishment::all();
            $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();

            $notifications = Notification::where('status', 'unread')
                ->where('receiver_id', Auth::user()->id)
                ->count();

            $dashboard_data = [
                'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                'nearby' => Establishment::count(),
                'notifications' => $notifications
            ];

            return view('user.payments', compact('userdata', 'rooms', 'establishments', 'unread_count', 'notifications', 'dashboard_data'));
        }
        return Redirect::route('index');
    }

    public function myPayments_get_json($userid)
    {
        $payments = Payment::where('user_id', $userid)->orderBy('created_at', 'desc')->get();

        $data = [];
        for ($i = 0; $i < count($payments); $i++) {
            array_push(
                $data,
                [
                    $payments[$i]->payment_id,
                    $payments[$i]->amount,
                    $payments[$i]->payment_status,
                    $payments[$i]->created_at->format('Y-m-d') . ' || ' . $payments[$i]->created_at->diffForHumans(),
                ]
            );
        }
        return response()->json(['status' => 200, 'payments' => $data]);
    }

    public function entrance()
    {
        if (Auth::check()) {
            $userdata = Auth::user();
            $rooms = Room::all();
            $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();

            $notifications = Notification::where('status', 'unread')
                ->where('receiver_id', Auth::user()->id)
                ->count();

            $gcash_content = Content::where('type', 'gcash-payment')->take(1)->get();

            $dashboard_data = [
                'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                'nearby' => Establishment::count(),
                'notifications' => $notifications
            ];

            return view('user.entrance', compact('userdata', 'rooms', 'unread_count', 'notifications', 'gcash_content', 'dashboard_data'));
        }
        return Redirect::route('index');
    }

    public function get_establishment_json()
    {
        $est = Establishment::all();
        # code...
        $view = view('user.establishment_item', compact('est'))->render();
        return response()->json(['status' => 200, 'data' => $est, 'view' => $view]);
    }

    public function messages()
    {
        if (Auth::check()) {
            $userdata = Auth::user();
            $rooms = Room::all();

            $unread_count = Unread::where('message_id', Auth::user()->id)->where('receiver_type', 'user')->count();

            $notifications = Notification::where('status', 'unread')
                ->where('receiver_id', Auth::user()->id)
                ->count();

            $dashboard_data = [
                'registration' => Payment::where('user_id', Auth::user()->id)->where('payment_status', 'paid')->count(),
                'bookings' => Booking::where('user_id', Auth::user()->id)->count(),
                'nearby' => Establishment::count(),
                'notifications' => $notifications
            ];
            return view('user.messages', compact('userdata', 'rooms', 'unread_count', 'notifications', 'dashboard_data'));
        }
        return Redirect::route('index');
    }

    public function send_message(Request $request)
    {
        if ($request->message === '') {
            response()->json(['status' => 0, 'msg' => 'cannot send empty message.']);
        }

        Message::create(
            [
                'sender_id' => Auth::user()->id,
                'sender_name' => Auth::user()->name,
                'message_id' => Auth::user()->id,
                'message' => $request->message,
                'sender_type' => 'user',
                'sender_email' => Auth::user()->email
            ]
        );
        Unread::create([
            'message_id' => Auth::user()->id,
            'receiver_type' => 'admin'
        ]);
        return response()->json(['status' => 200, 'msg' => 'message has been sent.']);
    }

    public function get_message()
    {
        # code...
        Unread::where('message_id', Auth::user()->id)
            ->where('receiver_type', 'user')->delete();
        $message = Message::where('message_id', Auth::user()->id)->get();


        $content =  view('user.message_content', compact('message'))->render();
        return response()->json(['status' => 200, 'content' => $content]);
    }

    public function get_nearby(Request $request)
    {
        # code...
        $est = Establishment::where('establishment_name', 'like', '%' . $request->search . '%')
            ->orWhere('establishment_address', 'like', '%' . $request->search . '%')
            ->get();

        $view = view('user.establishment_item', compact('est'))->render();

        return response()->json(['status' => 200, 'view' => $view]);
    }

    public function refund_request($id)
    {
        # code...
        $admin_id = User::where('role', 1)->get();

        Notification::create([
            'receiver_id' => $admin_id[0]->id,
            'receiver' => 'admin',
            'content' => 'Entrance cancellation has arrived [PAYMENT-ID] - ' . $id
        ]);

        Entrance::where('payment_id', $id)->update([
            'status' => 'on-cancel-request'
        ]);

        Payment::where('payment_id', $id)->update([
            'payment_status' => 'on-cancel-request'
        ]);

        return response()->json(['status' => 200, 'msg' => 'ok']);
    }

    public function cancel_booking($id)
    {
        # code...
        $admin_id = User::where('role', 1)->get();
        Notification::create([
            'receiver_id' => $admin_id[0]->id,
            'receiver' => 'admin',
            'content' => 'Entrance cancellation has arrived [PAYMENT-ID] - ' . $id
        ]);

        Booking::where('payment_id', $id)->update([
            'status' => 'on-cancel-request'
        ]);

        Payment::where('payment_id', $id)->update([
            'payment_status' => 'on-cancel-request'
        ]);

        return response()->json(['status' => 200, 'msg' => 'ok']);
    }

    public function notification()
    {
        # code...
        if (request()->ajax()) {

            $notifications = Notification::where('receiver_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $content = view('user.notification', compact('notifications'))->render();

            return response()->json(['status' => 200, 'data' => $content]);
        }
    }

    public function notification_update($id)
    {
        # code...
        if (request()->ajax()) {

            Notification::where('id', $id)->update(['status' => 'seen']);

            $notifications = Notification::all()->values()->reverse();
            $content = view('user.notification', compact('notifications'))->render();

            return response()->json(['status' => 200, 'data' => $content]);
        }
    }

    public function notification_delete($id)
    {
        # code...
        if (request()->ajax()) {

            Notification::where('id', $id)->delete();

            $notifications = Notification::all()->values()->reverse();
            $content = view('user.notification', compact('notifications'))->render();

            return response()->json(['status' => 200, 'data' => $content]);
        }
    }

    public function get_faqs()
    {
        # code...
        $faqs = FAQ::all()->reverse()->values();
        $view = view('user.faqs', compact('faqs'))->render();

        return response()->json(['status' => 200, 'content' => $view]);
    }
    public function get_context()
    {
        # code...
        $context = Content::where('type', 'Chatbot-context')->first();

        return response()->json(['status' => 200, 'content' => $context]);
    }

    public function gcash_pay(Request $request)
    {
        # code...
        if (request()->ajax()) {

            /**
             * Booking payment gcash
             */
            if ($request->type === 'booking') {

                $pay_id = 'PAYID-' . md5(now());
                Payment::create(
                    [
                        'payment_id' => $pay_id,
                        'payer_id' => Auth::user()->id,
                        'payer_email' => Auth::user()->email,
                        'amount' => $request->amount,
                        'currency' => 'PHP',
                        'payment_status' => 'to-approve',
                        'user_id' => Auth::user()->id,
                        'type' => null
                    ]
                );

                Room::where('room_no', $request->room_no)->update([
                    'status' => 'reserved'
                ]);

                PaymentDetail::create(
                    [
                        'payment_id' => $pay_id,
                        'checker_name' => Auth::user()->name,
                        'address' => Auth::user()->address,
                        'email' => Auth::user()->email,
                        'mobile' => Auth::user()->phone,
                        'target_date' => $request->target_date,
                        'plan' => $request->plan,
                        'user_id' => Auth::user()->id,
                        'room_no' => $request->room_no,
                        'validity' => Carbon::parse($request->target_date)->format('M d Y'),
                    ]
                );

                $userdata = User::where('id', Auth::user()->id)->get();

                $NO_OF_DAYS = round($request->hour / 24);

                Booking::create(
                    [
                        'payment_id' => $pay_id,
                        'checker_name' => $userdata[0]->name,
                        'address' => $userdata[0]->address,
                        'email' => $userdata[0]->email,
                        'mobile' => $userdata[0]->phone,
                        'target_date' => $request->target_date,
                        'plan' => $request->plan,
                        'check_out_date' => Carbon::parse($request->target_date)->addDays($NO_OF_DAYS)->format('M d Y'),
                        'hour' => $request->hour,
                        'user_id' => Auth::user()->id,
                        'room_no' => $request->room_no,
                        'validity' => $request->target_date,
                        'status' => 'reserved'
                    ]
                );

                $admin_id = User::where('role', 1)->get();
                Notification::create([
                    'receiver_id' => $admin_id[0]->id,
                    'receiver' => 'admin',
                    'content' => 'Booking payment via gcash has arrived [PAYMENT-ID] - ' . $pay_id
                ]);

                return response()->json(['status' => 200, 'msg' => 'ok']);
            }

            /**
             * Entrance payment gcash
             */
            if ($request->type === 'entrance') {

                $pay_id = 'PAYID-' . md5(now());

                Payment::create(
                    [
                        'payment_id' => $pay_id,
                        'payer_id' => Auth::user()->id,
                        'payer_email' => Auth::user()->email,
                        'amount' => $request->amount,
                        'currency' => 'PHP',
                        'payment_status' => 'to-approve',
                        'user_id' => Auth::user()->id,
                        'type' => 'entrance'
                    ]
                );

                Entrance::create([
                    'payment_id' => $pay_id,
                    'user_id' => Auth::user()->id,
                    'target_date' => Carbon::parse($request->target_date)->format(' jS, \of F, Y'),
                    'no_of_person' => $request->no_of_person,
                    'amount' => $request->amount,
                    'status' => 'available'
                ]);

                $admin_id = User::where('role', 1)->get();
                Notification::create([
                    'receiver_id' => $admin_id[0]->id,
                    'receiver' => 'admin',
                    'content' => 'Entrance payment has arrived [PAYMENT-ID] - ' . $pay_id
                ]);

                return response()->json(['status' => 200, 'msg' => 'ok']);
            }
        }
    }
}
