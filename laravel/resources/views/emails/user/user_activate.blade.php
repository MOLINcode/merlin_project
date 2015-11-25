<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>压测宝邮件</title>
</head>
<body>
<div style="background:#f4f4f4; font-family:'微软雅黑'; padding:30px 0; margin:0;">
    <div style="width:900px; margin:0 auto; background:#fafafa;">
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="900px" style="font-family: '微软雅黑';font-size: 14px;color: #393737;">
            <tbody>
            <tr bgcolor="#3fcaa0" height="100">
                <td width="170" align="center"><img src="{{Config::get('domain.domainName')}}/resource/img/logo.png"></td>
                <td width="520" style="line-height:30px;" align="center">
                    <span style="font-size:20px; color:#fff;">欢迎使用压测宝，请完成账号激活</span><br/>
                <td width="180"></td>
            </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="860px" style="font-family: '微软雅黑';font-size: 14px;color: #393737;">
            <tbody>
            <tr height="20px"></tr>
            <tr>
                <td width="150" align="center" rowspan="2"><img src="{{Config::get('domain.domainName')}}/resource/img/edm/head_mail.png"></td>
                <td width="750" style="line-height:30px;font-family:'微软雅黑';font-size:16px;">
                    Hi，亲爱的<span style="font-weight: bold;">{{ $user_name }}</span>

                </td>
            </tr>
            <tr>
                <td style="font-size:14px;font-family:'微软雅黑'">我是压测宝客服Jon，您的压测宝试用申请已经成功通过审核了哦：</td>
            </tr>
            <tr style="height: 30px;"></tr>
            <tr>
                <td></td>
                <td height="30px" style="color: #000;">账号密码:<span style="color: red; font-weight: bold;">{{ $password }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td height="30px">赶紧点击一下链接激活账号吧，建议登录后修改密码</td>
            </tr>
            <tr>
                <td></td>
                <td height="30px">
                    <a href="{{Config::get('domain.domainName')}}/user_activate?token={{ $token }}" style="color:#009bdc;cursor:pointer;">{{Config::get('domain.domainName')}}/user_activate?token={{$token}}</a>
                </td>
            </tr>
            <tr height="60" ><td colspan="2" style="border-bottom: 1px dashed #ddd;"></td></tr>
            <tr height="20px"></tr>
            <tr>
                <td></td>
                <td height="30px">如果您在使用过程中有任何疑问，请随时联系我们：</td>
            </tr>
            <tr height="40px"></tr>

            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="860px" style="font-family: '微软雅黑';font-size: 14px;color: #393737;">
            <tbody>
            <tr>
                <td width="150"></td>
                <td width="500px" height="30px">微信平台：cloudwise2014</td>
                <td rowspan="3"><img src="{{Config::get('domain.domainName')}}/resource/img/erweima.png"/></td>
            </tr>
            <tr>
                <td></td>
                <td height="30px">统一受理热线：400-618-7188</td>
            </tr>
            <tr>
                <td></td>
                <td height="30px">统一受理平台：<a href="support.cloudwise.com" style="color: #009bdc;">support.cloudwise.com</a></td>
            </tr>
            <tr height="40"></tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>