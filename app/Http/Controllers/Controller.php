<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The authenticated user.
     * @var \App\User|null
     */
    protected $user;

    /**
     * Is the user signed in?
     * @var \App\User|null
     */
    protected $signedIn;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->user = $this->signedIn = Auth::user();
    }
}
