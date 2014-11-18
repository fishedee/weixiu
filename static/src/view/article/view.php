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
		seajs.use(['lib/global','ui/input','ui/query','ui/dialog','ui/subPage'],function($,input,query,dialog,subPage){
			var articleId = $.location.getQueryArgv('articleId');
			function goTable(){
				$('#articleContent').empty();
				query.simpleQuery({
					id:'articleContent',
					url:'/articlecontent/search',
					column:[
						{id:'articleContentId',type:'text',name:'文章内容ID'},
						{id:'type',type:'enum',name:'类型',map:{'0':'文字','1':'图片'}},
						{id:'data',type:'text',name:'数据'},
						{id:'weight',type:'text',name:'排序权重'},
						{id:'createTime',type:'text',name:'创建时间'},
						{id:'modifyTime',type:'text',name:'修改时间'},
					],
					params:{articleId:articleId,state:0},
					queryColumn:[],
					operate:[
					{
						name:'编辑',
						click:function(data){
							if( data.type == '文字'){
								subPage.open({
									title:'请编辑文字',
									url:'viewText.html?articleContentId='+data.articleContentId,
									close:function(){
										goTable();
									}
								});
							}else{
								subPage.open({
									title:'请编辑图片',
									url:'viewImage.html?articleContentId='+data.articleContentId,
									close:function(){
										goTable();
									}
								});
							}
						}
					},
					{
						name:'删除',
						click:function(data){
							dialog.confirm('是否删除'+data.articleContentId+"的数据",function(){
								var postData = {
									articleContentId:data.articleContentId,
									type:data.type,
									data:data.data,
									weight:data.weight,
									state:1,
								};
								$.post('/articlecontent/mod',postData,function(data){
									data = $.JSON.parse(data);
									if( data.code != 0 ){
										dialog.message(data.msg);
										return;
									}
									goTable();
								});
							});
						}
					}],
					button:[
					{
						name:'添加文字',
						click:function(){
							subPage.open({
								title:'请添加文字',
								url:'viewText.html?articleId='+articleId,
								close:function(){
									goTable();
								}
							});
						}
					},
					{
						name:'添加图片',
						click:function(){
							subPage.open({
								title:'请添加图片',
								url:'viewImage.html?articleId='+articleId,
								close:function(){
									goTable();
								}
							});
						}
					}
					],
				});
			}
			function goInput(value,templateMap){
				input.verticalInput({
					id:'container',
					field:[
						{id:'title',type:'text',name:'标题'},
						{id:'templateId',type:'enum',name:'模板',map:templateMap},
						{id:'content',type:'unknown',name:'内容',targetId:'articleContent'},
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
				goTable();
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