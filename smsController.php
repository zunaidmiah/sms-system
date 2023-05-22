<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SmsController extends Controller
{
    public $message_body;
    public $mobile_numbers;
    public function __construct(string $message_body, array $mobile_numbers = []){
        if(isset($message_body)){
            $this->message_body = $message_body;
            if(!isset($mobile_numbers) or empty($mobile_numbers)){
                $this->mobile_numbers = $this->getDevsNumbers();
            }else{
                $this->mobile_numbers = $mobile_numbers;
            }
        }else{
            return response()->json(['status' => 'message_content required'],402);
        }
    }

    public function processSendSms(){
        if(!empty($this->mobile_numbers) and !empty($this->message_body)){
            $data = [
                'apikey' => "06e80c43462e998f",
                'secretkey' => "3733d087",
                'callerID' => '8809612448803',
                'toUser' => implode(",",$this->mobile_numbers),
                'messageContent' => $this->message_body,
            ];
            $query = http_build_query($data);
            // dd($query);
            $url = "http://smpp.ajuratech.com:7788/sendtext?$query";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            $ce = curl_exec($ch);

            curl_close($ch);
            return $ce;
        }else{
            return response()->json(['status' => 'message_content required'],402);
        }
        
        

    }

    public function getDevsNumbers(){
        $number = Config::get('global.devs_info');
        return array_values($number);
    }
}
