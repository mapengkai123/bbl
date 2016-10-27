<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="{{host}}public/css/s_style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <script src="{{host}}public//js/jquery.min.js"></script>
	</head>
	<body>
		<div class="s_warp">
	
		<header class="s_header">
			<ul ui-sref="l_gerenzhongxin">
				<li><img src="{{host}}public/img/s_y_h1_03.png"/></li>
				<li>返回</li>
			</ul>
			<h1>帮帮乐</h1>
			<div class="header_right"><img src="{{host}}public/img/s_y_h1_06.png"/></div>
		</header>
		<section class="s_section">
			<div class="s_section_you">
				<h3><a href="javascript:void(0)" id="sign_in">签到</a><br><br>
					<a href="#">兑奖规则</a><br>
					<a href="{{host}}signIn/price">已兑换的商品</a>
				</h3>
				<p><img src="{{host}}public/img/s_sd.png"/></p>
				<ul>
					<li>呦,天气不错哦</li>
					<li>你一共签到<a href="#" style="color: black;"><span id="sum"></span></a>次</li>
					<li>你的值一共有<a href="#" style="color: black;"><span id="fen"></span></a>分</li>
					<li>已连续签到<a href="{{host}}public/" style="color: black;"><span id="day"></span></a>天</li>

					<!-- <li>你拥有<a href="{{host}}public/" style="color: black;">0</a>次的兑换机会</li> -->

				</ul>
			</div>
			<div class="s_section_jiang">
				<h1>签到奖品</h1>
				<div id="dll">
					<dl>
						<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
						<dd><a href="javascript:void(0)" class="change" ids="1">兑换</a></dd>
					</dl>
					<dl>
						<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
						<dd><a href="javascript:void(0)" class="change" ids="2">兑换</a></dd>
					</dl>
					<dl>
						<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
						<dd><a href="javascript:void(0)" class="change" ids="3">兑换</a></dd>
					</dl>
					<dl>
						<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
						<dd><a href="javascript:void(0)" class="change" ids="4">兑换</a></dd>
					</dl>
					<dl>
						<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
						<dd><a href="javascript:void(0)" class="change" ids="5">兑换</a></dd>
					</dl>
				</div>
				
			</div>
			<div class="s_section_jian">
				<h1>奖池</h1>
				<div id="dll">
					<dl>
					<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
					<dd><a href="{{host}}public/">ipones6s</a></dd>
				</dl>
				<dl>
					<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
					<dd><a href="{{host}}public/">ipones6s</a></dd>
				</dl>
				<dl>
					<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
					<dd><a href="{{host}}public/">ipones6s</a></dd>
				</dl>
				<dl>
					<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
					<dd><a href="{{host}}public/">ipones6s</a></dd>
				</dl>
				<dl>
					<dt><img src="{{host}}public/img/images/s_shou1_03.png"/></dt>
					<dd><a href="{{host}}public/">ipones6s</a></dd>
				</dl>
				</div>
				
			</div>
		</section>
		<footer class="s_footer">
			<!--<div class="aaa" ng-if='showbgg'>
				<h1>你目前没有兑换机会<br />成功采购1次,既可获得一次兑换机会!</h1>
				<button ng-click='showsss()' ui-sref='s_queren'>我知道了</button>
			</div>-->
			<!--<div class="know" ng-if='showbg'>
				<h1>签到规则</h1>
				<p>1.连续签到7日,我们将随机在奖池中为你分派一个可兑换的奖品;</p>
				<p>2.在平台上成功完成1次采购,你就可以在你的签到奖品中,免费兑换其它任何1个奖品.</p>
				<p>还等什么,快来签到和采购吧,iPone.iPad等你来领取哦!</p>
				<p>恩基云采平台拥有在法律允许范围内的最终解释权</p>
				<button ng-click='showas()' >我知道了</button>
			</div>-->
			<dl>
				<dt><img src="{{host}}public/img/s_y_f1_03.png"/></dt>
				<dd>首页</dd>
			</dl>
			<dl>
				<dt><img src="{{host}}public/img/s_y_f1_05.png"/></dt>
				<dd>方案车</dd>
			</dl>
			<dl>
				<dt><img src="{{host}}public/img/s_y_f1_07.png"/></dt>
				<dd>我</dd>
			</dl>
		</footer>
	</div>

	</body>
</html>
<script>
	$(function(){
		//查看签到次数
		$.get('{{host}}signIn/xiangqing',function(msg){
			$("#fen").html(msg.integral)
			$("#day").html(msg.day)
			$("#sum").html(msg.sum)
		},'json')

		//签到，判断是否已经签到
		$("#sign_in").click(function(){
			$.get('{{host}}signIn/add',function(msg){
				if(msg==0)
				{
					alert('今天已签到')
				}else{
					$("#day").html(msg.day)
				}
			},'json')
		})

		//奖品兑换
		$(".change").click(function(){
			var id = $(this).attr('ids')
			$.get('{{host}}signIn/exchange/id/'+id,function(msg){
				if(msg==0){
					alert('值不够，不能兑换')
				}else if(msg==1){
					alert('兑换信息出错')
				}else if(msg==2){
					alert('兑换成功')
				}
			})
		})
	})
</script>