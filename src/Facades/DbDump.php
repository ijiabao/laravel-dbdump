<?php
/**
 * Created by PhpStorm.
 * User: iJiabao
 * Date: 2018/10/15
 * Time: 17:09
 */

namespace iJiabao\DbDump\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class DbDump
 * @package iJiabao\DbDump\Facades
 * @mixin \iJiabao\DbDump\DbDump
 */
class DbDump extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'ijiabao.dbdump';
    }
}