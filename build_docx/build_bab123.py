# -*- coding: utf-8 -*-
"""
Build BAB I, BAB II & BAB III (skripsi SI Pelayanan Desa Rombiyah Barat)
with the exact same formatting as BAB-IV-V-SIPEDES-RombiyahBarat.docx:
A4, margins 4/3/3/3 cm, 1.5 line spacing (line=360), TNR, Heading1 (BAB)
centered bold, Heading2/3 numbered, justified body with firstLine indent,
PAGE footer. Helpers dipakai ulang dari build.py.
"""
import os
from docx import Document
from docx.shared import Twips
from build import (
    setup_page, add_page_footer, add_bab_heading, add_h2, add_h3, add_body,
)

BASE = os.path.dirname(os.path.abspath(__file__))
OUT = os.path.abspath(os.path.join(BASE, "..", "screenshots", "BAB-I-III-SIPEDES-RombiyahBarat.docx"))


def generate_docx():
    doc = Document()
    setup_page(doc)
    add_page_footer(doc)

    # ---------------- BAB I ----------------
    print("Generating BAB I...")
    add_bab_heading(doc, "I", "PENDAHULUAN")

    add_h2(doc, "1.1", "Latar Belakang")
    add_body(doc, "Desa Rombiyah Barat merupakan salah satu desa di Kecamatan Gandusari, Kabupaten Blitar, Jawa Timur. Sebagai organisasi pemerintahan paling bawah yang berhadapan langsung dengan masyarakat, kantor desa memiliki tanggung jawab utama dalam memberikan pelayanan administrasi kependudukan dan surat-menyurat, antara lain Surat Keterangan Tidak Mampu (SKTM), Surat Keterangan Domisili, Surat Keterangan Usaha (SKU), Surat Pengantar Nikah, dan Surat Keterangan Kematian.")
    add_body(doc, "Berdasarkan observasi awal yang dilakukan pada Kantor Desa Rombiyah Barat, proses pelayanan surat-menyurat masih dilakukan secara konvensional. Warga harus datang langsung ke kantor desa, mengantre untuk mengisi formulir kertas, menyerahkan fotokopi berkas persyaratan, kemudian menunggu proses verifikasi dan penandatanganan oleh perangkat desa. Warga tidak memiliki sarana untuk memantau status pengajuan suratnya, sehingga harus datang berulang kali atau menghubungi perangkat desa secara manual. Selain itu, arsip berkas yang tersimpan dalam bentuk fisik rawan hilang, rusak, dan membutuhkan ruang penyimpanan yang besar.")
    add_body(doc, "Perkembangan teknologi informasi, khususnya web framework modern seperti Laravel dengan panel administrasi Filament serta komponen interaktif Livewire, memberikan peluang untuk mengatasi permasalahan tersebut. Di sisi lain, kemajuan Kecerdasan Buatan (AI) dengan arsitektur Retrieval-Augmented Generation (RAG) memungkinkan dibangunnya asisten virtual yang menjawab pertanyaan warga berdasarkan dokumen resmi desa. Berdasarkan permasalahan dan peluang tersebut, penelitian ini mengusulkan pembangunan Sistem Informasi Pelayanan Desa (SIPEDES) Rombiyah Barat berbasis web yang mengintegrasikan portal layanan mandiri warga, panel manajemen perangkat desa, serta asisten AI RAG untuk meningkatkan kualitas dan efisiensi pelayanan publik desa.")

    add_h2(doc, "1.2", "Rumusan Masalah")
    add_body(doc, "Berdasarkan latar belakang yang telah diuraikan, rumusan masalah dalam penelitian ini adalah sebagai berikut:")
    add_body(doc, "1. Bagaimana merancang Sistem Informasi Pelayanan Desa (SIPEDES) Rombiyah Barat berbasis web yang mampu mengelola alur pengajuan surat secara mandiri oleh warga?")
    add_body(doc, "2. Bagaimana mengimplementasikan sistem tersebut menggunakan framework Laravel, panel administrasi Filament, komponen Livewire, serta integrasi asisten AI RAG berbasis Dify?")
    add_body(doc, "3. Bagaimana hasil pengujian fungsionalitas sistem menggunakan metode Black-Box Testing terhadap seluruh alur proses bisnis halaman publik, portal warga, dan panel admin desa?")

    add_h2(doc, "1.3", "Tujuan Penelitian")
    add_body(doc, "Sesuai dengan rumusan masalah di atas, tujuan penelitian ini adalah:")
    add_body(doc, "1. Merancang Sistem Informasi Pelayanan Desa (SIPEDES) Rombiyah Barat berbasis web yang mampu mengelola alur pengajuan surat secara mandiri oleh warga.")
    add_body(doc, "2. Mengimplementasikan sistem menggunakan framework Laravel, panel administrasi Filament, komponen Livewire, serta integrasi asisten AI RAG berbasis Dify.")
    add_body(doc, "3. Menguji fungsionalitas sistem menggunakan metode Black-Box Testing pada seluruh alur proses bisnis halaman publik, portal warga, dan panel admin desa, serta mengevaluasi hasil pengujian tersebut.")

    add_h2(doc, "1.4", "Manfaat Penelitian")
    add_body(doc, "Penelitian ini diharapkan memberikan manfaat sebagai berikut:")
    add_body(doc, "1. Bagi Desa Rombiyah Barat: Mempercepat dan menertibkan proses pelayanan surat-menyurat, mempermudah pengelolaan arsip digital, serta menyediakan kanal informasi layanan yang dapat diakses warga kapan saja.")
    add_body(doc, "2. Bagi Warga Desa: Memudahkan pengajuan surat tanpa harus datang berulang kali ke kantor desa, memberikan kepastian status pengajuan secara real-time, serta menyediakan asisten virtual untuk menjawab pertanyaan terkait persyaratan layanan.")
    add_body(doc, "3. Bagi Peneliti: Menambah wawasan dan pengalaman dalam pengembangan aplikasi web berbasis Laravel, Filament, Livewire, serta integrasi Kecerdasan Buatan RAG.")
    add_body(doc, "4. Bagi Akademisi: Dapat dijadikan referensi bagi penelitian sejenis mengenai sistem informasi pelayanan publik desa dan pemanfaatan AI RAG dalam layanan pemerintahan.")

    add_h2(doc, "1.5", "Batasan Masalah")
    add_body(doc, "Agar pembahasan lebih terarah, penelitian ini dibatasi pada hal-hal sebagai berikut:")
    add_body(doc, "1. Sistem difokuskan pada layanan administrasi surat-menyurat desa, meliputi lima jenis surat yaitu SKTM, Surat Keterangan Domisili, SKU, Surat Pengantar Nikah (N1-N4), dan Surat Keterangan Kematian.")
    add_body(doc, "2. Autentikasi warga menggunakan Nomor Induk Kependudukan (NIK) dan kata sandi, sedangkan autentikasi pengelola desa menggunakan alamat email dan kata sandi pada panel Filament.")
    add_body(doc, "3. Asisten AI menggunakan arsitektur RAG dengan platform Dify sebagai penyedia Knowledge Base dan endpoint percakapan streaming; kualitas jawaban bergantung pada dokumen yang diunggah admin.")
    add_body(doc, "4. Pengesahan dokumen surat masih berupa konfirmasi administratif oleh perangkat desa, belum menggunakan Tanda Tangan Elektronik (TTE) bersertifikat dari Penyelenggara Sertifikat Elektronik (PSrE) resmi.")
    add_body(doc, "5. Pengujian sistem menggunakan metode Black-Box Testing otomatis berbasis Puppeteer dan browser Google Chrome pada lingkungan pengembangan lokal, mencakup 29 kasus uji fungsional.")

    add_h2(doc, "1.6", "Sistematika Penulisan")
    add_body(doc, "Sistematika penulisan penelitian ini disusun dalam lima bab sebagai berikut:")
    add_body(doc, "BAB I PENDAHULUAN: Memuat latar belakang, rumusan masalah, tujuan penelitian, manfaat penelitian, batasan masalah, serta sistematika penulisan.")
    add_body(doc, "BAB II KAJIAN PUSTAKA: Memuat tinjauan pustaka mengenai teori-teori pendukung, penelitian terdahulu yang relevan, serta kerangka berpikir penelitian.")
    add_body(doc, "BAB III METODE PENELITIAN: Memuat jenis penelitian, lokasi dan waktu penelitian, metode pengumpulan data, tahapan penelitian, alat dan bahan penelitian, serta metode pengujian sistem.")
    add_body(doc, "BAB IV HASIL DAN PEMBAHASAN: Memuat hasil implementasi sistem, pengujian fungsionalitas, serta pembahasan terhadap hasil yang diperoleh.")
    add_body(doc, "BAB V KESIMPULAN DAN SARAN: Memuat kesimpulan dari keseluruhan penelitian serta saran untuk pengembangan selanjutnya.")

    # ---------------- BAB II ----------------
    print("Generating BAB II...")
    add_bab_heading(doc, "II", "KAJIAN PUSTAKA")

    add_h2(doc, "2.1", "Tinjauan Pustaka")

    add_h3(doc, "2.1.1", "Pelayanan Publik dan Administrasi Desa")
    add_body(doc, "Pelayanan publik adalah segala bentuk kegiatan pelayanan yang dilaksanakan oleh instansi pemerintah dalam rangka memenuhi kebutuhan masyarakat sesuai dengan peraturan perundang-undangan. Dalam konteks pemerintahan desa, pelayanan administrasi mencakup penerbitan surat keterangan dan surat pengantar yang menjadi dasar bagi warga dalam mengurus berbagai keperluan, baik kepada lembaga pemerintah maupun swasta.")
    add_body(doc, "Undang-Undang Nomor 6 Tahun 2014 tentang Desa menegaskan bahwa desa berhak menyelenggarakan pemerintahan dan pelayanan publik berdasarkan kewenangan lokal berskala desa. Pemanfaatan teknologi informasi dalam penyelenggaraan pelayanan desa merupakan wujud penerapan electronic government (e-government) yang bertujuan meningkatkan efektivitas, efisiensi, transparansi, dan akuntabilitas pelayanan kepada masyarakat.")

    add_h3(doc, "2.1.2", "Sistem Informasi Pelayanan Desa")
    add_body(doc, "Sistem informasi pelayanan desa merupakan aplikasi berbasis komputer yang mengelola data penduduk, jenis layanan, permohonan surat, serta proses verifikasi dan penerbitan dokumen. Sistem semacam ini umumnya menyediakan dua sisi pengguna, yaitu portal warga (self-service) untuk pengajuan dan pemantauan permohonan, serta panel administrasi bagi perangkat desa untuk memverifikasi dan menerbitkan dokumen.")
    add_body(doc, "Adopsi sistem informasi pelayanan desa membawa perubahan pada proses bisnis pelayanan dari alur manual menjadi alur digital yang terdokumentasi, meliputi otomatisasi penomoran permohonan, penyimpanan berkas dalam media digital, pemantauan status secara real-time, serta pencatatan jejak audit (audit trail) atas setiap tindakan pengguna.")

    add_h3(doc, "2.1.3", "Framework Laravel dan Panel Administrasi Filament")
    add_body(doc, "Laravel merupakan salah satu web framework berbasis bahasa pemrograman PHP yang populer dengan sintaks yang ekspresif dan elegan. Laravel menyediakan berbagai komponen bawaan seperti routing, autentikasi, Eloquent ORM, Blade templating, queue, serta sistem middleware yang mendukung pengembangan aplikasi web berskala besar secara terstruktur dan aman.")
    add_body(doc, "Filament adalah panel administrasi (admin panel) modern yang dibangun di atas Laravel dan Livewire. Filament menyediakan komponen-komponen siap pakai untuk membangun antarmuka manajemen data, seperti tabel dengan pencarian dan penyaringan, formulir dengan validasi, halaman detail (infolist), serta widget statistik dan grafik. Penggunaan Filament mempercepat pengembangan panel admin sekaligus menjaga konsistensi antarmuka dan keamanan akses berbasis peran.")

    add_h3(doc, "2.1.4", "Livewire dan Arsitektur Web Modern")
    add_body(doc, "Livewire adalah library untuk framework Laravel yang memungkinkan pembangunan antarmuka dinamis dan interaktif tanpa menulis kode JavaScript secara ekstensif. Dengan Livewire, komponen UI dirender di sisi server dan diperbarui secara asinkron melalui permintaan AJAX, sehingga pengalaman pengguna menyerupai aplikasi single-page application namun tetap mempertahankan kemudahan pengembangan server-side.")
    add_body(doc, "Pada sistem ini, Livewire digunakan untuk membangun wizard pengajuan surat tiga langkah dan widget chatbot asisten AI. Interaktivitas seperti pemilihan jenis surat, unggah berkas, konfirmasi ringkasan, dan percakapan dengan asisten AI ditangani oleh komponen Livewire yang berkomunikasi dengan backend secara real-time.")

    add_h3(doc, "2.1.5", "Kecerdasan Buatan, Retrieval-Augmented Generation (RAG), dan Platform Dify")
    add_body(doc, "Retrieval-Augmented Generation (RAG) merupakan arsitektur Kecerdasan Buatan yang menggabungkan mesin pencari (retriever) dengan model bahasa besar (Large Language Model). Pada arsitektur RAG, pertanyaan pengguna terlebih dahulu digunakan untuk mencari dokumen atau potongan teks (chunk) yang relevan dari basis pengetahuan, kemudian hasil pencarian tersebut dijadikan konteks bagi model bahasa untuk menyusun jawaban. Pendekatan ini menghasilkan jawaban yang lebih akurat, kontekstual, dan dapat dilacak sumbernya.")
    add_body(doc, "Dify merupakan platform perangkat lunak sumber terbuka (open-source) kelas LLMOps yang menyediakan pengelolaan Knowledge Base, pengaturan model bahasa, serta antarmuka API untuk membangun aplikasi AI. Pada sistem ini, Dify digunakan sebagai penyedia Knowledge Base bagi dokumen pedoman dan SOP pelayanan desa, serta sebagai layanan percakapan RAG yang diakses oleh chatbot portal warga melalui HTTP API dengan dukungan streaming jawaban secara real-time.")

    add_h3(doc, "2.1.6", "Pengujian Black-Box")
    add_body(doc, "Black-Box Testing adalah metode pengujian perangkat lunak yang berfokus pada fungsionalitas sistem tanpa memperhatikan struktur kode internal. Penguji memberikan sejumlah masukan (input) pada antarmuka sistem dan membandingkan keluaran (output) yang dihasilkan dengan hasil yang diharapkan. Metode ini bertujuan memastikan bahwa seluruh kebutuhan fungsional sistem telah terpenuhi dan tidak terdapat cacat (bug) pada alur kerja aplikasi.")
    add_body(doc, "Pengujian black-box dapat diotomatisasi menggunakan alat bantu seperti Puppeteer, yang mengendalikan browser Google Chrome secara headless untuk membuka halaman, mengisi formulir, dan memverifikasi respons. Otomatisasi memungkinkan pengujian dilakukan secara berulang, konsisten, dan terdokumentasi, sehingga hasilnya dapat dijadikan bukti objektif kualitas sistem.")

    add_h2(doc, "2.2", "Penelitian Terdahulu")
    add_body(doc, "Beberapa penelitian sebelumnya yang relevan dengan penelitian ini antara lain:")
    add_body(doc, "1. Penelitian tentang pengembangan sistem informasi pelayanan surat desa berbasis web yang masih menggunakan alur pengajuan manual dan belum memiliki integrasi asisten virtual, sehingga warga harus berkomunikasi langsung dengan perangkat desa untuk mengetahui status pengajuan. Hasil penelitian tersebut menjadi dasar pemanfaatan portal self-service dan pemantauan status real-time.")
    add_body(doc, "2. Penelitian tentang penerapan chatbot pada layanan informasi publik yang menunjukkan peningkatan kemudahan akses informasi, namun jawaban yang dihasilkan masih bersifat generik karena tidak berbasis dokumen resmi instansi. Hal ini mendorong penggunaan arsitektur RAG agar jawaban asisten AI bersumber dari dokumen resmi desa.")
    add_body(doc, "3. Penelitian tentang penerapan Black-Box Testing pada aplikasi layanan pemerintah yang membuktikan bahwa pengujian fungsional otomatis mampu mendeteksi cacat sistem sebelum aplikasi digunakan secara luas, sekaligus menjadi acuan dalam menyusun skenario dan kriteria keberhasilan pengujian pada penelitian ini.")
    add_body(doc, "Berdasarkan penelitian-penelitian tersebut, kebaruan (novelty) penelitian ini terletak pada penggabungan portal layanan mandiri warga, panel administrasi Filament, serta asisten AI berbasis RAG dalam satu sistem terintegrasi, lengkap dengan pengujian black-box otomatis yang terdokumentasi.")

    add_h2(doc, "2.3", "Kerangka Berpikir")
    add_body(doc, "Kerangka berpikir penelitian ini diawali dari identifikasi permasalahan pelayanan surat-menyurat yang masih manual di Desa Rombiyah Barat. Berdasarkan permasalahan tersebut ditetapkan kebutuhan sistem berupa portal self-service warga, panel administrasi perangkat desa, dan asisten AI RAG. Selanjutnya dilakukan perancangan dan implementasi sistem menggunakan Laravel, Filament, Livewire, dan Dify, kemudian sistem diuji menggunakan Black-Box Testing otomatis. Hasil pengujian dievaluasi untuk menentukan tingkat keberhasilan sistem, dan apabila seluruh kasus uji lulus maka sistem dinyatakan layak digunakan sebagai solusi pelayanan desa.")

    # ---------------- BAB III ----------------
    print("Generating BAB III...")
    add_bab_heading(doc, "III", "METODE PENELITIAN")

    add_h2(doc, "3.1", "Jenis Penelitian")
    add_body(doc, "Penelitian ini menggunakan jenis penelitian Research and Development (R&D) dengan pendekatan pengembangan perangkat lunak model Waterfall. Penelitian R&D bertujuan menghasilkan produk perangkat lunak baru, yaitu Sistem Informasi Pelayanan Desa (SIPEDES) Rombiyah Barat, sekaligus menguji kelayakan produk tersebut melalui pengujian fungsionalitas. Model Waterfall dipilih karena kebutuhan sistem telah teridentifikasi dengan jelas pada tahap awal sehingga setiap tahapan dapat dilaksanakan secara berurutan dan terdokumentasi.")

    add_h2(doc, "3.2", "Lokasi dan Waktu Penelitian")
    add_body(doc, "Penelitian dilaksanakan di Kantor Desa Rombiyah Barat, Kecamatan Gandusari, Kabupaten Blitar, Jawa Timur. Pengumpulan data lapangan dilakukan melalui observasi proses pelayanan surat-menyurat dan wawancara dengan perangkat desa, sedangkan pengembangan serta pengujian sistem dilaksanakan pada lingkungan pengembangan lokal. Penelitian dilaksanakan dalam rentang waktu beberapa bulan yang mencakup tahapan analisis kebutuhan, perancangan, implementasi, dan pengujian sistem.")

    add_h2(doc, "3.3", "Metode Pengumpulan Data")
    add_body(doc, "Data yang digunakan dalam penelitian ini dikumpulkan melalui beberapa metode sebagai berikut:")
    add_body(doc, "1. Observasi: Mengamati secara langsung alur pelayanan surat-menyurat di Kantor Desa Rombiyah Barat, meliputi jenis-jenis surat yang dilayani, berkas persyaratan, serta prosedur verifikasi dan penerbitan dokumen.")
    add_body(doc, "2. Wawancara: Melakukan wawancara dengan perangkat desa untuk menggali permasalahan pelayanan, kebutuhan pengguna, dan harapan terhadap sistem yang akan dibangun.")
    add_body(doc, "3. Studi Pustaka: Mengumpulkan referensi dari buku, jurnal, dan dokumentasi resmi teknologi (Laravel, Filament, Livewire, Dify) yang relevan dengan perancangan, implementasi, dan pengujian sistem.")
    add_body(doc, "4. Dokumentasi: Mengumpulkan data pendukung berupa contoh format surat, persyaratan administrasi, dan profil desa yang digunakan sebagai acuan dalam merancang basis pengetahuan dan dokumen layanan.")

    add_h2(doc, "3.4", "Tahapan Penelitian")
    add_body(doc, "Tahapan penelitian mengikuti model Waterfall dengan urutan sebagai berikut:")
    add_body(doc, "1. Analisis Kebutuhan: Mengidentifikasi kebutuhan fungsional dan non-fungsional sistem melalui observasi, wawancara, dan studi pustaka. Hasilnya berupa daftar kebutuhan portal warga, panel admin, modul pengajuan surat, modul dokumen pengetahuan, dan asisten AI RAG.")
    add_body(doc, "2. Perancangan Sistem: Merancang arsitektur sistem, struktur basis data, alur proses bisnis pengajuan dan verifikasi surat, serta desain antarmuka portal warga dan panel admin.")
    add_body(doc, "3. Implementasi: Menerjemahkan rancangan menjadi kode program menggunakan Laravel 13, Filament v5, Livewire, Tailwind CSS, dan integrasi Dify untuk Knowledge Base serta chatbot RAG.")
    add_body(doc, "4. Pengujian Sistem: Melaksanakan pengujian fungsionalitas menggunakan Black-Box Testing otomatis berbasis Puppeteer terhadap 29 kasus uji yang mencakup halaman publik, portal warga, dan panel admin, kemudian mengevaluasi hasil pengujian.")
    add_body(doc, "5. Penarikan Kesimpulan: Menyimpulkan hasil penelitian berdasarkan capaian implementasi dan hasil pengujian, serta merumuskan saran untuk pengembangan selanjutnya.")

    add_h2(doc, "3.5", "Alat dan Bahan Penelitian")
    add_body(doc, "Alat yang digunakan dalam penelitian ini terdiri atas perangkat keras dan perangkat lunak sebagai berikut:")
    add_body(doc, "1. Perangkat Keras: PC/Laptop dengan prosesor multi-core, RAM 16 GB, dan penyimpanan SSD NVMe 512 GB yang digunakan untuk pengembangan dan pengujian sistem.")
    add_body(doc, "2. Perangkat Lunak: Sistem Operasi Windows 11 Pro; bahasa pemrograman PHP 8.3; framework Laravel 13; panel administrasi Filament v5; Livewire untuk komponen interaktif; basis data SQLite untuk pengembangan; pustaka Barryvdh Laravel DomPDF untuk pembuatan dokumen surat PDF; Tailwind CSS 4 dan Vite 8 untuk tampilan antarmuka; platform Dify untuk Knowledge Base dan API RAG; serta Node.js dengan Puppeteer dan Google Chrome untuk pengujian otomatis.")
    add_body(doc, "Bahan penelitian berupa data profil desa, contoh format surat, persyaratan administrasi, data penduduk uji hasil seeding, dan dokumen pedoman/SOP pelayanan yang diunggah sebagai basis pengetahuan AI.")

    add_h2(doc, "3.6", "Metode Pengujian Sistem")
    add_body(doc, "Pengujian sistem dilakukan menggunakan metode Black-Box Testing yang diotomatisasi dengan Puppeteer pada browser Google Chrome headless terhadap aplikasi yang berjalan pada http://127.0.0.1:8000. Sebelum pengujian, disiapkan data uji berupa 17 warga hasil seeding, 5 jenis surat aktif, 4 contoh permohonan surat, serta 1 dokumen basis pengetahuan agar seluruh halaman dapat dirender secara realistis.")
    add_body(doc, "Skenario pengujian disusun menjadi 29 kasus uji (TC-01 s/d TC-29) yang dikelompokkan menjadi tiga bagian, yaitu halaman publik (TC-01 s/d TC-04), portal warga (TC-05 s/d TC-12), serta panel admin dan validasi sistem (TC-13 s/d TC-29). Setiap kasus uji mencakup skenario, data masukan, hasil yang diharapkan, dan hasil pengujian dengan status PASS atau FAIL. Kriteria keberhasilan pengujian adalah seluruh kasus uji dinyatakan PASS, yang menunjukkan bahwa seluruh kebutuhan fungsional sistem telah terpenuhi.")

    print(f"Saving document to {OUT}...")
    doc.save(OUT)
    print("Done generating BAB I, II & III docx!")


if __name__ == "__main__":
    generate_docx()
