<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-7-21 下午7:03
 */
namespace App\Constants;
class CacheKeyEnum
{
    //用户信息cache标签
    const USER_INFO_CACHE_TAG = 'user';
    //用户信息cookie
    const USER_INFO_COOKIE_KEY = '__USER_INFO_TICKET';

    /**
     * 测试场景相关的key 和 tag
     */
    const TEST_SCENE_TAG = 'test_scene';

    //生成存储测试场景脚本的key
    static function mkTestSceneKey($account_id,$scene_id){
        return 'testSceneKey_'.$account_id.'_'.$scene_id;
    }

    /**
     * 数据仓库相关的key 和 tag
     */
    const TEST_DATA_TAG = 'test_data';

    //生成存储测试场景脚本的key
    static function mkTestDataKey($account_id,$data_id){
        return 'testDataKey_'.$account_id.'_'.$data_id;
    }

}