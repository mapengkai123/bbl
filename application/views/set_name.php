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
	<div data-role="page" class="touzi name" id="set-name">
		<header data-role="header" data-position="fixed">
			<a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a> 
			<h3>实名认证</h3>
		</header>
		<div class="ui-content" data-role="content">
			<div class="namebox">
				<h3>?</h3>
				<p>未认证</p>
			</div>
			<a href="set-ren.html" data-transition="slide">立即认证</a>
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