<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function SignInView()
    {
        return view('pages/auth/login');
    }

    public function SignInPost(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $validated['email'];
        $password = $validated['password'];

        $employeeAccount = DB::select('SELECT email, password FROM employee_accounts WHERE email = ?', [$email]);

        if (!empty($employeeAccount) && Hash::check($password, $employeeAccount[0]->password)) {
            $employee = DB::select('SELECT employee_id, email FROM employees WHERE email = ?', [$email]);

            Session::put('employee_id', $employee[0]->employee_id);
            Session::put('email', $employee[0]->email);

            return Redirect::route('product');
        } else {
            return redirect()->back()
                ->withErrors(['email' => 'Email dan password yang anda masukan salah.'])
                ->withInput();
        }
    }

    public function SignOut(Request $request)
    {
        $request->session()->flush();

        return Redirect::route('login');
    }
}
