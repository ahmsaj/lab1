<? session_start();/***GNR***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}	
/***********medical prescription*******************/
.presc_info{width:50px; height:46px; background-image:url(images/presc_info.png);}
.arrow_symbol{background-image:url(images/arrow.png); -webkit-transform: rotate(270deg);}
.pd2 {margin-right:2px; margin-left:2px;}
.mgy5 {margin-top:5px; margin-top:5px;}
.not_active>td,.not_active>div{cursor:pointer;opacity:0.5;filter:alpha(opacity=70);}
.not_active>td[add_altr]{opacity:2; filter:alpha(opacity=100);}
.editNoti{
	position:absolute;
	width: 60px;
	margin-right:-50px;
	margin-top:+10px;
	background-color:#eee;
	text-align: center;
	border-radius: 2px;
	border:1px #B8B8B8 solid;
}
.ic_edit_tit{
	position: relative;
	width:25px;
	height:25px;
	border-radius: 2px;
	/*margin-top: -33px; #D0BC03; goldenrod*/
 	background-position: center center;
	background-repeat: no-repeat;
	background-color:<?=$clr6?>;
	background-image:url(images/presc_edit.png);

}
.no_event,.not_active > td[edit],.not_active > td[req_qantity],.not_active > td[ch]{pointer-events:none;}
.pdy10{
	padding-bottom: 10px;
	padding-top: 10px;
}
.pdt10{ padding-top: 10px;}
.resSamlpe{
	width:200px;
	text-align:center;
	padding:5px;
	padding-bottom:0px;
	border-<?=$align?>:1px #ccc solid;
	background-color:#eee;
	height:65px;
}
.resSamlpe div[t]{
	line-height:25px;
	height:25px;
}
.sStatus{margin:0px;}
.sStatus div[a]{margin:0px; line-height:50px; color:#fff; font-size:24px;}
.sStatus div[a2]{margin:0px; line-height:40px; color:#fff; font-size:24px;}
.sStatus div[b]{ color:#fff; margin:0px; font-size:9px;}
.sStatus div[b2]{ line-height:15px; color:#fff; margin:0px; font-size:10px; font-family: 'f1'}
	
.presc_top_icon{width:80px;height:70px;border-<?=$align?>:2px solid #e5e7ea;
background-repeat:no-repeat; text-align: center;}
.no_border{
	border-width:0px;
	border:none;
	box-shadow: none;
}
.presc_process{margin-top:1px; margin-right:-10px;}
.cbg_pink{
	background-color:#FDF5F5;/* fadede*/
}
.cbg_light_b{background-color: #2f3d44;}
table[sHeader] th{
	position:sticky;
	top:0px;
	border-color: #eee;
}
	
.presc_doc_up{background-image:url(images/exc_icon_up.png);}
.presc_doc_down{background-image:url(images/exc_icon_down.png); bottom;}
.vertical_td{
	writing-mode: vertical-rl; 
	transform: rotate(180deg);
}
.opcity{
	opacity:1;
}
.cbg44_{
	background-color:rgba(235,243,245,0.3);
}
.cbg555_{
	background-color: rgba(250,222,222,0.3);
}
tr[rep]:hover{
	cursor: pointer;
	opacity:0.5;
	
}
</style>