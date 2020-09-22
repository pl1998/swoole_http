

```shell script
//启动文件
php start.php
```

#### 接口地址


`xxxx/index.php`

##### 请求格式

`post`

##### 参数

| 参数   | 是否必选 | 备注      | 限制 | 新增 |
| ------| -------- | --------- | ---- | ---- |
| email|   必须   | 收件人邮箱   |      |      |
| time |   必须   | 发送间隔时间 时间戳 例如 一个小时 3600  |      |      |
| content|   必须   | 错误内容   |      |      |
| api_url|   必须   | 发送错误的接口名称  |      |      |



```PHP


$api = ['email', 'time', 'content','api_url'];


```
