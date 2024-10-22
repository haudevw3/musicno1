<?php

namespace App\Http\Controllers;

use Core\Facades\Mailgun;
use Core\Facades\Smtp;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function testMailgun()
    {   
        Smtp::sendHtml('nguyenhauit.dev@gmail.com', 'Xác thực tài khoản', template_email('', '', ['name' => 'Nguyễn Văn Hậu']));
    }
}