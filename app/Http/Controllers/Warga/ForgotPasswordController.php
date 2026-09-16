<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan halaman formulir permintaan OTP lupa password (input NIK)
     */
    public function showLinkRequestForm(Request $request)
    {
        // Jika user secara eksplisit ingin mengganti NIK (?ganti=1 atau ?reset=1)
        if ($request->has('ganti') || $request->has('reset')) {
            session()->forget([
                'password_reset_user_id',
                'password_reset_nik',
                'password_reset_telepon',
                'password_reset_otp_sent_at',
                'password_reset_otp_verified',
            ]);
            session()->save();

            return view('warga.auth.forgot-password');
        }

        // Jika sudah ada sesi OTP yang masih aktif dan belum kadaluarsa, arahkan langsung ke halaman OTP
        $userId = session('password_reset_user_id');
        if ($userId) {
            $activeOtp = PasswordResetOtp::where('user_id', $userId)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->latest()
                ->first();

            if ($activeOtp) {
                return redirect()->route('warga.password.verify', ['nik' => session('password_reset_nik')])->with(
                    'info',
                    'Kode verifikasi OTP telah dikirimkan ke WhatsApp Anda. Silakan masukkan 6 digit kode OTP di bawah ini.'
                );
            }
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

        $maskedPhone = $this->maskPhoneNumber($user->telepon);

        // Cek apakah ada OTP aktif yang baru saja dikirim dalam rentang 60 detik (cooldown proteksi spam)
        $lastOtp = PasswordResetOtp::where('user_id', $user->id)
            ->where('is_used', false)
            ->where('created_at', '>=', now()->subSeconds(60))
            ->first();

        if ($lastOtp) {
            // Pastikan session tersimpan dan LANGSUNG bawa pengguna ke halaman verifikasi OTP!
            session([
                'password_reset_user_id' => $user->id,
                'password_reset_nik' => $user->nik,
                'password_reset_telepon' => $user->telepon,
                'password_reset_otp_sent_at' => $lastOtp->created_at->timestamp,
            ]);
            session()->save();

            $secondsLeft = 60 - now()->diffInSeconds($lastOtp->created_at);

            return redirect()->route('warga.password.verify', ['nik' => $user->nik])->with(
                'info',
                "Kode OTP telah dikirimkan ke WhatsApp Anda ({$maskedPhone}). Silakan periksa pesan masuk dan masukkan kodenya. Anda dapat meminta kode baru dalam {$secondsLeft} detik."
            );
        }

        // Nonaktifkan kode OTP lama yang belum terpakai untuk user ini
        PasswordResetOtp::where('user_id', $user->id)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Buat 6 digit kode OTP angka acak
        $otpCode = (string) random_int(100000, 999999);

        // Simpan OTP ke database dengan masa aktif 10 menit
        $newOtp = PasswordResetOtp::create([
            'user_id' => $user->id,
            'nik' => $user->nik,
            'telepon' => $user->telepon,
            'otp' => $otpCode,
            'attempts' => 0,
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Simpan referensi ke session pengguna secara persisten
        session([
            'password_reset_user_id' => $user->id,
            'password_reset_nik' => $user->nik,
            'password_reset_telepon' => $user->telepon,
            'password_reset_otp_sent_at' => now()->timestamp,
        ]);
        session()->save();

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

        return redirect()->route('warga.password.verify', ['nik' => $user->nik])->with(
            'success',
            "Kode OTP 6-digit berhasil dikirimkan ke WhatsApp Anda ({$maskedPhone}). Silakan periksa pesan masuk WhatsApp."
        );
    }

    /**
     * Tampilkan halaman formulir verifikasi OTP 6 digit
     */
    public function showVerifyForm(Request $request)
    {
        $userId = session('password_reset_user_id');
        $user = null;

        if ($userId) {
            $user = User::find($userId);
        }

        // Fallback: Jika session kosong (misal cookie terhambat di browser), pulihkan via parameter NIK jika memiliki OTP aktif
        if (!$user && $request->filled('nik')) {
            $userCandidate = User::where('nik', $request->nik)->where('is_active', true)->first();
            if ($userCandidate) {
                $hasActiveOtp = PasswordResetOtp::where('user_id', $userCandidate->id)
                    ->where('is_used', false)
                    ->where('expires_at', '>', now())
                    ->latest()
                    ->first();

                if ($hasActiveOtp) {
                    $user = $userCandidate;
                    session([
                        'password_reset_user_id' => $user->id,
                        'password_reset_nik' => $user->nik,
                        'password_reset_telepon' => $user->telepon,
                        'password_reset_otp_sent_at' => $hasActiveOtp->created_at->timestamp,
                    ]);
                    session()->save();
                }
            }
        }

        if (!$user) {
            return redirect()->route('warga.password.request')->with('error', 'Sesi verifikasi tidak ditemukan atau telah berakhir. Silakan masukkan NIK Anda.');
        }

        $maskedPhone = $this->maskPhoneNumber($user->telepon ?? '');
        $sentAt = session('password_reset_otp_sent_at', now()->timestamp);
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

        if (!$userId && $request->filled('nik')) {
            $userCandidate = User::where('nik', $request->nik)->where('is_active', true)->first();
            if ($userCandidate) {
                $userId = $userCandidate->id;
                session([
                    'password_reset_user_id' => $userCandidate->id,
                    'password_reset_nik' => $userCandidate->nik,
                    'password_reset_telepon' => $userCandidate->telepon,
                ]);
                session()->save();
            }
        }

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
            session()->save();
            return redirect()->route('warga.password.request')->with('error', 'Batas percobaan memasukkan OTP terlampaui (maksimal 5 kali). Demi keamanan akun, silakan ajukan ulang.');
        }

        if (!$otpRecord->isValid($request->otp)) {
            $otpRecord->incrementAttempts();
            $sisa = 5 - $otpRecord->attempts;
            return back()->withErrors([
                'otp' => "Kode OTP yang Anda masukkan salah. Sisa kesempatan: {$sisa} kali.",
            ]);
        }

        // OTP Valid! Buat secure reset token dan simpan di database & session
        $resetToken = Str::random(64);
        $otpRecord->update([
            'reset_token' => $resetToken,
            'verified_at' => now(),
            'expires_at' => now()->addMinutes(15), // Berikan waktu 15 menit penuh setelah verifikasi untuk membuat kata sandi baru
        ]);

        $user = User::find($userId);

        session([
            'password_reset_user_id' => $user->id,
            'password_reset_nik' => $user->nik,
            'password_reset_telepon' => $user->telepon,
            'password_reset_token' => $resetToken,
            'password_reset_otp_verified' => true,
        ]);
        session()->save();

        return redirect()->route('warga.password.reset', [
            'token' => $resetToken,
            'nik' => $user->nik,
        ])->with('success', 'Kode OTP valid! Silakan masukkan kata sandi baru Anda.');
    }

    /**
     * Kirim ulang kode OTP dengan countdown proteksi
     */
    public function resendOtp(Request $request, WhatsAppService $waService)
    {
        $userId = session('password_reset_user_id');

        if (!$userId && $request->filled('nik')) {
            $userCandidate = User::where('nik', $request->nik)->where('is_active', true)->first();
            if ($userCandidate) {
                $userId = $userCandidate->id;
                session([
                    'password_reset_user_id' => $userCandidate->id,
                    'password_reset_nik' => $userCandidate->nik,
                    'password_reset_telepon' => $userCandidate->telepon,
                ]);
                session()->save();
            }
        }

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
        session()->save();

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
    public function showResetForm(Request $request)
    {
        $userId = session('password_reset_user_id');
        $isVerified = session('password_reset_otp_verified');
        $token = $request->query('token') ?: session('password_reset_token');
        $nik = $request->query('nik') ?: session('password_reset_nik');
        $user = null;

        if ($userId && $isVerified) {
            $user = User::find($userId);
        }

        // Fallback 1: validasi via token & nik yang telah terverifikasi di database
        if (!$user && !empty($token) && !empty($nik)) {
            $otpRecord = PasswordResetOtp::where('nik', $nik)
                ->where('reset_token', $token)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->whereNotNull('verified_at')
                ->latest()
                ->first();

            if ($otpRecord) {
                $user = User::find($otpRecord->user_id);
            }
        }

        // Fallback 2: jika token terlepas, periksa via NIK apakah ada OTP yang sudah diverifikasi dan belum terpakai
        if (!$user && !empty($nik)) {
            $otpRecord = PasswordResetOtp::where('nik', $nik)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->whereNotNull('verified_at')
                ->latest()
                ->first();

            if ($otpRecord) {
                $user = User::find($otpRecord->user_id);
                $token = $otpRecord->reset_token;
            }
        }

        // Fallback 3: periksa sesi userId jika memiliki OTP terverifikasi yang sah
        if (!$user && $userId) {
            $otpRecord = PasswordResetOtp::where('user_id', $userId)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->whereNotNull('verified_at')
                ->latest()
                ->first();

            if ($otpRecord) {
                $user = User::find($userId);
                $token = $otpRecord->reset_token;
                $nik = $otpRecord->nik;
            }
        }

        if (!$user) {
            // Cek apakah NIK ini baru saja berhasil memperbarui password dalam 15 menit terakhir (misal reload atau klik Back)
            if (!empty($nik)) {
                $recentlyReset = PasswordResetOtp::where('nik', $nik)
                    ->where('is_used', true)
                    ->where('updated_at', '>=', now()->subMinutes(15))
                    ->exists();

                if ($recentlyReset) {
                    return redirect()->route('warga.login')->with('info', 'Kata sandi Anda telah berhasil diperbarui sebelumnya. Silakan masuk menggunakan kata sandi baru Anda.');
                }
            }

            return redirect()->route('warga.password.request')->with('error', 'Sesi verifikasi tidak ditemukan atau telah kadaluarsa. Silakan masukkan NIK Anda untuk meminta kode OTP.');
        }

        // Simpan pemulihan sesi secara aman
        session([
            'password_reset_user_id' => $user->id,
            'password_reset_nik' => $user->nik,
            'password_reset_telepon' => $user->telepon,
            'password_reset_token' => $token,
            'password_reset_otp_verified' => true,
        ]);
        session()->save();

        return view('warga.auth.reset-password', [
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Simpan kata sandi baru warga dan redirect ke login
     */
    public function resetPassword(Request $request, WhatsAppService $waService)
    {
        $userId = session('password_reset_user_id');
        $isVerified = session('password_reset_otp_verified');
        $token = $request->input('token') ?: session('password_reset_token');
        $nik = $request->input('nik') ?: session('password_reset_nik');
        $user = null;

        if ($userId && $isVerified) {
            $user = User::find($userId);
        }

        // Fallback 1: pulihkan user via token & nik dari database jika session terhambat
        if (!$user && !empty($token) && !empty($nik)) {
            $otpRecord = PasswordResetOtp::where('nik', $nik)
                ->where('reset_token', $token)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->whereNotNull('verified_at')
                ->latest()
                ->first();

            if ($otpRecord) {
                $user = User::find($otpRecord->user_id);
            }
        }

        // Fallback 2: via NIK dengan OTP terverifikasi aktif
        if (!$user && !empty($nik)) {
            $otpRecord = PasswordResetOtp::where('nik', $nik)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->whereNotNull('verified_at')
                ->latest()
                ->first();

            if ($otpRecord) {
                $user = User::find($otpRecord->user_id);
            }
        }

        // Fallback 3: via session userId jika memiliki OTP terverifikasi aktif
        if (!$user && $userId) {
            $otpRecord = PasswordResetOtp::where('user_id', $userId)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->whereNotNull('verified_at')
                ->latest()
                ->first();

            if ($otpRecord) {
                $user = User::find($userId);
            }
        }

        if (!$user) {
            // Cek apakah NIK ini baru saja berhasil memperbarui password dalam 15 menit terakhir (misal karena double submit / duplicate POST)
            if (!empty($nik)) {
                $recentlyReset = PasswordResetOtp::where('nik', $nik)
                    ->where('is_used', true)
                    ->where('updated_at', '>=', now()->subMinutes(15))
                    ->exists();

                if ($recentlyReset) {
                    Auth::guard('web')->logout();
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('warga.login')->with(
                        'success',
                        'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.'
                    );
                }
            }

            return redirect()->route('warga.password.request')->with('error', 'Waktu sesi pembaruan kata sandi telah habis. Silakan ajukan ulang kode OTP.');
        }

        // Validasi kata sandi dengan pesan Bahasa Indonesia yang presisi
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks yang valid.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok. Pastikan Anda memasukkan kata sandi yang sama persis di kedua kolom.',
        ]);

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

        // Pastikan pengguna TIDAK langsung masuk / terautentikasi (logout dari semua guard)
        Auth::guard('web')->logout();
        Auth::logout();

        // Hapus session reset password dan invalidate session lama
        session()->forget([
            'password_reset_user_id',
            'password_reset_nik',
            'password_reset_telepon',
            'password_reset_token',
            'password_reset_otp_verified',
            'password_reset_otp_sent_at',
        ]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect tepat ke halaman login portal warga
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
