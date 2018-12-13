<?php

namespace Themes\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Smile\Core\Services\CategoryService;

class CategoriesController extends BaseAdminController
{
    /**
     * @var CategoryService
     */
    private $category;

    /**
     * @param CategoryService $category
     */
    public function __construct(CategoryService $category)
    {
        $this->middleware('auth.admin');

        $this->category = $category;
    }

    /**
     * Get all categories
     *
     * @return \Illuminate\View\View
     */
    public function all()
    {
        $categories = $this->category->all();

        return $this->view('categories.list', compact('categories'));
    }

    /**
     * Get all categories
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $cat = $this->category->findById($id);

        if ( ! $cat) {
            return redirect()->back();
        }

        $categories = $this->category->all();

        return $this->view('categories.list', compact('categories', 'cat'));
    }

    /**
     * Store categories new informations
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doEdit($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:categories,id,'.$id,
            'description' => 'max:150',
            'template' => 'required',
            'icon' => 'image'
        ]);

        $category = $this->category->findById($id);

        if ( ! $category || $this->ensure('admin')) {
            return redirect()->back();
        }

        $data = $request->only('title', 'description', 'template', 'icon');

        $this->category->update($category, $data);

        return redirect()->route('admin.categories');
    }

    /**
     * Create category
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:categories',
            'description' => 'max:150',
            'template' => 'required',
            'icon' => 'image'
        ]);

        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $data = $request->only('title', 'description', 'template', 'icon');

        $this->category->create($data);

        return redirect()->route('admin.categories');
    }

    /**
     * Set category status
     *
     * @param $id
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function status($id, Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->category->status($id, $request->get('active', false));

        if ($request->ajax()) {
            return [];
        }

        return redirect()->route('admin.categories');
    }

    /**
     * Order categories
     *
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    protected function order(Request $request)
    {
        if ($page = $this->ensure('admin')) {
            return [];
        }

        $this->category->order($request->get('order'));

        if ($request->ajax()) {
            return [];
        }

        return redirect()->route('admin.categories');
    }

    /**
     * Delete category by id
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $this->category->deleteById($id);

        return redirect()->route('admin.categories');
    }

}
