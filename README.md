# laravel-dbdump
* 用于数据库备份/同步
* 使用php artisan命令, 应用于开发期版本控制时,表结构经常变动或经常同步数据库信息.
* 核心使用mysql/mysqldump命令进行导入/导出
* 基于laravel5.5开发(php7),注意版本



### 安装配置

* 默认使用系统mysql/mysqldump命令进行导入和导出, 请将mysql/bin目录添加到环境变量PATH
* 或者在.env 下添加 MYSQL_BIN_DIR=some/path

```bash
# 安装
composer require ijiabao/laravel-dbdump
# 发布配置
php artisan vendor publish
```



### 版本控制,导入导出

> 同步代码,提交之前,导出数据库信息, 注意将migrate.sql纳入版本控制
>
> 更新代码时,执行导入命令即可同步数据库信息

```bash
# 导出, 默认保存在 resource/dbdump/migrate.sql
php artisan db:dump export

# 导入
php artisan db:dump import
```



### 程序中使用

```php
// 导出
$action = \DbDump::export($full_file);
// 导入
$action = \DbDump::import($full_file);
```

