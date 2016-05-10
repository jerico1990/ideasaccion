<?php

namespace app\controllers;

use Yii;
use app\models\Cronograma;
use app\models\CronogramaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CronogramaController implements the CRUD actions for Cronograma model.
 */
class CronogramaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cronograma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CronogramaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cronograma model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cronograma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cronograma();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cronograma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cronograma model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cronograma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cronograma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cronograma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCargatablacronograma($valor)
    {
        $dataTabla=[];
        $cronogramaArray=[];
        $cronogramas=Cronograma::find()
                                ->where('actividad_id=:actividad_id and estado=1',[':actividad_id'=>$valor])
                                ->all();
        
        $countcronogramas=Cronograma::find()
                                ->where('actividad_id=:actividad_id and estado=1',[':actividad_id'=>$valor])
                                ->count();
        array_push($dataTabla,$countcronogramas);
        foreach($cronogramas as $cronograma)
        {
            array_push($dataTabla,['id'=>$cronograma->id,'tarea'=>$cronograma->tarea,'responsable'=>$cronograma->responsable_id,'fecha_inicio'=>date("Y-m-d", strtotime($cronograma->fecha_inicio)),'fecha_fin'=>date("Y-m-d", strtotime($cronograma->fecha_fin))]);
        }
        
        //array_push($dataTabla,['cronograma'=>$cronogramaArray]);
        echo json_encode($dataTabla,JSON_UNESCAPED_UNICODE); 
    }
}
