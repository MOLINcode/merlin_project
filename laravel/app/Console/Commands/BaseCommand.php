<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-5-8 下午1:34
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BaseCommand extends Command
{
    /**
     * @var array
     */
    const DEBUG = 1; //等级debug
    const ERROR = 2; //等级error
    static public $levelInfo = array(
        self::DEBUG => 'debug',
        self::ERROR => 'error',
    );
    protected $aParams = array();

    protected $oService = NULL;

    public function __construct()
    {
        parent::__construct();
    }

    protected function getAllparams()
    {
        $this->aParams = $this->argument();
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(//     array('id', InputArgument::REQUIRED, '0'),
//            array('type', InputArgument::REQUIRED, '1'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('example', NULL, InputOption::VALUE_OPTIONAL, 'An example option.', NULL),
        );
    }

    /**
     * 输出命令符信息
     * @param     $outPutMsg
     * @param     $level
     * @param int $debug
     */
    static public function OutPutCommands($outPutMsg, $level, $debug = 0)
    {
        LogService::instance()->setLog(self::$levelInfo[$level], $outPutMsg);

        if ($debug == 1) {
            //echo self::$levelInfo[$level].'——'.$outPutMsg."\n";
        }
    }
}