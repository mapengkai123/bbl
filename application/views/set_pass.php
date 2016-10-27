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
	<div class="loading"><img src="images/ajax-loader.gif"/></div>
	<div data-role="page" class="touzi set" id="pass">
		<header data-role="header" data-position="fixed">
			<a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a> 
			<h3>交易密码</h3>
		</header>
		<div class="ui-content" data-role="content">
			<dl>
				<dd>
					<a href="{{host}}set/gopass" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon"><label>设置交易密码</label></a>
				</dd>
				<dd>
					<a href="{{host}}set/topass" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon"><label>修改交易密码</label></a>
				</dd>
			</dl>
		</div>
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