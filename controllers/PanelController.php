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
                'only' => ['index','acciones'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['acciones'],
                        'allow' => true,
                        'roles' => ['administrador'],
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
        $this->layout='estandar';
        if(\Yii::$app->user->can('administrador'))
        {
            return $this->redirect(['acciones']);
        }
        
        
        return $this->render('ideas-accion');
    }
    public function actionIndex()
    {
        $this->layout='estandar';
        if(\Yii::$app->user->can('administrador'))
        {
            return $this->redirect(['acciones']);
        }
        
        
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $estudiante=Estudiante::find()->where('id=:id',[':id'=>$usuario->estudiante_id])->one();
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$estudiante->id])->one();
        if($integrante)
        {
            $equipo=Equipo::findOne($integrante->equipo_id);
        }
        else
        {
            $equipo = new Equipo;
        }
        
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
                                       'equipo'=>$equipo
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
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total_comentario',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0) falta_valorar',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado'
                        ]) 
                ->innerJoin('asunto','foro.asunto_id=asunto.id')
                ->groupBy('foro.titulo,total_comentario')
                ->orderBy('total_comentario DESC,falta_valorar DESC,valorado DESC')
                ->all();
        
        $foroparticipacion= Foro::find()
                ->select([
                        'foro.id',
                        'foro.titulo',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=2) total_comentario',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=2 and foro_comentario.valoracion=0) falta_valorar',
                        '(select count(*) from foro_comentario where foro_comentario.foro_id=2 and foro_comentario.valoracion!=0) valorado'
                        ])
                ->where('foro.id=2')
                ->groupBy('foro.titulo,total_comentario')
                ->orderBy('total_comentario DESC,falta_valorar DESC,valorado DESC')
                ->one();
        
        return $this->render('foros',['forospublicos'=>$forospublicos,'foroparticipacion'=>$foroparticipacion]);
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
}
