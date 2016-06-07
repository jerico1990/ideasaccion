<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use app\models\Voto;
use app\models\Estudiante;
use app\models\Foro;
use app\models\Equipo;
use app\models\Proyecto;
use yii\data\Sort;
/**
 * ProyectoController implements the CRUD actions for Proyecto model.
 */
class ReporteController extends Controller
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
     * Lists all Proyecto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='administrador';
        
        $sort = new Sort([
            'attributes' => [
                'voto_emitido' => [
                    'label' => 'Votos emitidos',
                ],
                'descripcion_cabecera' => [
                    'label' => 'Asunto público',
                ],
                
            ],
        ]);
        
        $model = new Voto();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('index', [
            'model' => $model,
            'sort' => $sort,
        ]);
    }
    
    public function actionRegion()
    {
        $this->layout='administrador';
        
        $sort = new Sort([
            'attributes' => [
                'voto_emitido' => [
                    'label' => 'Votos emitidos',
                ],
                'region_id' => [
                    'label' => 'Región',
                ],
                
            ],
        ]);
        
        $model = new Voto();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('region', [
            'model' => $model,
            'sort' => $sort,
        ]);
    }
    
    public function actionIndex_descargar($region=null)
    {
        return $this->render('index_descargar', [
            'region' => $region,
        ]);
    }
    
    public function actionRegion_descargar($region=null)
    {
        return $this->render('region_descargar', [
            'region' => $region,
        ]);
    }
    
    public function actionRegistrados()
    {
        $this->layout='administrador';
        
        $sort = new Sort([
            'attributes' => [
                'department' => [
                    'label' => 'Región',
                ],
                'total_estudiantes' => [
                    'label' => 'Total',
                ],
                'estudiantes_finalizaron_equipo' => [
                    'label' => 'Finalizaron equipos',
                ],
                'estudiantes_aceptaron_invitacion' => [
                    'label' => 'Falta finalizar equipo',
                ],
                'estudiantes_invitaciones_pendientes' => [
                    'label' => 'Invitaciones pendientes',
                ],
                'estudiantes_huerfanos' => [
                    'label' => 'Sin equipo',
                ],
                
            ],
        ]);
        
        $model = new Estudiante();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('registrados', [
            'model' => $model,
            'sort' => $sort,
        ]);
    }
    
    public function actionRegistrados_descargar()
    {
        return $this->render('registrados_descargar');
    }
    
    public function actionRegistradosDetalles()
    {
        $this->layout='administrador';
        
        $sort = new Sort([
            'attributes' => [
                /*'department' => [
                    'label' => 'Región',
                ],
                'total_estudiantes' => [
                    'label' => 'Total',
                ],
                'estudiantes_finalizaron_equipo' => [
                    'label' => 'Finalizaron equipos',
                ],
                'estudiantes_aceptaron_invitacion' => [
                    'label' => 'Falta finalizar equipo',
                ],
                'estudiantes_invitaciones_pendientes' => [
                    'label' => 'Invitaciones pendientes',
                ],
                'estudiantes_huerfanos' => [
                    'label' => 'Sin equipo',
                ],*/
                
            ],
        ]);
        
        $model = new Estudiante();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('registrados-detalles', [
            'model' => $model,
            'sort' => $sort,
        ]);
    }
    
    public function actionRegistradosDetalles_descargar($region=null,$estado=null)
    {
        return $this->render('registrados-detalles_descargar',['region'=>$region,'estado'=>$estado]);
    }
    
    public function actionEquipo()
    {
        $this->layout='administrador';
        
        $sort = new Sort([
            'attributes' => [
                'department' => [
                    'label' => 'Región',
                ],
                'province'=>[
                    'label' => 'Total de equipos finalizados',
                ],
                'district'=>[
                    'label' => 'Total integrantes de equipos finalizados',
                ],
                'latitude'=>[
                    'label' => 'Total de equipos no finalizados',
                ],
                'longitud'=>[
                    'label' => 'Total integrantes de equipos no finalizados',
                ],
            ],
        ]);
        
        $model = new Equipo();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('equipo', [
            'model' => $model,
            'sort' => $sort,
        ]);
    }
    
    public function actionEquipoDescargar()
    {
        $this->layout='administrador';
        
        $sort = new Sort([
            'attributes' => [
                'department' => [
                    'label' => 'Región',
                ],
                'province'=>[
                    'label' => 'Total de equipos finalizados',
                ],
                'district'=>[
                    'label' => 'Total integrantes de equipos finalizados',
                ],
                'latitude'=>[
                    'label' => 'Total de equipos no finalizados',
                ],
                'longitud'=>[
                    'label' => 'Total integrantes de equipos no finalizados',
                ],
            ],
        ]);
        
        $model = new Equipo();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('equipo-descargar', [
            'model' => $model,
            'sort' => $sort,
        ]);
    }
    
    public function actionForo_descargar($region=null)
    {
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
                
        return $this->render('foro_descargar', [
            'forospublicos' => $forospublicos,
            'foroparticipacion'=>$foroparticipacion
        ]);
    }
    
    public function actionProyecto()
    {
        $this->layout='administrador';
        
        $sort = new Sort([
            'attributes' => [
                /*'department' => [
                    'label' => 'Región',
                ],*/
            ],
        ]);
        
        $model = new Proyecto();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('proyecto', [
            'model' => $model,
            'sort' => $sort,
        ]);
    }
    
    public function actionProyectoDescargar($region=null)
    {
        if($region)
        {
            $proyectos=Proyecto::find()->select(['
                    proyecto.id,
                    proyecto.asunto_id,
                    proyecto.titulo, 
                    COUNT( i.estudiante_id ) AS total_integrantes,
                    IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and proyecto.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                    IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=proyecto.asunto_id and estudiante.grado!=6 and proyecto.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                    IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.proyecto_id = proyecto.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") =1, 1, 0 ) AS video_check,
                    IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = proyecto.id AND TRIM( reflexion.p1 ) IS NOT NULL and TRIM( reflexion.p1 )!="" AND TRIM( reflexion.p2 ) IS NOT NULL and TRIM( reflexion.p2 )!="" AND TRIM( reflexion.p3 ) IS NOT NULL and TRIM( reflexion.p3 )!="") =1, 1, 0 ) AS reflexion_check,
                    IF(trim(proyecto.proyecto_archivo)!="",1,0) as archivo_proyecto_check,
                    IF(e.etapa=1,1,0) as proyecto_finalizado
                  '])
            ->innerJoin('equipo e','e.id = proyecto.equipo_id')
            ->innerJoin('integrante i','i.equipo_id = e.id')
            ->innerJoin('estudiante es','es.id=i.estudiante_id')
            ->innerJoin('institucion ins','ins.id=es.institucion_id')
            ->innerJoin('ubigeo u','u.district_id=ins.ubigeo_id')
            ->where('u.department_id=:department_id',[':department_id'=>$region])
            ->groupBy('proyecto.id,proyecto.titulo')
            ->all();
        }
        else{
            $proyectos=Proyecto::find()->select(['
                    proyecto.id,
                    proyecto.asunto_id,
                    proyecto.titulo, 
                    COUNT( i.estudiante_id ) AS total_integrantes,
                    IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and proyecto.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                    IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=proyecto.asunto_id and estudiante.grado!=6 and proyecto.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                    IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.proyecto_id = proyecto.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") =1, 1, 0 ) AS video_check,
                    IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = proyecto.id AND TRIM( reflexion.p1 ) IS NOT NULL and TRIM( reflexion.p1 )!="" AND TRIM( reflexion.p2 ) IS NOT NULL and TRIM( reflexion.p2 )!="" AND TRIM( reflexion.p3 ) IS NOT NULL and TRIM( reflexion.p3 )!="") =1, 1, 0 ) AS reflexion_check,
                    IF(trim(proyecto.proyecto_archivo)!="",1,0) as archivo_proyecto_check,
                    IF(e.etapa=1,1,0) as proyecto_finalizado
                  '])
            ->innerJoin('equipo e','e.id = proyecto.equipo_id')
            ->innerJoin('integrante i','i.equipo_id = e.id')
            ->innerJoin('estudiante es','es.id=i.estudiante_id')
            ->innerJoin('institucion ins','ins.id=es.institucion_id')
            ->innerJoin('ubigeo u','u.district_id=ins.ubigeo_id')
            ->groupBy('proyecto.id,proyecto.titulo')
            ->all();
        }
        return $this->render('proyecto-descargar', [
            'proyectos' => $proyectos
        ]);
    }
}
