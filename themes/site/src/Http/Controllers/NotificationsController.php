<?php

namespace Themes\Site\Http\Controllers;

use Illuminate\Http\Request;
use Smile\Core\Persistence\Repositories\NotificationContract;

class NotificationsController extends BaseSiteController
{

    /**
     * @var NotificationContract
     */
    private $notification;

    /**
     * @param NotificationContract $notification
     */
    public function __construct(NotificationContract $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Mark notifications as read
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function read(Request $request, $id)
    {
        $user = $request->user();
        $notification = $this->notification->findById($id);

        if ($notification && $user && $notification->user_id == $user->id) {
            $this->notification->delete($notification);
            return redirect()->to($notification->url);
        }

        return redirect()->route('home');
    }

    /**
     * Delete all the notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAll(Request $request)
    {
        $this->notification->deleteAll($request->user());

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
        $notifications = $this->notification->search($request->user(), 10);

        if ($request->has('ajax')) {
            return $this->jsonPagination($notifications, $this->view('ajax.notifications', compact('notifications')));
        }

        return $this->view('notifications.list', compact('notifications'));
    }
}
