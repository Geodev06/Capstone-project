<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Establishmentimage;
use Illuminate\Http\Request;

class Guestcontroller extends Controller
{
    public function showLogin()
    {
        return view('user.login');
    }
    public function get_establishtment_json(Request $request)
    {
        # code...
        $est = Establishment::where('establishment_name', 'like', '%' . $request->search . '%')
            ->orWhere('establishment_address', 'like', '%' . $request->search . '%')
            ->get();
        $item = view('layouts.establishment_item', compact('est'))->render();
        return response()->json(['status' => 200, 'data' => $item]);
    }

    public function get_est_details($id)
    {
        $establishment = Establishment::where('id', $id)->get();

        return response()->json(['status' => 200, 'data' => $establishment]);
    }

    public function get_est_images($id)
    {
        $images = Establishmentimage::where('establishment_id', $id)
            ->get();

        $item = view('layouts.establishment_images', compact('images'))->render();

        return response()->json(['status' => 200, 'image' => $item]);
    }
}
