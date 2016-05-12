<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use app\models\Voto;
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
                'only' => [],
                'rules' => [
                    [
                        'actions' => [],
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
    
    public function actionIndex_descargar($region=null)
    {
        return $this->render('index_descargar', [
            'region' => $region,
            'sort'=>$sort
        ]);
    }

}
