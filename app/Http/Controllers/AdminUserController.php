<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Imports\DosenImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller {
    public function index(Request $request) {
        $role = $request->get('role', 'all');
        
        $query = User::with('prodi');
        
        if ($role !== 'all') {
            $query->where('role', $role);
        }
        
        $users = $query->get();
        
        // Count per role untuk badge
        $roleCounts = [
            'all' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'wadir1' => User::where('role', 'wadir1')->count(),
            'kaprodi' => User::where('role', 'kaprodi')->count(),
            'tim' => User::where('role', 'tim')->count(),
            'dosen' => User::where('role', 'dosen')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'role', 'roleCounts'));
    }

    public function create() {
        $prodis = Prodi::all();
        return view('admin.users.create',compact('prodis'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|unique:users,nip',
            'nohp' => 'required|unique:users,nohp|min:6|max:15',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,wadir1,tim,kaprodi,dosen',
            'status' => 'required|in:approved,pending'
        ]);

        if (in_array($request->role, ['kaprodi', 'tim', 'dosen']) && !$request->kode_prodi) {
            return back()->withErrors(['kode_prodi' => 'Prodi wajib dipilih untuk role ini.'])->withInput();
        }
    
        if (in_array($request->role, ['admin', 'wadir1'])) {
            $request->merge(['kode_prodi' => null]);
        }

        User::create($request->all());

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        $prodis = Prodi::all();
        return view('admin.users.edit', compact('user','prodis'));
    }
    

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'nip' => ['required', Rule::unique('users', 'nip')->ignore($user->id)],
            'nohp' => ['required', 'min:6', 'max:15', Rule::unique('users', 'nohp')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,wadir1,tim,kaprodi,dosen',
            'status' => 'required|in:approved,pending'
        ]);

        $data = [
            'name' => $request->name,
            'nip' => $request->nip,
            'nohp' => $request->nohp,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if (in_array($request->role, ['kaprodi', 'tim', 'dosen'])) {
            if (!$request->kode_prodi) {
                return back()->withErrors(['kode_prodi' => 'Prodi wajib dipilih untuk role ini.'])->withInput();
            }
            $data['kode_prodi'] = $request->kode_prodi;
        }
        
        if (in_array($request->role, ['admin', 'wadir1'])) {
            $data['kode_prodi'] = null;
        }        

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function details($id) {
        $user = User::findOrFail($id);
        return view('admin.users.detail', compact('user'));
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('sukses', 'User berhasil dihapus');
    }

    public function pendingUsers() {
        $pendingUsers = User::where('status', 'pending')->get();
        return view('admin.pendingusers.index', compact('pendingUsers'));
    }


    public function approveUser($id) {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();
        return redirect()->route('admin.pendingusers.index')->with('success', 'Pengguna berhasil disetujui');
    }

    public function rejectUser($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.pendingusers.index')->with('sukses', 'Pengguna berhasil ditolak');
    }

    public function importDosen(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new DosenImport(), $request->file('file'));

            return redirect()->route('admin.users.index')
                ->with('success', 'Data dosen berhasil diimport!');
                
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            return redirect()->route('admin.users.index')
                ->with('error', 'Gagal import: ' . implode(' | ', array_slice($errorMessages, 0, 3)));
                
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate() {
        // Buat file CSV yang proper (bukan XLSX palsu)
        $filename = 'template_import_dosen.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['nama', 'nip', 'nohp', 'email', 'password', 'kode_prodi'];
        $sampleData = [
            ['Dr. Ahmad Fauzi', '198501012010121001', '081234567890', 'ahmad.fauzi@example.com', '123456', 'C0303'],
            ['Dr. Siti Nurhaliza', '198702022011122002', '082345678901', 'siti.nurhaliza@example.com', '123456', 'C0303'],
        ];

        $callback = function() use ($columns, $sampleData) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, $columns);
            
            // Sample data
            foreach ($sampleData as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}