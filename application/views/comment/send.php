<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>赚不停</title>
    <link rel="stylesheet" type="text/css" href="{{host}}public/css/slick.css"/>
    <link rel="stylesheet" href="{{host}}public/css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="{{host}}public/css/style.css"/>
    <script src="{{host}}public/js/jquery.min.js"></script>
    <script src="{{host}}public/js/jquery.mobile-1.4.5.min.js"></script>

</head>
<body style="background-color: #f2f2f2;">
	<!-- <div class="loading"><img src="{{host}}public/images/ajax-loader.gif"/></div> -->
	<div data-role="page"  class="touzi jilu" id="jilu">
		<header data-role="header" data-position="fixed">
			<h3>赚不停</h3>
		</header>
		<link media="screen" href="{{host}}public/statics/grade.css" type="text/css" rel="stylesheet" /> 
		<script src="{{host}}public/statics/jquery-latest.pack.js" type="text/javascript"></script> 
		<script src="{{host}}public/statics/grade.js" type="text/javascript"></script> 
		<div class="ui-content" data-role="content"> 
<div id="box"> 
	<h2 align="center">接单评论</h2> 
		<div id="myPoint">
			<span><big>{{data.level}}</big><small>.0</small></span> 
			<div>
				<img src="{{host}}public/statics/star{{data.level}}.gif"/>
			</div>
		</div> 
		<div id="doPoint"> 
			<p>星星评分=(服务+速度+信用)/3</p> 
			<li>
				<ul>服务:<img src="../public/statics/star{{data.fuwu}}.gif" alt=""></ul>   
				<ul>速度:<img src="../public/statics/star{{data.speed}}.gif" alt=""></ul>
				<ul>信用:<img src="../public/statics/star{{data.info}}.gif" alt=""></ul>
			</li>

			
	 		<!-- <table  cellspacing="0" cellpadding="0" border="0">

			{% for val in data %}
			<li>
				<ul><img src="../public/statics/star{{val.e_fuwu}}.gif" alt=""></ul>   
				<ul><img src="../public/statics/star{{val.e_speed}}.gif" alt=""></ul>
				<ul><img src="../public/statics/star{{val.e_info}}.gif" alt=""></ul>
			</li>
			{% endfor%}
			</table> -->
			<br>
		<h3><a href="send">接单评论</a></h3>
		<h3><a href="lend">发单评论</a></h3>
		 <script src="{{host}}public/js/jquery.min.js"></script>
     	 <script src="{{host}}public/js/jquery.mobile-1.4.5.min.js"></script>
	     <script type="text/javascript">
					$(window).load(function(){
						$(".loading").fadeOut();
					})
	    </script>
	</div>
</body>
</html>