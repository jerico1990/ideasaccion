<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\widgets\Pjax;
use yii\web\JsExpression;

/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */
$opciones_objetivos='';
foreach($objetivos as $objetivo){ 
    $opciones_objetivos=$opciones_objetivos.'<option value='.$objetivo->id.'>'.$objetivo->descripcion.'</option>';
}

?>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-3 col-md-3 text-center"></div>
    <div class="col-xs-12 col-sm-6 col-md-6 text-center">
	<select id="proyecto-cronograma_objetivo_99" class="form-control" name="Proyecto[cronogramas_objetivos][]" onchange="actividad2($(this).val(),99)" <?= $disabled ?>>
	    <option value>seleccionar</option>
	    <?= $opciones_objetivos ?>
	</select>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-3 col-md-3 text-center"></div>
    <div class="col-xs-12 col-sm-6 col-md-6 text-center">
	<select id="proyecto-cronograma_actividad_99" class="form-control" name="Proyecto[cronogramas_actividades]" onchange="cronograma($(this).val())" <?= $disabled ?>>
	    <option value>seleccionar</option>
	</select>
    </div>
    <div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12">
	    <table class="table table-striped table-hover" id="cronograma" style="display: none">
		<thead>
		    <th>Responsable</th>
		    <th>Fecha inicio</th>
		    <th>Fecha fin</th>
		    <?= ($disabled=='')?'<th></th>':'' ?>
		</thead>
		<tbody id="cronograma_cuerpo">
		    
		</tbody>
	    </table>
	    <?php if($disabled==''){?>
		<div id="btn_cronograma" class="btn btn-default pull-right" onclick="InsertarCronograma()" style="display: none">Agregar</div>
	    <?php } ?>
	</div>
    <div class="clearfix"></div>
    
<?php
    $eliminarcronograma=Yii::$app->getUrlManager()->createUrl('actividad/eliminarcronograma');
    $cargatablacronograma= Yii::$app->getUrlManager()->createUrl('cronograma/cargatablacronograma');
?>
<script>
    var cron=0;
    var opciones_objetivos="<?= $opciones_objetivos ?>";
    function actividad2(value,contador) {
	$.get( '<?= Yii::$app->urlManager->createUrl('plan-presupuestal/actividades?id=') ?>'+value, function( data ) {
	    $( '#proyecto-cronograma_actividad_'+contador ).html( data );
	});
    }
    
    $("#cronograma").on('click',' .remCF',function(){
        var r = confirm("Estas seguro?");
	id=$(this).children().val();
	//console.log(id);
        if (r == true) {
            
	    if (id) {
		$.ajax({
		    url: '<?= $eliminarcronograma ?>',
		    type: 'GET',
		    async: true,
		    data: {id:id},
		    success: function(data){
			
		    }
		});
		$(this).parent().parent().remove();	
	    }
	    else
	    {
		$(this).parent().parent().remove();
	    }
            
        } 
    });
    
    function InsertarCronograma() {
	var error='';
	cron=parseInt($("#contador1").val());
	var cronogramas=$('input[name=\'Proyecto[cronogramas_fechas_inicios][]\']').length;
        for (var i=0; i<cronogramas; i++) {
	    
            if($('#proyecto-cronograma_responsable_'+i).val()=='')
            {
                error=error+'ingrese el responsable '+i+' <br>';
                $('.field-proyecto-cronograma_responsable_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-cronograma_responsable_'+i).addClass('has-success');
                $('.field-proyecto-cronograma_responsable_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-cronograma_fecha_inicio_'+i).val()=='')
            {
                error=error+'ingrese la fecha inicio de '+i+' <br>';
                $('.field-proyecto-cronograma_fecha_inicio_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-cronograma_fecha_inicio_'+i).addClass('has-success');
                $('.field-proyecto-cronograma_fecha_inicio_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-cronograma_fecha_fin_'+i).val()=='')
            {
                error=error+'ingrese la fecha fin de '+i+' <br>';
                $('.field-proyecto-cronograma_fecha_fin_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-cronograma_fecha_fin_'+i).addClass('has-success');
                $('.field-proyecto-cronograma_fecha_fin_'+i).removeClass('has-error');
            }
        }
	if (error!='') {
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        else
        {
	   
	    $('#cronograma_'+cron).html(
		    "<td style='padding: 2px'>"+
			"<div class='form-group field-proyecto-cronograma_responsable_"+cron+" required' style='margin-top: 0px'>"+
			    "<select id='proyecto-cronograma_responsable_"+cron+"' class='form-control' name='Proyecto[cronogramas_responsables][]' >"+
				"<option value>seleccionar</option>"+
				<?php foreach($responsables as $responsable){ ?>
				    "<option value='<?= $responsable->estudiante_id ?>'><?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>"+
				<?php } ?>
			    "</select>"+
			"</div>"+
		    "</td>"+
		   "<td style='padding: 2px'>"+
			"<div class='form-group field-proyecto-cronograma_fecha_inicio_"+cron+" required' style='margin-top: 0px'>"+
			    "<input type='date' id='proyecto-cronograma_fecha_inicio_"+cron+"' class='form-control' name='Proyecto[cronogramas_fechas_inicios][]' placeholder='Fecha inicio' />"+
			"</div>"+
		    "</td>"+
		    "<td style='padding: 2px'>"+
			"<div class='form-group field-proyecto-cronograma_fecha_fin_"+cron+" required' style='margin-top: 0px'>"+
			    "<input type='date' id='proyecto-cronograma_fecha_fin_"+cron+"' class='form-control' name='Proyecto[cronogramas_fechas_fines][]' placeholder='Fecha fin' />"+
			"</div>"+
		    "</td>"+
		    "<td style='padding: 2px'>"+
			"<span class='remCF glyphicon glyphicon-minus-sign'></span>"+
		    "</td>");
	    $('#cronograma').append('<tr id="cronograma_'+(cron+1)+'"></tr>');
	    cron++;
	}
	
	return true;
	
    }
    
    
    
    function cronograma(valor) {
	
	$.ajax({
	    url: '<?= $cargatablacronograma ?>',
	    type: 'GET',
	    async: true,
	    dataType: 'json',
	    data: {valor:valor},
	    success: function(data){
		
		var tebody="";
		var i=data[0];
		var selecta="";
		
		if (data) {
		    data.splice(0,1);
		    $.each(data, function(i,star) {
			var responsable=0;
			//console.log(star.responsable);
			<?php foreach($responsables as $responsable){ ?>
			    responsable=<?= $responsable->estudiante_id ?>;
			    //console.log(<?= $responsable->estudiante_id ?>);
			   // console.log(star.responsable);
			    if (responsable==star.responsable) {
				selecta=selecta+"<option value='<?= $responsable->estudiante_id ?>' selected ><?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>";
				//console.log("0");
			    }
			    else
			    {
				//console.log("1");
				selecta=selecta+"<option value='<?= $responsable->estudiante_id ?>' ><?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>";
			    }
			<?php } ?>
			tebody=tebody+"<tr id='cronograma_"+i+"'>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-cronograma_responsable_"+i+" required' style='margin-top: 0px'>"+
						"<select id='proyecto-cronograma_responsable_"+i+"' class='form-control' name='Proyecto[cronogramas_responsables][]' >"+
						    "<option value>seleccionar</option>"+
						    selecta+
						"</select>"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-cronograma_fecha_inicio_"+i+" required form-control-wrapper' style='margin-top: 0px'>"+
						"<input type='text' id='proyecto-cronograma_fecha_inicio_"+i+"' class='form-control ' name='Proyecto[cronogramas_fechas_inicios][]' placeholder='Fecha inicio' value='"+star.fecha_inicio+"' />"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-cronograma_fecha_fin_"+i+" required' style='margin-top: 0px'>"+
						"<input type='date' id='proyecto-cronograma_fecha_fin_"+i+"' class='form-control' name='Proyecto[cronogramas_fechas_fines][]' placeholder='Fecha fin' value='"+star.fecha_fin+"'/>"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<span class='remCF glyphicon glyphicon-minus-sign'>"+
						"<input class='id' type='hidden' name='Proyecto[cronogramas_ids][]' value='"+star.id+"' />"+
					    "</span>"+
					"</td>"+
				    "</tr>";
			   // idtr=i;
			$('#proyecto-cronograma_fecha_inicio_'+i).bootstrapMaterialDatePicker({ weekStart : 0, time: false ,format : 'DD/MM/YYYY',lang : 'es' });   
		    });
		    
		    tebody=tebody+"<tr id='cronograma_"+i+"'><input type='hidden' id='contador1' value='"+i+"' ></tr>"
		    
		}
		
		$('#cronograma_cuerpo').html(tebody);
		$('#cronograma').show();
		$('#btn_cronograma').show();
		
	    }
	});
    }
</script>

