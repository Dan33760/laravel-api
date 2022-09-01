<?php

namespace App\Http\Controllers\Api;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use App\Mail\TestMarkdownMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TestMailController extends Controller
{
    public function sendMailUser(Request $request)
    {
        $user = $request->user();

        // Mail::to($user['email'])->send(new TestMail($user));

        Mail::to($user['email'])->send(new TestMarkdownMail($user));

        return response([
            'status' => true,
            'message' => 'mail envoyé'
        ]);
    }
}
