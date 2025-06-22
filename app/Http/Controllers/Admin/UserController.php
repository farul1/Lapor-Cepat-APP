<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna (admin dan masyarakat),
     * kecuali admin yang sedang login.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Ambil semua pengguna KECUALI diri sendiri
        $query = User::where('id', '!=', auth()->id());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%") // Menambahkan pencarian berdasarkan nomor telepon
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Urutkan berdasarkan nama, lalu paginasi
        $users = $query->orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Menampilkan detail spesifik dari seorang pengguna.
     * Admin bisa melihat detail admin lain atau masyarakat.
     */
    public function show(User $user)
    {
        // Memuat relasi pengaduan (hanya akan ada isinya jika user adalah masyarakat)
        $user->load('pengaduans');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit data pengguna.
     */
    public function edit(User $user)
    {
        // Pengecekan agar admin tidak bisa mengedit dirinya sendiri dari menu ini.
        // Sebaiknya edit profil sendiri melalui halaman /profile.
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('info', 'Untuk mengedit profil Anda sendiri, silakan gunakan halaman "Profil Saya".');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memproses dan menyimpan perubahan data pengguna.
     */
    public function update(Request $request, User $user)
    {
        // Pengecekan keamanan agar admin tidak bisa mengedit dirinya sendiri dari halaman ini.
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengedit akun Anda sendiri dari halaman ini.');
        }

        // Validasi semua input dari form.
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'nik' => ['nullable', 'string', 'digits:16', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'masyarakat'])], // Memastikan role yang masuk valid
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password opsional
        ]);

        // Menyimpan data yang telah divalidasi
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->nik = $request->nik;
        $user->role = $request->role; // Menyimpan perubahan role

        // Jika field password diisi, maka update passwordnya
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan semua perubahan ke database
        $user->save();

        // Arahkan kembali ke halaman detail pengguna dengan pesan sukses
        return redirect()->route('admin.users.show', $user->id)->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Pengecekan keamanan agar admin tidak bisa menghapus dirinya sendiri.
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            $userName = $user->name;
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', "Pengguna '{$userName}' berhasil dihapus.");
        } catch (\Exception $e) {
            // Log error untuk membantu debugging di masa depan
            Log::error("Error deleting user {$user->id}: " . $e->getMessage());
            return redirect()->route('admin.users.index')->with('error', 'Gagal menghapus pengguna. Mungkin pengguna ini masih memiliki data terkait.');
        }
    }

    /**
     * Menampilkan form pembuatan pengguna (tidak digunakan oleh admin).
     * Memberikan feedback informatif kepada admin.
     */
    public function create()
    {
        return redirect()->route('admin.users.index')->with('info', 'Penambahan pengguna baru dilakukan melalui halaman registrasi publik.');
    }

    /**
     * Menyimpan pengguna baru (tidak digunakan oleh admin).
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.users.index');
    }
}
