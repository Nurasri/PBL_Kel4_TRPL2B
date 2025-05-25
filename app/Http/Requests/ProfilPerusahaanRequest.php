<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfilPerusahaanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $perusahaan = $this->route('perusahaan');
        
        return [
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:15'],
            'jenis_usaha' => ['required', 'string', 'max:255'],
            'no_registrasi' => [
                'required', 
                'string', 
                Rule::unique('perusahaans', 'no_registrasi')->ignore($perusahaan)
            ],
            'deskripsi' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'jenis_usaha.required' => 'Jenis usaha wajib diisi',
            'no_registrasi.required' => 'Nomor registrasi wajib diisi',
            'no_registrasi.unique' => 'Nomor registrasi sudah terdaftar',
            'logo.image' => 'File harus berupa gambar',
            'logo.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'logo.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
} 