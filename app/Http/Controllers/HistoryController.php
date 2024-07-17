<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = Transaction::all()->where('user_id', Auth::user()->id);

        return view('transaction.history.index', compact('histories'));
    }

    public function update($code)
    {
        $history = Transaction::where('code', $code)->first();

        $token_code = '';

        for ($i = 0; $i < 20; $i++) {
            $token_code .= random_int(0, 9);
        }

        $history->update([
            'status' => 'Paid',
            'date_paid' => Carbon::now(),
            'token_code' => $token_code
        ]);
    }

    public function index_admin()
    {
        $histories = Transaction::all();

        return view('transaction.history.index_admin', compact('histories'));
    }
}
