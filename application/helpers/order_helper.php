<?php
function getNomorPesanan(){
	date_default_timezone_set('Asia/Jakarta');
    $CI = &get_instance();
    $CI->load->model(['M_order']);
    $count_order = $CI->M_order->countOrderToday(date('Y-m-d 00:00:00')) + 1;
    $no_pesanan = date('Ymd').str_pad($count_order, 3, '0', STR_PAD_LEFT);
    return $no_pesanan;
}

function send_whatsapp($no_hp, $message) {
    $key_demo = 'db63f52c1a00d33cf143524083dd3ffd025d672e255cc688';
    $url='http://45.77.34.32:8000/demo/send_message';
    $data = array(
        "phone_no"=> $no_hp,
        "key"     => $key_demo,
        "message" => $message
    );
    
    $data_string = json_encode($data,1);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 360);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string),
        'Authorization: Basic dXNtYW5ydWJpYW50b3JvcW9kcnFvZHJiZWV3b293YToyNjM3NmVkeXV3OWUwcmkzNDl1ZA=='
    ));
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}