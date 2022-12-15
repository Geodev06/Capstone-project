<?php

namespace App\Http\Controllers;

use App\Models\Entrance;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware(['auth', 'admin']);
    }

    public function open()
    {
        # code...
        $table_data = DB::select('select count(payment_id) as payment_count, round(sum(amount),2) as total, date_format(created_at, "%M %d %Y") as date from payments where payment_status = "paid" group by date');

        $data = [
            'payments' => Payment::where('payment_status', 'paid')->count(),
            'visitors' => Entrance::sum('no_of_person'),
            'revenue' => Payment::where('payment_status', 'paid')->sum('amount'),
            'transactions' => Payment::count(),
            'user' => User::where('role', 0)->count()
        ];
        return view('admin.report', compact('table_data', 'data'));
    }
}
