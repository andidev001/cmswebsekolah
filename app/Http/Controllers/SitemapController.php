<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')->latest()->get();

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Static Pages
        $staticRoutes = [
            'home', 'portal.sambutan', 'portal.visi-misi', 'portal.kurikulum', 
            'portal.guru', 'portal.jurusan', 'portal.ekskul', 'portal.fasilitas', 
            'portal.artikel', 'portal.pengumuman', 'portal.unduhan', 'portal.video', 
            'portal.agenda', 'portal.prestasi', 'portal.alumni', 'portal.hubungi', 'portal.ppdb'
        ];

        foreach ($staticRoutes as $route) {
            $content .= '<url>';
            $content .= '<loc>' . route($route) . '</loc>';
            $content .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $content .= '<changefreq>weekly</changefreq>';
            $content .= '<priority>0.8</priority>';
            $content .= '</url>';
        }

        // Dynamic Posts
        foreach ($posts as $post) {
            $content .= '<url>';
            $content .= '<loc>' . route('portal.artikel.detail', $post->slug) . '</loc>';
            $content .= '<lastmod>' . $post->updated_at->toAtomString() . '</lastmod>';
            $content .= '<changefreq>monthly</changefreq>';
            $content .= '<priority>0.6</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200)->header('Content-Type', 'text/xml');
    }
}
