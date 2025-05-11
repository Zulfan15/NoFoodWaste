<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Method untuk register
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',  // Changed from 'name' to 'username'
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Buat user baru - changed field names to match your database
        $user = User::create([
            'username' => $request->username,  // Changed from 'name' to 'username'
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'penerima',  // Default role from your table
        ]);        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect berdasarkan role
        return $this->redirectBasedOnRole($user);
    }

    // Helper method untuk redirect berdasarkan role
    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'restaurant':
                return redirect()->route('restaurant.dashboard');
            case 'ngo':
                return redirect()->route('ngo.dashboard');
            case 'user':
            case 'penerima':
                return redirect()->route('user.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    // Method untuk login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        \Log::info('Login attempt', ['email' => $request->email]);
        
        // Cek apakah user dengan email tersebut ada
        $user = User::where('email', $request->email)->first();  // Simplified - use imported class
        
        if (!$user) {
            \Log::warning('User tidak ditemukan', ['email' => $request->email]);
            return back()
                ->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput($request->except('password'));
        }
        
        \Log::info('User ditemukan', ['user_id' => $user->user_id, 'role' => $user->role]);
        
        // Tambahkan debug untuk password verification
        $password_check = Hash::check($request->password, $user->password);
        \Log::info('Password check', ['result' => $password_check ? 'match' : 'no match']);
          // Coba login - ensure fields match your database
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            \Log::info('Login berhasil', ['user_id' => Auth::id(), 'email' => $request->email]);
            
            // Redirect berdasarkan role
            return $this->redirectBasedOnRole(Auth::user());
        }
    
        \Log::warning('Login gagal', ['email' => $request->email]);
        return back()
            ->withErrors(['password' => 'Password yang Anda masukkan salah.'])
            ->withInput($request->except('password'));
    }
    
    // Method untuk logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
