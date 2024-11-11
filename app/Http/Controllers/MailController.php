<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class MailController extends Controller
{
    public function sendMail()
    {
        $data = array('name' => "Customer");
        Mail::send('mail', $data, function ($message) {
            $message->from('temppol1901@gmail.com', 'PhiLong');
            $message->to('temppol1901@gmail.com', 'Customer');
            $message->subject('Laravel HTML Testing Mail');
        });
        echo "HTML Email Sent. Check your inbox.";
    }

}
