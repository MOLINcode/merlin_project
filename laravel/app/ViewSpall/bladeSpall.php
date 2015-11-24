<?php
class bladeSpall {
    /**
     * 生成面包屑导航
     * @param       $iconClass 图标的类
     * @param array $process 显示的名称list
     * @param array  $createName  array('名称'，'')创建的名称，如果有则显示，没有则不显示
     * @return string
     */
    public static function showBreadCrumb($iconClass, $process = array(),  $createName = NULL){

        return View::make('common.main_title')->with(
            array(
                'iconClass'=>$iconClass,
                'process'=>$process,
                'createName'=>$createName
            ))->render();
    }

}