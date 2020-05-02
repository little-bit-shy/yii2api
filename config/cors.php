<?php

/**
 * cors跨域配置
 */
return [
    'Origin' => ['http://127.0.0.1:8080'],
    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
    'Access-Control-Request-Headers' => ['*'],
    'Access-Control-Allow-Credentials' => true,
    'Access-Control-Max-Age' => 86400,
    'Access-Control-Expose-Headers' => [],
];

