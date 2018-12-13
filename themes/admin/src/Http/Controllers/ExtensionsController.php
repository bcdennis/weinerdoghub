<?php
namespace Themes\Admin\Http\Controllers;

use Smile\Core\Extensions\Manager;

class ExtensionsController extends BaseAdminController
{
    /**
     * @var Manager
     */
    protected $extensions;

    public function __construct()
    {
        $this->middleware('auth.admin');

        $this->extensions = app('extensions.manager');
    }

    /**
     * Get all the modules
     *
     * @return \Illuminate\View\View
     */
    public function all()
    {
        $extensions = $this->extensions->all();

        return $this->view('extensions.list', compact('extensions'));
    }

    /**
     * Install extension
     *
     * @param $extension
     * @return \Illuminate\Http\RedirectResponse
     */
    public function install($extension)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $extension = $this->extensions->findByName($extension);

        if ($extension && ! $extension->isInstalled() && ! $extension->isActive()) {
            $this->extensions->install($extension);
        }

        return redirect()->back();
    }
    /**
     * Uninstall extension
     *
     * @param $extension
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uninstall($extension)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $extension = $this->extensions->findByName($extension);

        if ($extension && $extension->isInstalled()) {
            $this->extensions->uninstall($extension);
        }

        return redirect()->back();
    }
    /**
     * Toggle extension status
     *
     * @param $extension
     * @return array
     */
    public function status($extension)
    {
        if ($page = $this->ensure('admin')) {
            return $page;
        }

        $extension = $this->extensions->findByName($extension);

        if ( ! $extension->isInstalled()) {
            return [];
        }

        if ($extension->isActive()) {
            $this->extensions->deactivate($extension);
        } else {
            $this->extensions->activate($extension);
        }

        return [];
    }

}
