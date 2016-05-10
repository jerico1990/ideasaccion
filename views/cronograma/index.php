<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CronogramaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cronogramas';
?>
<div class="cronograma-index">

    <h1>Filtros</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'actividad_id',
            'fecha_inicio',
            'fecha_fin',
            'duracion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
