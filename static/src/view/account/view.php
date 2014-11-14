<?php require(__DIR__."/../common/header.php"); ?>
<form id="user-form" class="definewidth m20" >
<input type="hidden" name="_method" value="POST"/>
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td class="tableleft">名称</td>
        <td><input type="text" name="name"/></td>
    </tr>
	<tr>
        <td class="tableleft">金额</td>
        <td><input type="text" name="money"/></td>
    </tr>
    <tr>
        <td class="tableleft">备注</td>
        <td><input type="text" name="remark"/></td>
    </tr>
	<tr>
        <td class="tableleft">分类</td>
        <td>
        <select class="category" name="categoryId">
        </select>
        </td>
    </tr>
	<tr>
        <td class="tableleft">类型</td>
        <td>
        <select name="type">
            <option value="0">收入</option>
            <option value="1">支出</option>
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

function getCategory(fun){
	$.get("/category/getAll",{},function(data){
		data = JSON.parse(data);
		if( data.code != 0 )
			return;
		$(".category").empty();
		var categorys = data.data;
		for( var i in categorys ){
			var option = $('<option value="'+categorys[i].categoryId+'">'+categorys[i].name+'</option>');
			$(".category").append(option);
		}
		
		if( fun )
			fun();
	});
}
function get( accountId ){
	$.get("/account/get",{accountId:accountId},function(data){
		data = JSON.parse(data);
		if( data.code != 0 )
			return;
		var data = data.data;
		$("input[name=name]").val(data.name);
		$("input[name=money]").val(data.money);
		$("input[name=remark]").val(data.remark);
		$("select[name=categoryId]").val(data.categoryId);
		$("select[name=type]").val(data.type);
		$("select[name=state]").val(data.state);
	});
	
}
function mod( accountId ){
	var data = {
		accountId:accountId,
		name:$("input[name=name]").val(),
		money:$("input[name=money]").val(),
		remark:$("input[name=remark]").val(),
		categoryId:$("select[name=categoryId]").val(),
		type:$("select[name=type]").val(),
		state:$("select[name=state]").val()
	};
	$.post("/account/mod",data,function(data){
		data = JSON.parse(data);
		if( data.code == 0)
			_href("/account/index.html");
	});
}
function add(){
	var data = {
		name:$("input[name=name]").val(),
		money:$("input[name=money]").val(),
		remark:$("input[name=remark]").val(),
		categoryId:$("select[name=categoryId]").val(),
		type:$("select[name=type]").val(),
		state:$("select[name=state]").val()
	};
	$.post("/account/add",data,function(data){
		data = JSON.parse(data);
		if( data.code == 0)
			_href("/account/index.html");
	});
}
$(function(){
    if( _get("accountId") && _get("accountId") != "null" ){
		getCategory(function(){
			get(_get("accountId"));
		});
		$(".submit").click(function(){
			mod(_get("accountId"));		
		});
	}else{
		getCategory();
		$(".submit").click(function(){
			add();
		});
	}
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
