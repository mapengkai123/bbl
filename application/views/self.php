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
<body style="background-color: #f2f2f2;">
	<div class="loading"><img src="images/ajax-loader.gif"/></div>
	<div data-role="page" class="index self" id="self">
		<header data-role="header">
			<h3>帮帮乐</h3>
		</header>
		<div class="ui-content" data-role="content"> 
			<section class="self-header">
				<p>当前帐户：{{one.name}}</p>
				<ul>
					<li><h3>已发单</h3><br>{{one.fa}}</li>
					<li><h3>已接单</h3><br>{{one.jie}}</li>
				</ul>
			</section>
			<div class="self-tixian">
				<p>总余额（元）<b>￥{{one.balance}}</b></p>
				<a href="{{host}}property/recharge" data-role="none" data-transition="slide" data-ajax="false"  class="chong">充值</a>
				<a href="{{host}}property/cash" data-role="none" data-transition="slide" data-ajax="false"  class="tixian">提现</a>
			</div>
			<dl>
				<dd>
					<a href="{{host}}order/orderlist" data-transition="slide" data-ajax="false"  class="ui-btn ui-btn-icon-right ui-icon-appright ui-nodisc-icon">我的订单</a>
				</dd>
                <dd>
                    <a href="{{host}}comment/lend" data-transition="slide" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-appright ui-nodisc-icon">我的评价</a>
                </dd>
				<dt>
					<a href="{{host}}set/home" data-ajax="false" class="ui-btn ui-btn-icon-right ui-icon-appright ui-nodisc-icon">设置</a>
					</dt>
			</dl>
		</div>

		<footer data-role="footer" data-position="fixed">  
			<ul>
				<li><a href="{{host}}lists/receive"  rel="external">接单</a></li>
				<li><a href="{{host}}lists/send"  rel="external">发单</a></li>
				<li><a href="javascript:void(0)" id="center"  rel="external">我的</a></li>
			</ul>
		</footer>
		 <script src="js/jquery.min.js"></script>
     	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	    <script type="text/javascript">
					$(window).load(function(){
						$(".loading").fadeOut();
					});
            $(document).on('click',"#center",function() {
                $.get("{{host}}common/checklog", {}, function (data) {
                    if (data == 0) {
                        window.location.href = "{{host}}login/login";
                    } else {
                        window.location.href = "{{host}}index/self";
                    }
                })
            })
        </script>
</body>
</html>