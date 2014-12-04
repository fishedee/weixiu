define('ui/input',['lib/global','ui/editor','ui/dialog'], function(require, exports, module){
	var $ = require('lib/global');
	var dialog = require('ui/dialog');
	var editor = require('ui/editor');
	return {
		flowInput:function( option ){
			//处理option
			var defaultOption = {
				id:'',
				field:[],
				submit:function(){
				},
			};
			for( var i in option )
				defaultOption[i] = option[i];
			if( defaultOption.field.length == 0 )
				return;
			var div = "";
			//基本框架
			for( var i in defaultOption.field ){
				var field = defaultOption.field[i];
				if( field.type == 'text'){
					div += '<span>&nbsp;'+field.name+'：</span>' + '<input type="text" name="'+field.id+'" class="input-small"/>';
				}else if( field.type == 'enum'){
					var option = "";
					if( typeof field.map[""] != 'undefined')
						option += '<option value="">'+field.map[""]+'</option>';
					for( var j in field.map ){
						if( j != "")
							option += '<option value="'+j+'">'+field.map[j]+'</option>';
					}
					div += '<span>&nbsp;'+field.name+'：</span>' + '<select name="'+field.id+'">'+option+'</select>';
				}
			}
			div += '<button type="button" class="btn query">查询</button>'+
				'<button type="reset" class="btn">重置</button>';
			div = $(div);
			//加入页面
			$('#'+defaultOption.id).append(div);
			//挂载事件
			$('#'+defaultOption.id).find('.query').click(function(){
				var data = {};
				for( var i in defaultOption.field ){
					var field = defaultOption.field[i];
					if( field.type == 'text'){
						data[field.id] = $.trim($('#'+defaultOption.id).find('input[name='+field.id+']').val());
					}else if( field.type == 'enum'){
						data[field.id] = $.trim($('#'+defaultOption.id).find('select[name='+field.id+']').val());
					}
				}
				defaultOption.submit(data);
			});
		},
		verticalInput:function( option ){
			//处理option
			var defaultOption = {
				id:'',
				field:[],
				value:{},
				submit:function(){
				},
				cancel:function(){
				}
			};
			for( var i in option )
				defaultOption[i] = option[i];
			
			//执行业务逻辑
			var div = "";
			var contentDiv = "";
			for( var i in defaultOption.field ){
				var field = defaultOption.field[i];
				contentDiv += 
					'<tr>'+
						'<td class="tableleft">'+field.name+'</td>';
				if( typeof field.targetId != 'undefined'){
					contentDiv += '<td id="'+field.targetId+'">';
				}else{
					contentDiv += '<td>';
				}
				if( field.type == 'read'){
					contentDiv += '<div name="'+field.id+'"/>';
				}else if( field.type == 'simpleEditor'){
					field.editorTargetId = $.uniqueNum();
					contentDiv += '<div name="'+field.id+'" id="'+field.editorTargetId+'"/>';
				}else if( field.type == 'file'){
					field.fileTargetId = $.uniqueNum();
					field.fileTargetTipId = $.uniqueNum();
					contentDiv += '<div name="'+field.id+'"></div><input type="file" name="'+field.id+'" id="'+field.fileTargetId +'"/><span id="'+field.fileTargetTipId+'"></span>';
				}else if( field.type == 'image'){
					field.imageTargetId = $.uniqueNum();
					contentDiv += '<img name="'+field.id+'" src=""/><input type="file" name="'+field.id+'" accept="image/*" id="'+field.imageTargetId +'"/>';
				}else if( field.type == 'area'){
					contentDiv += '<textarea name="'+field.id+'" style="width:90%;height:300px;"></textarea>';
				}else if( field.type == 'text'){
					contentDiv += '<input type="text" name="'+field.id+'"/>';
				}else if( field.type == 'password'){
					contentDiv += '<input type="password" name="'+field.id+'"/>';
				}else if( field.type == 'enum'){
					var option = "";
					for( var j in field.map ){
						option += '<option value="'+j+'">'+field.map[j]+'</option>';
					}
					contentDiv += '<select name="'+field.id+'">'+option+'</select>';
				}
				contentDiv +=
					'</td>'+
				'</tr>';
			}
			div += '<table class="table table-bordered table-hover definewidth m10">'+
				contentDiv+
				'<tr>'+
					'<td class="tableleft"></td>'+
					'<td>'+
						'<button type="button" class="btn btn-primary submit" >提交</button>'+
						'<button type="button" class="btn btn-success cancel">返回列表</button>'+
					'</td>'+
				'</tr>'+
			'</table>';
			div = $(div);
			//插入到页面中
			$('#'+defaultOption.id).append(div);
			//挂载控件事件
			for( var i in defaultOption.field ){
				var field = defaultOption.field[i];
				if( field.type == 'image'){
					(function(field){
						div.find('input[name='+field.id+']').change(function(){
							$.ajaxFileUpload({
								url:field.url,
								secureuri:false,
								fileElementId:field.imageTargetId,
								dataType:'json',
								success: function (data, status){
									if( data.code != 0 ){
										dialog.message('上传文件失败:'+data.msg);
										return;
									}
									$('#'+defaultOption.id).find('img[name='+field.id+']').attr('src',data.data);
								},
								error:function(data,status,e){
									dialog.message('上传文件失败:'+data.status);
								}
							});
						});
					})(field);
				}else if( field.type == 'file'){
					(function(field){
						div.find('input[name='+field.id+']').change(function(){
							$('#'+field.fileTargetTipId).text('上传中');
							$.ajaxFileUpload({
								url:field.url,
								secureuri:false,
								fileElementId:field.fileTargetId,
								dataType:'json',
								success: function (data, status){
									if( data.code != 0 ){
										dialog.message('上传文件失败:'+data.msg);
										return;
									}
									$('#'+field.fileTargetTipId).text('上传成功');
									$('#'+defaultOption.id).find('div[name='+field.id+']').text(data.data);
								},
								error:function(data,status,e){
									$('#'+field.fileTargetTipId).text('上传失败');
									dialog.message('上传文件失败，请上传少于2M的文件并且符合mp3或midi格式');
								}
							});
						});
					})(field);
				}else if( field.type == 'simpleEditor'){
					field._editor = editor.simpleEditor({
						id:field.editorTargetId
					});
				}
			}
			//设置value
			for( var i in defaultOption.field ){
				var field = defaultOption.field[i];
				if( typeof defaultOption.value[field.id] == 'undefined' )
					continue;
				if( field.type == 'read')
					div.find('div[name='+field.id+']').text(defaultOption.value[field.id]);
				else if( field.type == 'simpleEditor')
					field._editor.setFormatData(defaultOption.value[field.id]);
				else if( field.type == 'file')
					div.find('div[name='+field.id+']').text(defaultOption.value[field.id]);
				else if( field.type == 'image')
					div.find('img[name='+field.id+']').attr("src",defaultOption.value[field.id]);
				else if( field.type == 'area')
					div.find('textarea[name='+field.id+']').val(defaultOption.value[field.id]);
				else if( field.type == 'text' || field.type == 'password')
					div.find('input[name='+field.id+']').val(defaultOption.value[field.id]);
				else if( field.type == 'enum')
					div.find('select[name='+field.id+']').val(defaultOption.value[field.id]);
			}
			//挂载事件
			div.find('.submit').click(function(){
				var data = {};
				for( var i in defaultOption.field ){
					var field = defaultOption.field[i];
					if( field.type == 'read'){
						data[field.id] = $.trim($('#'+defaultOption.id).find('div[name='+field.id+']').text());
					}else if( field.type == 'file'){
						data[field.id] = $.trim($('#'+defaultOption.id).find('div[name='+field.id+']').text());
					}else if( field.type == 'simpleEditor'){
						data[field.id] = field._editor.getFormatData();
					}else if( field.type == 'image'){
						data[field.id] = $.trim($('#'+defaultOption.id).find('img[name='+field.id+']').attr("src"));
					}else if( field.type == 'area'){
						data[field.id] = $.trim($('#'+defaultOption.id).find('textarea[name='+field.id+']').val());
					}else if( field.type == 'text' || field.type == 'password'){
						data[field.id] = $.trim($('#'+defaultOption.id).find('input[name='+field.id+']').val());
					}else if( field.type == 'enum'){
						data[field.id] = $.trim($('#'+defaultOption.id).find('select[name='+field.id+']').val());
					}
				}
				defaultOption.submit(data);
			});
			div.find('.cancel').click(defaultOption.cancel);
		}
	};
});