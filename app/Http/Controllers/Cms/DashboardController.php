<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\GalleryItem;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages' => CmsPage::count(),
            'posts' => Post::count(),
            'gallery' => GalleryItem::count(),
            'published_posts' => Post::where('is_published', true)->count(),
        ];

        $recentPosts = Post::query()
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('views.cms.dashboard', compact('stats', 'recentPosts'));
    }
}
