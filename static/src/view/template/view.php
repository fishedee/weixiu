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
			var templateId = $.location.getQueryArgv('templateId');
			function go(value){
				input.verticalInput({
					id:'container',
					field:[
						{id:'name',type:'text',name:'名字'},
						{id:'url',type:'text',name:'链接'},
						{id:'remark',type:'text',name:'备注'},
						{id:'state',type:'enum',name:'状态',map:{'0':'可用','1':'不可用'}},
					],
					value:value,
					submit:function(data){
						if( templateId != null ){
							data = $.extend({templateId:templateId},data);
							$.post('/template/mod',data,function(data){
								data = $.JSON.parse(data);
								if( data.code != 0 ){
									dialog.message(data.msg);
									return;
								}
								location.href = 'index.html';
							});
						}else{
							$.post('/template/add',data,function(data){
								data = $.JSON.parse(data);
								if( data.code != 0 ){
									dialog.message(data.msg);
									return;
								}
								location.href = 'index.html';
							});
						}
					},
					cancel:function(){
						location.href = 'index.html';
					}
				});
			}
			if( templateId != null ){
				$.get('/template/get',{templateId:templateId},function(data){
					data = $.JSON.parse(data);
					if( data.code != 0 ){
						dialog.message(data.msg);
						return;
					}
					go(data.data);
				});
			}else{
				go({});
			}
		});
	</script>
 </body>
</html>
