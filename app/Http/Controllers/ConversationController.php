<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\UserMeta;
use App\Message;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Sends message to specific user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendMessage(Request $request, Message $message)
    {
        $request->validate([
            'subject' => 'required|alpha_num',
            'body' => 'required|alpha_num',
            'nickname' => [
                'required',
                Rule::exists('user_metas')->where('nickname', $request->nickname),
            ]
        ]);

        $receiver = UserMeta::where('nickname', $request->nickname)->first()->user;

        Auth::user()->sendMessageTo($receiver, $request->subject, $request->body);

        return response()->json([
            'message' => 'Your message has been sent',
        ]);
    }

}
