import fs from 'fs';
import path from 'path';
import puppeteer from 'puppeteer';

const BASE_URL = process.env.APP_URL || 'http://127.0.0.1:8000';
const SCREENSHOT_DIR = path.resolve(process.cwd(), 'screenshots');

// Waktu penungguan rendering per halaman (ms)
const RENDER_DELAY_MS = parseInt(process.env.RENDER_DELAY_MS || '4000', 10);
// Waktu penungguan setelah submit form login (ms)
const LOGIN_DELAY_MS = 4000;

// Kredensial demo (dari seeder)
const WARGA_NIK = process.env.WARGA_NIK || '3529102904650001';
const WARGA_PASSWORD = 'password';
const ADMIN_EMAIL = process.env.ADMIN_EMAIL || 'admin@rombiyahbarat.desa.id';
const ADMIN_PASSWORD = 'password';

// id contoh dari seeder (PermohonanSuratSeeder & record KnowledgeDocument)
const PERMOHONAN_ID = 1;
const KNOWLEDGE_DOCUMENT_ID = 4;

if (!fs.existsSync(SCREENSHOT_DIR)) {
    fs.mkdirSync(SCREENSHOT_DIR, { recursive: true });
}

function getExecutablePath() {
    const possiblePaths = [
        'C:\\Users\\g0str\\.cache\\puppeteer\\chrome\\win64-151.0.7922.47\\chrome-win64\\chrome.exe',
        'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
        'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
        'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe',
        'C:\\Program Files\\Microsoft\\Edge\\Application\\msedge.exe'
    ];

    for (const p of possiblePaths) {
        if (fs.existsSync(p)) {
            return p;
        }
    }
    return null;
}

async function waitForPageRender(page, delayMs = RENDER_DELAY_MS) {
    await new Promise(r => setTimeout(r, delayMs));
}

async function capture(page, filePath, urlPath) {
    console.log(`📸 ${path.basename(filePath)}  (${urlPath})`);
    await page.goto(`${BASE_URL}${urlPath}`, { waitUntil: 'networkidle0', timeout: 60000 });
    await waitForPageRender(page);
    await page.screenshot({ path: filePath, fullPage: true });
}

async function takeScreenshots() {
    console.log('🚀 Memulai Screenshot Generator SIPEDES Rombiyah Barat...');
    console.log(`⏱️ Waktu tunggu render: ${RENDER_DELAY_MS / 1000} detik/halaman`);

    const execPath = getExecutablePath();
    const launchOptions = {
        headless: 'new',
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=1440,900']
    };

    if (execPath) {
        console.log(`📌 Browser Executable: ${execPath}`);
        launchOptions.executablePath = execPath;
    }

    const browser = await puppeteer.launch(launchOptions);
    let count = 0;

    // ============================================================
    // 1. HALAMAN PUBLIK & GUEST (TANPA LOGIN)
    // ============================================================
    console.log('\n🌐 1. HALAMAN PUBLIK & GUEST...');
    const publicPage = await browser.newPage();
    await publicPage.setViewport({ width: 1440, height: 900, deviceScaleFactor: 1 });

    const publicPages = [
        { name: '01_publik_landing.png', path: '/' },
        { name: '02_login_warga.png', path: '/login' },
        { name: '03_registrasi_warga.png', path: '/register' },
        { name: '04_admin_login.png', path: '/admin/login' },
    ];

    for (const p of publicPages) {
        try {
            await capture(publicPage, path.join(SCREENSHOT_DIR, p.name), p.path);
            count++;
        } catch (e) {
            console.warn(`⚠️ Skipped ${p.name}: ${e.message}`);
        }
    }

    // ============================================================
    // 2. PORTAL WARGA (LOGIN SEBAGAI WARGA)
    // ============================================================
    console.log(`\n🔑 2. AUTENTIKASI PORTAL WARGA (${WARGA_NIK})...`);
    const wargaContext = await browser.createBrowserContext();
    const wargaPage = await wargaContext.newPage();
    await wargaPage.setViewport({ width: 1440, height: 900, deviceScaleFactor: 1 });

    try {
        await wargaPage.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle0', timeout: 60000 });
        await new Promise(r => setTimeout(r, 1500));

        await wargaPage.waitForSelector('input[name="nik"]', { timeout: 15000 });
        await wargaPage.type('input[name="nik"]', WARGA_NIK);
        await wargaPage.type('input[name="password"]', WARGA_PASSWORD);

        await Promise.all([
            wargaPage.waitForNavigation({ waitUntil: 'networkidle0', timeout: 30000 }).catch(() => {}),
            wargaPage.click('button[type="submit"]'),
        ]);
        await new Promise(r => setTimeout(r, LOGIN_DELAY_MS));
        console.log(`✅ Login Warga Sukses. URL: ${wargaPage.url()}`);
    } catch (e) {
        console.warn('⚠️ Kendala Login Portal Warga:', e.message);
    }

    const wargaPages = [
        { name: '05_warga_dashboard.png', path: '/dashboard' },
        { name: '06_warga_pengajuan_surat.png', path: '/pengajuan' },
        { name: '07_warga_riwayat_index.png', path: '/riwayat' },
        { name: '08_warga_riwayat_detail.png', path: `/riwayat/${PERMOHONAN_ID}` },
    ];

    // Route /surat/{id}/pdf mengembalikan dokumen PDF (bukan halaman HTML).
    // Browser headless tidak dapat menampilkan viewer PDF, jadi cukup unduh file PDF-nya.
    try {
        const cookies = await wargaPage.cookies();
        const cookieHeader = cookies.map(c => `${c.name}=${c.value}`).join('; ');
        const origin = new URL(wargaPage.url()).origin;
        const res = await fetch(`${origin}/surat/${PERMOHONAN_ID}/pdf`, { headers: { Cookie: cookieHeader } });
        if (res.ok) {
            const buf = Buffer.from(await res.arrayBuffer());
            fs.writeFileSync(path.join(SCREENSHOT_DIR, '09_warga_surat_pdf_file.pdf'), buf);
            console.log(`💾 09_warga_surat_pdf_file.pdf disimpan (${buf.length} bytes)`);
        } else {
            console.warn(`⚠️ Gagal mengunduh PDF (HTTP ${res.status})`);
        }
    } catch (e) {
        console.warn(`⚠️ Gagal mengunduh PDF: ${e.message}`);
    }
    count++;

    for (const p of wargaPages) {
        try {
            await capture(wargaPage, path.join(SCREENSHOT_DIR, p.name), p.path);
            count++;
        } catch (e) {
            console.warn(`⚠️ Skipped ${p.name}: ${e.message}`);
        }
    }

    // ============================================================
    // 3. FILAMENT ADMIN PANEL (LOGIN SEBAGAI ADMIN)
    // ============================================================
    console.log(`\n🔑 3. AUTENTIKASI FILAMENT ADMIN PANEL (${ADMIN_EMAIL})...`);
    const adminContext = await browser.createBrowserContext();
    const adminPage = await adminContext.newPage();
    await adminPage.setViewport({ width: 1440, height: 900, deviceScaleFactor: 1 });

    try {
        await adminPage.goto(`${BASE_URL}/admin/login`, { waitUntil: 'networkidle0', timeout: 60000 });
        await new Promise(r => setTimeout(r, 1500));

        await adminPage.waitForSelector('input[name="email"], input[type="email"]', { timeout: 15000 });
        await adminPage.type('input[name="email"], input[type="email"]', ADMIN_EMAIL);
        await adminPage.type('input[name="password"], input[type="password"]', ADMIN_PASSWORD);

        await Promise.all([
            adminPage.waitForNavigation({ waitUntil: 'networkidle0', timeout: 30000 }).catch(() => {}),
            adminPage.click('button[type="submit"]'),
        ]);
        await new Promise(r => setTimeout(r, LOGIN_DELAY_MS));
        console.log(`✅ Login Admin Sukses. URL: ${adminPage.url()}`);
    } catch (e) {
        console.warn('⚠️ Kendala Login Admin Panel:', e.message);
    }

    const adminPages = [
        { name: '10_admin_dashboard.png', path: '/admin' },
        { name: '11_admin_jenis_surat_index.png', path: '/admin/jenis-surats' },
        { name: '12_admin_jenis_surat_create.png', path: '/admin/jenis-surats/create' },
        { name: '13_admin_jenis_surat_edit.png', path: '/admin/jenis-surats/1/edit' },
        { name: '14_admin_knowledge_documents_index.png', path: '/admin/knowledge-documents' },
        { name: '15_admin_knowledge_documents_create.png', path: '/admin/knowledge-documents/create' },
        { name: '16_admin_knowledge_documents_edit.png', path: `/admin/knowledge-documents/${KNOWLEDGE_DOCUMENT_ID}/edit` },
        { name: '17_admin_permohonan_surat_index.png', path: '/admin/permohonan-surats' },
        { name: '18_admin_permohonan_surat_view.png', path: `/admin/permohonan-surats/${PERMOHONAN_ID}` },
        { name: '19_admin_permohonan_surat_edit.png', path: `/admin/permohonan-surats/${PERMOHONAN_ID}/edit` },
        { name: '20_admin_profil_desa_index.png', path: '/admin/profil-desas' },
        { name: '21_admin_profil_desa_edit.png', path: '/admin/profil-desas/1/edit' },
        { name: '22_admin_users_index.png', path: '/admin/users' },
        { name: '23_admin_users_create.png', path: '/admin/users/create' },
        { name: '24_admin_users_edit.png', path: '/admin/users/1/edit' },
        { name: '25_admin_aktivitas_logs_index.png', path: '/admin/aktivitas-logs' },
    ];

    for (const p of adminPages) {
        try {
            await capture(adminPage, path.join(SCREENSHOT_DIR, p.name), p.path);
            count++;
        } catch (e) {
            console.warn(`⚠️ Skipped ${p.name}: ${e.message}`);
        }
    }

    await browser.close();
    console.log(`\n🎉 ${count} screenshot berhasil diambil & disimpan di: ${SCREENSHOT_DIR}`);
}

takeScreenshots().catch(console.error);
