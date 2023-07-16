<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawalStoreRequest;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->where('transaction_type', 'withdrawal')->get();
        return view('withdrawals.index', compact('transactions'));
    }

    public function create()
    {
        $options = User::all();
        return view('withdrawals.create', compact('options'));
    }

    public function store(WithdrawalStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::find($request->user_id);
            $withdrawRate = $user->account_type == User::TYPES[0] ? 0.015 : 0.025;
            $currentMonthWithdrawal = Transaction::with('user')
                ->where('user_id', $request->user_id)
                ->whereMonth('date', now()->month)
                ->where('transaction_type', 'withdrawal')
                ->sum('amount');
            $fee = 0;
            if ($user->balance != 0) {
                if ($user->account_type == User::TYPES[0]) {
                    if ($request->amount > 1000 || $currentMonthWithdrawal > 5000) {
                        if ($request->amount > 1000) {
                            $withdrawalableWithRate = $request->amount - 1000;
                            $fee = $withdrawalableWithRate * $withdrawRate;
                            if (($request->amount + $fee) > $user->balance) {
                                return redirect()->route('withdrawal.create')->with('error', "Couldn't withdraw,balance is low");
                            }
                            $user->balance = ($user->balance - $request->amount - $fee);
                        }
                    }
                    if (now()->format('l') != 'Friday') {
                        $user->balance = $user->balance - $request->amount;
                    }
                }
                if ($user->account_type == User::TYPES[1]) {
                    $totalWithdrawalAmount = Transaction::with('user')
                        ->where('user_id', $request->user_id)
                        ->where('transaction_type', 'withdrawal')
                        ->sum('amount');
                    if ($totalWithdrawalAmount > 50000) {
                        $fee = $request->amount * 0.015;
                        if (($request->amount + $fee) > $user->balance) {
                            return redirect()->route('withdrawal.create')->with('error', "Couldn't withdraw,balance is low");
                        }
                        $user->balance = $user->balance - $request->amount * 0.015;
                    } else {
                        $fee = $request->amount * $withdrawRate;
                        if (($request->amount + $fee) > $user->balance) {
                            return redirect()->route('withdrawal.create')->with('error', "Couldn't withdraw,balance is low");
                        }
                        $user->balance = $user->balance - ($request->amount * $withdrawRate);
                    }
                }
            }
            $user->save();
            Transaction::create(array_merge($data, ['transaction_type' => 'withdrawal', 'date' => now(), 'fee' => $fee]));

            return redirect()->route('withdrawal.create')->with('success', 'The withdrawal is successfully created.');
        } catch (Exception $e) {
            return redirect()->route('withdrawal.create')->with('error', $e->getMessage());
        }
    }
}
