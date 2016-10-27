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
			<h3>星级 排行榜</h3>
		</header>
		<div class="ui-content" data-role="content">
	 	<table data-role="table" data-mode="" class="ui-responsive" id="myTable">
      <thead>
        <tr>
          <th data-priority="2">昵称</th>
          <th data-priority="3">星级</th>
          <th data-priority="4">排名</th>
        </tr>
      </thead>
      {% for val in data %}
      <tbody>
        <tr>
          <td>{{val.u_name}}</td>
          <td><img src="../public/statics/star{{val.star_num}}.gif" alt=""></td>
          <td><img src="../public/images/{{val.star_num}}.jpg" alt=""></td>
        </tr>
      </tbody>
      	{% endfor%}
    </table>
		</div>

		
		<footer  data-position="fixed" data-role="footer">
			<font color="red" >&nbsp;&nbsp;   特别提醒：综合评价高于8星可以荣登排行板</font>
			<a data-role="none" href="{{host}}index/index" class="outset" data-ajax="false">返回首页</a>
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