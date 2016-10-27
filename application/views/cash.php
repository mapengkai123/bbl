<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮帮乐</title>

</head>
<body>
<div class="loading"><img src="{{host}}public/images/ajax-loader.gif"/></div>
<div data-role="page" class="touzi tixian" id="tixian">
    <!--jqmb需要把所以东西放在page div内-->
    <link rel="stylesheet" href="{{host}}public/css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="{{host}}public/css/style.css"/>

    <!--jqmb需要把所以东西放在page div内-->
    <header data-role="header" data-position="fixed">
        <a href="{{host}}index/self" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a>
        <h3>提现</h3>
    </header>
    <div class="ui-content" data-role="content">
        <form action="{{host}}property/cash_ac" data-ajax="false" method="post"  id="form1">
        <ul class="tibox">
            <li>
                <label>您的可用余额为：{{price}}元</label>
            </li>
            <li>
                <label>提现金额：</label>
                <input type="number" data-role="none" price="{{price}}" name="balance" onblur="balanceCheck(this)" value="请输入你好提现的金额"/>元
                <p style="color: red" id="balanceInfo"></p>
            </li>
            <li>
                <label>提现银行卡号：</label>
                <input type="number" name="luhm" data-role="none" maxlength="19" onblur="luhmCheck(this.value)" >
                <p style="color: red" id="banknoInfo"></p>
            </li>
            <li>
                <label>支付密码：</label>
                <div class="pwd-box">
                    <input type="tel" maxlength="6" class="pwd-input"  name="paypass" id="pwd-input" data-role="none">
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
        <div class="tou-sub"><input type="submit" class="submit" value="提交" data-role="none"/></div>
        </form>
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
            } else {
                $(".tou-sub input").css({backgroundColor:"#999"})
                $("#checkpaypass").html("请输入六位支付密码")
                ok1=false;
            }
        });
        function luhmCheck(bankno){
            if (bankno.length < 16 || bankno.length > 19) {
                $("#banknoInfo").html("银行卡号长度必须在16到19之间");
                return false;
            }
            var num = /^\d*$/;  //全数字
            if (!num.exec(bankno)) {
                $("#banknoInfo").html("银行卡号必须全为数字");
                return false;
            }
            //开头6位
            var strBin="10,18,30,35,37,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,58,60,62,65,68,69,84,87,88,94,95,98,99";
            if (strBin.indexOf(bankno.substring(0, 2))== -1) {
                $("#banknoInfo").html("银行卡号开头6位不符合规范");
                return false;
            }
            var lastNum=bankno.substr(bankno.length-1,1);//取出最后一位（与luhm进行比较）

            var first15Num=bankno.substr(0,bankno.length-1);//前15或18位
            var newArr=new Array();
            for(var i=first15Num.length-1;i>-1;i--){    //前15或18位倒序存进数组
                newArr.push(first15Num.substr(i,1));
            }
            var arrJiShu=new Array();  //奇数位*2的积 <9
            var arrJiShu2=new Array(); //奇数位*2的积 >9

            var arrOuShu=new Array();  //偶数位数组
            for(var j=0;j<newArr.length;j++){
                if((j+1)%2==1){//奇数位
                    if(parseInt(newArr[j])*2<9)
                        arrJiShu.push(parseInt(newArr[j])*2);
                    else
                        arrJiShu2.push(parseInt(newArr[j])*2);
                }
                else //偶数位
                    arrOuShu.push(newArr[j]);
            }

            var jishu_child1=new Array();//奇数位*2 >9 的分割之后的数组个位数
            var jishu_child2=new Array();//奇数位*2 >9 的分割之后的数组十位数
            for(var h=0;h<arrJiShu2.length;h++){
                jishu_child1.push(parseInt(arrJiShu2[h])%10);
                jishu_child2.push(parseInt(arrJiShu2[h])/10);
            }

            var sumJiShu=0; //奇数位*2 < 9 的数组之和
            var sumOuShu=0; //偶数位数组之和
            var sumJiShuChild1=0; //奇数位*2 >9 的分割之后的数组个位数之和
            var sumJiShuChild2=0; //奇数位*2 >9 的分割之后的数组十位数之和
            var sumTotal=0;
            for(var m=0;m<arrJiShu.length;m++){
                sumJiShu=sumJiShu+parseInt(arrJiShu[m]);
            }

            for(var n=0;n<arrOuShu.length;n++){
                sumOuShu=sumOuShu+parseInt(arrOuShu[n]);
            }

            for(var p=0;p<jishu_child1.length;p++){
                sumJiShuChild1=sumJiShuChild1+parseInt(jishu_child1[p]);
                sumJiShuChild2=sumJiShuChild2+parseInt(jishu_child2[p]);
            }
            //计算总和
            sumTotal=parseInt(sumJiShu)+parseInt(sumOuShu)+parseInt(sumJiShuChild1)+parseInt(sumJiShuChild2);

            //计算Luhm值
            var k= parseInt(sumTotal)%10==0?10:parseInt(sumTotal)%10;
            var luhm= 10-k;

            if(lastNum==luhm){
                $("#banknoInfo").html(null);
                return true;
            }
            else{
                $("#banknoInfo").html("请输入正确的银行卡号");
                return false;
            }
        }

        function balanceCheck(obj) {
            var ba = parseFloat(obj.value);
            var price = parseFloat(obj.getAttribute('price'));
            if(isNaN(ba)) {
                $("#balanceInfo").html("提现金额不能为空");
                return false;
            }
            if(ba>price) {
                $("#balanceInfo").html("提现金额不能大于可用余额")
                return false;
            } else {
                $("#balanceInfo").html(null)
                return true;
            }
        }
        $('.submit').click(function(){
            var luhm =  $("input[name='luhm']").val();
            var balance =  $("input[name='balance']");
            alert(balance)
            if(ok1 && luhmCheck(luhm) && balanceCheck(balance)){
                $('#form1').submit();
            }else{
                return false;
            }
        });
    </script>
</div>

</body>
</html>
