<?php

use Illuminate\Database\Seeder;
use Smile\Core\Persistence\Repositories\CategoryContract;

class CategoryTableSeeder extends Seeder
{
    protected $data = [
        'All' => 'all',
        'Fresh' => 'fresh',
        'NSFW' => 'nsfw',
        'Gif' => 'gif',
        'Meme' => 'meme',
        'Video' => 'video',
        'Sound' => 'sound',
        'Vine' => 'vine',
    ];

    /**
     * @var CategoryContract
     */
    private $category;

    /**
     * @param CategoryContract $category
     */
    public function __construct(CategoryContract $category)
    {
        $this->category = $category;
    }

    public function run()
    {
        $pos = 0;

        foreach ($this->data as $category => $template)
        {
            $this->category->create([
                'title'    => $category,
                'slug'     => str_slug($category),
                'template' => $template,
                'active'   => true,
                'position' => $pos,
            ]);
            $pos++;
        }
    }
}