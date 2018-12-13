<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\Category;

interface CategoryContract
{
	/**
	 * Create a new category
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function create(array $data);

	/**
	 * Find category by slug
	 *
	 * @param $slug
	 * @return mixed
	 */
	public function findBySlug($slug);

	/**
	 * Find categories by slugs
	 *
	 * @param $slugs
	 */
	public function findBySlugs(array $slugs);

	/**
	 * Find categories slugs by template
	 *
	 * @param $template
	 * @return mixed
	 */
	public function findSlugsByTemplate($template);

    /**
     * Find category by id
     *
     * @param $id
     * @return Category
     */
    public function findById($id);

    /**
     * Find category latest position
     *
     * @return int
     */
    public function latestPosition();

	/**
	 * Get first category with posts
	 *
	 * @return mixed
	 */
	public function first();

	/**
	 * Get all categories
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all();

    /**
     * Get all active categories
     *
     * @return mixed
     */
    public function allActive();

    /**
     * Update category
     *
     * @param Category $category
     * @param array $data
     * @return mixed
     */
	public function update(Category $category, array $data);

    /**
     * Delete category
     *
     * @param Category $category
     * @return mixed
     */
    public function delete(Category $category);

}