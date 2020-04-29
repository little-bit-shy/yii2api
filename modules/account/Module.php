<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2019/9/5
 * Time: 14:48
 */

namespace account;

use Yii;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        // 从config.php加载配置来初始化模块
        $config = require(__DIR__ . '/config/config.php');
        $components = $config['components'];
        $params = $config['params'];
        // 重新配置相关组件
        Yii::$app->setComponents($components);
        Yii::$app->params = $params;
    }
}