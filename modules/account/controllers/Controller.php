<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 控制器基类
 */

namespace account\controllers;

use \Yii;

/**
 * Yii 提供两个控制器基类来简化创建RESTful 操作的工作: yii\rest\Controller 和 yii\rest\ActiveController，
 * 两个类的差别是后者提供一系列将资源处理成Active Record 的操作。
 * 因此如果使用Active Record 内置的操作会比较方便，
 * 可考虑将控制器类继承yii\rest\ActiveController，
 * 它会让你用最少的代码完成强大的RESTful APIs.
 *
 * Class Controller
 * @package account\controllers
 */
class Controller extends \app\controllers\Controller
{
    /**
     * @apiDefine publicParam
     * @apiParam (params) {String} [access_token=aft21f21f129fg817fg317gv1]  用户令牌，登录后必填，拼接在链接后使用
     * @apiParam (params) {String} [fields=*]  字段显示控制，例如：*，获取数据可用，拼接在链接后使用
     * @apiParam (params) {String} [expand=*]  对象显示控制，例如：*，获取数据可用，拼接在链接后使用
     * @apiParam (params) {Int} [page=1]  页码，例如：1，列表数据可用，拼接在链接后使用
     * @apiParam (params) {Int} [per-page=20]  单页最大显示数，例如：20，列表数据可用，拼接在链接后使用
     */
}
