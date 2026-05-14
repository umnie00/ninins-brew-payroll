<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name'             => ['required', 'string', 'max:100'],
            'last_name'              => ['required', 'string', 'max:100'],
            'email'                  => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone'                  => ['required', 'string', 'max:20'],
            'address'                => ['required', 'string', 'max:255'],
            'date_of_birth'          => ['required', 'date'],
            'gender'                 => ['required', 'in:Male,Female'],
            'emergency_name'         => ['required', 'string', 'max:100'],
            'emergency_relationship' => ['required', 'string', 'max:50'],
            'emergency_phone'        => ['required', 'string', 'max:20'],
            'job_title'              => ['required', 'string', 'max:100'],
            'department'             => ['required', 'string', 'max:100'],
            'password'               => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'employee',
        ]);

        \App\Models\Employee::create([
            'user_id'                => $user->id,
            'first_name'             => $request->first_name,
            'last_name'              => $request->last_name,
            'email'                  => $request->email,
            'phone'                  => $request->phone,
            'address'                => $request->address,
            'date_of_birth'          => $request->date_of_birth,
            'gender'                 => $request->gender,
            'emergency_name'         => $request->emergency_name,
            'emergency_relationship' => $request->emergency_relationship,
            'emergency_phone'        => $request->emergency_phone,
            'job_title'              => $request->job_title,
            'department'             => $request->department,
            'hourly_rate'            => 0,
            'status'                 => 'active',
            'hired_date'             => now()->toDateString(),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard'));
    }
}