<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Rak;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
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
        $rak->nama = $request->nama;
        $rak->lokasi = $request->lokasi;
        $rak->jumlah_barang = $request->jumlah_barang;
        $rak->save();

        return redirect('/rak');
    }

    public function show($id)
    {
        $data = Rak::find($id);
        $barang = Barang::where('rak_id', $id)->get();
        $barangBelumDiRak = Barang::where('rak_id', null)->get();
        $barangBelumDiRak = $barangBelumDiRak->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama . ' (Ukuran ' . $item->ukuran . ', Warna ' . $item->warna . ')',
            ];
        });

        return view('content.pages.admin.rak.show-barang', compact('data', 'barang', 'barangBelumDiRak'));
    }

    public function edit($id)
    {
        $rak = Rak::find($id);

        return view('content.pages.admin.rak.edit', compact('rak'));
    }

    public function update($id, Request $request)
    {
        $rak = Rak::find($id);
        $rak->nama = $request->nama ?? $rak->nama;
        $rak->lokasi = $request->lokasi ?? $rak->lokasi;
        $rak->jumlah_barang = $request->jumlah_barang ?? $rak->jumlah_barang;
        $rak->save();

        return redirect('/rak');
    }

    public function destroy($id)
    {
        $rak = Rak::find($id);
        $rak->delete();

        return redirect('/rak');
    }

    public function kirimBarang(Request $request, $id)
    {
        $barangIds = $request->input('barangIds');

        foreach ($barangIds as $barangId) {
            $barang = Barang::find($barangId);
            $barang->rak_id = $id;
            $barang->save();
        }

        return response()->json(['message' => 'Barang berhasil dikirim'], 200);
    }

    public function hapusBarang($id, $barangId)
    {
        $barang = Barang::find($barangId);
        $barang->rak_id = null;
        $barang->save();

        return redirect('/rak' . '/' . $id);
    }

    public function cetakPDF($id)
    {
        $rak = Rak::find($id);
        $barang = Barang::where('rak_id', '=', $id)->get();
        $pdf = FacadePdf::loadView('content.pages.admin.rak.cetak-pdf', ['title' => 'Barang'], compact('rak', 'barang'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('cetak.pdf');
    }
}
