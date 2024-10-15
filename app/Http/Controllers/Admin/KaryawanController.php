<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'Karyawan')->get();
        return view('content.pages.admin.karyawan.index', compact('data'));
    }

    public function create()
    {
        return view('content.pages.admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'Karyawan';
        $user->save();

        $karyawan = new Karyawan();
        $karyawan->user_id = $user->id;
        $karyawan->nama_lengkap = $request->nama_lengkap;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->umur = $request->umur;
        $karyawan->nomor_telepon = $request->nomor_telepon;
        $karyawan->save();

        return redirect('/karyawan');
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('content.pages.admin.karyawan.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->email = $request->email ?? $user->email;
        if ($request->password) {
            $user->passsword = $request->password;
        }
        $user->save();

        $karyawan = Karyawan::where('user_id', $id)->first();
        $karyawan->nama_lengkap = $request->nama_lengkap ?? $karyawan->nama_lengkap;
        $karyawan->jenis_kelamin = $request->jenis_kelamin ?? $karyawan->jenis_kelamin;
        $karyawan->umur = $request->umur ?? $karyawan->umur;
        $karyawan->nomor_telepon = $request->nomor_telepon ?? $karyawan->nomor_telepon;
        $karyawan->save();

        return redirect('/karyawan');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/karyawan');
    }
}
