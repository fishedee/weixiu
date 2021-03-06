<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>微秀后台管理系统</title>
</head>
<body class="definewidth m10">
	<div id="container">
	</div>
	<script type="text/javascript" src="/js/uedit/ueditor.config.js?t=<?php echo time();?>" charset="utf-8"></script>
	<script type="text/javascript" src="/js/uedit/ueditor.all.min.js?t=<?php echo time();?>" charset="utf-8"></script>
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
		seajs.use(['lib/global','ui/input','ui/query','ui/dialog','ui/subPage'],function($,input,query,dialog,subPage){
			var articleId = $.location.getQueryArgv('articleId');
			function goInput(value,templateMap){

				input.verticalInput({
					id:'container',
					field:[
						{id:'title',type:'text',name:'标题'},
						{id:'templateId',type:'enum',name:'模板',map:templateMap},
						{id:'sound',type:'file',name:'音乐',url:'/upload/music'},
						{id:'content',type:'simpleEditor',name:'内容'},
						{id:'remark',type:'text',name:'备注'},
						{id:'state',type:'enum',name:'状态',map:{'0':'可用','1':'不可用'}},
					],
					value:value,
					submit:function(data){
						data = $.extend({articleId:articleId},data);
						$.post('/article/mod',data,function(data){
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
			}
			function go(templateMap){

				$.get('/article/get',{articleId:articleId},function(data){

					data = $.JSON.parse(data);
					if( data.code != 0 ){
						dialog.message(data.msg);
						return;
					}

					goInput(data.data,templateMap);
				});
			}
			$.get('/template/search',{state:0},function(data){
				data = $.JSON.parse(data);
				if( data.code != 0 ){
					dialog.message(data.msg);
					return;
				}
				var map = {};
				for( var i in data.data.data ){
					var item = data.data.data[i];
					map[item.templateId] = item.name;
				}
				go(map);
			});
		});
	</script>
 </body>
</html>
