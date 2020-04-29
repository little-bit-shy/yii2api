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
    'the user is freeze' => '该用户已被冻结|10014',
    'the role could not be added' => '无法添加该角色|10015',
    'this data cannot be deleted' => '该数据无法删除|10016',
    'there must be campus id' => '校区id必须存在|10017',
    'data exception' => '数据异常|10018',
    'there must be app id' => '应用id必须存在|10019',
    'the current employee has been added' => '当前员工已经添加过了|10020',
    'the current campus is out of service' => '当前校区为停用状态|10021',
    'verification code sent too often, please send again later' => '验证码发送太频繁，请稍后再发|10022',
    'the current phone number has been registered' => '当前手机号已被注册|10023',
    'verification code error' => '验证码错误|10024',
    'the current phone number has been added' => '当前手机号已被添加过了|10025',
    'the current app is out of service' => '当前应用为停用状态|10026',
    'the current user does not have permission to perform the operation' => '当前用户没有权限执行操作|10027',
    'current users have not become campus employees' => '当前用户还未成为校区员工|10028',
    'current employee not enabled' => '当前员工未启用|10029',
    'the current data cannot be modified' => '当前数据不允许修改|10030',
    'the current data cannot be add' => '当前数据不允许添加|10031',
    'the course has been added' => '课程已经添加过了|10032',
    'the classroom has been added' => '教室已经添加过了|10033',
    'current students have purchased the course' => '当前学生已经购买过该课程了|10034',
    'the course not exist' => '课程不存在|10035',
    'the classroom not exist' => '教室不存在|10036',
    'the teacher not exist' => '教师不存在|10037',
    'rate limit exceeded' => '请求频率过快，请稍后重试|10038',
    'your request was made with invalid credentials' => '您的请求使用了无效的凭据|10039',
    'the student not exist' => '学生不存在|10040',
    'students did not purchase the course' => '学生没有购买该课程|10041',
    'the current phone number has been not registered' => '当前手机号未注册|10042',
    'the school district name has been used' => '校区名称已经被使用了|10043',
    'the class is not exist' => '该班课数据不存在|10044',
    'the class students has been added' => '该学生已经添加过了|10045',
    'the class students not exist' => '该学生的班课过滤数据不存在|10046',
    'the employees scheduling ({0}) has been added' => '教师（{0}）当前时间段的排课存在冲突|10047',
    'the students ({0}) scheduling has been added' => '学生（{0}）当前时间段的排课存在冲突|10048',
    'end time must be greater than start time' => '结束时间必须大于开始时间|10049',
    'end time must be ten minutes longer than start time' => '结束时间必须大于开始时间10分钟|10050',
    'the teacher does not belong to the class' => '该教师不属于该班课|10051',
    'the student do not belong to the class' => '该学生不属于该班课|10052',
    'the class exceeds the number limit' => '该班课超出人数限制|10053',
    'there can only be one student in this class' => '该班课类型只能有1位学生|10054',
    'the class is over' => '该班课已经完结|10055',
    '({0}) the course was not purchased' => '（{0}）没有购买该课程|10056',
    'the student course was not purchased' => '所选学生没有购买该课程|10057',
    'the course does not belong to the class' => '该教师不属于该班课|10058',
    'start time and end time cannot exceed ({0}) days' => '开始时间和结束时间不能超过({0})天|10059',
    'the class scheduling is not exist' => '该班课课程数据不存在|10060',
    'the class has already completed the course' => '该班级已有结课课程|10061',
    'the students ({0}) no sign in, no class closing' => '学生({0})没有签到，不能结课|10062',
    'the student class course has not exist' => '该学生的班课课节数据不存在|10063',
    'the student does not belong to the class section' => '该学生不属于该课节|10064',
    'the class scheduling is over' => '该班课课程已完结|10065',
    'the class scheduling students_id has not exist' => '该学生排课数据不存在|10066',
    'the class is not closed, unable to operate' => '该班课未结课，不能操作|10067',
    'transferred students cannot have signed in' => '调课的学生不能已签到|10068',
    'the student exists in the class and does not need to be transferred' => '该学生存在于该班课课程，无需调课|10069',
    'adjusted courses cannot be the same' => '调整的课程不能是同一个|10070',
    'refunded hours are greater than the rest' => '退款的课时不能大于剩余的课时|10071',
    'the refund amount cannot be greater than the remaining amount' => '退款的金额不能大于剩余的金额|10072',
    'the student\'s check-in time is not within the specified time' => '该学生的签到时间不在规定的时间内|10073',
    'the deducted class hours cannot be greater than the remaining class hours' => '扣除的课时不能大于剩余的课时|10074',
    'follow up record of follow-up description can only be edited' => '跟进描述的跟进记录才能编辑|10075',
    'the follow-up record does not exist' => '该跟进记录不存在|10076',
    'the resources course not exist' => '该学生购买的该课程不存在|10077',
    'class time cannot be less than the current time' => '课节时间不能小于当前时间|10078',
    'can\'t schedule ({0}) days' => '无法排({0})天后的课程|10079',
    'last week\'s date cannot be greater than this week\'s date' => '上周日期不能大于这周的日期|10080',
    'weekly time date cannot be greater than monthly time date' => '周时间日期不能大于月时间日期|10081',
    'the time of the day must be within this week' => '当日时间必须在这周内|10082',
    'date time format error' => '日期时间格式错误|10083',
    'time format error' => '时间格式错误|10084',
    'classroom data format error' => '教室数据格式错误|10085',
    'employees data format error' => '教师数据格式错误|10086',
    'last end time must be greater than last start time' => '上周结束时间必须大于上周开始时间|10087',
    'the time of the day must be within the month' => '当日时间必须在当月内|10088',
    'sms gateway exception' => '短信网关异常|10089',
    'the campus has expired, please renew it' => '校区已过期，请续费|10090',
    'wechat signature verification failed' => '微信签名验证失败|10091',
    'the wechat payment call failed' => '微信支付调用失败|10092',
    'the order is not in the state to be paid' => '订单不是待支付状态|10093',
    'this order is not an unpaid order and cannot be modified' => '该订单不是未支付订单，无法修改|10094',
    'no more than ({0}) pictures can be uploaded' => '上传的图片不能超过({0})张|10095',
    'images data format error' => '图片数据格式错误|10096',
    'the app cat not exist' => '应用分类不存在|10097',
    'the expiration time of modification cannot be less than the last expiration time' => '修改的过期时间不能低于上次的过期时间|10098',
    'feedback data from other users cannot be deleted' => '不能删除其他用户的反馈数据|10099',
]
```
