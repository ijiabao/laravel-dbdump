<?php
/**
 * Created by PhpStorm.
 * User: iJiabao
 * Date: 2018/10/15
 * Time: 15:33
 */

namespace iJiabao\DbDump;

use Illuminate\Foundation\Application;

/**
 * Class DbDump
 * @package iJiabao\DbDump
 *
 * 使用 mysqldump, mysql 命令执行导出导入操作
 * 如果权限不足,可使用高权限 Cli + 任务队列执行
 */
class DbDump
{

    /** @var Application */
    protected $app;
    protected $cfg;

    protected $mysql_bin = 'mysql';
    protected $mysql_dump_bin = 'mysqldump';
    protected $save_dir;
    protected $save_file;

    /**
     * DbDump constructor.
     * @param Application $app
     */
    public function __construct($app)
    {

        $this->app = $app;

        /** @var \Illuminate\Config\Repository $cfg */
        $cfg = $app['config'];

        $bindir = $cfg->get('dbdump.mysql_bin_dir');
        $focus_bindir = $cfg->get('dbdump.cli_mysql_bin_dir');

        // Running in CLI.
        if($app->runningInConsole() && $focus_bindir){
            $bindir = $focus_bindir;
        }

        if($bindir){
            $bindir = realpath($bindir);
        }
        //$sep = DIRECTORY_SEPARATOR;

        // 可能是linux子系统,调用win32程序 /mnt/d/foo/bar/mysql/bin/mysql.exe
        // 则, mysql环境可能为win32, 终端(CLI)环境为 linux bash, 识别为非 Windows
        if ($bindir){
            $this->mysql_bin = "{$bindir}/mysql";
            $this->mysql_dump_bin ="{$bindir}/mysqldump";
            if(file_exists($this->mysql_bin.'.exe')){
                $this->mysql_bin .= '.exe';
                $this->mysql_dump_bin .= '.exe';
            }
        }
        else if(DIRECTORY_SEPARATOR == '\\'){
            // 设置了环境变量
            $this->mysql_bin .= '.exe';
            $this->mysql_dump_bin .= '.exe';
        }

        $this->save_dir = $cfg->get('dbdump.save_dir', resource_path('dbdump'));

        $this->save_file = $this->save_dir.'/migrate.sql';
    }

    /**
     * @param $bin
     * @return string
     */
    protected function checkMysqlBin($bin)
    {
        @exec("{$bin} -V", $output, $ret);
        return (0 === $ret) ? $bin : '';
    }

    /**
     * @return mixed
     */
    protected function getConnConfig()
    {
        return \DB::connection()->getConfig();
    }

    /**
     * @param $file
     * @param array $tables
     * @return bool
     */
    public function export($file = null, $tables = [])
    {
        $bin = $this->checkMysqlBin($this->mysql_dump_bin);
        if(!$bin){
            return false;
        }

        $cfg = $this->getConnConfig();
        $cmd = "{$bin} -u{$cfg['username']} -p{$cfg['password']} {$cfg['database']}";

        if($tables){
            $tables = trim(implode($tables, " "));
            $cmd .= " --tables {$tables}";
        }


        $outfile = $file ?: $this->save_file;
        $dir = dirname($outfile);
        if(!is_dir($dir)){
            @mkdir($dir, 0755, true);
        }

        $cmd .= " > {$outfile}";

        try {
            exec($cmd, $output, $ret);
        } catch(\Exception $e){
            return false;
        }

        // dump($cmd, $output);
        return ($ret === 0);
    }


    /**
     * @param null $file
     * @return bool
     */
    public function import($file = null)
    {
        $srcfile = $file ?: $this->save_file;
        if(!file_exists($srcfile)){
            return false;
        }
        $bin = $this->checkMysqlBin($this->mysql_bin);
        if(!$bin){
            return false;
        }

        $cfg = $this->getConnConfig();
        $cmd = "{$bin} -u{$cfg['username']} -p{$cfg['password']} {$cfg['database']}";
        $cmd .= " < {$srcfile}";

        try{
            exec($cmd, $output, $ret);
        } catch(\Exception $e){
            return false;
        }
        return ($ret === 0);

    }
}