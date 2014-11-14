<?php require(__DIR__."/../common/header.php"); ?>
<form id="user-form" class="definewidth m20" >
<input type="hidden" name="_method" value="POST"/>
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td class="tableleft">姓名</td>
        <td><input type="text" name="name"/></td>
    </tr>
	<tr>
        <td class="tableleft">密码</td>
        <td><input type="text" name="password"/></td>
    </tr>
    <tr>
        <td class="tableleft">类型</td>
        <td>
        <select name="type">
            <option value="0">管理员</option>
            <option value="1">普通会员</option>
        </select>
        </td>
    </tr>
	<tr>
        <td class="tableleft">状态</td>
        <td>
        <select name="state">
            <option value="0">可用</option>
            <option value="1">不可用</option>
        </select>
        </td>
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

function get( userId ){
	$.get("/user/get",{userId:userId},function(data){
		data = JSON.parse(data);
		if( data.code != 0 )
			return;
		var data = data.data;
		$("input[name=name]").val(data.name);
		$("input[name=password]").val(data.password);
		$("select[name=type]").val(data.type);
		$("select[name=state]").val(data.state);
	});
}
function mod( userId ){
	var data = {
		userId:userId,
		type:$("select[name=type]").val(),
		state:$("select[name=state]").val()
	};
	$.post("/user/mod",data,function(data){
		data = JSON.parse(data);
		if( data.code == 0)
			_href("/user/index.html");
	});
}
function add(){
	var data = {
		name:$("input[name=name]").val(),
		password:$("input[name=password]").val(),
		type:$("select[name=type]").val(),
		state:$("select[name=state]").val()
	};
	$.post("/user/add?t="+Math.random(),data,function(data){
		data = JSON.parse(data);
		if( data.code == 0)
			_href("/user/index.html");
	});
}
$(function(){
    if( _get("userId") && _get("userId") != "null" ){
		$("input[name=name]").attr("readonly","true");
		$("input[name=password]").attr("readonly","true");
		get(_get("userId"));
		$(".submit").click(function(){
			mod(_get("userId"));		
		});
	}else{
		$(".submit").click(function(){
			add();
		});
	}
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
