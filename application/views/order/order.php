<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮帮乐</title>

</head>
<body>
<div class="loading"><img src="{{host}}public/images/ajax-loader.gif"/></div>
<div data-role="page" class="touzi jilu" id="jilu">
    <!--jqmb需要把所以东西放在page div内-->

    <link rel="stylesheet" href="{{host}}public/css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="{{host}}public/css/style.css"/>
    <link rel="stylesheet" href="{{host}}public/css/order.css"/>

    <!--jqmb需要把所以东西放在page div内-->
    <header data-role="header" data-position="fixed">
        <a href="#" data-ajax="false" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a>
        <h3>我的订单</h3>
    </header>
    <div class="ui-content"   data-role="content">
        <div class="nav-tab-top" style="height:47px">
            <ul>
                <li data-code="send"  class="cur click">
                    我发的订单
                </li>
                <li data-code="get" class="click">
                    我接的订单
                </li>
            </ul>
        </div>
        <div id="send" >
        </div>
        <div id="get" style="display: none">
        </div>
         <script src="{{host}}public/js/jquery.min.js"></script>
<!--    <script src="{{host}}public/jQuery.mobile-Tabs/jquery.mobile.tabs.js"></script>-->
    <script src="{{host}}public/js/jquery.mobile-1.4.5.min.js"></script>
    <script type="text/javascript">
        $(window).load(function(){
            $(".loading").fadeOut();
        })
        $.get("{{host}}order/getsend",{},function (data) {
            if(data==1)
            {
                window.location.href="{{host}}login/login"
            } else {
                var v = '';
                for (var i = 0; i < data.length; i++) {
                    v += '<a href="{{host}}order/send_one/id/'+data[i].s_id+'" style="color: #051b28;" data-ajax="false">\
                        <div style="background-color: #fff;margin-top: 30px;">\
                    <div style="height: 35px;">';
                    if (data[i].r_id == null) {
                        v += '<div style="height: 35px;width: 50%;float:left;line-height: 35px;text-indent: 1em">暂时没有人接单</div>'
                    } else {
                        v += '<div style="height: 35px;width: 50%;float:left;line-height: 35px;text-indent: 1em">接单人：' + data[i].nickname + '</div>'
                    }
                    if(data[i].s_type==1) {
                            v += '<div style="height: 35px;width: 45%;float:left;color:red;text-align: right;line-height: 35px">任务未被接取</div>'
                    }else if(data[i].s_type==2) {
                            v += '<div style="height: 35px;width: 45%;float:left;color:red;text-align: right;line-height: 35px">任务正在完成中</div>'
                    }else if(data[i].s_type==3) {
                            v += '<div style="height: 35px;width: 45%;float:left;color:red;text-align: right;line-height: 35px">任务已完成</div>'
                    }else if(data[i].s_type==4) {
                            v += '<div style="height: 35px;width: 45%;float:left;color:red;text-align: right;line-height: 35px">交易结束</div>'
                    }

                    v += '</div>\
                    <div style="height: 70px; background-color: #f7f7f7">\
                    <div style="height: 70px;width: 65%;float:left;line-height: 70px;font-weight: bold;text-align: center;font-size: 18px;">' + data[i].s_title + '</div>\
                    <div style="height: 70px;width: 35%;float:left; line-height: 70px;font-weight: bold; font-size: 20px;text-align: center">￥' + data[i].s_list_money + '</div>\
                    </div>\
                    <div style="height: 25px;">\
                    <div style="float: right;text-align:center;width: 40%;height: 25px;line-height:25px;">违约状态：<font color="green">未违约</font></div>\
                    <div style="float: right;text-align:center;width: 60%;height: 25px;line-height:25px; ">订单开始时间：' + data[i].s_time + '</div>\
                </div>\
                </div>\
                </a>'
                }
                $("#send").html(v)
            }
        },'json')
        $.get("{{host}}order/getget",{},function (data) {
            if(data==1)
            {
                 location.href="{{host}}login/login"
            } else {
                var v = '';
                for (var i = 0; i < data.length; i++) {
                    v += '<a href="{{host}}lists/lists/id/'+data[i].s_id+'" style="color: #051b28;" data-ajax="false">\
                        <div style="background-color: #fff;margin-top: 30px;">\
                    <div style="height: 35px;">';
                    v += '<div style="height: 35px;width: 50%;float:left;line-height: 35px;text-indent: 1em">发单人：' + data[i].nickname + '</div>'
                   if (data[i].s_type==1) {
                            v += '<div style="height: 35px;width: 45%;float:left;color:red;text-align: right;line-height: 35px">任务未被接取</div>'
                    } else if (data[i].s_type == 2) {
                            v += '<div style="height: 35px;width: 45%;float:left;color:red;text-align: right;line-height: 35px">任务正在完成中</div>'
                    } else if (data[i].s_type == 3) {
                            v += '<div style="height: 35px;width: 45%;float:left;color:red;text-align: right;line-height: 35px">任务已完成</div>'
                    } else if (data[i].s_type == 4) {
                            v += '<div style="height: 35px;width: 45%;float:left;color:red;text-align: right;line-height: 35px">交易结束</div>'
                    }

                    v += '</div>\
                    <div style="height: 70px; background-color: #f7f7f7">\
                    <div style="height: 70px;width: 65%;float:left;line-height: 70px;font-weight: bold;text-align: center;font-size: 18px;">' + data[i].s_title + '</div>\
                    <div style="height: 70px;width: 35%;float:left; line-height: 70px;font-weight: bold; font-size: 20px;text-align: center">￥' + data[i].s_list_money + '</div>\
                    </div>\
                    <div style="height: 25px;">\
                    <div style="float: right;text-align:center;width: 40%;height: 25px;line-height:25px;">违约状态：<font color="green">未违约</font></div>\
                    <div style="float: right;text-align:center;width: 60%;height: 25px;line-height:25px; ">订单开始时间：' + data[i].s_time + '</div>\
                </div>\
                </div>\
                </a>'
                }
                $("#get").html(v)
            }
        },'json')
        $(document).on('click','.click',function () {
            $(this).addClass("cur").siblings('li').removeClass('cur');
            var code = $(this).attr("data-code");
            if(code=='send'){
                $("#send").show();
                $("#get").hide();
            } else {
                $("#send").hide();
                $("#get").show();
            }
        })
    </script>
    </div>
</div>

</body>
</html>
