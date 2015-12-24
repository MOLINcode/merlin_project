/**
 * Created by admin-chen on 15-1-22.
 */
var version = '20150508';
seajs.config({
    //基础路径
    base: '/js/',
    base: '/js/',
    // 别名配置
    alias: {
        //第三方common公共的js
        jquery: 'common/jquery/jquery.min.js',
        jqueryCookie: 'common/jquery/jquery.cookie.js',
        jqueryBounceBox: 'common/jquery/jquery-ui/jquery.bouncebox.1.0.js',
        echarts:'common/echarts/echarts-plain.js',
        jtopo:'common/jtopo-0.4.8-min.js',

		
		//common公共的js
        jqueryTopoPlugin:'common/jquery/jquery.jtopo.js',
        jqueryTsbPlugin:'common/jquery/jquery-tsb-plugins.js',
        jqueryCodetreePlugin:'common/jquery/jquery-codetree.js',
        jqueryZclip:'common/jquery/zclip/jquery.zclip.min.js',
        echartsPlugin:'common/echarts/echarts-plugin.js',
        echartsDriverDataMixed:'common/echarts/driver/data/mixed.js',
        echartsDriverDataPieRing:'common/echarts/driver/data/pieRing.js',
        echartsDriverDataGauge:'common/echarts/driver/data/gauge.js',
        echartsDriverDataLine:'common/echarts/driver/data/line.js',
        echartsDriverDataScatter:'common/echarts/driver/data/scatter.js',
        echartsDriverDataNewLine:'common/echarts/driver/data/new_line.js',
        echartsDriverDataMap:'common/echarts/driver/data/map.js',
        echartsDriverDataPie:'common/echarts/driver/data/pie.js',
        echartsDriverDataRadar:'common/echarts/driver/data/radar.js',
        echartsDriverThemeDefaultTsb:'common/echarts/driver/theme/default-tsb.js',
        echartsDriverDataMiniRing:"common/echarts/driver/data/miniring",
        echartsDriverThemeMiniRing:"common/echarts/driver/theme/miniring",

        commonConf:'config.js',
        event_extension:'common/event-extension.js',
        jqueryDataTables:'common/jquery.dataTables.min.js',
        jqueryValidate:'common/jquery.validate.min.js',
        jqueryValidateAddMethod:'common/additional-methods.js',
        TSB:'common/main.js',
        report_chart:'common/report_chart.js',
        team:'common/team.js',
        T:'common/TSB.js',
        tsb_map:'common/tsb_map.js',
        config:'common/config.js',
        areaNameMapping:'common/areaNameMapping.js',

        //用户管理
        user_register:'user/user_register.js',
        user_signin:'user/user_signin.js',

        //表单异步文件提交
        ajaxFormSubmit:'common/jquery/jquery.form.js',

        //后台分类管理
        'category':'admin/category.js',
        //后台文章管理
        'article':'admin/article.js',
        'iUploader':'common/plugin/iUploader.js',
    },
    // 预加载项
    preload: [
        "jquery"
    ],
    // 调试模式
    //debug: true,
    // 映射配置
    map: [
        [/^(.*\.(?:css|js))(?:.*)$/i, '$1?version=' + version]
    ],
    // 文件编码
    charset: 'utf-8'
});
