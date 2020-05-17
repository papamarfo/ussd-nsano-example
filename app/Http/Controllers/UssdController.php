<?php

namespace App\Http\Controllers;

use Sparors\Ussd\Facades\Ussd;
use App\Http\Ussd\Welcome;

class UssdController extends Controller
{
    public function index()
    {
    	$ussd = Ussd::machine()->set([
		    'phone_number' => request('msisdn'),
		    'network' => request('network'),
		    'session_id' => request('UserSessionID'),
		    'input' => request('msg')
		])
	    ->setInitialState(Welcome::class)
	    ->setResponse(function(string $message, string $action) {
		    return [
				'USSDResp' => [
				    'action' => $action === 2 ? 'prompt' : 'input',
				    'menus' => '',
				    'title' => $message
				]
		    ];
		});

	    return response()->json($ussd->run());
    }
}