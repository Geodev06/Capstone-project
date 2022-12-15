<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Establishmentimage;
use App\Models\Message;
use App\Models\Unread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use File;

class EstablishmentController extends Controller
{
    public function __contruct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function manageEstablishments()
    {
        $userdata = Auth::user();
        $unread_msg = Unread::where('receiver_type', 'admin')->count();
        $establishments = Establishment::all()->reverse()->values();
        return view('admin.manage_establishments', compact('userdata', 'establishments', 'unread_msg'));
    }

    public function createEstablishment()
    {
        # code...
        $userdata = Auth::user();
        $establishments = Establishment::all()->reverse()->values();
        $unread_msg = Unread::where('receiver_type', 'admin')->count();
        return view('admin.create_establishment', compact('userdata', 'establishments', 'unread_msg'));
    }

    public function storeEstablishment(Request $request)
    {
        # code...
        $request->validate([
            'establishment_name' => 'required',
            'establishment_address' => 'required',
            'schedule' => 'required',
            'contact' => 'required|min:11|max:11',
            'email' => 'required',
            'open' => 'required',
            'close' => 'required'
        ]);

        $data = [
            'establishment_name' => $request->establishment_name,
            'establishment_address' => $request->establishment_address,
            'schedule' => $request->schedule,
            'contact' => $request->contact,
            'email' => $request->email,
            'open' => $request->open,
            'close' => $request->close,
            'lat' => $request->lat,
            'long' => $request->lon,
        ];

        Establishment::create($data);

        return Redirect::route('admin.manage_establishments')->with('success', 'Establishment has been added!.');
    }

    public function destroyEstablishment($id)
    {
        if (count(Establishment::where('id', $id)->get())) {

            Establishment::where('id', $id)->delete();
            return Redirect::route('admin.manage_establishments')->with('success', 'Establishment has been remove.');
        } else {
            return abort(404);
        }
    }

    public function editEstablishment($id)
    {

        if (Auth::check()) {
            $userdata = Auth::user();
            $establishments = Establishment::where('id', $id)->get();
            $unread_msg = Unread::where('receiver_type', 'admin')->count();
            if (count($establishments)) {
                return view('admin.edit_establishment', compact('userdata', 'establishments', 'unread_msg'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/login');
        }
    }

    public function updateEstablishment(Request $request, $id)
    {
        if (count(Establishment::where('id', $id)->get()) <= 0) {
            return abort(404);
        }
        # code...
        $request->validate([
            'establishment_name' => 'required',
            'establishment_address' => 'required',
            'schedule' => 'required',
            'contact' => 'required|min:11|max:11',
            'email' => 'required',
            'open' => 'required',
            'close' => 'required'
        ]);

        $data = [
            'establishment_name' => $request->establishment_name,
            'establishment_address' => $request->establishment_address,
            'schedule' => $request->schedule,
            'contact' => $request->contact,
            'email' => $request->email,
            'open' => $request->open,
            'close' => $request->close,
            'lat' => $request->lat,
            'long' => $request->lon,
        ];

        Establishment::where('id', $id)->update($data);

        return Redirect::route('admin.manage_establishments')->with('success', 'Establishment has been updated!.');
    }

    public function storeimages(Request $request, $id)
    {
        $request->validate([
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        # code...

        if ($request->hasFile('image')) {
            foreach ($request->image as $image) {
                $img_path = null;
                $img_path = 'uploads/establishment_images/' . now()->timestamp . $image->getClientOriginalName();
                $destination = public_path('/uploads/establishment_images');
                $image->move($destination, $img_path);
                Establishmentimage::create([
                    'establishment_id' => $id,
                    'image' => $img_path
                ]);
            }
            return Redirect::route('establishment.upload_image', $id)->with('success', 'Image has been uploaded successfully.');
        }
    }
    public function delete_image_batch($id)
    {
        if (Establishment::where('id', $id)->count() > 0) {

            $files = Establishmentimage::select('image')->where('establishment_id', $id)->get();


            for ($i = 0; $i < count($files); $i++) {

                if (File::exists(public_path($files[$i]->image))) {
                    File::delete(public_path($files[$i]->image));
                }
            }
            // Establishmentimage::select('image')->where('id', $id)->delete();
            Establishmentimage::where('establishment_id', $id)->delete();
            return Redirect::route('establishment.upload_image', $id)->with('success', 'All images has been deleted successfully.');
        }
        return abort(404);
    }

    public function delete_image($img_id)
    {
        if (Establishmentimage::where('id', $img_id)->count() > 0) {
            $est_image = Establishmentimage::select('establishment_id', 'image')->where('id', $img_id)->first();

            if (File::exists(public_path($est_image->image))) {
                File::delete(public_path($est_image->image));
            }

            Establishmentimage::where('id', $img_id)->delete();

            return Redirect::route('establishment.upload_image', $est_image->establishment_id)->with('success', 'An image has been deleted successfully.');
        }
        return abort(404);
    }

    public function uploadimage($id)
    {
        # code...
        if (Establishment::where('id', $id)->count() > 0) {
            $establishments = Establishment::where('id', $id)->get();
            $userdata = Auth::user();
            $images = Establishmentimage::where('establishment_id', $id)->get();
            $unread_msg = Unread::where('receiver_type', 'admin')->count();
            return view('admin.establishment_upload_image', compact('establishments', 'userdata', 'images', 'unread_msg'));
        }
        return abort(404);
    }
}
