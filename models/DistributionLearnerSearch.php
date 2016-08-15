<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DistributionLearner;

/**
 * DistributionLearnerSearch represents the model behind the search form about `app\models\DistributionLearner`.
 */
class DistributionLearnerSearch extends DistributionLearner
{
    public $mesechtaDafCount;
    public $mesechtaEnglishName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mesechtaDafCount'], 'integer'],
            [['mesechtaEnglishName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($profileid, $params)
    {
        $query = DistributionLearner::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
	
	$dataProvider->setSort([
        	'attributes' => [
            		'mesechtaEnglishName' => [
                		'asc' => ['mesechtos.nameenglish' => SORT_ASC],
                		'desc' => ['mesechtos.nameenglish' => SORT_DESC],
                		'label' => 'Mesechta'
            		],
			'mesechtaDafCount' => [
                		'asc' => ['mesechtos.dafcount' => SORT_ASC],
                		'desc' => ['mesechtos.dafcount' => SORT_DESC],
                		'label' => 'Daf Count'
            		]
		]
    	]);

	$query->joinWith(['user']);

        if (!($this->load($params) && $this->validate())) {
		$query->joinWith(['mesechta']);
        	return $dataProvider;
        }

	$query->joinWith(['mesechta' => function ($q) {
		$q->where('mesechtos.nameenglish LIKE "%' . $this->mesechtaEnglishName . '%" AND mesechtos.dafcount = ' . $this->mesechtaDafCount);
	}]);


        $query->andFilterWhere(['distributionprofileid' => $profileid]);

        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'creatoruserid' => $this->creatoruserid,
            'mesechtaid' => $this->mesechtaid,
        ]);

        return $dataProvider;
    }
}
