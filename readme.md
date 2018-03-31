## 项目概述

* 产品名称：laravel5.5-chatroom
* 项目代码：laravel5.5-chatroom
* 演示地址：http://dev10.shareg.cn

laravel5.5-chatroom是一个简洁的聊天室应用，使用laravel5.5编写的聊天室api

## 功能如下
- 用户认证 —— 注册、登录;
- 聊天室发送文字和图片消息
- 接入图灵机器人，可自定义开关

## 运行环境要求

- Nginx 1.8+
- PHP 7.0+
- Mysql 5.7+

## 开发环境部署/安装

本项目代码使用php框架laravel5.5开发

### 基础安装

#### 1. 克隆源代码

克隆 `laravel-chatroom` 源代码到本地：

    > git clone https://github.com/zzDylan/laravel5.5-chatroom.git


#### 2. 安装扩展包依赖

	composer install

#### 3. 生成配置文件

```
cp .env.example .env
```

你可以根据情况修改 `.env` 文件里的内容，如数据库连接、缓存、邮件设置等：

```
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chatroom
DB_USERNAME=root
DB_PASSWORD=123456
```

#### 4. 生成数据表及生成测试数据

在网站根目录下运行以下命令

```shell
$ php artisan migrate
```

初始的用户和聊天室表已使用数据迁移生成


#### 5. 生成秘钥

```shell
php artisan key:generate
```

```shell
php artisan jwt:secret
```

