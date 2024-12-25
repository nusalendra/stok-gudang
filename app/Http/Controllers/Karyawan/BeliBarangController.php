<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Pembelian;
use App\Models\PembelianPesanan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeliBarangController extends Controller
{
    public function index()
    {
        $data = Barang::with('rak')->get();

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
            $pembelian->status_pembelian = 'Sukses';
            $pembelian->metode_pembayaran = $request->metode_pembayaran;
            $pembelian->total_harga = 0;

            $pesananIds = [];
            $today = Carbon::now();

            foreach ($request->barang_id as $id => $barangId) {
                $qty = $request->qty[$id];
                $harga = $request->harga[$id];
                $pendapatan = $qty * $harga;
                $barang = Barang::find($barangId);

                $barang->stok -= $qty;
                $barang->save();
                $statusPenjualan = '';

                if ($today->greaterThanOrEqualTo($barang->tanggal_expired)) {
                    $statusPenjualan = 'Obral';
                } else {
                    $statusPenjualan = 'Normal';
                }

                $pesanan = Pesanan::create([
                    'barang_id' => $barangId,
                    'status_penjualan' => $statusPenjualan,
                    'qty' => $qty,
                    'harga' => $harga,
                    'pendapatan' => $pendapatan
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

    public function masukkanKeranjang(Request $request)
    {
        try {
            $user = Auth::user();
            $karyawan = Karyawan::where('user_id', $user->id)->first();
            $totalHarga = 0;

            $pembelian = new Pembelian();
            $pembelian->karyawan_id = $karyawan->id;
            $pembelian->nama_pembeli = $request->nama_pembeli;
            $pembelian->status_pembelian = 'Dalam Keranjang';
            $pembelian->metode_pembayaran = $request->metode_pembayaran;
            $pembelian->total_harga = 0;
            $pembelian->save();

            $pesananIds = [];

            foreach ($request->items as $item) {
                $barangId = $item['id'];
                $qty = $item['jumlah'];
                $harga = $item['harga'];

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
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function removeItemsKeranjang($id)
    {
        $pesanan = Pesanan::with('pembelian')->find($id);

        if ($pesanan) {
            $harga = $pesanan->harga;
            $pembelian = $pesanan->pembelian()->first();

            if ($pembelian) {
                $pembelian->total_harga -= $harga;
                $pembelian->save();
            }

            $pesanan->delete();
            return response()->json(['success' => true, 'message' => 'Barang berhasil dihapus.']);
        }

        return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan.']);
    }

    public function checkoutKeranjang($id)
    {
        $pembeli = Pembelian::find($id);

        return view('content.pages.karyawan.keranjang-pesanan.checkout-keranjang', compact('pembeli'));
    }

    public function updateCheckoutKeranjang(Request $request, $id)
    {
        foreach ($request->qty as $pesananId => $qty) {
            $pesanan = Pesanan::where('id', $pesananId)->first();
            $barangId = $pesanan->barang_id;

            $barang = Barang::find($barangId);
            if ($qty > $barang->stok) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok Barang {$barang->nama} tidak mencukupi. Stok tersedia : {$barang->stok}",
                ], 400);
            }
        }

        try {
            $totalHarga = 0;
            $today = Carbon::now();
            foreach ($request->qty as $pesananId => $qty) {
                $pesanan = Pesanan::where('id', $pesananId)->first();
                $barang = Barang::where('id', $pesanan->barang_id)->first();
                $statusPenjualan = '';
                $pendapatan = $qty * $pesanan->harga;

                if ($today->greaterThanOrEqualTo($barang->tanggal_expired)) {
                    $statusPenjualan = 'Obral';
                } else {
                    $statusPenjualan = 'Normal';
                }

                if ($pesanan) {
                    $pesanan->status_penjualan = $statusPenjualan;
                    $pesanan->qty = $qty;
                    $pesanan->pendapatan = $pendapatan;
                    $pesanan->save();

                    $totalHarga += $pesanan->harga * $qty;
                }

                $barang->stok -= $qty;
                $barang->save();
            }

            $pembelian = Pembelian::find($id);
            if ($pembelian) {
                $pembelian->total_harga = $totalHarga;
                $pembelian->status_pembelian = 'Sukses';
                $pembelian->metode_pembayaran = $request->metode_pembayaran;
                $pembelian->save();
            }

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
