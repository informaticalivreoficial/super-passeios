<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CatPost;
use App\Models\Config;
use App\Models\Post;
use App\Support\Seo;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $seo, $config;

    public function __construct()
    {
        $this->seo = new Seo();
        $this->config = Config::where('id', 1)->firstOrFail();
    }

    public function index(Request $request)
    {
        $articles = Post::query()
            ->where('type', 'artigo')
            ->Postson()
            ->where(function ($query) {
                $query->whereNull('publish_at')
                      ->orWhere('publish_at', '<=', now());
            })
            ->orderByDesc('publish_at')
            ->orderByDesc('created_at')
            ->paginate(18);

        $head = $this->seo->render('Blog - ' . $this->config->app_name . '' ?? config('app.name'),
            'Blog - ' . $this->config->app_name . '' ?? config('app.name'),
            route('web.home'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );

        return view('web.' . $this->config->template . '.blog.index', [
            'head' => $head,
            'articles' => $articles
        ]);
    }

    public function show(string $slug)
    {
        $article = Post::query()
            ->where('type', 'artigo')
            ->where('slug', $slug)
            ->Postson()
            ->with('images') // eager load
            ->firstOrFail();

        $article->increment('views');

        $related = Post::query()
            ->where('type', 'artigo')
            ->Postson()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->latest('publish_at')
            ->take(3)
            ->get();
        
        $head = $this->seo->render($article->title . ' - ' . $this->config->app_name . '' ?? config('app.name'),
            $article->metaDescription ?? $article->excerpt,
            route('web.blog.show', ['slug' => $article->slug]),
            $article->cover() ?? $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );

        return view('web.' . $this->config->template . '.blog.article', [
            'article' => $article,
            'related' => $related,
            'head' => $head
        ]);
    }

    public function category(string $slug)
    {
        $category = CatPost::where('slug', $slug)->firstOrFail();

        $articles = Post::query()
            ->where('type', 'artigo')
            ->Postson()
            ->where('category', $category->id)
            ->orderByDesc('publish_at')
            ->paginate(18);

        return view('web.' . $this->config->template . '.blog.category', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }

    public function page(string $slug)
    {
        $page = Post::query()
            ->where('type', 'pagina')
            ->where('slug', $slug)
            ->Postson()
            ->firstOrFail();

        $head = $this->seo->render($page->title . ' - ' . $this->config->app_name . '' ?? config('app.name'),
            $page->metaDescription ?? $page->excerpt,
            route('web.blog.page', ['slug' => $page->slug]),
            $page->cover() ?? $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        ); 

        return view('web.' . $this->config->template . '.blog.page', [
            'page' => $page,
            'head' => $head
        ]);
    }
}
