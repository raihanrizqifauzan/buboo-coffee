<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 col-md-6 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Menu</h4>
        </div>
        <div class="col-12 col-md-6 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/menu') ?>" class="text-muted">Menu</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Edit Menu</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Nama Menu</label>
                        <input type="hidden" value="<?= $menu->id_menu ?>" id="id_menu">
                        <input type="text" class="form-control" id="nama_menu" value="<?= $menu->nama_menu ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="number" class="form-control" id="harga" value="<?= $menu->harga ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi"><?= $menu->deskripsi ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select class="form-control" id="id_kategori">
                            <option value="">- Pilih Kategori -</option>
                            <?php 
                            foreach ($list_kategori as $i => $kategori) { 
                                $selected = "";
                                if ($kategori->id_kategori == $menu->id_kategori) {
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?= $kategori->id_kategori ?>" <?= $selected ?>><?= $kategori->nama_kategori ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar Menu</label>
                        <?php $gambar_menu = json_decode($menu->json_gambar, TRUE); ?>
                        <div class="form-group">
                            <div class="d-flex align-items-center h-100" style="gap: 5px">
                                <?php 
                                for ($i=0; $i < 3; $i++) { 
                                    $img = "none";
                                    if (isset($gambar_menu[$i])) {
                                        $img = base_url('assets/public/img/menu/').$gambar_menu[$i];
                                    }
                                    ?>
                                    <div class="img-preview d-flex justify-content-center align-items-center" style="padding:5px;width:100px;height:100px;border:1px solid #e4e7ed;background-image:url(<?= $img ?>);background-size:cover">
                                        <div class="mx-1"><a href="javascript:void(0)" class="text-dark change-img"><span class="iconify" data-icon="material-symbols:edit-square-outline"></span></div></a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div style="display:none">
                                <input type="file" class="form-control gambar_menu">
                                <input type="file" class="form-control gambar_menu">
                                <input type="file" class="form-control gambar_menu">
                            </div>
                            <div class="area-gambar"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-success pull-right" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/admin/ckeditor/ckeditor.js') ?>"></script>

<script>
    var change_gambar = [];
    $("[id='id_kategori']").select2({
        width: "100%",
        positionDropdown: true
    });

    $(".gambar_menu").change(function () {
        var index_change = $(".gambar_menu").index($(this));
        if (!change_gambar.includes(index_change)) {
            change_gambar.push(index_change)
        }

        var change_index = $(".gambar_menu").index($(this));
        console.log(change_index);
        var preview = "";
        var file = $(this).get(0).files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                $(".img-preview").eq(change_index).css('background-image', 'url("' + reader.result + '")');
                $(".img-preview").eq(change_index).css('background-size', 'cover');
            }
            reader.readAsDataURL(file);
        } else {
            $(".img-preview").eq(change_index).css('background-image', 'url("none")');
        }
    })

    $(document).ready(function () {
        CKEDITOR.replace('deskripsi',{
            height: '200px',  
        });
        CKEDITOR.on( 'dialogDefinition', function( ev ){
           var dialogName = ev.data.name;
           var dialogDefinition = ev.data.definition;

           if ( dialogName == 'link' || dialogName == 'image' ){
               dialogDefinition.removeContents( 'Upload' );
           }
        });
        // CKEDITOR.config.extraPlugins = 'simplebutton';
        CKEDITOR.config.removePlugins = 'image, iframe, anchor, forms, newpage, save, exportpdf, preview, print, templates';
    });


    function showLoading() {
        return Swal.fire({
            title: 'Loading...',
            width: 600,
            padding: '3em',
            allowOutsideClick: false,
            timer: 500,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    $("#addGambar").click(function () {
        var length_gambar = $(".gambar_menu").length;
        if (length_gambar == 3) {
            Swal.fire({
                icon: "warning",
                text: "Maksimal 3 gambar",
            });
            return false;
        }
        var html = `
        <div class="row mt-2">
            <div class="col-10">
                <input type="file" class="form-control gambar_menu" id="gambar_menu_${length_gambar - 1}">
            </div>
            <div class="col-2">
                <button class="btn btn-circle btn-sm btn-danger deleteGambar"><i class="fa fa-trash"></i></button>
            </div>
        </div>`;
        $(".area-gambar").append(html);
    })

    $(document).on("click", ".deleteGambar", function (e) {
        $(this).closest(".row").remove();
    })
    
    $(".change-img").click(function () {
        var change_index = $(".change-img").index($(this));
        var background_before = $(this).css('background-image');
        $(".gambar_menu").eq(change_index).trigger("click");
    })

    $("#btnSave").click(function () {
        var form_data = new FormData(); 
        form_data.append('id_menu', $("#id_menu").val());
        form_data.append('nama_menu', $("#nama_menu").val());
        form_data.append('id_kategori', $("#id_kategori").val());
        form_data.append('harga', $("#harga").val());
        form_data.append('deskripsi', CKEDITOR.instances['deskripsi'].getData());
        $('.gambar_menu').each(function(i, obj) {
            form_data.append(`gambar_menu[]`, $(obj).prop('files')[0]);
        });

        change_gambar.forEach(e => {
            form_data.append('idx_change_gambar[]', e);
        });

        $.ajax({
            url: "<?= base_url('admin/menu/update_menu/') ?>",
            beforeSend: function () {
                showLoading()
            },
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(response){
                var res = JSON.parse(response);
                if (res.status) {
                    Swal.fire("Berhasil", res.message, "success").then(function () {
                        window.location.href = "<?= base_url('admin/menu') ?>"
                    });
                } else {
                    Swal.fire("Oops...", res.message, "error").then(function () {
                    });
                }
            }
        });
    })
</script>