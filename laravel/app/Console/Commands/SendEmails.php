<?php

namespace App\Console\Commands;

use App\Console\Commands\BaseCommand;
use App\Services\Tool\MailService;
use App\Services\Tool\LogService;
class SendEmails extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';
    public $oMailService;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每分钟运行一次，处理队列中待发送的邮件';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->oMailService = MailService::instance();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        LogService::instance()->setLogger('command/mq_email_process');

        parent::getAllparams();

        $result = $this->oMailService->processMailWithMQ();

//        if ($result) {
//            LogService::instance()->setLog('debug','done');
//        } else {
//            LogService::instance()->setLog('error','邮件发送故障');
//        }
    }
}
