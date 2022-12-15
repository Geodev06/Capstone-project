<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\EntranceController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\Guestcontroller;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Report;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Usercontroller;
use App\Models\Content;
use App\Models\Establishment;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

use function Clue\StreamFilter\fun;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(
    ['verify' => true]
);

Route::get('/', function () {

    $isLoggedin = Auth::check();
    $userdata = Auth::user();
    $admin = User::where('role', 1)->get();
    $contents = Content::select('*')->where('type', 'Feature')->get();
    $abouts = Content::select('*')->where('type', 'About')->get();
    $todos = Content::select('*')->where('type', 'Todo')->get();
    $establishment = Establishment::all();

    $rating_count = Rating::count();
    if ($isLoggedin) {

        if ($userdata->role == 1) {

            return Redirect::route('admin.dashboard');
        }
        if ($userdata->role == 0) {

            return Redirect::route('user.dashboard');
        }
    } else {
        return view('layouts.app', compact('isLoggedin', 'userdata', 'contents', 'abouts', 'todos', 'establishment', 'admin', 'rating_count'));
    }
})->name('index');

Route::get('user/ratings/app-layout', function () {
    $feedback_data = [];

    $feedback = Rating::latest()->take(5)->get();

    foreach ($feedback as $fb) {

        $name = User::where('id', $fb->user_id)->get();

        array_push(
            $feedback_data,
            [
                'user_name' => $name[0]->name,
                'comment' => $fb->comment,
                'rating' => $fb->feedback
            ]
        );
    }

    $content = view('layouts.ratings', compact('feedback_data'))->render();
    return response()->json(['status' => 200, 'content' => $content]);
})->name('layout.ratings');


Route::get('tanaw-admin/login', [AdminLoginController::class, 'admin_login'])->name('admin.login');
Route::post('tanaw-admin/auth', [AdminLoginController::class, 'admin_authenticate'])->name('admin.authenticate');



Route::post('get/establishment-item', [Guestcontroller::class, 'get_establishtment_json'])->name('establishment.guest');
Route::get('get/establishment-item/json/{id}', [Guestcontroller::class, 'get_est_details'])->name('establishment.get.json');
Route::get('get/establishment-item/json/image/{id}', [Guestcontroller::class, 'get_est_images'])->name('establishment.get.json.images');



// admin routes
Route::get('u/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('u/admin/manage-content', [AdminController::class, 'managecontent'])->name('admin.manage_content');
Route::get('u/admin/manage-content/getcontent', [AdminController::class, 'getcontent_json'])->name('content.get_json');

Route::get('u/admin/manage-content/delete/{id}', [AdminController::class, 'contentDestroy'])->name('content.destroy');
Route::post('u/admin/manage-content/update/{id}', [AdminController::class, 'contentUpdate'])->name('content.update');
Route::post('u/admin/manage-content/store', [AdminController::class, 'contentStore'])->name('content.store');

Route::get('u/admin/manage-users', [AdminController::class, 'manageUsers'])->name('manage.users');
Route::get('u/admin/setting', [AdminController::class, 'setting'])->name('admin.setting');
Route::get('u/admin/manage-users/list', [AdminController::class, 'getusers_json'])->name('users.get_json');
//admin message
Route::get('u/admin/user-message/', [AdminController::class, 'message'])->name('admin.message');
Route::get('u/admin/user-message/get/{id}', [AdminController::class, 'get_message'])->name('admin.messages.get');
Route::post('u/admin/reply/send/{msg_id}', [AdminController::class, 'send_message'])->name('admin.message.store');

//establishements
Route::get('u/admin/manage-establishments', [EstablishmentController::class, 'manageEstablishments'])->name('admin.manage_establishments');
Route::get('u/admin/manage-establishments/create', [EstablishmentController::class, 'createEstablishment'])->name('admin.create_establishment');
Route::post('u/admin/manage-establishments/store', [EstablishmentController::class, 'storeEstablishment'])->name('establishment.store');
Route::get('u/admin/manage-establishments/destroy/{id}', [EstablishmentController::class, 'destroyEstablishment'])->name('establishment.destroy');
Route::get('u/admin/manage-establishments/edit/{id}', [EstablishmentController::class, 'editEstablishment'])->name('establishment.edit');
Route::post('u/admin/manage-establishments/update/{id}', [EstablishmentController::class, 'updateEstablishment'])->name('establishment.update');

//image-upload routes
Route::get('u/admin/manage-establishments/upload-image/{est_id}', [EstablishmentController::class, 'uploadimage'])->name('establishment.upload_image');
Route::post('u/admin/manage-establishments/store-image/{est_id}', [EstablishmentController::class, 'storeimages'])->name('establishment.store_image');
Route::get('u/admin/manage-establishments/delete-image-batch/{est_id}', [EstablishmentController::class, 'delete_image_batch'])->name('establishment.delete_images');
Route::get('u/admin/manage-establishments/delete-image/{img_id}', [EstablishmentController::class, 'delete_image'])->name('establishment.delete_image');
Route::get('u/admin/payments', [AdminController::class, 'payments'])->name('user_payments');
Route::get('u/admin/payments/getjson', [AdminController::class, 'payments_get_json'])->name('payments.get_json');
Route::get('u/admin/user-bookings/getjson/{room_no}', [AdminController::class, 'booking_get_json'])->name('booking.get_json');
Route::get('u/admin/user-bookings/end/{bookingid}', [AdminController::class, 'end_user_booking'])->name('booking.end');
Route::get('u/admin/room-mark/{booking_id}', [AdminController::class, 'mark_room'])->name('room.mark');

Route::get('u/admin/notifications', [AdminController::class, 'notification'])->name('notification');
Route::post('u/admin/notifications/update/{id}', [AdminController::class, 'notification_update'])->name('notification.update');
Route::post('u/admin/notifications/delete/{id}', [AdminController::class, 'notification_delete'])->name('notification.delete');

Route::post('u/admin/faq', [AdminController::class, 'faq_store'])->name('faq.store');
Route::get('u/admin/faq/get', [AdminController::class, 'faq_get'])->name('saves.faq.get');
Route::get('u/admin/faq/destroy/{id}', [AdminController::class, 'faq_destroy'])->name('faq.destroy');
//refund
Route::get('user/refund/request/{id}', [Usercontroller::class, 'refund_request'])->name('request.refund');
Route::get('user/booking-cancel/request/{id}', [Usercontroller::class, 'cancel_booking'])->name('booking.cancel');
Route::get('admin/booking-cancel/approve/{id}', [AdminController::class, 'approve_cancel_request'])->name('booking.cancel.approve');
Route::get('admin/payment/approve/{id}', [AdminController::class, 'accept_payment'])->name('payment.accept');

// Route::get('admin/entrance-cancel/approve/{id}', [AdminController::class, 'approve_cancel_request_entrance'])->name('entrance.cancel.approve');

//charts
Route::get('u/admin/revenue/overview/{category}', [AdminController::class, 'revenue_overview'])->name('overview.get');
Route::get('u/admin/visitor/overview/{category}', [AdminController::class, 'visitor_overview'])->name('overview.visitor');
Route::get('u/admin/entrance-payment/overview/{category}', [AdminController::class, 'entrance_payment_overview'])->name('overview.entrance');
Route::get('u/admin/rating', [AdminController::class, 'getRating'])->name('ratings.get');
//room managements routes
Route::get('u/admin/manage-rooms', [RoomController::class, 'manageRoom'])->name('rooms.manage');
Route::get('u/admin/manage-rooms/room-info/{id}', [RoomController::class, 'info'])->name('rooms.info');
Route::get('u/admin/manage-rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::get('u/admin/manage-rooms/destroy/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');
Route::post('u/admin/manage-rooms/store', [RoomController::class, 'store'])->name('rooms.store');
Route::get('u/admin/manage-rooms/room-images/{id}', [RoomController::class, 'images'])->name('rooms.images');
Route::post('u/admin/manage-rooms/room-images/upload/{id}', [RoomController::class, 'upload'])->name('room_images.upload');
Route::get('u/admin/manage-rooms/room-images/delete-all/{id}', [RoomController::class, 'deleteall'])->name('rooms.delete_all');
Route::get('u/admin/manage-rooms/room-images/delete-image/{id}', [RoomController::class, 'deleteimage'])->name('rooms.image_delete');
Route::post('u/admin/manage-rooms/price/save', [RoomController::class, 'storeprice'])->name('price.store');
Route::get('u/admin/manage-rooms/prices/get', [RoomController::class, 'getprice'])->name('prices.get');
Route::get('u/admin/manage-rooms/prices/delete/{id}', [RoomController::class, 'deleteprice'])->name('price.destroy');


//user routes
Route::get('user/dashboard', [Usercontroller::class, 'index'])->name('user.dashboard');
Route::get('user/setting', [Usercontroller::class, 'setting'])->name('user.setting');
Route::get('user/tanaw-map', [Usercontroller::class, 'tanaw_map'])->name('tanaw.map');
Route::post('user/update', [Usercontroller::class, 'updateinfo'])->name('user.update_info');
Route::post('user/update/password', [Usercontroller::class, 'updatepassword'])->name('user.update_pass');
Route::post('user/delete/{id}', [Usercontroller::class, 'userdelete'])->name('user.delete');
Route::get('user/view-room/{id}', [Usercontroller::class, 'showRoomDetail'])->name('user.roominfo');
Route::get('user/check-in-form/{room_id}', [Usercontroller::class, 'checkInForm'])->name('user.checkinform');
Route::get('user/bookings', [Usercontroller::class, 'booking'])->name('user.bookings');
Route::get('user/entrance', [Usercontroller::class, 'entrance'])->name('user.entrance');
Route::get('user/bookings/get', [Usercontroller::class, 'userBooking'])->name('user.booking.get');
Route::get('user/bookings/get/detail/{pay_id}', [Usercontroller::class, 'userBooking_detail'])->name('user.booking_detail.get');
Route::get('user/nearby', [Usercontroller::class, 'nearby'])->name('user.nearby');
Route::get('user/my-payments', [Usercontroller::class, 'payments'])->name('user.payments');
Route::get('user/my-payments/{userid}', [Usercontroller::class, 'myPayments_get_json'])->name('user.payments.json');
Route::get('u/admin/est/getjson', [Usercontroller::class, 'get_establishment_json'])->name('get_est');
Route::post('user/getnearby', [Usercontroller::class, 'get_nearby'])->name('getnearby');
Route::get('get/faqs', [Usercontroller::class, 'get_faqs'])->name('getfaqs');
Route::get('user/chatbot', [Usercontroller::class, 'get_context'])->name('chatbot.getcontext');

Route::get('user/notifications', [Usercontroller::class, 'notification'])->name('user.notification');
Route::post('user/notifications/update/{id}', [Usercontroller::class, 'notification_update'])->name('user.notification.update');
Route::post('user/notifications/delete/{id}', [Usercontroller::class, 'notification_delete'])->name('user.notification.delete');




//message route
Route::get('user/messages', [Usercontroller::class, 'messages'])->name('user.messages');
Route::post('message/send', [Usercontroller::class, 'send_message'])->name('user.message.store');
Route::get('user/message/get', [Usercontroller::class, 'get_message'])->name('user.messages.get');

//booking payment routes
Route::post('user/check-in/pay', [PaymentController::class, 'pay'])->name('payment');
Route::get('success/{userid}/{tdate}/{plan}/{room_no}/{hour}', [PaymentController::class, 'success']);
Route::get('user/check-in/receipt/{payment_id}', [PaymentController::class, 'check_in_receipt'])->name('check_in.receipt');
Route::get('error', [PaymentController::class, 'error']);

//entrance
Route::post('user/entrance/pay', [EntranceController::class, 'pay'])->name('user.entrance.pay');
Route::get('user/entrance/get', [EntranceController::class, 'getdata'])->name('user.entrance.get');
Route::get('user/entrance/{payment_id}', [EntranceController::class, 'entrancedetails'])->name('user.entrance.getdetails');
Route::get('success/{date}/{no_of_person}', [EntranceController::class, 'success']);
Route::get('user/entrance-in/receipt/{payment_id}', [EntranceController::class, 'receipt'])->name('entrance.receipt');
Route::get('error', [EntranceController::class, 'error']);
//gcash
Route::post('user/entrance/gcash-pay', [Usercontroller::class, 'gcash_pay'])->name('pay.gcash');

//rating
Route::post('user/rating/store', [Usercontroller::class, 'rating_store'])->name('rating.store');

//print
Route::get('tanaw-report/print', [Report::class, 'open'])->name('report.print');
