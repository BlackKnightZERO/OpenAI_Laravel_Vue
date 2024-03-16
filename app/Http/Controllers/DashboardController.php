<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use OpenAI\Laravel\Facades\OpenAI;

class DashboardController extends Controller
{
    public function index() {
        $chats = Chat::WHERE('user_id', auth()->user()->id)->latest()->get();
        return Inertia::render('Dashboard', [
            'chats'     => $chats,
        ]);
    }

    public function ask(Request $request) {

        $request->validate([
            'question' => ['required'],
        ]);

        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $request->question],
            ],
        ]);

        $finalResult = $result->choices[0]->message->content;

        if($finalResult) {
            $chat = Chat::Create([
                'question'  => $request->question,
                'answer'    => $finalResult,
                'user_id'   => auth()->user()->id 
            ]);
            $chats = Chat::WHERE('user_id', auth()->user()->id)->latest()->get();
        }

        return Inertia::render('Dashboard', [
            'chats'     => $chats,
        ]);
    }
}
