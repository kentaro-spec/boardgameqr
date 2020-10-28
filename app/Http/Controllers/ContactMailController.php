<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactMailController extends Controller
{
    public function contact_mail()
    {
        $text = 'ああああ';
        $to = 'tsalm10@yahoo.co.jp';
        Mail::to($to)->send(new ContactMail($text));
    }
}
