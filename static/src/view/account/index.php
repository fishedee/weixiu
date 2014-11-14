<?php require(__DIR__."/../common/header.php"); ?>
<!-- 查询窗口 -->
<form id="user-form" class="form-inline">
    名称：
    <input type="text" name="name" class="input-small"/>
	金额：
    <input type="text" name="money" class="input-small"/>
	备注：
    <input type="text" name="remark" class="input-small"/>
	分类：
    <select name="categoryId" class="category">
		<option value="">请选择分类</option>
	</select>
	类型：
	<select name="type">
		<option value="">请选择类型</option>
		<option value="0">收入</option>
		<option value="1">支出</option>
	</select>
	状态：
	<select name="type">
		<option value="">请选择状态</option>
		<option value="0">可用</option>
		<option value="1">不可用</option>
	</select>
    <button type="button" class="btn query">查询</button>
    <button type="reset" class="btn">重置</button>
</form>
<div class="m10">
    <button class="btn add">添加账目</button>
    <div id="table"></div>
</div>
<div>
</div>

<script>
function getCategory(fun){
	$.get("/category/getAll",{},function(data){
		data = JSON.parse(data);
		if( data.code != 0 )
			return;
		var categorys = data.data;
		for( var i in categorys ){
			var option = $('<option value="'+categorys[i].categoryId+'">'+categorys[i].name+'</option>');
			$(".category").append(option);
		}
		
		if( fun )
			fun();
	});
}
function view(accountId){
	_href('/account/view.html?accountId=' + accountId);
}
function add(){
	_href('/account/view.html');
}
function get(params){
	var fields = {
		accountId:"账目ID",
        name: '名称',
		money:'金额',
        remark: '备注',
		categoryName:"分类",
		type:{
			name:'类型',
			format:function(data){
				var m = {0:"收入",1:"支出"};
				return m[data];
			}
		},
        state:{
			name:'状态',
			format:function(data){
				var m = {0:"可用",1:"不可用"};
				return m[data];
			}
		},
        createTime: '创建时间',
        modifyTime: '修改时间',
        oper:{
			name:'操作',
			format:function(data){
				return "<a href='#' class='_edit'>编辑</a>"
			}
		}
    };
    _table('/account/search', {params:params,key_index: 'accountId', data: 'data', fields: fields}, function(){
        $("._edit").click(function(){
            var accountId = $.trim($(this).parent().parent().find(".accountId").text());
            view(accountId);
        });
    });
}
$(function(){
	getCategory(function(){
		$(".query").unbind("click").click(function(){
		   get({
				name:$("input[name=name]").val(),
				money:$("input[name=money]").val(),
				remark:$("input[name=remark]").val(),
				categoryId:$("select[name=categoryId]").val(),
				type:$("select[name=type]").val(),
				state:$("select[name=state]").val()
		   });
		});
		$(".add").click(function(){
		   add();
		});
		get();
	});
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
