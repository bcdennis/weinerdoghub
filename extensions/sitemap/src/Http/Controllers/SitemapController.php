<?php
namespace Extensions\Sitemap\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Roumen\Sitemap\Sitemap;
use Smile\Core\Persistence\Repositories\CategoryContract;
use Smile\Core\Persistence\Repositories\PostContract;

class SitemapController extends Controller
{

    /**
     * @var Sitemap
     */
    private $sitemap;

    /**
     * @var CategoryContract
     */
    private $category;
    /**
     * @var PostContract
     */
    private $post;

    /**
     * @param CategoryContract $category
     * @param PostContract $post
     */
    public function __construct(CategoryContract $category, PostContract $post)
    {
        $this->sitemap = app('sitemap');

        $this->category = $category;
        $this->post = $post;
    }

    /**
     * Serve sitemap
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function serve()
    {
        $this->sitemap->setCache('laravel.sitemap', 3600);

        if ( ! $this->sitemap->isCached()) {
            $this->sitemap->add(route('home'), Carbon::now()->toW3cString(), '1.0', 'daily');

            foreach ($this->category->allActive() as $category) {
                $this->sitemap->add(route('home', $category->slug), null, '1.0', 'daily');
            }

            foreach ($this->post->search('', 50000) as $post) {
                $this->sitemap->add(route('post', $post->slug), $post->updated_at, '1.0', 'monthly');
            }
        }
        return $this->sitemap->render('xml');
    }

}
