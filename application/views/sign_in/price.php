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
			<a href="{{host}}signIn/show" class="ui-btn ui-icon-carat-l ui-btn-icon-left ui-nodisc-icon" data-transition="slide" data-direction="revserse">返回</a> 
			<h3>个人获奖详情</h3>
		</header>
		<div class="ui-content" data-role="content"> 
		<!-- 自定义样式 -->
			<div id="content">
				<!-- <dl class="index-year" >
					<a href="month.html" data-transition="slide" data-ajax="false">
						<dd>
							<div style="float:left;width:60%;">
							<h4 rowspan='2'>娃娃</h4>
							</div>
							<div style="float:left; width:40%">
							<p style="float:none"><small>×</small>2</p>
							</div>
						</dd>
					</a>
				</dl> -->
			</div>
			<div id="allmap" style="display:none"></div>
		</div>
		<script src="{{host}}public/js/slick.min.js" ></script>
		<script>
			$(function(){
				$.get('{{host}}signIn/price_list',function(msg){
					var dl='';
					for(var i=0;i<msg.length;i++)
					{
						dl+='<dl class="index-year" >\
								<a href="#" data-transition="slide" data-ajax="false">\
									<dd>\
										<div style="float:left;width:60%;">\
										<h4 rowspan="2">'+msg[i].g_name+'</h4>\
										</div>\
										<div style="float:left; width:40%">\
										<p style="float:none">×<small></small>'+msg[i].u_num+'</p>\
										</div>\
									</dd>\
								</a>\
							</dl>'
					}
					$("#content").html(dl)
				},'json')
			})
		</script>
		<script>
			$(function(){
				// var distance = $("#distance").value()
				// $.get('/lists/receive_list',{'distance':distance},function(msg){

				// })
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
