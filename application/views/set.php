<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮帮乐</title>
    <base href="{{host}}public/"/>
</head>
<body>
	<div class="loading"><img src="images/ajax-loader.gif"/></div>
	<div data-role="page" class="touzi set" id="set">
		<!--jqmb需要把所以东西放在page div内-->
		 <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css"/>
   		 <link rel="stylesheet" href="css/style.css"/>
   		 
   		<!--jqmb需要把所以东西放在page div内--> 
		<header data-role="header" data-position="fixed">
			<a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon"  data-ajax="false">返回</a> 
			<h3>设置</h3>
		</header>
		<div class="ui-content" data-role="content">
			<dl>
				<dd>
					<a href="{{host}}set/name"  data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">实名认证<small>{{one.name}}</small></a>
				</dd>
				<dd>
					<a href="{{host}}set/bank" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">银行卡</a>
				</dd>

                <dd>
                    <a href="{{host}}set/info" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">个人信息</a>
                </dd>
			</dl>
			<dl>
                <dd>
                    <a href="{{host}}set/bang" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">绑定手机<small>{{one.phone}}</small></a>
                </dd>
				<dd>
					<a href="{{host}}set/pass" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">交易密码</a>
				</dd>
				<dd>
					<a href="{{host}}set/pwd" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">修改登录密码</a>
				</dd>

			</dl>
			<dl>
				<dd>
					<a href="{{host}}set/ques" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">常见问题</a>
				</dd>
				<dd>
					<a href="{{host}}set/details" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">关于我们</a>
				</dd>
			</dl>
		</div>
		<footer  data-position="fixed" data-role="footer">
		</footer>
		<script src="js/jquery.min.js"></script>
   		<script src="js/jquery.mobile-1.4.5.min.js"></script>
   		<script type="text/javascript">
   			$(window).load(function(){
					$(".loading").fadeOut();
					
				})
   		</script>
	</div>
	
</body>
</html>