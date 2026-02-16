<?php

namespace App\Http\Controllers\Customer;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        return redirect()->route('customer.profile.index');
    }

    public function create()
    {
        $edit = false;
        return view('customer.address.form', [
            'title' => 'Tambah Alamat',
            'edit' => $edit,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'             => 'required|string|max:50',
            'receiver_name'     => 'required|string|max:100',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string',
            'province_id'       => 'required',
            'regency_id'        => 'required',
            'district_id'       => 'required',
            'sub_district_id'   => 'required',
            'province_name'     => 'required|string',
            'regency_name'      => 'required|string',
            'district_name'     => 'required|string',
            'sub_district_name' => 'required|string',
            'postal_code'       => 'required|string|max:10',
            'latitude'          => 'required',
            'longitude'         => 'required',
            'is_default'        => 'nullable',
        ], [
            'label.required'             => 'Label alamat harus diisi (misal Rumah / Kantor).',
            'label.max'                  => 'Label alamat maksimal 50 karakter.',
            'receiver_name.required'     => 'Nama penerima wajib diisi.',
            'receiver_name.max'          => 'Nama penerima maksimal 100 karakter.',
            'phone.required'             => 'Nomor WhatsApp wajib diisi.',
            'phone.max'                  => 'Nomor WhatsApp maksimal 20 karakter.',
            'address.required'           => 'Alamat lengkap wajib diisi.',
            'province_name.required'     => 'Provinsi harus dipilih.',
            'regency_name.required'      => 'Kabupaten / Kota harus dipilih.',
            'district_name.required'     => 'Kecamatan harus dipilih.',
            'sub_district_name.required' => 'Kelurahan / Desa harus dipilih.',
            'postal_code.required'       => 'Kode pos wajib diisi.',
            'postal_code.max'            => 'Kode pos maksimal 10 karakter.',
            'latitude.required'          => 'Latitude harus ditentukan dengan memilih titik pada peta.',
            'longitude.required'         => 'Longitude harus ditentukan dengan memilih titik pada peta.',
        ]);
        // dd($data);

        $user = Auth::user();
        if ($request->boolean('is_default')) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create([
            'label'             => $data['label'],
            'receiver_name'     => $data['receiver_name'],
            'phone'             => $data['phone'],
            'address'           => $data['address'],
            'province_id'       => $data['province_id'],
            'regency_id'        => $data['regency_id'],
            'district_id'       => $data['district_id'],
            'sub_district_id'   => $data['sub_district_id'],
            'province_name'     => $data['province_name'],
            'regency_name'      => $data['regency_name'],
            'district_name'     => $data['district_name'],
            'sub_district_name' => $data['sub_district_name'],
            'postal_code'       => $data['postal_code'],
            'latitude'          => $data['latitude'],
            'longitude'         => $data['longitude'],
            'is_default'        => $request->boolean('is_default'),
        ]);

        return redirect()->route('customer.profile.index')->with('success', 'Alamat Anda berhasil ditambahkan');
    }

    public function edit(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);
        $edit = true;

        return view('customer.address.form', [
            'title' => 'Edit Alamat',
            'address' => $address,
            'edit' => $edit,
        ]);
    }

    public function update(Request $request, Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);
        $data = $request->validate([
            'label'             => 'required|string|max:50',
            'receiver_name'     => 'required|string|max:100',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string',
            'province_id'       => 'required',
            'regency_id'        => 'required',
            'district_id'       => 'required',
            'sub_district_id'   => 'required',
            'province_name'     => 'required|string',
            'regency_name'      => 'required|string',
            'district_name'     => 'required|string',
            'sub_district_name' => 'required|string',
            'postal_code'       => 'required|string|max:10',
            'latitude'          => 'required',
            'longitude'         => 'required',
            'is_default'        => 'nullable',
        ], [
            'label.required'             => 'Label alamat harus diisi (misal Rumah / Kantor).',
            'label.max'                  => 'Label alamat maksimal 50 karakter.',
            'receiver_name.required'     => 'Nama penerima wajib diisi.',
            'receiver_name.max'          => 'Nama penerima maksimal 100 karakter.',
            'phone.required'             => 'Nomor WhatsApp wajib diisi.',
            'phone.max'                  => 'Nomor WhatsApp maksimal 20 karakter.',
            'address.required'           => 'Alamat lengkap wajib diisi.',
            'province_name.required'     => 'Provinsi harus dipilih.',
            'regency_name.required'      => 'Kabupaten / Kota harus dipilih.',
            'district_name.required'     => 'Kecamatan harus dipilih.',
            'sub_district_name.required' => 'Kelurahan / Desa harus dipilih.',
            'postal_code.required'       => 'Kode pos wajib diisi.',
            'postal_code.max'            => 'Kode pos maksimal 10 karakter.',
            'latitude.required'          => 'Latitude harus ditentukan dengan memilih titik pada peta.',
            'longitude.required'         => 'Longitude harus ditentukan dengan memilih titik pada peta.',
        ]);

        $user = Auth::user();
        if ($request->boolean('is_default')) {
            $user->addresses()->update(['is_default' => false]);
        }

        $address->update([
            'label'             => $data['label'],
            'receiver_name'     => $data['receiver_name'],
            'phone'             => $data['phone'],
            'address'           => $data['address'],
            'province_id'       => $data['province_id'] ?? $address->province_id,
            'regency_id'        => $data['regency_id'] ?? $address->regency_id,
            'district_id'       => $data['district_id'] ?? $address->district_id,
            'sub_district_id'   => $data['sub_district_id'] ?? $address->sub_district_id,
            'province_name'     => $data['province_name'],
            'regency_name'      => $data['regency_name'],
            'district_name'     => $data['district_name'],
            'sub_district_name' => $data['sub_district_name'],
            'postal_code'       => $data['postal_code'],
            'latitude'          => $data['latitude'],
            'longitude'         => $data['longitude'],
            'is_default'        => $request->is_default ? true : $address->is_default,
        ]);

        return redirect()->route('customer.profile.index')->with('success', 'Alamat Anda berhasil diperbarui');
    }

    public function destroy(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);
        $user = Auth::user();
        $isDefault = $address->is_default;
        $address->delete();

        // Jika alamat yang dihapus adalah default
        if ($isDefault) {
            $newDefault = $user->addresses()->oldest()->first();

            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        return redirect()->route('customer.profile.index')->with('success', 'Alamat Anda berhasil dihapus');
    }

    public function setDefault(Address $address)
    {
        // Pastikan user pemilik alamat
        abort_if($address->user_id !== Auth::id(), 403);

        $user = Auth::user();

        // Reset semua alamat menjadi bukan default
        $user->addresses()->update(['is_default' => false]);

        // Set alamat yang dipilih menjadi default
        $address->update(['is_default' => true]);

        return redirect()->route('customer.profile.index')->with('success', 'Alamat Utama Anda berhasil diperbarui');
    }
}
