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
	<div class="loading"><img src="{{host}}public/images/ajax-loader.gif"/></div>
	<div data-role="page" class="touzi yijian" id="yijian">  
		<header data-role="header" data-position="fixed">
			<a href="#" data-rel="back" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" 
			data-transition="slide" data-direction="revserse">返回</a> 
			<h3>评论</h3>
		</header>
		<link media="screen" href="{{host}}public/statics/grade.css" type="text/css" rel="stylesheet" /> 
		<script src="{{host}}public/statics/jquery-latest.pack.js" type="text/javascript"></script> 
		<script src="{{host}}public/statics/grade.js" type="text/javascript"></script> 

<div class="ui-content" data-role="content"> 
<div id="box"> 
	<h2 align="center">我的评分</h2> 
	
		<div id="myPoint">
			<span><big>5</big><small>.0</small></span> 
			<div>
				<img src="{{host}}public/statics/star5.gif"/>
				<em>(一般)</em>
			</div>
		</div> 
		<div id="doPoint"> 
			<p>星星评分=(服务+速度+信用)/3</p> 
			<table cellspacing="0" cellpadding="0" border="0"> 
					<tbody> 
						<tr> 
							<th>服务：</th> 
							<td><span class="star5" id="item1" v="5"><small>1</small><small>2</small><small>3</small><small>4</small><small>5</small><small>6</small><small>7</small><small>8</small><small>9</small><small>10</small></span></td> 
							<td><strong>5</strong> <em>(一般)</em></td>
						</tr> 
						<tr> 
							<th>速度：</th> 
							<td><span class="star5" id="item2" v="5"><small>1</small><small>2</small><small>3</small><small>4</small><small>5</small><small>6</small><small>7</small><small>8</small><small>9</small><small>10</small></span></td> 
							<td><strong>5</strong> <em>(一般)</em></td>
						</tr> 
						<tr> 
							<th>信用：</th> 
							<td><span class="star5" id="item3" v="5"><small>1</small><small>2</small><small>3</small><small>4</small><small>5</small><small>6</small><small>7</small><small>8</small><small>9</small><small>10</small></span></td> 
							<td><strong>5</strong> <em>(一般)</em></td>
						</tr>
					</tbody>
			</table>
	
		<form id="form1"  action="{{host}}comment/fj" method="post" target="_top">
			<input id="pointV1" type="hidden" value="5" name="pointV1" /> 
			<input id="pointV2" type="hidden" value="5" name="pointV2" /> 
			<input id="pointV3" type="hidden" value="5" name="pointV3" /> 
			<label>评论内容：
			<textarea id="woqu" rows="30" cols="5" name="comment">
		
			</textarea></label>
			<button type="submit" id="woqu">提交</button> 
		</form>
	</div>
<!-- </div>   -->
</div>

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