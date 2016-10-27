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
	<div data-role="page" class="touzi bank" id="set-bank">
		<header data-role="header" data-position="fixed">
			<a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a> 
			<h3>银行卡</h3>
		</header>
		<div class="ui-content" data-role="content">
			<ul>
				<li>
					<small>开户行</small>
					<span>招商银行</span>
				</li>
				<li>
					<small>账号</small>
					<span>62215461654513461</span>
				</li>
			</ul>
			<ul>
				<li>
					<small>开户行</small>
					<span>招商银行</span>
				</li>
				<li>
					<small>账号</small>
					<span>62215461654513461</span>
				</li>
			</ul>
			<a href="{{host}}set/add_bank" data-transition="slide">添加新卡</a>
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