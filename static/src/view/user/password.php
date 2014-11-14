<?php require(__DIR__."/../common/header.php"); ?>
<form id="user-form" class="definewidth m20" >
<input type="hidden" name="_method" value="POST"/>
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td class="tableleft">新密码</td>
        <td><input type="password" name="newpassword"/></td>
    </tr>
	<tr>
        <td class="tableleft">再次输入新密码</td>
        <td><input type="password" name="newpassword2"/></td>
    </tr>
	<tr>
        <td class="tableleft"></td>
        <td>
            <button type="button" class="btn btn-primary submit" >提交</button>
			<button type="button" class="btn btn-success" onclick="location.href='index.html'">返回列表</button>
        </td>
    </tr>
</table>
</form>
<script>

function mod(){
	var newpass1 = $("input[name=newpassword]").val();
	var newpass2 = $("input[name=newpassword2]").val();
	if( newpass1 != newpass2 ){
		_dialog("新密码两次输入不一致！");
		return;
	}
	
	var data = {
		userId:_get('userId'),
		password:newpass2
	};
	$.post("/user/modPassword",data,function(data){
		data = JSON.parse(data);
		if( data.code == 0)
			_href("/user/index.html");
	});
}
$(function(){
	$(".submit").click(function(){
		mod();
	});
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
