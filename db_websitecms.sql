/*
 Navicat Premium Data Transfer

 Source Server         : laragon
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : db_websitecms

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 31/05/2026 10:33:46
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for achievements
-- ----------------------------
DROP TABLE IF EXISTS `achievements`;
CREATE TABLE `achievements`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `student_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `date` date NULL DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of achievements
-- ----------------------------
INSERT INTO `achievements` VALUES (1, 'Juara I Futsal Cup Tingkat Provinsi', 'Tim futsal SMK Skolabs meraih trofi juara III setelah bertanding sengit melawan sekolah-sekolah unggulan se-Provinsi.', 'Tim Futsal Skolabs', '2026-04-18', '1780137298_juara-i-futsal-cup-tingkat-provinsi.jpg', '2026-05-27 07:46:59', '2026-05-30 10:34:58');

-- ----------------------------
-- Table structure for agendas
-- ----------------------------
DROP TABLE IF EXISTS `agendas`;
CREATE TABLE `agendas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `date` date NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of agendas
-- ----------------------------
INSERT INTO `agendas` VALUES (1, 'Penilaian Akhir Semester (PAS) Genap', 'Ujian tertulis dan praktik semester genap untuk seluruh tingkat kelas.', '2026-06-02', 'Gedung SKOLABS', '07:30 - 12:30 WIB', '2026-05-27 07:46:59', '2026-05-30 10:30:05');
INSERT INTO `agendas` VALUES (2, 'Classmeeting Kemerdekaan', 'Lomba olahraga, seni, dan keagamaan antar kelas.', '2026-06-12', 'Lapangan Olahraga Utama', '08:00 - 15:00 WIB', '2026-05-27 07:46:59', '2026-05-27 07:46:59');

-- ----------------------------
-- Table structure for alumni
-- ----------------------------
DROP TABLE IF EXISTS `alumni`;
CREATE TABLE `alumni`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `graduation_year` int NOT NULL,
  `tahun_ajaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `job` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `melanjutkan_sekolah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `testimonial` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of alumni
-- ----------------------------
INSERT INTO `alumni` VALUES (1, 'Dimas Prayoga', 2023, NULL, 'Software Engineer di Tokopedia', NULL, '081299887766', 'dimas.prayoga@gmail.com', 'Belajar di SMK Yapisda Cisoka membuka wawasan saya di bidang teknologi. Guru-gurunya sangat suportif dan fasilitas laboratorium komputernya lengkap sekali!', 1, '2026-05-27 07:46:59', '2026-05-27 13:29:06');
INSERT INTO `alumni` VALUES (2, 'Dewi Safitri', 2024, NULL, 'Quality Control di PT. Gajah Tunggal', NULL, '081344556677', 'dewi.safitri@yahoo.com', 'Disiplin yang diajarkan selama sekolah sangat membantu saya beradaptasi cepat dengan lingkungan pabrik yang membutuhkan presisi tinggi. Bangga jadi alumni Yapisda!', 1, '2026-05-27 07:46:59', '2026-05-27 13:29:09');

-- ----------------------------
-- Table structure for announcements
-- ----------------------------
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `announcements_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of announcements
-- ----------------------------
INSERT INTO `announcements` VALUES (1, 'Pengumuman Libur Hari Raya Idul Fitri 1447 H', 'pengumuman-libur-hari-raya-idul-fitri-1447-h', 'Sehubungan dengan datangnya Hari Raya Idul Fitri 1447 H, maka kegiatan pembelajaran diliburkan mulai tanggal 25 Mei hingga 2 Juni 2026. Pembelajaran aktif kembali tanggal 3 Juni 2026.', '2026-05-24', '2026-05-27 07:46:59', '2026-05-27 07:46:59');
INSERT INTO `announcements` VALUES (2, 'Pembagian Raport Semester Genap Tahun Ajaran 2025/2026', 'pembagian-raport-semester-genap-tahun-ajaran-20252026', 'Diinformasikan kepada seluruh orang tua/wali murid bahwa pembagian Raport Semester Genap akan dilaksanakan pada tanggal 20 Juni 2026 di kelas masing-masing, dimulai pukul 08.00 WIB.', '2026-06-15', '2026-05-27 07:46:59', '2026-05-27 07:46:59');

-- ----------------------------
-- Table structure for carousels
-- ----------------------------
DROP TABLE IF EXISTS `carousels`;
CREATE TABLE `carousels`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `subtitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `button_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `button_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `order_index` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of carousels
-- ----------------------------
INSERT INTO `carousels` VALUES (1, 'carousel_1780138035_717.png', NULL, NULL, NULL, NULL, 1, 1, '2026-05-28 02:44:36', '2026-05-30 10:48:19');
INSERT INTO `carousels` VALUES (2, 'carousel_1780138307_848.png', NULL, NULL, NULL, NULL, 0, 1, '2026-05-30 10:03:51', '2026-05-30 10:51:47');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `categories_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Kegiatan Sekolah', 'kegiatan-sekolah', '2026-05-27 07:46:59', '2026-05-27 07:46:59');
INSERT INTO `categories` VALUES (2, 'Pendidikan', 'pendidikan', '2026-05-27 07:46:59', '2026-05-27 07:46:59');
INSERT INTO `categories` VALUES (3, 'Prestasi', 'prestasi', '2026-05-27 07:46:59', '2026-05-27 07:46:59');
INSERT INTO `categories` VALUES (4, 'Tips & Trik', 'tips-dan-trik', '2026-05-27 07:46:59', '2026-05-27 07:46:59');

-- ----------------------------
-- Table structure for extracurriculars
-- ----------------------------
DROP TABLE IF EXISTS `extracurriculars`;
CREATE TABLE `extracurriculars`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `coach` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of extracurriculars
-- ----------------------------
INSERT INTO `extracurriculars` VALUES (1, 'Pramuka (Scout)', 'Ekskul wajib pembentuk kedisiplinan, kemandirian, kepemimpinan, dan kerja sama tim.', '1780133774_pramuka-scout.jpg', 'Jaka Tarub, S.Pd.', '2026-05-27 07:46:59', '2026-05-30 09:36:14');
INSERT INTO `extracurriculars` VALUES (2, 'Paskibra', 'Melatih ketangkasan baris-berbaris, disiplin tinggi, fisik prima, dan cinta tanah air.', '1780133618_paskibra.jpg', 'Slamet Riyadi, S.H.', '2026-05-27 07:46:59', '2026-05-30 09:33:38');
INSERT INTO `extracurriculars` VALUES (3, 'Hadroh & Rohis', 'Pengembangan seni musik religi islami dan kajian kerohanian islam pembentuk akhlak karimah.', '1780133708_hadroh-rohis.jpg', 'Ust. M. Ridwan, S.Ag.', '2026-05-27 07:46:59', '2026-05-30 09:35:08');
INSERT INTO `extracurriculars` VALUES (4, 'IT CLUB', 'IT Club adalah wadah bagi siswa yang memiliki minat dan bakat di bidang teknologi informasi untuk belajar, berkreasi, dan mengembangkan keterampilan digital secara aktif dan inovatif.', '1780133458_it-club.png', 'Ahmad Wihardi', '2026-05-30 09:30:58', '2026-05-30 09:32:20');

-- ----------------------------
-- Table structure for facilities
-- ----------------------------
DROP TABLE IF EXISTS `facilities`;
CREATE TABLE `facilities`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of facilities
-- ----------------------------
INSERT INTO `facilities` VALUES (1, 'Laboratorium Komputer TKJ', 'Laboratorium berstandar industri dengan spesifikasi PC modern, server Cisco, Mikrotik Router, dan AC pendingin demi kenyamanan siswa.', '1780137607_laboratorium-komputer-tkj.jpg', '2026-05-27 07:46:59', '2026-05-30 10:40:07');
INSERT INTO `facilities` VALUES (2, 'Bengkel Praktik TKR', 'Bengkel luas dengan alat hidrolik, pembongkar mesin, kompresor, alat ukur elektrikal, serta motor dan mobil unit praktik langsung.', '1780137551_bengkel-praktik-tbsm-tkr.jpg', '2026-05-27 07:46:59', '2026-05-30 10:40:30');
INSERT INTO `facilities` VALUES (3, 'Perpustakaan Digital', 'Menyediakan ribuan buku pelajaran, novel, ensiklopedia fisik serta portal e-book yang bisa diakses di PC perpustakaan.', 'perpus.jpg', '2026-05-27 07:46:59', '2026-05-27 07:46:59');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for majors
-- ----------------------------
DROP TABLE IF EXISTS `majors`;
CREATE TABLE `majors`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of majors
-- ----------------------------
INSERT INTO `majors` VALUES (1, 'Teknik Komputer & Jaringan (TKJ)', 'Mempelajari instalasi jaringan komputer LAN, WAN, administrasi server, konfigurasi mikrotik & cisco router, serat optik (fiber optic), serta perakitan dan troubleshooting PC.', NULL, '2026-05-30 04:06:40', '2026-05-30 04:06:40');
INSERT INTO `majors` VALUES (2, 'Rekayasa Perangkat Lunak (RPL)', 'Mempelajari pemrograman web dasar dan lanjutan, pengembangan aplikasi mobile, administrasi basis data relasional (MySQL/PostgreSQL), konsep pemrograman berorientasi objek (PBO), serta UI/UX design.', NULL, '2026-05-30 04:06:40', '2026-05-30 04:06:40');
INSERT INTO `majors` VALUES (3, 'Teknik Kendaraan Ringan (TKR)', 'Mempelajari servis berkala mesin bensin dan diesel, pembongkaran transmisi manual/otomatis, sistem suspensi dan kemudi, kelistrikan bodi otomotif, serta diagnosa sistem EFI.', '1780114274_teknik-kendaraan-ringan-tkr.png', '2026-05-30 04:06:40', '2026-05-30 04:11:14');

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES (1, 'Rahmat Hidayat', 'rahmat.h@gmail.com', 'Pertanyaan Kemitraan Magang', 'Halo Admin, saya perwakilan dari CV Mitra Solusindo ingin menanyakan bagaimana prosedur untuk mengajukan kemitraan penerimaan magang siswa TKJ SMK Yapisda. Terima kasih.', '2026-05-27 07:46:59', '2026-05-27 07:46:59');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2026_05_27_074531_create_school_tables', 1);
INSERT INTO `migrations` VALUES (6, '2026_05_27_122501_add_tahun_ajaran_to_alumni_table', 2);
INSERT INTO `migrations` VALUES (7, '2026_05_27_122624_create_carousels_table', 2);
INSERT INTO `migrations` VALUES (8, '2026_05_27_131123_add_theme_to_settings_table', 3);
INSERT INTO `migrations` VALUES (9, '2026_05_27_132616_add_is_approved_to_alumni_table', 4);
INSERT INTO `migrations` VALUES (10, '2026_05_27_134612_add_whatsapp_fields_to_settings_table', 5);
INSERT INTO `migrations` VALUES (11, '2026_05_28_000001_create_roles_table', 6);
INSERT INTO `migrations` VALUES (12, '2026_05_28_000002_add_role_id_to_users_table', 6);
INSERT INTO `migrations` VALUES (13, '2026_05_30_105600_add_jenjang_to_settings_table', 7);
INSERT INTO `migrations` VALUES (14, '2026_05_30_110200_create_majors_table', 8);
INSERT INTO `migrations` VALUES (15, '2026_05_30_111600_add_melanjutkan_sekolah_to_alumni_table', 9);
INSERT INTO `migrations` VALUES (16, '2026_05_30_113400_add_slogan_to_settings_table', 10);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` enum('draft','published') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `views` int NOT NULL DEFAULT 0,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `posts_slug_unique`(`slug` ASC) USING BTREE,
  INDEX `posts_category_id_foreign`(`category_id` ASC) USING BTREE,
  INDEX `posts_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES (1, 'Pelepasan dan Wisuda Siswa Kelas XII Angkatan 2025/2026', 'pelepasan-dan-wisuda-siswa-kelas-xii-angkatan-20252026-1', 1, '<p>SKOLABS menyelenggarakan acara pelepasan dan wisuda untuk siswa kelas XII angkatan 2025/2026. Acara yang berlangsung khidmat ini dihadiri oleh para jajaran pengurus yayasan, kepala sekolah, guru, staf, serta orang tua wisudawan. Selamat atas kelulusannya, semoga sukses di dunia kerja maupun jenjang pendidikan berikutnya!</p>', '1780136709_pelepasan-dan-wisuda-siswa-kelas-xii-angkatan-20252026.jpg', 'published', 132, 1, '2026-05-27 07:46:59', '2026-05-30 10:56:25');
INSERT INTO `posts` VALUES (2, 'Kerjasama Industri: Penandatanganan MoU dengan PT. Astra Honda Motor', 'kerjasama-industri-penandatanganan-mou-dengan-pt-astra-honda-motor-2', 2, '<p>Dalam rangka meningkatkan kompetensi siswa Program Keahlian Teknik Bisnis Sepeda Motor (TBSM), SMK SKOLABS menandatangani kesepakatan kerjasama (MoU) dengan PT. Astra Honda Motor. Kerjasama ini meliputi penyelarasan kurikulum, magang guru dan siswa, serta penyerapan lulusan.</p>', '1780136839_kerjasama-industri-penandatanganan-mou-dengan-pt-astra-honda-motor.jpg', 'published', 91, 1, '2026-05-27 07:46:59', '2026-05-30 10:27:19');
INSERT INTO `posts` VALUES (3, 'Juara I Lomba Kompetensi Siswa (LKS) Tingkat Kabupaten Tangerang', 'juara-i-lomba-kompetensi-siswa-lks-tingkat-kabupaten-tangerang-3', 3, '<p>Prestasi membanggakan diraih oleh siswa SKOLABS bidang Lomba IT Network System Administration dalam ajang LKS Tingkat Kabupaten Tangerang. Juara I diraih oleh ananda Ahmad Fauzi kelas XI Teknik Komputer Jaringan. Selamat atas perjuangan hebatnya!</p>', '1780137147_juara-i-lomba-kompetensi-siswa-lks-tingkat-kabupaten-tangerang.jpg', 'published', 211, 1, '2026-05-27 07:46:59', '2026-05-30 10:32:27');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_unique`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'admin', 'Administrator', 'Memiliki akses penuh ke seluruh fitur sistem.', '2026-05-28 02:36:34', '2026-05-28 02:36:34');
INSERT INTO `roles` VALUES (2, 'editor', 'Editor', 'Memiliki akses untuk mengelola blog, artikel, pengumuman, dan agenda.', '2026-05-28 02:36:34', '2026-05-28 02:36:34');
INSERT INTO `roles` VALUES (3, 'operator', 'Operator', 'Memiliki akses untuk mengelola data sekolah, guru, ekskul, dan prestasi.', '2026-05-28 02:36:34', '2026-05-28 02:36:34');

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slogan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jenjang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `school_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `principal_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `principal_speech` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `principal_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vision` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `mission` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `maps_iframe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `external_ppdb_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `facebook_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `instagram_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `youtube_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `theme` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `whatsapp_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `whatsapp_welcome_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'SKOLABS', 'Unggul, Kompeten dan Berkarakter', 'smk', 'logo_1780055615.png', 'Maulana Hasanudin, M.Pd.', 'Selamat datang di website resmi SKOLABS. Kami berkomitmen untuk menyelenggarakan pendidikan vokasi yang bermutu, unggul, dan berkarakter islami guna mempersiapkan lulusan yang siap kerja, berwirausaha, dan bersaing di era global. Melalui integrasi kurikulum industri dan pembinaan akhlak mulia, kami terus berupaya mencetak generasi emas bangsa.', 'principal_1780137898.png', 'Terwujudnya Sekolah sebagai lembaga pendidikan vokasi yang unggul, berkarakter islami, menguasai IPTEK, dan berdaya saing global.', '1. Menyelenggarakan proses pembelajaran yang berbasis kompetensi dan link and match dengan dunia usaha/industri.\r\n2. Mengembangkan karakter siswa yang berakhlak mulia, disiplin, bertanggung jawab, dan berjiwa wirausaha.\r\n3. Menyediakan sarana dan prasarana praktik kejuruan yang modern dan sesuai standar industri.\r\n4. Meningkatkan profesionalisme pendidik dan tenaga kependidikan secara berkelanjutan.\r\n5. Membangun kemitraan strategis dengan dunia industri dalam penyerapan lulusan dan magang kerja.', 'Kabupaten Tangerang, Banten 15730', 'info@skolabs.web.id', '(021) 5968123', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.113063080775!2d106.4253331!3d-6.2488344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e420790757a3e79%3A0xe7f9ab7c31db3eb9!2sSMK%20YAPISDA%20CISOKA!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://skolabs.web.id/', 'https://skolabs.web.id/', 'https://skolabs.web.id/', 'https://skolabs.web.id/', 'amethyst', '6281234567890', 'Halo! Terima kasih telah mengunjungi SMK SKOLABS. Ada yang bisa kami bantu? Silakan hubungi kami via WhatsApp.', '2026-05-27 07:46:59', '2026-05-30 10:44:58');

-- ----------------------------
-- Table structure for teachers
-- ----------------------------
DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of teachers
-- ----------------------------
INSERT INTO `teachers` VALUES (1, '198804122019031002', 'Ahmad Subarjo, S.Kom.', 'Kepala Program TKJ', '1779868835_ahmad-subarjo-skom.png', 1, '2026-05-27 07:46:59', '2026-05-30 09:44:57');
INSERT INTO `teachers` VALUES (2, '199012052021022004', 'Siti Aminah, S.Pd.', 'Guru Bahasa Inggris', '1780134253_siti-aminah-spd.jpg', 1, '2026-05-27 07:46:59', '2026-05-30 09:44:13');
INSERT INTO `teachers` VALUES (3, NULL, 'Budi Santoso, S.T.', 'Guru Produktif TKR', '1780134348_budi-santoso-st.jpg', 1, '2026-05-27 07:46:59', '2026-05-30 09:45:48');
INSERT INTO `teachers` VALUES (4, '19876365336356533', 'Ahmad Wihardi', 'Guru Produktif TKJ', '1780133983_ahmad-wihardi.jpg', 1, '2026-05-30 09:39:43', '2026-05-30 09:39:43');
INSERT INTO `teachers` VALUES (5, '19876365336356533', 'Andi Supriyanto', 'Guru', '1780134614_andi-supriyanto.jpg', 1, '2026-05-30 09:50:14', '2026-05-30 09:50:14');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  INDEX `users_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 1, 'Minda', 'minda@gmail.com', '2026-05-27 07:46:59', '$2y$10$HZFr.a11QvwgSu0dBr23.ek8hsPHqsTnQlRLgRhCM5wSWFmQpaNpK', NULL, '2026-05-27 07:46:59', '2026-05-29 11:49:11');

SET FOREIGN_KEY_CHECKS = 1;
