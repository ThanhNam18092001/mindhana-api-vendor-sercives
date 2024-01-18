<?php

namespace App\Http\Controllers\Zalo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZaloController extends Controller
{
    public function accessToken()
    {
        $curl = curl_init();

        $data = array(
            'code' => '<your_oauth_code>',
            'app_id' => '1003456463332716062',
            'grant_type' => 'authorization_code',
            'code_verifier' => 'your_code_verifier',
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://oauth.zaloapp.com/v4/oa/access_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "secret_key: j19i1v0wH767NYvMYe55",
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


    public function accessTokenByRefresh(Request $request)
    {
        $curl = curl_init();

        $data = array(
            'app_id' => $request->input('app_id'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->input('refresh_token'),
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://oauth.zaloapp.com/v4/oa/access_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "secret_key: j19i1v0wH767NYvMYe55",
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

    public function getOfInterestedListCustomer()
    {
        $curl = curl_init();

        $data = array(
            'offset' => 0,
            'count' => 5,
        );
        $accessToken = isset($_SERVER['HTTP_ACCESS_TOKEN']) ? $_SERVER['HTTP_ACCESS_TOKEN'] : '';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://openapi.zalo.me/v2.0/oa/getfollowers?data=" . urlencode(json_encode($data)),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "access_token: $accessToken"
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

    public function getListInfomationZalo()
    {
        $curl = curl_init();
        $accessToken = isset($_SERVER['HTTP_ACCESS_TOKEN']) ? $_SERVER['HTTP_ACCESS_TOKEN'] : '';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://openapi.zalo.me/v2.0/oa/getoa",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "access_token: $accessToken"
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

    public function sendMessage(Request $request)
    {
        $curl = curl_init();

        $data = array(
            'recipient' => array(
                'anonymous_id' => '1ffedc467f179649cf06',
                'conversation_id' => '1003456463332716062',
            ),
            'message' => array(
                'text' => $request->input('text'),
            ),
        );

        $accessToken = isset($_SERVER['HTTP_ACCESS_TOKEN']) ? $_SERVER['HTTP_ACCESS_TOKEN'] : '';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://openapi.zalo.me/v2.0/oa/message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
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

    public function requestUserInfo(Request $request)
    {
        $curl = curl_init();

        $data = array(
            'recipient' => array(
                'user_id' => $request->input('user_id'),
            ),
            'message' => array(
                'attachment' => array(
                    'type' => 'template',
                    'payload' => array(
                        'template_type' => 'request_user_info',
                        'elements' => array(
                            array(
                                'title' => $request->input('title'),
                                'subtitle' => $request->input('subtitle'),
                                'image_url' => $request->input('image_url'),
                            ),
                        ),
                    ),
                ),
            ),
        );

        $accessToken = isset($_SERVER['HTTP_ACCESS_TOKEN']) ? $_SERVER['HTTP_ACCESS_TOKEN'] : '';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://openapi.zalo.me/v3.0/oa/message/cs",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
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

    public function getUserProfile(Request $request)
    {
        $curl = curl_init();

        $access_token = isset($_SERVER['HTTP_ACCESS_TOKEN']) ? $_SERVER['HTTP_ACCESS_TOKEN'] : '';

        $data = array(
            'user_id' => $request->input('user_id'),
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://openapi.zalo.me/v2.0/oa/getprofile?data=" . urlencode(json_encode($data)),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "access_token: $access_token",
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

    
    public function updateFollowerInfo(Request $request)
    {
        $curl = curl_init();
        $accessToken = isset($_SERVER['HTTP_ACCESS_TOKEN']) ? $_SERVER['HTTP_ACCESS_TOKEN'] : '';
        $data = array(
            "user_id" => $request->input('user_id'),
            "name" => $request->input('name'),
            "phone" => $request->input('phone'),
            "address" => $request->input('address'),
            "city_id" => (int)$request->input('city_id'),
            "district_id" => (int)$request->input('district_id'),
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://openapi.zalo.me/v2.0/oa/updatefollowerinfo",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
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
