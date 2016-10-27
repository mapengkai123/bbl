<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>赚不停</title>
    <base href="{{host}}"/>
     <link rel="stylesheet" type="text/css" href="public/css/slick.css"/>
    <link rel="stylesheet" href="public/css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="public/css/style.css"/>
    <script src="public/js/jquery.min.js"></script>
     <script src="public/js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body style="background-color: #f2f2f2;">
	<div class="loading"><img src="public/images/ajax-loader.gif"/></div>
	<div data-role="page" class="index" id="index">
		<header data-role="header">
			<h3>帮帮Le</h3>
		</header>
		<div class="ui-content" data-role="content">

            <dl class="index-year">
                <dt>支持续投，次月起年化收益增加0.1%</dt>   </dl>
                <dd>
                    <a href="{{host}}set/name"  data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">实名认证<small>*玉嘭</small></a>
                </dd>
                <dd>
                    <a href="{{host}}set/name"  data-ajax="false" class="ui-btn ui-icon-appright ui-btn-icon-right ui-nodisc-icon">实名认证<small>*玉嘭</small></a>
                </dd>








</div>
            <div class="ui-content" data-role="content">
			<dl class="index-year">
				<a href="month.html" data-transition="slide" data-ajax="false">
					<dd>
						<h4>季度丰</h4>
						<p><small>年化</small>6.3%起</p>
					</dd>
					<dt>支持续投，次月起年化收益增加0.1%</dt> 
				</a>
			</dl>
			<dl class="index-year">
				<a href="month.html" data-transition="slide" data-ajax="false">
					<dd>
						<h4>半年享</h4>
						<p><small>年化</small>6.6%起</p>
					</dd>
					<dt>支持续投，次月起年化收益增加0.1%</dt>
				</a>
			</dl>
		</div>
		<script src="public/js/slick.min.js" ></script>
	    <script type="text/javascript">
	    	$(document).on("pagecreate","#index",function(){
 					$('.slick').slick({
						    	dots:true,
						    	autoplay:true,
						    	autoplaySpeed:2000,
						    	arrows:false
						    }); 
					
					});
					$(window).load(function(){
						$(".loading").fadeOut()
					})
	    </script>
	</div>
</body>
</html>