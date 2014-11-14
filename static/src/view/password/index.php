<?php require(__DIR__."/../common/header.php"); ?>
<form id="user-form" class="definewidth m20" >
<input type="hidden" name="_method" value="POST"/>
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td class="tableleft">原密码</td>
        <td><input type="password" name="oldpassword"/></td>
    </tr>
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
        </td>
    </tr>
</table>
</form>
<script>

function mod(){
	var oldpass = $("input[name=oldpassword]").val();
	var newpass1 = $("input[name=newpassword]").val();
	var newpass2 = $("input[name=newpassword2]").val();
	if( newpass1 != newpass2 ){
		_dialog("新密码两次输入不一致！");
		return;
	}
	
	var data = {
		oldpassword:oldpass,
		newpassword:newpass2
	};
	$.post("/password/mod",data,function(data){
		data = JSON.parse(data);
		if( data.code == 0)
			_dialog("修改密码成功");
	});
}
$(function(){
	$(".submit").click(function(){
		mod();
	});
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
