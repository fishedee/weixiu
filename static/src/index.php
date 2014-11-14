<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>微秀后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="css/common.css?t=<?php echo time();?>"/>
</head>
<body>
	<script type="text/javascript" src="js/sea.js?t=<?php echo time();?>" charset="utf-8"></script>
	<script type="text/javascript" src="js/sea-css.js?t=<?php echo time();?>" charset="utf-8"></script>
	<script type="text/javascript">
		seajs.config({
			charset: 'utf-8',
			timeout: 20000,
			map:[
				[ /^(.*\.(js|css))(.*)$/i, '$1?t=<?php echo time();?>' ],
			]
		});
		seajs.use(['ui/indexPage','ui/dialog','lib/global'],function(indexPage,dialog,$){
			indexPage.use({
				title:'微秀后台管理系统',
				init:function(){
					$.get('/login/islogin?t='+Math.random(),{},function(data){
						data = $.JSON.parse(data);
						if( data.code != 0 ){
							location.href = 'login.html';
							return;
						}
					});
				},
				logout:function(){
					$.get('/login/checkout?t='+Math.random(),{},function(data){
						data = $.JSON.parse(data);
						if( data.code != 0 ){
							dialog.message(data.msg);
							return;
						}
						location.href = 'login.html';
					});
				},
				menu:{
					'系统管理':[
						{name:'帐号管理',url:'http://wx.hongbeibang.com/backstage/view/user/index.html'},
						{name:'密码管理',url:'http://wx.hongbeibang.com/backstage/view/password/index.html'}
					],
					'社区管理':[
						{name:'帐号管理',url:'http://wx.hongbeibang.com/backstage/view/user/index.html'},
						{name:'密码管理',url:'http://wx.hongbeibang.com/backstage/view/password/index.html'}
					],
				}
			});
		});
	</script>
 </body>
</html>
