<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\ExtracurricularController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AlumniController as AdminAlumniController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\PortalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// ==========================================
// 1. PUBLIC PORTAL FRONTEND ROUTES
// ==========================================
Route::get('/', [PortalController::class, 'index'])->name('home');
Route::get('/sambutan', [PortalController::class, 'sambutan'])->name('portal.sambutan');
Route::get('/visi-misi', [PortalController::class, 'visiMisi'])->name('portal.visi-misi');
Route::get('/guru', [PortalController::class, 'guru'])->name('portal.guru');
Route::get('/ekskul', [PortalController::class, 'ekskul'])->name('portal.ekskul');
Route::get('/fasilitas', [PortalController::class, 'fasilitas'])->name('portal.fasilitas');
Route::get('/jurusan', [PortalController::class, 'jurusan'])->name('portal.jurusan');
Route::get('/artikel', [PortalController::class, 'artikel'])->name('portal.artikel');
Route::get('/artikel/kategori/{slug}', [PortalController::class, 'artikelKategori'])->name('portal.artikel.category');
Route::get('/artikel/{slug}', [PortalController::class, 'artikelDetail'])->name('portal.artikel.detail');
Route::get('/pengumuman', [PortalController::class, 'pengumuman'])->name('portal.pengumuman');
Route::get('/pengumuman/{slug}', [PortalController::class, 'pengumumanDetail'])->name('portal.pengumuman.detail');
Route::get('/agenda', [PortalController::class, 'agenda'])->name('portal.agenda');
Route::get('/prestasi', [PortalController::class, 'prestasi'])->name('portal.prestasi');
Route::get('/alumni', [PortalController::class, 'alumni'])->name('portal.alumni');
Route::post('/alumni/store', [PortalController::class, 'alumniStore'])->name('portal.alumni.store')->middleware('throttle:5,1');
Route::get('/hubungi', [PortalController::class, 'hubungi'])->name('portal.hubungi');
Route::post('/hubungi/kirim', [PortalController::class, 'hubungiKirim'])->name('portal.hubungi.kirim')->middleware('throttle:5,1');
Route::get('/ppdb', [PortalController::class, 'ppdb'])->name('portal.ppdb');

// ==========================================
// 2. AUTHENTICATION ROUTES
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. ADMIN BACKEND ROUTES (AUTH)
// ==========================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // School Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('admin.settings.update');

    // Data Guru & Staff
    Route::get('/teachers', [TeacherController::class, 'index'])->name('admin.teachers');
    Route::get('/teachers/data', [TeacherController::class, 'getData'])->name('admin.teachers.data');
    Route::post('/teachers/store', [TeacherController::class, 'store'])->name('admin.teachers.store');
    Route::get('/teachers/show/{id}', [TeacherController::class, 'show'])->name('admin.teachers.show');
    Route::post('/teachers/update/{id}', [TeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/teachers/destroy/{id}', [TeacherController::class, 'destroy'])->name('admin.teachers.destroy');

    // Fasilitas Sekolah
    Route::get('/facilities', [FacilityController::class, 'index'])->name('admin.facilities');
    Route::get('/facilities/data', [FacilityController::class, 'getData'])->name('admin.facilities.data');
    Route::post('/facilities/store', [FacilityController::class, 'store'])->name('admin.facilities.store');
    Route::get('/facilities/show/{id}', [FacilityController::class, 'show'])->name('admin.facilities.show');
    Route::post('/facilities/update/{id}', [FacilityController::class, 'update'])->name('admin.facilities.update');
    Route::delete('/facilities/destroy/{id}', [FacilityController::class, 'destroy'])->name('admin.facilities.destroy');

    // Ekstrakurikuler
    Route::get('/extracurriculars', [ExtracurricularController::class, 'index'])->name('admin.extracurriculars');
    Route::get('/extracurriculars/data', [ExtracurricularController::class, 'getData'])->name('admin.extracurriculars.data');
    Route::post('/extracurriculars/store', [ExtracurricularController::class, 'store'])->name('admin.extracurriculars.store');
    Route::get('/extracurriculars/show/{id}', [ExtracurricularController::class, 'show'])->name('admin.extracurriculars.show');
    Route::post('/extracurriculars/update/{id}', [ExtracurricularController::class, 'update'])->name('admin.extracurriculars.update');
    Route::delete('/extracurriculars/destroy/{id}', [ExtracurricularController::class, 'destroy'])->name('admin.extracurriculars.destroy');

    // Jurusan / Program Keahlian
    Route::get('/majors', [MajorController::class, 'index'])->name('admin.majors');
    Route::get('/majors/data', [MajorController::class, 'getData'])->name('admin.majors.data');
    Route::post('/majors/store', [MajorController::class, 'store'])->name('admin.majors.store');
    Route::get('/majors/show/{id}', [MajorController::class, 'show'])->name('admin.majors.show');
    Route::post('/majors/update/{id}', [MajorController::class, 'update'])->name('admin.majors.update');
    Route::delete('/majors/destroy/{id}', [MajorController::class, 'destroy'])->name('admin.majors.destroy');

    // Kategori Artikel
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::get('/categories/data', [CategoryController::class, 'getData'])->name('admin.categories.data');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/show/{id}', [CategoryController::class, 'show'])->name('admin.categories.show');
    Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Daftar Artikel/Blog
    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts');
    Route::get('/posts/data', [PostController::class, 'getData'])->name('admin.posts.data');
    Route::post('/posts/store', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/show/{id}', [PostController::class, 'show'])->name('admin.posts.show');
    Route::post('/posts/update/{id}', [PostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts/destroy/{id}', [PostController::class, 'destroy'])->name('admin.posts.destroy');

    // Pengumuman
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements');
    Route::get('/announcements/data', [AnnouncementController::class, 'getData'])->name('admin.announcements.data');
    Route::post('/announcements/store', [AnnouncementController::class, 'store'])->name('admin.announcements.store');
    Route::get('/announcements/show/{id}', [AnnouncementController::class, 'show'])->name('admin.announcements.show');
    Route::post('/announcements/update/{id}', [AnnouncementController::class, 'update'])->name('admin.announcements.update');
    Route::delete('/announcements/destroy/{id}', [AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');

    // Agenda Kegiatan
    Route::get('/agendas', [AgendaController::class, 'index'])->name('admin.agendas');
    Route::get('/agendas/data', [AgendaController::class, 'getData'])->name('admin.agendas.data');
    Route::post('/agendas/store', [AgendaController::class, 'store'])->name('admin.agendas.store');
    Route::get('/agendas/show/{id}', [AgendaController::class, 'show'])->name('admin.agendas.show');
    Route::post('/agendas/update/{id}', [AgendaController::class, 'update'])->name('admin.agendas.update');
    Route::delete('/agendas/destroy/{id}', [AgendaController::class, 'destroy'])->name('admin.agendas.destroy');

    // Prestasi Siswa
    Route::get('/achievements', [AchievementController::class, 'index'])->name('admin.achievements');
    Route::get('/achievements/data', [AchievementController::class, 'getData'])->name('admin.achievements.data');
    Route::post('/achievements/store', [AchievementController::class, 'store'])->name('admin.achievements.store');
    Route::get('/achievements/show/{id}', [AchievementController::class, 'show'])->name('admin.achievements.show');
    Route::post('/achievements/update/{id}', [AchievementController::class, 'update'])->name('admin.achievements.update');
    Route::delete('/achievements/destroy/{id}', [AchievementController::class, 'destroy'])->name('admin.achievements.destroy');

    // Database Alumni
    Route::get('/alumni', [AdminAlumniController::class, 'index'])->name('admin.alumni');
    Route::get('/alumni/data', [AdminAlumniController::class, 'getData'])->name('admin.alumni.data');
    Route::get('/alumni/export', [AdminAlumniController::class, 'export'])->name('admin.alumni.export');
    Route::post('/alumni/store', [AdminAlumniController::class, 'store'])->name('admin.alumni.store');
    Route::get('/alumni/show/{id}', [AdminAlumniController::class, 'show'])->name('admin.alumni.show');
    Route::post('/alumni/update/{id}', [AdminAlumniController::class, 'update'])->name('admin.alumni.update');
    Route::delete('/alumni/destroy/{id}', [AdminAlumniController::class, 'destroy'])->name('admin.alumni.destroy');
    Route::post('/alumni/toggle-approve/{id}', [AdminAlumniController::class, 'toggleApprove'])->name('admin.alumni.toggle-approve');

    // Hero Slider Carousel Settings
    Route::get('/carousels', [CarouselController::class, 'index'])->name('admin.carousels.index');
    Route::get('/carousels/data', [CarouselController::class, 'getData'])->name('admin.carousels.data');
    Route::post('/carousels/store', [CarouselController::class, 'store'])->name('admin.carousels.store');
    Route::get('/carousels/show/{id}', [CarouselController::class, 'show'])->name('admin.carousels.show');
    Route::post('/carousels/update/{id}', [CarouselController::class, 'update'])->name('admin.carousels.update');
    Route::delete('/carousels/destroy/{id}', [CarouselController::class, 'destroy'])->name('admin.carousels.destroy');

    // Pesan Masuk
    Route::get('/messages', [MessageController::class, 'index'])->name('admin.messages');
    Route::get('/messages/data', [MessageController::class, 'getData'])->name('admin.messages.data');
    Route::get('/messages/show/{id}', [MessageController::class, 'show'])->name('admin.messages.show');
    Route::delete('/messages/destroy/{id}', [MessageController::class, 'destroy'])->name('admin.messages.destroy');

    // Manajemen Akses (User & Role)
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles');
    Route::get('/roles/data', [RoleController::class, 'getData'])->name('admin.roles.data');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/data', [UserController::class, 'getData'])->name('admin.users.data');
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('admin.users.show');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
