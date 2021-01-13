
<!--button type="button" id="modal-update-foto" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#modal-update-foto">
  Abrir Modal
</button-->

<!--?php #carregar o id do usuario a editar a foto
    $id_edit_foto = $_SESSION['usu_id'];
    echo '<input id="id-update-foto" style="display: none" value="'.$id.'"></input>' ;
    echo '<input id="refresh" style="display: none" value="#ID DA DIV QUE VAI RECEBER A FOTO ATUALIZADA"></input>' ;
?-->

<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<!--link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css"-->
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

<style type="text/css">
.modal-dialog{
    margin-top: 200px;
    width: 302px;
}
#upload-demo-i{
    background:#e1e1e1;
    width:298px;
    padding:30px;
    height:298px;
    margin-top:30px
}
#upload-demo{
    width: 100%; 
    padding: 0;
}
</style>

<div id="msg" style="display: none">teste</div>

<div class="modal fade" id="modal-update-foto" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Alterar imágem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style=" padding: 0">
                <div class="container" style="width: 100%; padding: 0">
                    <!--div class="panel-heading"></div-->
                      <div class="panel-body" style="width: 100%; padding: 0">
                            <div class="col-md-12 text-center" style="width: 100%; padding: 0">
                                <div id="upload-demo"></div>
                                <strong>Select Image:</strong>
                            </div>
                            <div class="col-md-4" style="display: none">
                                <div id="upload-demo-i"></div>
                            </div>
                      </div>
                <!--/div-->
            </div>
            <div class="modal-footer">
                <span class="btn btn-default btn-file"><span><i class="fa fa-upload"></i> Abrir</span><input id="upload" type="file"/></span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary upload-result" id="upload-result" data-dismiss="modal">Alterar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

$('#upload').on('change', function () { 
    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop.croppie('bind', {
            url: e.target.result
        }).then(function(){
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
});

$('#upload-result').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {
        var iduser = $('#id-update-foto').val();
        var imgstr = $('#str-refresh-foto').val(); 
        $.ajax({
            url: "assets/cropper/crop-image.php",
            type: "POST",
            data: {'iduser': iduser,'image': resp, 'mini': 0},
            success: function (data) {
                if (imgstr = ""){
                    location.reload();
                } else {
                    html = imgsrt + ' src="' + resp + '" />';
                    $("#img-refresh").html(html);
                }
            }
        });
    });
});
</script>