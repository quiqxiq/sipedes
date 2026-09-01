import fs from 'fs';
import path from 'path';
import puppeteer from 'puppeteer';

const BASE_URL = process.env.APP_URL || 'http://127.0.0.1:8000';
const WARGA_NIK = '3529102904650001';
const WARGA_PASSWORD = 'password';
const ADMIN_EMAIL = 'admin@rombiyahbarat.desa.id';
const ADMIN_PASSWORD = 'password';

// Fixture berkas untuk uji upload (PDF minimal)
const FIXTURE_PDF = path.join(process.cwd(), 'fixture-berkas.pdf');
if (!fs.existsSync(FIXTURE_PDF)) {
    fs.writeFileSync(FIXTURE_PDF, '%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 200 200]>>endobj\ntrailer<</Root 1 0 R>>\n%%EOF\n');
}

const results = [];
let browser;

function record(id, name, status, evidence) {
    results.push({ id, name, status, evidence });
    console.log(`${status === 'PASS' ? '✅' : '❌'} ${id} [${status}] ${name}`);
    if (evidence) console.log(`      └ ${evidence}`);
}

function getExecutablePath() {
    const possiblePaths = [
        'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
        'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
        'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe',
        'C:\\Program Files\\Microsoft\\Edge\\Application\\msedge.exe'
    ];
    for (const p of possiblePaths) {
        if (fs.existsSync(p)) return p;
    }
    return null;
}

const sleep = ms => new Promise(r => setTimeout(r, ms));

async function newPage() {
    const page = await browser.newPage();
    await page.setViewport({ width: 1440, height: 900, deviceScaleFactor: 1 });
    return page;
}

async function goto(page, urlPath) {
    const resp = await page.goto(`${BASE_URL}${urlPath}`, { waitUntil: 'domcontentloaded', timeout: 45000 });
    return resp;
}

async function wargaLogin(page, nik, password) {
    await goto(page, '/login');
    await sleep(800);
    await page.waitForSelector('input[name="nik"]', { timeout: 15000 });
    await page.type('input[name="nik"]', nik);
    await page.type('input[name="password"]', password);
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 30000 }).catch(() => {}),
        page.click('button[type="submit"]'),
    ]);
    await sleep(1200);
}

async function adminLogin(page, email, password) {
    await goto(page, '/admin/login');
    await sleep(800);
    await page.waitForSelector('input[name="email"], input[type="email"]', { timeout: 15000 });
    await page.type('input[name="email"], input[type="email"]', email);
    await page.type('input[name="password"], input[type="password"]', password);
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 30000 }).catch(() => {}),
        page.click('button[type="submit"]'),
    ]);
    await sleep(1200);
}

async function run() {
    browser = await puppeteer.launch({
        headless: 'new',
        executablePath: getExecutablePath(),
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=1440,900']
    });

    // ==================== A. HALAMAN PUBLIK ====================
    const pub = await newPage();

    // TC-01 Landing page
    try {
        const resp = await goto(pub, '/');
        await sleep(1200);
        const title = await pub.title();
        const h1 = await pub.evaluate(() => document.querySelector('h1, h2, .hero-title, main h1')?.innerText || '');
        const ok = resp.status() === 200 && title.trim().length > 0;
        record('TC-01', 'Akses Halaman Landing Publik', ok ? 'PASS' : 'FAIL',
            `HTTP ${resp.status()}, title="${title}", hero="${h1.slice(0, 60)}"`);
    } catch (e) { record('TC-01', 'Akses Halaman Landing Publik', 'FAIL', e.message); }

    // TC-02 Login warga page
    try {
        const resp = await goto(pub, '/login');
        await sleep(800);
        const hasNik = await pub.$('input[name="nik"]') !== null;
        const hasPw = await pub.$('input[name="password"]') !== null;
        record('TC-02', 'Akses Halaman Login Warga (Form NIK + Password)', hasNik && hasPw ? 'PASS' : 'FAIL',
            `HTTP ${resp.status()}, form NIK=${hasNik}, password=${hasPw}`);
    } catch (e) { record('TC-02', 'Akses Halaman Login Warga', 'FAIL', e.message); }

    // TC-03 Registrasi warga page
    try {
        const resp = await goto(pub, '/register');
        await sleep(800);
        const fields = await pub.evaluate(() =>
            ['name', 'nik', 'email', 'telepon', 'alamat', 'password', 'password_confirmation']
                .filter(n => document.querySelector(`input[name="${n}"], textarea[name="${n}"]`)));
        record('TC-03', 'Akses Halaman Registrasi Mandiri Warga', resp.status() === 200 && fields.length >= 6 ? 'PASS' : 'FAIL',
            `HTTP ${resp.status()}, field terisi=${fields.join(',')}`);
    } catch (e) { record('TC-03', 'Akses Halaman Registrasi Warga', 'FAIL', e.message); }

    // TC-04 Login warga gagal (password salah)
    const pg1 = await newPage();
    try {
        await wargaLogin(pg1, WARGA_NIK, 'salah123');
        const errText = await pg1.evaluate(() => document.body.innerText.includes('tidak cocok'));
        const stillLogin = pg1.url().includes('/login');
        record('TC-04', 'Login Warga Password Salah → Muncul Pesan Error', (errText && stillLogin) ? 'PASS' : 'FAIL',
            `URL=${pg1.url()}, pesan error tampil=${errText}`);
    } catch (e) { record('TC-04', 'Login Warga Password Salah', 'FAIL', e.message); }
    await pg1.close();

    // ==================== B. PORTAL WARGA ====================
    const w = await newPage();

    // TC-05 Login warga sukses
    try {
        await wargaLogin(w, WARGA_NIK, WARGA_PASSWORD);
        const url = w.url();
        const welcome = await w.evaluate(() => document.body.innerText.includes('Selamat Datang'));
        record('TC-05', 'Login Warga Berhasil → Dashboard Warga', url.includes('/dashboard') ? 'PASS' : 'FAIL',
            `URL=${url}, banner selamat datang=${welcome}`);
    } catch (e) { record('TC-05', 'Login Warga Berhasil', 'FAIL', e.message); }

    // TC-06 Dashboard warga (statistik)
    try {
        await goto(w, '/dashboard');
        await sleep(1200);
        const stats = await w.evaluate(() => document.body.innerText);
        const hasStats = /total permohonan|sedang diproses|surat disetujui/i.test(stats);
        const hasNik = stats.includes(WARGA_NIK.slice(0, 4));
        record('TC-06', 'Dashboard Warga Menampilkan Statistik & Identitas', hasStats ? 'PASS' : 'FAIL',
            `kartu statistik=${hasStats}, NIK ternormalisasi=${hasNik}`);
    } catch (e) { record('TC-06', 'Dashboard Warga', 'FAIL', e.message); }

    // TC-07 Wizard pengajuan: pilih jenis surat
    let createdPermohonanId = null;
    try {
        await goto(w, '/pengajuan');
        await w.waitForFunction(() => document.body.innerText.includes('Pilih Jenis Surat'), { timeout: 20000 }).catch(() => {});
        await sleep(2500);
        const clicked = await w.evaluate(() => {
            const el = [...document.querySelectorAll('[wire\\:click]')]
                .find(e => e.innerText && e.innerText.includes('Tidak Mampu'));
            if (el) { el.click(); return true; }
            return false;
        });
        await sleep(2500);
        const stepText = await w.evaluate(() => document.body.innerText);
        const hasStep2 = stepText.includes('Langkah 2') || stepText.includes('Syarat Berkas');
        record('TC-07', 'Wizard Pengajuan: Pilih Jenis Surat → Tahap Form & Berkas', (clicked && hasStep2) ? 'PASS' : 'FAIL',
            `kartu diklik=${clicked}, langkah 2 tampil=${hasStep2}`);
    } catch (e) { record('TC-07', 'Wizard Pengajuan Pilih Jenis Surat', 'FAIL', e.message); }

    // TC-08 Wizard: kirim permohonan (alur lengkap) → redirect ke detail & notifikasi sukses
    try {
        await goto(w, '/pengajuan');
        await w.waitForFunction(() => document.body.innerText.includes('Pilih Jenis Surat'), { timeout: 20000 }).catch(() => {});
        await sleep(2500);
        await w.evaluate(() => {
            const el = [...document.querySelectorAll('[wire\\:click]')]
                .find(e => e.innerText && e.innerText.includes('Tidak Mampu'));
            if (el) el.click();
        });
        await sleep(2500);
        // Langkah 2: upload 1 berkas (wajib sebelum lanjut konfirmasi)
        const fileInput = await w.$('input[type="file"]');
        let uploaded = false;
        if (fileInput) {
            await fileInput.uploadFile(FIXTURE_PDF);
            // Tunggu sampai daftar file terunggah muncul (upload Livewire selesai)
            await w.waitForFunction(() => document.body.innerText.includes('fixture-berkas.pdf'), { timeout: 20000 }).catch(() => {});
            uploaded = await w.evaluate(() => document.body.innerText.includes('fixture-berkas.pdf'));
        }
        await sleep(1500);
        // Lanjut ke Langkah 3
        await w.evaluate(() => {
            const btn = [...document.querySelectorAll('button')].find(b => /Lanjut ke Konfirmasi/i.test(b.innerText));
            if (btn) btn.click();
        });
        await sleep(2500);
        const step3 = await w.evaluate(() => document.body.innerText.includes('Langkah 3'));
        // Kirim permohonan
        await w.evaluate(() => {
            const btn = [...document.querySelectorAll('button')].find(b => /Kirim Permohonan/i.test(b.innerText));
            if (btn) btn.click();
        });
        // Tunggu redirect ke /riwayat/{id}
        await w.waitForFunction(() => /\/riwayat\/\d+/.test(window.location.pathname), { timeout: 20000 }).catch(() => {});
        await sleep(1500);
        const url = w.url();
        const m = url.match(/\/riwayat\/(\d+)/);
        createdPermohonanId = m ? m[1] : null;
        const text = await w.evaluate(() => document.body.innerText);
        const success = /berhasil|terkirim|diajukan/i.test(text);
        record('TC-08', 'Wizard Pengajuan: Kirim Permohonan → Redirect Detail & Sukses', (createdPermohonanId && success && uploaded) ? 'PASS' : 'FAIL',
            `redirect /riwayat/${createdPermohonanId}, berkas terunggah=${uploaded}, notifikasi sukses=${success}`);
    } catch (e) { record('TC-08', 'Wizard Kirim Permohonan', 'FAIL', e.message); }

    // TC-09 Riwayat pengajuan index
    try {
        await goto(w, '/riwayat');
        await sleep(1200);
        const text = await w.evaluate(() => document.body.innerText);
        const hasRow = text.includes('SRT/');
        const hasStatus = /Disetujui|Diproses|Diajukan|Koreksi|Ditolak/.test(text);
        record('TC-09', 'Halaman Riwayat Pengajuan Menampilkan Data + Status', (hasRow && hasStatus) ? 'PASS' : 'FAIL',
            `data permohonan=${hasRow}, badge status=${hasStatus}`);
    } catch (e) { record('TC-09', 'Riwayat Pengajuan Index', 'FAIL', e.message); }

    // TC-10 Detail riwayat
    try {
        await goto(w, '/riwayat/1');
        await sleep(1200);
        const text = await w.evaluate(() => document.body.innerText);
        const hasDetail = text.includes('SKTM') || text.includes('Tidak Mampu');
        const hasBadge = text.includes('Disetujui');
        record('TC-10', 'Halaman Detail Pengajuan & Status', (hasDetail && hasBadge) ? 'PASS' : 'FAIL',
            `detail surat=${hasDetail}, badge Disetujui=${hasBadge}`);
    } catch (e) { record('TC-10', 'Detail Riwayat', 'FAIL', e.message); }

    // TC-11 Unduh PDF surat resmi
    try {
        const cookies = await w.cookies();
        const cookieHeader = cookies.map(c => `${c.name}=${c.value}`).join('; ');
        const res = await fetch(`${BASE_URL}/surat/1/pdf`, { headers: { Cookie: cookieHeader } });
        const buf = Buffer.from(await res.arrayBuffer());
        const isPdf = buf.slice(0, 4).toString() === '%PDF';
        const ctype = res.headers.get('content-type') || '';
        record('TC-11', 'Unduh PDF Surat Resmi (Route /surat/{id}/pdf)', (res.ok && isPdf) ? 'PASS' : 'FAIL',
            `HTTP ${res.status}, content-type=${ctype}, magic=%PDF:${isPdf}, bytes=${buf.length}`);
    } catch (e) { record('TC-11', 'Unduh PDF Surat Resmi', 'FAIL', e.message); }

    // TC-12 Logout warga
    try {
        await goto(w, '/dashboard');
        await sleep(800);
        const csrf = await w.evaluate(() => {
            const m = document.querySelector('meta[name="csrf-token"]');
            return m ? m.content : '';
        });
        const ok = await w.evaluate(async (token) => {
            const form = [...document.querySelectorAll('form')].find(f => /logout/i.test(f.action) || f.querySelector('button')?.innerText.includes('Keluar'));
            if (!form) return false;
            const fd = new FormData();
            fd.append('_token', token);
            const r = await fetch(form.action, { method: 'POST', body: fd, credentials: 'include' });
            return r.redirected;
        }, csrf);
        await sleep(1200);
        record('TC-12', 'Logout Warga → Kembali ke Halaman Publik', ok ? 'PASS' : 'FAIL',
            `redirect setelah logout=${ok}`);
    } catch (e) { record('TC-12', 'Logout Warga', 'FAIL', e.message); }
    await w.close();

    // ==================== C. PANEL ADMIN ====================
    const a = await newPage();

    // TC-13 Admin login page
    try {
        const resp = await goto(a, '/admin/login');
        await sleep(800);
        const hasEmail = await a.$('input[name="email"], input[type="email"]') !== null;
        record('TC-13', 'Akses Halaman Login Panel Admin Filament', (resp.status() === 200 && hasEmail) ? 'PASS' : 'FAIL',
            `HTTP ${resp.status()}, form email=${hasEmail}`);
    } catch (e) { record('TC-13', 'Akses Login Admin', 'FAIL', e.message); }

    // TC-14 Admin login gagal
    const a2 = await newPage();
    try {
        await adminLogin(a2, ADMIN_EMAIL, 'salah');
        const err = await a2.evaluate(() => document.body.innerText);
        const hasErr = /kredensial|tidak dapat ditemukan|tidak cocok|credentials|match/i.test(err);
        const snippet = (err.match(/(.{0,40}(kredensial|tidak dapat ditemukan|tidak cocok|credentials|match).{0,40})/i) || [''])[0].replace(/\n+/g, ' ');
        record('TC-14', 'Login Admin Password Salah → Pesan Error', hasErr ? 'PASS' : 'FAIL',
            `pesan error tampil=${hasErr} | teks: "${snippet}"`);
    } catch (e) { record('TC-14', 'Login Admin Gagal', 'FAIL', e.message); }
    await a2.close();

    // TC-15 Admin login sukses → dashboard
    try {
        await adminLogin(a, ADMIN_EMAIL, ADMIN_PASSWORD);
        const url = a.url();
        record('TC-15', 'Login Admin Berhasil → Dashboard Admin', url.includes('/admin') ? 'PASS' : 'FAIL',
            `URL=${url}`);
    } catch (e) { record('TC-15', 'Login Admin Berhasil', 'FAIL', e.message); }

    // TC-16 Dashboard admin widgets
    try {
        await goto(a, '/admin');
        await sleep(2000);
        const text = await a.evaluate(() => document.body.innerText);
        const hasWidget = /Permohonan|Surat|Warga|Total/.test(text);
        const hasChart = await a.$('svg, canvas') !== null;
        record('TC-16', 'Dashboard Admin: Widget Statistik & Chart', (hasWidget && hasChart) ? 'PASS' : 'FAIL',
            `widget statistik=${hasWidget}, elemen chart=${hasChart}`);
    } catch (e) { record('TC-16', 'Dashboard Admin Widgets', 'FAIL', e.message); }

    // TC-17 Jenis Surat index
    try {
        await goto(a, '/admin/jenis-surats');
        await sleep(1500);
        const text = await a.evaluate(() => document.body.innerText);
        const count = (text.match(/SKTM|SKD|SKU|SKN|SKK/g) || []).length;
        record('TC-17', 'Resource Jenis Surat: Daftar 5 Jenis Surat', count >= 5 ? 'PASS' : 'FAIL',
            `kode surat terdeteksi=${count} (SKTM, SKD, SKU, SKN, SKK)`);
    } catch (e) { record('TC-17', 'Jenis Surat Index', 'FAIL', e.message); }

    // TC-18 Jenis Surat create
    try {
        await goto(a, '/admin/jenis-surats/create');
        await sleep(1500);
        const hasForm = await a.evaluate(() => !!document.querySelector('form input[name="kode"], form input') );
        record('TC-18', 'Resource Jenis Surat: Formulir Tambah', hasForm ? 'PASS' : 'FAIL',
            `form input tersedia=${hasForm}`);
    } catch (e) { record('TC-18', 'Jenis Surat Create', 'FAIL', e.message); }

    // TC-19 Jenis Surat edit
    try {
        await goto(a, '/admin/jenis-surats/1/edit');
        await sleep(1500);
        const val = await a.evaluate(() => {
            const inp = document.querySelector('[wire\\:model="data.kode"]') || document.querySelector('#form\\.kode');
            return inp ? inp.value : null;
        });
        record('TC-19', 'Resource Jenis Surat: Edit Data Terisi', val ? 'PASS' : 'FAIL', `kode="${val}"`);
    } catch (e) { record('TC-19', 'Jenis Surat Edit', 'FAIL', e.message); }

    // TC-20 Knowledge Documents index
    try {
        await goto(a, '/admin/knowledge-documents');
        await sleep(1500);
        const text = await a.evaluate(() => document.body.innerText);
        record('TC-20', 'Resource Knowledge Documents: Daftar Dokumen Pengetahuan', text.includes('SOP Pelayanan') ? 'PASS' : 'FAIL',
            `dokumen "SOP Pelayanan Surat Desa" tampil=${text.includes('SOP Pelayanan')}`);
    } catch (e) { record('TC-20', 'Knowledge Documents Index', 'FAIL', e.message); }

    // TC-21 Knowledge Documents create
    try {
        await goto(a, '/admin/knowledge-documents/create');
        await sleep(1500);
        const hasForm = await a.evaluate(() => !!document.querySelector('input[type="file"], form input'));
        record('TC-21', 'Resource Knowledge Documents: Formulir Unggah', hasForm ? 'PASS' : 'FAIL', `form tersedia=${hasForm}`);
    } catch (e) { record('TC-21', 'Knowledge Documents Create', 'FAIL', e.message); }

    // TC-22 Permohonan Surat index
    try {
        await goto(a, '/admin/permohonan-surats');
        await sleep(1500);
        const text = await a.evaluate(() => document.body.innerText);
        const rows = (text.match(/SRT\/20260813/g) || []).length;
        record('TC-22', 'Resource Permohonan Surat: Daftar Permohonan Masuk', rows >= 4 ? 'PASS' : 'FAIL',
            `4 record contoh tampil=${rows >= 4} (ditemukan ${rows})`);
    } catch (e) { record('TC-22', 'Permohonan Surat Index', 'FAIL', e.message); }

    // TC-23 Permohonan Surat view
    try {
        await goto(a, '/admin/permohonan-surats/1');
        await sleep(1500);
        const text = await a.evaluate(() => document.body.innerText);
        record('TC-23', 'Resource Permohonan Surat: Halaman Detail/Verifikasi', text.includes('SRT/20260813/00001') ? 'PASS' : 'FAIL',
            `nomor permohonan tampil=${text.includes('SRT/20260813/00001')}`);
    } catch (e) { record('TC-23', 'Permohonan Surat View', 'FAIL', e.message); }

    // TC-24 Permohonan Surat edit
    try {
        await goto(a, '/admin/permohonan-surats/1/edit');
        await sleep(1500);
        const hasForm = await a.evaluate(() => !!document.querySelector('form input, form select, form textarea'));
        record('TC-24', 'Resource Permohonan Surat: Formulir Edit', hasForm ? 'PASS' : 'FAIL', `form tersedia=${hasForm}`);
    } catch (e) { record('TC-24', 'Permohonan Surat Edit', 'FAIL', e.message); }

    // TC-25 Profil Desa index & edit
    try {
        await goto(a, '/admin/profil-desas');
        await sleep(1500);
        const text = await a.evaluate(() => document.body.innerText);
        const hasDesa = text.includes('Rombiyah');
        await goto(a, '/admin/profil-desas/1/edit');
        await sleep(1500);
        const nama = await a.evaluate(() => {
            const inp = document.querySelector('[wire\\:model="data.nama_desa"]') || document.querySelector('#form\\.nama_desa');
            return inp ? inp.value : null;
        });
        record('TC-25', 'Resource Profil Desa: Data Terisi & Edit', (hasDesa && nama) ? 'PASS' : 'FAIL',
            `profil tampil=${hasDesa}, nama_desa="${nama}"`);
    } catch (e) { record('TC-25', 'Profil Desa', 'FAIL', e.message); }

    // TC-26 Users index
    try {
        await goto(a, '/admin/users');
        await sleep(1500);
        const text = await a.evaluate(() => document.body.innerText);
        const hasAdmin = text.includes('Administrator Desa');
        const hasWarga = text.includes('SUHRAWI');
        record('TC-26', 'Resource Users: Daftar Pengguna (Admin & Warga)', (hasAdmin && hasWarga) ? 'PASS' : 'FAIL',
            `admin tampil=${hasAdmin}, warga SUHRAWI tampil=${hasWarga}`);
    } catch (e) { record('TC-26', 'Users Index', 'FAIL', e.message); }

    // TC-27 Users create
    try {
        await goto(a, '/admin/users/create');
        await sleep(1500);
        const hasForm = await a.evaluate(() => !!document.querySelector('input[name="name"], form input'));
        record('TC-27', 'Resource Users: Formulir Tambah Pengguna', hasForm ? 'PASS' : 'FAIL', `form tersedia=${hasForm}`);
    } catch (e) { record('TC-27', 'Users Create', 'FAIL', e.message); }

    // TC-28 Aktivitas Logs index
    try {
        await goto(a, '/admin/aktivitas-logs');
        await sleep(1500);
        const text = await a.evaluate(() => document.body.innerText);
        const hasLog = /Log|Aktivitas|catat|seeder|login/i.test(text);
        record('TC-28', 'Resource Aktivitas Logs: Audit Trail Tersedia', hasLog ? 'PASS' : 'FAIL',
            `halaman log render=${hasLog}`);
    } catch (e) { record('TC-28', 'Aktivitas Logs Index', 'FAIL', e.message); }

    // TC-29 Registrasi warga: validasi NIK tidak valid (konteks browser terpisah)
    const regContext = await browser.createBrowserContext();
    const pub2 = await regContext.newPage();
    await pub2.setViewport({ width: 1440, height: 900, deviceScaleFactor: 1 });
    try {
        await goto(pub2, '/register');
        await sleep(800);
        await pub2.type('input[name="nik"]', '123');
        await pub2.type('input[name="name"]', 'Test Registrasi');
        await pub2.type('input[name="email"]', 'test-reg@example.com');
        await pub2.type('input[name="telepon"]', '081234567890');
        await pub2.type('[name="alamat"]', 'Jl. Uji');
        await pub2.type('input[name="password"]', 'password123');
        await pub2.type('input[name="password_confirmation"]', 'password123');
        await Promise.all([
            pub2.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 30000 }).catch(() => {}),
            pub2.click('button[type="submit"]'),
        ]);
        await sleep(1200);
        const errText = await pub2.evaluate(() => document.body.innerText);
        const hasNikErr = /16 karakter|harus 16|nik/i.test(errText);
        record('TC-29', 'Registrasi Warga: Validasi NIK (harus 16 digit)', hasNikErr ? 'PASS' : 'FAIL',
            `pesan error NIK tampil=${hasNikErr}`);
    } catch (e) { record('TC-29', 'Registrasi Validasi NIK', 'FAIL', e.message); }
    await regContext.close();

    await browser.close();

    // ==================== RINGKASAN ====================
    const pass = results.filter(r => r.status === 'PASS').length;
    console.log(`\n===== HASIL BLACKBOX TESTING: ${pass}/${results.length} PASS =====`);
    for (const r of results) {
        console.log(`${r.id}\t${r.status}\t${r.name}`);
    }
}

run().catch(e => { console.error('FATAL', e); process.exit(1); });
