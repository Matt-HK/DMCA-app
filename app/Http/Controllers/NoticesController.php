<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrepareNoticeRequest;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


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


    public function confirm(PrepareNoticeRequest $request)
    {
        return $request->all();
    }
}
