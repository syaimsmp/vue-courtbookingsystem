<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\NotificationMail;

class SendEmailController extends Controller
{
    //
    public function index(){

        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];

        Mail::to('user@123.com')->send(new NotificationMail ($details));

        if (Mail::failures()) {
            return response('Sorry! Please try again latter', 200);
        }else{
            return response('Great! Successfully send in your mail', 200);
        }
    }
}
