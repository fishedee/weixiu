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
        <td class="tableleft">联系方式</td>
        <td class="contact">
		</td>
    </tr>
	<tr>
        <td class="tableleft">事件</td>
        <td class="event">
		</td>
    </tr>
	<tr>
        <td class="tableleft">关系</td>
        <td class="relation">
			<button type="button" class="btn btn-primary addRelation">添加</button>
			<table>
				
			</table>
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
var contactTable;
var eventTable;
function setDataToUser(data){
	//设置基本信息
	$("input[name=name]").val(data.name);
	$("select[name=sex]").val(data.sex);
	$("input[name=birthday]").val(data.birthday);
	$('input[name=birthday]').datetimepicker({
		lang:'ch',
		timepicker:false,
		format: 'Y-m-d',
		closeOnDateSelect:true
	});
	$("input[name=remark]").val(data.remark);
	$("select[name=state]").val(data.state);
	//设置联系方式
	contactTable = _simpleUserTable({
		target:$('.contact'),
		column:[
			{
				text:'联系方式ID',
				name:'peopleContactId',
				type:'label'
			},
			{
				text:'名',
				name:'name',
				type:'text'
			},
			{
				text:'值',
				name:'value',
				type:'text'
			},
			{
				text:'备注',
				name:'remark',
				type:'text'
			},
			{
				text:'创建时间',
				name:'createTime',
				type:'label'
			},
			{
				text:'修改时间',
				name:'modifyTime',
				type:'label'
			},
		],
		data:data.contact,
	});
	//设置事件
	eventTable = _simpleUserTable({
		target:$('.event'),
		column:[
			{
				text:'事件ID',
				name:'peopleEventId',
				type:'label'
			},
			{
				text:'名字',
				name:'name',
				type:'text'
			},
			{
				text:'事件',
				name:'remark',
				type:'area'
			},
			{
				text:'创建时间',
				name:'createTime',
				type:'label'
			},
			{
				text:'修改时间',
				name:'modifyTime',
				type:'label'
			},
		],
		data:data.event,
	});
	//设置关系
	$(".addRelation").click(function(){
		_newDialogPage('请选择另外一个关系人','/view/people/index.html',function(result){
			alert("页面关闭了"+result);
		});
	});
}
function getDataFromUser(){
	data = {
		name:$("input[name=name]").val(),
		sex:$("select[name=sex]").val(),
		birthday:$("input[name=birthday]").val(),
		remark:$("input[name=remark]").val(),
		state:$("select[name=state]").val(),
		event:eventTable.get(),
		relation:[],
		contact:contactTable.get()
	};
	return data;
}
$(function(){
    peopleId = _get("peopleId");
	$.get('/people/get',{peopleId:peopleId},function(data){
		data = $.JSON.parse(data);
		if( data.code != 0 )
			return;
		setDataToUser(data.data);
	});
	$(".submit").click(function(){
		var data = getDataFromUser();
		data.peopleId = peopleId;
		console.log(data);
		$.post('/people/mod',data,function(data){
			data = $.JSON.parse(data);
			if( data.code != 0 )
				return;
			_href('/people/index.html');
		});
	});
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
