<?php

use yii\helpers\Html;
use app\models\Integrante;
use app\models\Invitacion;

if($integrante)
{
    $integrantes=Integrante::find()
                ->select('integrante.id,estudiante.nombres_apellidos,integrante.estudiante_id,integrante.rol,estudiante.email')
                ->innerJoin('estudiante','integrante.estudiante_id=estudiante.id')
                ->where('integrante.equipo_id=:equipo_id and integrante.estado=1',[':equipo_id'=>$integrante->equipo_id])
                ->all();
                
    $connection = \Yii::$app->db;
    $command=$connection->createCommand("
                SELECT AA.tipo,AA.equipo_id,AA.id,AA.nombres_apellidos,AA.nombres,AA.apellido_paterno,AA.apellido_materno,
                AA.estudiante_id,AA.rol,AA.estado,AA.email,AA.orden,AA.avatar,AA.grado
                FROM
                (
                select 1 tipo,integrante.equipo_id,integrante.id,estudiante.nombres_apellidos,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,
                integrante.estudiante_id,integrante.rol,integrante.estado,estudiante.email,1 orden,usuario.avatar,estudiante.grado
                from integrante
                inner join estudiante on integrante.estudiante_id=estudiante.id
                inner join usuario on usuario.estudiante_id=estudiante.id
                where integrante.equipo_id=".$integrante->equipo_id." and integrante.estado in (1,2)
                union
                select 2 tipo,invitacion.equipo_id,invitacion.id,estudiante.nombres_apellidos,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,
                estudiante.id,0,6,estudiante.email,2,usuario.avatar,estudiante.grado
                from invitacion
                inner join estudiante on invitacion.estudiante_invitado_id=estudiante.id
                inner join usuario on usuario.estudiante_id=estudiante.id
                where invitacion.equipo_id=".$integrante->equipo_id." and invitacion.estado=1
                ) AA
                ORDER BY AA.orden ASC,AA.ROL ASC
                
               ");
    $equipoeinvitaciones = $command->queryAll();
    $integrantestotales=[];
    //cont=0;
    foreach($equipoeinvitaciones as $equipoinvitacion)
    {
        array_push($integrantestotales,['nombres'=>$equipoinvitacion['nombres']." ".$equipoinvitacion['apellido_paterno']." ".$equipoinvitacion['apellido_materno'],'grado'=>$equipoinvitacion['grado'],'avatar'=>$equipoinvitacion['avatar']]);
    }
    $primeras3elementos = array_slice($integrantestotales, 0, 3);
    $otros3elementos= array_slice($integrantestotales, 3,6);
}
$btninscribir=$integrante
?>

<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">MI EQUIPO
</div>

    


<?php if(!$integrante) { ?>
    <?php if(!$invitaciones){ ?>
        <!--Comienza-->
        <div class="box_content contenido_seccion_equipo">
            <div class="texto_final_equipo">
                
                <?php if($estudiante->grado!=6){ ?>
                    <p class="text-center"><b>No tienes invitaciones activas de otros equipos,</b></p>
                    <p class="text-center"><b>te invitamos a ser el coordinador de un equipo.</b></p>
                <?php } else { ?>
                    <p class="text-center"><b>No tienes invitaciones activas de otros equipos.</b></p>
                <?php } ?>
            </div>
        <?php if(!$integrante && $estudiante->grado!=6){ ?>
            <div class="final_seccion_equipo">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <?= Html::a('Crea tu equipo',['inscripcion/index'],['class'=>'btn btn-default btn-raised ']); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
    <?php } else { ?>
    <div class="box_content contenido_seccion_equipo">
        <div class="titulo_contenido_equipo">
            <b>Has recibido invitaciones</b> para ser parte de otros equipos, revisalas y confirma tu participación.
        </div>

        <div class="inputs_seccion_equipo">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Equipo</th>
                    <th>Coordinador</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                <?php
                foreach($invitaciones as $invitacion)
                {
                    echo "<tr>
                            <td style='vertical-align:middle'>$invitacion->descripcion_equipo</td>
                            <td style='vertical-align:middle'><div class='row-picture'>
                            <img class='circle' src='../../web/foto_personal/".$invitacion->avatar."' alt='icon' style='height: 30px;width: 30px'>
                        ".$invitacion->nombres." ".$invitacion->apellido_paterno." ".$invitacion->apellido_materno."
                      </div> </td>
                            <td class='text-center' style='vertical-align:middle'><div style='color:green;font-size:24px;cursor:pointer'  class='fa  fa-check-circle-o fa-6' onclick='unirme($invitacion->id)'></div></td>
                            <td class='text-center' style='vertical-align:middle'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' onclick='rechazar($invitacion->id)'></div></td>
                            </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php if($estudiante->grado!=6){ ?>
            <div class="final_seccion_equipo">
                <div class="texto_final_equipo">
                    <b>Si no te gusta ninguno de los equipos puedes crear el tuyo</b>
                </div>
                <div class="row">
                    <div class="col-md-4">
    
                    </div>
                    <div class="col-md-4">
                        <?= Html::a('Crea tu equipo',['inscripcion/index'],['class'=>'btn btn-default btn-raised ']); ?>
                    </div>
                    <div class="col-md-4">
    
                    </div>
                </div>
            </div>
        <?php } ?>
        
    </div>
    
    <?php } ?>
    
    
    
<?php } ?>

<?php if($integrante){ ?>
<div class="box_content contenido_seccion_crear_equipo">
    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <label for="">Nombre de tu equipo:</label>
                <div class="rpta">
                    <?= $equipo->descripcion_equipo ?>
                </div>
            </div>

            <div class="form-group">
                <label for="">Danos una breve descripión de tu equipo:</label>
                <div class="rpta">
                    <?= $equipo->descripcion ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for=""> </label>
                <div class="imagen_equipo">
                    <?= Html::img('../foto_equipo/'.$equipo->foto,['id'=>'img_destino','class'=>'img-responsive logo', 'alt'=>'Responsive image','style'=>"height: 158px;width: 158px"]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Selecciona el asunto del público sobrea el que trabajará tu equipo:</label>
                <div class="rpta">
                    <?= $equipo->asunto->descripcion_cabecera ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row lista_miembros_equipo">
        <div class="col-md-12">
                <label for="">Los miembros de tu equipo:</label>
        </div>

        <div class="col-md-12">
            <?php if($equipo->estado==0){ ?>
            <table class="table table-striped table-hover ">
                <thead>
                    <th>Nombres y apellidos</th>
                    <th>correo electrónico</th>
                    <th>Estado</th>
                    <?php if($equipo->estado==0){ ?>
                    <th class='text-center'></th>
                    <?php } ?>
                </thead>
                <tbody>
                
                    <?php
                    $i=1;
                        foreach($equipoeinvitaciones as $equipoeinvitacion)
                        {
                            echo    "<tr>
                                        <td>".$equipoeinvitacion['nombres']." ".$equipoeinvitacion['apellido_paterno']." ".$equipoeinvitacion['apellido_materno']."</td>";
                            
                            echo    "<td>".$equipoeinvitacion['email']."</td>";
                                        
                            if($integrante->rol==1)
                            {
                                if($equipoeinvitacion['rol']==1)
                                {
                                    echo    "<td>Coordinador</td>
                                            <td></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estado']==1 && $equipoeinvitacion['grado']!=6)
                                {
                                    echo    "<td>Integrante</td>
                                            <td class='text-center'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' onclick='eliminarintegrante(".$equipoeinvitacion['estudiante_id'].")'></div></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estado']==2 && $equipoeinvitacion['grado']!=6)
                                {
                                    echo    "<td>Integrante</td>
                                            <td></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estado']==1 && $equipoeinvitacion['grado']==6)
                                {
                                    echo    "<td>Docente</td>
                                            <td class='text-center'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' onclick='eliminarintegrante(".$equipoeinvitacion['estudiante_id'].")'></div></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estado']==2 && $equipoeinvitacion['grado']==6)
                                {
                                    echo    "<td>Docente</td>
                                            <td></td>";
                                }
                                elseif($equipoeinvitacion['rol']==0)
                                {
                                    echo    "<td>Invitado</td>
                                            <td class='text-center'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' onclick='eliminarinvitado(".$equipoeinvitacion['estudiante_id'].",".$equipoeinvitacion['equipo_id'].")'></div></td>";
                                }
                            }
                            elseif($integrante->rol==2)
                            {
                                if($equipoeinvitacion['rol']==1)
                                {
                                    echo    "<td>Coordinador</td>
                                            <td></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estudiante_id']==$integrante->estudiante_id && $equipoeinvitacion['estado']==1 && $equipoeinvitacion['grado']!=6)
                                {
                                    echo    "<td>Integrante</td>
                                            <td class='text-center'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' onclick='dejarequipo(".$equipoeinvitacion['estudiante_id'].")'></div></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estudiante_id']==$integrante->estudiante_id && $equipoeinvitacion['estado']==2 && $equipoeinvitacion['grado']!=6)
                                {
                                    echo    "<td>Integrante</td>
                                            <td></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estudiante_id']!=$integrante->estudiante_id && $equipoeinvitacion['grado']!=6)
                                {
                                    echo    "<td>Integrante</td>
                                            <td></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estudiante_id']==$integrante->estudiante_id && $equipoeinvitacion['estado']==1 && $equipoeinvitacion['grado']==6)
                                {
                                    echo    "<td>Docente</td>
                                            <td class='text-center'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' onclick='dejarequipo(".$equipoeinvitacion['estudiante_id'].")'></div></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estudiante_id']==$integrante->estudiante_id&& $equipoeinvitacion['estado']==2 && $equipoeinvitacion['grado']==6)
                                {
                                    echo    "<td>Docente</td>
                                            <td></td>";
                                }
                                elseif($equipoeinvitacion['rol']==2 && $equipoeinvitacion['estudiante_id']!=$integrante->estudiante_id && $equipoeinvitacion['grado']==6)
                                {
                                    echo    "<td>Docente</td>
                                            <td></td>";
                                }
                                elseif($equipoeinvitacion['rol']==0)
                                {
                                    echo    "<td>Invitado</td>
                                            <td></td>";
                                }
                            }
                            
                            echo    "</tr>";
                        $i++;
                    } ?>
                
                </tbody>
            </table>
            <?php } elseif($equipo->estado==1){ ?>
            
            <div class="col-md-1">
                    &nbsp;
            </div>

            <div class="col-md-5">
                <?php for($i=0;$i<count($primeras3elementos);$i++){?>
                    <div class="table_div">
                            <div class="row_div">
                                    <div class="cell_div div_ia_icon">
                                            <div class="imagen_perfil_miembro" style="background-image: url(../foto_personal/<?= $primeras3elementos[$i]['avatar'] ?>);"></div>
                                    </div>
                                    <div class="cell_div uppercase">
                                            <b><?= $primeras3elementos[$i]['nombres'] ?></b><br>
                                    </div>
                            </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-1">
                    &nbsp;
            </div>

            <div class="col-md-5">
                <?php for($i=0;$i<count($otros3elementos);$i++){?>
                    <div class="table_div">
                            <div class="row_div">
                                    <div class="cell_div div_ia_icon">
                                            <div class="imagen_perfil_miembro" style="background-image: url(../foto_personal/<?= $otros3elementos[$i]['avatar'] ?>);"></div>
                                    </div>
                                    <div class="cell_div uppercase">
                                            <b><?= $otros3elementos[$i]['nombres'] ?></b><br>
                                    </div>
                            </div>
                    </div>
                <?php } ?>
            </div>
            
            <?php } ?>
        </div>
    </div>
    <?php if( $integrante && $integrante->rol==1 && $integrante->estado==1) { ?>
    <div class="row">
            <div class="col-md-4">
                <?= Html::a('Modificar equipo',['inscripcion/actualizar','id'=>$estudiante->id],['class'=>'btn btn-default']); ?>
            </div>
            <div class="col-md-4">
                <button class='btn btn-default' onclick='dejarequipo(<?= $estudiante->id ?>)'>Cancelar equipo</button>
            </div>
            <div class="col-md-4">
                <button class='btn btn-default' onclick='finalizarequipo(<?=  $integrante->equipo_id ?>)'>Finalizar equipo</button>
            </div>
    </div>
    
    <?php } ?>
</div> 


<?php //if($equipo->estado==0){ ?>

<?php /*} elseif($equipo->estado==1) {?>
    <?php
    $i=1;
        foreach($equipoeinvitaciones as $equipoeinvitacion)
        {
            
            $i++;
        }
    ?>
<?php }*/ ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if(!$equipo->descripcion_equipo){?>
<?php }?>
    
            
        <?php
        if(!$integrante)
        { /*
        ?>
        <div class="final_seccion_equipo">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <?= Html::a('Crea tu equipo',['inscripcion/index'],['class'=>'btn btn-default btn-raised ']); ?>
            </div>
        </div>
        </div>
        <?php */ }
        if( $integrante && $integrante->rol==1 && $integrante->estado==1)
        {
        //echo Html::a('Actualizar equipo',['inscripcion/actualizar','id'=>$estudiante->id],['class'=>'btn btn-raised btn-default']);
        //echo " <button class='btn btn-raised btn-default' onclick='dejarequipo(".$estudiante->id.")'>Cancelar equipo</button>";
        //echo " <button class='btn btn-raised btn-default' onclick='finalizarequipo(".$integrante->equipo_id.")'>Finalizar equipo</button>";
        }
        ?>
    

<?php
    $unirme= Yii::$app->getUrlManager()->createUrl('equipo/unirme');
    $validarunirme=Yii::$app->getUrlManager()->createUrl('equipo/validarunirme');
    $rechazar= Yii::$app->getUrlManager()->createUrl('equipo/rechazar');
    $dejarequipo= Yii::$app->getUrlManager()->createUrl('equipo/dejarequipo');
    $eliminarinvitado= Yii::$app->getUrlManager()->createUrl('equipo/eliminarinvitado');
    $eliminarintegrante= Yii::$app->getUrlManager()->createUrl('equipo/eliminarintegrante');
    $validarequipo= Yii::$app->getUrlManager()->createUrl('equipo/validarequipo');
    $finalizarequipo= Yii::$app->getUrlManager()->createUrl('equipo/finalizarequipo');
    $finalizarequipovalidar= Yii::$app->getUrlManager()->createUrl('equipo/finalizarequipovalidar');
    $validarparafinalizar= Yii::$app->getUrlManager()->createUrl('equipo/validarparafinalizar');
?>
<script>
function unirme(id) {
    var validarunirme=1;
    $.ajax({
        url: '<?php echo $validarunirme ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            if (data==0) {
                $.notify({
                    // options
                    message: 'El lider te ha eliminado' 
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
                validarunirme=0;
                console.log(validarunirme);
            }
            else
            {
                $.ajax({
                    url: '<?php echo $unirme ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id},
                    success: function(data){
                        $.notify({
                            // options
                            message: 'Gracias se ha unido al equipo  ' 
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
                });
            }
            
        }
    });
    
    
}


function rechazar(id) {
    $.ajax({
        url: '<?php echo $rechazar ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            $.notify({
                // options
                message: 'Ha rechazado la invitación' 
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
    });
}

function dejarequipo(id) {
    
    $.ajax({
        url: '<?php echo $validarequipo ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            if (data==1) {
                $.notify({
                    // options
                    message: 'Ya no pertenecs al equipo o el lider a eliminado el equipo' 
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
            else if (data==2)
            {
                $.ajax({
                    url: '<?php echo $dejarequipo ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id},
                    success: function(data){
                        $.notify({
                            // options
                            message: 'Has dejado el equipo' 
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
                });
            }
            else if (data==3) {
                $.notify({
                    // options
                    message: 'El lider del equipo ah finalizado el equipo, incluyendote' 
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
    
    
}


function eliminarinvitado(id,equipo) {
    $.ajax({
        url: '<?php echo $eliminarinvitado ?>',
        type: 'GET',
        async: true,
        data: {id:id,equipo:equipo},
        success: function(data){
            $.notify({
                // options
                message: 'Invitación eliminada' 
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
    });
}

function eliminarintegrante(id) {
    $.ajax({
        url: '<?php echo $eliminarintegrante ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            if (data==1) {
                $.notify({
                    // options
                    message: 'Has retirado al integrante' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                }); 
            }
            else if (data==2) {
                $.notify({
                    // options
                    message: 'El integrante se ha retirado' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                }); 
            }
            
            setTimeout(function(){
                window.location.reload(1);
            }, 2000);
        }
    });
}


function finalizarequipo(id) {
    var texto="";
    var error="";
    var validarparafinalizar=$.ajax({
        url: '<?php echo $validarparafinalizar ?>',
        type: 'GET',
        async: false,
        data: {id:id},
        success: function(data){}
    });
    
    var finalizarequipovalidar=$.ajax({
        url: '<?php echo $finalizarequipovalidar ?>',
        type: 'GET',
        async: false,
        data: {id:id},
        success: function(data){}
    });
    
    if (finalizarequipovalidar.responseText==2) {
        error="No tienes la cantidad suficiente de integrantes para finalizar el equipo, deben ser 4 integrantes como mínimo";
    }
    else if (finalizarequipovalidar.responseText==3) {
        error="Necesitas invitar a un docente para finalizar el equipo";
    }
    else if (finalizarequipovalidar.responseText==4) {
        error=  "No tienes la cantidad suficiente de integrantes para finalizar el equipo, deben ser 4 integrantes como mínimo <br>"+
                "Necesitas invitar a un docente para finalizar el equipo";
    }
    
    if (error!="") {
        $.notify({
            // options
            message: error
        },{
            // settings
            type: 'danger',
            z_index: 1000000,
            placement: {
                    from: 'bottom',
                    align: 'right'
            },
        });//code
        return false;
    }
                
    
    
    if (validarparafinalizar.responseText==1) {
        texto="Estas seguro de finalizar tu equipo, aún tienes invitaciones pendientes los cuales serán eliminadas";
    }
    else if (validarparafinalizar.responseText==0) {
        texto="Estas seguro de finalizar tu equipo";
    }
    
    var txt;
    var r = confirm(texto);
    if (r == true) {
        $.ajax({
            url: '<?php echo $finalizarequipo ?>',
            type: 'GET',
            async: true,
            data: {id:id},
            success: function(data){
                if (data==1) {
                    $.notify({
                        // options
                        message: 'Ha finalizado su equipo' 
                    },{
                        // settings
                        type: 'success',
                        z_index: 1000000,
                        placement: {
                                from: 'bottom',
                                align: 'right'
                        },
                    });
                }
                setTimeout(function(){
                    window.location.reload(1);
                }, 2000);
            }
        });
    }
    
    
    
    
    
}
</script>