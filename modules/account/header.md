### 统一参数介绍：

#### success: 状态
true：接口调用成功
false: 接口调用失败

#### data.status: http状态码
200: OK。一切正常。  
201: 响应 POST 请求时成功创建一个资源。Location header 包含的URL指向新创建的资源。  
204: 该请求被成功处理，响应不包含正文内容 (类似 DELETE 请求)。  
304: 资源没有被修改。可以使用缓存的版本。  
400: 错误的请求。可能通过用户方面的多种原因引起的，例如在请求体内有无效的JSON 数据，无效的操作参数，等等。  
401: 验证失败。  
403: 已经经过身份验证的用户不允许访问指定的 API 末端。  
404: 所请求的资源不存在。  
405: 不被允许的方法。 请检查 Allow header 允许的HTTP方法。  
415: 不支持的媒体类型。 所请求的内容类型或版本号是无效的。  
422: 数据验证失败 (例如，响应一个 POST 请求)。 请检查响应体内详细的错误消息。  
429: 请求过多。 由于限速请求被拒绝。  
500: 内部服务器错误。 这可能是由于内部程序错误引起的。

#### data.message: 描述语句
返回接口请求描述

#### data.code: 详细状态码
```PHP
[
    'server internal error' => '当前网络不稳定，请稍后重试|10000',
    'not null' => '不能为空|10001',
    'the user does not exist' => '用户不存在|10002',
    'user password error' => '用户密码错误|10003',
    'permissions name error' => '权限名称不合法|10004',
    'rule name error' => '规则名称不合法|10005',
    'role or name error' => '角色或名称不合法|10006',
    'the data exist' => '数据已存在|10007',
    'the data not exist' => '数据不存在|10008',
    'rule error' => '规则错误|10009',
    'user old password error' => '用户旧密码错误|10010',
    'the user not exist' => '用户不存在|10011',
    'access token no exist' => '访问令牌异常|10012',
    'access token time out' => '访问令牌已过期|10013',
]
```
