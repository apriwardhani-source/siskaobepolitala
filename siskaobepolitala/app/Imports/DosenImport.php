<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DosenImport implements ToModel, WithHeadingRow, WithValidation
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'        => $row['nama'],
            'nip'         => $row['nip'],
            'nohp'        => $row['nohp'],
            'email'       => $row['email'],
            'password'    => Hash::make($row['password'] ?? '123456'), // Default password
            'role'        => 'dosen',
            'kode_prodi'  => $row['kode_prodi'],
            'status'      => 'approved',
        ]);
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'nip' => 'required|unique:users,nip',
            'nohp' => 'required|unique:users,nohp|min:6|max:15',
            'email' => 'required|email|unique:users,email',
            'kode_prodi' => 'required|exists:prodis,kode_prodi',
            'password' => 'nullable|min:6',
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Nama dosen wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nohp.required' => 'No HP wajib diisi',
            'nohp.unique' => 'No HP sudah terdaftar',
            'nohp.min' => 'No HP minimal 6 digit',
            'nohp.max' => 'No HP maksimal 15 digit',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'kode_prodi.required' => 'Kode Prodi wajib diisi',
            'kode_prodi.exists' => 'Kode Prodi tidak ditemukan',
            'password.min' => 'Password minimal 6 karakter',
        ];
    }
}
