<?php require(__DIR__."/../common/header.php"); ?>
<!-- 查询窗口 -->
<form id="user-form" class="form-inline">
    姓名：
    <input type="text" name="name" class="input-small"/>
	类型：
    <select name="type">
		<option value="">请选择类型</option>
		<option value="0">管理员</option>
		<option value="1">普通会员</option>
    </select>
	状态：
    <select name="state">
		<option value="">请选择状态</option>
		<option value="0">可用</option>
		<option value="1">不可用</option>
    </select>
    <button type="button" class="btn query">查询</button>
    <button type="reset" class="btn">重置</button>
</form>
<div class="m10">
    <button class="btn add">添加用户</button>
    <div id="table"></div>
</div>
<div>
</div>

<script>
function del(userId){
	$.post("/user/del",{userId:userId},function(data){
		var data = JSON.parse(data);
        if(data.code == 0){
			dt.refresh(); 
		}
	});
}
function view(userId){
	_href('/user/view.html?userId=' + userId);
}
function modPass(userId){
	_href('/user/password.html?userId=' + userId);
}
function add(){
	_href('/user/view.html');
}
function get(params){
	var fields = {
		userId:"用户ID",
        name: '姓名',
        password: '密码',
		type: {
			name:'类型',
			format:function(data){
				var m = {0:"管理员",1:"普通用户"};
				return m[data];
			}
		},
		state: {
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
				return "<a href='#' class='_edit'>编辑</a>&nbsp;<a href='#' class='_modpass'>修改密码</a>"
			}
		}
    };
    _table('/user/search', { key_index: 'userId', data: 'data', fields: fields,params:params}, function(){
        $("._edit").unbind("click").click(function(){
            var userId = $.trim($(this).parent().parent().find(".userId").text());
            view(userId);
        });
        $("._modpass").unbind("click").click(function(){
            var userId = $.trim($(this).parent().parent().find(".userId").text());
			modPass(userId);
        });
    });
}
$(function(){
	$(".query").unbind("click").click(function(){
       get({
			name:$("input[name=name]").val(),
			type:$("select[name=type]").val(),
			state:$("select[name=state]").val()
	   });
    });
    $(".add").unbind("click").click(function(){
       add();
    });
	get();
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
