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
    
    
    public function actionEquipo()
    {
        $this->layout='administrador';
        
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
        
        $model = new Equipo();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('equipo', [
            'model' => $model,
            'sort' => $sort,
        ]);
    }
}
