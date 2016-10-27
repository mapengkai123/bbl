<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>帮帮乐</title>
</head>

<!-- 地图样式 -->
<style type="text/css">
	body, html {width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
	#allmap{width:100%;height:100%;}
	p{margin-left:5px; font-size:14px;}
</style>

<!-- 地图ak -->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ERtymnt2XAAWdaDdLGE60jqk0pm4Q4kT"></script>

<!-- 遮罩层样式 -->
<style type="text/css">     
    .mask {       
            position: absolute; top: 0px; filter: alpha(opacity=60); background-color: #777;     
            z-index: 1002; left: 0px;     
            -moz-opacity:0.5;     
        } 
</style>
<body>
	<div class="loading"><img src="{{host}}public/images/ajax-loader.gif"/></div>
	<!-- 遮罩层 -->
	<div id="mask" class="mask" style="display:none;">
		<div id="allmap"></div>
	</div>
	<div data-role="page" class="touzi" id="touzi">
		<!--jqmb需要把所以东西放在page div内-->
		 <link rel="stylesheet" href="{{host}}public/css/jquery.mobile-1.4.5.min.css"/>
   		 <link rel="stylesheet" href="{{host}}public/css/style.css"/>
   		 
   		<!--jqmb需要把所以东西放在page div内--> 
		<header data-role="header" data-position="fixed" data-tap-toggle="false">
			<a href="{{host}}index/index" data-ajax="false" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a>
			<h3>发单</h3>
		</header>
		<div class="ui-content" data-role="content">
			 <div data-role="main" class="ui-content">
			    <form method="post" action="{{host}}lists/add_lists" data-ajax="false" onsubmit="return check_submit()">
			      <div class="ui-field-contain">
			        <label for="fullname">标题：</label>
			        <input type="text" name="title" id="title" onblur="check_title(this)">
			        <label for="fullname">详情：</label>
			        <textarea name="content" id="content" onblur="check_content(this)" cols="30" rows="10"></textarea>
			        <label for="fullname">个人联系方式</label>
			        <input type="text" name="call" id="call"onmousedown="check_call(this)" onkeyup="check_call(this)">
					<label for="fullname">本单金额：</label>
			        <input type="text" name="list_money" id="list_money" onblur="check_list_money()">
			        <label for="fullname">标违约金额：</label>
			        <input type="text" name="violate_money" id="violate_money" onblur="check_violate_money()">
			        <input type="button" name="fullname" class="showMask" status="0" value="任务地址">
			        <input type="text" name="address" id="address" readOnly="true" onblur="check_address()">
			        <label for="fullname">任务详细地址：</label>
			        <input type="text" name="s_address" id="s_address" onblur="check_s_address()">
			        <input type="button" name="fullname" class="showMask" status="1" value="约定交易地址">
			        <input type="text" name="end_address" id="end_address" readOnly="true" onblur="check_end_address()">
			        <label for="fullname">约定交易详细地址：</label>
			        <input type="text" name="s_end_address" id="s_end_address" onblur="check_s_end_address()">
			        <label for="bday">结束时间：</label>
			        <input type="datetime" name="end_time" id="end_time" onblur="check_end_time()" class="sang_Calender">
			        <input type="hidden" name="mission" id="mission">
			        <input type="hidden" name="finish" id="finish">
			      </div>
			      <input type="submit" data-inline="true" id="btn" value="提交">
			    </form>
			  </div>
			</div>
		</div>
		<script src="{{host}}public/js/jquery.min.js"></script>
   		<script src="{{host}}public/js/jquery.mobile-1.4.5.min.js"></script>
   		<script type="text/javascript" src="{{host}}public/js/datetime.js"></script>
   		<script type="text/javascript">
   			$(window).load(function(){
					$(".loading").fadeOut();
					//var id = 1;
					//location.href="{{host}}public/touzi.html?id=1";
				})
   		</script>
		<script>
			$("#end_address").click(function(){

			})
		</script>
<!--		<pre class="html" name="code">-->
            <script type="text/javascript">
			//定义status，如果0则任务地址，如果1交易完成地址
			var status;
		    //兼容火狐、IE8   
		    //显示遮罩层 
		    $(".showMask").click(function(){
		    	status = ($(this).attr('status'));
		        $("#mask").css("height",$(document).height());     
		        $("#mask").css("width",$(document).width());   
		        $("#mask").show();
		    })
		    //隐藏遮罩层  
		    function hideMask(){     
		          
		        $("#mask").hide();     
		    }

		</script>  
		<script>
			//获取经纬度
				$(function(){  
				  if (navigator.geolocation)  
					{  
					navigator.geolocation.getCurrentPosition(showPosition);  
					}  
				  else{x.innerHTML="Geolocation is not supported by this browser.";}  
				  
				})  
				// 百度地图API功能
				function showPosition(position)
				{
					// alert(position.coords.longitude)
					var map = new BMap.Map("allmap");
					map.centerAndZoom(new BMap.Point(position.coords.longitude,position.coords.latitude),8);
					setTimeout(function(){
						map.setZoom(14);   
					}, 2000);  //2秒后放大到14级
					map.enableScrollWheelZoom(true);
					
					map.addEventListener("click", function(e){ 
						//经纬度获取       
						// alert(e.point.lng + ", " + e.point.lat);
						$.get('http://api.map.baidu.com/geocoder/v2/?ak=ERtymnt2XAAWdaDdLGE60jqk0pm4Q4kT&callback=renderReverse&location='+e.point.lat+','+e.point.lng+'&output=json&pois=1',function(msg){
							if(status==0)
							{
								$("#mission").val(e.point.lng + "," + e.point.lat)
								$("#address").val(msg.result.formatted_address)
								$("#mask").hide();
							}else{
								$("#finish").val(e.point.lng + "," + e.point.lat)
								$("#end_address").val(msg.result.formatted_address)
								$("#mask").hide();
							}
						},'jsonp')
					});
					
					var geolocation = new BMap.Geolocation();
					geolocation.getCurrentPosition(function(r){
						if(this.getStatus() == BMAP_STATUS_SUCCESS){
							var mk = new BMap.Marker(r.point);
							map.addOverlay(mk);
							map.panTo(r.point);
//							alert('您的位置：'+r.point.lng+','+r.point.lat);
						}
						else {
							alert('failed'+this.getStatus());
						}        
					},{enableHighAccuracy: true})
				}
			$("#btn").click(function(){

			})
		</script>
		<script>
			//验证标题
			function check_title(title)
			{
				var title = document.getElementById('title');
				if(title.value=='')
				{
					title.style.border="1px solid red";
					return false;
				}else{
					title.style.border="1px solid green";
					return true;
				}
			}
			//验证内容
			function check_content(content)
			{
				var content = document.getElementById('content');
				if(content.value=='')
				{
					content.style.border="1px solid red";
					return false;
				}else{
					content.style.border="1px solid green";
					return true;
				}
			}
			//验证手机号
			function check_call(call)
			{
				var call = document.getElementById('call');
				var reg_call = /^1(3|5|7|8)\d{9}$/
				if(!reg_call.test(call.value))
				{
					call.style.border="1px solid red";
					return false;
				}else{
					call.style.border="1px solid green";
					return true;
				}
			}
			//时间判断
			function check_end_time(end_time)
			{
				var end_time = document.getElementById('end_time');
				if(end_time.value=='')
				{
					end_time.style.border="1px solid red";
					return false;
				}else{
					end_time.style.border="1px solid green";
					return true;
				}
			}
			//订单价格判断
			function check_list_money(list_money)
			{
				var list_money = document.getElementById('list_money');
				var reg_list_money = /^\d{1,4}$/
				if(!reg_list_money.test(list_money.value))
				{
					list_money.style.border="1px solid red";
					return false;
				}else{
					list_money.style.border="1px solid green";
					return true;
				}
			}
			//违约价格判断
			function check_violate_money(violate_money)
			{
				var violate_money = document.getElementById('violate_money');
				var reg_violate_money = /^\d{1,4}$/
				if(!reg_violate_money.test(violate_money.value))
				{
					violate_money.style.border="1px solid red";
					return false;
				}else{
					violate_money.style.border="1px solid green";
					return true;
				}
			}
			//任务地址判断
			function check_address(address)
			{
				var address = document.getElementById('address');
				if(address.value=='')
				{
					address.style.border="1px solid red";
					return false;
				}else{
					address.style.border="1px solid green";
					return true;
				}
			}
			//任务详细地址
			function check_s_address(s_address)
			{
				var s_address = document.getElementById('s_address');
				if(s_address.value=='')
				{
					s_address.style.border="1px solid red";
					return false;
				}else{
					s_address.style.border="1px solid green";
					return true;
				}
			}
			//约定交易地址判断
			function check_end_address(end_address)
			{
				var end_address = document.getElementById('end_address');
				if(end_address.value=='')
				{
					end_address.style.border="1px solid red";
					return false;
				}else{
					end_address.style.border="1px solid green";
					return true;
				}
			}
			//约定交易详细地址判断
			function check_s_end_address(s_end_address)
			{
				var s_end_address = document.getElementById('s_end_address');
				if(end_address.value=='')
				{
					s_end_address.style.border="1px solid red";
					return false;
				}else{
					s_end_address.style.border="1px solid green";
					return true;
				}
			}
			function check_submit()
			{
				if(check_title()&check_content()&check_call()&check_address()&check_s_address()&check_end_address()&check_s_end_address()&check_end_time()&check_list_money()&check_violate_money())
				{
					return true;
				}else{
					return false;
				}
			}
		</script>
	</div>
	
</body>
</html>