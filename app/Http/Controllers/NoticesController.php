<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\PrepareNoticeRequest;
use App\Provider;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;


class NoticesController extends Controller
{

    /**
     * Create new notices controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all notices.
     * @return string
     */
    public function index()
    {
        return 'all notices';
    }

    /**
     * Show page for creating a notice.
     * @return \Illuminate\View\View
     */

    public function create()
    {
        $providers = Provider::lists('name', 'id');

        return view('notices.create', compact('providers'));
    }

    /**
     * Receives/compiles user data, sends user to confirmation page.
     * @param PrepareNoticeRequest $request
     * @param Guard $auth
     * @return \Response
     */
    public function confirm(PrepareNoticeRequest $request, Guard $auth)
    {
        $template = $this->compileDmcaTemplate($data = $request->all(), $auth);

        session()->flash('dmca', $data);

        return view('notices.confirm', compact('template'));
    }

    public function store()
    {
        $data = session()->get('dmca');

        return \Request::input('template');
    }

    /**
     * Compile the DMCA template from form data.
     * @param $data
     * @param Guard $auth
     * @return mixed
     */
    public function compileDmcaTemplate($data, Guard $auth)
    {
        $data = $data + [
                'name' => $auth->user()->name,
                'email' => $auth->user()->email,
            ];

        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }
}
