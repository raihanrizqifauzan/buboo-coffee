<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.0/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rasterizehtml/1.3.0/rasterizeHTML.allinone.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    /* @media print {
        .pagebreak { page-break-before: always; } 
        
    } */

    body {
        background: #ddd;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    
</style>
<div id="print_area" style="background:#FFF;">
<?php 
    $meja = $this->input->get('meja');
    if ($meja == "all") {
        for ($i=1; $i <= $jumlah_meja; $i++) {  ?>
            <div class="pagebreak d-flex justify-content-between">
                <div style="padding:20px;border:2px solid #57606f;margin-bottom:30px;width:280px;background:#57606f;color:#FFF;max-height:30%;">
                    <div style="padding:10px;background:#FFF;border-radius:10px;">
                        <div class="qrcode" id="qrcode_<?= $i ?>" data-val="<?= $i ?>"></div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:40px;margin-bottom:100px;">Scan Me</div>
                        <div>No. Meja : <?= $i ?> </div>
                    </div>
                </div>

                <div style="padding:20px;border:2px solid #57606f;margin-bottom:30px;width:280px;background:#57606f;color:#FFF;height:30%">
                    <div style="padding:10px;background:#FFF;border-radius:10px;height:60%">
                        <div style="font-size:100px;color:#000;padding:20px;text-align:center;"><?= $i ?></div>
                    </div>
                    <div style="text-align:center;margin-top:20px;">
                        <div>
                            <b><?= $info->nama_toko." ($info->no_telp)"; ?></b>
                            <div><small><?= $info->alamat_lengkap ?></small></div>
                        </div>
                    </div>
                </div>
            </div>    
        <?php }
    } else {
        $arr_meja = explode(",", $meja);
        foreach ($arr_meja as $key => $m) { ?>
            <div class="pagebreak d-flex justify-content-between">
                <div style="padding:20px;border:2px solid #57606f;margin-bottom:30px;width:280px;background:#57606f;color:#FFF;max-height:30%;">
                    <div style="padding:10px;background:#FFF;border-radius:10px;">
                        <div class="qrcode" id="qrcode_<?= $m ?>" data-val="<?= $m ?>"></div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:40px;margin-bottom:100px;">Scan Me</div>
                        <div>No. Meja : <?= $m ?> </div>
                    </div>
                </div>

                <div style="padding:20px;border:2px solid #57606f;margin-bottom:30px;width:280px;background:#57606f;color:#FFF;height:30%">
                    <div style="padding:10px;background:#FFF;border-radius:10px;height:60%">
                        <div style="font-size:100px;color:#000;padding:20px;text-align:center;"><?= $m ?></div>
                    </div>
                    <div style="text-align:center;margin-top:20px;">
                        <div>
                            <b><?= $info->nama_toko." ($info->no_telp)"; ?></b>
                            <div><small><?= $info->alamat_lengkap ?></small></div>
                        </div>
                    </div>
                </div>
            </div>    
        <?php }
    }


?>

</div>
<a class="btn btn-pirmary my-4" href="<?= base_url('admin/meja') ?>">Back</a>
<script src="<?= base_url() ?>assets/admin/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/') ?>qrcode.js"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/') ?>jquery.qrcode.js"></script>

<script>
    
    $(document).ready(function () {
        var pdf = new jsPDF();
        $(".qrcode").each(function (i, obj) {
            var no = $(obj).data("val");
            $(obj).qrcode(`<?= base_url('order/book_table?id=') ?>` + btoa(no));

            pdf.addHTML($("#print_area"),function() {
                var file = pdf.output('blob');
                var fd = new FormData();
                fd.append('mypdf',file);
                
                $.ajax({
                    url: "<?= base_url('welcome/upload_qr') ?>",
                    data: fd,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (response) {
                        window.location.href=response.data;
                    },
                    error: function (jqXHR) {
                        alter('Failure to send request');
                    }
                });
            });
        })
        
    })
</script>

<?php 

// $mpdf = new \Mpdf\Mpdf();
// $view = $this->load->view('admin/V_generate_qr', $data, TRUE);
// $mpdf->WriteHTML();
// $mpdf->Output();
?>
