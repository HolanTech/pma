<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view("customer.index", compact("customers"));
    }
    public function create()
    {
        return view("customer.create");
    }
    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->no_hp = $request->no_hp;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->paket = $request->paket;
        $customer->date = $request->date;
        $customer->longitude = $request->longitude;
        $customer->latitude = $request->latitude;
        $customer->status = '1';

        $customer->save(); // Simpan dulu untuk mendapatkan ID

        // Menghasilkan no_pelanggan berdasarkan ID yang baru saja dibuat
        $customer->no_pelanggan = 'OKE' . str_pad($customer->id, 7, '0', STR_PAD_LEFT);
        $customer->save(); // Simpan lagi untuk memperbarui no_pelanggan

        return redirect()->route('customer.index')->with('success', 'Pelanggan baru berhasil ditambahkan dengan Id Pelanggan ' . $customer->no_pelanggan);
    }
    public function changeStatus(Request $request, $id)
    {
        $customer = Customer::findOrFail($id); // Cari pelanggan berdasarkan ID, jika tidak ada, akan mengembalikan 404
        $newStatus = $request->status; // Ambil status baru dari request

        // Update status pelanggan
        $customer->status = $newStatus;
        $customer->save(); // Simpan perubahan

        // Kembali dengan response JSON
        return response()->json([
            'message' => 'Status updated successfully!',
            'newStatus' => $newStatus,
        ]);
    }
    public function showMap()
    {
        $customers = Customer::all(); // Ambil semua data customer
        // dd($customers);
        return view('customer.map', compact('customers')); // Ganti 'customers.map' dengan path view Anda
    }
}
