<?php

namespace Themes\Site\Http\Controllers;

use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Smile\Core\Persistence\Repositories\CategoryContract;
use Smile\Core\Persistence\Repositories\NotificationContract;
use Smile\Core\Persistence\Repositories\PostContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotificationsController extends BaseSiteController {

    /**
     * Current user
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $currentUser;

    /**
     * @var NotificationContract
     */
    private $notification;

    /**
     * @param NotificationContract $notification
     * @param Guard $auth
     */
    public function __construct(NotificationContract $notification, Guard $auth)
    {
        $this->currentUser = $auth->user();
        $this->notification = $notification;
    }

    /**
     * Mark notifications as readed
     *
     * @param Request $request
     * @return array
     */
    public function read($id, Request $request)
    {
        $notification = $this->notification->findById($id);

        if ($notification && $this->currentUser && $notification->user_id == $this->currentUser->id) {
            $this->notification->delete($notification);
            return redirect()->to($notification->url);
        }

        return redirect()->route('home');
    }

    /**
     * Delete all the notifications
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAll()
    {
        $this->notification->deleteAll($this->currentUser);

        return redirect()->back();
    }

    /**
     * Notifications
     *
     * @param Request $request
     * @return array|\Illuminate\View\View
     */
    public function all(Request $request)
    {
        $notifications = $this->notification->search($this->currentUser, 10);

        if ($request->has('ajax')) {
            return $this->jsonPagination($notifications, $this->view('ajax.notifications', compact('notifications')));
        }

        return $this->view('notifications.list', compact('notifications'));
    }
}
