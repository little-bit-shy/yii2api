<?php
/**
 * 自定义错误响应
 * 有时你可能想自定义默认的错误响应格式。
 * 例如，你想一直使用HTTP状态码200，
 * 而不是依赖于使用不同的HTTP状态来表示不同的错误，
 * 并附上实际的HTTP状态代码为JSON结构的一部分的响应
 */

return [
    'class' => \yii\web\Response::className(),
    'on beforeSend' => function ($event) {
        /** @var \yii\web\Response $response */
        $response = $event->sender;
        $data = $response->data;
        if ($response->getIsEmpty() || is_string($data) || $data === null) {
            return;
        }
        // 处理code、message
        $exception = Yii::$app->getErrorHandler()->exception;
        if ($exception !== null) {
            $code = $data['code'];
            $message = $data['message'];
            // 数据重构
            $responseData = $response->data;
            if (strpos($message, '|')) {
                list($message, $code) = explode('|', $message);
                $responseData['code'] = (int)$code;
            }

            if (strpos($message, '=')) {
                list($key, $message) = explode('=', $message);
                $responseData['key'] = $key;
            }
            $responseData['message'] = str_replace('。','',$message);

            // 记录异常节点
            if(!$response->getIsSuccessful()){
                $responseData['line'] = $exception->getLine();
                $responseData['file'] = $exception->getFile();
            }
            $response->data = $responseData;
        }

        // 数据格式重构
        $response->data = [
            'success' => $response->getIsSuccessful(),
            'data' => $response->data,
        ];

        $log = [
            "result" => $response->data
        ];
        if ($response->getIsSuccessful()) {
            Yii::info(\yii\helpers\Json::encode(\yii\helpers\ArrayHelper::toArray($log)));
        } else {
            Yii::warning(\yii\helpers\Json::encode(\yii\helpers\ArrayHelper::toArray($log)));
        }

        // 放在后面，避免污染IsSuccessfulz
        $response->setStatusCode(\Codeception\Util\HttpCode::OK);
    }
];
