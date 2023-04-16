<style>
    #reader {
        width: 100%;
    }

    #reader video {
        width: 100%;
    }
    
    #html5-qrcode-button-camera-start, #html5-qrcode-button-camera-stop {
        border:none;
        background: #444;
        color: #FFF;
        padding: 5px;
        border-radius: 4px;
    }
    
    #html5-qrcode-button-camera-start:hover, #html5-qrcode-button-camera-stop:hover {
        background: #FFF;
        color: #000;
        border: 1px solid #000;
    }

    #html5-qrcode-anchor-scan-type-change {
        display:none !important;
    }

    .info-no-meja {
        display:none;
    }
</style>
<section class="pt-2 pb-5" style="min-height:500px;">
  <div class="container">
    <div class="d-flex mb-5 w-100">
        <div id="reader"></div>
    </div>
  </div>
</section>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        window.location.href = decodedText;
    }
    
    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }
    
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { 
            fps: 10, 
            qrbox: {width: 250, height: 250} 
        },
    false);
    
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>