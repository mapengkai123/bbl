<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮帮乐</title>
</head>
<body>
<div class="loading"><img src="{{host}}public/images/ajax-loader.gif"/></div>
<div data-role="page" class="touzi tixian" id="chong">
    <!--jqmb需要把所以东西放在page div内-->
    <link rel="stylesheet" href="{{host}}public/css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="{{host}}public/css/style.css"/>

    <!--jqmb需要把所以东西放在page div内-->
    <header data-role="header" data-position="fixed">
        <a href="{{host}}index/self"  class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a>
        <h3>充值</h3>
    </header>
    <div class="ui-content" data-role="content">
        <form id="form1" action="{{host}}Property/recharge_ac" method="post" data-ajax="false">
        <ul class="tibox">
            <li>
                <label>充值金额：</label>
                <input type="number" name="paynum" id="paynum" data-role="none" placeholder="请输入充值金额"/>元
                <p id="checkpaynum" style="color: red;"></p>
            </li>
            <li>
                <label>支付方式：</label>
                <select name="type" id="type" data-role="none">
                    <option value="0">请选择一个支付方式</option>
                    <option value="1">银行卡支付（暂未开放）</option>
                    <option value="2">微信支付（暂未开放）</option>
                </select>
                <p id="checktype" style="color: red"></p>
            </li>
            <li>
                <label>支付密码：</label>
                <div class="pwd-box">
                    <input type="tel" name="paypass" autocomplete="off" maxlength="6" class="pwd-input" id="pwd-input" data-role="none">
                    <div class="fake-box">
                        <input type="password" data-role="none" maxlength="1" readonly="">
                        <input type="password" data-role="none" maxlength="1" readonly="">
                        <input type="password" data-role="none" maxlength="1" readonly="">
                        <input type="password" data-role="none" maxlength="1" readonly="" >
                        <input type="password" data-role="none" maxlength="1" readonly="" >
                        <input type="password" data-role="none" maxlength="1" readonly="" >
                    </div>
                </div>
                <p id="checkpaypass" style="color: red"></p>
            </li>
        </ul>
        <div class="tou-sub"><input type="submit" class="submit"  value="提交" data-role="none"/>
        </form>
        </div>
    </div>
    <script src="{{host}}public/js/jquery.min.js"></script>
    <script src="{{host}}public/js/jquery.mobile-1.4.5.min.js"></script>
    <script type="text/javascript">
        $(window).load(function(){
            $(".loading").fadeOut();
        })
    </script>
    <script>
        var $input = $(".fake-box input");
        var ok1=false;
        var ok2=false;
        var ok3=false;
        $("#pwd-input").on("input", function() {
            var pwd = $(this).val().trim();
            for (var i = 0, len = pwd.length; i < len; i++) {
                $input.eq("" + i + "").val(pwd[i]);
            }
            $input.each(function() {
                var index = $(this).index();
                if (index >= len) {
                    $(this).val("");
                }
            });
            if (len == 6) {
                $(".tou-sub input").css({backgroundColor:"#009dd9"})
                $("#checkpaypass").empty()
                ok1=true;
            }else{
                $(".tou-sub input").css({backgroundColor:"#999"})
                $("#checkpaypass").html("请输入六位支付密码")
                ok1=false;
            }
        });
        $("#paynum").blur(function () {
            var _this = $(this).val();
            if(_this==''){
                $("#checkpaynum").html("请输入金额")
                $(".tou-sub input").css({backgroundColor:"#999"})
                ok2=false;
            } else {
                $("#checkpaynum").empty()
                ok2=true;
            }
        })
        $("#type").blur(function () {
            var _this = $(this).val();
            if(_this==0){
                $("#checktype").html("请选择支付类型")
                $(".tou-sub input").css({backgroundColor:"#999"})
                ok3=false;
            } else {
                $("#checktype").empty()
                ok3=true;
            }
        })
        $('.submit').click(function(){
            if(ok1 && ok2 && ok3){
                $('#form1').submit();
            }else{
                return false;
            }
        });
    </script>
</div>

</body>
</html>
