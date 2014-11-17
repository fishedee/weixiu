<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>微秀后台管理系统</title>
</head>
<body class="definewidth m10">
	<div id="container">
	</div>
	<script type="text/javascript" src="/js/sea.js?t=<?php echo time();?>" charset="utf-8"></script>
	<script type="text/javascript" src="/js/sea-css.js?t=<?php echo time();?>" charset="utf-8"></script>
	<script type="text/javascript">
		seajs.config({
			charset: 'utf-8',
			timeout: 20000,
			map:[
				[ /^(.*\.(js|css))(.*)$/i, '$1?t=<?php echo time();?>' ],
			]
		});
		seajs.use(['lib/global','ui/input','ui/dialog'],function($,input,dialog){
			var userId = $.location.getQueryArgv('userId');
			$.get('/user/get',{userId:userId},function(data){
				data = $.JSON.parse(data);
				if( data.code != 0 ){
					dialog.message(data.msg);
					return;
				}
				data = data.data;
				input.verticalInput({
					id:'container',
					field:[
						{id:'name',type:'read',name:'姓名'},
						{id:'password',type:'text',name:'新密码'},
					],
					value:{
						name:data.name
					},
					submit:function(data){
						data = $.extend({userId:userId},{password:data.password});
						$.post('/user/modPassword',data,function(data){
							data = $.JSON.parse(data);
							if( data.code != 0 ){
								dialog.message(data.msg);
								return;
							}
							location.href = 'index.html';
							
						});
					},
					cancel:function(){
						location.href = 'index.html';
					}
				});
			});
		});
	</script>
 </body>
</html>
