<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'cliente',
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
