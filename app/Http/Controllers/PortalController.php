<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Teacher;
use App\Models\Facility;
use App\Models\Extracurricular;
use App\Models\Category;
use App\Models\Post;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\Achievement;
use App\Models\Alumni;
use App\Models\Message;
use App\Models\Carousel;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortalController extends Controller
{
    private function getSettings()
    {
        return Setting::firstOrCreate(['id' => 1], [
            'school_name' => 'SMK Yapisda Cisoka',
            'slogan' => 'Unggul, Berkarakter Islami & Berdaya Saing',
            'jenjang' => 'smk',
            'email' => 'info@smkyapisdacisoka.sch.id',
            'phone' => '(021) 5968123',
            'address' => 'Jl. Raya Cisoka No.15, Cisoka, Kec. Cisoka, Kabupaten Tangerang, Banten 15730',
        ]);
    }

    public function index()
    {
        $settings = $this->getSettings();
        $recent_posts = Post::with('category')->where('status', 'published')->latest()->limit(3)->get();
        $announcements = Announcement::latest()->limit(4)->get();
        $agendas = Agenda::latest()->limit(4)->get();
        $achievements = Achievement::latest()->limit(4)->get();
        $teachers_count = Teacher::where('is_active', true)->count();
        $ekskul_count = Extracurricular::count();
        $alumni_count = Alumni::count();
        $carousels = Carousel::where('is_active', true)->orderBy('order_index', 'asc')->get();
        $contact_captcha_question = $this->generateContactCaptcha();

        // Fetch teachers, extracurriculars, and facilities for homepage sections
        $teachers = Teacher::where('is_active', true)->get();
        $ekskuls = Extracurricular::all();
        $facilities = Facility::all();

        return view('portal.home', compact(
            'settings',
            'recent_posts',
            'announcements',
            'agendas',
            'achievements',
            'teachers_count',
            'ekskul_count',
            'alumni_count',
            'carousels',
            'contact_captcha_question',
            'teachers',
            'ekskuls',
            'facilities'
        ));
    }

    public function sambutan()
    {
        $settings = $this->getSettings();
        return view('portal.sambutan', compact('settings'));
    }

    public function visiMisi()
    {
        $settings = $this->getSettings();
        return view('portal.visi-misi', compact('settings'));
    }

    public function guru()
    {
        $settings = $this->getSettings();
        $teachers = Teacher::where('is_active', true)->get();
        return view('portal.guru', compact('settings', 'teachers'));
    }

    public function ekskul()
    {
        $settings = $this->getSettings();
        $ekskuls = Extracurricular::all();
        return view('portal.ekskul', compact('settings', 'ekskuls'));
    }

    public function fasilitas()
    {
        $settings = $this->getSettings();
        $facilities = Facility::all();
        return view('portal.fasilitas', compact('settings', 'facilities'));
    }

    public function artikel(Request $request)
    {
        $settings = $this->getSettings();
        $categories = Category::withCount('posts')->get();

        $query = Post::with('category')->where('status', 'published');
        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%')
                ->orWhere('content', 'like', '%' . $request->q . '%');
        }
        $posts = $query->latest()->paginate(6);

        return view('portal.artikel', compact('settings', 'posts', 'categories'));
    }

    public function artikelKategori($slug, Request $request)
    {
        $settings = $this->getSettings();
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::withCount('posts')->get();

        $query = Post::with('category')->where('status', 'published')->where('category_id', $category->id);
        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%')
                ->orWhere('content', 'like', '%' . $request->q . '%');
        }
        $posts = $query->latest()->paginate(6);

        return view('portal.artikel', compact('settings', 'posts', 'categories', 'category'));
    }

    public function artikelDetail($slug)
    {
        $settings = $this->getSettings();
        $post = Post::with(['category', 'user'])->where('slug', $slug)->firstOrFail();
        $post->increment('views');

        $recent_posts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest()->limit(5)->get();

        return view('portal.artikel-detail', compact('settings', 'post', 'recent_posts'));
    }

    public function pengumuman()
    {
        $settings = $this->getSettings();
        $announcements = Announcement::latest()->paginate(6);
        return view('portal.pengumuman', compact('settings', 'announcements'));
    }

    public function pengumumanDetail($slug)
    {
        $settings = $this->getSettings();
        $announcement = Announcement::where('slug', $slug)->firstOrFail();
        $recent_announcements = Announcement::where('id', '!=', $announcement->id)->latest()->limit(5)->get();
        return view('portal.pengumuman-detail', compact('settings', 'announcement', 'recent_announcements'));
    }

    public function agenda()
    {
        $settings = $this->getSettings();
        $agendas = Agenda::latest()->paginate(6);
        return view('portal.agenda', compact('settings', 'agendas'));
    }

    public function prestasi()
    {
        $settings = $this->getSettings();
        $achievements = Achievement::latest()->paginate(8);
        return view('portal.prestasi', compact('settings', 'achievements'));
    }

    private function generateCaptcha()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['alumni_captcha_ans' => $num1 + $num2]);
        return "$num1 + $num2 = ?";
    }

    private function generateContactCaptcha()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['contact_captcha_ans' => $num1 + $num2]);
        return "$num1 + $num2 = ?";
    }

    public function alumni()
    {
        $settings = $this->getSettings();
        $alumni = Alumni::where('is_approved', true)->latest()->paginate(10);
        $captcha_question = $this->generateCaptcha();

        return view('portal.alumni', compact('settings', 'alumni', 'captcha_question'));
    }

    public function alumniStore(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1970|max:' . (date('Y') + 1),
            'tahun_ajaran' => 'nullable|string|max:50',
            'job' => 'nullable|string|max:255',
            'melanjutkan_sekolah' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'testimonial' => 'nullable|string',
            'captcha' => 'required|integer',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'graduation_year.required' => 'Tahun lulus wajib diisi.',
            'captcha.required' => 'Jawaban captcha wajib diisi.',
            'captcha.integer' => 'Jawaban captcha harus berupa angka.',
        ]);

        if ($validator->fails()) {
            $new_captcha = $this->generateCaptcha();
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->toArray(),
                'new_captcha' => $new_captcha
            ], 422);
        }

        $captcha_ans = session('alumni_captcha_ans');
        if ($request->input('captcha') != $captcha_ans) {
            $new_captcha = $this->generateCaptcha();
            return response()->json([
                'success' => false,
                'errors' => ['captcha' => ['Jawaban captcha salah!']],
                'new_captcha' => $new_captcha
            ], 422);
        }

        Alumni::create($request->only(['name', 'graduation_year', 'tahun_ajaran', 'job', 'melanjutkan_sekolah', 'phone', 'email', 'testimonial']));

        $new_captcha = $this->generateCaptcha();

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih, data alumni Anda berhasil disimpan!',
            'new_captcha' => $new_captcha
        ]);
    }

    public function hubungi()
    {
        $settings = $this->getSettings();
        $contact_captcha_question = $this->generateContactCaptcha();
        return view('portal.hubungi', compact('settings', 'contact_captcha_question'));
    }

    public function hubungiKirim(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'captcha' => 'required|integer',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'message.required' => 'Pesan lengkap wajib diisi.',
            'captcha.required' => 'Jawaban captcha wajib diisi.',
            'captcha.integer' => 'Jawaban captcha harus berupa angka.',
        ]);

        if ($validator->fails()) {
            $new_captcha = $this->generateContactCaptcha();
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->toArray(),
                'new_captcha' => $new_captcha
            ], 422);
        }

        $captcha_ans = session('contact_captcha_ans');
        if ($request->input('captcha') != $captcha_ans) {
            $new_captcha = $this->generateContactCaptcha();
            return response()->json([
                'success' => false,
                'errors' => ['captcha' => ['Jawaban captcha salah!']],
                'new_captcha' => $new_captcha
            ], 422);
        }

        Message::create($request->only(['name', 'email', 'subject', 'message']));

        $new_captcha = $this->generateContactCaptcha();

        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda kembali.',
            'new_captcha' => $new_captcha
        ]);
    }

    public function jurusan()
    {
        $settings = $this->getSettings();
        if (!in_array($settings->jenjang, ['sma', 'smk'])) {
            abort(404);
        }
        $majors = Major::all();
        return view('portal.jurusan', compact('settings', 'majors'));
    }

    public function ppdb()
    {
        $settings = $this->getSettings();
        return view('portal.ppdb', compact('settings'));
    }
}
