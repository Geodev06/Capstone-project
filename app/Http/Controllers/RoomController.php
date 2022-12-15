<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Price;
use App\Models\Room;
use App\Models\Roomimage;
use App\Models\Unread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use File;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function manageRoom()
    {
        # code...
        $userdata = Auth::user();
        $rooms = Room::all()->reverse()->values();
        $unread_msg = Unread::where('receiver_type', 'admin')->count();
        return view('admin.manage_room', compact('userdata', 'rooms', 'unread_msg'));
    }

    public function create()
    {
        # code...
        $userdata = Auth::user();
        $rooms = Room::all();
        $unread_msg = Unread::where('receiver_type', 'admin')->count();
        return view('admin.room_form', compact('userdata', 'rooms', 'unread_msg'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'room_no' => 'required|numeric|max:999|unique:rooms',
                'min' => 'required|numeric|max:999|min:0|not_in:0',
                'max' => 'required|numeric|min:' . $request->min . '|min:0|not_in:0'
            ],
            [
                'room_no.unique' => 'Room no. ' . $request->room_no . ' is already registered as a room no.'
            ]
        );
        Room::create([
            'room_no' => $request->room_no,
            'min' => $request->min,
            'max' => $request->max
        ]);

        return Redirect::route('rooms.manage')->with('success', 'Room has been created!');
    }

    public function info($id)
    {
        # code...
        if (Room::where('id', $id)->count() > 0) {

            $userdata = Auth::user();
            $rooms = Room::where('id', $id)->get();
            $unread_msg = Unread::where('receiver_type', 'admin')->count();
            return view('admin.room_info', compact('userdata', 'rooms', 'unread_msg'));
        }

        abort(404);
    }

    public function destroy($id)
    {
        # code...
        if (Room::where('id', $id)->count() > 0) {
            $room = Room::select('room_no')->where('id', $id)->get();
            $files = Roomimage::select('image')->where('room_no', $room[0]->room_no)->get();
            for ($i = 0; $i < count($files); $i++) {

                if (File::exists(public_path($files[$i]->image))) {
                    File::delete(public_path($files[$i]->image));
                }
            }
            Roomimage::where('room_no', $room[0]->room_no)->delete();
            Room::where('id', $id)->delete();
            return Redirect::route('rooms.manage')->with('success', 'Room has been deleted');
        }

        abort(404);
    }

    public function images($id)
    {

        if (Room::where('room_no', $id)->count() > 0) {
            $userdata = Auth::user();
            $rooms = Room::where('room_no', $id)->get();
            $images = Roomimage::where('room_no', $id)->get();
            $unread_msg = Unread::where('receiver_type', 'admin')->count();
            return view('admin.room_images', compact('userdata', 'rooms', 'images', 'unread_msg'));
        }

        abort(404);
    }

    public function upload(Request $request, $id)
    {
        # code...
        if (Room::where('room_no', $id)->count() > 0) {
            $request->validate([
                'image' => 'required|array|min:1|max:4',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $rooms_images = Roomimage::where('room_no', $id)->count();

            if ($rooms_images > 4) {
                return Redirect::route('rooms.images', $id)->with('error', 'Cant upload anymore.');
            }

            if (($rooms_images + count($request->image)) > 4) {
                return Redirect::route('rooms.images', $id)->with('error', 'the number of images you submit can exceed to images limit.');
            } else {
                if ($rooms_images <= 4) {
                    if ($request->hasFile('image')) {
                        foreach ($request->image as $image) {
                            $img_path = null;
                            $img_path = 'uploads/room_images/' . now()->timestamp . $image->getClientOriginalName();
                            $destination = public_path('/uploads/room_images');
                            $image->move($destination, $img_path);
                            Roomimage::create([
                                'room_no' => $id,
                                'image' => $img_path
                            ]);
                        }
                        return Redirect::route('rooms.images', $id)->with('success', 'Image has been uploaded successfully.');
                    }
                } else {
                    return Redirect::route('rooms.images', $id)->with('error', 'Cant add images anyore maximum of 4.');
                }
            }
        }

        abort(404);
    }

    public function deleteall($id)
    {
        # code...
        if (Roomimage::where('room_no', $id)->count() > 0) {

            $files = Roomimage::select('image')->where('room_no', $id)->get();


            for ($i = 0; $i < count($files); $i++) {

                if (File::exists(public_path($files[$i]->image))) {
                    File::delete(public_path($files[$i]->image));
                }
            }
            Roomimage::where('room_no', $id)->delete();
            return Redirect::route('rooms.images', $id)->with('success', 'All images has been deleted!.');
        }
        abort(404);
    }
    public function deleteimage($id)
    {
        # code...
        if (Roomimage::where('id', $id)->count() > 0) {
            $room = Roomimage::select('room_no')->where('id', $id)->get();

            $files = Roomimage::select('image')->where('id', $id)->get();
            if (File::exists(public_path($files[0]->image))) {
                File::delete(public_path($files[0]->image));
            }
            Roomimage::where('id', $id)->delete();
            return Redirect::route('rooms.images', $room[0]->room_no)->with('success', 'Image has been deleted!.');
        }
        abort(404);
    }

    public function storeprice(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'hour' => 'required|numeric|min:0|max:500',
                    'price' => 'required'
                ]
            );

            if (!$validator->passes()) {
                return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
            } else {


                Price::create([
                    'hour' => $request->hour,
                    'price' => $request->price
                ]);
                return response()->json(['status' => 200, 'msg' => 'Price plan has been created!']);
            }
        }
    }

    public function getprice()
    {
        $prices = Price::all();

        $data = [];
        for ($i = 0; $i < count($prices); $i++) {
            array_push(
                $data,
                [
                    $prices[$i]->id,
                    $prices[$i]->hour,
                    $prices[$i]->price,
                    $prices[$i]->created_at->format('Y-m-d'),
                ]
            );
        }

        return response()->json(['status' => 200, 'content' => $data]);
    }

    public function deleteprice($id)
    {
        if (Price::where('id', $id)->count() > 0) {
            Price::where('id', $id)->delete();
            return response()->json(['status' => 200, 'msg' => 'The registered price has been deleted!']);
        }
        return response()->json(['status' => 0, 'msg' => 'Error in deleting please try again.']);
    }
}
