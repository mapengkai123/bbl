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
     <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ERtymnt2XAAWdaDdLGE60jqk0pm4Q4kT"></script>
</head>
<body style="background-color: #f2f2f2;">
	<div class="loading"><img src="{{host}}public//images/ajax-loader.gif"/></div>
	<div data-role="page" class="index" id="index">

		<header data-role="header">
		<a href="{{host}}lists/receive" data-ajax="false" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a>
			<h3>赚不停</h3>
		</header>
			 <div data-role="main" class="ui-content">
			      <div class="ui-field-contain" ids="{{ s_id }}" id="id">
			    	<table id="table">
			    	</table>
			    	<table id="table1">
			    	</table>
			      </div>
			      <div data-role="content" id="dis" style="display:none">
				  	<input type="button" value="我已到达" id="btn">
				  </div>
				  <div data-role="content" id="end_address" style="display:none">
				  	<input type="button" value="您已到达交易地点">
				  </div>
				  <div id="comment" style="display:none">
			  			<input type="button" value="评论订单" id="comment_receive">
			  		</div>
			  </div>
			  <!-- 百度地图 -->
			  <div id="allmap" style="display:none"></div>
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
				//评论对方
				$("#comment_receive").click(function(){
					var s_id = $("#id").attr('ids');
					location.href="{{host}}comment/show1/s_id/"+s_id
				})
				//查看是否评论对方
				var s_id = $("#id").attr('ids');
				$.get('{{host}}comment/show3/s_id'+s_id+'/type/1',function(msg){
					$.get('{{host}}lists/if_receive/s_id'+s_id,function(msg1){
						if(msg1!=null)
						{
							if(msg==0)
							{
								$("#comment").show()
							}
						}
					},'json')
				},'json')

				var id = $("#id").attr('ids')
				$.get("{{host}}order/send_one_s/id/"+id,function(msg){
					var table = '<tr><td>发单人</td><td>：'+msg.nickname+'</td></tr><tr><td>标题</td><td>'+msg.s_title+'</td></tr><tr><td>详细信息</td><td>'+msg.s_content+'</td></tr><tr><td>本单可得金额</td><td>'+msg.s_list_money+'￥</td></tr><tr><td>违约金额</td><td>'+msg.s_violate_money+'￥</td></tr><tr><td>发单人联系方式</td><td>'+msg.s_call+'</td></tr><tr><td>任务地址</td><td>'+msg.s_s_address+'</td></tr><tr><td>约定交易地点</td><td>'+msg.s_s_end_address+'</td></tr><tr><td>订单开始时间</td><td>'+msg.s_time+'</td></tr><tr><td>订单结束时间</td><td>'+msg.s_end_time+'</td></tr><tr><td>订单完成密码</td><td>'+msg.s_pwd+'</td></tr>';
					$("#table").append(table)
					alert(msg.r_id)
					if(msg.r_id!=null)
					{
						if(msg.s_violate_u!='1')
						{
							$("#dis").show()
						}else{
							$("#end_address").show()

							//判断接单人是否评论
							if(msg.s_type==4)
							{
								var s_id = $("#id").attr('ids');
								$.get('{{host}}comment/show2/s_id/'+s_id+'/e_type/1',function(msg){
									if(msg!=0)
									{
										$("#table1").append('<tr><td>接单人评论:</td><td>'+msg.e_content+'</td></tr>')
									}
								},'json')
							}
						}
					}
					
				},'json')

				//接单
				$("#btn").click(function(){
					var id = $("#id").attr('ids')
					//获取当前位置
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

							//判断距离
							$.get("{{host}}order/send_address/lat/"+lat+"/lng/"+lng+"/id/"+id,function(msg){
								if(msg=='0')
								{
									$("#dis").hide()
									$("#end_address").show()
								}else{
									alert('未到达指定地点')
								}
							})
						}
						else {
							alert('failed'+this.getStatus());
						}        
					},{enableHighAccuracy: true})
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