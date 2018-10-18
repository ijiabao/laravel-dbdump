<?php
/**
 * Created by PhpStorm.
 * User: iJiabao
 * Date: 2018/10/15
 * Time: 15:12
 */
return [
    // mysql | mysqldump 可执行文件目录
    // 一般情况,把上述目录添加到环境变量 PATH 中即可, 无需设置.
    'mysql_bin_dir' => env('MYSQL_BIN_DIR', ''),

    // 如果cli环境与web环境不一致,可设置cli下的mysql_bin目录
    // 方便 Linux子系统 用户 (终端环境为bash)
    'cli_mysql_bin_dir'=> env('CLI_MYSQL_BIN_DIR', ''),

    // 导入导出的 *.sql 目录
    'save_dir' => resource_path('dbdump'),
];