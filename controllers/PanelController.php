<?php

namespace app\controllers;

use Yii;
use app\models\Equipo;
use app\models\Estudiante;
use app\models\Integrante;
use app\models\Usuario;
use app\models\Voto;
use app\models\Foro;
use app\models\Asunto;
use app\models\Ubigeo;
use app\models\Participante;
use app\models\Invitacion;
use app\models\ParticipanteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Resultados;
use app\models\Etapa;
use app\models\VotacionInternaSearch;
use app\models\VotacionInterna;
use app\models\VotacionPublica;
use app\models\Proyecto;
use app\models\ForoComentario;
use app\models\Institucion;
use app\models\Inscripcion;
use yii\data\Sort;


/**
 * ParticipanteController implements the CRUD actions for Participante model.
 */
class PanelController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Participante models.
     * @return mixed
     */
    public function actionIdeasAccion()
    {
        $this->layout='ideas';
        if(\Yii::$app->user->can('administrador'))
        {
            return $this->redirect(['panel/acciones']);
        }
        elseif(\Yii::$app->user->can('monitor'))
        {
            return $this->redirect(['reporte/index']);
        }
        
        
        return $this->render('ideas-accion');
    }
    public function actionIndex()
    {
        $this->layout='panel';
        if(\Yii::$app->user->can('administrador'))
        {
            return $this->redirect(['panel/acciones']);
        }
        elseif(\Yii::$app->user->can('monitor'))
        {
            return $this->redirect(['reporte/index']);
        }
        
        
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $estudiante=Estudiante::find()->where('id=:id',[':id'=>$usuario->estudiante_id])->one();
        $institucion=Institucion::find()->where('id=:id',[':id'=>$estudiante->institucion_id])->one();
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$estudiante->id])->one();
        if($integrante)
        {
            $equipo=Equipo::findOne($integrante->equipo_id);
            if($equipo->foto=="")
            {
                $equipo->foto="no_disponible.png";
            }
        }
        else
        {
            $equipo = new Equipo;
        }
        
        $estudiantes=Estudiante::find()
                    ->LeftJoin('integrante','integrante.estudiante_id=estudiante.id')
                    ->where('estudiante.institucion_id=:institucion_id and estudiante.id!=:id and integrante.id is null and estudiante.grado!=6
                            ',[':institucion_id'=>$institucion->id,':id'=>$estudiante->id])
                    ->orderBy('grado asc')->all();
                    
        $invitaciones=Invitacion::find()
                        ->select('usuario.avatar,invitacion.id,equipo.descripcion_equipo,lider.nombres,lider.apellido_paterno,lider.apellido_materno,lider.nombres_apellidos,institucion.denominacion')
                        ->innerJoin('equipo','equipo.id=invitacion.equipo_id')
                        ->innerJoin('estudiante lider','invitacion.estudiante_id=lider.id')
                        ->innerJoin('usuario','usuario.estudiante_id=lider.id')
                        ->innerJoin('institucion','institucion.id=lider.institucion_id')
                        ->where('invitacion.estudiante_invitado_id=:invitado and invitacion.estado=1',
                                [':invitado'=>$usuario->estudiante_id])
                        ->all();
                        
        
        
        return $this->render('index', ['invitaciones'=>$invitaciones,
                                       'integrante'=>$integrante,
                                       'estudiante'=>$estudiante,
                                       'equipo'=>$equipo,
                                       'estudiantes'=>$estudiantes
                            ]);
    }
    
    public function actionAcciones()
    {
        $this->layout='administrador';
        $countVoto=Voto::find()->count();
        $resultados=Resultados::find()->all();
        $Countresultados=Resultados::find()->count();
        $votacionpublica=VotacionPublica::find()->all();
        $etapa=Etapa::find()->where('estado=1')->one();
        $votacionesinternas=VotacionInterna::find()->count();
        $faltavalorporcentual=VotacionInterna::find()
                        ->innerJoin('proyecto','proyecto.id=votacion_interna.proyecto_id')
                        ->where('votacion_interna.estado=2 and proyecto.valor_porcentual_administrador is null ')->count();
        
        return $this->render('acciones',['resultados'=>$resultados,'etapa'=>$etapa,
                                         'faltavalorporcentual'=>$faltavalorporcentual,
                                         'votacionpublica'=>$votacionpublica,
                                         'countVoto'=>$countVoto,'Countresultados'=>$Countresultados,
                                         'votacionesinternas'=>$votacionesinternas]);
    }
    
    public function actionCerrar($bandera)
    {
        $resultados=Resultados::find()->all();
        $connection = \Yii::$app->db;
        $ubigeos=Ubigeo::find()->select('department_id,department')->groupBy('department_id')->orderBy('department desc')->all();
        if($bandera==1 && !$resultados)
        {
            foreach($ubigeos as $ubigeo)
            {
                $command=$connection->createCommand("
                    insert into resultados (asunto_id,region_id,cantidad)
                    select asunto_id,region_id,COUNT(asunto_id) contador from voto
                    where region_id='$ubigeo->department_id'
                    group by region_id,asunto_id
                    order by contador desc
                    limit 3;
                ");
                
                $command->execute();
                
            }
            echo 1;
        }
        else
        {
            echo 2;
        }
    }
    
    public function actionVotacioninterna()
    {
        $this->layout='administrador';
        
        $searchModel = new VotacionInternaSearch();
        $dataProvider = $searchModel->votacion(Yii::$app->request->queryParams);
        $countInterna=VotacionInterna::find()->select(['count(proyecto_id) as maximo'])->groupBy('proyecto_id')->one();
        
        return $this->render('votacioninterna',[
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'countInterna'=>$countInterna]);
    }
    
    public function actionForos()
    {
        $this->layout='administrador';
        $forospublicos= Foro::find()
                ->select([
                        'foro.id',
                        'foro.titulo',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and not foro_comentario.user_id between 2 and 8) pendiente',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and foro_comentario.user_id between 2 and 8) emitido'
                        ]) 
                ->innerJoin('asunto','foro.asunto_id=asunto.id')
                ->innerJoin('resultados','resultados.asunto_id=foro.asunto_id')
                ->groupBy('foro.titulo,total')
                ->orderBy('total DESC,pendiente DESC,valorado DESC')
                ->all();
        
        $foroparticipacion= Foro::find()
                ->select([
                        'foro.id',
                        'foro.titulo',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and not foro_comentario.user_id between 2 and 8) pendiente',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and foro_comentario.user_id between 2 and 8) emitido'
                        ])
                ->where('foro.id=2')
                ->groupBy('foro.titulo,total')
                ->orderBy('total DESC,pendiente DESC,valorado DESC')
                ->one();
        $resultado=new Resultados;
        $resultado->load(Yii::$app->request->queryParams);
        
        $sort = new Sort([
            'attributes' => [
                /*'department' => [
                    'label' => 'Región',
                ],
                'total_estudiantes' => [
                    'label' => 'Total',
                ],*/
                
            ],
        ]);
        
        return $this->render('foros',['resultado'=>$resultado,'sort' => $sort,'forospublicos'=>$forospublicos,'foroparticipacion'=>$foroparticipacion]);
    }
    
    
    public function actionResultadosasuntospublicos($asunto)
    {
        $data=[];
        
        //var_dump($asunto);
        /*$proyectos= Proyecto::find()
                    ->select([
                              'proyecto.titulo',
                              '(select count(foro_comentario.id) from foro_comentario 
                                inner join usuario on usuario.id=foro_comentario.user_id 
                                inner join integrante on integrante.estudiante_id=usuario.estudiante_id
                                where integrante.equipo_id=proyecto.equipo_id and foro_comentario.valoracion!=0) as valorados',
                                '(select count(foro_comentario.id) from foro_comentario 
                                inner join usuario on usuario.id=foro_comentario.user_id 
                                inner join integrante on integrante.estudiante_id=usuario.estudiante_id
                                where integrante.equipo_id=proyecto.equipo_id and foro_comentario.valoracion=0) as faltan_valorar'])
                    ->innerJoin('asunto','asunto.id=proyecto.asunto_id')
                    ->innerJoin('foro','foro.asunto_id=asunto.id')
                    ->where('foro.asunto_id=:asunto_id',[':asunto_id'=>$asunto])
                    ->groupBy('proyecto.titulo,valorados,faltan_valorar')
                    ->orderBy('valorados desc,proyecto.id asc')
                    ->all();*/
        $connection = \Yii::$app->db;
        $proyectos = $connection->createCommand('
                    select 
                        proyecto.titulo,
                        (select count(foro_comentario.id) from foro_comentario 
                        inner join usuario on usuario.id=foro_comentario.user_id 
                        inner join integrante on integrante.estudiante_id=usuario.estudiante_id
                        where integrante.equipo_id=proyecto.equipo_id and foro_comentario.valoracion!=0) as valorado,
                        (select count(foro_comentario.id) from foro_comentario 
                        inner join usuario on usuario.id=foro_comentario.user_id 
                        inner join integrante on integrante.estudiante_id=usuario.estudiante_id
                        where integrante.equipo_id=proyecto.equipo_id and foro_comentario.valoracion=0) as falta_valorar
                    from proyecto
                    inner join asunto on asunto.id=proyecto.asunto_id
                    inner join foro on foro.asunto_id=asunto.id 
                    where foro.asunto_id='.$asunto.'
                    group by proyecto.titulo,valorado,falta_valorar
                    order by valorado desc,proyecto.id asc')
                ->queryAll();
        
        foreach( $proyectos as $proyecto)
        {
            array_push($data,['titulo'=>$proyecto["titulo"],'valorado'=>$proyecto["valorado"],'falta_valorar'=>$proyecto["falta_valorar"]]);
        }
        
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        
    }
    
    public function actionRating($rating,$comentario_id)
    {
        $foro_comentario=ForoComentario::findOne($comentario_id);
        $foro_comentario->valoracion=$rating;
        $foro_comentario->update();
    }
    
    
    public function actionForosproyectos()
    {
        $this->layout='administrador';
        
        
        return $this->render('forosproyectos',[]);
    }
    
    public function actionResultadosproyectos($region)
    {
        $data=[];
        $connection = \Yii::$app->db;
        
        $forosproyectos= Foro::find()
                ->select([
                        'foro.id',
                        'foro.titulo',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total_comentario',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0) falta_valorar',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado'
                        ]) 
                ->innerJoin('proyecto','proyecto.id=foro.proyecto_id')
                ->where('proyecto.region_id=:region_id',[':region_id'=>$region])
                ->groupBy('foro.titulo,total_comentario')
                ->orderBy('id desc,total_comentario DESC,falta_valorar DESC,valorado DESC')
                ->all();
        
        foreach( $forosproyectos as $proyecto)
        {
            array_push($data,['titulo'=>$proyecto["titulo"],'total_comentario'=>$proyecto["total_comentario"],'falta_valorar'=>$proyecto["falta_valorar"],'valorado'=>$proyecto["valorado"],'foro'=>$proyecto["id"]]);
        }
        
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    
    public function actionProceso1()
    {
	$inscripciones=Inscripcion::find()->where('equipo!="" and equipo is not null')->all();
	foreach($inscripciones as $inscripcion){
            
            $institucion=Institucion::find()->where('codigo_modular=:codigo_modular',[':codigo_modular'=>$inscripcion->codigo_modular])->one();
	    if($institucion){
                $estudiante=Estudiante::find()->where('dni=:dni or email=:email',[':dni'=>$inscripcion->dni,':email'=>$inscripcion->email])->one();
                if($estudiante)
                {
                    $estudiante->email=$inscripcion->email;
                    $estudiante->dni=$inscripcion->dni;
                    $estudiante->update();
                    $usuario=Usuario::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$estudiante->id])->one();
                    $usuario->username=$inscripcion->email;
                    $usuario->password='$2y$13$T6OEJW0WjS30nlKofw5gTetHkSrhKPAddewnCJR1jkjdljcWw0rvu';
                    $usuario->update();
                    echo "se ha actualizado el email,dni y contraseña en base al excel :".$estudiante->dni.", ".$estudiante->email;
                }
                else
                {
                    $estudiante=new Estudiante();
                    $estudiante->institucion_id=$institucion->id;
                    $estudiante->dni=$inscripcion->dni;
                    $estudiante->email=$inscripcion->email;
                    $estudiante->apellido_paterno=$inscripcion->paterno;
                    $estudiante->apellido_materno=$inscripcion->materno;
                    $estudiante->nombres=$inscripcion->nombres;
                    $estudiante->celular=$inscripcion->celular;
                    $estudiante->save();
                    
                    $usuario=new Usuario;
                    $usuario->username=$inscripcion->email;
                    $usuario->password='$2y$13$T6OEJW0WjS30nlKofw5gTetHkSrhKPAddewnCJR1jkjdljcWw0rvu';
                    $usuario->status=1;
                    $usuario->avatar="no_disponible.jpg";
                    $usuario->estudiante_id=$estudiante->id;
                    $usuario->fecha_registro=date("Y-m-d H:i:s");
                    $usuario->save();
                    echo "Se ha creado al estudiante: ".$estudiante->dni;
                }
                
                if($inscripcion->rol==1)
                {
                    $coordinador=Integrante::find()->where('estudiante_id=:estudiante_id and rol=1',[':estudiante_id'=>$estudiante->id])->one();
                    if($coordinador)
                    {
                        $equipo=Equipo::find()->where('id=:id',[':id'=>$coordinador->equipo_id])->one();
                    }
                    else
                    {
                        $equipo=new Equipo;
                        $equipo->descripcion_equipo=$inscripcion->equipo;
                        $equipo->descripcion=$inscripcion->equipo;
                        $equipo->fecha_registro=date("Y-m-d H:i:s");
                        $equipo->estado=0;
                        $equipo->etapa=1;
                        $equipo->save();
                        $coordinador=new Integrante;
                        $coordinador->estudiante_id=$estudiante->id;
                        $coordinador->equipo_id=$equipo->id;
                        $coordinador->rol=1;
                        $coordinador->estado=1;
                        $coordinador->save();
                    }
                }
            }   
        }
    }
    
    
    public function actionProceso2()
    {
	$inscripciones=Inscripcion::find()->where('equipo!="" and equipo is not null and rol=1')->all();
	foreach($inscripciones as $inscripcion){
            $institucion=Institucion::find()->where('codigo_modular=:codigo_modular',[':codigo_modular'=>$inscripcion->codigo_modular])->one();
            if($institucion)
            {
                $estudiante=Estudiante::find()->where('dni=:dni or email=:email',[':dni'=>$inscripcion->dni,':email'=>$inscripcion->email])->one();
                $coordinador=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$estudiante->id])->one();
                $equipo=Equipo::find()->where('id=:id',[':id'=>$coordinador->equipo_id])->one();
                $estudiantes_por_invitarlos=Inscripcion::find()->where('equipo!="" and equipo is not null and rol=2 and lider_equipo=:lider_equipo',
                                                                       [':lider_equipo'=>$estudiante->email])->all();
                foreach($estudiantes_por_invitarlos as $estudiante_por_invitar){
                    $institucionx=Institucion::find()->where('codigo_modular=:codigo_modular',[':codigo_modular'=>$estudiante_por_invitar->codigo_modular])->one();
                    if($institucionx)
                    {
                        $estudianteainvitar=Estudiante::find()->where('dni=:dni or email=:email',[':dni'=>$estudiante_por_invitar->dni,':email'=>$estudiante_por_invitar->email])->one();
                        $invitaciones=Invitacion::find()
                            ->where('estado in (1,2) and estudiante_invitado_id=:estudiante_invitado_id',[':estudiante_invitado_id'=>$estudianteainvitar->id])
                            ->all();
                        if($invitaciones)
                        {
                            foreach($invitaciones as $invitacion)
                            {
                                $invi=Invitacion::findOne($invitacion->id);
                                if($invitacion->estado==1)
                                {
                                    $invi->estado=2;
                                    $invi->update();
                                    $integrante=new Integrante;
                                    $integrante->equipo_id=$equipo->id;
                                    $integrante->estudiante_id=$estudianteainvitar->id;
                                    $integrante->rol=2;
                                    $integrante->estado=1;
                                    $integrante->save();
                                }
                            }
                        }
                        else
                        {
                            $invitacion=new Invitacion;
                            $invitacion->equipo_id=$equipo->id;
                            $invitacion->estudiante_id=$estudiante->id;
                            $invitacion->estudiante_invitado_id=$estudianteainvitar->id;
                            $invitacion->estado=2;
                            $invitacion->fecha_invitacion=date("Y-m-d H:i:s");
                            $invitacion->fecha_aceptacion=date("Y-m-d H:i:s");
                            $invitacion->save();
                            $integrante=new Integrante;
                            $integrante->equipo_id=$equipo->id;
                            $integrante->estudiante_id=$estudianteainvitar->id;
                            $integrante->rol=2;
                            $integrante->estado=1;
                            $integrante->save();
                        }
                    }
                    
                }
            }
            
        }
    }
    
    
    public function actionProceso3()
    {
	$inscripciones=Inscripcion::find()->where('equipo!="" and equipo is not null and rol=1')->all();
	foreach($inscripciones as $inscripcion){
            $estudiante=Estudiante::find()->where('dni=:dni or email like ("%:email%")',[':dni'=>$inscripcion->dni,':email'=>$inscripcion->email])->one();
            $coordinador=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$estudiante->id])->one();
            $equipo=Equipo::find()->where('id=:id',[':id'=>$coordinador->equipo_id])->one();
            
        }
    }
}
