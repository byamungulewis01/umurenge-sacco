<?php
$dbuser = "root";
$dbpass = "";
$host = "localhost";
$db = "internetbanking_db";
$mysqli = new mysqli($host, $dbuser, $dbpass, $db);

function send_sms($phone, $message)
{
    $data = array(
        "sender" => 'ISMS',
        "recipients" => $phone,
        "message" => $message,
    );

    $url = "https://www.intouchsms.co.rw/api/sendsms/.json";
    $data = http_build_query($data);
    $username = "menyatips";
    $password = "Menyatips14";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // echo $result;
}

define("CLIENT_ID", "129bcf44-ef18-11ee-ab7c-deaddb65b9c2");
define("CLIENT_SECRET", "0d8cf357818053f3ac5bef5446483597da39a3ee5e6b4b0d3255bfef95601890afd80709");
define('BASE_URL', 'https://payments.paypack.rw/api');

function getToken()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => BASE_URL . '/auth/agents/authorize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{"client_id": "129bcf44-ef18-11ee-ab7c-deaddb65b9c2","client_secret": "0d8cf357818053f3ac5bef5446483597da39a3ee5e6b4b0d3255bfef95601890afd80709"}',
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response)->access;
}

function deposit($amount, $phone)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://payments.paypack.rw/api/transactions/cashin?Idempotency-Key=OldbBsHAwAdcYalKLXuiMcqRrdEcDGRv',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "amount":' . $amount . ',
        "number":"' . $phone . '"
    }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . getToken(),
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

}
function withdrawal($amount, $phone)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://payments.paypack.rw/api/transactions/cashout?Idempotency-Key=OldbBsHAwAdcYalKLXuiMcqRrdEcDGRv',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
    "amount":' . $amount . ',
    "number":"' . $phone . '"
}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . getToken(),
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

}
