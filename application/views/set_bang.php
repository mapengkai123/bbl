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
	<div data-role="page" class="touzi set" id="set-bang">
		<header data-role="header" data-position="fixed">
			<a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-ajax="false">返回</a> 
			<h3>绑定手机</h3>
		</header>
		<div class="ui-content" data-role="content">
			<dl>
				<dt><label>已绑定手机</label><small>{{bang.phone}}</small></dt>
				<dd>
					<a href="{{host}}set/phone" data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon"><label>修改绑定手机</label></a>
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