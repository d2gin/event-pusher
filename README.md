# event-pusher

#### 介绍
事件发布器，是`icy8/socket.io`的辅助工具。其实这是一个对`curl`的封装，只是针对socket.io的事件服务器定制了部分固定的url。

#### 软件架构
php>=7.0

#### 安装教程

```shell
composer require icy8/event-pusher
```

#### 使用说明

```php
<?php
$pusher = new Pusher("http://127.0.0.1:9002");
// 通过channel发送给客户端
$pusher->trigger('event_name', 'channel', 'data');
// 广播
$pusher->broadcast('event_name', 'data');
```