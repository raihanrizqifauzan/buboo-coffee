<style>
  #btn-cart {
    display: none !important;
  }

  #btnKirimOTP {
    border-radius: 8px;
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      /* display: none; <- Crashes Chrome on hover */
      -webkit-appearance: none;
      margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
  }
  
  input[type=number] {
      -moz-appearance:textfield; /* Firefox */
  }
</style>
<section class="container" style="min-height:100vh;background:#f3f4f6!important">
    <div class="step1">
        <div class="form-group p-4">
            <label for="">No. Whatsapp</label>
            <div class="input-group mt-2">
                <span class="input-group-text" id="basic-addon1">+62</span>
                <input id="no_hp" type="number" class="form-control" placeholder="Min. 8 digit (ex : 8123456789)" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <small class="text-danger text-error" style="display:none">Salah</small>
        </div>
        <div class="form-group px-4 mt-2 text-center">
            <button class="btn btn-primary w-100" id="btnKirimOTP">Kirim OTP</button>
            <small class="">Dengan melanjutkan proses kamu setuju dengan Syarat Penggunaan dan Kebijakan Privasi</small>
        </div>
    </div>
    <div class="step2" style="display:none">
        <div class="form-group p-4">
            <label for="">Kode OTP</label>
            <input id="kode_otp" type="number" class="form-control" placeholder="Masukan kode" aria-label="Username" aria-describedby="basic-addon1">
            <small class="text-danger text-error" style="display:none">Salah</small>
        </div>
        <div class="form-group px-4">
            <small class="">Silahkan cek whatsapp anda</small>
            <div id="container-countdown"><small class="">Kirim ulang dalam <b><span class="countdown text-danger">60 detik</span></b></small></div>
            <div id="btn-resend" class="my-2 text-center"><a href="javascript:void(0)" id="resendOTP"><b><small>Kirim Ulang OTP</small></b></a></div>
            <button class="btn btn-primary w-100" id="btnLanjutkan">Lanjutkan</button>
        </div>
    </div>
</section>

<script>
    var timing;
    var myTimer;
    
    function beginCountdown() {
        timing = 60;
        $("#btn-resend").hide();
        $("#container-countdown").show();
        $(".countdown").html("60 detik");
        myTimer = setInterval(function() {
            --timing;
            $(".countdown").html(`${timing} detik`);
            if (timing === 0) {
                clearInterval(myTimer);
                $("#btn-resend").show();
                $("#container-countdown").hide();
            }
        }, 1000);
    }

    async function sendOTP(no_hp) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>welcome/send_otp`,
                data: { 
                    no_hp: no_hp,
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Mohon Tunggu...',
                        width: 600,
                        padding: '3em',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();
                    var res = JSON.parse(response);
                    resolve(res);
                },
                error: function () {
                    Swal.close();
                }
            });
    
        });
    }
     
    function showError(msg) {
        $(".text-error").html(msg)
        $('.text-error').show();
        setTimeout(function() {
            $('.text-error').hide();
        }, 1500);
    }

    $("#btnKirimOTP").click(async function () {
        var no_hp = $("#no_hp").val();
        if (no_hp == "" || no_hp.length < 8) {
            showError("No. HP minimal 8 digit");
            return false;
        } else if (no_hp.length > 15) {
            showError("No. HP maksimal 15 digit");
            return false;
        } else if (no_hp[0] != "8") {
            showError("No. HP harus dimulai dengan angka 8");
            return false;
        }
        no_hp = "+62"+no_hp;
        sendOTP(no_hp).then(function(res) {
            if (res.status) {
                beginCountdown();
                $(".step1").hide();
                $(".step2").show();
            } else {
                messageError(res.message);
            }
        });
    })

    
    $("#resendOTP").click(async function () {
        var no_hp = $("#no_hp").val();
        sendOTP("+62"+no_hp).then(function(res) {
            if (res.status) {
                beginCountdown();
            } else {
                messageError(res.message);
            }
        });
    })

    $("#btnLanjutkan").click(function () {
        var no_hp = $("#no_hp").val();
        var kode_otp = $("#kode_otp").val();

        if (kode_otp == "" || kode_otp.length < 4 || kode_otp.length > 4) {
            showError("Kode OTP 4 digit");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>welcome/pakai_otp`,
            data: { 
                no_hp: "+62"+no_hp,
                kode_otp: kode_otp,
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Mohon Tunggu...',
                    width: 600,
                    padding: '3em',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status) {
                    Swal.close();
                    var data = res.data;
                    window.location.href = "<?= base_url('order') ?>";
                } else {
                    messageError(res.message);
                }
            }
        });
    })
</script>