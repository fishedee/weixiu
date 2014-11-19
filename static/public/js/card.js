function goguanzhu(){
	location.href = 'http://mp.weixin.qq.com/mp/appmsg/show?__biz=MzA4NjAwOTQzNg==&appmsgid=201769864&itemidx=1&sign=5fc0601498fa5c2c6475bb187c21d049#wechat_redirect';
}
function fillData(option){
	function getQueryArgv(name){
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
		var r = decodeURI(window.location.search).substr(1).match(reg);
		if (r != null) 
			return unescape(r[2]); 
		return null;
	};
	//处理option
	var defaultOption = {
		id:getQueryArgv('articleId'),
		type:'normal',
		titleTarget:'',
		timeTarget:'',
		contentTarget:'',
	};
	for( var i in option )
		defaultOption[i] = option[i];
	//模块函数
	function getArticleContentData(fun){
		$.get('/articlecontent/search',{articleId:defaultOption.id,state:0},function(data){
			data = JSON.parse(data);
			if( data.code != 0 ){
				alert(data.msg);
				return;
			}
			fun(data.data.data);
		});
	}
	function getArticleData(fun){
		$.get('/article/get',{articleId:defaultOption.id},function(data){
			data = JSON.parse(data);
			if( data.code != 0 ){
				alert(data.msg);
				return;
			}
			fun(data.data);
		});
	}
	function normalRender(data){
		$(defaultOption.titleTarget).text(data.title);
		$(defaultOption.timeTarget).text(data.createTime);
		var content = "";
		for( var i in data.content ){
			var singleContent = data.content[i];
			if( singleContent.type == 0 ){
				content += '<p class="text-c1" style="text-indent:2em;">'+singleContent.data+'<br></p>';
			}else{
				content += '<p style="text-align:center;"><img class="img-c1"  src="'+singleContent.data+'"></p>';
			}
		}
		$(defaultOption.contentTarget).html(content);
	}
	function render(data){
		if( defaultOption.type == 'normal')
			normalRender(data);
	}
	//入口函数
	if( defaultOption.id == null ){
		alert('缺少articleId参数');
		return;
	}
	var article;
	getArticleData(function(data1){
		article = data1;
		getArticleContentData(function(data2){
			article.content = data2;
			render(article);
		});
	});
}