<?php

namespace App\Http\Controllers;

use App\Mail\CancellationEmail;
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
use App\Models\Rating;
use App\Models\Room;
use App\Models\Unread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {

        $userdata = Auth::user();
        $users = User::where('role', 0)->count();
        $contents = Content::count();
        $establishments = Establishment::count();
        $daily_rev = Payment::where('payment_status', 'paid')->whereDate('created_at', Carbon::today())->sum('amount');
        $room_count = Room::count();
        $booking_count = Booking::where('status', 'reserved')->count();

        // $current_visitor = Entrance::whereDate(DB::raw('date_format(target_date," jS, \of F, Y")'), Carbon::parse(now())->format('jS, \of F, Y'))->count();
        $current_visitor = Entrance::select('target_date', DB::raw('sum(no_of_person) as visitor'))
            ->where('status', 'paid')
            ->where('target_date', Carbon::parse(now())->format(' jS, \of F, Y'))
            ->groupBy('target_date')
            ->get();

        $BOOKINGS = Booking::where('target_date', Carbon::parse(now())->format('M d Y'))
            ->where('status', 'reserved')
            ->get();

        if (count($BOOKINGS) > 0) {
            for ($i = 0; $i < count($BOOKINGS); $i++) {
                Booking::where('payment_id', $BOOKINGS[$i]->payment_id)
                    ->update(
                        ['status' => 'expired']
                    );
            }
        }

        $RESERVATIONS = Entrance::where('target_date', Carbon::parse(now())->format(' jS, \of F, Y'))
            ->where('status', 'paid')
            ->get();

        if (count($RESERVATIONS) > 0) {
            for ($i = 0; $i < count($RESERVATIONS); $i++) {
                Entrance::where('payment_id', $RESERVATIONS[$i]->payment_id)
                    ->update(
                        ['entrance_status' => 'expired']
                    );
            }
        }

        $tanaw_visitor = "";

        if (count($current_visitor) <= 0) {
            $tanaw_visitor = "0";
        } else {
            $tanaw_visitor = $current_visitor[0]->visitor;
        }



        $free_room = Room::where('status', 'free')->count();
        $reserved_room = Room::where('status', 'reserved')->count();
        $inused_room = Room::where('status', 'in-used')->count();

        $room_infos = array($free_room, $reserved_room, $inused_room);

        $recent_payment = Payment::where('type', '=', null)->latest()->take(6)->get();

        $entrance_payment = Payment::where('type', '=', 'entrance')->latest()->take(6)->get();

        $entrance_payment_count = Payment::where('type', '=', 'entrance')->where('payment_status', 'paid')->count();

        $unread_msg = Unread::where('receiver_type', 'admin')->count();

        $notifications = Notification::where('status', 'unread')
            ->where('receiver_id', Auth::user()->id)
            ->count();

        $dashboard = [
            $users,
            $contents,
            $establishments,
            number_format((float)$daily_rev, 2, '.', ''),
            $room_count,
            $booking_count,
            $tanaw_visitor,
            $room_infos,
            $notifications,
            $entrance_payment_count
        ];



        return view('admin.dashboard', compact('userdata', 'dashboard', 'recent_payment', 'entrance_payment', 'unread_msg'));
    }

    public function manageUsers()
    {
        # code...
        $userdata = Auth::user();
        $unread_msg = Unread::where('receiver_type', 'admin')->count();

        return view('admin.users', compact('userdata', 'unread_msg'));
    }

    public function managecontent()
    {
        # code...
        $userdata = Auth::user();
        $contents = Content::all()->reverse()->values();
        $unread_msg = Unread::where('receiver_type', 'admin')->count();
        return view('admin.manage_content', compact('userdata', 'contents', 'unread_msg'));
    }

    public function setting()
    {
        # code...
        $userdata = Auth::user();
        $isLoggedin = Auth::check();
        $unread_msg = Unread::where('receiver_type', 'admin')->count();

        return view('user_settings', compact('userdata', 'isLoggedin', 'unread_msg'));
    }

    public function payments()
    {
        $userdata = Auth::user();
        $isLoggedin = Auth::check();
        $unread_msg = Unread::where('receiver_type', 'admin')->count();
        return view('admin.user_payments', compact('userdata', 'isLoggedin', 'unread_msg'));
    }

    public function contentStore(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'content' => 'required',
                    'image' => 'required'
                ]
            );

            if (!$validator->passes()) {
                return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
            } else {
                $img_path = null;
                if ($request->hasFile('image')) {
                    $img_path = 'uploads/' . now()->timestamp . $request->file('image')->getClientOriginalName();
                    $destination = public_path('/uploads');
                    $request->image->move($destination, $img_path);
                }

                Content::create([
                    'title' => $request->title,
                    'content' => $request->content,
                    'type' => $request->type,
                    'image' => $img_path
                ]);
                return response()->json(['status' => 200, 'msg' => 'Content created!']);
            }
        }
    }
    public function getcontent_json()
    {
        $contents = Content::all();

        $data = [];
        for ($i = 0; $i < count($contents); $i++) {
            array_push(
                $data,
                [
                    $contents[$i]->id,
                    $contents[$i]->title,
                    $contents[$i]->content,
                    $contents[$i]->created_at->format('Y-m-d') . ' | ' . $contents[$i]->created_at->diffForHumans(),
                    $contents[$i]->type,
                    $contents[$i]->image,
                ]
            );
        }

        return response()->json(['status' => 200, 'content' => $data]);
    }

    public function contentDestroy($id)
    {
        $file = Content::select('image')->where('id', $id)->get();


        if (File::exists(public_path($file[0]->image))) {
            File::delete(public_path($file[0]->image));
        }
        Content::where('id', $id)->delete();
        return response()->json(['status' => 200, 'msg' => 'Content has been removed!']);
    }

    public function contentUpdate(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'content' => 'required'
                ]
            );

            if (!$validator->passes()) {
                return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
            } else {

                $img_path = null;
                if ($request->image == null) {
                    $current_img = Content::select('image')->where('id', $id)->get();
                    $img_path = $current_img[0]->image;
                }

                if ($request->hasFile('image')) {
                    $img_path = 'uploads/' . now()->timestamp . $request->file('image')->getClientOriginalName();
                    $destination = public_path('/uploads');
                    $request->image->move($destination, $img_path);

                    $file = Content::select('image')->where('id', $id)->get();
                    if (File::exists(public_path($file[0]->image))) {
                        File::delete(public_path($file[0]->image));
                    }
                }



                Content::where('id', $id)->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'type' => $request->type,
                    'image' => $img_path
                ]);
                return response()->json(['status' => 200, 'msg' => 'Content updated!']);
            }
        }
    }

    public function getusers_json()
    {
        $userdata = User::where('role', 0)->get();

        $data = [];
        for ($i = 0; $i < count($userdata); $i++) {
            array_push(
                $data,
                [
                    $userdata[$i]->id,
                    $userdata[$i]->name,
                    $userdata[$i]->address,
                    $userdata[$i]->email,
                    $userdata[$i]->phone,
                    $userdata[$i]->created_at->format('Y-m-d'),
                ]
            );
        }

        return response()->json(['status' => 200, 'users' => $data]);
    }

    public function payments_get_json()
    {
        $payments = Payment::all()->reverse()->values();

        $data = [];
        for ($i = 0; $i < count($payments); $i++) {
            array_push(
                $data,
                [
                    $payments[$i]->payment_id,
                    $payments[$i]->payer_id,
                    $payments[$i]->payer_email,
                    $payments[$i]->amount,
                    $payments[$i]->payment_status,
                    $payments[$i]->created_at->format('Y-m-d'),
                    $payments[$i]->type
                ]
            );
        }
        return response()->json(['status' => 200, 'payments' => $data]);
    }

    public function booking_get_json($room_no)
    {
        $bookings = Booking::where('room_no', $room_no)->where('status', 'reserved')
            ->orWhere('status', 'in-used')->get();
        return response()->json(['status' => 200, 'booking' => $bookings]);
    }

    public function end_user_booking($booking_id)
    {

        if (Booking::where('id', $booking_id)->count() > 0) {

            $booking = Booking::where('id', $booking_id)->get();

            Room::where('room_no', $booking[0]->room_no)->update(['status' => 'free']);

            Bookinghistory::create(
                [
                    'payment_id' => $booking[0]->payment_id,
                    'booking_no' => $booking[0]->id,
                    'user_id' => $booking[0]->user_id,
                    'room_no' => $booking[0]->room_no
                ]
            );

            Booking::where('id', $booking_id)->update(['status' => 'expired']);
            return Redirect::route('rooms.manage')->with('success', 'Room has been freed');
        }
        abort(404);
    }

    public function revenue_overview($category)
    {
        if (Auth::check()) {
            if (request()->ajax()) {
                switch ($category) {
                    case 7:
                        //weekly
                        $response_data = DB::select('select sum(amount) as total, date_format(created_at, "%M-%d-%Y") as date from payments  where date(created_at) >= (date(now()) - interval 8 day) and payment_status = "paid" group by date order by created_at asc');
                        return response()->json(['status' => 200, 'data' => $response_data]);
                        break;
                    case 30:
                        //monthly
                        $response_data = DB::select('select sum(amount) as total, date_format(created_at, "%M-%Y") as date from payments where date(created_at) >= (date(now()) - interval 365 day) and payment_status = "paid" group by date order by created_at asc');
                        return response()->json(['status' => 200, 'data' => $response_data]);
                        break;
                    case 365:
                        //weekly
                        $response_data = DB::select('select sum(amount) as total, date_format(created_at, "%Y") as date from payments where payment_status = "paid" group by date');
                        return response()->json(['status' => 200, 'data' => $response_data]);
                        break;
                    default:
                        # code...
                        return response()->json(['status' => 200, 'data' => []]);
                        break;
                }
            }
        } else {
            return Redirect::route('forbidden');
        }
    }

    public function visitor_overview($category)
    {
        if (request()->ajax()) {
            switch ($category) {
                case 7:
                    //weekly
                    $response_data = DB::select('select sum(no_of_person) as total, date_format(created_at, "%M-%d-%Y") as date from entrances where date(created_at) >= (date(now()) - interval 8 day) and status="paid" group by date order by created_at asc');
                    return response()->json(['status' => 200, 'data' => $response_data]);
                    break;
                case 30:
                    //monthly
                    $response_data = DB::select('select sum(no_of_person) as total, date_format(created_at, "%M-%Y") as date from entrances where date(created_at) >= (date(now()) - interval 365 day) and status="paid" group by date order by created_at asc');
                    return response()->json(['status' => 200, 'data' => $response_data]);
                    break;
                case 365:
                    //weekly
                    $response_data = DB::select('select sum(no_of_person) as total, date_format(created_at, "%Y") as date from entrances where status="paid" group by date');
                    return response()->json(['status' => 200, 'data' => $response_data]);
                    break;
                default:
                    # code...
                    return response()->json(['status' => 200, 'data' => []]);
                    break;
            }
        }
    }

    public function entrance_payment_overview($category)
    {
        if (request()->ajax()) {
            switch ($category) {
                case 7:
                    //weekly
                    $response_data = DB::select('select sum(amount) as total, date_format(created_at, "%M-%d-%Y") as date from entrances where date(created_at) >= (date(now()) - interval 8 day) group by date order by created_at asc');
                    return response()->json(['status' => 200, 'data' => $response_data]);
                    break;
                case 30:
                    //monthly
                    $response_data = DB::select('select sum(amount) as total, date_format(created_at, "%M-%Y") as date from entrances where date(created_at) >= (date(now()) - interval 365 day) group by date order by created_at asc');
                    return response()->json(['status' => 200, 'data' => $response_data]);
                    break;
                case 365:
                    //weekly
                    $response_data = DB::select('select sum(amount) as total, date_format(created_at, "%Y") as date from entrances group by date');
                    return response()->json(['status' => 200, 'data' => $response_data]);
                    break;
                default:
                    # code...
                    return response()->json(['status' => 200, 'data' => []]);
                    break;
            }
        }
    }

    public function getRating()
    {
        # code...
        $excellent = Rating::where('feedback', 'excellennt')->count();
        $great = Rating::where('feedback', 'great')->count();
        $good = Rating::where('feedback', 'good')->count();
        $poor = Rating::where('feedback', 'poor')->count();
        $terrible = Rating::where('feedback', 'terrible')->count();

        $rating_count = Rating::count();
        $data = [
            'excellent' => round(($excellent / $rating_count) * 100, 2),
            'great' => round(($great / $rating_count) * 100, 2),
            'good' =>  round(($good / $rating_count) * 100, 2),
            'poor' => round(($poor / $rating_count) * 100, 2),
            'terrible' =>  round(($terrible / $rating_count) * 100, 2),
        ];
        if ($rating_count < 0) {
            return response()->json(['status' => 200, 'data' => 'no ratings']);
        }
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function message()
    {
        # code...
        $userdata = Auth::user();
        // $users_message = Message::all()->where('has_unread', true)->where('sender_id', '!=', Auth::user()->id)->groupBy('message_id');

        $users = Message::all()->where('sender_id', '!=', Auth::user()->id)->groupBy('message_id');

        $user_data = [];
        foreach ($users as $user) {
            array_push(
                $user_data,
                [
                    'user' => $user[0],
                    'unread' => Unread::where('message_id', $user[0]->message_id)->where('receiver_type', 'admin')->count()
                ]
            );
        }
        // dd($user_data[0]['user']);

        $unread_msg = Unread::where('receiver_type', 'admin')->count();

        return view('admin.message', compact('userdata', 'unread_msg', 'user_data'));
    }
    public function get_message($msg_id)
    {
        # code...
        $message = Message::where('message_id', $msg_id)->get();


        Unread::where('message_id', $msg_id)
            ->where('receiver_type', 'admin')
            ->delete();

        $content = view('admin.message_content', compact('message'))->render();

        return response()->json(['status' => 200, 'content' => $content]);
    }

    public function send_message(Request $request, $msg_id)
    {
        if ($request->message != '') {

            Message::create(
                [
                    'sender_id' => Auth::user()->id,
                    'sender_name' => 'administrator',
                    'message' => $request->message,
                    'message_id' => $msg_id,
                    'sender_type' => 'admin',
                    'sender_email' => Auth::user()->email

                ]
            );

            Unread::create([
                'message_id' => $msg_id,
                'receiver_type' => 'user'
            ]);
            return response()->json(['status' => 200, 'msg' => 'message has been sent!']);
        }
    }

    public function mark_room($booking_id)
    {
        $room_no = Booking::select('room_no')->where('id', $booking_id)->get();

        Room::where('room_no', $room_no[0]->room_no)->update(['status' => 'in-used']);

        Booking::where('id', $booking_id)->update(
            ['status' => 'in-used']
        );
        return response()->json(['msg' => 'Room has been updated!']);
    }

    public function notification()
    {
        # code...
        if (request()->ajax()) {

            $notifications = Notification::where('receiver_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $content = view('admin.notification', compact('notifications'))->render();

            return response()->json(['status' => 200, 'data' => $content]);
        }
    }

    public function notification_update($id)
    {
        # code...
        if (request()->ajax()) {

            Notification::where('id', $id)->update(['status' => 'seen']);

            $notifications = Notification::all()->values()->reverse();
            $content = view('admin.notification', compact('notifications'))->render();

            return response()->json(['status' => 200, 'data' => $content]);
        }
    }

    public function notification_delete($id)
    {
        # code...
        if (request()->ajax()) {

            Notification::where('id', $id)->delete();

            $notifications = Notification::all()->values()->reverse();
            $content = view('admin.notification', compact('notifications'))->render();

            return response()->json(['status' => 200, 'data' => $content]);
        }
    }

    public function faq_store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'question' => 'required',
                    'answer' => 'required'
                ]
            );

            if (!$validator->passes()) {
                return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
            } else {

                FAQ::create(
                    ['question' => $request->question, 'answer' => $request->answer]
                );

                return response()->json(['status' => 200, 'msg' => 'FAQ Created!']);
            }
        }
    }

    public function faq_get()
    {
        $faq = FAQ::all()->reverse()->values();
        return response()->json(['status' => 200, 'content' => $faq]);
    }

    public function faq_destroy($id)
    {
        # code...
        FAQ::where('id', $id)->delete();
        return response()->json(['status' => 200, 'msg' => 'Successfully deleted']);
    }

    public function approve_cancel_request($id)
    {
        # code...
        Payment::where('payment_id', $id)->update(
            [
                'payment_status' => 'cancelled'
            ]
        );

        $booking = Booking::where('payment_id', $id)->get();

        if (count($booking) > 0) {

            $payment_detail = PaymentDetail::where('payment_id', $id)->get();

            $mailData = [
                'to' => $payment_detail[0]->email
            ];

            Mail::to($payment_detail[0]->email)->send(new CancellationEmail($mailData));

            Room::where('room_no', $booking[0]->room_no)->update(
                [
                    'status' => 'free'
                ]
            );
            Booking::where('payment_id', $id)->update(['status' => 'cancelled']);

            Notification::create(
                [
                    'receiver_id' => $payment_detail[0]->user_id,
                    'receiver' => 'user',
                    'status' => 'unread',
                    'content' => 'Your Booking cancellation request has been approved by the administrator.'
                ]
            );

            Notification::create(
                [
                    'receiver_id' => Auth::user()->id,
                    'receiver' => 'admin',
                    'status' => 'unread',
                    'content' => 'Booking cancellation has been approved'
                ]
            );
        } else {

            //entrance
            $entrance = Entrance::where('payment_id', $id)->get();

            $user_email = User::where('id', $entrance[0]->user_id)->get();
            $mailData = [
                'to' => $user_email[0]->email
            ];

            Mail::to($user_email[0]->email)->send(new CancellationEmail($mailData));


            Entrance::where('payment_id', $id)->update(
                ['status' => 'cancelled']
            );

            Notification::create(
                [
                    'receiver_id' => $entrance[0]->user_id,
                    'status' => 'unread',
                    'receiver' => 'user',
                    'content' => 'Your Entrance cancellation request has been approved by the administrator.'
                ]
            );


            Notification::create(
                [
                    'receiver_id' => Auth::user()->id,
                    'status' => 'unread',
                    'receiver' => 'admin',
                    'content' => 'Entrance cancellation has been approved'
                ]
            );
        }

        return response()->json(['status' => 200, 'msg' => 'ok']);
    }

    public function accept_payment($id)
    {
        # code...
        Payment::where('payment_id', $id)->update(
            [
                'payment_status' => 'paid'
            ]
        );


        $booking = Booking::where('payment_id', $id)->get();

        if (count($booking) > 0) {

            $payment_detail = PaymentDetail::where('payment_id', $id)->get();

            // $mailData = [
            //     'to' => $payment_detail[0]->email
            // ];

            // Mail::to($payment_detail[0]->email)->send(new CancellationEmail($mailData));

            Room::where('room_no', $booking[0]->room_no)->update(
                [
                    'status' => 'reserved'
                ]
            );
            Booking::where('payment_id', $id)->update(['status' => 'reserved']);

            Notification::create(
                [
                    'receiver_id' => $payment_detail[0]->user_id,
                    'receiver' => 'user',
                    'status' => 'unread',
                    'content' => 'Your Booking payment has been approved by the administrator.'
                ]
            );

            Notification::create(
                [
                    'receiver_id' => Auth::user()->id,
                    'receiver' => 'admin',
                    'status' => 'unread',
                    'content' => 'Booking payment has been approved'
                ]
            );
        } else {

            //entrance
            $entrance = Entrance::where('payment_id', $id)->get();

            $user_email = User::where('id', $entrance[0]->user_id)->get();
            // $mailData = [
            //     'to' => $user_email[0]->email
            // ];

            // Mail::to($user_email[0]->email)->send(new CancellationEmail($mailData));


            Entrance::where('payment_id', $id)->update(
                ['status' => 'paid']
            );

            Notification::create(
                [
                    'receiver_id' => $entrance[0]->user_id,
                    'status' => 'unread',
                    'receiver' => 'user',
                    'content' => 'Your Entrance cancellation request has been approved by the administrator.'
                ]
            );


            Notification::create(
                [
                    'receiver_id' => Auth::user()->id,
                    'status' => 'unread',
                    'receiver' => 'admin',
                    'content' => 'Entrance payment has been approved'
                ]
            );
        }
        return response()->json(['status' => 200, 'msg' => 'ok']);
    }
}
