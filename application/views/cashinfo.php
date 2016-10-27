<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮帮乐</title>
    <link rel="stylesheet" href="{{host}}public/css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="{{host}}public/css/style.css"/>

</head>
<body>
<div class="loading"><img src="{{host}}public/images/ajax-loader.gif"/></div>
<div data-role="page" class="touzi name" id="set-name">
    <header data-role="header" data-position="fixed">
        <!--        <a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a>-->
        <h3>
            {% if info.status == 1 %}
            提现成功
            {% else %}
            提现失败
            {% endif %}
        </h3>
    </header>
    <div class="ui-content" data-role="content">
        <div style="text-align:center ">
            {% if info.status == 1 %}
            <h2><img src="{{host}}public/images/success.png" alt="">提现成功</h2>
            {% else %}
            <h2><img src="{{host}}public/images/error.png" alt="">提现失败</h2>
            {% endif %}
            <p>{{info.msg}}</p>
        </div>
        {% if info.status == 1 %}
        <a href="{{host}}index/index" data-transition="slide">返回首页</a>
        {% else %}
        <a href="{{host}}property/cash"  rel="external"  data-transition="slide">重新提现</a>
        {% endif %}
    </div>
    <script src="{{host}}public/js/jquery.min.js"></script>
    <script src="{{host}}public/js/jquery.mobile-1.4.5.min.js"></script>
    <script type="text/javascript">
        $(window).load(function(){
            $(".loading").fadeOut();
        })
    </script>
</div>
</body>
</html>
