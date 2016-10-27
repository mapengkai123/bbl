<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>赚不停</title>
     <link rel="stylesheet" type="text/css" href="{{host}}public//css/slick.css"/>
    <link rel="stylesheet" href="{{host}}public//css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="{{host}}public//css/style.css"/>
    <script src="{{host}}public//js/jquery.min.js"></script>
     <script src="{{host}}public//js/jquery.mobile-1.4.5.min.js"></script>
</head>
<body style="background-color: #f2f2f2;">
	<div class="loading"><img src="{{host}}public//images/ajax-loader.gif"/></div>
	<div data-role="page" class="index" id="index">

		<header data-role="header">
		<a href="{{host}}lists/receive" data-ajax="false" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a>
			<h3>赚不停</h3>
		</header>
			 <div data-role="main" class="ui-content">
			      <div class="ui-field-contain" ids="{{ id }}" money="{{ money }}" id="id">
			    	<table id="table">
			    	</table>
			      </div>
			      <div data-role="content">
				  	<input type="button" value="接下本单" id="btn">
				  </div>
				  <div id="comment">
				  		
				  </div>
			  </div>
		<footer data-role="footer" data-position="fixed">  
			<ul>
				<li><a href="{{host}}lists/receive"  rel="external">接单</a></li>
				<li><a href="{{host}}lists/send"  rel="external">发单</a></li>
				<li><a href="self.html"  rel="external">我的</a></li>
			</ul>
		</footer>
		<script src="{{host}}public//js/slick.min.js" ></script>
		<script>
			$(function(){
				var id = $("#id").attr('ids')
				$.get("{{host}}lists/receive_details/id/"+id,function(msg){
					var table = '<tr><td>发单人</td><td>：'+msg.u_name+'</td></tr><tr><td>标题</td><td>'+msg.s_title+'</td></tr><tr><td>详细信息</td><td>'+msg.s_content+'</td></tr><tr><td>本单可得金额</td><td>'+msg.s_list_money+'￥</td></tr><tr><td>违约金额</td><td>'+msg.s_violate_money+'￥</td></tr><tr><td>发单人联系方式</td><td>'+msg.s_call+'</td></tr><tr><td>任务地址</td><td>'+msg.s_s_address+'</td></tr><tr><td>约定交易地点</td><td>'+msg.s_s_end_address+'</td></tr><tr><td>订单开始时间</td><td>'+msg.s_time+'</td></tr><tr><td>订单结束时间</td><td>'+msg.s_end_time+'</td></tr>';
					$("#table").append(table)
				},'json')

				//接单
				$("#btn").click(function(){
					var id = $("#id").attr('ids')
					var money = $("#id").attr('money')
					$.get('{{host}}lists/receive_lists/id/'+id+'/money/'+money,function(msg){
						if(msg==1)
						{
							// alert(msg)
							location.href="{{host}}lists/lists/id/"+id+"/money/"+money;
						}else{
							alert('余额不足');
						}
					})
				})
			})
		</script>
	    <script type="text/javascript">
	    	$(document).on("pagecreate","#index",function(){
 					$('.slick').slick({
						    	dots:true,
						    	autoplay:true,
						    	autoplaySpeed:2000,
						    	arrows:false,
						    }); 
					
					});
					$(window).load(function(){
						$(".loading").fadeOut()
					})
	    </script>
	</div>
	</div>
</body>
</html>