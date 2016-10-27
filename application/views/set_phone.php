<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>赚不停</title>
    <base href="{{host}}public/"/>
    <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
   		 
</head>
<body>
	<div class="loading"><img src="images/ajax-loader.gif"/></div>
	<div data-role="page" class="touzi phone" id="phone">
		<header data-role="header" data-position="fixed">
			<a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a> 
			<h3>修改绑定手机</h3>
		</header>
		<div class="ui-content" data-role="content">
            <p><font color="#ff7f50">重新绑定手机号后,之前的手机号将作废!</font></p>
            <form  method="post" action="{{host}}set/setphone"  data-ajax="false" >
				<ul>
                    <li>
                        <label>手机号：</label>
                        <input type="tel" name="phone" id="tel" required="" placeholder="请输入合法的手机号" maxlength="11" data-role="none"/>
                    </li>
                    <li>
                        <label>短信验证码：</label>
                        <input type="text" id="number" required="" name="number"/>
                        <input type="button" value="发送验证码" id="but" data-role="none"/>
                    </li>
				</ul>
				<input type="submit"  value="确认修改" data-role="none"/>

			</form>

		</div>
		<script src="js/jquery.min.js"></script>
        <script src="js/jquery.cookie.js" ></script>
   		<script src="js/jquery.mobile-1.4.5.min.js"></script>
   		<script type="text/javascript">
   			$(window).load(function(){
					$(".loading").fadeOut();
                //验证手机号
                $("#tel").keyup(function(){
                    var tel=$(this).val();
                    var tel1=/^1(3|4|5|8|7)\d{9}$/;
                    if(!tel1.test(tel)){
                        this.style.border="1px solid red";
                        return false;
                    }else{
                        this.style.border="1px solid green";
                        return true;
                    }
                });
                //短信验证码
                $("#number").blur(function(){
                    var tem= this;
                    var number =$("#number").val();
                    if(number==''){
                        tem.style.border="1px solid red";
                        return false;
                    }
                    $.post("{{host}}login/number",function(msg){
                        if(number==''){
                            tem.style.border="1px solid red";
                            return false;
                        }
                        if(msg===number)
                        {
                            tem.style.border="1px solid green";
                        }else{
                            tem.style.border="1px solid red";
                            return false;
                        }
                    })
                });
                /*仿刷新：检测是否存在cookie*/
                if($.cookie("captcha")){
                    var count = $.cookie("captcha");
                    var btn = $('#but');
                    btn.val(count+'秒后可重新获取').attr('disabled',true).css('cursor','not-allowed');
                    var resend = setInterval(function(){
                        count--;
                        if (count > 0){

                            btn.val(count+'秒后可重新获取').attr('disabled',true).css('cursor','not-allowed');
                            $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
                        }else {

                            clearInterval(resend);
                            btn.val("获取验证码").removeClass('disabled').removeAttr('disabled style');
                        }
                    }, 1000);
                }

                /*点击改变按钮状态，已经简略掉ajax发送短信验证的代码*/
                $("#but").click(function(){

                    var btn = $(this);
                    //当前时间
                    var date = new Date();
                    var t=date.toLocaleString();
                    var count = 60;
                    var resend = setInterval(function(){
                        count--;
                        if (count > 0){
                            btn.val(count+"秒后可重新获取");
                            $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
                            $.cookie("time",t,{path: '/', expires: 1440*1000});

                        }else {
                            clearInterval(resend);
                            btn.val("获取验证码").removeAttr('disabled style');
                        }
                    }, 1000);
                    //发短信
                    var tel=$("#tel").val();
                    $.post("{{host}}set/msg",{num:tel},function(msg){
                        //alert(msg);
                        if(msg==1){
                            alert("请输入合法的手机号!");
                        }
                        if(msg==2){
                            alert("请重新获取验证码!");
                        }
                    });
                    btn.attr('disabled',true).css('cursor','not-allowed');
                });
				})
   		</script>
	</div>
</body>
</html>