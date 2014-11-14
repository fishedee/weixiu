<?php require(__DIR__."/../common/header.php"); ?>
<form id="user-form" class="definewidth m20" >
<input type="hidden" name="_method" value="POST"/>
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td class="tableleft">名称</td>
        <td><input type="text" name="name"/></td>
    </tr>
	<tr>
        <td class="tableleft">性别</td>
        <td>
        <select name="sex">
            <option value="0">男</option>
            <option value="1">女</option>
        </select>
        </td>
    </tr>
	<tr>
        <td class="tableleft">生日</td>
        <td><input type="text" name="birthday"/></td>
    </tr>
    <tr>
        <td class="tableleft">备注</td>
        <td><input type="text" name="remark"/></td>
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
function add(){
	var data = {
		name:$("input[name=name]").val(),
		sex:$("select[name=sex]").val(),
		birthday:$("input[name=birthday]").val(),
		remark:$("input[name=remark]").val(),
		state:$("select[name=state]").val(),
	};
	$.post("/people/add",data,function(data){
		data = JSON.parse(data);
		if( data.code == 0)
			_href("/people/index.html");
	});
}
$(function(){
	$('input[name=birthday]').datetimepicker({
		lang:'ch',
		timepicker:false,
		format: 'Y-m-d',
		closeOnDateSelect:true
	});
	$(".submit").click(function(){
		add();
	});
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
