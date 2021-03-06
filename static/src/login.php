<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>微秀后台管理系统</title>
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
		seajs.use(['ui/loginPage','ui/dialog','lib/global'],function(loginPage,dialog,$){
			loginPage.use({
				title:'微秀后台管理系统',
				init:function(){
					$.get('/login/islogin?t='+Math.random(),{},function(data){
						data = $.JSON.parse(data);
						if( data.code == 0 ){
							location.href = 'index.html';
							return;
						}
					});
				},
				login:function(data){
					$.post('/login/checkin?t='+Math.random(),data,function(data){
						data = $.JSON.parse(data);
						if( data.code != 0 ){
							dialog.message(data.msg);
							return;
						}
						location.href = 'index.html';
					});
				}
			});
		});
	</script>
</body>
</html>
