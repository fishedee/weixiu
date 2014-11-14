<?php require(__DIR__."/../common/header.php"); ?>
<button type="button" class="btn btn-primary components" >收支成分统计表</button>
<button type="button" class="btn btn-primary history" >收支走势统计表</button>
<script>
$(function(){
	$(".components").click(function(){
		_href('/statistics/components.html');
	});
	$(".history").click(function(){
		_href('/statistics/history.html');
	});
});

</script>
<?php require(__DIR__."/../common/footer.php"); ?>
