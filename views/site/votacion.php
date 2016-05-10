<?php
use app\models\Asunto;
use app\models\Ubigeo;
use yii\widgets\ActiveForm;
?>

<div class="col-md-2">
    <div class="text_results">
            <img src="<?= \Yii::$app->request->BaseUrl ?>/images/text_results_title.png" alt="">
            <div class="line_separator"></div>
            Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.
    </div>
</div>
<div class="col-md-6">
    <div class="vote_options">
        <div class="vote_options_content">
            <div class="options_form options_day_to_day" data-option="1">
                <div class="opt_title">NUESTRO D&Iacute;A A D&Iacute;A</div>
                <div class="opt_content ia_show">
                    <div class="scrollCustom gray-skin">
                        <ul>
                            <?php
                                $a=1;
                                $categorias1=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>1])->all();
                                foreach($categorias1 as $categoria1)
                                {
                            ?>
                                <li>
                                    <a href="#" id="a<?= $categoria1->id ?>" data-id="<?= $a ?>" onclick="Seleccionar(<?= $categoria1->id ?>)">
                                        <div class="ia_table">
                                            <div class="ia_row">
                                                <div class="ia_cell"><span class="ia_icon_heart"></span></div>
                                                <div class="ia_cell"><?= $categoria1->descripcion_cabecera ?> <input type="hidden" id="ocultar<?= $categoria1->id ?>" ></div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php
                                $a++;
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="options_form options_our_school" data-option="2">
                <div class="opt_title">NUESTRO COLE</div>
                <div class="opt_content">
                    <div class="scrollCustom gray-skin">
                        <ul>
                            <?php
                                $b=1;
                                $categorias2=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>2])->all();
                                foreach($categorias2 as $categoria2)
                                {
                            ?>
                                <li>
                                    <a href="#" id="a<?= $categoria2->id ?>" data-id="<?= $b ?>" onclick="Seleccionar(<?= $categoria2->id ?>)">
                                        <div class="ia_table">
                                            <div class="ia_row">
                                                <div class="ia_cell"><span class="ia_icon_heart"></span></div>
                                                <div class="ia_cell"><?= $categoria2->descripcion_cabecera ?> <input type="hidden" id="ocultar<?= $categoria2->id ?>" ></div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php
                                $b++;
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="options_form options_my_regions" data-option="3">
                <div class="opt_title">MI REALIDAD LOCAL, REGIONAL Y NACIONAL</div>
                <div class="opt_content">
                    <div class="scrollCustom gray-skin">
                        <ul>
                            <?php
                                $c=1;
                                $categorias3=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>3])->all();
                                foreach($categorias3 as $categoria3)
                                {
                            ?>
                                <li>
                                    <a href="#" id="a<?= $categoria3->id ?>" data-id="<?= $c ?>" onclick="Seleccionar(<?= $categoria3->id ?>)" >
                                        <div class="ia_table">
                                            <div class="ia_row">
                                                <div class="ia_cell"><span class="ia_icon_heart"></span></div>
                                                <div class="ia_cell"><?= $categoria3->descripcion_cabecera ?> <input type="hidden" id="ocultar<?= $categoria3->id ?>" ></div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php
                                $c++;
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="vote_submit">
            <a class="btn btn-default" onclick="BtnVotar()" href="#" role="button">VOTAR</a>
    </div>
</div>
<div class="col-md-4">
    <div class="col-md-6">
        <div class="options_selected">
            <div class="option_items options_alternative_1">
                <div class="icon_alternative"><div class="num_alternative">01</div></div>
                <div class="text_alternative"></div>
            </div>
            <div class="option_items options_alternative_2">
                <div class="icon_alternative"><div class="num_alternative">02</div></div>
                <div class="text_alternative"></div>
            </div>
            <div class="option_items options_alternative_3">
                <div class="icon_alternative"><div class="num_alternative">03</div></div>
                <div class="text_alternative"></div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Votar -->

<div class="popup">
    <div class="popup_content">
        <a href="#" class="close_popup"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></a>
        <?php $form = ActiveForm::begin(); ?>
                <div class="form-group label-floating field-voto-dni required">
			<label class="control-label" for="voto-dni">DNI</label>
			<input type="text" id="voto-dni" class="form-control numerico" name="Voto[dni]"  onfocusout="CambioDNI(this)" maxlength="8">
		</div>
                <div class="form-group label-floating field-voto-region required">
			<label class="control-label" for="voto-region">Región</label>
			<select id="voto-region" class="form-control" name="Voto[region]" >
			    <option value></option>
			    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
				<option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
			    <?php } ?>
			</select>
		    </div>
                <div class="form-group">
                        <button type="button" class="btn btn-default" onclick="Votar()">VOTAR</button>
                </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$url= Yii::$app->getUrlManager()->createUrl('voto/validardni');
$urlinsert= Yii::$app->getUrlManager()->createUrl('voto/registrar');

?>
<script type="text/javascript">
    var myArray = [];
    var indices=[1,2,3];
    
    $(window).load(function () {
        $(".ia_show .scrollCustom").customScrollbar({
            updateOnWindowResize: true
        });
    });
    $('.numerico').keypress(function (tecla) {
        var reg = /^[0-9\s]+$/;
        if(!reg.test(String.fromCharCode(tecla.which))){
            return false;
        }
        return true;
    });
        
      
    $('.options_form .opt_title').on('click', function () {
        var _content = $(this).parent().children('.opt_content');
        if(!_content.is(":visible")){
            $('.opt_content').stop().slideUp();
            _content.slideDown();
            $(".scrollCustom", _content).customScrollbar({
                    updateOnWindowResize: true
            });
        }
    });

    $(".popup .close_popup").on('click', function (e) {
        e.preventDefault();
        var _popup = $(this).parents('.popup');
        _popup.hide();
    });
                
    function BtnVotar()
    {
        if(myArray.length<3)
        {
            $.notify({
                // options
                message: 'Debe seleccionar 3 proyectos' 
            },{
                // settings
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
            $('.popup').show();
            return true;
        }
    };
    
    function Seleccionar(asunto) {
        Agregar(asunto,'proyecto'+asunto);
        
    }
    var indice=0;
    //var prueba=1;
    function Agregar(value,identificador){
        var notificacion;
        var asuntotexto="";
        var _a = $('#a'+value);
        var _p = _a.parents('.options_form');
        var _n = _p.data("option");
        //var _f = $(".options_alternative_"+cont);
        indices.sort();
        
        
        
        notificacion=jQuery.inArray( value, myArray );
        
        if(notificacion!=-1)
        {
            $('#a'+value).removeClass("active");
            indices.push($("#ocultar"+value).val());
            
            myArray.splice(notificacion, 1);
            
            
            $(".options_alternative_"+$("#ocultar"+value).val()).removeClass(" selected");
            $(".options_alternative_"+$("#ocultar"+value).val()).children(".text_alternative").html("");
            
            //console.log(indices);
            return false;
        }
        
        if(myArray.length>2)
        {
            $.notify({
                // options
                message: 'Solo se puede votar por 3 proyectos' 
            },{
                // settings
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
            
            //console.log(indices);
            //indices.first();
            _a.addClass("active");
            $(".options_alternative_"+indices[0]).addClass("selected");
            $(".options_alternative_"+indices[0]).children(".text_alternative").html($(".ia_table .ia_row .ia_cell", _a).last().html());
            $('#item_option_'+ _n).val(_a.data("id"));
            $("#ocultar"+value).val(indices[0]);
            indices.splice(0,1);
            myArray.push(value);
            //cont++;
            //prueba++;
            return true;
            
        }
        
    }
                
    function Votar() {
        var error='';
        if($('#voto-dni').val()=='')
        {
            error='Ingrese DNI <br>';
            $('.field-voto-dni').addClass('has-error');
        }
        else
        {
            $('.field-voto-dni').addClass('has-success');
            $('.field-voto-dni').removeClass('has-error');
        }
        
        if($('#voto-region').val()=='')
        {
            error=error+'Ingrese Región <br>';
            $('.field-voto-region').addClass('has-error');
        }
        else
        {
            $('.field-voto-region').addClass('has-success');
            $('.field-voto-region').removeClass('has-error');
        }
        
        if(error!='')
        {
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
            $('.field-voto-dni').addClass('has-success');
            $('.field-voto-dni').removeClass('has-error');
            $('.field-voto-region').addClass('has-success');
            $('.field-voto-region').removeClass('has-error');
            $.ajax({
                url: '<?= $urlinsert ?>',
                type: 'GET',
                async: true,
                data: {'Voto[dni]':$('#voto-dni').val(),'Voto[region]':$('#voto-region').val(),Asuntos: myArray},
                success: function(data){
                
                    if(data==1)
                    {
                        $.notify({
                            // options
                            message: 'Gracias por registrar su voto' 
                        },{
                            // settings
                            type: 'success',
                            z_index: 1000000,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                        });
                        
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 2000);
                    }
                    else
                    {
                        $.notify({
                            // options
                            message: 'Hubo un problema en el registro' 
                        },{
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                        });
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 2000);
                    }
                }
            });
            return true;
        }   
    }
    
    function CambioDNI(elemento) {
        if($(elemento).val()!='')
        {
            if($(elemento).val().length<8)
            {
                $.notify({
                    // options
                    message: 'El DNI debe contener 8 caracteres' 
                },{
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                $('.field-voto-dni').addClass('has-error');
                $('#voto-dni').val('');
                return false;
            }
            
            $.ajax({
                url: '<?= $url ?>',
                //dataType: 'json',
                type: 'GET',
                async: true,
                data: {dni:$(elemento).val()},
                success: function(data){
                    if(data==1)
                    {
                        $('.field-voto-dni').addClass('has-error');
                        $.notify({
                            // options
                            message: 'El DNI ya existe' 
                        },{
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                    from: 'bottom',
                                    align: 'right'
                            },
                        });
                        $('#voto-dni').val('');
                        
                        
                    }
                }
            });
            return true;
            
        }
        return false;
    }   
</script>
