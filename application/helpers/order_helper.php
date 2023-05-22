<?php
function getNomorPesanan(){
	date_default_timezone_set('Asia/Jakarta');
    $CI = &get_instance();
    $CI->load->model(['M_order']);
    $count_order = $CI->M_order->countOrderToday(date('Y-m-d 00:00:00')) + 1;
    $no_pesanan = date('Ymd').str_pad($count_order, 3, '0', STR_PAD_LEFT);
    return $no_pesanan;
}