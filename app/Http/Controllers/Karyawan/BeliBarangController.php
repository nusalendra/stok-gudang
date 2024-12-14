<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Pembelian;
use App\Models\PembelianPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeliBarangController extends Controller
{
    public function index()
    {
        $data = Barang::with('barangKeluar')->get();
        return view('content.pages.karyawan.beli-barang.index', compact('data'));
    }

    public function checkoutItems(Request $request)
    {
        $ids = $request->ids;

        $barangCheckout = [];
        foreach ($ids as $id) {
            $barang = Barang::find($id);
            $barangCheckout[] = $barang;
        }

        session(['checkoutItems' => $barangCheckout]);

        return response()->json(['message' => 'Berhasil diproses']);
    }

    public function checkout()
    {
        $items = session('checkoutItems', []);

        return view('content.pages.karyawan.beli-barang.checkout', compact('items'));
    }

    public function removeItems($key)
    {
        $items = session('checkoutItems', []);

        if (isset($items[$key])) {
            unset($items[$key]);

            session(['checkoutItems' => $items]);
        }

        return redirect('/beli-barang/checkout');
    }

    public function checkoutStore(Request $request)
    {
        foreach ($request->barang_id as $id => $barangId) {
            $qty = $request->qty[$id];

            $barang = Barang::find($barangId);
            if ($qty > $barang->stok) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok Barang {$barang->nama} tidak mencukupi. Stok tersedia : {$barang->stok}",
                ], 400);
            }
        }

        try {
            $user = Auth::user();
            $karyawan = Karyawan::where('user_id', $user->id)->first();
            $totalHarga = 0;

            $pembelian = new Pembelian();
            $pembelian->karyawan_id = $karyawan->id;
            $pembelian->nama_pembeli = $request->nama_pembeli;
            $pembelian->metode_pembayaran = $request->metode_pembayaran;
            $pembelian->total_harga = 0;
            $pembelian->save();

            $pesananIds = [];

            foreach ($request->barang_id as $id => $barangId) {
                $qty = $request->qty[$id];
                $harga = $request->harga[$id];
                $barang = Barang::find($barangId);

                $barang->stok -= $qty;
                $barang->save();

                $pesanan = Pesanan::create([
                    'barang_id' => $barangId,
                    'qty' => $qty,
                    'harga' => $harga,
                ]);

                $pesananIds[] = $pesanan->id;
                $totalHarga += $harga * $qty;
            }

            $pembelian->total_harga = $totalHarga;
            $pembelian->save();
            $pembelian->pesanan()->attach($pesananIds);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diproses.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses transaksi. Silakan coba lagi.',
            ], 500);
        }
    }
}
