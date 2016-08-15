<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistributionLearnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mesechtos Chooser';
$this->params['breadcrumbs'][] = ['label' => 'Chalukah Profiles', 'url' => (Yii::$app->user->isGuest ? ['list'] : ['profiles'])];
$this->params['breadcrumbs'][] = $profile->header;
?>
<div class="distribution-learner-index">

    <h1><?= $profile->header ?></h1>
    <h3><?= $profile->description ?></h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
		'class' => 'yii\grid\ActionColumn',
		'header' => 'Learner',
		'buttons' => 
		[
		    'select' => function ($url, $model, $key) {
			if(!$model->userid)
	        		return Html::a("Select", $url, ["title" => Yii::t("app", "Select"),]);
			else
				return $model->userFullName;
    		    },
		],
		'template' => '{select}',
		
	    ],
            'mesechtaEnglishName',
	    'mesechtaHebrewName',
            'mesechtaDafCount',
            'mesechtaWordCount',
            'mesechtaLetterCount',
            [
		'visible' => false,//!Yii::$app->user->isGuest,
		'class' => 'yii\grid\ActionColumn',
		'buttons' => 
		[
		    'select' => function ($url, $model, $key) {
			if(!$model->userid)
        		return Html::a('<span class="glyphicon glyphicon-chevron-right"></span>', $url, [
                            'title' => Yii::t('app', 'Select'),
            		]);
    		    },
		],
		'template' => '{select}',
		
	    ],
        ],
    ]); ?>

</div>
