<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NoticesController extends Controller
{

    /*
     * Create new notices controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Show all notices.
     * @return string
     */
    public function index()
    {
        return 'all notices';
    }

    /*
    * Show page for creating a notice.
     * @return \Response
    */
    public function create()
    {
        //get list of providers

        //load a view to create a new notice
        return view('notices.create');
    }
}
