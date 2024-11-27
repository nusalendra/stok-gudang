<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $data = Rak::all();

        return view('content.pages.admin.rak.index', compact('data'));
    }

    public function create()
    {
        return view('content.pages.admin.rak.create');
    }

    public function store(Request $request)
    {
        $rak = new Rak();
        $rak->jenis = $request->jenis;
        $rak->kapasitas = $request->kapasitas;
        $rak->save();

        return redirect('/rak');
    }

    public function edit($id)
    {
        $rak = Rak::find($id);

        return view('content.pages.admin.rak.edit', compact('rak'));
    }

    public function update($id, Request $request)
    {
        $rak = Rak::find($id);
        $rak->jenis = $request->jenis ?? $rak->jenis;
        $rak->kapasitas = $request->kapasitas ?? $rak->kapasitas;
        $rak->save();

        return redirect('/rak');
    }

    public function destroy($id)
    {
        $rak = Rak::find($id);
        $rak->delete();

        return redirect('/rak');
    }
}
