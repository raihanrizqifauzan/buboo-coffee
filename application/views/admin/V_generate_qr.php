<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.css" />
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.0/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rasterizehtml/1.3.0/rasterizeHTML.allinone.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    /* @media print {
        .pagebreak { page-break-before: always; } 
        
    } */

    #print_area {
        background: #ddd;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    .pagebreak {
        break-after: always; 
    }
    
</style>
<div id="print_area" style="background:#FFF;">
<?php 
    $meja = $this->input->get('meja');
    if ($meja == "all") {
        for ($i=1; $i <= $jumlah_meja; $i++) {  ?>
            <div class="pagebreak d-flex justify-content-between">
                <div style="padding:20px;border:2px solid #57606f;margin-bottom:30px;width:280px;background:#57606f;color:#FFF;max-height:20%;">
                    <div style="padding:10px;background:#FFF;border-radius:10px;margin-top:20px;">
                        <div class="qrcode" id="qrcode_<?= $i ?>" data-val="<?= $i ?>"></div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:40px;margin-bottom:40px;">Scan Me</div>
                        <div>No. Meja : <?= $i ?> </div>
                    </div>
                </div>

                <div style="padding:20px;border:2px solid #57606f;margin-bottom:30px;width:280px;background:#57606f;color:#FFF;height:30%">
                    <div style="padding:40px;background:#FFF;border-radius:10px;height:60%;margin-top:40px;">
                        <div style="font-size:120px;color:#000;padding:20px;text-align:center;"><?= $i ?></div>
                    </div>
                    <div style="text-align:center;margin-top:40px;">
                        <div>
                            <b><?= $info->nama_toko." ($info->no_telp)"; ?></b>
                            <div><small><?= $info->alamat_lengkap ?></small></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="html2pdf__page-break" style="color:#FFF;background:#FFF;"></div> 
        <?php }
    } else {
        $arr_meja = explode(",", $meja);
        foreach ($arr_meja as $key => $m) { ?>
             <div class="pagebreak d-flex justify-content-between">
                <div style="padding:20px;border:2px solid #57606f;margin-bottom:30px;width:280px;background:#57606f;color:#FFF;max-height:20%;">
                    <div style="padding:10px;background:#FFF;border-radius:10px;margin-top:20px;">
                        <div class="qrcode" id="qrcode_<?= $m ?>" data-val="<?= $m ?>"></div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-size:40px;margin-bottom:40px;">Scan Me</div>
                        <div>No. Meja : <?= $m ?> </div>
                    </div>
                </div>

                <div style="padding:20px;border:2px solid #57606f;margin-bottom:30px;width:280px;background:#57606f;color:#FFF;height:30%">
                    <div style="padding:40px;background:#FFF;border-radius:10px;height:60%;margin-top:40px;">
                        <div style="font-size:120px;color:#000;padding:20px;text-align:center;"><?= $m ?></div>
                    </div>
                    <div style="text-align:center;margin-top:40px;">
                        <div>
                            <b><?= $info->nama_toko." ($info->no_telp)"; ?></b>
                            <div><small><?= $info->alamat_lengkap ?></small></div>
                        </div>
                    </div>
                </div>
            </div>   
            <div class="html2pdf__page-break" style="color:#FFF;background:#FFF;"></div> 
        <?php }
    }


?>

</div>
<div style="display:flex;align-items:center;justify-content:center;padding-top:400px;">
    <div>
        <center>
            <div><p style="font-size:50px;margin-bottom:20px;">PDF telah berhasil di download</p></div>
            <a style="border:1px solid silver;color:#000;border:1px solid #000;padding:5px;font-size:80px;text-decoration:none" href="<?= base_url('admin/meja') ?>">Kembali ke Kelola Meja</a>
            
            <div><p style="font-size:50px;margin-top:20px;">Jika belum ke download otomatis, silahkan <a href="" id="linkdownload">klik disini</a></p></div>
        </center>
    </div>
</div>
<script src="<?= base_url() ?>assets/admin/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/') ?>qrcode.js"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/') ?>jquery.qrcode.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.11.0/sweetalert2.all.min.js"></script>
<script>

    function showLoading() {
        return swal({
            title: "Loading...",
            text: "Generate PDF Files",
            imageUrl: "https://www.boasnotas.com/img/loading2.gif",
            showConfirmButton: false,
            allowOutsideClick: false
        }); 
    }
    
    $(document).ready(function () {
        // var pdf = new jsPDF();
        showLoading();
        $(".qrcode").each(function (i, obj) {
            var no = $(obj).data("val");
            $(obj).qrcode(`<?= base_url('order/book_table?id=') ?>` + btoa(no));

        })
        let element = document.getElementById('print_area');

        var opt = {
            margin:10,
            // filename:'output.pdf',
            image:{type:'jpeg',quality:0.98},
            html2canvas:{scale:2,logging:true,dpi:192,letterRendering:true},
            // jsPDF:{unit:'mm',format:'a4',orientation:'portrait'}
        };
        html2pdf().set(opt).from(element).output('datauristring').then(function (pdfAsString) {
            var arr = pdfAsString.split(',');
            pdfAsString= arr[1];
            console.log(pdfAsString);
            // var file = pdf.output('blob');
            var fd = new FormData();
            fd.append("data", pdfAsString);
            // fd.append('mypdf',file);
            
            $.ajax({
                url: "<?= base_url('welcome/upload_qr') ?>",
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (response) {
                    swal.close();
                    console.log(response);
                    if (response.status) {
                        $("#linkdownload").attr("href", response.data);
                        window.location.href = response.data;
                        $("#print_area").html("");
                    }
                    // console.log(response);
                },
                error: function (jqXHR) {
                    alter('Failure to send request');
                }
            });
        })
        
    })
</script>