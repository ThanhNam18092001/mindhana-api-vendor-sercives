<?php

namespace App\Http\Controllers\Zalo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZnsController extends Controller
{
    public function sendZaloMessage(Request $request)
    {
        $curl = curl_init();

        $phoneNumber = $request->input('phone');
        $phoneNumberWithPrefix = '84' . substr($phoneNumber, 1);

        $data = array(
            "phone" => $phoneNumberWithPrefix,
            "template_id" => $request->input('template_id'),
            "template_data" => array(
                "customer_name" => $request->input('customer_name'),
                "booking_code" => $request->input('booking_code'),
                "schedule_time" => $request->input('schedule_time'),
                "address" => $request->input('address')
            ),
            // "tracking_id" => "tracking_id",
        );
        $accessToken = isset($_SERVER['HTTP_ACCESS_TOKEN']) ? $_SERVER['HTTP_ACCESS_TOKEN'] : '';
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://business.openapi.zalo.me/message/template",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "access_token: $accessToken",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $responseData = json_decode($response, true);
            print_r($responseData);
        }
    }
}
