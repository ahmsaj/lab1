window.onresize = function(){fixPage();} 
$(document).ready(function(e){
	fixPage();
    setTimeout(function(){checkLogin();},3000)
	
})
var Dwidth=200;
var Dheight=200;
var www=0; 
var hhh=0;
function fixPage(){	
	www=$(window).width(); hhh=$(window).height();
	$('.body').width(www);$('.body').height(hhh+1);	
	log_h=$('.log_in').height();	
	if(hhh<log_h){toplog=(hhh-log_h);}else{toplog=(hhh-log_h)/2;}	
	loadPageTimer(toplog);	
}
var p_load='';
function loadPageTimer(toplog){clearTimeout(p_load);p_load=setTimeout(function(){move(toplog);},400);}
function move(n){$('.log_in').animate({'margin-top':toplog}, 800);}

var logTimer='';
function checkLogin(){
    token=$('[_token]').attr('_token');
	$.post(f_path+"S/sys_loginCheck.php",{_token:token},function(data){
		if(data==1){
			clearTimeout(logTimer);
			location.reload();
		}else{
			logTimer=setTimeout(function(){checkLogin()},3000);
		}
	});	
}
