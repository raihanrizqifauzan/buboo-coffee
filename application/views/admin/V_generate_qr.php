<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">
<style>
    @media print {
        .pagebreak { page-break-before: always; } /* page-break-after works, as well */
        
    }

    body {
        background: #ddd;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    
</style>
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
<script src="<?= base_url() ?>assets/admin/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/') ?>qrcode.js"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/') ?>jquery.qrcode.js"></script>

<script>
    $(".qrcode").each(function (i, obj) {
        var no = $(obj).data("val");
        $(obj).qrcode(`<?= base_url('order/book_table?id=') ?>` + btoa(no));
    })

    window.print();
</script>
