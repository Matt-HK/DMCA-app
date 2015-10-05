<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\PrepareNoticeRequest;
use App\Notice;
use App\Provider;
use Auth;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Mail;


class NoticesController extends Controller
{

    /**
     * Create new notices controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        parent::__construct();
    }

    /**
     * Show all notices.
     * @return string
     */
    public function index()
    {
        return $this->user->notices;
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
     * @return \Response
     */
    public function confirm(PrepareNoticeRequest $request)
    {
        $template = $this->compileDmcaTemplate($data = $request->all());

        session()->flash('dmca', $data);

        return view('notices.confirm', compact('template'));
    }

    public function store(Request $request)
    {
        $notice = $this->createNotice($request);

        Mail::queue('emails.dmca', compact('notice'), function($message) use ($notice) {
            $message
                ->from($notice->getOwnerEmail())
                ->to($notice->getRecipientEmail())
                ->subject('DMCA Notice');
        });

        return redirect('notices');
    }

    /**
     * Compile the DMCA template from form data.
     * @param $data
     * @return mixed
     */
    public function compileDmcaTemplate($data)
    {
        $data = $data + [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ];

        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }

    /** Create and persist a new notice.
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createNotice(Request $request)
    {
        $notice = session()->get('dmca') + ['template' => $request->input('template')];

        $notice = $this->user->notices()->create($notice);

        return $notice;
    }
}
