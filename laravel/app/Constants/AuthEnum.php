<?php
/**
 * @author ciogao@gmail.com
 * Date: 15-1-27 上午10:18
 */
namespace App\Constants;
class AuthEnum {
    /**
     * 权限枚举
     */
      const VIEW_TASK_TPL    = 'viewTaskTpl';//查看测试任务
      const MODIFY_TASK_TPL  = 'modifyTaskTpl';//修改测试任务

      const VIEW_TEST_CASE    = 'viewTestCase';//查看测试任务
      const MODIFY_TEST_CASE  = 'modifyTestCase';//修改测试任务

      const VIEW_TEST_SCENE   = 'viewTestScene';//查看测试场景
      const MODIFY_TEST_SCENE = 'modifyTestScene';//修改测试场景

      const VIEW_DATA_STORE   = 'viewDataStore';//查看数据仓库
      const MODIFY_DATA_STORE = 'modifyDataStore';//修改数据仓库

      const VIEW_SYSTEM    = 'viewUserList';//查看用户列表
      const MODIFY_SYSTEM  = 'modifySystem';//用户相关操作

      public static $roles = array(
           //管理员权限
           UserEnum::USER_ROLE_ADMIN    => array(
               self::VIEW_TASK_TPL,
               self::VIEW_TEST_CASE,
               self::VIEW_TEST_SCENE,
               self::VIEW_DATA_STORE,
               self::VIEW_SYSTEM,

               self::MODIFY_TASK_TPL,
               self::MODIFY_TEST_CASE,
               self::MODIFY_TEST_SCENE,
               self::MODIFY_DATA_STORE,
               self::MODIFY_SYSTEM,
           ),
           //高级用户权限
           UserEnum::USER_ROLE_ADVANCED => array(
               self::VIEW_TASK_TPL,
               self::VIEW_TEST_CASE,
               self::VIEW_TEST_SCENE,
               self::VIEW_DATA_STORE,
               self::VIEW_SYSTEM,

               self::MODIFY_TASK_TPL,
               self::MODIFY_TEST_CASE,
               self::MODIFY_TEST_SCENE,
               self::MODIFY_DATA_STORE,

           ),
           //只读用户权限
           UserEnum::USER_ROLE_READONLY => array(
               self::VIEW_TASK_TPL,
               self::VIEW_TEST_CASE,
               self::VIEW_TEST_SCENE,
               self::VIEW_DATA_STORE,
               self::VIEW_SYSTEM,
           )
      );
} 