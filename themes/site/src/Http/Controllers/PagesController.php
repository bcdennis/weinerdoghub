<?php

namespace Themes\Site\Http\Controllers;

use Smile\Http\Requests\ContactRequest;
use Smile\Core\Mailers\UserMailer;

class PagesController extends BaseSiteController {

    /**
     * Terms page
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return $this->view('pages.terms');
    }

    /**
     * Privacy page
     *
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return $this->view('pages.privacy');
    }

    /**
     * About page. It contains information about the persons behind the app
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return $this->view('pages.about');
    }

    /**
     * Contact page for contacting the persons behind the application
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        if ( ! canContact()) {
            return redirect()->route('home');
        }

        return $this->view('pages.contact');
    }

    /**
     * Send message through contact
     *
     * @param ContactRequest $request
     * @param UserMailer $mailer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doContact(ContactRequest $request, UserMailer $mailer)
    {
        if ( ! canContact()) {
            return redirect()->route('home');
        }

        $mailer->contact($request->all());

        return redirect()->back()->with('status', 'Yep');
    }

}
