<?php

namespace App\Constants;
use App\Constants\MenuEnum;
use App\Constants\AuthEnum;
use Lang;
use Route;
class UserMenuEnum extends MenuEnum
{
    /**
     * 分组名称
     */
    const GROUP_CATEGORY  = 'category';     //用户中心
    const GROUP_ARTICLE   = 'article';     //用户中心

   /* const GROUP_TEST_CASE   = 'testCase';       //测试任务
    const GROUP_TASK_TPL    = 'taskTpl';        //测试模板
    const GROUP_TEST_SCENE  = 'testScene';      //测试场景
    const GROUP_TEST_DATA   = 'testData';       //数据仓库
    const GROUP_SYSTEM      = 'system';         //系统设置*/

    private static function TsbLeftMenus()
    {
        $TsbLeftMenus = array(
            array(
                self::LABEL => '分类管理',
                self::ICON => 'test',
                self::URL => '/admin/category',
//                self::AUTH => AuthEnum::VIEW_TASK_TPL,
                self::GROUP => self::GROUP_CATEGORY,

            ),
            array(
                self::LABEL => '文章管理',
                self::ICON => 'test',
                self::URL => '/admin/article',
//                self::AUTH => AuthEnum::VIEW_TEST_CASE,
                self::GROUP => self::GROUP_ARTICLE,

            ),
            /*array(
                self::LABEL => Lang::get('common.test_scene'),
                self::ICON => 'scene',
                self::URL => '/testScene/list',
                self::AUTH => AuthEnum::VIEW_TEST_SCENE,
                self::GROUP => self::GROUP_TEST_SCENE,


            ),
            array(
                self::LABEL => Lang::get('common.data_store'),
                self::ICON => 'storehouse',
                self::URL => '/dataStore/list',
                self::AUTH => AuthEnum::VIEW_DATA_STORE,
                self::GROUP => self::GROUP_TEST_DATA

            ),
            array(
                self::LABEL => Lang::get('common.system_config'),
                self::ICON => 'sys-set',
                self::URL => '/user/user_list',
                self::AUTH => AuthEnum::MODIFY_SYSTEM,
                self::GROUP => self::GROUP_SYSTEM,
            ),*/
        );
        return $TsbLeftMenus;
    }


    /**获取压测宝左侧菜单
     * @return array
     */
    public static function getLeftMenu()
    {
        $leftData = static::TsbLeftMenus();
        foreach ($leftData as $key=>&$menu) {
//            if (array_key_exists(self::AUTH, $menu) && !AuthService::Auth($menu[self::AUTH])) {
//                unset($leftData[$key]);
//                continue;
//            }
            $menu[self::ACTIVE] = false;
            if (array_key_exists(self::GROUP, $menu) && $menu[self::GROUP] == self::getCurrentActions('group')) {
                $menu[self::ACTIVE] = true;
            }
//            $menu[self::LABEL] = Lang::get($menu[self::LABEL]);
        }


        return $leftData;
    }

    /**
     * 将菜单转换成通用格式的菜单
     * @param array $menus  要转换的菜单
     * @param string $activeKey 哪个key使用active效果
     * @return array
     */
    public static function getMenus(array $menus, $activeKey = ''){
        foreach($menus as $key => &$menu){
            /*if ((array_key_exists(self::AUTH, $menu) && !AuthService::Auth($menu[self::AUTH])) || (array_key_exists('hide',$menu))) {
                unset($menus[$key]);
                continue;
            }*/
            $menu[self::ACTIVE] = false;
            if($key == $activeKey){
                $menu[self::ACTIVE] = true;
            }
            $menu[self::LABEL] = Lang::get($menu[self::LABEL]);
        }
        return $menus;
    }

    /**
     * 获取当前路由的action参数
     * @param null $name
     * @return null
     */
    private static function getCurrentActions($name = NULL)
    {
        $currentAction = Route::current()->getAction();
        if (!is_null($name)) {
            return array_key_exists($name, $currentAction) ? $currentAction[$name] : NULL;
        }
        return $currentAction;
    }

}