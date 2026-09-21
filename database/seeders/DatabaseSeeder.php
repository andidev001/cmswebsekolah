<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\Facility;
use App\Models\Extracurricular;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\Achievement;
use App\Models\Alumni;
use App\Models\Message;
use App\Models\Major;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Create Roles
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Memiliki akses penuh ke seluruh fitur sistem.',
        ]);

        Role::create([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'Memiliki akses untuk mengelola blog, artikel, pengumuman, dan agenda.',
        ]);

        Role::create([
            'name' => 'operator',
            'display_name' => 'Operator',
            'description' => 'Memiliki akses untuk mengelola data sekolah, guru, ekskul, dan prestasi.',
        ]);

        // 1. Create Admin User
        $admin = User::create([
            'name' => 'Administrator SMK Yapisda',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role_id' => $adminRole->id,
        ]);

        // 2. Create Base Settings
        Setting::create([
            'school_name' => 'SMK Yapisda Cisoka',
            'jenjang' => 'smk',
            'school_logo' => 'logo.png',
            'principal_name' => 'H. Muhamad Solihin, S.Pd., M.M.',
            'principal_speech' => 'Selamat datang di website resmi SMK Yapisda Cisoka. Kami berkomitmen untuk menyelenggarakan pendidikan vokasi yang bermutu, unggul, dan berkarakter islami guna mempersiapkan lulusan yang siap kerja, berwirausaha, dan bersaing di era global. Melalui integrasi kurikulum industri dan pembinaan akhlak mulia, kami terus berupaya mencetak generasi emas bangsa.',
            'principal_photo' => 'principal.png',
            'vision' => 'Terwujudnya SMK Yapisda Cisoka sebagai lembaga pendidikan vokasi yang unggul, berkarakter islami, menguasai IPTEK, dan berdaya saing global.',
            'mission' => "1. Menyelenggarakan proses pembelajaran yang berbasis kompetensi dan link and match dengan dunia usaha/industri.\n2. Mengembangkan karakter siswa yang berakhlak mulia, disiplin, bertanggung jawab, dan berjiwa wirausaha.\n3. Menyediakan sarana dan prasarana praktik kejuruan yang modern dan sesuai standar industri.\n4. Meningkatkan profesionalisme pendidik dan tenaga kependidikan secara berkelanjutan.\n5. Membangun kemitraan strategis dengan dunia industri dalam penyerapan lulusan dan magang kerja.",
            'address' => 'Jl. Raya Cisoka No.15, Cisoka, Kec. Cisoka, Kabupaten Tangerang, Banten 15730',
            'email' => 'info@smkyapisdacisoka.sch.id',
            'phone' => '(021) 5968123',
            'maps_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.113063080775!2d106.4253331!3d-6.2488344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e420790757a3e79%3A0xe7f9ab7c31db3eb9!2sSMK%20YAPISDA%20CISOKA!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'external_ppdb_link' => 'https://ppdb.yapisdacisoka.com', // External PPDB URL
            'facebook_url' => 'https://facebook.com/smkyapisdacisoka',
            'instagram_url' => 'https://instagram.com/smkyapisdacisoka',
            'youtube_url' => 'https://youtube.com/c/smkyapisdacisoka',
        ]);

        // 3. Create Categories
        $cat1 = Category::create(['name' => 'Kegiatan Sekolah', 'slug' => 'kegiatan-sekolah']);
        $cat2 = Category::create(['name' => 'Pendidikan', 'slug' => 'pendidikan']);
        $cat3 = Category::create(['name' => 'Prestasi', 'slug' => 'prestasi']);
        $cat4 = Category::create(['name' => 'Tips & Trik', 'slug' => 'tips-dan-trik']);

        // 4. Create Blog Posts
        Post::create([
            'title' => 'Pelepasan dan Wisuda Siswa Kelas XII Angkatan 2025/2026',
            'slug' => Str::slug('Pelepasan dan Wisuda Siswa Kelas XII Angkatan 2025/2026'),
            'category_id' => $cat1->id,
            'content' => '<p>SMK Yapisda Cisoka menyelenggarakan acara pelepasan dan wisuda untuk siswa kelas XII angkatan 2025/2026. Acara yang berlangsung khidmat ini dihadiri oleh para jajaran pengurus yayasan, kepala sekolah, guru, staf, serta orang tua wisudawan. Selamat atas kelulusannya, semoga sukses di dunia kerja maupun jenjang pendidikan berikutnya!</p>',
            'image' => 'wisuda.jpg',
            'status' => 'published',
            'views' => 125,
            'user_id' => $admin->id,
        ]);

        Post::create([
            'title' => 'Kerjasama Industri: Penandatanganan MoU dengan PT. Astra Honda Motor',
            'slug' => Str::slug('Kerjasama Industri Penandatanganan MoU dengan PT Astra Honda Motor'),
            'category_id' => $cat2->id,
            'content' => '<p>Dalam rangka meningkatkan kompetensi siswa Program Keahlian Teknik Bisnis Sepeda Motor (TBSM), SMK Yapisda Cisoka menandatangani kesepakatan kerjasama (MoU) dengan PT. Astra Honda Motor. Kerjasama ini meliputi penyelarasan kurikulum, magang guru dan siswa, serta penyerapan lulusan.</p>',
            'image' => 'mou.jpg',
            'status' => 'published',
            'views' => 84,
            'user_id' => $admin->id,
        ]);

        Post::create([
            'title' => 'Juara I Lomba Kompetensi Siswa (LKS) Tingkat Kabupaten Tangerang',
            'slug' => Str::slug('Juara I Lomba Kompetensi Siswa LKS Tingkat Kabupaten Tangerang'),
            'category_id' => $cat3->id,
            'content' => '<p>Prestasi membanggakan diraih oleh siswa SMK Yapisda Cisoka bidang Lomba IT Network System Administration dalam ajang LKS Tingkat Kabupaten Tangerang. Juara I diraih oleh ananda Ahmad Fauzi kelas XI Teknik Komputer Jaringan. Selamat atas perjuangan hebatnya!</p>',
            'image' => 'lks.jpg',
            'status' => 'published',
            'views' => 210,
            'user_id' => $admin->id,
        ]);

        // 5. Create Teachers
        Teacher::create([
            'nip' => '198804122019031002',
            'name' => 'Ahmad Subarjo, S.Kom.',
            'position' => 'Kepala Program Teknik Komputer Jaringan',
            'photo' => 'teacher1.jpg',
            'is_active' => true,
        ]);

        Teacher::create([
            'nip' => '199012052021022004',
            'name' => 'Siti Aminah, S.Pd.',
            'position' => 'Guru Bahasa Inggris',
            'photo' => 'teacher2.jpg',
            'is_active' => true,
        ]);

        Teacher::create([
            'nip' => null,
            'name' => 'Budi Santoso, S.T.',
            'position' => 'Guru Produktif Teknik Kendaraan Ringan',
            'photo' => 'teacher3.jpg',
            'is_active' => true,
        ]);

        // 6. Create Facilities
        Facility::create([
            'name' => 'Laboratorium Komputer TKJ',
            'description' => 'Laboratorium berstandar industri dengan spesifikasi PC modern, server Cisco, Mikrotik Router, dan AC pendingin demi kenyamanan siswa.',
            'photo' => 'lab_tkj.jpg',
        ]);

        Facility::create([
            'name' => 'Bengkel Praktik TBSM & TKR',
            'description' => 'Bengkel luas dengan alat hidrolik, pembongkar mesin, kompresor, alat ukur elektrikal, serta motor dan mobil unit praktik langsung.',
            'photo' => 'bengkel.jpg',
        ]);

        Facility::create([
            'name' => 'Perpustakaan Digital',
            'description' => 'Menyediakan ribuan buku pelajaran, novel, ensiklopedia fisik serta portal e-book yang bisa diakses di PC perpustakaan.',
            'photo' => 'perpus.jpg',
        ]);

        // 7. Create Extracurriculars
        Extracurricular::create([
            'name' => 'Pramuka (Scout)',
            'description' => 'Ekskul wajib pembentuk kedisiplinan, kemandirian, kepemimpinan, dan kerja sama tim.',
            'photo' => 'pramuka.jpg',
            'coach' => 'Jaka Tarub, S.Pd.',
        ]);

        Extracurricular::create([
            'name' => 'Paskibra',
            'description' => 'Melatih ketangkasan baris-berbaris, disiplin tinggi, fisik prima, dan cinta tanah air.',
            'photo' => 'paskibra.jpg',
            'coach' => 'Slamet Riyadi, S.H.',
        ]);

        Extracurricular::create([
            'name' => 'Hadroh & Rohis',
            'description' => 'Pengembangan seni musik religi islami dan kajian kerohanian islam pembentuk akhlak karimah.',
            'photo' => 'hadroh.jpg',
            'coach' => 'Ust. M. Ridwan, S.Ag.',
        ]);

        // 8. Create Announcements
        Announcement::create([
            'title' => 'Pengumuman Libur Hari Raya Idul Fitri 1447 H',
            'slug' => Str::slug('Pengumuman Libur Hari Raya Idul Fitri 1447 H'),
            'content' => 'Sehubungan dengan datangnya Hari Raya Idul Fitri 1447 H, maka kegiatan pembelajaran diliburkan mulai tanggal 25 Mei hingga 2 Juni 2026. Pembelajaran aktif kembali tanggal 3 Juni 2026.',
            'date' => '2026-05-24',
        ]);

        Announcement::create([
            'title' => 'Pembagian Raport Semester Genap Tahun Ajaran 2025/2026',
            'slug' => Str::slug('Pembagian Raport Semester Genap Tahun Ajaran 2025/2026'),
            'content' => 'Diinformasikan kepada seluruh orang tua/wali murid bahwa pembagian Raport Semester Genap akan dilaksanakan pada tanggal 20 Juni 2026 di kelas masing-masing, dimulai pukul 08.00 WIB.',
            'date' => '2026-06-15',
        ]);

        // 9. Create Agendas
        Agenda::create([
            'title' => 'Penilaian Akhir Semester (PAS) Genap',
            'description' => 'Ujian tertulis dan praktik semester genap untuk seluruh tingkat kelas.',
            'date' => '2026-06-02',
            'location' => 'SMK Yapisda Cisoka',
            'time' => '07:30 - 12:30 WIB',
        ]);

        Agenda::create([
            'title' => 'Classmeeting Kemerdekaan',
            'description' => 'Lomba olahraga, seni, dan keagamaan antar kelas.',
            'date' => '2026-06-12',
            'location' => 'Lapangan Olahraga Utama',
            'time' => '08:00 - 15:00 WIB',
        ]);

        // 10. Create Achievements
        Achievement::create([
            'title' => 'Juara III Futsal Cup Tingkat Provinsi',
            'description' => 'Tim futsal SMK Yapisda meraih trofi juara III setelah bertanding sengit melawan sekolah-sekolah unggulan se-Provinsi.',
            'student_name' => 'Tim Futsal Yapisda',
            'date' => '2026-04-18',
            'photo' => 'futsal.jpg',
        ]);

        // 11. Create Alumni
        Alumni::create([
            'name' => 'Dimas Prayoga',
            'graduation_year' => 2023,
            'job' => 'Software Engineer di Tokopedia',
            'phone' => '081299887766',
            'email' => 'dimas.prayoga@gmail.com',
            'testimonial' => 'Belajar di SMK Yapisda Cisoka membuka wawasan saya di bidang teknologi. Guru-gurunya sangat suportif dan fasilitas laboratorium komputernya lengkap sekali!',
        ]);

        Alumni::create([
            'name' => 'Dewi Safitri',
            'graduation_year' => 2024,
            'job' => 'Quality Control di PT. Gajah Tunggal',
            'phone' => '081344556677',
            'email' => 'dewi.safitri@yahoo.com',
            'testimonial' => 'Disiplin yang diajarkan selama sekolah sangat membantu saya beradaptasi cepat dengan lingkungan pabrik yang membutuhkan presisi tinggi. Bangga jadi alumni Yapisda!',
        ]);

        Message::create([
            'name' => 'Rahmat Hidayat',
            'email' => 'rahmat.h@gmail.com',
            'subject' => 'Pertanyaan Kemitraan Magang',
            'message' => 'Halo Admin, saya perwakilan dari CV Mitra Solusindo ingin menanyakan bagaimana prosedur untuk mengajukan kemitraan penerimaan magang siswa TKJ SMK Yapisda. Terima kasih.',
        ]);

        // 13. Create Majors (Jurusan)
        Major::create([
            'name' => 'Teknik Komputer & Jaringan (TKJ)',
            'description' => "Mempelajari instalasi jaringan komputer LAN, WAN, administrasi server, konfigurasi mikrotik & cisco router, serat optik (fiber optic), serta perakitan dan troubleshooting PC.",
            'photo' => null,
        ]);

        Major::create([
            'name' => 'Rekayasa Perangkat Lunak (RPL)',
            'description' => "Mempelajari pemrograman web dasar dan lanjutan, pengembangan aplikasi mobile, administrasi basis data relasional (MySQL/PostgreSQL), konsep pemrograman berorientasi objek (PBO), serta UI/UX design.",
            'photo' => null,
        ]);

        Major::create([
            'name' => 'Teknik Kendaraan Ringan (TKR)',
            'description' => "Mempelajari servis berkala mesin bensin dan diesel, pembongkaran transmisi manual/otomatis, sistem suspensi dan kemudi, kelistrikan bodi otomotif, serta diagnosa sistem EFI.",
            'photo' => null,
        ]);
    }
}
