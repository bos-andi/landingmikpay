<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegistrasiController extends Controller
{
    public function index()
    {
        return view('registrasi');
    }

    public function checkSubdomain(Request $request)
    {
        $subdomain = $request->input('subdomain');
        
        if (empty($subdomain)) {
            return response()->json([
                'available' => false,
                'message' => 'Subdomain tidak boleh kosong'
            ]);
        }

        // Validasi format subdomain
        if (!preg_match('/^[a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?$/', $subdomain)) {
            return response()->json([
                'available' => false,
                'message' => 'Format subdomain tidak valid. Hanya huruf kecil, angka, dan tanda hubung'
            ]);
        }

        // Cek apakah subdomain sudah digunakan
        $exists = User::where('subdomain', $subdomain)->exists();
        
        // Daftar subdomain yang dilarang
        $reserved = ['www', 'admin', 'api', 'mail', 'ftp', 'localhost', 'test', 'dev', 'staging', 'app', 'register', 'login'];
        if (in_array(strtolower($subdomain), $reserved)) {
            return response()->json([
                'available' => false,
                'message' => 'Subdomain ini tidak dapat digunakan'
            ]);
        }

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Subdomain sudah digunakan' : 'Subdomain tersedia'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'subdomain' => [
                'required',
                'string',
                'min:3',
                'max:63',
                'regex:/^[a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?$/',
                'unique:users,subdomain'
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'terms' => 'required|accepted'
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'subdomain.required' => 'Subdomain wajib diisi',
            'subdomain.unique' => 'Subdomain sudah digunakan',
            'subdomain.regex' => 'Format subdomain tidak valid. Hanya huruf kecil, angka, dan tanda hubung',
            'subdomain.min' => 'Subdomain minimal 3 karakter',
            'subdomain.max' => 'Subdomain maksimal 63 karakter',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cek reserved subdomain
        $reserved = ['www', 'admin', 'api', 'mail', 'ftp', 'localhost', 'test', 'dev', 'staging', 'app', 'register', 'login'];
        if (in_array(strtolower($request->subdomain), $reserved)) {
            return back()->withErrors(['subdomain' => 'Subdomain ini tidak dapat digunakan'])->withInput();
        }

        // Cek apakah subdomain sudah digunakan
        if (User::where('subdomain', $request->subdomain)->exists()) {
            return back()->withErrors(['subdomain' => 'Subdomain sudah digunakan'])->withInput();
        }

        // Password default untuk semua user baru
        $defaultPassword = '1234';
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($defaultPassword),
            'subdomain' => strtolower($request->subdomain),
            'role' => 'user',
            'status' => 'pending',
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Kirim notifikasi ke Telegram
        try {
            $telegramService = new TelegramService();
            $telegramService->sendNewRegistrationNotification($user);
        } catch (\Exception $e) {
            // Log error tapi jangan gagalkan registrasi
            \Log::error('Failed to send Telegram notification: ' . $e->getMessage());
        }

        return redirect()->route('registrasi.success')->with('success', 'Registrasi berhasil! Email dan password default akan dikirim ke email Anda dalam 1x24 jam setelah persetujuan admin.');
    }

    public function success()
    {
        return view('registrasi-success');
    }
}
