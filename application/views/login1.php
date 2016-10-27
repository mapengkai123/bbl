<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮帮乐</title>
    <base href="{{host}}public/"/>
    <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>

</head>
<body>
<div data-role="page" class="touzi phone" id="phone">
    <header data-role="header" data-position="fixed">
        <a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a>
        <h3>登陆</h3>
    </header>
    <div class="ui-content"  data-role="content">
        <form  action="{{host}}login/logined"   method="post" data-ajax="false">
            <ul>
                <li>
                    <label>用户名：</label>
                    <input type="text" name="name" id="na" required=""  placeholder="请填写用户名" data-role="none"/>
                </li>
                <li>
                    <label>密码：</label>
                    <input type="password" name="u_pwd" id="pwd" required="" placeholder="请填写密码" data-role="none"/>
                </li>
            </ul>
            <input type="submit" id="sub"   value="登陆" data-role="none"/>
            <p style="text-align: center">没有账号? <a href="{{host}}login/reg" data-ajax="false">立即注册</a></p>
        </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.cookie.js" ></script>
    <script src="js/jquery.mobile-1.4.5.min.js"></script>
    <script>

    </script>
</div>
</body>
</html>