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
        <h3>注册</h3>
    </header>
    <div class="ui-content" data-role="content">
        <form  method="post" action="{{host}}login/register"  data-ajax="false" >
            <ul>

                <li>
                    <label>账号：</label>
                    <input type="text" name="u_name" id="name" required=""  placeholder="请填写3-10字母"  data-role="none"/>
                    <p style="color: red" id="error1"></p>
                </li>
                <li>
                    <label>昵称：</label>
                    <input type="text" name="nickname" id="nick"  required="required" placeholder="请填写昵称" maxlength="20" data-role="none"/>
                </li>
                <li>
                    <label>密码：</label>
                    <input type="password" name="u_pwd" id="pwd" required="required"  placeholder="请填6-10数字密码" maxlength="10" data-role="none"/>
                </li>
                <li>
                    <label>确认密码：</label>
                    <input type="password" name="rpwd" id="rpwd" required="required" placeholder="请确认密码" maxlength="10" data-role="none"/>
                </li>
                <li>
                    <label>邮箱：</label>
                    <input type="email" name="email" id="email" required="required" placeholder="请输入合法电子邮箱" data-role="none"/>
                </li>
                <li>
                    <label>手机号：</label>
                    <input type="tel" name="phone" id="tel" required="required" placeholder="请输入合法手机号" maxlength="11" data-role="none"/>
                    <p style="color: red" id="error2"></p>
                </li>
                <li>
                    <label>短信验证码：</label>
                    <input type="text" id="number" required="" name="number"/>
                    <p style="color: red" id="error3"></p>
                    <input type="button" value="发送验证码" id="but" data-role="none"/>
                </li>

            </ul>
            <input type="submit"  id="sub" value="注册" data-role="none"/>
            <p style="text-align: center"> <a href="{{host}}login/login" data-ajax="false">立即登陆</a></p>
        </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.cookie.js" ></script>
    <script src="js/jquery.mobile-1.4.5.min.js"></script>
    <script type="text/javascript">
      $(function(){
          //账号唯一性
          $("#name").blur(function(){
              var name1=/^[a-z]{3,10}$/i;
              var name=$(this).val();
              var zhe=this;
              if(name1.test(name)){
                  $.post("{{host}}login/only",{name:name},function(one){
                      if(one==1){
                          zhe.style.border="1px solid red";
                          $("#error1").html("账号已存在,请重新填写!");
                         // history.go(0);
                      }else{
                          zhe.style.border="1px solid green";
                          $("#error1").html("");
                      }
                  })
              }else{
                  this.style.border="1px solid red";
                  return false;
              }
          });

          //验证密码
          $("#pwd").blur(function() {
              var pwd = $(this).val();
              var pwd1=/^[0-9]{6,10}$/;
              if(rpwd==''){
                  this.style.border="1px solid red";
                  $("#sub").attr("disabled", true);
                  return false;
              }else if(!pwd1.test(pwd)){
                  this.style.border="1px solid red";
                  return false;
              }else{
                  this.style.border="1px solid green";
                  return true;
              }

          });

          //确认密码是否一致
          $("#rpwd").blur(function(){
              var rpwd=$(this).val();
              var rpwd1=/^[0-9]{6,10}$/;
              var pwd =$("#pwd").val();
               if(rpwd==''){
                   this.style.border="1px solid red";
                   return false;
               }else if(!rpwd1.test(rpwd)){
                  this.style.border="1px solid red";
                  return false;
              }else if(rpwd!=pwd){
                  this.style.border="1px solid red";
                  return false;
              }else{
                  this.style.border="1px solid green";
                  return true;
              }
          });

          //验证email
          $("#email").blur(function(){
              var email=$(this).val();
              var email1=/^[\w]+(\.[\w]+)*@[\w]+(\.[\w]+)+$/;
              if(email==''){
                  this.style.border="1px solid red";
                  return false;
              }else if(!email1.test(email)){
                  this.style.border="1px solid red";
                  return false;
              }else{
                  this.style.border="1px solid green";
                  return true;
              }
          });

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
          $("#number").keyup(function(){
              var tem= this;
              var number =$("#number").val();
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
              var tel1=/^1(3|4|5|8|7)\d{9}$/;
              if(tel==''){
                  tel.style.border="1px solid red";
                  return false;
              }else  if(!tel1.test(tel)){
                  tel.style.border="1px solid red";
                  return false;
              }else{
                  $.post("{{host}}login/msg",{num:tel},function(msg){
                      if(msg==1){
                          $("#error2").html("手机号错误!");
                      }
                      if(msg==2){
                          $("#error3").html("验证码错误!");
                      }
                  });
              }
              btn.attr('disabled',true).css('cursor','not-allowed');
          });
      });
    </script>
</div>
</body>
</html>