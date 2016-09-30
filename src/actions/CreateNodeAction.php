<?php

namespace voskobovich\tree\manager\actions;

use Yii;
use voskobovich\tree\manager\interfaces\TreeInterface;
use yii\db\ActiveRecord;
use yii\web\HttpException;

/**
 * Class CreateNodeAction
 * @package voskobovich\tree\manager\actions
 */
class CreateNodeAction extends BaseAction
{
    public $nameAttribute = 'name';
    /**
     * @return null
     * @throws HttpException
     */
    public function run()
    {
        /** @var TreeInterface|ActiveRecord $model */
        $model = new $this->modelClass;

        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params);

        if (!$model->validate()) {
            return $model;
        }

        $roots = $model::find()->roots()->all();

        if (isset($roots[0])) {
            //$name = Yii::$app->request->post('StructureAL[name]');
            print_r($params);
            //$model->name = $name;
            return $model->appendTo($roots[0])->save();
        } else {
            return $model->makeRoot()->save();
        }
    }
}