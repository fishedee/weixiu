<?php require(__DIR__."/../common/header.php"); ?>
<!-- 查询窗口 -->
<form id="user-form" class="form-inline">
    名称：
    <input type="text" name="name" class="input-small"/>
	备注：
    <input type="text" name="remark" class="input-small"/>
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
    <button class="btn add">添加类目</button>
    <div id="table"></div>
</div>
<div>
</div>

<script>
function view(categoryId){
	_href('/category/view.html?categoryId=' + categoryId);
}
function add(){
	_href('/category/view.html');
}
function get(params){
	var fields = {
		categoryId:"类目ID",
        name: '名称',
        remark: '备注',
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
				return "<a href='#' class='_edit'>编辑</a>"
			}
		}
    };
    _table('/category/search', {params:params,key_index: 'categoryId', data: 'data', fields: fields}, function(){
        $("._edit").click(function(){
            var categoryId = $.trim($(this).parent().parent().find(".categoryId").text());
            view(categoryId);
        });
    });
}
$(function(){
	$(".query").click(function(){
		 get({
			name:$("input[name=name]").val(),
			remark:$("input[name=remark]").val(),
			state:$("select[name=state]").val()
	   });
	});

    $(".add").click(function(){
       add();
    });
	
	get({});
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
