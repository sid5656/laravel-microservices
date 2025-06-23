<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectNotificationMail;

class NotificationController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::to($request->email)->send(new ProjectNotificationMail($request->message));

        return response()->json(['status' => 'Email Sent']);
    }
}

