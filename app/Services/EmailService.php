<?php

namespace App\Services;

class EmailService
{
    public function __construct(){

    }

    public function sendEmail($emailTarget, $subject, $template, $data = null){
        $details = [
            "to_mail" => $emailTarget,
            "subject" => $subject,
            "template" => $template,
            "data" => $data
        ];
       
        \Mail::to($emailTarget)->send(new \App\Mail\SendEmailBot($details));
    }
}
