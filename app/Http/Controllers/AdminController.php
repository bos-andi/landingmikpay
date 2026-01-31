<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserCredentialsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        // Cek apakah user adalah admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        
        return view('admin.users', compact('users'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:active,inactive,pending'
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diupdate'
        ]);
    }

    public function sendCredentials(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = User::findOrFail($id);

        // Generate password baru jika belum ada atau jika diminta
        $password = $request->input('password');
        if (empty($password)) {
            $password = Str::random(12); // Generate random password 12 karakter
        }

        // Update password user
        $user->password = Hash::make($password);
        $user->save();

        try {
            // Kirim email
            Mail::to($user->email)->send(new UserCredentialsMail($user, $password));

            return response()->json([
                'success' => true,
                'message' => 'Email berhasil dikirim ke ' . $user->email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = User::findOrFail($id);
        
        // Jangan hapus admin
        if ($user->role === 'admin') {
            return response()->json(['error' => 'Tidak dapat menghapus admin'], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
