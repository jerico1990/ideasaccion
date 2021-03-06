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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.min.css" />
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootstrap-notify.js"></script>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
	<div class="form-group field-proyecto-cronograma_99 required" style="margin:0px;">
	    <label class="control-label" for="proyecto-cronograma_objetivo_99">Objetivo</label>
	    <select id="proyecto-cronograma_objetivo_99" class="form-control" name="Proyecto[cronogramas_objetivos][]" onchange="actividad2($(this).val(),99)" >
		<option value>Seleccionar</option>
		<?= $opciones_objetivos ?>
	    </select>
	</div>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
	<div class="form-group field-proyecto-cronograma_actividad_99 required" style="margin: 0px;padding: 0px">
	    <label class="control-label" for="registrar-cronograma_actividad_99">Actividad</label>
	    <select id="proyecto-cronograma_actividad_99" class="form-control" name="Proyecto[cronogramas_actividades]"  >
		<option value>Seleccionar</option>
	    </select>
	</div>
    </div>
    <div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12">
	    <table class="table table-striped " id="cronograma" style="display: none">
		<thead>
		    <th>Tarea</th>
		    <th>Responsable</th>
		    <th>Fecha inicio</th>
		    <th>Fecha fin</th>
		    <?= ($disabled=='')?'<th></th>':'' ?>
		</thead>
		<tbody id="cronograma_cuerpo">
		    
		</tbody>
		<tr><td colspan="5" ></td>
		</tr>
		<tr>
		    <td colspan="4" ></td>
		    <td>
			<?php if($disabled==''){?>
			    <div id="btn_cronograma" class="btn btn-default pull-right"  style="display: none;background: #1f2a69;color: white">Agregar tarea</div>
			<?php } ?>
		    </td>
		</tr>
	    </table>
	    
	</div>
    <div class="clearfix"></div>
    
<?php
    $eliminarcronograma=Yii::$app->getUrlManager()->createUrl('actividad/eliminarcronograma');
    $cargatablacronograma= Yii::$app->getUrlManager()->createUrl('cronograma/cargatablacronograma');
?>


<script>
    $( ".datepicker" ).datepicker();
    
    function actividad2(value,contador) {
	$.get( '<?= Yii::$app->urlManager->createUrl('plan-presupuestal/actividades?id=') ?>'+value, function( data ) {
	    $( '#proyecto-cronograma_actividad_'+contador ).html( data );
	});
    }
    
    
    
    $(document).ready(function ($) {
    
    $.datepicker.regional['es'] = {
      changeMonth: true,
      changeYear: true,
      closeText: 'Cerrar',
      prevText: 'Previo',
      nextText: 'Próximo',
      monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
      'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
      'Jul','Ago','Sep','Oct','Nov','Dic'],
      monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
      dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
      dateFormat: 'dd/mm/yy', firstDay: 0,
      initStatus: 'Selecciona la fecha', isRTL: false};
      $.datepicker.setDefaults($.datepicker.regional['es']);
      
	var cron=0;
	var opciones_objetivos="<?= $opciones_objetivos ?>";
	$("#cronograma").on('click',' .remCF',function(){
	    var r = confirm("Estas seguro?");
	    id=$(this).children().val();
	    //console.log(id);
	    if (r == true) {
		
		if (id) {
		    $.post( "<?= $eliminarcronograma ?>", { id: id})
		    .done(function( data ) {
			
		    });
		
		    $(this).parent().parent().remove();	
		}
		else
		{
		    $(this).parent().parent().remove();
		}
		
	    } 
	});
    
	$("#btn_cronograma").click(function () {
		    InsertarCronograma();
	});
	
	function InsertarCronograma() {
	    var error='';
	    cron=parseInt($("#contador1").val());
	    var cronogramas=$('input[name=\'Proyecto[cronogramas_fechas_inicios][]\']').length;
	    for (var i=0; i<cronogramas; i++) {
		
		
		if($('#proyecto-cronograma_tarea_'+i).val()=='')
		{
		    error=error+'ingrese la tarea '+i+' <br>';
		    $('.field-proyecto-cronograma_tarea_'+i).addClass('has-error');
		}
		else
		{
		    $('.field-proyecto-cronograma_tarea_'+i).addClass('has-success');
		    $('.field-proyecto-cronograma_tarea_'+i).removeClass('has-error');
		}
		
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
			    "<div class='form-group field-proyecto-cronograma_tarea_"+cron+" required' style='margin-top: 0px'>"+
				"<input type='text'   id='proyecto-cronograma_tarea_"+cron+"' class='form-control' name='Proyecto[cronogramas_tareas][]' placeholder='Tarea' />"+
			    "</div>"+
			"</td>"+
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
				"<input type='text'   id='proyecto-cronograma_fecha_inicio_"+cron+"' class='form-control datepicker' name='Proyecto[cronogramas_fechas_inicios][]' placeholder='Fecha inicio' />"+
			    "</div>"+
			"</td>"+
			"<td style='padding: 2px'>"+
			    "<div class='form-group field-proyecto-cronograma_fecha_fin_"+cron+" required' style='margin-top: 0px'>"+
				"<input type='text' id='proyecto-cronograma_fecha_fin_"+cron+"' class='form-control datepicker' name='Proyecto[cronogramas_fechas_fines][]' placeholder='Fecha fin' />"+
			    "</div>"+
			"</td>"+
			"<td style='padding: 2px'>"+
			    "<span class='remCF glyphicon glyphicon-minus-sign'></span>"+
			"</td>");
		$( ".datepicker" ).datepicker();
		$('#cronograma').append('<tr id="cronograma_'+(cron+1)+'"><input type="hidden" id="contador1" value="'+(cron+1)+'" ></tr>');
		
		
		cron++;
		
	    }
	    
	    
	    return true;
	}
	
	$("#proyecto-cronograma_actividad_99").change(function () {
	    cronograma($(this).val());
	});
	
	/*este carga cuando el selector observa de que hay data*/
	function cronograma(valor) {
	    //$.material.init();
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
			    <?php foreach($responsables as $responsable){ ?>
				responsable=<?= $responsable->estudiante_id ?>;
				if (responsable==star.responsable) {
				    selecta=selecta+"<option value='<?= $responsable->estudiante_id ?>' selected ><?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>";
				}
				else
				{
				    selecta=selecta+"<option value='<?= $responsable->estudiante_id ?>' ><?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>";
				}
			    <?php } ?>
			    tebody=tebody+"<tr id='cronograma_"+i+"' class='demo'>"+
					    "<td style='padding: 2px'>"+
						"<div class='form-group field-proyecto-cronograma_tarea_"+i+" required form-control-wrapper' style='margin-top: 0px'>"+
						    "<input type='text'  id='proyecto-cronograma_tarea_"+i+"' class='form-control label-floating' name='Proyecto[cronogramas_tareas][]' placeholder='Tarea' value='"+star.tarea+"' <?= $disabled?> />"+
						"</div>"+
					    "</td>"+
					    "<td style='padding: 2px'>"+
						"<div class='form-group field-proyecto-cronograma_responsable_"+i+" required' style='margin-top: 0px'>"+
						    "<select id='proyecto-cronograma_responsable_"+i+"' class='form-control' name='Proyecto[cronogramas_responsables][]' <?= $disabled?>>"+
							"<option value>seleccionar</option>"+
							selecta+
						    "</select>"+
						"</div>"+
					    "</td>"+
					    "<td style='padding: 2px'>"+
						"<div class='form-group field-proyecto-cronograma_fecha_inicio_"+i+" required form-control-wrapper' style='margin-top: 0px'>"+
						    "<input type='text'  id='proyecto-cronograma_fecha_inicio_"+i+"' class='form-control label-floating datepicker' name='Proyecto[cronogramas_fechas_inicios][]' placeholder='Fecha inicio' value='"+star.fecha_inicio+"' <?= $disabled?> />"+
						"</div>"+
					    "</td>"+
					    "<td style='padding: 2px'>"+
						"<div class='form-group field-proyecto-cronograma_fecha_fin_"+i+" required' style='margin-top: 0px'>"+
						    "<input type='text' id='proyecto-cronograma_fecha_fin_"+i+"' class='form-control label-floating datepicker' name='Proyecto[cronogramas_fechas_fines][]' placeholder='Fecha fin' value='"+star.fecha_fin+"' <?= $disabled?>/>"+
						"</div>"+
					    "</td>"+
					    <?php if($disabled==''){?>
					    "<td style='padding: 2px'>"+
						"<span class='remCF glyphicon glyphicon-minus-sign'>"+
						    "<input class='id' type='hidden' name='Proyecto[cronogramas_ids][]' value='"+star.id+"' />"+
						"</span>"+
					    "</td>"+
					    <?php } ?>
					"</tr>";
			});
			tebody=tebody+"<tr id='cronograma_"+i+"'><input type='hidden' id='contador1' value='"+i+"' ></tr> "
			
		    }
		    $('#cronograma_cuerpo').html(tebody);
		    $( ".datepicker" ).datepicker();
		    $('#cronograma').show();
		    $('#btn_cronograma').show();
		}
	    });
	}
    
    });
    
</script>



