<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\MataKuliah;
use App\Models\Material;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Dosen Pengampu Default
        $dosen = User::updateOrCreate(
            ['email' => 'dosen@celoe.test'],
            [
                'name' => 'Dr. Ir. Budi Santoso, M.T.',
                'password' => Hash::make('dosen123'),
                'role' => 'dosen',
                'nomor_induk' => '198501012015041001',
            ]
        );

        // 2. Akun Mahasiswa Default
        $mahasiswa1 = User::updateOrCreate(
            ['email' => 'mahasiswa@celoe.test'],
            [
                'name' => 'Ahmad Pratama',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nomor_induk' => '1301210001',
            ]
        );

        // 3. Mata Kuliah Dasar (Modul 3)
        $course1 = MataKuliah::updateOrCreate(
            ['kode_mk' => 'IF301'],
            [
                'nama_mk' => 'Pengembangan Aplikasi Website',
                'deskripsi' => 'Mata kuliah yang membahas arsitektur aplikasi web modern menggunakan framework Laravel, MVC, Eloquent ORM, dan keamanan web.',
                'sks' => 4,
                'semester' => 'Ganjil 2026/2027',
                'dosen_id' => $dosen->id,
            ]
        );

        // 4. Daftarkan Mahasiswa ke Mata Kuliah Pertama (status approved)
        $course1->students()->syncWithoutDetaching([
            $mahasiswa1->id => ['status' => 'approved'],
        ]);

        // 5. Tambahkan Materi Contoh
        Material::updateOrCreate(
            ['course_id' => $course1->id, 'minggu_ke' => 1, 'urutan' => 1],
            [
                'judul' => 'Pengenalan Arsitektur MVC & Routing di Laravel 12',
                'konten' => 'Mempelajari alur HTTP Request, Route Middleware, Controller, dan pembuatan View menggunakan Blade Template.',
            ]
        );

        // TODO 8: Tambahkan minimal 2 mata kuliah lagi dengan semester berbeda, 1 mahasiswa tambahan, 2 tugas, dan contoh data submission

        // 6. Akun Mahasiswa Tambahan
        $mahasiswa2 = User::updateOrCreate(
            ['email' => 'mahasiswa2@celoe.test'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nomor_induk' => '1301210002',
            ]
        );

        // 7. Mata Kuliah Tambahan dengan Semester dan SKS Berbeda
        $course2 = MataKuliah::updateOrCreate(
            ['kode_mk' => 'IF302'],
            [
                'nama_mk' => 'Basis Data Lanjut',
                'deskripsi' => 'Pembahasan lanjutan mengenai perancangan basis data relasional, normalisasi, indeks, transaksi, dan optimasi query.',
                'sks' => 3,
                'semester' => 'Genap 2026/2027',
                'dosen_id' => $dosen->id,
            ]
        );

        $course3 = MataKuliah::updateOrCreate(
            ['kode_mk' => 'SI301'],
            [
                'nama_mk' => 'Analisis dan Perancangan Sistem Informasi',
                'deskripsi' => 'Mata kuliah yang membahas identifikasi kebutuhan pengguna, pemodelan proses bisnis, serta perancangan solusi sistem informasi.',
                'sks' => 2,
                'semester' => 'Ganjil 2025/2026',
                'dosen_id' => $dosen->id,
            ]
        );

        // 8. Pendaftaran Mahasiswa pada Setiap Mata Kuliah (status approved)
        $course1->students()->syncWithoutDetaching([
            $mahasiswa1->id => ['status' => 'approved'],
            $mahasiswa2->id => ['status' => 'approved'],
        ]);

        $course2->students()->syncWithoutDetaching([
            $mahasiswa1->id => ['status' => 'approved'],
            $mahasiswa2->id => ['status' => 'approved'],
        ]);

        $course3->students()->syncWithoutDetaching([
            $mahasiswa1->id => ['status' => 'approved'],
            $mahasiswa2->id => ['status' => 'approved'],
        ]);

        // 9. Materi Contoh untuk Mata Kuliah Tambahan
        Material::updateOrCreate(
            ['course_id' => $course2->id, 'minggu_ke' => 1, 'urutan' => 1],
            [
                'judul' => 'Pengantar Basis Data Relasional',
                'konten' => 'Membahas entitas, atribut, relasi, kunci primer, kunci asing, serta penerapan normalisasi hingga bentuk normal ketiga.',
            ]
        );

        Material::updateOrCreate(
            ['course_id' => $course3->id, 'minggu_ke' => 1, 'urutan' => 1],
            [
                'judul' => 'Identifikasi Kebutuhan Sistem',
                'konten' => 'Mempelajari teknik wawancara, observasi, dan penyusunan kebutuhan fungsional maupun non-fungsional pada proyek sistem informasi.',
            ]
        );

        // 10. Tugas Perkuliahan untuk Pengujian Penilaian dan Export CSV
        $assignment1 = Assignment::updateOrCreate(
            ['course_id' => $course1->id, 'judul' => 'Tugas 1 — Implementasi MVC dan Routing'],
            [
                'deskripsi' => 'Jelaskan alur request pada arsitektur MVC Laravel, kemudian rancang tiga rute beserta controller dan view yang sesuai. Tuliskan jawaban dalam bentuk esai minimal 300 kata.',
                'deadline' => now()->addDays(7),
            ]
        );

        $assignment2 = Assignment::updateOrCreate(
            ['course_id' => $course2->id, 'judul' => 'Tugas 1 — Perancangan Basis Data Relasional'],
            [
                'deskripsi' => 'Buat rancangan tabel untuk studi kasus perpustakaan, tentukan kunci primer dan kunci asing, lalu jelaskan proses normalisasi hingga 3NF.',
                'deadline' => now()->addDays(10),
            ]
        );

        $assignment3 = Assignment::updateOrCreate(
            ['course_id' => $course3->id, 'judul' => 'Studi Kasus — Analisis Kebutuhan Sistem'],
            [
                'deskripsi' => 'Pilih satu proses bisnis sederhana, identifikasi aktor dan kebutuhan sistem, lalu susun ringkasan kebutuhan fungsional dan non-fungsional.',
                'deadline' => now()->addDays(14),
            ]
        );

        // 11. Contoh Pengumpulan Tugas dengan Berbagai Status Nilai
        Submission::updateOrCreate(
            ['assignment_id' => $assignment1->id, 'user_id' => $mahasiswa1->id],
            [
                'jawaban' => 'Alur request Laravel dimulai dari public/index.php, diteruskan ke kernel, melewati middleware, lalu diarahkan oleh router ke controller. Controller memproses data melalui model dan mengembalikan view Blade kepada pengguna. Rute yang dirancang mencakup halaman daftar mata kuliah, detail mata kuliah, dan pengumpulan tugas.',
                'submitted_at' => now()->subDays(2),
                'nilai' => 88,
                'catatan_dosen' => 'Pemahaman alur MVC sudah baik dan contoh rute relevan. Pertahankan ketelitian pada penamaan controller.',
            ]
        );

        Submission::updateOrCreate(
            ['assignment_id' => $assignment1->id, 'user_id' => $mahasiswa2->id],
            [
                'jawaban' => 'Laravel menerima request melalui index.php kemudian memprosesnya dengan router. Saya membuat rute untuk katalog dan detail, tetapi penjelasan mengenai middleware masih terlalu singkat.',
                'submitted_at' => now()->subDays(1),
                'nilai' => 65,
                'catatan_dosen' => 'Struktur jawaban sudah benar, namun bagian middleware dan hubungan controller dengan model perlu dijelaskan lebih rinci.',
            ]
        );

        Submission::updateOrCreate(
            ['assignment_id' => $assignment2->id, 'user_id' => $mahasiswa1->id],
            [
                'jawaban' => 'Rancangan basis data perpustakaan terdiri atas tabel anggota, buku, dan peminjaman. Relasi one-to-many diterapkan antara anggota dan peminjaman, sedangkan buku juga berelasi one-to-many ke peminjaman. Normalisasi hingga 3NF dilakukan dengan memisahkan data penerbit dan kategori.',
                'submitted_at' => now()->subHours(8),
                'nilai' => 92,
                'catatan_dosen' => 'Rancangan sangat rapi, normalisasi dijelaskan dengan contoh yang tepat, dan kunci asing sudah konsisten.',
            ]
        );

        Submission::updateOrCreate(
            ['assignment_id' => $assignment2->id, 'user_id' => $mahasiswa2->id],
            [
                'jawaban' => 'Saya merancang tabel buku, anggota, dan transaksi peminjaman. Setiap transaksi mencatat tanggal pinjam dan tanggal kembali. Normalisasi dilakukan dengan menghilangkan data berulang pada tabel buku.',
                'submitted_at' => now()->subHours(3),
                'nilai' => null,
                'catatan_dosen' => null,
            ]
        );

        Submission::updateOrCreate(
            ['assignment_id' => $assignment3->id, 'user_id' => $mahasiswa1->id],
            [
                'jawaban' => 'Proses bisnis yang dipilih adalah pengajuan cuti akademik. Aktor yang terlibat adalah mahasiswa, dosen wali, dan bagian akademik. Kebutuhan fungsional mencakup pengajuan, verifikasi, dan pencatatan status cuti.',
                'submitted_at' => now()->subHours(1),
                'nilai' => null,
                'catatan_dosen' => null,
            ]
        );
    }
}
