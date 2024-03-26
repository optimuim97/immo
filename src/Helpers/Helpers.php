<?php

use Symfony\Component\HttpFoundation\Response;

// Encryption
function encrypt($data, $encryptionKey = "apaym")
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CBC'));
    $encrypted = openssl_encrypt($data, 'AES-128-CBC', $encryptionKey, 0, $iv);
    return base64_encode($iv . $encrypted);
}

// Decryption function
function decrypt($encryptedData, $encryptionKey)
{
    $encryptedData = base64_decode($encryptedData);
    $ivLength = openssl_cipher_iv_length('AES-128-CBC');
    $iv = substr($encryptedData, 0, $ivLength);
    $encrypted = substr($encryptedData, $ivLength);
    return openssl_decrypt($encrypted, 'AES-128-CBC', $encryptionKey, 0, $iv);
}

// Response
function responseSuccess(string $message, int $status, $data = [], $errors = [])
{
    return [
        "message" => $message == "" ? Response::$statusTexts['200']  : $message,
        "status_code" => $status,
        "data" => $data,
        "errors" => $errors
    ];
}

// Random Generator
function generateRandomInt($length = 7)
{
    $characters = '0123456789';
    $randomString = substr(str_shuffle($characters), 0, $length);

    return $randomString;
}

function generateRandomString($length = 7)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = substr(str_shuffle($characters), 0, $length);

    return $randomString;
}

// Date
function dateExpiration($number, $timeUnit, $time = null)
{
    $date = new \DateTime($time);
    $date->modify(" +$number $timeUnit");

    return  $date->format('Y-m-d H:i:s');
}

function isPast($date)
{
    $date = new DateTime($date);
    $now = new DateTime();

    if ($date < $now) {
        return true;
    }
}

/**
 * Summary of checkNotEmpty
 * @param mixed $elements
 * @param mixed $required_values
 * @return array
 */
function checkNotEmpty($elements = [], $required_values = [])
{

    $all = [];

    if (count($required_values) >= 1) {

        foreach ($required_values as $value) {

            if (isset($elements[$value])) {
                if (empty($elements[$value]) || is_null($elements[$value])) {
                    $error = ['message' => sprintf('Champ requis non renseigné : %s ', $value)];
                    array_push($all, $error);
                }
            } else {
                $error = ['message' => sprintf('Champ réquis manquant dans le payload  : %s ', $value)];
                array_push($all, $error);
            }
        }
    } else {

        foreach ($elements as $key => $element) {

            if (empty($element) || is_null($element)) {
                $error = ['message' => sprintf('Champ non renseigné : %s ', $key)];
                array_push($all, $error);
            }
        }
    }

    if (count($all) > 0) {
        return responseSuccess("Paramètre requis manquant", Response::HTTP_UNPROCESSABLE_ENTITY, errors: array_merge($all));
    }
}

//Phone
function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool
{
    return preg_match('/^[0-9]{' . $minDigits . ',' . $maxDigits . '}\z/', $s);
}

function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool
{
    if (preg_match('/^[+][0-9]/', $telephone)) { //is the first character + followed by a digit
        $count = 1;
        $telephone = str_replace(['+'], '', $telephone, $count); //remove +
    }

    //remove white space, dots, hyphens and brackets
    $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

    //are we left with digits only?
    return isDigits($telephone, $minDigits, $maxDigits);
}

function normalizeTelephoneNumber(string $telephone): string
{
    //remove white space, dots, hyphens and brackets
    $telephone = str_replace([' ', '.', '-', "'", '(', ')'], '', $telephone);
    return $telephone;
}

function decode64($img, $path, $name, $extention = "png")
{

    $image_parts = explode(";base64,", $img);

    if (str_contains($image_parts[0], "image/")) {

        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        if (isset($image_type_aux[1])) {
            $extention = $image_type;
        }
    }

    if (str_contains($image_parts[0], "application/")) {
        $image_type_aux = explode("application/", $image_parts[0]);
        $extention = $image_type_aux[1];
    }

    $image_en_base64 = base64_decode($image_parts[1]);
    $file = $name . ".$extention";

    file_put_contents("$path/$file", $image_en_base64);

    return $file;
}


function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}


function generatePath($path, $data)
{
    if(is_array($data)){
        $finalPath = sprintf($path['url'], ...$data);
    }else{
        $finalPath = sprintf($path['url'], $data);
    }

    return $finalPath;

}
