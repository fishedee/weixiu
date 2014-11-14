<?php require(__DIR__."/../common/header.php"); ?>
<form id="user-form" class="form-inline">
    起始时间：
	<input id="beginTime" type="text" name="beginTime"class="beginTime input-small"> 
	结束时间：
	<input id="endTime" type="text" name="endTime" class="endTime input-small"/>
	选择：
    <select name="state" class="selector">
		<option value="0">最近一个月</option>
		<option value="1">最近三个月</option>
		<option value="2">最近半年</option>
		<option value="3">最近一年</option>
    </select>
    <button type="button" class="btn query">查询</button>
</form>
<table class="table table-bordered table-hover definewidth m10 type0">
	<tr>
		<th colspan="3">收入成分表</th>
	</tr>
	<tr>
        <th>类目</th>
		<th>价格</th>
		<th>占比</th>
    </tr>
</table>
<table class="table table-bordered table-hover definewidth m10 type1">
	<tr>
		<th colspan="3">支出成分表</th>
	</tr>
	<tr>
        <th>类目</th>
		<th>价格</th>
		<th>占比</th>
    </tr>
</table>
<script>
	function setDate(){
		function setValue( value ){
			var beginTime = new Date();
			var endTime = new Date();
			var month = new Date().getMonth(); 
			if( value == 0 ){
				beginTime.setDate( 1 );
			}else if( value == 1 ){
				beginTime.setDate( 1 );
				beginTime.setMonth( month - 2 );
			}else if( value == 2 ){
				beginTime.setDate( 1 );
				beginTime.setMonth( month - 5 );
			}else{
				beginTime.setDate( 1 );
				beginTime.setMonth( 0 );
			}
			$('.beginTime').val(beginTime.format('yyyy-MM-dd'));
			$('.endTime').val(endTime.format('yyyy-MM-dd'));
		}
		$('#beginTime').datetimepicker({
			lang:'ch',
			timepicker:false,
			format: 'Y-m-d',
			closeOnDateSelect:true
		});
		$('#endTime').datetimepicker({
			lang:'ch',
			timepicker:false,
			format: 'Y-m-d',
			closeOnDateSelect:true
		});
		$('.selector').change(function(){
			var value = $('.selector').val();
			setValue(value);
		});
		setValue(0);
	}
	function getValue(){
		var beginTime = $('.beginTime').val();
		var endTime = $('.endTime').val();
		$('.type1').find('.item').remove();
		$('.type0').find('.item').remove();
		$.get('/statistics/payComponents',{beginTime:beginTime,endTime:endTime},function(data){
			data = JSON.parse(data);
			if( data.code != 0 )
				return ;
			for( var single in data.data ){
				var table = $('.type'+single);
				var data2 = data.data[single];
				for( var item in data2 ){
					var div = '<tr class="item">' +
						'<td>'+data2[item].categoryName+'</td>'+
						'<td>'+data2[item].money+'</td>'+
						'<td>'+data2[item].percentage+'%</td>'+
					'</tr>';
					table.append($(div));
				}
			}
		});
	}
	$(function(){
		setDate();
		getValue();
		$('.query').click(function(){
			getValue();
		});
	});
</script>
<?php require(__DIR__."/../common/footer.php"); ?>
