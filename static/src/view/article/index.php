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
		seajs.use(['lib/global','ui/query','ui/dialog'],function($,query,dialog){
			function go(templateMap){
				query.simpleQuery({
					id:'container',
					url:'/article/search',
					column:[
						{id:'articleId',type:'text',name:'文章ID'},
						{id:'title',type:'text',name:'标题'},
						{id:'templateId',type:'enum',name:'模板',map:templateMap},
						{id:'remark',type:'text',name:'备注'},
						{id:'state',type:'enum',name:'状态',map:{'0':'可用','1':'不可用'}},
						{id:'createTime',type:'text',name:'创建时间'},
						{id:'modifyTime',type:'text',name:'修改时间'},
					],
					queryColumn:['title','templateId','state'],
					operate:[
					{
						name:'编辑',
						click:function(data){
							location.href = 'view.html?articleId='+data.articleId;
						}
					},
					{
						name:'原文链接',
						click:function(data){
							window.open('/article/go?articleId='+data.articleId);
						}
					}],
					button:[
					{
						name:'添加文章',
						click:function(){
							location.href = 'add.html';
						}
					}
					],
				});
			}
			$.get('/template/search',{},function(data){
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
