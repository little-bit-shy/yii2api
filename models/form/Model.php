<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace app\models\form;

use Yii;
use yii\web\Response;

class Model extends \yii\base\Model
{
    /**
     * rewrite
     * @param null $attribute
     * @return mixed|string
     */
    public function getFirstError($attribute = null)
    {
        if ($attribute === null) {
            $firstErrors = $this->getFirstErrors();
            $key = key($firstErrors);
            $value = $firstErrors[$key];
            if (YIi::$app->getResponse() instanceof Response &&
                Yii::$app->getResponse()->acceptMimeType == 'application/html') {
                return $value;
            }
            return $key . '=' . $value;
        }
        return parent::getFirstError($attribute);
    }
}