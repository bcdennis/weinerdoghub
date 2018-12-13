<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Models\Category;
use Smile\Core\Persistence\Repositories\CategoryContract;

class CategoryRepository extends BaseRepository implements CategoryContract
{

    /**
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $category = $this->getNew();
        $category->fill($data);
        $category->save();

        return $category;
    }

    /**
     * Update category
     *
     * @param Category $category
     * @param array $data
     * @return mixed
     */
    public function update(Category $category, array $data)
    {
        $category->fill($data);
        $category->save();

        return $category;
    }

    /**
     * Delete category
     *
     * @param Category $category
     * @return mixed
     */
    public function delete(Category $category)
    {
        return $category->delete();
    }

    /**
     * Find category by slug
     *
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Find categories by slugs
     *
     * @param $slugs
     */
    public function findBySlugs(array $slugs)
    {
        return $this->model->whereIn('slug', $slugs)->get();
    }

    /**
     * Find category latest position
     *
     * @return int
     */
    public function latestPosition()
    {
        $category = $this->model->orderBy('position', 'desc')->orderBy('id', 'asc')->first();

        if ($category) {
            return $category->position;
        }

        return -1;
    }

    /**
     * Get first category with posts
     *
     * @return mixed
     */
    public function first()
    {
        return $this->model->orderBy('position', 'asc')->orderBy('id', 'asc')->first();
    }

    /**
     * Find categories slugs by template
     *
     * @param $template
     * @return mixed
     */
    public function findSlugsByTemplate($template)
    {
        return $this->model->where('template', $template)->lists('slug');
    }

    /**
     * Get all categories
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->orderBy('position', 'asc')->orderBy('id', 'asc')->get();
    }

    /**
     * Get all active categories
     *
     * @return mixed
     */
    public function allActive()
    {
        return $this->model->where('active', true)
            ->orderBy('position', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Find category by id
     *
     * @param $id
     * @return null|Category
     */
    public function findById($id)
    {
        return $this->model->where('id', $id)->first();
    }

}
