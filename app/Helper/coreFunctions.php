<?php

if (!function_exists('userIp')) {
    function userIp() {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}


if (!function_exists('randomString')) {
    function randomString($length = 4): string {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('randomNumber')) {
    function randomNumber($length = 4) {
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $randomNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomNumber;
    }
}


if (!function_exists('getIp')) {
    function getIp() {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}

if (!function_exists('shorter')) {
    function shorter($text, $chars_limit) {
        try {
            if (strlen($text) > $chars_limit) {
                // If so, cut the string at the character limit
                $new_text = substr($text, 0, $chars_limit);
                // Trim off white space
                $new_text = trim($new_text);
                // Add at end of text ...
                return $new_text . "...";
            } // If not just return the text as is
            else {
                return $text;
            }
        } catch (\Throwable $th) {
            return "decode";
        }

    }
}

if (!function_exists('skipTags')) {
    function skipTags($text) {
        try {
            $text = strip_tags($text, '<style>');
            $start = strpos($text, '<style');
            // All of occurrences of <style>.
            while ($start !== FALSE) {
                $end = strpos($text, '</style>');
                if (!$text) {
                    break;
                }
                $diff = $end - $start + strlen('</style>');
                $substring = substr($text, $start, $diff);
                $text = str_replace($substring, '', $text);
                $start = strpos($text, '<style');
            }

            // Remaining <style> if any.
            $text = strip_tags($text);

            // Remove all new lines and tabs and use a space instead.
            $text = str_replace(["\n", "\r", "\t"], ' ', $text);

            // Trim left and right.
            $text = trim($text);

            // Remove all spaces that have more than one occurrence.
            $text = preg_replace('!\s+!', ' ', $text);

            return $text;
        } catch (\Throwable $th) {
            return 'Decode Faield!';
        }

    }
}
if (!function_exists('pp')) {
    function pp($data,$exit = true) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if($exit){
            exit();
        }
    }
}
if (!function_exists('timeFormat')) {
    function timeFormat($timestamp, $tz = NULL): string {
        try {
            if (!$tz) {
                $tz = auth()->user()->timezone;
            }
            #Sample: Tue, Jan 3, 2023 11:57 AM
            return \Carbon\Carbon::parse($timestamp, 'UTC')->timezone($tz)->toDayDateTimeString();
        } catch (Throwable $th) {
            return 'Invalid Time';
        }
    }
}

if (!function_exists('emailTimeFormat')) {
    function emailTimeFormat($datetime, $timezone = 'UTC'): string {
        date_default_timezone_set($timezone);
        if ((date('d', $datetime) != date('d')) && (date('Y', $datetime) == date('Y'))) {
            return date("d M", $datetime);
        }else if(date('Y', $datetime) != date('Y')){
            return date("d/m/y", $datetime);
        }else{
            $seconds = time() - $datetime ;
            $minutes = round($seconds / 60);
            if ($seconds <= 60) {
                return "Just Now";
            } else if ($minutes <= 60) {
                if ($minutes == 1) {
                    return "a min ago";
                } else {
                    return "$minutes minutes ago";
                }
            }else{
                return date("h:i a", $datetime);
            }
        }
    }
}

if (!function_exists('facebook_time_ago')) {
    function facebook_time_ago($timestamp,$timezone = 'UTC'): string {
        date_default_timezone_set($timezone);
        $time_ago = $timestamp;
        $current_time = time();
//        $current_time = strtotime($now);
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes = round($seconds / 60);            // value 60 is seconds
        $hours = round($seconds / 3600);            //value 3600 is 60 minutes * 60 sec
        $days = round($seconds / 86400);            //86400 = 24 * 60 * 60;
        $weeks = round($seconds / 604800);          // 7*24*60*60;
        $months = round($seconds / 2629440);        //((365+365+365+365+366)/5/12)*24*60*60
        $years = round($seconds / 31553280);        //(365+365+365+365+366)/5 * 24 * 60 * 60
        if ($seconds <= 60) {
            return "Just Now";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "a minute ago";
            } else {
                return "$minutes minutes ago";
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "about an hour ago";
            } else {
                return "$hours hours ago";
            }
        } else if ($days <= 7) {
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        } else if ($weeks <= 4.3) //4.3 == 52/12
        {
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        } else {
            if ($years == 1) {
                return "1 year ago";
            } else {
                return "$years years ago";
            }
        }
    }
}

/**
 * @param string $str
 *
 * @return string|string[]|null
 */
function slugify(string $str = ''): array|string|null {
    if (!is_string($str)) {
        return $str;
    }
    if ($str == '') {
        return $str;
    }

    $str = trim($str);
    $str = preg_replace('/\s\s+/', ' ', $str);
    $str = str_replace(' ', '_', $str);                 // Replaces all spaces with hyphens.
    $str = preg_replace('/[^A-Za-z0-9\-]/', '_', $str); // Removes special chars.
    $str = preg_replace('/-+/', '-', $str);
    $a = substr($str, -1);
    if ($a == '-') {
        $str = rtrim($str, '_');
        //$str = clean_fields($str);
    }
    return strtolower($str);
}

function getImageLink($path = '', $image = ''): string {
    if (!empty($path) && file_exists(public_path($path))) {
        return asset($path);
    } else {
        return asset('images/no_image.png');
    }
}
