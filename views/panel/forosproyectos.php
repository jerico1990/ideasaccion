<?php
use yii\helpers\Html;
use app\models\Ubigeo ;
?>


<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Foro
</div>
<div class="box_content contenido_seccion_equipo" >
    
    <div class="col-md-4">
        <div class="form-group label-floating field-registrar-departamento required" style="margin-top: 15px">
            <label class="control-label" for="registrar-departamento">Departamento</label>
            <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-departamento" class="form-control" name="Registrar[departamento]" onchange='departamento($(this).val())'>
            <option value=""></option>
            <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
            <option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
            <?php } ?>
            </select>
        </div>
    </div>
    
    
    <div id="resultados_asuntos_publicos" style="display: none">
        <div class="clearfix"></div>
        <div class="col-md-6">Asunto</div>
        <div class="col-md-2">Total de comentarios</div>
        <div class="col-md-2">Comentarios valorados</div>
        <div class="col-md-2">Falta valorar</div>
        <div class="clearfix"></div>
        <hr>
    </div>
    
</div>



<?php
    $ResultadosAsuntosPublicos= Yii::$app->getUrlManager()->createUrl('panel/resultadosasuntospublicos');
?>
<script>
function ResultadosAsuntosPublicos(valor) {
    $.ajax({
        url: '<?= $ResultadosAsuntosPublicos ?>',
        //type: 'GET',
        dataType: "json",
        async: true,
        data: {asunto:valor},
        success: function(data){
            $("#resultados_asuntos_publicos").html("");
            if (data) {
                $.each( data, function( index, value ){
                    $("#resultados_asuntos_publicos").append("<div class='col-md-4'>"+value["titulo"]+"</div><div class='col-md-4'>"+value["valorado"]+"</div><div class='col-md-4'>"+value["falta_valorar"]+"</div><div class='clearfix'></div>");
                    console.log("bien");
                }); 
            }
            
             
        }
    });
}
</script>