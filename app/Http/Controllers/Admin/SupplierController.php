<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $data = Supplier::all();
        return view('content.pages.admin.supplier.index', compact('data'));
    }

    public function create()
    {
        return view('content.pages.admin.supplier.create');
    }

    public function store(Request $request)
    {
        $supplier = new Supplier();
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;
        $supplier->nomor_telepon = $request->nomor_telepon;
        $supplier->save();

        return redirect('/supplier');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);

        return view('content.pages.admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->nama = $request->nama ?? $supplier->nama;
        $supplier->alamat = $request->alamat ?? $supplier->alamat;
        $supplier->nomor_telepon = $request->nomor_telepon ?? $supplier->nomor_telepon;
        $supplier->save();


        return redirect('/supplier');
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return redirect('/supplier');
    }
}
