<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function store()
  {
    $attributes = request()->validate([
      'email' => 'required',
      'password' => 'required'
    ]);

    if (Auth::attempt($attributes)) {
      session()->regenerate();
      if (Auth::user()->role == "Admin") {
        return redirect('/dashboard');
      }
      // else if (Auth::user()->role == "Peminjam") {
      //   return redirect('/peminjaman-barang');
      // }
    } else {
      return redirect()->back()->with('error', 'Username atau password anda salah!');
    }
  }

  public function destroy()
  {
    Auth::logout();

    return redirect('/');
  }
}
