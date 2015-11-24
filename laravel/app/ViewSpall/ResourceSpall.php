<?php
namespace app\ViewSpall;
/**
 * @author Neeke.Gao
 * Date: 14-5-14 下午3:49
 */

class ResourceSpall
{
    static public function getCSS($key){
        $CSS = array(
            'commonCSS' => array(
                'common/bootstrap/bootstrap.min.css',
                'common/bootstrap/bootstrap-switch.min.css',
                'common/jquery-ui/jquery-ui.min.css',
                'common/bootstrap/bootstrap-datetimepicker.css',
                'common/font-awesome.min.css',
                'common/main.css',
                'common/slider.css',
                'common/switch.css',
                'common/user_center.css',
            ),
        );

        return $CSS[$key];
    }

    static public function getJS($key){
        $newJS = array(
            //公共JS
            'commonHeadJS' => array(
                'common/sea/sea.js',
                'common/sea/config.js',
                'common/jquery/jquery.min.js',
                //'common/jquery/jquery.form.js',
            ),
            'commonFooterJS' => array(
                'common/jquery/jquery-ui/jquery-ui.min.js',
                'common/bootstrap/bootstrap.min.js',
                'common/bootstrap/bootstrap-switch.min.js',
                'common/bootstrap/date/bootstrap-datetimepicker.js',
                'common/bootstrap/date/bootstrap-datetimepicker.zh-CN.js',
                "common/Lang/".(isset(UserService::getUserCache()->language) ? LangEnum::$lang[UserService::getUserCache()->language] : 'zh_cn').".js",
                'config.js',
            ),
            'AdminCommonJS' => array(
                'common/less-1.7.0.js',
                'common/sea/sea.js',
                'common/sea/config.js',
                'common/jquery/jquery.min.js',
                'common/jquery/jquery-ui/jquery-ui-1.10.4.custom.min.js',
                'common/bootstrap/bootstrap.min.js',
                'common/bootstrap/bootstrap-switch.min.js',
                'config.js',
            ),

            //ueditor js
            'ueditor' => array(
                'ueditor/ueditor.config.js',
                'ueditor/ueditor.all.min.js'
            ),


        );

        return $newJS[$key];
    }



    static private $version = NULL;
    static public function getResourceVersion()
    {
        if (is_null(self::$version)) {
            self::$version = Config::get('app.resource.version');
        }

        return self::$version;
    }

    /**
     *  导入CSS
     */
    static public function includeCSS($key){
        $cssArr = self::getCSS($key);
        foreach($cssArr as $v){
            echo '<link rel="stylesheet" type="text/css" href="/resource/css/'.$v.'?v='.ResourceSpall::getResourceVersion().'" />'."\n";
        }
    }

    /**
     *  导入JS
     */
    static public function includeJS($key){
        $cssArr = self::getJS($key);
        foreach($cssArr as $v){
            echo "<script type='text/javascript' src='/resource/js/".$v."?v=".ResourceSpall::getResourceVersion()."'></script>\n";
        }
    }

    /**
     *  导入php模板
     */
    static public function includeTpl($tplName){
        return $tplName;
    }
}