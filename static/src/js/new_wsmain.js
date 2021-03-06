var pop_up_note_mode = true;
var note_id = 1;

function id(name)
{
	return document.getElementById(name);
}
function switchsound()
{
	au = id('bgsound');
	ai = id('sound_image');
	if(au.paused)
	{
		au.play();
		ai.src = "http://res.iweshow.com.cn/weshow/music_note_big.png";
		pop_up_note_mode = true;
		popup_note();
		id("music_txt").innerHTML = "播放";
		id("music_txt").style.visibility = "visible";
		setTimeout(function(){id("music_txt").style.visibility="hidden"}, 2500);
	}
	else
	{
		pop_up_note_mode = false;
		au.pause();
		ai.src = "http://res.iweshow.com.cn/weshow/music_note_big.png";
		id("music_txt").innerHTML = "暂停";
		id("music_txt").style.visibility = "visible";
		setTimeout(function(){id("music_txt").style.visibility="hidden"}, 2500);
	}
}

function on_pop_note_end(event)
{
	note = event.target;
	
	if(note.parentNode == id("note_box"))
	{
		id("note_box").removeChild(note);
		//console.log("remove note id " + note.getAttribute("id"));
	}
}

function popup_note()
{
	box = id("note_box");
	
	note = document.createElement("span");
	note.style.cssText = "visibility:visible;position:absolute;background-image:url('/img/music_note_small.png');width:15px;height:25px";
	note.style.left = Math.random() * 20 + 20;
	note.style.top = "75px";
	this_node = "music_note_" + note_id;
	note.setAttribute("ID", this_node);
	note_id += 1;
	scale = Math.random() * 0.4 + 0.4;
	note.style.webkitTransform = "rotate(" + Math.floor(360 * Math.random()) + "deg) scale(" + scale + "," + scale + ")";
	note.style.webkitTransition = "top 2s ease-in, opacity 2s ease-in, left 2s ease-in";
	note.addEventListener("webkitTransitionEnd", on_pop_note_end);
	box.appendChild(note);

	setTimeout("document.getElementById('" + this_node + "').style.left = '0px';", 100);
	setTimeout("document.getElementById('" + this_node + "').style.top = '0px';", 100);
	setTimeout("document.getElementById('" + this_node + "').style.opacity = '0';", 100);
	
	if(pop_up_note_mode)
	{
		setTimeout("popup_note()", 600);
	}	
}


function share(){
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","http://weshow.kagirl.cn/weshow/share.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("value="+share_value);
}
function forward(){
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","http://weshow.kagirl.cn/weshow/for.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("value="+forward_value);
}

function goguanzhu(){
	location.href = 'http://mp.weixin.qq.com/s?__biz=MzA3MTE0NDkxNg==&mid=268473041&idx=8&sn=1b8c1adb17f3fb62e1fcefe7db9fedfc#wechat_redirect';
}

(function() {
	var timer = null;
	var height = (window.innerHeight || document.documentElement.clientHeight) + 40;
									
	var images = [];
	function detect() {
		var scrollTop = (window.pageYOffset || document.documentElement.scrollTop) - 5;
		for (var i = 0,l = images.length; i < l; i++) {
			var img = images[i];
			var offsetTop = img.el.offsetTop;
			if (!img.show && scrollTop < offsetTop + img.height && scrollTop + height > offsetTop) {
				img.el.setAttribute('src', img.src);
				img.show = true;
			}
		}
		
	}
	function onScroll() {
		clearTimeout(timer);
		timer = setTimeout(detect, 100);
	}
	function onLoad() {
		var imageEls = document.getElementsByTagName('img');
		for (var i = 0,l = imageEls.length; i < l; i++) {
			var img = imageEls.item(i);
			if (!img.getAttribute('data-src')) continue;
			images.push({
				el: img,
				src: img.getAttribute('data-src'),
				height: img.offsetHeight,
				show: false
			});
		}
		detect();
	}

	if (window.addEventListener) {
		window.addEventListener('scroll', onScroll, false);
		window.addEventListener('load', onLoad, false);
		document.addEventListener('touchmove', onScroll, false);
	} else {
		window.attachEvent('onscroll', onScroll);
		window.attachEvent('onload', onLoad);
	}
})();

function playbksound()
{
	var audiocontainer = document.getElementById('audiocontainer');
	
	if(audiocontainer != undefined)
	{
		audiocontainer.innerHTML = '<audio id="bgsound" loop="loop" autoplay="autoplay"> <source src="' + gSound + '" /> </audio>';
	}
	
	var audio = document.getElementById('bgsound');
	audio.src = gSound;
	audio.play();
	
	sound_div = document.createElement("div");
	sound_div.setAttribute("ID", "cardsound");
	sound_div.style.cssText = "position:fixed;right:20px;top:40px;z-index:50000;visibility:visible;";
	sound_div.onclick = switchsound;
	if(document.body.offsetWidth > 400)
	{
	    bg_htm = "<img id='sound_image' src='http://res.iweshow.com.cn/weshow/music_note_big.png'>";
    	box_htm = "<div id='note_box' style='height:100px;width:44px;position:absolute;left:-20px;top:-80px'></div>";
	}
	else
	{
	    bg_htm = "<img id='sound_image' width='30px' src='http://res.iweshow.com.cn/weshow/music_note_big.png'>";
    	box_htm = "<div id='note_box' style='height:100px;width:44px;position:absolute;left:-5px;top:-80px'></div>";
	}
	txt_htm = "<div id='music_txt' style='color:white;position:absolute;left:-40px;top:30px;width:60px'></div>"
	sound_div.innerHTML = bg_htm + box_htm + txt_htm;
	document.body.appendChild(sound_div);
	setTimeout("popup_note()", 100);
}

function in_weixin()
{
	var ua = navigator.userAgent.toLowerCase();

	if(ua.match(/MicroMessenger/i) == "micromessenger") {return true;}
	
	return false;
}
	
(function(){
	var onBridgeReady = function () {	
		
		playbksound();
		
		var serverNo = Math.floor(Math.random()*5200+1);
		/*		
		if (fxnum < 2){
			link = 'http://weshow'+serverNo+'.kagirlweshow.net/weshow/'+fxlink;
		}else{
			link = 'http://weshow'+serverNo+'.knweshow.cn/weshow/'+fxlink;
		}

		WeixinJSBridge.on('menu:share:appmessage', function(argv){
			WeixinJSBridge.invoke('sendAppMessage',{
				'img_url' : imgUrl,
				'img_width' : '640',
				'img_height' : '640',
				'link' : link,
				'desc' : desc,
				'title' : title
			}, function(res) {
				switch(res.err_msg) {
					case "send_app_msg:confirm":
					case "send_app_msg:ok":
						location.href="http://mp.weixin.qq.com/s?__biz=MzA3MTE0NDkxNg==&mid=268473041&idx=8&sn=1b8c1adb17f3fb62e1fcefe7db9fedfc#wechat_redirect";
						break;
				}
			});
			forward();
		});
		WeixinJSBridge.on('menu:share:timeline', function(argv){
			WeixinJSBridge.invoke('shareTimeline',{
				'img_url' : imgUrl,
				'img_width' : '640',
				'img_height' : '640',
				'link' : link,
				'desc' : desc,
				'title' : desc
			}, function(res) {
				switch(res.err_msg) {
					case "share_timeline:confirm":
					case "share_timeline:ok":
						if(fxnum < 2){
							location.href="http://weshow.iweshow.com.cn/weshow/firstfx.php?sharevalue="+share_value+"&sn="+serverNo;
						}else{
							location.href="http://count.iweshow.com.cn/save_fx.php?sn="+serverNo;
						}
						break;
				}
			});
			share();
		});
		*/
	};
	
	if(document.addEventListener){
		document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
	} else if(document.attachEvent){
		document.attachEvent('WeixinJSBridgeReady' , onBridgeReady);
		document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
	}
	
	if(!in_weixin())
	{
		setTimeout("playbksound()", 500);
	}
	
})();	