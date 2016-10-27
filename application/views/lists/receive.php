<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮帮乐</title>
     <link rel="stylesheet" type="text/css" href="{{host}}public/css/slick.css"/>
    <link rel="stylesheet" href="{{host}}public/css/jquery.mobile-1.4.5.min.css"/>
    <link rel="stylesheet" href="{{host}}public/css/style.css"/>
    <script src="{{host}}public/js/jquery.min.js"></script>
     <script src="{{host}}public/js/jquery.mobile-1.4.5.min.js"></script>
     <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ERtymnt2XAAWdaDdLGE60jqk0pm4Q4kT"></script>
</head>
<body style="background-color: #f2f2f2;">
	<div class="loading"><img src="{{host}}public/images/ajax-loader.gif"/></div>
	<div data-role="page" class="index" id="index">

		<!--jqmb需要把所以东西放在page div内--> 
		<header data-role="header" data-position="fixed">
			<a href="{{host}}index/index" data-ajax="false" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a> 
			<h3>接单</h3>
		</header>
		<div class="ui-content" data-role="content"> 
		<!-- 自定义样式 -->
		 <!-- data-role='none' style="width:20px" -->
		 	<div>
		 		<div style="width:30%;float:left">
				 	<select name="" id="distance" >
						<option value="1000">1000m</option>
						<option value="2000" selected>2000m</option>
						<option value="3000">3000m</option>
						<option value="5000">5000m</option>
						<option value="10000">10000m</option>
						<option value="15000">15000m</option>
					</select>
				</div>
		 		<div style="width:65%;float:left;margin-top:11px;padding-left:5%">
		 			当前位置：<br/><span  id="address"></span>
		 		</div>
		 	</div>
			<div id="content">
				<!-- <dl class="index-year" >
					<a href="month.html" data-transition="slide" data-ajax="false">
						<dd>
							<div style="float:left;width:60%;">
							<h4 rowspan='2'>帮我带个饭！！</h4>
							</div>
							<div style="float:left; width:40%">
							<p style="float:none"><small>距离您：</small>1500m</p>
							<p style="float:none"><small>用户星级：</small><img src="{{host}}public/images/star1.gif" width='80' alt=""></p>
							</div>
						</dd>
						<dt><font color="#009dd9">李智渊</font>于2016-05-20 18:20:25发布</dt>
					</a>
				</dl> -->
			</div>
			<div id="allmap" style="display:none"></div>
		</div>
		<footer data-role="footer" data-position="fixed">  
			<ul>
				<li><a href="{{host}}lists/receive"  rel="external">接单</a></li>
				<li><a href="{{host}}lists/send"  rel="external">发单</a></li>
				<li><a href="javascript:void(0)" id='center'  rel="external">我的</a></li>
			</ul>
		</footer>
		<script src="{{host}}public/js/slick.min.js" ></script>
		<script>
			$(function(){
				// var distance = $("#distance").value()
				// $.get('/lists/receive_list',{'distance':distance},function(msg){

				// })
			})
		</script>
		<script>  
			$(function(){  
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
						$.get('http://api.map.baidu.com/geocoder/v2/?ak=ERtymnt2XAAWdaDdLGE60jqk0pm4Q4kT&callback=renderReverse&location='+r.point.lat+','+r.point.lng+'&output=json&pois=1',function(msg){
							$("#address").append(msg.result.formatted_address)

							//位置获取完成获取信息
							var distance = $("#distance").val()
							$.get("{{host}}lists/receive_list/distance/"+distance+"/lng/"+lng+"/lat/"+lat,function(msg){
								var v='';
								for(var i=0;i<msg.length;i++)
								{
									v=v+'<dl class="index-year" ><a href="{{host}}lists/receive_one/id/'+msg[i].s_id+'/money/'+msg[i].s_violate_money+'" data-transition="slide" data-ajax="false"><dd><div style="float:left;width:60%;"> <h4 rowspan="2">'+msg[i].s_title+'</h4></div><div style="float:left; width:40%"><p style="float:none"><small>距离您：</small>'+msg[i].distance+'m</p><p style="float:none"><small>用户星级：</small><img src="{{host}}public/images/star'+msg[i].star_num+'.gif" width="80" alt=""></p></div></dd><dt><font color="#009dd9">'+msg[i].u_name+'</font>于'+msg[i].s_time+'发布</dt></a></dl>'
								}
								$("#content").html(v)
							},'json')
						},'jsonp')
						// alert('您的位置：'+r.point.lng+','+r.point.lat);
					}
					else {
						alert('failed'+this.getStatus());
					}        
				},{enableHighAccuracy: true})

				//判断距离
				$("#distance").change(function(){
					var distance = $(this).val()
					$.get("{{host}}lists/receive_list/distance/"+distance+"/lng/"+lng+"/lat/"+lat,function(msg){
						var v='';
						for(var i=0;i<msg.length;i++)
						{
							v=v+'<dl class="index-year" ><a href="{{host}}lists/receive_one/id/'+msg[i].s_id+'/money/'+msg[i].s_violate_money+'" data-transition="slide" data-ajax="false"><dd><div style="float:left;width:60%;"> <h4 rowspan="2">'+msg[i].s_title+'</h4></div><div style="float:left; width:40%"><p style="float:none"><small>距离您：</small>'+msg[i].distance+'m</p><p style="float:none"><small>用户星级：</small><img src="{{host}}public/images/star'+msg[i].star_num+'.gif" width="80" alt=""></p></div></dd><dt><font color="#009dd9">'+msg[i].u_name+'</font>于'+msg[i].s_time+'发布</dt></a></dl>'
						}
						$("#content").html(v)
					},'json')
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
                    $(document).on('click','#center',function(){
                        $.get("{{host}}common/checklog",{},function( data ){
                            if(data == 0) {
                                window.location.href = '{{host}}login/login'    
                            } else {
                                window.location.href = '{{host}}index/self'
                            }
                        })        
                    })
	    </script>
	</div>
</body>
</html>
