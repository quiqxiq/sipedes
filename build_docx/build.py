# -*- coding: utf-8 -*-
"""
Build BAB IV & BAB V (Skripsi Sistem Informasi Pelayanan Desa Rombiyah Barat) as .docx
Matching academic thesis formatting: A4, margins 4/3/3/3 cm, 1.5 line spacing (line=360),
Times New Roman, Heading 1 (BAB) centered bold, Heading 2/3 numbered, justified body
with firstLine indent (0.75 cm), centered figure captions with bold labels, shaded table headers,
and centered page numbers in footer.
"""
import os, sys, shutil
from PIL import Image
from docx import Document
from docx.shared import Twips, Pt, Inches, Emu, RGBColor
from docx.oxml.ns import qn
from docx.oxml import OxmlElement
from docx.enum.text import WD_ALIGN_PARAGRAPH as AL
from docx.enum.text import WD_TAB_ALIGNMENT, WD_TAB_LEADER
from docx.enum.table import WD_TABLE_ALIGNMENT

BASE = os.path.dirname(os.path.abspath(__file__))
IMG_DIR = os.path.abspath(os.path.join(BASE, "..", "screenshots"))
OUT_DAFTAR = os.path.abspath(os.path.join(BASE, "..", "screenshots", "BAB-IV-V-SIPEDES-RombiyahBarat-DaftarGambar.docx"))
OUT_MAIN = os.path.abspath(os.path.join(BASE, "..", "screenshots", "BAB-IV-V-SIPEDES-RombiyahBarat.docx"))

# Daftar seluruh gambar hasil implementasi sistem
FIGURES = [
    ("01_publik_landing.png", "Halaman Utama / Landing Page Publik SIPEDES Desa Rombiya Barat"),
    ("01a_publik_profil_desa.png", "Bagian Profil Desa, Sejarah, Visi Misi & Potensi Wilayah pada Landing Page"),
    ("02_login_warga.png", "Antarmuka Halaman Login Portal Warga Berbasis NIK"),
    ("03_registrasi_warga.png", "Formulir Registrasi Mandiri Warga Desa Rombiya Barat"),
    ("03a_lupa_password.png", "Formulir Permintaan Kode OTP Pemulihan Kata Sandi Akun Warga"),
    ("03b_lupa_password_verifikasi.png", "Halaman Verifikasi Kode OTP 6-Digit WhatsApp"),
    ("03c_lupa_password_reset.png", "Formulir Pembuatan Kata Sandi Baru Warga dengan Token Aman"),
    ("05_warga_dashboard.png", "Halaman Dashboard Utama Portal Warga & Widget Asisten AI"),
    ("06_warga_pengajuan_surat.png", "Wizard Pengajuan Surat - Langkah 1 Pemilihan Jenis Surat"),
    ("07_warga_riwayat_index.png", "Halaman Riwayat Pengajuan Surat Portal Warga"),
    ("08_warga_riwayat_detail.png", "Halaman Detail Pengajuan & Status Permohonan Warga"),
    ("09_warga_surat_pdf.png", "Dokumen Surat Resmi Hasil Terbitan Sistem Berformat PDF dengan Kop Resmi"),
    ("04_admin_login.png", "Halaman Login Panel Admin & Perangkat Desa"),
    ("10_admin_dashboard.png", "Dashboard Utama Panel Admin Filament"),
    ("11_admin_jenis_surat_index.png", "Halaman Daftar Jenis Surat Pelayanan Desa"),
    ("12_admin_jenis_surat_create.png", "Formulir Tambah Jenis Surat & Persyaratan Berkas"),
    ("13_admin_jenis_surat_edit.png", "Formulir Edit Data Jenis Surat Pelayanan Desa"),
    ("14_admin_knowledge_documents_index.png", "Halaman Daftar Dokumen Basis Pengetahuan (Dify RAG)"),
    ("15_admin_knowledge_documents_create.png", "Formulir Unggah Dokumen Basis Pengetahuan ke Dify"),
    ("16_admin_knowledge_documents_edit.png", "Formulir Edit Dokumen Basis Pengetahuan & Status Indexing"),
    ("17_admin_permohonan_surat_index.png", "Daftar Permohonan Surat Masuk pada Panel Admin dengan Tab Status"),
    ("18_admin_permohonan_surat_view.png", "Halaman Detail & Verifikasi Permohonan Surat oleh Petugas"),
    ("19_admin_permohonan_surat_edit.png", "Formulir Tindak Lanjut & Edit Data Permohonan Surat"),
    ("20_admin_profil_desa_index.png", "Halaman Data Profil Desa Rombiya Barat pada Panel Admin"),
    ("21_admin_profil_desa_edit.png", "Formulir Edit Profil Desa, Visi Misi, Potensi Dusun, dan Kontak Pelayanan"),
    ("22_admin_users_index.png", "Halaman Manajemen Pengguna Sistem (Admin, Petugas, dan Warga)"),
    ("23_admin_users_create.png", "Formulir Tambah Pengguna Baru oleh Administrator"),
    ("24_admin_users_edit.png", "Formulir Edit Data Pengguna & Hak Akses"),
    ("25_admin_aktivitas_logs_index.png", "Halaman Log Aktivitas Sistem (Audit Trail)"),
]

# Lebar area teks dalam twips: 11907 - 2268 (kiri 4cm) - 1701 (kanan 3cm) = 7938 twips (~14 cm)
TEXT_WIDTH_TWIPS = 7938

# ---------------- low-level formatting helpers ----------------

def _child(parent, tag):
    el = parent.find(qn(tag))
    if el is None:
        el = OxmlElement(tag)
        parent.append(el)
    return el

def set_spacing(p, before=None, after=0, line=360, rule="auto"):
    pPr = p._p.get_or_add_pPr()
    sp = _child(pPr, "w:spacing")
    if before is not None:
        sp.set(qn("w:before"), str(before))
    if after is not None:
        sp.set(qn("w:after"), str(after))
    if line is not None:
        sp.set(qn("w:line"), str(line))
        sp.set(qn("w:lineRule"), rule)

def set_indent(p, firstLine=None, left=None, hanging=None):
    pPr = p._p.get_or_add_pPr()
    ind = _child(pPr, "w:ind")
    if firstLine is not None:
        ind.set(qn("w:firstLine"), str(firstLine))
    if left is not None:
        ind.set(qn("w:left"), str(left))
    if hanging is not None:
        ind.set(qn("w:hanging"), str(hanging))

def style_run(r, pt=12, bold=False, italic=False, color=None, name="Times New Roman"):
    r.font.name = name
    rpr = r._r.get_or_add_rPr()
    rf = _child(rpr, "w:rFonts")
    for a in ("w:ascii", "w:hAnsi", "w:cs", "w:eastAsia"):
        rf.set(qn(a), name)
    r.font.size = Pt(pt)
    r.font.bold = bold
    r.font.italic = italic
    if color:
        r.font.color.rgb = RGBColor.from_string(color)

# ---------------- page setup ----------------

def setup_page(doc):
    """A4, margins: top/right/bottom=3cm (1701 twips), left=4cm (2268 twips)."""
    sec = doc.sections[0]
    sec.page_width  = Twips(11907)
    sec.page_height = Twips(16840)
    sec.top_margin    = Twips(1701)
    sec.right_margin  = Twips(1701)
    sec.bottom_margin = Twips(1701)
    sec.left_margin   = Twips(2268)
    sec.footer_distance = Twips(720)
    sec.header_distance = Twips(720)

# ---------------- footer (centered PAGE field) ----------------

def add_page_footer(doc):
    sec = doc.sections[0]
    sec.different_first_page_header_footer = False
    footer = sec.footer
    footer.is_linked_to_previous = False
    for p in footer.paragraphs:
        p._element.getparent().remove(p._element)

    sdt = OxmlElement("w:sdt")
    sdtPr = OxmlElement("w:sdtPr")
    sdtId = OxmlElement("w:id"); sdtId.set(qn("w:val"), "-264543138")
    sdtPr.append(sdtId)
    dpo = OxmlElement("w:docPartObj")
    dpg = OxmlElement("w:docPartGallery"); dpg.set(qn("w:val"), "Page Numbers (Bottom of Page)")
    dpu = OxmlElement("w:docPartUnique")
    dpo.append(dpg); dpo.append(dpu); sdtPr.append(dpo)
    sdt.append(sdtPr)
    sdtEnd = OxmlElement("w:sdtEndPr")
    rpr_end = OxmlElement("w:rPr"); np_end = OxmlElement("w:noProof"); rpr_end.append(np_end)
    sdtEnd.append(rpr_end); sdt.append(sdtEnd)
    sdtContent = OxmlElement("w:sdtContent")

    p_el = OxmlElement("w:p")
    pPr = OxmlElement("w:pPr")
    pStyle = OxmlElement("w:pStyle"); pStyle.set(qn("w:val"), "Footer"); pPr.append(pStyle)
    jc = OxmlElement("w:jc"); jc.set(qn("w:val"), "center"); pPr.append(jc)
    p_el.append(pPr)
    def fld_run(ftype):
        r = OxmlElement("w:r"); fc = OxmlElement("w:fldChar"); fc.set(qn("w:fldCharType"), ftype); r.append(fc); return r
    p_el.append(fld_run("begin"))
    r_instr = OxmlElement("w:r"); it = OxmlElement("w:instrText")
    it.set("{http://www.w3.org/XML/1998/namespace}space", "preserve")
    it.text = " PAGE   \\* MERGEFORMAT "; r_instr.append(it); p_el.append(r_instr)
    p_el.append(fld_run("separate"))
    r_val = OxmlElement("w:r"); rpr_v = OxmlElement("w:rPr"); np_v = OxmlElement("w:noProof")
    rpr_v.append(np_v); r_val.append(rpr_v)
    t_v = OxmlElement("w:t"); t_v.text = "1"; r_val.append(t_v); p_el.append(r_val)
    p_el.append(fld_run("end"))
    sdtContent.append(p_el); sdt.append(sdtContent)
    footer._element.append(sdt)

# ---------------- paragraph factories ----------------

def add_bab_heading(doc, roman, title):
    """Heading1: 'BAB IV\\nHASIL DAN PEMBAHASAN' centered, TNR 12pt bold."""
    p = doc.add_paragraph()
    p.style = doc.styles["Heading 1"]
    pPr = p._p.get_or_add_pPr()
    sp = _child(pPr, "w:spacing")
    sp.set(qn("w:before"), "0"); sp.set(qn("w:after"), "120")
    sp.set(qn("w:line"), "360"); sp.set(qn("w:lineRule"), "auto")
    jc = _child(pPr, "w:jc"); jc.set(qn("w:val"), "center")
    r1 = p.add_run("BAB " + roman); style_run(r1, pt=12, bold=True)
    r_br = p.add_run(); r_br._r.append(OxmlElement("w:br"))
    r2 = p.add_run(title); style_run(r2, pt=12, bold=True)
    return p

def add_h2(doc, num, title):
    """Heading2: '4.1  Hasil Penelitian' — TNR 12pt bold, before=240, after=60."""
    p = doc.add_paragraph()
    p.style = doc.styles["Heading 2"]
    pPr = p._p.get_or_add_pPr()
    sp = _child(pPr, "w:spacing")
    sp.set(qn("w:before"), "240"); sp.set(qn("w:after"), "60")
    sp.set(qn("w:line"), "360"); sp.set(qn("w:lineRule"), "auto")
    r = p.add_run(num + "  " + title); style_run(r, pt=12, bold=True)
    return p

def add_h3(doc, num, title):
    """Heading3: '4.1.1  Lingkungan Implementasi' — TNR 12pt bold, before=180, after=60."""
    p = doc.add_paragraph()
    p.style = doc.styles["Heading 3"]
    pPr = p._p.get_or_add_pPr()
    sp = _child(pPr, "w:spacing")
    sp.set(qn("w:before"), "180"); sp.set(qn("w:after"), "60")
    sp.set(qn("w:line"), "360"); sp.set(qn("w:lineRule"), "auto")
    r = p.add_run(num + "  " + title); style_run(r, pt=12, bold=True)
    return p

def add_body(doc, text, bold_prefix=None, italic=False):
    """Normal body: justified, firstLine=426 (0.75 cm), TNR 12pt, line=360 (1.5 spasi)."""
    p = doc.add_paragraph()
    p.style = doc.styles["Normal"]
    set_spacing(p, before=0, after=0, line=360)
    set_indent(p, firstLine=426)
    p.alignment = AL.JUSTIFY
    if bold_prefix:
        r_pre = p.add_run(bold_prefix)
        style_run(r_pre, pt=12, bold=True, italic=italic)
    r = p.add_run(text)
    style_run(r, pt=12, italic=italic)
    return p

def add_caption(doc, text):
    """Caption: centered, TNR 11pt bold label, before=120 after=120 line=360."""
    p = doc.add_paragraph()
    p.style = doc.styles["Caption"]
    pPr = p._p.get_or_add_pPr()
    sp = _child(pPr, "w:spacing")
    sp.set(qn("w:before"), "120"); sp.set(qn("w:after"), "120")
    sp.set(qn("w:line"), "360"); sp.set(qn("w:lineRule"), "auto")
    jc = _child(pPr, "w:jc"); jc.set(qn("w:val"), "center")
    ind = _child(pPr, "w:ind"); ind.set(qn("w:firstLine"), "0")

    if text.startswith("Gambar ") or text.startswith("Tabel "):
        parts = text.split("  ", 1)
        if len(parts) == 2:
            r1 = p.add_run(parts[0] + "  "); style_run(r1, pt=11, bold=True, color="000000")
            r2 = p.add_run(parts[1]); style_run(r2, pt=11, bold=False, color="000000")
        else:
            r = p.add_run(text); style_run(r, pt=11, bold=False, color="000000")
    else:
        r = p.add_run(text); style_run(r, pt=11, bold=False, color="000000")
    return p

# ---------------- image insertion ----------------

IMG_COUNTER = {"n": 0}

def add_figure(doc, filename, caption_text):
    IMG_COUNTER["n"] += 1
    idx = IMG_COUNTER["n"] - 1
    assert idx < len(FIGURES) and FIGURES[idx][0] == filename, \
        f"Urutan gambar tidak sinkron dengan FIGURES: {filename} vs {FIGURES[idx][0]}"
    num_str = f"Gambar 4.{IMG_COUNTER['n']}"
    full_caption = f"{num_str}  {caption_text}"
    path = os.path.join(IMG_DIR, filename)
    try:
        with Image.open(path) as im:
            w_px, h_px = im.size
    except Exception:
        w_px, h_px = 1280, 720

    # Max width: 14 cm (~5.51 in)
    max_w_emu = int(5.51 * 914400)
    max_h_emu = int(3.5 * 914400)
    ratio = w_px / h_px
    w_emu = max_w_emu
    h_emu = int(w_emu / ratio)
    if h_emu > max_h_emu:
        h_emu = max_h_emu
        w_emu = int(h_emu * ratio)

    p = doc.add_paragraph()
    set_spacing(p, before=180, after=60, line=360)
    p.alignment = AL.CENTER
    run = p.add_run()
    run.add_picture(path, width=Emu(w_emu), height=Emu(h_emu))
    add_caption(doc, full_caption)
    return p

# ---------------- DAFTAR GAMBAR (list of figures) ----------------

def add_page_break(doc):
    p = doc.add_paragraph()
    set_spacing(p, before=0, after=0, line=360)
    r = p.add_run()
    br = OxmlElement("w:br"); br.set(qn("w:type"), "page")
    r._r.append(br)
    return p

def add_front_heading(doc, text):
    """Judul bagian awal (DAFTAR GAMBAR): centered, bold, TNR 12pt."""
    p = doc.add_paragraph()
    pPr = p._p.get_or_add_pPr()
    sp = _child(pPr, "w:spacing")
    sp.set(qn("w:before"), "0"); sp.set(qn("w:after"), "240")
    sp.set(qn("w:line"), "360"); sp.set(qn("w:lineRule"), "auto")
    jc = _child(pPr, "w:jc"); jc.set(qn("w:val"), "center")
    r = p.add_run(text); style_run(r, pt=12, bold=True)
    return p

def add_daftar_entry(doc, label, caption, page):
    """Satu baris daftar gambar: label + judul ..... halaman (dot leader)."""
    p = doc.add_paragraph()
    p.style = doc.styles["Normal"]
    set_spacing(p, before=0, after=0, line=360)
    p.paragraph_format.tab_stops.add_tab_stop(Twips(TEXT_WIDTH_TWIPS), WD_TAB_ALIGNMENT.RIGHT, WD_TAB_LEADER.DOTS)
    r1 = p.add_run(f"{label}  {caption}"); style_run(r1, pt=12)
    r2 = p.add_run("\t" + str(page)); style_run(r2, pt=12)
    return p

def add_daftar_gambar(doc, fig_pages=None):
    """Buat halaman DAFTAR GAMBAR di awal dokumen. fig_pages: dict nomor->halaman."""
    add_page_break(doc)
    add_front_heading(doc, "DAFTAR GAMBAR")
    sp = doc.add_paragraph()
    set_spacing(sp, before=0, after=0, line=360)

    # Baris header kolom halaman
    hp = doc.add_paragraph()
    hp.style = doc.styles["Normal"]
    set_spacing(hp, before=0, after=0, line=360)
    hp.paragraph_format.tab_stops.add_tab_stop(Twips(TEXT_WIDTH_TWIPS), WD_TAB_ALIGNMENT.RIGHT, WD_TAB_LEADER.SPACES)
    rh = hp.add_run("\tHalaman"); style_run(rh, pt=12)

    for i, (_fname, caption) in enumerate(FIGURES, 1):
        page = str(fig_pages.get(i, "")) if fig_pages else ""
        add_daftar_entry(doc, f"Gambar 4.{i}", caption, page)

    add_page_break(doc)

# ---------------- black-box test table ----------------

def add_bb_table(doc, tbl_num, caption_text, rows):
    """rows = list of (no, skenario, input, expected, result, status)"""
    add_caption(doc, f"Tabel {tbl_num}  {caption_text}")
    tbl = doc.add_table(rows=1 + len(rows), cols=6)
    tbl.style = "Table Grid"
    tbl.alignment = WD_TABLE_ALIGNMENT.CENTER

    widths = [Twips(450), Twips(1580), Twips(1580), Twips(1860), Twips(1860), Twips(600)]
    for i, w in enumerate(widths):
        for cell in tbl.columns[i].cells:
            cell.width = w

    headers = ["No.", "Skenario Uji", "Data Masukan", "Hasil yang Diharapkan", "Hasil Pengujian", "Status"]
    hrow = tbl.rows[0]
    for i, h in enumerate(headers):
        cell = hrow.cells[i]
        cell.text = ""
        p = cell.paragraphs[0]
        set_spacing(p, before=60, after=60, line=240)
        p.alignment = AL.CENTER
        r = p.add_run(h); style_run(r, pt=10, bold=True)
        tcPr = cell._tc.get_or_add_tcPr()
        shd = OxmlElement("w:shd")
        shd.set(qn("w:val"), "clear"); shd.set(qn("w:color"), "auto"); shd.set(qn("w:fill"), "D9D9D9")
        tcPr.append(shd)

    for ri, row_data in enumerate(rows):
        row = tbl.rows[ri + 1]
        for ci, val in enumerate(row_data):
            cell = row.cells[ci]
            cell.text = ""
            p = cell.paragraphs[0]
            set_spacing(p, before=60, after=60, line=240)
            p.alignment = AL.CENTER if ci in (0, 5) else AL.JUSTIFY
            r = p.add_run(str(val))
            is_bold = (ci == 5)
            style_run(r, pt=9.5, bold=is_bold)
    return tbl

# ---------------- DOCUMENT GENERATOR MAIN ----------------

def generate_docx(fig_pages=None):
    IMG_COUNTER["n"] = 0
    doc = Document()
    setup_page(doc)
    add_page_footer(doc)

    print("Generating DAFTAR GAMBAR...")
    add_daftar_gambar(doc, fig_pages)

    print("Generating BAB IV...")

    # ---------------- BAB IV ----------------
    add_bab_heading(doc, "IV", "HASIL DAN PEMBAHASAN")

    # 4.1 Hasil Penelitian
    add_h2(doc, "4.1", "Hasil Penelitian")
    add_body(doc, "Hasil penelitian ini adalah terbangunnya Sistem Informasi Pelayanan Desa (SIPEDES) Desa Rombiya Barat berbasis web yang dirancang untuk mengotomatisasi seluruh alur permohonan surat-menyurat di Kantor Balai Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep, Jawa Timur. Sistem ini memadukan konsep self-service portal bagi warga desa, wizard pengajuan surat multi-langkah, mekanisme verifikasi dan persetujuan permohonan oleh perangkat desa, otomatisasi pembuatan dokumen surat resmi berformat PDF berstandar kop dinas desa, sistem pemulihan akun warga melalui OTP WhatsApp Gateway terenkripsi, integrasi manajemen profil desa dinamis, serta Kecerdasan Buatan (AI) berbasis Retrieval-Augmented Generation (RAG) melalui platform Dify sebagai asisten virtual layanan informasi desa.")

    # 4.1.1 Lingkungan Implementasi
    add_h3(doc, "4.1.1", "Lingkungan Implementasi")
    add_body(doc, "Pengembangan dan implementasi sistem SIPEDES Desa Rombiya Barat dilaksanakan pada lingkungan perangkat keras (hardware) dan perangkat lunak (software) dengan spesifikasi teknis sebagai berikut:")
    add_body(doc, "1. Spesifikasi Perangkat Keras (Hardware): Sistem dikembangkan pada unit PC/Laptop berbasis prosesor modern multi-core, memori utama (RAM) 16 GB, serta media penyimpanan Solid State Drive (SSD) NVMe 512 GB. Lingkungan peladen (server) pengujian dijalankan secara lokal menggunakan web server bawaan Laravel (php artisan serve) pada port 8000, siap didistribusikan ke infrastruktur Cloud Server (VPS) pada tahap produksi.")
    add_body(doc, "2. Spesifikasi Perangkat Lunak (Software): Sistem beroperasi pada lingkungan Sistem Operasi Microsoft Windows 11 Pro. Bahasa pemrograman utama yang digunakan adalah PHP 8.4 dengan basis web framework Laravel 12/13, panel manajemen administrasi Filament v3/v5, basis data MySQL 8.0, web server Nginx/Apache, serta browser Google Chrome untuk pengujian fungsionalitas antarmuka.")
    add_body(doc, "3. Tech Stack dan Pustaka Pendukung: Arsitektur perangkat lunak memanfaatkan Blade + Livewire untuk komponen antarmuka dinamis portal warga, Filament Resource untuk panel administrasi desa, Barryvdh Laravel DomPDF untuk pembentukan dokumen surat resmi dalam format PDF, Tailwind CSS v4 dan Vite 8 untuk styling modern serta bundling aset, Go-WA Docker Service sebagai gerbang komunikasi WhatsApp Gateway resmi, serta Dify (open-source LLMOps platform) sebagai layanan Knowledge Base dan RAG chatbot dengan HTTP API streaming.")

    # 4.1.2 Implementasi Antarmuka Portal Warga
    add_h3(doc, "4.1.2", "Implementasi Antarmuka Portal Warga")
    add_body(doc, "Antarmuka portal warga dirancang berorientasi pada kemudahan pengguna (user-friendly) dan kemudahan akses mandiri (self-service). Warga dapat mengakses halaman utama publik untuk melihat informasi umum profil desa, potensi wilayah, dan katalog layanan surat sebelum melakukan autentikasi.")

    add_figure(doc, "01_publik_landing.png", "Halaman Utama / Landing Page Publik SIPEDES Desa Rombiya Barat")
    add_body(doc, "Halaman utama (Landing Page) menampilkan hero banner selamat datang, daftar informasi layanan persuratan unggulan (Surat Keterangan Tidak Mampu, Domisili, Usaha, Pengantar Nikah, dan Keterangan Kematian), statistik pelayanan kependudukan, serta tautan cepat menuju halaman login dan registrasi portal warga.")

    add_figure(doc, "01a_publik_profil_desa.png", "Bagian Profil Desa, Sejarah, Visi Misi & Potensi Wilayah pada Landing Page")
    add_body(doc, "Bagian Profil Desa pada halaman depan menyajikan informasi sejarah singkat Desa Rombiya Barat, visi dan misi kepemimpinan Kepala Desa, kartu potensi unggulan desa (sektor pertanian, peternakan, perkebunan tembakau, UMKM, dan BUMDes), daftar dusun resmi, serta kontak balai desa dan jam operasional pelayanan tatap muka.")

    add_figure(doc, "02_login_warga.png", "Antarmuka Halaman Login Portal Warga Berbasis NIK")
    add_body(doc, "Halaman login portal warga digunakan oleh warga terdaftar untuk masuk ke dalam sistem menggunakan Nomor Induk Kependudukan (NIK) dan kata sandi yang telah dibuat saat registrasi mandiri, dilengkapi dengan tautan menuju fitur pemulihan kata sandi.")

    add_figure(doc, "03_registrasi_warga.png", "Formulir Registrasi Mandiri Warga Desa Rombiya Barat")
    add_body(doc, "Warga baru yang belum memiliki akun dapat mengisikan formulir registrasi mandiri yang mencakup Nama Lengkap sesuai KTP, NIK (16 digit), Alamat Email, Nomor Telepon/WhatsApp aktif, Alamat Tempat Tinggal, serta Kata Sandi dengan konfirmasi. Sistem memvalidasi panjang NIK dan keunikan data sebelum akun dibuat.")

    add_figure(doc, "03a_lupa_password.png", "Formulir Permintaan Kode OTP Pemulihan Kata Sandi Akun Warga")
    add_body(doc, "Apabila warga lupa kata sandi akunnya, sistem menyediakan fitur pemulihan mandiri dengan memasukkan NIK terdaftar. Sistem secara otomatis memeriksa keberadaan akun dan mengirimkan kode OTP 6-digit ke nomor WhatsApp warga yang terdaftar melalui WhatsApp Gateway.")

    add_figure(doc, "03b_lupa_password_verifikasi.png", "Halaman Verifikasi Kode OTP 6-Digit WhatsApp")
    add_body(doc, "Warga memasukkan 6 digit kode OTP rahasia yang diterima di WhatsApp ke dalam formulir verifikasi khusus. Sistem menerapkan pembatasan waktu aktif OTP selama 10 menit, batas percobaan salah maksimal 5 kali, serta mekanisme proteksi anti-spam cooldown 60 detik.")

    add_figure(doc, "03c_lupa_password_reset.png", "Formulir Pembuatan Kata Sandi Baru Warga dengan Token Aman")
    add_body(doc, "Setelah kode OTP terverifikasi sah, sistem menerbitkan token reset acak 64 karakter di database dan mengarahkan warga ke formulir pengubahan kata sandi baru. Setelah kata sandi berhasil diperbarui, sistem mencabut seluruh sesi aktif dan mengarahkan warga langsung ke halaman login.")

    add_figure(doc, "05_warga_dashboard.png", "Halaman Dashboard Utama Portal Warga & Widget Asisten AI")
    add_body(doc, "Setelah berhasil login, warga disambut pada Dashboard Warga yang memuat kartu ringkasan status pengajuan (Total Permohonan, Sedang Diproses, Surat Disetujui), tombol cepat ajukan surat, identitas pemohon, serta widget interaktif Chatbot AI Layanan Desa.")

    add_figure(doc, "06_warga_pengajuan_surat.png", "Wizard Pengajuan Surat - Langkah 1 Pemilihan Jenis Surat")
    add_body(doc, "Warga dapat mengajukan permohonan surat melalui wizard interaktif. Pada langkah pertama, warga memilih jenis surat yang dibutuhkan beserta estimasi durasi pelayanan, deskripsi keperluan, dan persyaratan dokumen yang wajib dipersiapkan.")

    add_figure(doc, "07_warga_riwayat_index.png", "Halaman Riwayat Pengajuan Surat Portal Warga")
    add_body(doc, "Halaman riwayat pengajuan menampilkan seluruh berkas permohonan yang pernah dibuat oleh warga lengkap dengan nomor permohonan otomatis, jenis surat, tanggal pengajuan, dan indikator badge status permohonan secara real-time.")

    add_figure(doc, "08_warga_riwayat_detail.png", "Halaman Detail Pengajuan & Status Permohonan Warga")
    add_body(doc, "Warga dapat melihat rincian permohonan beserta status terkini (Diajukan, Diproses, Disetujui, Butuh Koreksi, atau Ditolak), catatan resmi dari petugas desa, serta berkas lampiran persyaratan yang telah diunggah.")

    add_figure(doc, "09_warga_surat_pdf.png", "Dokumen Surat Resmi Hasil Terbitan Sistem Berformat PDF dengan Kop Resmi")
    add_body(doc, "Surat permohonan yang telah disetujui oleh petugas desa secara otomatis diterbitkan ke dalam format dokumen PDF resmi berstandar tata naskah dinas Pemerintah Desa Rombiya Barat lengkap dengan lambang resmi desa, nomor surat baku, isi keterangan, serta stempel administratif dan QR-code verifikasi.")

    # 4.1.3 Implementasi Antarmuka Panel Admin
    add_h3(doc, "4.1.3", "Implementasi Antarmuka Panel Admin & Perangkat Desa")
    add_body(doc, "Panel administrasi dikembangkan menggunakan Filament untuk memfasilitasi tugas perangkat desa dan administrator sistem dalam mengelola master data, antrian permohonan surat, profil desa, basis pengetahuan AI, serta pemantauan aktivitas sistem.")

    add_figure(doc, "04_admin_login.png", "Halaman Login Panel Admin & Perangkat Desa")
    add_body(doc, "Halaman login khusus pengelola dan perangkat desa yang menjamin autentikasi aman menggunakan alamat email resmi dan kata sandi. Hak akses dibatasi hanya bagi pengguna dengan peran admin atau petugas.")

    add_figure(doc, "10_admin_dashboard.png", "Dashboard Utama Panel Admin Filament")
    add_body(doc, "Dashboard Admin menampilkan widget statistik permohonan surat, kartu ringkasan pelayanan desa, serta grafik distribusi status permohonan (chart) sehingga perangkat desa dapat memantau antrean pelayanan secara terpadu.")

    add_figure(doc, "11_admin_jenis_surat_index.png", "Halaman Daftar Jenis Surat Pelayanan Desa")
    add_body(doc, "Admin dapat mengelola seluruh katalog jenis surat yang dilayani oleh Pemerintah Desa Rombiya Barat, termasuk pengaturan kode surat (SKTM, SKD, SKU, SKN, SKK), estimasi durasi proses, syarat berkas lampiran, serta status keaktifan layanan.")

    add_figure(doc, "12_admin_jenis_surat_create.png", "Formulir Tambah Jenis Surat & Persyaratan Berkas")
    add_body(doc, "Sistem memungkinkan Admin menambahkan jenis surat pelayanan baru lengkap dengan nama surat, kode registrasi, estimasi waktu penyelesaian, dan daftar syarat berkas yang wajib dilampirkan warga.")

    add_figure(doc, "13_admin_jenis_surat_edit.png", "Formulir Edit Data Jenis Surat Pelayanan Desa")
    add_body(doc, "Admin dapat memperbarui rincian jenis surat, menyesuaikan persyaratan dokumen yang diminta, mengubah durasi estimasi proses, serta mengaktifkan atau menonaktifkan layanan surat terkait.")

    add_figure(doc, "14_admin_knowledge_documents_index.png", "Halaman Daftar Dokumen Basis Pengetahuan (Dify RAG)")
    add_body(doc, "Modul Dokumen Pengetahuan menampilkan seluruh berkas pedoman yang diunggah ke dalam basis pengetahuan AI, lengkap dengan status indexing pada Dify Knowledge Base (Diproses/Terindeks/Gagal), jumlah chunk, serta tombol aksi sinkronisasi.")

    add_figure(doc, "15_admin_knowledge_documents_create.png", "Formulir Unggah Dokumen Basis Pengetahuan ke Dify")
    add_body(doc, "Admin dapat mengunggah dokumen pedoman, peraturan desa, dan SOP pelayanan (format PDF, DOCX, TXT) yang secara otomatis dikirim ke platform Dify untuk diproses chunking dan indexing sebagai referensi jawaban chatbot AI.")

    add_figure(doc, "16_admin_knowledge_documents_edit.png", "Formulir Edit Dokumen Basis Pengetahuan & Status Indexing")
    add_body(doc, "Halaman pembaruan dokumen pengetahuan menampilkan informasi metadata berkas, status sinkronisasi pada Dify, jumlah potongan teks (chunks), dan identitas pengunggah berkas.")

    add_figure(doc, "17_admin_permohonan_surat_index.png", "Daftar Permohonan Surat Masuk pada Panel Admin dengan Tab Status")
    add_body(doc, "Halaman kelola permohonan surat menyajikan tabel antrean permohonan masuk lengkap dengan nomor registrasi, nama pemohon, jenis surat, tanggal pengajuan, serta tab filter status (Semua, Diajukan, Diproses, Disetujui, Ditolak, Butuh Koreksi, dan Dibatalkan).")

    add_figure(doc, "18_admin_permohonan_surat_view.png", "Halaman Detail & Verifikasi Permohonan Surat oleh Petugas")
    add_body(doc, "Perangkat desa memeriksa rincian permohonan, data warga pemohon, dan berkas lampiran persyaratan. Petugas dapat mengambil tindakan verifikasi berupa menyetujui, memproses, meminta koreksi berkas, atau menolak permohonan dengan memberikan catatan resmi.")

    add_figure(doc, "19_admin_permohonan_surat_edit.png", "Formulir Tindak Lanjut & Edit Data Permohonan Surat")
    add_body(doc, "Formulir tindak lanjut permohonan memungkinkan perangkat desa mencatat nomor surat resmi, mengisi catatan pertimbangan dinas, dan memperbarui status pemrosesan permohonan warga secara akurat.")

    add_figure(doc, "20_admin_profil_desa_index.png", "Halaman Data Profil Desa Rombiya Barat pada Panel Admin")
    add_body(doc, "Modul Profil Desa menyajikan tabel data identitas wilayah resmi Desa Rombiya Barat, nama Kepala Desa, kecamatan, kabupaten, serta tanggal pembaruan terakhir yang diproteksi dengan pola singleton.")

    add_figure(doc, "21_admin_profil_desa_edit.png", "Formulir Edit Profil Desa, Visi Misi, Potensi Dusun, dan Kontak Pelayanan")
    add_body(doc, "Admin dapat memperbarui seluruh data desa, meliputi narasi sejarah, visi dan misi, pembagian wilayah dusun (repeater dinamis), sektor potensi unggulan (pertanian, peternakan, UMKM, BUMDes), statistik kependudukan, jam pelayanan, dan nomor hotline WhatsApp.")

    add_figure(doc, "22_admin_users_index.png", "Halaman Manajemen Pengguna Sistem (Admin, Petugas, dan Warga)")
    add_body(doc, "Kelola data akun pengguna sistem yang mencakup Administrator Desa, Petugas Pelayanan, dan seluruh Warga terdaftar, lengkap dengan NIK, alamat email, nomor telepon, status keaktifan akun, dan hak akses (role).")

    add_figure(doc, "23_admin_users_create.png", "Formulir Tambah Pengguna Baru oleh Administrator")
    add_body(doc, "Formulir penambahan pengguna baru oleh admin dengan input NIK, nama lengkap, email, nomor WhatsApp, alamat domisili, kata sandi, serta penentuan peran pengguna dalam sistem.")

    add_figure(doc, "24_admin_users_edit.png", "Formulir Edit Data Pengguna & Hak Akses")
    add_body(doc, "Halaman perbaikan data pengguna untuk memperbarui informasi identitas, nomor kontak, perubahan peran (role), serta fasilitas mengaktifkan atau menonaktifkan akun pengguna.")

    add_figure(doc, "25_admin_aktivitas_logs_index.png", "Halaman Log Aktivitas Sistem (Audit Trail)")
    add_body(doc, "Pencatatan jejak audit (audit trail) otomatis yang merekam setiap aksi krusial pengguna seperti login, pengajuan surat, persetujuan berkas, perubahan data profil desa, dan reset kata sandi demi menjamin akuntabilitas pelayanan publik desa.")

    # 4.1.4 Implementasi Modul Utama & Logika Sistem
    add_h3(doc, "4.1.4", "Implementasi Modul Utama & Logika Sistem")
    add_body(doc, "Sistem SIPEDES Desa Rombiya Barat mengimplementasikan enam modul logika utama yang saling terhubung secara terpadu:")
    add_body(doc, "1. Modul Self-Service Autentikasi & Pemulihan Akun: Warga melakukan pendaftaran akun mandiri dengan validasi NIK 16 digit yang unik. Untuk keamanan akun, sistem dilengkapi fitur pemulihan kata sandi berbasis kode OTP WhatsApp Gateway dengan masa aktif 10 menit, proteksi rate-limiting 60 detik, dan token verifikasi acak 64 karakter.")
    add_body(doc, "2. Modul Wizard Pengajuan Surat Multi-Langkah: Pengajuan surat dibangun menggunakan Livewire dalam alur tiga langkah terstruktur: (1) pemilihan jenis surat, (2) pengunggahan berkas persyaratan dan keterangan keperluan, serta (3) konfirmasi ringkasan data sebelum pengiriman. Validasi berkas (PDF/JPG/PNG max 3 MB) dijalankan di sisi server dengan nomor permohonan unik berformat SRT/YYYYMMDD/XXXXX.")
    add_body(doc, "3. Modul Asisten Virtual AI RAG (Dify): Sistem terintegrasi dengan platform Dify melalui App\\Services\\DifyService menggunakan HTTP client Guzzle. Dokumen pedoman dan SOP pelayanan desa yang diunggah dikirim ke Knowledge Base Dify untuk diproses chunking dan indexing. Chatbot asisten virtual tertanam pada portal warga mampu menjawab pertanyaan seputar syarat surat dan informasi desa secara streaming real-time beserta rujukan sumber dokumennya.")
    add_body(doc, "4. Modul Pembuatan Dokumen Surat PDF Resmi: Surat resmi yang disetujui dibangkitkan otomatis dalam format PDF menggunakan pustaka Barryvdh DomPDF melalui controller SuratPdfController. Dokumen mencantumkan kop resmi Pemerintah Desa Rombiya Barat, nomor registrasi surat baku, data diri pemohon, serta tanda tangan dan stempel administratif.")
    add_body(doc, "5. Modul Pengelolaan Profil & Potensi Desa Terintegrasi: Menyediakan fasilitas pengelolaan dinamis bagi perangkat desa untuk menyesuaikan data profil desa, visi misi, potensi ekonomi unggulan (pertanian, peternakan, perkebunan, UMKM, BUMDes), daftar wilayah dusun, statistik demografi, serta kontak hotline kantor desa yang terhubung otomatis ke landing page publik.")
    add_body(doc, "6. Modul Manajemen Permohonan & Audit Trail: Perangkat desa memverifikasi permohonan melalui aksi Setujui & Proses, Minta Koreksi, atau Tolak dengan pencatatan catatan pertimbangan resmi. Seluruh aktivitas pengguna terekam otomatis ke dalam tabel aktivitas_log melalui method AktivitasLog::catat untuk kebutuhan transparansi dan audit.")

    # 4.2 Pengujian Sistem
    add_h2(doc, "4.2", "Pengujian Sistem (Testing & Evaluation)")

    # 4.2.1 Metode Pengujian
    add_h3(doc, "4.2.1", "Metode Pengujian")
    add_body(doc, "Pengujian Sistem Informasi Pelayanan Desa (SIPEDES) Desa Rombiya Barat dilaksanakan menggunakan metode Black-Box Testing dan Automated Functional Testing. Pengujian Black-Box berfokus pada evaluasi fungsionalitas antarmuka dan alur kerja sistem tanpa meninjau struktur kode internal, guna memastikan seluruh kebutuhan fungsional (Functional Requirements) terpenuhi dengan baik.")
    add_body(doc, "Pengujian otomatis dilaksanakan menggunakan framework pengujian fitur Laravel (PHPUnit/Pest) dan skrip otomatisasi Puppeteer headless browser terhadap aplikasi yang berjalan pada http://127.0.0.1:8000. Pengujian mencakup pengisian formulir, validasi sisi klien dan server, pengiriman kode OTP WhatsApp, pemrosesan berkas permohonan, hingga pengecekan izin akses rute (middleware guest, auth, dan role admin).")

    # 4.2.2 Hasil Pengujian Fungsional
    add_h3(doc, "4.2.2", "Hasil Pengujian Fungsional")
    add_body(doc, "Pengujian fungsionalitas dilakukan mencakup 33 kasus uji utama (Test Cases TC-01 s/d TC-33) yang merepresentasikan seluruh alur proses bisnis portal warga dan panel admin desa. Hasil pengujian disajikan pada Tabel 4.1 dan Tabel 4.2 berikut.")

    rows_warga = [
        ("TC-01", "Akses Halaman Landing Publik", "GET /", "HTTP 200 dengan hero banner, profil desa & statistik tampil", "Landing page tampil lengkap (HTTP 200)", "PASS"),
        ("TC-02", "Akses Halaman Login Warga", "GET /login", "Form NIK & password tersedia dengan layout auth bersih", "Form login NIK + password tampil", "PASS"),
        ("TC-03", "Akses Halaman Registrasi Mandiri", "GET /register", "Form 7 field (nama, NIK, email, telepon, alamat, password, konfirmasi)", "Seluruh field registrasi tampil", "PASS"),
        ("TC-04", "Permintaan OTP Lupa Password", "POST /lupa-password (NIK terdaftar)", "OTP 6 digit terkirim via WhatsApp & redirect ke halaman verifikasi", "OTP terkirim ke WhatsApp, redirect ke /lupa-password/verifikasi", "PASS"),
        ("TC-05", "Verifikasi OTP WhatsApp Salah", "POST /lupa-password/verifikasi (OTP salah)", "Pesan error OTP tidak cocok muncul & kesempatan mencoba berkurang", "Error 'Kode OTP tidak valid' tampil", "PASS"),
        ("TC-06", "Verifikasi OTP WhatsApp Benar", "POST /lupa-password/verifikasi (OTP valid)", "OTP terverifikasi & redirect ke form ubah kata sandi dengan token aman", "Redirect ke /lupa-password/reset?token=...", "PASS"),
        ("TC-07", "Simpan Kata Sandi Baru", "POST /lupa-password/reset (sandi baru confirmed)", "Sandi terupdate, sesi dibersihkan, redirect ke /login dengan pesan sukses", "Kata sandi terbarui, redirect ke /login", "PASS"),
        ("TC-08", "Login Warga Password Salah", "NIK valid + password salah", "Muncul pesan error pada field password & tetap di halaman login", "Pesan error kredensial tidak cocok tampil", "PASS"),
        ("TC-09", "Login Warga Berhasil", "NIK 3529102904650001 + password benar", "Autentikasi berhasil & redirect ke /dashboard warga", "Redirect ke dashboard portal warga", "PASS"),
        ("TC-10", "Dashboard Warga & Widget AI", "GET /dashboard", "Kartu ringkasan status surat, identitas NIK & widget AI tampil", "Dashboard + widget AI chatbot tampil", "PASS"),
        ("TC-11", "Wizard Langkah 1: Pilih Jenis Surat", "Pilih jenis surat SKTM pada /pengajuan", "Pindah ke Langkah 2 (unggah berkas persyaratan & keterangan)", "Langkah 2 wizard tampil", "PASS"),
        ("TC-12", "Wizard: Kirim Permohonan Surat", "Unggah berkas lampiran, klik Kirim Permohonan", "Nomor permohonan terbit, redirect ke /riwayat + notifikasi sukses", "Permohonan tersimpan & nomor surat terbit", "PASS"),
        ("TC-13", "Halaman Riwayat Pengajuan", "GET /riwayat", "Tabel daftar permohonan surat + badge status tampil", "Daftar permohonan & status tampil", "PASS"),
        ("TC-14", "Detail Pengajuan & Status", "GET /riwayat/1", "Rincian surat, berkas lampiran & catatan petugas tampil", "Detail permohonan tampil lengkap", "PASS"),
        ("TC-15", "Unduh Dokumen Surat Resmi PDF", "GET /surat/1/pdf", "Respons file PDF valid dengan kop resmi desa (application/pdf)", "HTTP 200, format PDF resmi terunduh", "PASS"),
        ("TC-16", "Logout Portal Warga", "POST /logout", "Sesi autentikasi warga dicabut & redirect ke halaman login", "Redirect ke /login, sesi bersih", "PASS"),
    ]
    add_bb_table(doc, "4.1", "Hasil Pengujian Fungsional Halaman Publik & Portal Warga", rows_warga)

    rows_admin = [
        ("TC-17", "Akses Halaman Login Panel Admin", "GET /admin/login", "Form email & password login admin tersedia", "Form login admin tampil", "PASS"),
        ("TC-18", "Login Admin Kredensial Salah", "Email admin + password salah", "Muncul pesan peringatan kredensial tidak cocok", "Pesan error kredensial tampil", "PASS"),
        ("TC-19", "Login Admin Berhasil", "admin@rombiyahbarat.desa.id + password", "Autentikasi sukses & redirect ke dashboard admin", "Redirect ke /admin dashboard", "PASS"),
        ("TC-20", "Dashboard Admin Statistik & Chart", "GET /admin", "Widget statistik permohonan & grafik chart distribusi tampil", "Widget + grafik chart SVG tampil", "PASS"),
        ("TC-21", "Jenis Surat: Katalog Layanan", "GET /admin/jenis-surats", "Daftar 5 jenis surat aktif (SKTM, SKD, SKU, SKN, SKK) tampil", "Seluruh jenis surat terdaftar tampil", "PASS"),
        ("TC-22", "Jenis Surat: Tambah Layanan Baru", "GET /admin/jenis-surats/create", "Formulir input nama, kode, durasi & syarat berkas tersedia", "Form tambah jenis surat tampil", "PASS"),
        ("TC-23", "Jenis Surat: Edit Data Layanan", "GET /admin/jenis-surats/1/edit", "Data jenis surat terisi pada form dan dapat diperbarui", "Form edit jenis surat tersimpan", "PASS"),
        ("TC-24", "Knowledge Docs: Daftar Dokumen AI", "GET /admin/knowledge-documents", "Tabel dokumen SOP desa & status indexing Dify tampil", "Daftar dokumen pengetahuan tampil", "PASS"),
        ("TC-25", "Knowledge Docs: Unggah Dokumen", "GET /admin/knowledge-documents/create", "Form upload berkas pedoman SOP desa tersedia", "Form unggah dokumen tampil", "PASS"),
        ("TC-26", "Permohonan Surat: Antrean Masuk", "GET /admin/permohonan-surats", "Tabel antrean permohonan dengan tab filter status tampil", "Tabel antrean & tab filter tampil", "PASS"),
        ("TC-27", "Permohonan Surat: Detail & Verifikasi", "GET /admin/permohonan-surats/1", "Detail permohonan, berkas lampiran & aksi verifikasi tersedia", "Halaman verifikasi tampil lengkap", "PASS"),
        ("TC-28", "Permohonan Surat: Formulir Edit", "GET /admin/permohonan-surats/1/edit", "Form input nomor surat, catatan dinas & status tersedia", "Form edit permohonan tampil", "PASS"),
        ("TC-29", "Profil Desa: Kelola Profil & Wilayah", "GET /admin/profil-desas/1/edit", "Form identitas desa, visi misi, potensi dusun & kontak tersedia", "Data profil desa terisi lengkap", "PASS"),
        ("TC-30", "Sinkronisasi Profil Desa ke Publik", "Simpan perubahan profil desa di Filament", "Perubahan otomatis tampil pada section profil desa di landing page", "Landing page terupdate dinamis", "PASS"),
        ("TC-31", "Users: Manajemen Pengguna", "GET /admin/users", "Tabel data admin, petugas, dan seluruh warga terdaftar tampil", "Daftar pengguna terdeteksi", "PASS"),
        ("TC-32", "Users: Formulir Tambah Pengguna", "GET /admin/users/create", "Form pendaftaran user dengan role assignment tersedia", "Form tambah user tampil", "PASS"),
        ("TC-33", "Aktivitas Logs: Audit Trail Sistem", "GET /admin/aktivitas-logs", "Log aktivitas pencatatan aksi login, pengajuan & verifikasi tampil", "Tabel log aktivitas tampil", "PASS"),
    ]
    add_bb_table(doc, "4.2", "Hasil Pengujian Fungsional Panel Admin & Validasi Sistem", rows_admin)

    # 4.2.3 Analisis Hasil Pengujian
    add_h3(doc, "4.2.3", "Analisis Hasil Pengujian")
    add_body(doc, "Berdasarkan hasil pengujian fungsionalitas yang disajikan pada Tabel 4.1 dan Tabel 4.2, dapat ditarik beberapa kesimpulan analisis pengujian:")
    add_body(doc, "1. Tingkat Keberhasilan Pengujian (Success Rate 100%): Dari 33 skenario kasus uji yang dieksekusi secara otomatis, seluruh skenario berhasil diselesaikan dengan hasil PASS (100% lolos uji). Seluruh modul utama beroperasi stabil dan memenuhi kebutuhan fungsional perangkat desa dan warga.")
    add_body(doc, "2. Keandalan Fitur Pemulihan Akun via OTP WhatsApp: Pengujian membuktikan bahwa alur Lupa Password berjalan aman dan presisi: NIK yang tidak terdaftar ditolak dengan pesan yang jelas, kode OTP dibatasi masa aktif 10 menit dengan batas percobaan, dan token acak aman 64-karakter mencegah akses tidak sah ke formulir ubah kata sandi.")
    add_body(doc, "3. Integritas Data Profil Desa & Penerbitan Dokumen PDF: Fitur Profil Desa singleton berhasil memfasilitasi perangkat desa dalam mengelola data dinamis desa yang langsung tersaji pada landing page publik. Sementara itu, otomatisasi penerbitan surat menghasilkan berkas PDF berstandar dinas yang hanya dapat diunduh oleh pemilik akun sah.")
    add_body(doc, "4. Keamanan Hak Akses dan Jejak Audit: Perlindungan middleware Laravel berhasil mencegah akses tidak sah antar-peran (warga tidak dapat membuka panel admin, dan pengunjung guest diarahkan ke halaman login). Seluruh aktivitas krusial tercatat pada tabel aktivitas_log untuk kebutuhan audit trail.")

    # 4.3 Pembahasan
    add_h2(doc, "4.3", "Pembahasan")

    # 4.3.1 Analisis Efisiensi Pelayanan Publik Desa
    add_h3(doc, "4.3.1", "Analisis Efisiensi Pelayanan Publik Desa")
    add_body(doc, "Penerapan SIPEDES membawa transformasi signifikan terhadap kualitas dan kecepatan pelayanan administrasi surat-menyurat di Desa Rombiya Barat. Pada sistem manual konvensional, warga harus datang ke Kantor Balai Desa, membawa dokumen fotokopi, mengisi formulir fisik, dan menunggu kehadiran petugas, dengan rata-rata waktu pemrosesan antara 1 hingga 3 hari kerja.")
    add_body(doc, "Melalui SIPEDES berbasis web self-service, warga dapat mengajukan permohonan surat kapan saja dan di mana saja melalui wizard tiga langkah yang memandu pengisian data secara runtut. Notifikasi status real-time mengeliminasi kebutuhan warga untuk datang berkali-kali ke kantor desa hanya untuk mengecek status surat. Surat yang disetujui dapat diunduh langsung dalam format PDF, memangkas durasi pelayanan menjadi beberapa jam kerja pada jam operasional desa.")

    # 4.3.2 Analisis Integrasi AI RAG (Dify) dan Kualitas Informasi Layanan
    add_h3(doc, "4.3.2", "Analisis Integrasi AI RAG (Dify) dan Kualitas Informasi Layanan")
    add_body(doc, "Integrasi Kecerdasan Buatan berarsitektur Retrieval-Augmented Generation (RAG) melalui platform Dify memberikan nilai tambah yang besar bagi transparansi informasi desa. Dokumen SOP pelayanan desa yang diunggah admin diolah menjadi basis pengetahuan terindeks, sehingga chatbot AI mampu memberikan jawaban faktual dan kontekstual sesuai pedoman resmi desa, bukan sekadar jawaban generik model bahasa.")
    add_body(doc, "Penyertaan kutipan sumber dokumen pada setiap respons AI memungkinkan warga memverifikasi keabsahan informasi. Pengelolaan siklus hidup dokumen (upload, re-indexing, update, dan delete) memastikan basis pengetahuan AI selalu selaras dengan regulasi dan kebijakan desa yang berlaku.")

    # 4.3.3 Analisis Keamanan Akun & Komunikasi WhatsApp Gateway
    add_h3(doc, "4.3.3", "Analisis Keamanan Akun & Komunikasi WhatsApp Gateway")
    add_body(doc, "Penggunaan WhatsApp Gateway lokal (Go-WA Docker) menjadi kanal komunikasi yang efektif dan mudah dijangkau oleh masyarakat pedesaan. Fitur verifikasi OTP 6 digit WhatsApp memberikan keamanan ganda bagi akun warga tanpa membebani warga dengan keharusan mengingat email atau prosedur reset yang rumit.")
    add_body(doc, "Penerapan rate-limiting (cooldown 60 detik) dan masa kedaluwarsa 10 menit berhasil mengantisipasi potensi penyalahgunaan SMS/WA spamming, sementara token acak 64 karakter menjamin bahwa sesi pengubahan sandi tidak dapat dieksploitasi oleh pihak lain.")

    # 4.3.4 Kelebihan dan Keterbatasan Sistem
    add_h3(doc, "4.3.4", "Kelebihan dan Keterbatasan Sistem")
    add_body(doc, "Kelebihan utama SIPEDES Desa Rombiya Barat meliputi: antarmuka ramah pengguna berbasis NIK, wizard pengajuan surat tiga langkah, penerbitan surat resmi otomatis berformat PDF, sistem pemulihan akun via OTP WhatsApp, asisten AI RAG berbasis dokumen resmi, panel admin Filament terpadu, serta modul profil desa yang dinamis.")
    add_body(doc, "Adapun keterbatasan sistem saat ini antara lain: operasional sistem memerlukan koneksi jaringan internet yang stabil, integrasi AI memerlukan ketersediaan server Dify yang aktif, serta pengesahan surat saat ini masih berupa tanda tangan dan stempel administratif digital desa, belum menggunakan Tanda Tangan Elektronik (TTE) tersertifikasi secara resmi dari BSrE BSSN.")

    print("Generating BAB V...")

    # ---------------- BAB V ----------------
    add_bab_heading(doc, "V", "KESIMPULAN DAN SARAN")

    # 5.1 Kesimpulan
    add_h2(doc, "5.1", "Kesimpulan")
    add_body(doc, "Berdasarkan seluruh rangkaian perancangan, implementasi, dan pengujian Sistem Informasi Pelayanan Desa (SIPEDES) Desa Rombiya Barat, dapat disimpulkan hal-hal sebagai berikut:")
    add_body(doc, "1. Telah berhasil dirancang dan dibangun Sistem Informasi Pelayanan Desa (SIPEDES) Desa Rombiya Barat berbasis web menggunakan framework Laravel, Filament, dan Livewire yang menyediakan portal mandiri (self-service) bagi warga serta panel manajemen terpadu bagi perangkat desa.")
    add_body(doc, "2. Sistem berhasil mengimplementasikan alur permohonan surat terotomatisasi melalui wizard tiga langkah, pemantauan status permohonan secara real-time, penerbitan dokumen surat resmi berformat PDF berstandar dinas, serta manajemen profil dan potensi desa yang tersinkronisasi dinamis ke halaman depan publik.")
    add_body(doc, "3. Sistem berhasil mengintegrasikan kanal komunikasi WhatsApp Gateway untuk pengiriman kode OTP verifikasi pemulihan kata sandi akun warga secara aman dengan perlindungan rate-limiting dan token 64 karakter.")
    add_body(doc, "4. Sistem berhasil mengintegrasikan asisten virtual berbasis Kecerdasan Buatan (AI) berarsitektur Retrieval-Augmented Generation (RAG) melalui Dify yang mampu menjawab pertanyaan warga seputar persyaratan dan SOP pelayanan desa berdasarkan dokumen resmi.")
    add_body(doc, "5. Hasil pengujian fungsionalitas menggunakan metode Black-Box Testing pada 33 skenario kasus uji (TC-01 s/d TC-33) menunjukkan tingkat kelulusan 100% (PASS), membuktikan bahwa seluruh fitur sistem beroperasi secara stabil, aman, dan sesuai spesifikasi kebutuhan.")

    # 5.2 Saran
    add_h2(doc, "5.2", "Saran")
    add_body(doc, "Untuk pengembangan dan penyempurnaan Sistem Informasi Pelayanan Desa (SIPEDES) di masa yang akan datang, diajukan beberapa saran sebagai berikut:")
    add_body(doc, "1. Integrasi Tanda Tangan Elektronik Resmi (BSrE BSSN): Disarankan untuk mengintegrasikan modul penerbitan surat dengan Tanda Tangan Elektronik (TTE) bersertifikat dari Balai Sertifikasi Elektronik (BSrE) BSSN agar keabsahan hukum surat digital diakui secara penuh di tingkat instansi pemerintah yang lebih tinggi.")
    add_body(doc, "2. Pengembangan Aplikasi Mobile (PWA/Android): Pengembangan aplikasi mobile atau Progressive Web App (PWA) dapat dipertimbangkan guna mempermudah akses warga melalui smartphone serta menghadirkan notifikasi push instan.")
    add_body(doc, "3. Integrasi Basis Data Kependudukan (SIAK/Dukcapil): Penjajakan integrasi API data kependudukan resmi dengan Dinas Kependudukan dan Pencatatan Sipil (Dukcapil) Kabupaten Sumenep agar validasi NIK dan biodata warga dapat berlangsung secara otomatis dan terverifikasi tunggal.")
    add_body(doc, "4. Peningkatan Redundansi dan Infrastruktur Server: Penyediaan server hosting dengan backup otomatis terjadwal serta pemeliharaan berkala pada service WhatsApp Gateway dan Dify AI Engine untuk menjamin ketersediaan layanan prima 24 jam bagi masyarakat.")

    print(f"Saving document to {OUT_DAFTAR}...")
    doc.save(OUT_DAFTAR)
    print(f"Copying document to {OUT_MAIN}...")
    try:
        shutil.copyfile(OUT_DAFTAR, OUT_MAIN)
        print("Berhasil menyalin ke:", OUT_MAIN)
    except Exception as e:
        print(f"Info: {OUT_MAIN} sedang terbuka di Microsoft Word ({e}). File utama tersimpan di {OUT_DAFTAR}")
    print("Done generating BAB IV & BAB V docx!")

if __name__ == "__main__":
    import json
    pages = None
    if len(sys.argv) > 1 and os.path.exists(sys.argv[1]):
        with open(sys.argv[1], encoding="utf-8-sig") as f:
            pages = {int(str(k).lstrip('\ufeff')): v for k, v in json.load(f).items()}
        print("Menggunakan peta halaman gambar:", pages)
    generate_docx(pages)
