<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-10-15
 * Time: 下午6:26
 * 使用方法：
 * php artisan command:ClearDB --env=local --DBCommand=clearTableData //清除表中的数据，但不删除表
 * php artisan command:ClearDB --env=local --DBCommand=dropTable //删除表
 *
 */
use Symfony\Component\Console\Input\InputOption;
use DB;
class ClearDBCommand extends BaseCommand{
    /**
     * 参数名称
     */
    const CLEAR_TABLE_DATA = 'clearTableData';
    const DROP_TABLE = 'dropTable';

    /**
     * @var string
     */
    protected $name = 'command:ClearDB';

    /**
     * @var string
     */
    protected $description = '清空数据库中部分的表数据';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 注册Command的选项
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('DBCommand', NULL, InputOption::VALUE_OPTIONAL, '切换不同的Command服务', NULL),
        );
    }


    /**
     * Execute the console command.
     * @todo 运行时log
     * @return mixed
     */
    public function fire()
    {
        $DBCommand = $this->option('DBCommand');

        switch($DBCommand){
            case self::CLEAR_TABLE_DATA :
                $this->clearTableData();
                break;
            case self::DROP_TABLE :
                $this->dropTable();
                break;
            default:
                echo "没有做任何操作！\n";
                return false;
        }

    }

    /**
     * 清除表数据
     */
    private function clearTableData(){
        $table_arr = array();
        //不删除表数据的白名单
        $no_clear_tables = array(
            'account_info',
            'company_info',
            'group_info',
            'relationship_group_user',
            'relationship_roles_user',
            'roles_info',
            'user_info',
            'user_personal_settings',
            'user_register'
        );

        $results = DB::select('show tables');
        foreach($results as $tableInfo){
            if(isset($tableInfo->Tables_in_db_cloudtesting)) {
                $table = $tableInfo->Tables_in_db_cloudtesting;
                array_push($table_arr,$table);
            }else{
                dd("键值“Tables_in_db_cloudtesting”不存在\n");
            }
        }

        DB::beginTransaction();
        foreach($table_arr as $table){
            if(in_array($table,$no_clear_tables)) continue;
            try{
                DB::statement('truncate '.$table);
            }catch (Exception $e){
                echo "清除表操作失败!\n";
                DB::rollback();
                exit();
            }
        }
        DB::commit();

        echo "清除表操作成功!\n";
    }

    /**
     * 删除表
     */
    private function dropTable(){
        $table_arr = array();
        //不删除的表
        $no_clear_tables = array(
            'account_info',
            'admin_info',
            'company_info',
            'dim_app',
            'dim_host',
            'es_mapping',
            'group_info',
            'help_article',
            'help_cat',
            'ip_location',
            'migrations',
            'new_plugin_of_host',
            'plugin_bank',
            'plugin_updated_history_0',
            'plugin_updated_history_1',
            'plugin_updated_history_2',
            'plugin_updated_history_3',
            'plugin_updated_history_4',
            'plugin_updated_history_5',
            'plugin_updated_history_6',
            'plugin_updated_history_7',
            'plugin_updated_history_8',
            'plugin_updated_history_9',
            'relationship_app_host',
            'relationship_app_sdk',
            'relationship_group_user',
            'relationship_roles_user',
            'relationship_service_host',
            'relationship_team_group_user',
            'roles_info',
            'service_scheduler_config_extvalue_0',
            'service_scheduler_config_extvalue_1',
            'service_scheduler_config_extvalue_10',
            'service_scheduler_config_extvalue_11',
            'service_scheduler_config_extvalue_12',
            'service_scheduler_config_extvalue_13',
            'service_scheduler_config_extvalue_14',
            'service_scheduler_config_extvalue_15',
            'service_scheduler_config_extvalue_16',
            'service_scheduler_config_extvalue_17',
            'service_scheduler_config_extvalue_18',
            'service_scheduler_config_extvalue_19',
            'service_scheduler_config_extvalue_2',
            'service_scheduler_config_extvalue_3',
            'service_scheduler_config_extvalue_4',
            'service_scheduler_config_extvalue_5',
            'service_scheduler_config_extvalue_6',
            'service_scheduler_config_extvalue_7',
            'service_scheduler_config_extvalue_8',
            'service_scheduler_config_extvalue_9',
            'service_scheduler_config_keys',
            'smartAgent_heartbeat',
            'user_info',
            'user_personal_settings',
            'user_register',
        );

        $results = DB::select('show tables');
        foreach($results as $tableInfo){
            if(isset($tableInfo->Tables_in_db_toushibao_main)) {
                $table = $tableInfo->Tables_in_db_toushibao_main;
                array_push($table_arr,$table);
            }else{
                dd("键值“Tables_in_db_toushibao_main”不存在\n");
            }
        }
        //$del_table = array_diff($table_arr,$no_clear_tables);
        //dd(implode(',',$del_table));
        DB::beginTransaction();
        foreach($table_arr as $table){
            if(in_array($table,$no_clear_tables)) continue;
            try{
                DB::statement('drop table '.$table);
            }catch (Exception $e){
                echo "删除表操作失败!\n";
                DB::rollback();
                exit();
            }
        }
        DB::commit();

        echo "删除表操作成功!\n";
    }

} 