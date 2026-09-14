<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan halaman formulir permintaan OTP lupa password (input NIK)
     */
    public function showLinkRequestForm()
    {
        if (Auth::check()) {
            return redirect()->route('warga.dashboard');
        }

        return view('warga.auth.forgot-password');
    }

    /**
     * Kirim kode OTP via WhatsApp ke nomor HP terdaftar milik warga
     */
    public function sendOtp(Request $request, WhatsAppService $waService)
    {
        $request->validate([
            'nik' => ['required', 'digits:16'],
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik.digits' => 'NIK harus berupa 16 digit angka.',
        ]);

        $user = User::where('nik', $request->nik)
            ->where('is_active', true)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'nik' => 'NIK tidak terdaftar dalam sistem SIPEDES atau akun dinonaktifkan.',
            ])->onlyInput('nik');
        }

        if (empty($user->telepon)) {
            return back()->withErrors([
                'nik' => 'Akun warga Anda belum memiliki nomor WhatsApp yang terdaftar. Silakan hubungi Balai Desa Rombiya Barat untuk pembaruan data kontak.',
            ])->onlyInput('nik');
        }

        // Cek cooldown proteksi spam pengiriman (60 detik)
        $lastOtp = PasswordResetOtp::where('user_id', $user->id)
            ->where('is_used', false)
            ->where('created_at', '>=', now()->subSeconds(60))
            ->first();

        if ($lastOtp) {
            $secondsLeft = 60 - now()->diffInSeconds($lastOtp->created_at);
            return back()->withErrors([
                'nik' => "Mohon tunggu {$secondsLeft} detik sebelum meminta kode OTP baru.",
            ])->onlyInput('nik');
        }

        // Nonaktifkan kode OTP lama yang belum terpakai untuk user ini
        PasswordResetOtp::where('user_id', $user->id)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Buat 6 digit kode OTP angka acak
        $otpCode = (string) random_int(100000, 999999);

        // Simpan OTP ke database dengan masa aktif 10 menit
        PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => $otpCode,
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Simpan referensi ke session pengguna
        session([
            'password_reset_user_id' => $user->id,
            'password_reset_nik' => $user->nik,
            'password_reset_telepon' => $user->telepon,
            'password_reset_otp_sent_at' => now()->timestamp,
        ]);

        // Kirim notifikasi pesan WhatsApp via template dengan fallback pesan langsung
        $sent = $waService->sendTemplate('otp_lupa_password', $user->telepon, [
            'nama_warga' => $user->name,
            'otp_code' => $otpCode,
        ], $user->name);

        if (!$sent) {
            $msg = "🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\n"
                . "Yth. *{$user->name}*,\n\n"
                . "Kode verifikasi OTP untuk mengatur ulang kata sandi akun SIPEDES Anda adalah:\n\n"
                . "👉 *{$otpCode}*\n\n"
                . "Kode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapapun demi keamanan akun Anda.\n\n"
                . "_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_";
            $waService->sendMessage($user->telepon, $msg, 'sistem', null, $user->name);
        }

        $maskedPhone = $this->maskPhoneNumber($user->telepon);

        return redirect()->route('warga.password.verify')->with(
            'success',
            "Kode OTP 6-digit berhasil dikirimkan ke WhatsApp Anda ({$maskedPhone}). Silakan periksa pesan masuk WhatsApp."
        );
    }

    /**
     * Tampilkan halaman formulir verifikasi OTP 6 digit
     */
    public function showVerifyForm()
    {
        if (Auth::check()) {
            return redirect()->route('warga.dashboard');
        }

        $userId = session('password_reset_user_id');
        if (!$userId) {
            return redirect()->route('warga.password.request')->with('error', 'Silakan masukkan NIK Anda terlebih dahulu.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('warga.password.request')->with('error', 'Data akun tidak valid.');
        }

        $maskedPhone = $this->maskPhoneNumber($user->telepon ?? '');
        $sentAt = session('password_reset_otp_sent_at', 0);
        $secondsPassed = now()->timestamp - $sentAt;
        $cooldownSeconds = max(0, 60 - $secondsPassed);

        return view('warga.auth.verify-otp', [
            'user' => $user,
            'maskedPhone' => $maskedPhone,
            'cooldownSeconds' => $cooldownSeconds,
        ]);
    }

    /**
     * Verifikasi kode OTP yang diinput warga
     */
    public function verifyOtp(Request $request)
    {
        $userId = session('password_reset_user_id');
        if (!$userId) {
            return redirect()->route('warga.password.request')->with('error', 'Sesi verifikasi telah berakhir. Silakan mulai kembali.');
        }

        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP 6-digit wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $otpRecord = PasswordResetOtp::where('user_id', $userId)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otpRecord) {
            return redirect()->route('warga.password.request')->with('error', 'Kode OTP tidak ditemukan. Silakan ajukan permintaan ulang.');
        }

        if ($otpRecord->isExpired()) {
            return back()->withErrors([
                'otp' => 'Kode OTP telah kadaluarsa (berlaku 10 menit). Silakan klik kirim ulang kode OTP.',
            ]);
        }

        if ($otpRecord->attempts >= 5) {
            $otpRecord->markAsUsed();
            session()->forget(['password_reset_user_id', 'password_reset_nik', 'password_reset_telepon']);
            return redirect()->route('warga.password.request')->with('error', 'Batas percobaan memasukkan OTP terlampaui (maksimal 5 kali). Demi keamanan akun, silakan ajukan ulang.');
        }

        if (!$otpRecord->isValid($request->otp)) {
            $otpRecord->incrementAttempts();
            $sisa = 5 - $otpRecord->attempts;
            return back()->withErrors([
                'otp' => "Kode OTP yang Anda masukkan salah. Sisa kesempatan: {$sisa} kali.",
            ]);
        }

        // OTP Valid! Tandai verifikasi berhasil di session
        session(['password_reset_otp_verified' => true]);

        return redirect()->route('warga.password.reset')->with('success', 'Kode OTP valid! Silakan masukkan kata sandi baru Anda.');
    }

    /**
     * Kirim ulang kode OTP dengan countdown proteksi
     */
    public function resendOtp(Request $request, WhatsAppService $waService)
    {
        $userId = session('password_reset_user_id');
        if (!$userId) {
            return redirect()->route('warga.password.request')->with('error', 'Sesi telah berakhir. Silakan masukkan NIK Anda kembali.');
        }

        $user = User::find($userId);
        if (!$user || empty($user->telepon)) {
            return redirect()->route('warga.password.request')->with('error', 'Akun tidak valid atau nomor WhatsApp tidak ditemukan.');
        }

        $sentAt = session('password_reset_otp_sent_at', 0);
        if ((now()->timestamp - $sentAt) < 60) {
            $remaining = 60 - (now()->timestamp - $sentAt);
            return back()->with('error', "Mohon tunggu {$remaining} detik sebelum meminta kirim ulang kode OTP.");
        }

        // Buat OTP baru
        $otpCode = (string) random_int(100000, 999999);

        // Nonaktifkan OTP lama
        PasswordResetOtp::where('user_id', $user->id)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => $otpCode,
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        session(['password_reset_otp_sent_at' => now()->timestamp]);

        $sent = $waService->sendTemplate('otp_lupa_password', $user->telepon, [
            'nama_warga' => $user->name,
            'otp_code' => $otpCode,
        ], $user->name);

        if (!$sent) {
            $msg = "🔐 *KODE VERIFIKASI OTP (KIRIM ULANG) — SIPEDES DESA ROMBIYA BARAT*\n\n"
                . "Yth. *{$user->name}*,\n\n"
                . "Kode verifikasi OTP baru Anda adalah:\n\n"
                . "👉 *{$otpCode}*\n\n"
                . "Kode ini bersifat RAHASIA dan berlaku selama 10 menit.\n\n"
                . "_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_";
            $waService->sendMessage($user->telepon, $msg, 'sistem', null, $user->name);
        }

        return back()->with('success', 'Kode OTP baru telah berhasil dikirimkan ke WhatsApp Anda.');
    }

    /**
     * Tampilkan formulir pengaturan kata sandi baru (setelah OTP diverifikasi)
     */
    public function showResetForm()
    {
        if (Auth::check()) {
            return redirect()->route('warga.dashboard');
        }

        $userId = session('password_reset_user_id');
        $isVerified = session('password_reset_otp_verified');

        if (!$userId || !$isVerified) {
            return redirect()->route('warga.password.request')->with('error', 'Akses ditolak. Silakan verifikasi kode OTP Anda terlebih dahulu.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('warga.password.request')->with('error', 'Data akun tidak ditemukan.');
        }

        return view('warga.auth.reset-password', [
            'user' => $user,
        ]);
    }

    /**
     * Simpan kata sandi baru warga dan redirect ke login
     */
    public function resetPassword(Request $request, WhatsAppService $waService)
    {
        $userId = session('password_reset_user_id');
        $isVerified = session('password_reset_otp_verified');

        if (!$userId || !$isVerified) {
            return redirect()->route('warga.password.request')->with('error', 'Sesi pembaruan kata sandi tidak sah atau telah kadaluarsa.');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::findOrFail($userId);

        // Update password baru di database
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Tandai seluruh OTP user ini sebagai used
        PasswordResetOtp::where('user_id', $user->id)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Kirim pesan konfirmasi keamanan ke WhatsApp warga
        if (!empty($user->telepon)) {
            $waService->sendTemplate('password_berhasil_diubah', $user->telepon, [
                'nama_warga' => $user->name,
                'waktu' => now()->translatedFormat('d F Y H:i') . ' WIB',
            ], $user->name);
        }

        // Hapus session reset password
        session()->forget([
            'password_reset_user_id',
            'password_reset_nik',
            'password_reset_telepon',
            'password_reset_otp_verified',
            'password_reset_otp_sent_at',
        ]);

        return redirect()->route('warga.login')->with(
            'success',
            'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.'
        );
    }

    /**
     * Mask nomor telepon untuk tampilan aman (misal 08123456789 -> 0812****6789)
     */
    protected function maskPhoneNumber(string $phone): string
    {
        $len = strlen($phone);
        if ($len <= 7) {
            return $phone;
        }

        $prefix = substr($phone, 0, 4);
        $suffix = substr($phone, -3);
        $stars = str_repeat('*', max(3, $len - 7));

        return $prefix . $stars . $suffix;
    }
}
