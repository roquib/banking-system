<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    public function create()
    {
        $options = collect(User::TYPES)
            ->map(fn ($item) => ['id' => $item, 'name' => $item])->all();
        return view('users.create', compact('options'));
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($request->password);
            $user = User::create($request->validated());
            event(new Registered($user));

            return redirect()->route('users.create')->with('success', 'The User is successfully created.');
        } catch (Exception $e) {
            return redirect()->route('users.create')->with('error', $e->getMessage());
        }
    }
}
