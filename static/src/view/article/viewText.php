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
		seajs.use(['lib/global','ui/input','ui/dialog','ui/subPage'],function($,input,dialog,subPage){
			var articleId = $.location.getQueryArgv('articleId');
			var articleContentId = $.location.getQueryArgv('articleContentId');
			function go(value){
				input.verticalInput({
					id:'container',
					field:[
						{id:'data',type:'area',name:'文本'},
						{id:'weight',type:'text',name:'权重'},
					],
					value:value,
					submit:function(data){
						if( articleContentId != null ){
							data = $.extend({articleContentId:articleContentId,type:0,state:0},data);
							$.post('/articlecontent/mod',data,function(data){
								data = $.JSON.parse(data);
								if( data.code != 0 ){
									dialog.message(data.msg);
									return;
								}
								subPage.close();
							});
						}else{
							console.log(data);
							data = $.extend({articleId:articleId,type:0},data);
							$.post('/articlecontent/add',data,function(data){
								data = $.JSON.parse(data);
								if( data.code != 0 ){
									dialog.message(data.msg);
									return;
								}
								subPage.close();
							});
						}
					},
					cancel:function(){
						subPage.close();
					}
				});
			}
			if( articleContentId != null ){
				$.get('/articlecontent/get',{articleContentId:articleContentId},function(data){
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
