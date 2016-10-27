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
			    	<table id="table1">
			    	</table>
			      </div>
			      <div data-role="content">
				  	<input type="button" value="我已到达任务地点" id="addr">
				  	<div id="npwd">
				  		<input type="button" value="输入密码" id="pwd">
				  	</div>
				  	<div id="sn" style="display:none">
				  		<input type="hidden" value="{{ id }}" id="s_id">
				  		<input type="text" id="ipwd">
				  		<input type="button" value="提交" id="sub">
				  	</div>
				  	<div id="finish" style="display:none">
				  		<div id="comment" style="display:none">
				  			<input type="button" value="评论订单" id="comment_send">
				  		</div>
				  		<input type="button" value="订单已完成">
				  	</div>
				  </div>
				  <div id="allmap" style="display:none"></div>
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
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ERtymnt2XAAWdaDdLGE60jqk0pm4Q4kT"></script>
		<script>
			$(function(){
				//评论对方
				$("#comment_send").click(function(){
					var s_id = $("#id").attr('ids');
					location.href="{{host}}comment/show/s_id/"+s_id
				})
				
				//查看是否评论了对方
				$.get('{{host}}comment/show2/s_id'+s_id+'/type/0',function(msg){
					if(msg==0)
					{
						$("#comment").show()
					}
				},'json')
				//获取当前位置
				var id = $("#id").attr('ids')
				var lat;
				var lng;
				var map = new BMap.Map("allmap");
				var point = new BMap.Point(116.331398,39.897445);
				map.centerAndZoom(point,12);
				var geolocation = new BMap.Geolocation();
				geolocation.getCurrentPosition(function(r){
					if(this.getStatus() == BMAP_STATUS_SUCCESS){
						var mk = new BMap.Marker(r.point);
						map.addOverlay(mk);
						map.panTo(r.point);
						lat=r.point.lat;
						lng=r.point.lng;
					}
					else {
						alert('failed'+this.getStatus());
					}        
				},{enableHighAccuracy: true})

				//页面信息
				var id = $("#id").attr('ids')
				$.get("{{host}}lists/receive_details/id/"+id,function(msg){
					//如果以到达任务地址则删除到达任务地址按钮
					if(msg.s_type==4)
					{
						$("#finish").show()
						$("#addr").remove()
						$("#npwd").hide()
						var table = '<tr><td>发单人</td><td>：'+msg.u_name+'</td></tr><tr><td>标题</td><td>'+msg.s_title+'</td></tr><tr><td>详细信息</td><td>'+msg.s_content+'</td></tr><tr><td>本单可得金额</td><td>'+msg.s_list_money+'￥</td></tr><tr><td>违约金额</td><td>'+msg.s_violate_money+'￥</td></tr><tr><td>发单人联系方式</td><td>'+msg.s_call+'</td></tr><tr><td>任务地址</td><td>'+msg.s_s_address+'</td></tr><tr><td>约定交易地点</td><td>'+msg.s_s_end_address+'</td></tr><tr><td>订单开始时间</td><td>'+msg.s_time+'</td></tr><tr><td>订单结束时间</td><td>'+msg.s_end_time+'</td></tr>{% if '+msg.s_type+'>2 %}<tr><td>任务地点状态</td><td>已成功到达任务地点</td></tr> {% endif %}';
						$("#table").append(table)

						//查看本单是否有发单人给接单人的评论
						var s_id = $("#s_id").val();//本单id
						$.get('{{host}}comment/show3/s_id/'+s_id+'/type/0',function(msg){
							if(msg!=0)
							{
								$("#table1").append('<tr><td>接单人评论:</td><td>'+msg.e_content+'</td></tr>')
							}
						},'json')
					}else{
						if(msg.s_type==3)
						{
							$("#addr").remove()
							
						}else{
							$("#npwd").hide()
						}
						var table = '<tr><td>发单人</td><td>：'+msg.u_name+'</td></tr><tr><td>标题</td><td>'+msg.s_title+'</td></tr><tr><td>详细信息</td><td>'+msg.s_content+'</td></tr><tr><td>本单可得金额</td><td>'+msg.s_list_money+'￥</td></tr><tr><td>违约金额</td><td>'+msg.s_violate_money+'￥</td></tr><tr><td>发单人联系方式</td><td>'+msg.s_call+'</td></tr><tr><td>任务地址</td><td>'+msg.s_s_address+'</td></tr><tr><td>约定交易地点</td><td>'+msg.s_s_end_address+'</td></tr><tr><td>订单开始时间</td><td>'+msg.s_time+'</td></tr><tr><td>订单结束时间</td><td>'+msg.s_end_time+'</td></tr>{% if '+msg.s_type+'>2 %}<tr><td>任务地点状态</td><td>已成功到达任务地点</td></tr> {% endif %}';

						$("#table").append(table)
					}
					
				},'json')

				//是否到达任务地点
				$("#addr").click(function(){
					$.get('{{host}}lists/address/id/'+id+'/lng/'+lng+'/lat/'+lat,function(msg){
						if(msg=='0')
						{
							alert('已到达')
							$("#addr").remove()
							$("#npwd").show()
						}else{
							alert('未到达指定任务地点')
						}
					})
				})

				//输入密码
				$("#pwd").click(function(){
					$("#sn").show()
				})

				//验证密码
				$("#sub").click(function(){
					var pwd = $("#ipwd").val()
					var s_id= $("#s_id").val()
					$.get('{{host}}lists/finish/s_id/'+s_id+'/pwd/'+pwd,function(msg){
						// alert(msg)
						if(msg=='1')
						{
							$("#sn").hide()
							$("#pwd").remove()
							$("#finish").show()
							alert('订单已完成')
						}else{
							alert('密码错误')
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
</body>
</html>