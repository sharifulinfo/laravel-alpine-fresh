<?php

namespace App\Traits;

use App\Helper\eDB;
use App\Http\Controllers\NotificationController;
use App\Http\Services\Users\NotificationService;
use App\Models\Notification;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

trait helperTrait {

    public function sResponse($data = [], $msg = "Operation executed successfully") { //success response
        return response()->json([
            'success' => TRUE,
            'msg'     => $msg,
            'data'    => $data,
        ]);
    }

    public function eResponse($data = [], $msg = "SalesMix couldn't execute this.") {
        //error response
        return response()->json([
            'success' => FALSE,
            'msg'     => $msg,
            'data'    => $data,
        ]);
    }

    public function sResponseMeta($data = [], $meta = []) { //success response
        $data = [
            'success' => TRUE,
            'data'    => $data,
            'meta'    => $meta,
        ];
        return response()->json($data);
    }

    public function checkReCaptacha($dataIn) {
        $res = [];
        $res['status'] = 'error';
        if (isset($dataIn['g-recaptcha-response']) && !empty($dataIn['g-recaptcha-response'])) {
            $postReCaptacha = $this->post_captcha($dataIn['g-recaptcha-response']);
            if ($postReCaptacha == TRUE) {
                $res['status'] = 'success';
            } else {
                $res['msg'] = 'Please solve the re-captcha';
            }
            //$res['status'] = 'success';
        } else {
            $res['msg'] = 'Please solve the re-captcha';
        }
        return $res;
    }

    private function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret'   => RECAPTCHA_ID,
            'response' => $user_response
        );
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, TRUE);
    }

    public function getUserTimeZoneTime($timestamp, $timezone = 'UTC') {
        date_default_timezone_set('UTC');
        $dt = new \DateTime();
        $dt->setTimestamp((int)$timestamp);
        $dt->setTimezone(new \DateTimeZone($timezone));
        return $dt->format('Y-m-d h:i:s a');
    }


    public function uploadImage(Request $request) {
        $dataIn = $request->all();
        $images_receive = $request->file('file');
        $image_extension = $images_receive->getClientOriginalExtension();
        $image_name = randomString('32') . '.' . $image_extension;

        $file_put_path = public_path() . '/uploads';
        $request->file('file')->move($file_put_path, $image_name);
        $retrive_image_path = $file_put_path . '/' . $image_name;


        // main image handle
        $finalName = randomString('16') . '.png';
        $intervation_put_path = $file_put_path . '/' . $finalName;

        // dd($intervation_put_path);

        Image::make($retrive_image_path)->resize(NULL, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($intervation_put_path, 90);

        if (file_exists($retrive_image_path)) {
            @unlink($retrive_image_path);
        }
        $thePath = siteUrl() . '/public/uploads/' . $finalName;
        // dd($thePath);
        $d = moveImageToCDN($thePath);
        if (file_exists($intervation_put_path)) {
            @unlink($intervation_put_path);
        }

        $res = [];
        $res['status'] = 'success';
        $res['name'] = $finalName;


        return $res;
    }

    public function timeZones() {
        $timeZones = [];
        $timeZones['GMT'] = ['id' => 'GMT', 'name' => 'Greenwich Mean Time', 'gmt' => '+0'];
        $timeZones['UTC'] = ['id' => 'UTC', 'name' => 'Universal Coordinated Time', 'gmt' => '+0'];
        $timeZones['ECT'] = ['id' => 'ECT', 'name' => 'European Central Time', 'gmt' => '+1'];
        $timeZones['EET'] = ['id' => 'EET', 'name' => 'Eastern European Time', 'gmt' => '+2'];
        $timeZones['ART'] = ['id' => 'ART', 'name' => '(Arabic) Egypt Standard Time', 'gmt' => '+2'];
        $timeZones['EAT'] = ['id' => 'EAT', 'name' => 'Eastern African Time', 'gmt' => '+3'];
        $timeZones['MET'] = ['id' => 'MET', 'name' => 'Middle East Time', 'gmt' => '+3:30'];
        $timeZones['NET'] = ['id' => 'NET', 'name' => 'Near East Time', 'gmt' => '+4'];
        $timeZones['PLT'] = ['id' => 'PLT', 'name' => 'Pakistan Lahore Time', 'gmt' => '+5'];
        $timeZones['IST'] = ['id' => 'IST', 'name' => 'India Standard Time', 'gmt' => '+5:30'];
        $timeZones['BST'] = ['id' => 'BST', 'name' => 'Bangladesh Standard Time', 'gmt' => '+6'];
        $timeZones['VST'] = ['id' => 'VST', 'name' => 'Vietnam Standard Time', 'gmt' => '+7'];
        $timeZones['CTT'] = ['id' => 'CTT', 'name' => 'China Taiwan Time', 'gmt' => '+8'];
        $timeZones['JST'] = ['id' => 'JST', 'name' => 'Japan Standard Time', 'gmt' => '+9'];
        $timeZones['ACT'] = ['id' => 'ACT', 'name' => 'Australia Central Time', 'gmt' => '+9:30'];
        $timeZones['AET'] = ['id' => 'AET', 'name' => 'Australia Eastern Time', 'gmt' => '+10'];
        $timeZones['SST'] = ['id' => 'SST', 'name' => 'Solomon Standard Time', 'gmt' => '+11'];
        $timeZones['NST'] = ['id' => 'NST', 'name' => 'New Zealand Standard Time', 'gmt' => '+12'];
        $timeZones['MIT'] = ['id' => 'MIT', 'name' => 'Midway Islands Time', 'gmt' => '-11'];
        $timeZones['HST'] = ['id' => 'HST', 'name' => 'Hawaii Standard Time', 'gmt' => '-10'];
        $timeZones['AST'] = ['id' => 'AST', 'name' => 'Alaska Standard Time', 'gmt' => '-9'];
        $timeZones['PST'] = ['id' => 'PST', 'name' => 'Pacific Standard Time', 'gmt' => '-8'];
        $timeZones['PNT'] = ['id' => 'PNT', 'name' => 'Phoenix Standard Time', 'gmt' => '-7'];
        $timeZones['MST'] = ['id' => 'MST', 'name' => 'Mountain Standard Time', 'gmt' => '-7'];
        $timeZones['CST'] = ['id' => 'CST', 'name' => 'Central Standard Time', 'gmt' => '-6'];
        $timeZones['EST'] = ['id' => 'EST', 'name' => 'Eastern Standard Time', 'gmt' => '-5'];
        $timeZones['IET'] = ['id' => 'IET', 'name' => 'Indiana Eastern Standard Time', 'gmt' => '-5'];
        $timeZones['PRT'] = ['id' => 'PRT', 'name' => 'Puerto Rico and US Virgin Islands Time', 'gmt' => '-4'];
        $timeZones['CNT'] = ['id' => 'CNT', 'name' => 'Canada Newfoundland Time', 'gmt' => '-3:30'];
        $timeZones['AGT'] = ['id' => 'AGT', 'name' => 'Argentina Standard Time', 'gmt' => '-3'];
        $timeZones['BET'] = ['id' => 'BET', 'name' => 'Brazil Eastern Time', 'gmt' => '-3'];
        $timeZones['CAT'] = ['id' => 'CAT', 'name' => 'Central African Time', 'gmt' => '-1'];
        return $timeZones;
    }

    public function convertToNative($time = NULL, $timeZone = NULL) {
        $resTime = '';
        $time = $time == NULL ? date('Y-m-d H:i:s a') : $time;
        $timeZone = $timeZone == NULL ? auth()->user()->timezone : $timeZone;
        $timeZones = $this->timeZones();
        $timeZoneData = $timeZones[$timeZone]['gmt'];
        if ($timeZoneData == '+0') {
            $resTime = $time;
        } else {
            $plusMinus = '+';
            $minutes = 0;
            if (strpos($timeZoneData, '-') !== FALSE) {
                $plusMinus = '-';
            }
            $timeZoneData = str_replace('+', '', $timeZoneData);
            $timeZoneData = str_replace('-', '', $timeZoneData);
            $timeZoneData = trim($timeZoneData);
            if (strpos($timeZoneData, ':') !== FALSE) {
                $timeZoneDataEx = explode(':', $timeZoneData);
                $minutes = ((int)$timeZoneDataEx[0] * 60) + (int)$timeZoneDataEx[1];
            } else {
                $minutes = (int)$timeZoneData * 60;
            }
            $minutes = strval($minutes);

            $resTime = date("Y-m-d H:i:s", strtotime($plusMinus . $minutes . ' minutes', strtotime($time)));
        }
        return $resTime;
    }

    public function checkImpressionBalance($user, $sendMail = FALSE) {
        // if( $user->used_impressions >  $user->impressions){
        //     $balance = $user->used_impressions - $user->impressions;
        // }else{
        $balance = $user->impressions - $user->used_impressions;
        // }

        if ($balance < 0) {
            if ($sendMail) {
                // $workspace = WorkSpace::findOrFail(auth()->user()->active_workspace);
                $data = [
                    'email'            => $user->email,
                    'name'             => $user->name,
                    'impression'       => $user->impressions,
                    'used_impressions' => $user->used_impressions,
                    'balance'          => $balance,
                    'subject'          => 'Impression Balance Low',
                ];

                // Mail::send('mails.invitation', $data, function($message) use ($data) {
                //     $message->to($data['email'])->from('team@roboimage.com')->subject($data['subject']);
                // });
                if (config('app.debug') == FALSE) {
                    \Mail::send('mails.invitation', $data, function ($message) use ($data) {
                        $message->from('team@roboimage.com', 'SalesMix');
                        $message->to($data['email'], $data['w_name'])->subject($data['subject']);
                    });
                }
            }
            return $balance;
        }

        if ($balance < 1000) {
            if ($sendMail) {
                // $workspace = WorkSpace::findOrFail(auth()->user()->active_workspace);
                $data = [
                    'email'            => $user->email,
                    'name'             => $user->name,
                    'impression'       => $user->impressions,
                    'used_impressions' => $user->used_impressions,
                    'balance'          => $balance,
                    'subject'          => 'Impression Balance Low',
                ];

                // Mail::send('mails.invitation', $data, function($message) use ($data) {
                //     $message->to($data['email'])->from('team@roboimage.com')->subject($data['subject']);
                // });
                if (config('app.debug') == FALSE) {
                    Mail::send('mails.invitation', $data, function ($message) use ($data) {
                        $message->from('team@roboimage.com', 'SalesMix');
                        $message->to($data['email'], $data['w_name'])->subject($data['subject']);
                    });
                }
            }
            return $balance;
        }
    }

    public function saveNotification($arr, $userId = NULL): void {
        try {
            if ($userId == NULL) {
                $userID = auth()->user()->_id;
            }
            $data = array_merge($arr, ['user_id' => $userID]);
            $nController = new NotificationService();
            $nController->createNotification($data);
            return;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function downloadAsCSV($name, $data = [],$sl=true) {
        if (count($data) == 0) {
            return $this->eResponse([], 'no data found!');
        }
        $fileName = $name . '_' . randomString(10) . date("Y-m-d H:i:s") . '.csv';
        $savedpath = public_path() . '/downloads/' . $fileName;
        $fp = fopen($savedpath, "w");
        $arrKeys = array_keys($data[0]);
        if($sl) {
            array_unshift($arrKeys, 'sl');
        }

//        pp($arrKeys);
        fputcsv($fp, $arrKeys);
        $i = 0;
        foreach ($data as $e) {
            $thisRow = [];
            if($sl) {
                $thisRow[] = ++$i;
            }
            foreach ($e as $key => $item) {
                $thisRow[] = isset($e[$key]) ? $e[$key] : '';
            }
//            pp($thisRow);
            fputcsv($fp, $thisRow);
        }
        fclose($fp);
        return $this->sResponse(['file' => $fileName]);
    }

    function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    public function POST_REST($url,$postData,$headers = [],$userPwd = null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        if(isset($userPwd) && !empty($userPwd)){
            curl_setopt($ch, CURLOPT_USERPWD, $userPwd);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    public function GET_REST($url,$headers = [], $userPwd = null){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if(isset($userPwd) && !empty($userPwd)){
            curl_setopt($ch, CURLOPT_USERPWD, $userPwd);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

}
