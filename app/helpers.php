<?php

require_once 'database_config.php';

if (!function_exists('old')) {

    /*
     * save user input values.
     * @param string $fn field name.
     * @return string the user input values.
     */

    function old($fn) {
        return $_REQUEST[$fn] ?? '';
    }

}

if (!function_exists('str_to_rtl')) {
    
    /*
     * change text direction - hebrew user.
     * @param string $str user input string.
     * @return string $output  - the div with rtl class.
     */

    function str_to_rtl($str) {

        $output = $str;

        if (preg_match("/[א-ת]/", $str)) {

            $output = '<div dir="rtl" style="text-align:right">' . $str . '</div>';
        }
        return $output;
    }

}

if (!function_exists('csrf_token')) {
    
    /*
     * creates token.
     * @param string $token token.
     * @return string $token token.
     */

    function csrf_token() {
        $token = sha1(rand(1, 1000) . '$$' . date('H.i.s') . 'myrecipe');
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

}

if (!function_exists('user_verify')) {
    
    /*
     * checks user ip and user agent
     * @return bool $verify
     */

    function user_verify() {

        $verify = false;

        if (isset($_SESSION['user_id'])) {

            if (isset($_SESSION['user_ip']) && $_SERVER['REMOTE_ADDR'] == $_SESSION['user_ip']) {

                if (isset($_SESSION['user_agent']) && $_SERVER['HTTP_USER_AGENT'] == $_SESSION['user_agent']) {

                    $verify = true;
                }
            }
        }

        return $verify;
    }

}

if (!function_exists('sess_start')) {
    
    /*
     * creates session id.
     * @param string $name optional session name.
     */

    function sess_start($name = null) {

        if ($name)
            session_name($name);
        session_start();
        session_regenerate_id();
    }

}

if (!function_exists('email_exist')) {
    
    /*
     * checks if email adreess already in DB.
     * @param $link server connection details.
     * @param $eamil user email.
     * @return bool $exist.
     */

    function email_exist($link, $email) {

        $exist = false;

        $sql = "SELECT email FROM users WHERE email = '$email' ";
        $result = mysqli_query($link, $sql);

        if ($result && mysqli_num_rows($result) == 1) {

            $exist = true;
        }

        return $exist;
    }

}

function load_image() {
    
    /*
     * image upload.
     * @return string $file_name file name.
     */

    $ex = ['png', 'jpg', 'btm', 'jpeg', 'gif'];
    define('MAX_FILE_SIZE', 1024 * 1024 * 5);

    if (is_uploaded_file($_FILES['image']['tmp_name'])) {

        if ($_FILES['image']['size'] <= MAX_FILE_SIZE) {

            $fileinfo = pathinfo($_FILES['image']['name']);

            if (strtolower(in_array($fileinfo['extention']), $ex)) {

                $file_name = date('Y.m.d.h.i.s') . '-' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $file_name);
            }
        }
    }
    return $file_name;
}
