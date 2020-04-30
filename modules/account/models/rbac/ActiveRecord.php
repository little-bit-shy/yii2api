<?php

namespace account\models\rbac;

use Yii;

class ActiveRecord extends \app\models\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('rbacDb');
    }
}
