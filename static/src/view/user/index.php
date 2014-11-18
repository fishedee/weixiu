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
			query.simpleQuery({
				id:'container',
				url:'/user/search',
				column:[
					{id:'userId',type:'text',name:'用户ID'},
					{id:'name',type:'text',name:'姓名'},
					{id:'type',type:'enum',name:'类型',map:{'0':'管理员','1':'普通会员'}},
					{id:'state',type:'enum',name:'状态',map:{'0':'可用','1':'不可用'}},
					{id:'createTime',type:'text',name:'创建时间'},
					{id:'modifyTime',type:'text',name:'修改时间'},
				],
				queryColumn:['name','type','state'],
				operate:[
				{
					name:'编辑',
					click:function(data){
						location.href = 'view.html?userId='+data.userId;
					}
				},
				{
					name:'修改密码',
					click:function(data){
						location.href = 'modPass.html?userId='+data.userId;
					}
				}],
				button:[
				{
					name:'添加用户',
					click:function(){
						location.href = 'add.html';
					}
				}
				],
			});
		});
	</script>
 </body>
</html>
