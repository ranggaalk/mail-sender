<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    private $token = [
        'j991v6XzpO8Jd3voXUdtb61IdEAa7Vlg',
        '72GzuOiLOUGrbMyIxwar4EykPxl2sg5P',
        '7WsluZ0K9na4OanRelTuSjGDWcy94PQS',
        '5j59MaWVkHs9FdsxEvI5QXv6C2Cifjci',
        'kXqkH5ligedhYGxGYDQNiN8o5JsEfTy8',
        'D2ATQnMZZgKZOUzFtZDfZes07hNHJ5Rx',
    ];
    public function index(Request $request, $token){
        if(in_array($token, $this->token)) {
            // return response()->json($request);
            $mail_destination = $request->mailto;
            $subject = $request->mailsubject;
            $title = $request->mailtitle;
            $body = $request->mailbody;
            $footer = $request->mailfooter;
            $data = [
                'mailto' => $mail_destination ?? '',
                'subject' => $subject ?? '',
                'title' => $title ?? '',
                'body' => $body ?? '',
                'footer' => $footer ?? '',
            ];
            try {
                Mail::to($mail_destination)->send(new MailNotify($data));
                return response()->json([
                    'status' => 'sent',
                    'message' => 'Email sent successfully...'
                ]);
            } catch (Exception $e) {
                return response()->json(['There is an error. Message:'.$e]);
            }
        } else {
            return response()->json('Access Denied');
        }
    }
}
