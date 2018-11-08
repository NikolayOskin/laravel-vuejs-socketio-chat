<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TestEvent;

class ChatController extends Controller
{
	public function index()
	{
		return view('chat');
	}

	public function send(Request $request)
	{
		$data = [
			'message' => $request->input('message'),
			'nickname' => $request->input('nickname'),
		];
		event(new TestEvent($data));
	}
}
