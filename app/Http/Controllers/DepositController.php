<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositStoreRequest;
use App\Http\Requests\WithdrawalStoreRequest;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->where('transaction_type', 'deposit')->get();
        return view('deposits.index', compact('transactions'));
    }

    public function create()
    {
        $options = User::all();
        return view('deposits.create', compact('options'));
    }

    public function store(DepositStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $user = Auth::user();
            $user->balance = $user->balance + $request->amount;
            $user->save();
            Transaction::create(array_merge($data, ['transaction_type' => 'deposit','date' => now()]));

            return redirect()->route('deposit.create')->with('success', 'The deposit is successfully created.');
        } catch (Exception $e) {
            return redirect()->route('deposit.create')->with('error', $e->getMessage());
        }
    }
}
