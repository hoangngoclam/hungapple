<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;


class TestSendEmailController extends BaseController
{
    public function __construct()
    {
    }

    public function sendEmail(){
        $data = [
            "id"=> 123123,
            "name" => "Trương Hoàng Ngọc Lâm",
            "phonenumber" => "0978228963",
            "pickup_location" => "Trần Khánh Dư - Đà Lạt",
            "dropoff_location" => "Trần Khánh Dư - Đà Lạt",
            "pickup_date" => "21/02/2021",
            "pickup_time" => "15:09",
            "category_name" => "Danh mục"
        ];
        $details = [
            "to_mail" => "lammt1998@gmail.com",
            "subject" => date("d/m/Y H:i:s") . ' | hungapple.com | Đơn Hàng Mới',
            "template" => 'client.email.email-order',
            "data" => $data
        ];
       
        \Mail::to('lammt1998@gmail.com')->send(new \App\Mail\SendEmailBot($details));
    }

}
