<?php

namespace iJiabao\DbDump\Console\Commands;

use iJiabao\DbDump\Facades\DbDump;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DbDumpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'db:dump';

    //
    protected $name = 'db:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import/export the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'with all tables'],
        ];
    }


    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['action', InputArgument::REQUIRED, 'must set: export export'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $action = $this->argument('action');
        if($action=='import'){
            DbDump::import();
        }
        else if($action=='export'){
            DbDump::export();
        }
    }
}
