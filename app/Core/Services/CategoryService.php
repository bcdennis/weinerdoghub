<?php
namespace Smile\Core\Services;

use Smile\Core\Contracts\Image\UploaderContract;
use Smile\Core\Persistence\Models\Category;
use Smile\Core\Persistence\Repositories\CategoryContract;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CategoryService
{

    /**
     * @var CategoryContract
     */
    private $category;
    /**
     * @var UploaderContract
     */
    private $image;

    /**
     * @param CategoryContract $category
     * @param UploaderContract $image
     */
    public function __construct(CategoryContract $category, UploaderContract $image)
    {
        $this->category = $category;
        $this->image = $image;
    }

    /**
     * Return all categories
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->category->all();
    }

    /**
     * Get active categories
     *
     * @return mixed
     */
    public function active()
    {
        return $this->category->allActive();
    }

    /**
     * Create a new category
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $icon = $data['icon'];

        $category = $this->category->create([
            'title' => $data['title'],
            'slug' => str_slug($data['title']),
            'template' => $data['template'] == 'null' ? '' : $data['template'],
            'description' => $data['description'],
            'position' => $this->category->latestPosition() + 1
        ]);

        if ($data['icon'] instanceof UploadedFile) {
            $icon = $this->image->icon($category, $data['icon']);
        }

        $category = $this->category->update($category, [
            'icon' => $icon,
        ]);

        return $category;
    }

    /**
     * Update category
     *
     * @param Category $category
     * @param array $data
     * @return Category
     */
    public function update(Category $category, array $data)
    {
        $category = $this->category->update($category, [
            'title' => $data['title'],
            'template' => $data['template'] == 'null' ? '' : $data['template'],
            'slug' => str_slug($data['title']),
            'description' => $data['description'],
        ]);

        if ($data['icon'] instanceof UploadedFile) {
            $icon = $this->image->icon($category, $data['icon']);
            $this->category->update($category, [
                'icon' => $icon,
            ]);
        }

        return $category;
    }

    /**
     * Set category status
     *
     * @param $id
     * @param $active
     * @return bool
     */
    public function status($id, $active)
    {
        $category = $this->category->findById($id);

        if ($category) {
            return $this->category->update($category, [
                'active' => (bool) $active
            ]);
        }

        return false;
    }

    /**
     * Delete category by id
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        $category = $this->category->findById($id);

        if ($category) {
            if ($category->icon) {
                $this->image->removeIcon($category);
            }
            $this->category->delete($category);
            return true;
        }

        return false;
    }

    /**
     * Order categories
     *
     * @param $order
     * @return bool
     */
    public function order($order)
    {
        foreach ($order as $pos => $id)
        {
            $category = $this->category->findById($id);

            if ($category) {
                $this->category->update($category, [
                    'position' => $pos,
                ]);
            }
        }

        return true;
    }

    /**
     * Find category by id
     *
     * @param $id
     * @return \Smile\Core\Persistence\Models\Category
     */
    public function findById($id)
    {
        return $this->category->findById($id);
    }
}
