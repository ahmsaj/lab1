<? session_start();/***SYS***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.cbg1{background-color:<?=$clr1?>;}.cbg11{background-color:<?=$clr11?>;}
.cbg111{background-color:<?=$clr111?>;}.cbg1111{background-color:<?=$clr1111?>;}
.cbg2{background-color:<?=$clr2?>;}.cbg3{background-color:<?=$clr3?>;}
.cbg4{background-color:<?=$clr4?>;}.cbg44{background-color:<?=$clr44?>;}.cbg444{background-color:<?=$clr444?>;}
.cbg5{background-color:<?=$clr5?>;}.cbg55{background-color:<?=$clr55?>;}.cbg555{background-color:<?=$clr555?>;}
.cbg6{background-color:<?=$clr6?>;}.cbg66{background-color:<?=$clr66?>;}.cbg666{background-color:<?=$clr666?>;}
.cbg7{background-color:<?=$clr7?>;}.cbg77{background-color:<?=$clr77?>;}.cbg777{background-color:<?=$clr777?>;}
.cbg8{background-color:<?=$clr8?>;}.cbg88{background-color:<?=$clr88?>;}.cbg888{background-color:<?=$clr888?>;}
.cbg9{background-color:<?=$clr9?>;}
.cbgb{background-color:#000;}
.cbgw{background-color:#fff;}
.clr1{color:<?=$clr1?>;}.clr11{color:<?=$clr11?>;}
.clr111{color:<?=$clr111?>;}.clr1111{color:<?=$clr1111?>;}
.clr2{color:<?=$clr2?>;}.clr3{color:<?=$clr3?>;}
.clr4{color:<?=$clr4?>;}.clr44{color:<?=$clr44?>;}.clr444{color:<?=$clr444?>;}
.clr5{color:<?=$clr5?>;}.clr55{color:<?=$clr55?>;}.clr555{color:<?=$clr555?>;}
.clr6{color:<?=$clr6?>;}.clr66{color:<?=$clr66?>;}.clr666{color:<?=$clr666?>;}
.clr7{color:<?=$clr7?>;}.clr77{color:<?=$clr77?>;}.clr777{color:<?=$clr777?>;}
.clr8{color:<?=$clr8?>;}.clr88{color:<?=$clr88?>;}.clr888{color:<?=$clr888?>;}
.clr9{color:<?=$clr9?>;}
.sh{text-shadow:0px 0px 1px #999;}
.clr9{color:#999;}
.clrw{color:#fff;}
.clrb{color:#000;}
ff{font-size:18px; font-family:'ff'; font-weight:bold; letter-spacing:1px;}
ff14{ font-family:'ff'; font-weight:bold; font-size:14px; letter-spacing:1px;}
line10{border-bottom:1px #ccc solid; height:5px; margin-bottom:5px;display:block; width:100%; clear:both;}
line20{border-bottom:1px #ccc solid; height:10px; margin-bottom:10px;display:block; width:100%; clear:both;}
.bs_b{box-sizing: border-box;}
.bs_p{box-sizing: padding-box;}
.bs_c{box-sizing: content-box;}
@font-face{font-family:'f1';src:url('library/fonts/TheSans-Bold-alinma.ttf') format('woff');}
@font-face{font-family:'f2';src:url('library/fonts/The-Sans-Plain-alinma.ttf') format('woff'));}
@font-face{font-family:'ff';src:url('library/fonts/MyriadSetPro-Thin.woff') format('woff');}
.flip{}
<? if($dir=='ltr'){
	$fontSize=2;?>
	start{}	
	.f1{font-weight:bold;}
	.ti_back{background-image:url(images/sys/main_icons.png);background-position:-420px top;}
	.ti_back:hover{background-position:-420px bottom;}
<? }else{$fontSize=0;?>
	start{}	
	.ti_back{background-image:url(images/sys/main_icons.png);background-position:-360px top;}
	.ti_back:hover{background-position:-360px bottom;}
    .flip{transform: scaleX(-1);}
<? }?>
start{}
<? if($_SESSION['blc_sel']==1 && $_SESSION[$logTs.'grp_code']!='s'){?>
start{}
div , td , span {
   -moz-user-select: -moz-none;
   -khtml-user-select: none;
   -webkit-user-select: none;
   -ms-user-select: none;
   user-select: none;
}
<? }?>

@font-face{font-family:'f1s';src:url('library/fonts/TheSans-Bold-alinma.ttf') format('woff');}
html,body{height: 100%;}
body{
	margin:0px;
	font-family:Tahoma, Geneva;
	font-size:12px;
	color:#003;
	background-color:#fff;
	overflow:hidden;
	color:#434343;
	direction:<?=$dir?>;
}	
.fl{float:<?=$align?>;}
.fr{float:<?=$Xalign?>;}
.ta_n{text-align:<?=$align?>;}
.ta_x{text-align:<?=$Xalign?>;}
.bord5{border:1px #000 solid;}
@keyframes blcFl {
	0%   {background-color: #eef058; ;}
    10%  {background-color: #eef058;}
    100%  {background-color: #eee;}	
}
.blcFl{		
    animation-name:blcFl;
    animation-duration:3s;
	animation-iteration-count:1;	
}
.PageStart{
	position: absolute;
	width: 100%;
	height: 100%;
	background-color:#999;
	z-index: 1000;
}
.PageStart div{
	position: absolute;
	width: 100%;
	font-family: 'f1';
	font-size: 18px;
	line-height:60px;
	height: 60px;
	text-align: center;
	color: #fff;
	background: url(images/sys/loader.gif)  no-repeat center bottom;
}
div no , td no{ font-family: 'ff';font-weight: bold;}
.uLine{border-bottom:1px #ddd solid; margin-bottom:10px; box-sizing: border-box; box-sizing: padding-box;}
.uLine2{border-bottom:1px #eee solid; margin-bottom:10px; box-sizing: border-box; box-sizing: padding-box;}
.holdH{}
.holdH th ,.holdH thead{
    position:sticky;	
    top:0;
	z-index: 2;
}
.fs10{font-size:<?=(10+$fontSize)?>px;}
.fs12{font-size:<?=(12+$fontSize)?>px;}
.fs14{font-size:<?=(14+$fontSize)?>px;}
.fs16{font-size:<?=(16+$fontSize)?>px;}
.fs18{font-size:<?=(18+$fontSize)?>px;}
.fs20{font-size:<?=(20+$fontSize)?>px;}
.fs22{font-size:<?=(22+$fontSize)?>px;}
.fs24{font-size:<?=(24+$fontSize)?>px;}
.fs12x{font-size:12px;}.fs14x{font-size:14px;}.fs16x{font-size:16px;}.font18x{font-size:18}.fs20x{font-size:20px;}.fs22x{font-size:22px;}.fs24x{font-size:24px;}
/*.ci_edit{background:url(images/icon_c_edit.png) no-repeat center center;}
.ci_del{background:url(images/icon_c_del.png) no-repeat center center;}
.ci_info{background:url(images/icon_c_info.png) no-repeat center center;}
.ci_print{background:url(images/icon_c_print.png) no-repeat center center;}
.ci_finish{background:url(images/icon_c_finish.png) no-repeat center center;}
.ci_enter{background:url(images/icon_c_enter.png) no-repeat center center;}
.ci_view{background:url(images/icon_c_view.png) no-repeat center center;}
.ci_up{background:url(images/icon_load.png) no-repeat center center;}
.ci_down{background:url(images/icon_save.png) no-repeat center center;}*/
.fl_d{direction:ltr;}
.fll{float:left;}
.frr{float:right;}
.l_bord{box-sizing: border-box;border-<?=$align?>:1px #ccc solid;}
.r_bord{box-sizing: border-box;border-<?=$Xalign?>:1px #ccc solid;}
.t_bord{box-sizing: border-box;border-top:1px #ccc solid;}
.b_bord{box-sizing: border-box;border-bottom:1px #ccc solid;}
.bord{box-sizing: border-box;border:1px #ccc solid;}

.bs_b{box-sizing: border-box;}
.bs_p{box-sizing: padding-box;}
.bs_c{box-sizing: content-box;}

.b_bord3{box-sizing: border-box;border-bottom:3px #999 solid;}

.w100{width:100%;max-width:100%; box-sizing: border-box;} 
.h100{height:100%;max-height:100%; box-sizing: border-box;}
.c_cont{width:fit-content;margin-left:auto;margin-right: auto; display:table;}

.w10{width:10px;box-sizing: border-box;}.h10{height:10px;box-sizing: border-box;}
.w20{width:20px;box-sizing: border-box;}.h20{height:20px;box-sizing: border-box;}
.w30{width:30px;box-sizing: border-box;}.h30{height:30px;box-sizing: border-box;}
.w40{width:40px;box-sizing: border-box;}.h40{height:40px;box-sizing: border-box;}
.w50{width:50px;box-sizing: border-box;}.h50{height:50px;box-sizing: border-box;}
.w60{width:60px;box-sizing: border-box;}.h60{height:60px;box-sizing: border-box;}

.cur{cursor:pointer;}
.Over:hover{cursor:pointer;
    filter: brightness(115%);
    /*opacity:0.7;filter:alpha(opacity=70);*/
}
.Over2:hover{cursor:pointer;
    filter: brightness(95%);
    box-shadow:0px 0px 10px #333;
    /*opacity:0.7;filter:alpha(opacity=70);*/
}
.ws{white-space:nowrap;}


.uc{text-transform: uppercase;}
header, section, footer, aside, article, figure {display: block;}
body , td , div ,span ,a ,section {font-family:Tahoma, Geneva;font-size:12px; 
box-sizing: border-box;
box-sizing: padding-box;
box-sizing: content-box;
}
form{margin:0px; padding:0px;}
.f1{font-family:'f1',Tahoma;}
.f1s{font-family:'f1s',Tahoma;}
.f2{font-family:'f2',Tahoma;}
.ff{font-family:'ff',Tahoma;}

.body{
	overflow:hidden;
	height: 100vh;
	width: 100vw;
	display: grid;
	grid-template-rows: auto 1fr auto;
	grid-template-columns: 1fr;
}
.so::-webkit-scrollbar{width: 4px; height: 10px; border-radius:0px;}
.so::-webkit-scrollbar-track {background-color: #eaeaea;border-radius:0px;}
.so::-webkit-scrollbar-thumb {background-color: <?=$clr1111?>;border-radius:0px;}
.so::-webkit-scrollbar-thumb:hover{width: 10px;background-color:<?=$clr11?>}
.so{ scrollbar-width: thin;}
.ro45{-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-o-transform: rotate(45deg);writing-mode: tb-rl;}
.ro90{-webkit-transform: rotate(90deg);-moz-transform: rotate(90deg);-o-transform: rotate(90deg);writing-mode: tb-rl;}
.ro180{-webkit-transform: rotate(180deg);-moz-transform: rotate(180deg);-o-transform: rotate(180deg);writing-mode: tb-rl;}
.ro270{-webkit-transform: rotate(270deg);-moz-transform: rotate(270deg);-o-transform: rotate(270deg);writing-mode: tb-rl;}

.hide{display:none;}
img{ border:0px;}
th{font-weight:normal;}
form{ margin:0px; padding:0px;}
a:link , a:visited , a:visited {text-decoration:none;color:#000;}
a:hover{color:#000;}
.cb{clear:both;}
.B{font-weight:bold;}
.U{text-decoration:underline;}
.LT{text-decoration:line-through;}
.I{font-style:italic;}
.TC{text-align:center;}
.TL{text-align:<?=$align?>;}
.TR{text-align:<?=$Xalign?>;}
.TJ{text-align:justify;}
/*.text{font-family: 'f1';}*/
.loadWin{
	width:100%;
	height:100%;
	position:absolute;
	z-index:500;
	background:rgba(0,0,0,0.8); 
	text-align:center;
	display:none;	
}
.topHeader{
	height:40px;
	background-color: <?=$clr1111?>;
	overflow: hidden;
	border-bottom:1px #666 solid;
}
#mwFooter{
	border-top:#ccc 1px solid;
	width: 100%;
	float: <?=$Xalign?>;
	background-color:#f9f9f9;
}
/**********************/
.th_win{
	position:absolute;
	overflow:hidden;
	background-color: <?=$clr2?>;
	width:320px;
	max-width: 100%;
	height:100%;
	z-index: 5;	
	border-<?=$Xalign?>: 1px #222 solid;
	display: none;
}
.mlWinTitle{
	height:40px;
	width: 100%;
	margin-bottom:5px;
	background-color: <?=$clr3?>;
}
.th_mH{width:260px;}
.th_mHIn{
	height:40px;
	width: 100%;
	margin-bottom:5px;	
	background: url(images/sys/ser_icon.png) <?=$clr3?> no-repeat <?=$Xalign?> center;
}
.th_lang{width:220px; height: auto;}
#langList{
	width: 100%;
	float: <?=$align?>;
	margin-top: 10px;
	margin-bottom: 10px;
}
.langBox{
	width:100%;
	float: <?=$align?>;	
	border-bottom:1px <?=$clr3?> solid;
	margin-bottom: 10px;
}
.langBox[nor]:hover{
	background-color:<?=$clr3?>;
	cursor: pointer;
}
.langBox > [lanbS]{
	width:40px;
	height: 40px;
	line-height: 40px;
	background-color:<?=$clr3?>; 
	float: <?=$align?>;
	text-align: center;
	text-transform:uppercase;
	font-size: 18px;
	font-family: 'ff';
	color: #fff;
}
.langBox[act] > [lanbS]{
	background-color:<?=$clr1?>;
}
.langBox > [lanbN]{	
	height: 40px;
	line-height: 40px;
	float: <?=$align?>;
	margin-<?=$align?>:10px;
	font-size: 16px;
	color: #fff;
	
}
.th_menu_src{	
	background-color: <?=$clr3?>;
	height: 40px;
}
.menuLoader{
	height: 50px;
	width: 100%;
	background:url(images/sys/loader.gif) no-repeat center center;
	position: relative;
}
#mHList{
	width:100%;
	max-height: 100%;
}
.menuBg{
	position:absolute;
	width:100%;
	height:100%;
	background-color: rgba(255,255,255,0.90);
	background:url(images/sys/mbg.png) center center;
	z-index: 4;
	display: none;	
}
.thic{
	width:40px;
	height:40px;
	box-sizing:border-box;
	border-<?=$Xalign?>:1px #666 solid;
	background-color: <?=$clr3?>;
	background-repeat: no-repeat;
	background-image: url(images/sys/mwtopicon.png);
}
.thic:hover{background-color:<?=$clr1111?>; cursor: pointer;}
.thic_x{
	width:40px;
	height:40px;		
	background-color: <?=$clr5?>;
	background-repeat: no-repeat;
	background-image: url(images/sys/mwtopicon.png);
	background-position:-40px 0px;
}
.thic_x:hover{background-color:<?=$clr55?>; cursor: pointer;}
.thic_menu{	
	background-position:0px 0px;	
}
.thic_fav{
	background-position:-80px 0px;	
}
.thic_exit{
	background-position:-120px 0px;
	border: 0px;
}
.thic_alert{
	background-position:-160px 0px;
}
.thic_alert div[c]{
	height:12px;    
    line-height: 12px;
    min-width: 8px;
    padding: 0 2px;
    font-size: 9px;
    text-align: center;
    border-radius: 50%;
    margin: 4px;
    color: #fff;
    background-color:<?=$clr5?>; 
    float: <?=$align?>;
    border: 1px #ccc solid;
}
.notiList{
    position: absolute;
    width: 280px;    
    background-color: <?=$clr3?>;
    border: 0px #999 solid;
    margin-top: 40px;
    <?=$Xalign?>:0;
    z-index: 100;
    padding: 10px;
    padding-bottom: 0;
    box-sizing: border-box;
    display: none; 
    max-height: calc(100vh - 40px);
}
.notiBlc{
    background-color: #fff;
    border-radius: 2px;
    border: 0px #999 solid;
    margin-bottom: 10px;
    padding: 10px;
}
.notiBlc[st="0"]{
    background-color: #cfc;
    border-radius: 2px;
    border: 0px #999 solid;
    margin-bottom: 10px;
    padding: 10px;
}
.thic_alert div[c="0"]{display: none;}
.thic_lang{
	background-position:-240px 0px;
}
.thic_home{
	background-position:-280px 0px;
}
.thic_user{
	background-position:-320px 0px;
}
.thic_con{
	background-position:-200px 0px;
}
.thic_help{
	background-position:-600px 0px;
	background-color: <?=$clr111?>;
	border-<?=$align?>:1px #666 solid;
}
.user_pro_win{	
	position: absolute;
    width: 280px;    
    background-color: <?=$clr3?>;    
	border:1px #666 solid ;
    margin-top: 40px;
    <?=$Xalign?>:0;
    z-index: 100;
    padding: 10px;
    padding-bottom: 0;
    box-sizing: border-box;
    display: none; 
    max-height: calc(100vh - 40px);
}
.user_pro_win > div{	
	border-bottom:1px #666 solid;		
}
.user_pro_win [text]{
	line-height: 40px;	
	color:#ccc;
	font-family: 'f1';
}	

.thic_help:hover{background-color: <?=$clr11?>;}
#conectS{
	width:40px;
	height:40px;
	background-position:-200px 0px;
	background-color: #666;
    color: #666;
    font-size: 8px;
    position: relative;
    padding: 3px;
}
#conectS:hover{cursor: auto;}
#conectS > div[c]{
    height:3px;
    background-color: #666;
    width: 30px;    
    margin: 35px 3px 0px 3px;
    float: <?=$Xalign?>;
    overflow: hidden;
}
.topHeader [clc]{border-<?=$Xalign?>:1px #666 solid;}
.centerSide{
	width:700px;
	height:600px;
	overflow:hidden;
	margin:0px;
	padding:0px;
}
.centerSideIn{
	padding:0px 10px;
	height:500px;
	overflow:auto;
	overflow-x:visible;	
	position:relative;
}
.centerSideInFull{	
	height:200px;		
	position:relative;
}
header{
	float: <?=$align?>;
	min-height:60px;
	width:100%;
	border-bottom:2px solid <?=$clr4?>;
	background-color:#f9f9f9;
}
.menuList_row{
	width:100%;
	height:50px;
	border-bottom:1px solid <?=$clr3?>;
	position:relative;
	display:block;
}
.menuList_row:hover{
	background-color:<?=$clr3?>;
}
.menuList_row[m_act]{
	background-color: <?=$clr1111?>;
}
.menuList_row div[m_ic]{
	width:50px;
	height:50px;
	float:<?=$align?>;	
	background-position:center center;
	background-repeat: no-repeat;
	opacity:0.7;
	filter1:alpha(opacity=70);
}
.menuList_row:hover div[m_ic]{
	opacity:1;
	filter:alpha(opacity=100);
}
.menuList_row div[m_tx]{	
	color:#bbb;
	font-size:14px;
	height:50px;
	line-height:50px;
	float:<?=$align?>;
	width:200px;
	overflow: hidden;
}
.menuList_row:hover div[m_tx]{
	color:#fff;
}
.menuList_row[m_sub] div[m_tx]{
	background: url(images/sys/arr_<?=$align?>.png);
	background-position:<?=$Xalign?> center;
	background-repeat: no-repeat;	
}
.mwEditPro{
	clear: both;
	font-size: 14px;
	line-height: 40px;
	margin:10px 0px;
	background-color: #000;
	font-family: 'f1';	
}
.mwEditPro:hover{background-color: <?=$clr1111?>; cursor: pointer;}
.mwEditPro > [ico]{
	width:40px;
	height: 40px;
	background: url(images/sys/mwtopicon.png) no-repeat -560px 0px;
}
.hh10{
	height:10px;
	width: 100%;
	float: <?=$align?>;
}
/* .topUserName{display: none;}  */
@media only screen and (max-width:500px) {
	.topUserName{
		display: none;
	}
}
/******/
/*
[ms_subC]{
	position:absolute;
	margin-right: 300px;
	margin-top: -50px;
	z-index: 100;
	float: right;
	width: 300px;
	background-color: <?=$clr3?>;
	display: none1;
}*/
.menuList_row_s{
	width:100%;
	height:50px;
	border-bottom:1px solid <?=$clr2?>;
	position:relative;
	display:block;
}
.menuList_row_s:hover{
	background-color:<?=$clr2?>;
}
.menuList_row_s[m_act]{
	background-color: <?=$clr1111?>	
}
.menuList_row_s div[m_ic]{
	width:50px;
	height:50px;
	float:<?=$align?>;	
	background-position:center center;
	background-repeat: no-repeat;
}
.menuList_row_s div[m_tx]{	
	color:#ddd;
	font-size:14px;
	font-family: 'f1';
	height:50px;
	line-height:50px;
	width:204px;
	float:<?=$align?>;
	overflow: hidden;	
}
/********************/
.sub_menu{
	position:fixed;
	width:260px;
	height:100%;	
	<?=$align?>:260px;
	top:0px;
	display:none;
	z-index:3;
	background-color:<?=$clr3?>;
}
.sub_menu_tab{
	border-top:1px solid <?=$clr2?>;
	
}
.top_txt_sec{
	width: auto;
	
}
.top_title{
	height:40px;
	line-height:40px;
	font-size:16px;
	color:666;
	margin-<?=$align?>:10px;
	white-space:nowrap;
}
.top_title span{
	font-family: 'ff';
	font-size: 14px;
	font-weight: bold;
}
.top_icons{height:60px; float:<?=$Xalign?>; background-color:<?=$clr1111?>;}
.top_icon{width:60px;height:60px;border-<?=$align?>:2px solid #e5e7ea;cursor:pointer;
background-repeat:no-repeat;}
.top_icon > div{
	min-width:10px;
	min-height:20px;
	line-height: 20px;
	color: #fff;
	text-align: center;
	font-family: 'ff';
	background-color:<?=$clr5?>;
	float: <?=$align?>;
	margin: 3px;
	border-radius: 10px;
	font-weight: bold;
	padding: 0px 5px;
	box-sizing: padding-box;
}
.top_icon:hover{background-color:<?=$clr1111?>;cursor:pointer;}
.top_OverX:hover{background-color:<?=$clr3?>;cursor:auto;}
.top_icon2{width:60px;height:60px;cursor:pointer;background-position:top;
background-repeat:no-repeat;background-color:<?=$clr5?>;}
.top_icon2:hover{background-color:<?=$clr5?>;cursor:pointer;}
.top_icon2 div{text-align:center;margin-top:52px;padding-left:10px;padding-right:10px;color:#fff;font-size:10px; }
.ti_add{background-image:url(images/sys/main_icons.png);background-position:-60px top;}
.ti_add:hover{background-position:-60px bottom;}
.ti_search{background-image:url(images/sys/main_icons.png);background-position:0px top;}
.ti_search:hover{background-position:0px bottom;}
.ti_save{background-image:url(images/sys/main_icons.png);background-position:-240px top;}
.ti_save:hover{background-position:-240px bottom;}
.ti_del{background-image:url(images/sys/main_icons.png);background-position:-180px top;}
.ti_del:hover{background-position:-180px bottom;}
.ti_ref{background-image:url(images/sys/main_icons.png);background-position:-120px top;}
.ti_ref:hover{background-position:-120px bottom;}
.ti_bak{background-image:url(images/sys/main_icons.png);background-position:-420px top;}
.ti_bak:hover{background-position:-420px bottom;}
.ti_res{background-image:url(images/sys/main_icons.png);background-position:-480px top;}
.ti_res:hover{background-position:-480px bottom;}
.ti_print{background-image:url(images/sys/main_icons.png);background-position:-540px top;}
.ti_print:hover{background-position:-540px bottom;}
.ti_search_o{background:url(images/sys/main_icons.png) <?=$clr11?> no-repeat 0px bottom;cursor:pointer;}
.ti_search_o div{color:#fff;}
/*.i_add{background:url(images/icon_t_add.png) <?=$clr1?> no-repeat center center;}*/
.pagging{
	width:100%;	background-color:#eee;
}
.pagging div{
	border-<?=$Xalign?>:1px solid #aaa;	
	height:35px;
	line-height:35px;
	min-width:31px;
	text-align:center;	
	font-family:'ff';		
	color:#444;
	padding: 0px 2px;
	background-color:#eee;
}
.pagging .p_butt{
	width:30px;
	font-size:20px;
	float: <?=$align?>;
	font-weight: bold;
	background-color:#ddd;
}
.pagging .p_no{
	color:<?=$clr2?>;
	font-size:16px;
	float: <?=$align?>;	
}
.pagging .p_act{
	background-color:#fff;	
	border-top:1px solid #fff;
	margin-top:-1px;
	font-size:16px;
	float: <?=$align?>;
	color: #000;
	font-weight: bold;
}
.pagging .p_butt:hover , .pagging .p_no:hover{	
	background-color:#ddd;	
	cursor:pointer;		
	font-weight: bold;
}
.pagging .selPm {
	background-color: #999;
	border-<?=$Xalign?>: 0px;	
}
.pagging .selPm div{	
	border-<?=$Xalign?>: 0px;	
}
.pagging #sPnI{
	height: 100%;
	width: 50px;
	border-radius: 0px 0px;
	padding:0px;	
	border:0px;
	margin-top: 1px;
	outline: none;
}
.pagging #sPnE{
	padding: 0px;
	width: 35px;
	height: 35px;
	background:url(images/sys/arr_w_<?=$align?>.png) #999 no-repeat center center ;
}
.pagging #sPnE:hover{background-color:#666;cursor: pointer; }
.reSoHold div{
	float: <?=$align?>;
	min-width: 35px;
	width:100%;
	min-height: 35px;
	height: 100%;
	background:url(images/sys/sort.png) #ccc no-repeat center center;
	border-radius: 2px;
}
.reSoHoldH{
	background:url(images/sys/sort.png) #ccc no-repeat center center;
}
.reSoHold div:hover{	
	cursor:row-resize;
	background-color:<?=$clr1111?>;
}
.grad_s{
	border-collapse:collapse;
	border-collapse:separate;	
	border-spacing:0;
	border:1px solid #ddd;
	border-top:0px solid #ddd;
	border-bottom:5px solid #ddd;
	background-color: #fff;
	margin-bottom:10px;
}
.grad_s th{
	height:40px;
	background-color:<?=$clr3?>;
	color:#e6e7e7;
	border:1px solid #414c53;
	font-family:'f1',tahoma;
	font-size:12px;	
}
.grad_s th b{
	color:#e6e7e7;
	font-family:tahoma;
	font-size:10px;
	font-weight:normal;
}

.grad_s td{
	height:40px;
	color:#444;
	border:1px solid #fdfdfd;
	border-bottom:0px solid #ddd;
	border-top:1px solid #ddd;
	text-align:center;
}
.grad_s td[txt]{
	font-size: 14px;
	font-family: 'f1';
}
.grad_s td[txtS]{
	font-size: 12px;
	font-family: 'f1';
}
.grad_s tr[fot] , .grad_s td[fot]{
	background-color:#eee;	
}
.grad_s td[bb2], .grad_s tr[bb2]{
	border-bottom:2px solid #ddd;	
}
.grad_s td[bb3], .grad_s tr[bb3]{
	border-bottom:3px solid #ddd;	
}
.grad_s2 td{
	height:41px;
	color:#676771;
	border-bottom:1px solid #eaeaea;
	border-<?=$align?>:1px solid #f1f1f1;
}
.grad_s2 td:last-child{
	border-<?=$Xalign?>:1px solid #eaeaea;
}
.grad_s2 tr:first-child td{
	border-top:1px solid #eaeaea;
}
.g_info > tr > td:first-child{
	text-align:<?=$Xalign?>;
	font-weight:bold;	
}
.g_info > tr > td:last-child{
	text-align:<?=$align?>;
	padding-left:10px;
	padding-right:10px;
}
table.pdd10 td{padding-right: 100px;padding-right: 10px;}  
/*
.options{
	position:relative;
	width:21px;	
	height:49px;
	background:url(images/options_<?=$align?>.png)<?=$clr1?> no-repeat center center;
	display:none;
	margin-<?=$Xalign?>:-22px;
	margin-bottom:-21px;
}
.options_cont{
    position:absolute;
	display:none;
	height:49px;
	margin-<?=$Xalign?>:21px;
	margin:0px;
}
.options_cont div{
	height:49px;
	width:49px;
	background-repeat:no-repeat;
	background-position:center center;
	float:<?=$Xalign?>;
	background-color:<?=$clr1?>;
	margin:0px;
}
.options_cont div:hover{
	cursor:pointer;
	background-color:<?=$clr11?>;
}
.withoutMP{ margin:0px; padding:0px; width:20px;}
.withoutMP > div{width:21px;}
.settings{
	width:33px;
	height:25px;
	border-<?=$align?>:1px solid #ccc;
	background:url(images/setting.png) <?=$clr1?> no-repeat left center;
}
.settings:hover{
	background-color:<?=$clr1?>;
	background-position:right  center;
}
.set_win{
	position:fixed;
	width:320px;
	height:208px;
	background-color:<?=$clr1?>;
	bottom:25px;
	<?=$Xalign?>:0px;
	display:none;
	z-index:2;
}
.logout{
	height:58px;
	line-height:58px;
	background-color:<?=$clr2?>;
	text-indent:20px;
	font-size:18px;
}
.logout:hover{
	background-color:<?=$clr3?>;
}
.i_logout{
	width:100px;
	height:58px;
	background:url(images/i_logout_<?=$align?>.png) no-repeat center center;
}
.set_b2{
	width:280px;
	margin:0px auto;
	margin-top:20px;
}
.yourLang{
	color:#fff;
	font-size:15px;
	margin-bottom:8px;
}
.langs_bar{
	height:50px;
	border-bottom:1px solid <?=$clr44?>;
	width:280px;
}
.lang_cer{
	width:30px;
	height:30px;
	line-height:30px;
	border:1px solid #fff;
	color:#fff;
	text-align:center;
	margin-<?=$Xalign?>:8px;
	border-radius:20px;
	
}
.lang_cer_act , .lang_cer:hover{
	width:30px;
	height:30px;
	line-height:30px;
	border:1px solid #fff;
	color:<?=$clr1?>;
	background-color:#fff;
	text-align:center;
	margin-<?=$Xalign?>:8px;
	border-radius:20px;
}
.set_acc{
	position:relative;
	width:260px;
	margin-<?=$align?>:20px;;
	height:39px;
	line-height:39px;
	padding-top:10px;
	color:#fff;
	font-size:15px;
	background:url(images/sys/arr_w_<?=$align?>.png) no-repeat <?=$Xalign?> center;
}
.information{
	height:17px;
	margin-top:4px;
}
.information > div:last-child{
	border:0px;
}
.information > div{
	float:<?=$Xalign?>;
	height:17px;
	margin-<?=$Xalign?>:8px;
	border-<?=$align?>:1px solid #ccc;
	text-align:<?=$Xalign?>;
	white-space:nowrap;	
}
.information > div span{
	white-space:nowrap;
	color:<?=$clr1?>;
}*/
.input {
	font-family:Tahoma, Geneva, sans-serif;
	color:#999; 
	font-size:14px;
	outline: none;
    padding: 10px;
}
input[type=text],
input[type=password],
input[type=email],
input[type=tel],
input[type=date],
input[type=color],
input[type=range],
input[type=month],
input[type=week],
input[type=time],
input[type=datetime],
input[type=search],
input[type=url],
input[type=number],
select ,select option {
	width:100%;	
	height:40px;
	line-height:40px;	
	text-indent:10px;	
	border-radius:1px;
	box-sizing: border-box;
	font-size:12px;
	border:1px solid #ddd;
	color:#666;
	box-sizing: border-box;
	margin: 0px;
	outline: none;
	padding: 0px;
    font-family: 'f1';
}
textarea {
    padding: 10px;
	font-size:14px;
    line-height:20px;
    text-indent: 0px;
    padding: 10px;
	height:180px;    
    box-sizing: border-box;
    border:1px solid #ddd;    
}
textarea[t]{
    font-family:'f1',Tahoma;
}
input:focus,
textarea:focus ,select:focus ,select option:focus {
	background-color: #f9f9ff;
	border:1px #999 solid;	
}

input[type=text][fw]{width:100%;max-width:100%;}
select option {
	height:40px;
	line-height:40px;
	/*font-size:14px;*/
	color:#666;    
}
select{font-family: 'f1'}
select{ height: 40px;}
select[t] ,select[t] option{font-family: 'f1'; height: 40px; font-size:12px; line-height: 30px;}
option[t]{font-family: 'f1'; height: 40px;}
select[t] span{font-family: 'ff'; font-size: 12px;}
select[n] ,select[n] option{font-family: 'ff'; font-size: 16px; font-weight: bold;}
input[type=number]{
	width:100%;
	height:40px;
	line-height:40px;
	font-family:'ff';
	border-radius:2px;
	font-size:18px;
	font-weight:bold;
	border:1px solid #ddd;
	color:#999;
	text-align:center;
}
.switch_butt{
	width:36px;
	height:22px;
	border:1px solid #ccc;
	background-color:#FFF;
	cursor:pointer;
	border-radius:3px;
	margin:5px;	
}
.switch_butt div{
	width:18px;
	height:18px;
	border-radius:3px;
	margin-top:2px;
	margin-left:2px;
	margin-right:5px;
	z-index:150;	
}
.infoTable th{
	height:52px;
	background-color:#3a4951;
	color:#fff;
	border-bottom:1px solid #cacbd0;
	border-<?=$align?>:1px solid #cacbd0;
    padding: 0px 10px;
}
.infoTable th:last-child{
	border-<?=$Xalign?>:1px solid #cacbd0;
}
.infoTable td{
	height:30px;
	color:#676771;
	border-bottom:1px solid #eaeaea;
	border-<?=$align?>:1px solid #f1f1f1;
    padding: 6px 10px;
}
.infoTable td[txt]{
    font-family: 'f1';
    font-size: 14px;
}    
.infoTable td span{
	color:<?=$clr1?>;
}
.infoTable td:last-child{
	border-<?=$Xalign?>:1px solid #eaeaea;
}
.infoTable tr:first-child td{
	border-top:1px solid #eaeaea;
}
.win_title{
	height:60px;
	line-height:60px;
	color:<?=$clr1?>;
	font-size:26px;
	margin:10px;
}
.filter{
	display:none;
	background-color:<?=$clr11?>;
	width:280px;
	position:fixed;
	top:70px;
	<?=$Xalign?>:0px;
	padding:20px;
	color:#fff;
}
.filter input{
	width:260px;
	border:0px;
}
.filter select{
	width:270px;
	border:0px;
    font-family: 'f1';
}
.filter div{
	margin-bottom:10px;
}
.fil_butt{
	background-color:#fff;
	color:<?=$clr11?>;
	border-bottom:3px solid #92beeb;
	height:41px;
	line-height:41px;
	width:150px;
	border-radius:4px;
	text-align:center;
	margin:10px;
	cursor:pointer;
}
#alert_win_cont{
	font-size:15px;
	font-family:'f1',tahoma;
	color:<?=$clr1111?>
}
.ser_line{
	padding:10px;
	margin:10px 0px;
	background-color:<?=$clr11?>;
	height:34px;
	line-height:18px;
	color:#f5f5f5;
}/*
.ser_icon{
	width:40px;
	height:34px;
	margin-<?=$Xalign?>:10px;
	background:url(images/icon_t_search2.png) <?=$clr11?> no-repeat <?=$align?> center;
	border-<?=$Xalign?>:1px solid #ccc;
}*/
.fil_box{
	border-<?=$Xalign?>:1px solid #ccc;
	padding-<?=$Xalign?>:10px;
	margin-<?=$Xalign?>:10px;
	text-align:center;
	font-size:14px;
}
.fil_box span{
	font-size:12px;
}
.iiii{ position:absolute; color:#fff;}
.hl_s{ background-color:#dd0; text-transform:capitalize;color:#000;}
/****************************************/
.xdsoft_datetimepicker  .xdsoft_label > .xdsoft_select > div > .xdsoft_option.xdsoft_current{
	background:<?=$clr1?>;
}
.xdsoft_datetimepicker  .xdsoft_calendar td.xdsoft_today{color:<?=$clr1?>;}
.xdsoft_datetimepicker  .xdsoft_timepicker .xdsoft_time_box >div >div.xdsoft_current{
	background: <?=$clr1?>;
	color:#fff;
	font-weight: 700;
}
.xdsoft_datetimepicker  .xdsoft_label > .xdsoft_select > div > .xdsoft_option:hover{
	color: #fff;
    background:<?=$clr5?>;
}
.xdsoft_datetimepicker  .xdsoft_calendar td:hover,
.xdsoft_datetimepicker  .xdsoft_timepicker .xdsoft_time_box >div >div:hover{
	color: #fff !important;
    background: <?=$clr5?> !important;
    box-shadow: none !important;
}
/*************/
.ui-widget-overlay{
    background-color:#000;
    opacity: 0.8;
}
.ui-dialog-titlebar-close {
    display: none;
    width: 0px;
}
.ui-dialog .ui-dialog-title , .ui-dialog .ui-dialog-content,.ui-widget-header,.ui-dialog .ui-dialog-titlebar,.ui-widget.ui-widget-content{
    padding:0px 0px 0px 0px;    
    margin:0px 0px 0px 0px;
    border-radius:0px 0px 0px 0px;
    border:0px;
}
.full_win.ui-dialog-content{
    overflow: hidden;
    height: 100%;
    box-sizing: border-box;
}
.ui-dialog .ui-dialog-title{ 	
	white-space:nowrap;
	width:100%;
	overflow:hidden;
	text-overflow:ellipsis;
	height:45px;
	line-height:45px;
	font-family:'f1',Tahoma, Geneva;
    color: #fff;
    font-weight:lighter;
    font-size: 16px;    
    box-sizing: border-box;
    padding: 0px 20px;
}
.ui-dialog{
    margin: 0px auto;
    background-color: #f5f5f5;
}
.ui-widget-header{ background-color:<?=$clr1?>;}
/****************************************/
.tabs{
	height:40px;	
	margin-top:10px;
	color:#fff;
}
.tabs div{background-repeat:no-repeat; overflow:hidden;}
.tab_nor{
	height:40px;
	line-height:40px;
	text-indent:10px;
	border-<?=$Xalign?>:1px solid #ccc;
	border-bottom:1px solid #ccc;	
	color:#fff;
	background-color:<?=$clr1?>;
	font-family:'f1',Tahoma, Geneva;
	font-size:14px;
	background-position:<?=$align?> top;
}
.tabs div:last-child{border-top-<?=$Xalign?>-radius:2px;}
.tabs div:first-child{border-top-<?=$align?>-radius:2px;}
.tab_nor:last-child{
	border-<?=$Xalign?>:0px;
}
.tab_nor:hover{
	background-color:<?=$clr11?>;
	cursor:pointer;
}
.tab_act{
	height:40px;
	font-size:15px;
	line-height:40px;	
	text-indent:10px;
	color:<?=$clr2?>;
	background-color:#fff;
	border-top:1px solid #ccc;
	border-<?=$Xalign?>:1px solid #ccc;
	font-family:'f1',Tahoma, Geneva;
	font-size:14px;	
	background-position:<?=$align?> bottom;
	
}
.tab_act:hover{
	color:<?=$clr3?>;
	background-color:#fff;
	border-top:1px solid #ccc;
}
.tf_act{border-<?=$align?>:1px solid #ccc;}
.tl_act{border-<?=$Xalign?>:1px solid #ccc;}
.tn_act{border-<?=$align?>:1px solid #fff;}
.tabc{
	height:120px;
	border:1px solid #ccc;
	border-top:0px;
	padding:10px;
	border-radius:0px 0px 2px 2px;
}
.tabc > section{
	display:none;
	overflow-x:hidden;
}
.add_but{
	width:38px;
	height:38px;
	background:url(images/sys/pcat_add.png) <?=$clr1?> no-repeat center center; 
	margin:5px;
	margin-top:0px;
	margin-<?=$align?>:0px;
	border-radius:2px;
}
.add_but:hover{
	cursor:pointer;
	background-color:<?=$clr11?>;
}
.topline{
	border-top:1px solid #ccc;
	margin-top:20px;
}
.title_Total{
	font-size:18px;
	font-family:'f1';
}
.title_Total span{
	font-size:16px;
	font-family:'ff';    
}

.loadeText{
	background:url(images/sys/load.gif) no-repeat <?=$align?> center;
	text-indent:20px;	
	font-family:'f1',tahoma;
	font-size:14px;
	margin:5px;
	clear: both;
}

.miraware-queue{
	position:fixed;
	<?=$Xalign?>:0px;
	top:0px;
	z-index:1001;
	background-color:<?=$clr2?>;
}
.out_up{
	width:100%;
	max-height:185px;
	overflow-x:hidden;
}
.file_ex{
	width:104px;
	height:78px;
	margin:3px;
	background-repeat:no-repeat;
	background-position:center center;
	position:relative;
	border:1px #ccc solid;
	padding:3px;
}
.file_ex_over{
	position:absolute;
	z-index:3;
	width:104px;
	height:78px;
	background:rgba(0,0,0,0.8); 
	display:none;
}
.file_ex_img{
	position:absolute;
	width:104px;
	height:78px;
	line-height:78px;
	background-repeat:no-repeat;
	font-size:22px;
	text-align:center;
	background-position:center center;
	z-index:2;
}
.file_ex_txt{
	width:100px;
	height:20px;
	color:#fff;
	text-align:center;
	font-size:10px;
	margin-left:auto;
	margin-right:auto;
	margin-top:8px;
}/*
.up_view{
	width:32px;
	height:32px;
	cursor:pointer;
	background:url(images/icon_up_view.png) no-repeat left center;
	margin-<?=$align?>:20px;
	margin-top:20px;
}
.up_view:hover{
	background:url(images/icon_up_view.png) no-repeat right center;
}
.up_del{
	width:32px;
	height:32px;
	cursor:pointer;
	background:url(images/icon_up_delete.png) no-repeat left center;
	margin-top:20px;
}
.up_del:hover{
	background:url(images/icon_up_delete.png) no-repeat right center;
}
.icon_del{
	width:32px;
	height:32px;
	cursor:pointer;
	background:url(images/icon_up_delete.png) no-repeat right center;
	margin:5px;
}*/
.winPhoto{
	background-position:center center;
	background-repeat:no-repeat;
	overflow:hidden;
	margin-top:20px;
	margin-left:auto;
	margin-right:auto;
}
.fileName , .fileSizeup{
	width:150px;
	height:20px;
	line-height:20px;
	overflow:hidden;
	text-align:<?=$Xalign?>;
	font-size:12px;
}
.fileSizeup{
	font-size:11px;
}
.loader_bup{
	height:15px;
	background-color:#eee;
	border-radius:3px;
}
.loader_bup div {
	height:15px;
	border-radius:3px;
	background:url(images/sys/preloader.gif) <?=$clr1?> <?=$Xalign?> top;
}
.preloader{
	background:url(images/sys/preloader.gif) <?=$clr6?> <?=$Xalign?> top;
}
.loadText{height:40px; line-height:40px;}
.loadText1{font-size:16px;}
.loadText2{font-size:22px;}
.il_add{
	background:url(images/sys/pcat_add.png) <?=$clr1?> no-repeat center center;
	margin-bottom:10px;
	margin-<?=$Xalign?>:10px;
	height:38px;
	width:38px;
	line-height:38px;
	color:#fff;
	float:<?=$align?>;
	color:<?=$clr3?>;
}
.il_add:hover{
	background-color:<?=$clr11?>;
	cursor:pointer;
}
.il_blc{
	background-color:#e7e9eb;
	margin-bottom:10px;
	margin-<?=$Xalign?>:10px;
	height:38px;
	line-height:38px;
	float:<?=$align?>;
	padding-left:10px;
	padding-right:10px;
	color:<?=$clr3?>;
}
.win_body_full{
	position:relative;	
	clear:both;
	width:100%;
	height: 100%;
	margin: 0px;
	padding: 0px;
    box-sizing: border-box;
}
.full_win {
    position:relative;
	margin:15px;
	clear:both;
    width: 100%;
    height: 100%;
}
.win_body{	
	margin:10px;
}
.win_body2{
	position:relative;
	padding:10px;
    padding-bottom: 0px;
	margin-bottom:10px;
	width: 100%;
    box-sizing: border-box;
}
.win_free{
	position:relative;
	margin:0px;
	padding: 0px;
	width: 100%;
	height: 100%;
	float: <?=$align?>;
	box-sizing: border-box;
}
.fTable{width:100%;}
.fTable td{
	border-bottom:1px #fafafa solid;
	padding:6px;
}
.fTable td[i] span{
	font-size:11px;
	color:#ccc;
}
.fTable td[n]{
	color:<?=$clr1111?>;
	font-family:'f1',tahoma;
	font-size:14px;
	width:140px;
	height:38px;
}
.fTable td[n] span{
	color:<?=$clr5?>;
}
.fTable td[n] b{
	font-size:12px;
	color:#999;
	font-weight:normal;
	font-family:Tahoma, Geneva, sans-serif;
}
.fTable td textarea{
	width: -webkit-fill-available;	
}
.form_body{
	border:1px #ddd solid;
	padding:10px;
	clear:both;
	border-radius:2px;
	box-sizing: border-box;
    background-color: #fff;
    overflow: auto;
}
.form_header{
	position:relative;
	float:left;
	clear:both;
	width:100%;
}
.form_fot{
	width:100%;
	padding-top:0px;
    box-sizing: border-box;
   
}
.bu{
	min-width:90px;
	height:40px;
	line-height:40px;
	margin:10px 5px;
	/*margin-<?=$Xalign?>:0px;*/
	color:#fff;
	border:0px;
	text-align:center;
	border-radius:1px;
	font-size:14px;
	font-family:'f1',Tahoma, Geneva;
	cursor:pointer;
	padding-left:10px;
	padding-right:10px;
	white-space:nowrap;
}
.bu2{
	height:30px;
	line-height:33px;
	margin:10px;
	margin-<?=$Xalign?>:0px;
	color:#fff;
	border:0px;
	text-align:center;
	border-radius:1px;
	font-size:14px;
	font-family:'f1',Tahoma, Geneva;
	cursor:pointer;
	padding-left:10px;
	padding-right:10px;
	white-space:nowrap;
}
.buu{margin:0px;}
.bu_t1{background-color:<?=$clr1?>;border-bottom:2px solid <?=$clr1111?>;}
.bu_t1:hover{background-color:<?=$clr1111?>;}
.bu_t2{background-color:#aaa;border-bottom:2px solid #888;}
.bu_t2:hover{background-color:#888;}
.bu_t3{background-color:<?=$clr5?>;border-bottom:2px solid <?=$clr55?>;}
.bu_t3:hover{background-color:<?=$clr55?>;}
.bu_t4{background-color:<?=$clr6?>;border-bottom:2px solid <?=$clr66?>;}
.bu_t4:hover{background-color:<?=$clr66?>;}
.form_checkBox{
	width:40px;
	height:40px;
	border:0px #ccc solid;
}
.form_checkBox > div{
	position:relative;
	width:17px;
	height:17px;
	border:1px #ccc solid;
	margin:9px;
	background-color:<?=$clr1?>;
	background-repeat:no-repeat;
	background-position:center center;
	border-radius:3px;
}
.form_checkBox > div[ch=on]{
	background-image:url(images/sys/fo_el_check.png);
}
.form_checkBox > div[ch=on]:hover{
	background-color:<?=$clr1111?>;
}
.form_checkBox > div[ch=off]{
	background-image:url(images/sys/fo_el_check.png);
	background-color:#eee;
}
.form_checkBox > div[ch=off]:hover{
	background-color:#ddd;
}
.radioBlc{width:100%; max-height:172px; overflow-x:hidden}
.radioBlc .form_radio{
	width:36px;
	height:36px;
	border:0px #ccc solid;	
}
.radioBlc_each{
	margin-<?=$Xalign?>:5px;
	border:1px #e5e7ea solid;
	border-radius:2px;
	margin-bottom:5px;
}
.radioBlc .form_radio > div{
	position:relative;
	width:15px;
	height:15px;
	border:1px #ccc solid;
	margin:9px;
	background-color:#fff;
	background-repeat:no-repeat;
	background-position:center center;
	border-radius:15px;
	cursor:pointer;
}
.radioBlc .form_radio > div > div{
	position:relative;
	width:9px;
	height:9px;
	margin:3px;	
	border-radius:15px;
	cursor:pointer;
}
.radioBlc_each[ch=on] .form_radio > div > div{background-color:<?=$clr1?>;}
.radioBlc_each[ch=off] .form_radio > div > div{background-color:#eee;}
.radioBlc_each:hover{background-color:<?=$clr11?>;cursor:pointer;border:1px <?=$clr1?> solid;color:#fff}
.radioBlc_each[ch=on]:hover .form_radio > div {border:1px <?=$clr1?> solid;}
.radioBlc_each[ch=off]:hover .form_radio > div > div{background-color:#ddd;}
.radioBlc .ri_labl{
	position:relative;
	height:36px;
	line-height:36px;
	background-position:center center;
	padding-<?=$Xalign?>:10px;
    font-family: 'f1';
}
.PageLoaderWin{
	position:fixed;
	z-index:1500;	
	width:100%;
	height:100%;
	background-color:rgba(0,0,0,0.4);
	display:none;
	text-align:center;	
}
.PageLoaderWin > div[c]{
	margin-top:10px;
	background-color:#999;	
	min-height: 60px;	
	margin-left: auto;
	margin-right: auto;
	border-radius:5px;
    box-shadow: 1px 0px 10px #666;
    border: 1px #ccc solid;
}
.PageLoaderWin div[i]{
	background:url(images/sys/loader.gif) no-repeat center center;
	background-color:rgba(0,0,0,0.2);
	height: 60px;	
	width:60px;
	border-radius:5px;
}
.PageLoaderWin div[s]{	
	color:#fff;
	text-align:center;	
	font-size:15px;
	min-height:30px;
	line-height: 30px;
	word-spacing:3px;	
	font-size:16px;
	line-height:40px;
	padding: 10px 30px;
	border-radius:5px;	
}
.PageLoaderWin div[c=t]{background-color: <?=$clr3?>}
.PageLoaderWin div[c=t1]{background-color:<?=$clr6?>}
.PageLoaderWin div[c=t0]{background-color:<?=$clr5?>}
.PageLoaderWin div[c=t] div[i]{background:url(images/sys/_0.png)  no-repeat center center; background-color:rgba(0,0,0,0.2);}
.PageLoaderWin div[c=t1] div[i]{background:url(images/sys/_1.png) no-repeat center center;background-color:rgba(0,0,0,0.2);}
.PageLoaderWin div[c=t0] div[i]{background:url(images/sys/_0.png) no-repeat center center;background-color:rgba(0,0,0,0.2);}
.PageLoaderWin div[c=t2] div[i]{background:url(images/sys/_0.png) no-repeat center center;background-color:rgba(0,0,0,0.2);}
.in_list_img img{ margin:0px; padding:0px;}
.in_list_img > div{
	margin:2px;
	background-repeat:no-repeat;
	background-position:center center;
	position:relative;
	border:1px #eee solid;
	padding:1px;
	text-transform:uppercase;
}
.in_list_img > div:hover {
	border:1px #666 solid;
	cursor:pointer;
}
.im_num{
	position:absolute;
	height:15px;
	line-height:15px;
	width:15px;
	background-color:<?=$clr1?>;
	border:1px solid #fff;
	border-radius:15px;
	color:#fff;
	text-align:center;
	margin-top:-8px;
	<?=$Xalign?>:-8px;
	font-size:10px;
}
.file_box{
	background:url(images/sys/file_corn.png) <?=$clr1111?> no-repeat top right;
	border-radius:5px;
	font-size: 20px;
	color:#fff;
	text-transform:uppercase;	
	text-align:center;
	position:relative;
	width:50px;
	height:50px;
	line-height:50px;
	margin:2px;	
	box-sizing: border-box;
	
}
.file_box:hover{ background-color:<?=$clr1?>; cursor:pointer;}
.file_box:hover >div {display: block;}
.file_box >div{
	position: absolute;
	float: left;
	width: 25px;
	height: 25px;
	line-height: 25px;
	border-radius: 15px;
	background-color: <?=$clr5?>;
	margin-top: -10px;
	display: none;
}
.file_box >div:hover{
	background-color: <?=$clr55?>;
	cursor: pointer;
}
.orderPlace{min-height: 40px;width:100%;position:relative;clear: both;border:1px #000 dashed;background-color:<?=$clr5?>;}

.ui-sortable-helper{
	box-shadow:#000 0px 0px 5px;
	background-color:#fff;
}
.child_link{
	position:relative;
	padding-<?=$Xalign?>:10px;
	border-<?=$align?>:2px <?=$clr2?> solid;
	text-indent:40px;
	text-align:<?=$align?>;
	border-radius:2px;
	background-color: <?=$clr11?>;
	font-family: 'f1';
	color:#fff;
	height: 30px;
	line-height: 30px;
	min-width:100px;
	white-space:nowrap;
	border-radius:2px;
}
.child_link[act]{background-color:<?=$clr1111?>; color:#fff;}
.child_link:hover{
	background-color:<?=$clr1?>;
	color:#fff;
	cursor:pointer;
}
.child_link div{
	position: absolute;
	height:30px;
	line-height:30px;
	width:30px;
	color:#fff;
	text-align:center;
	font-size:16px;	
	font-family: 'ff';
	float:<?=$Xalgin?>;
	text-indent:0px;
	font-weight: bold;
	border-radius: 2px;
}
.child_link div[t]{
	background-color:<?=$clr1111?>;
}
.child_link div[n]{
	background-color:<?=$clr111?>;
}
.warn_msg{
	color:#f00;
	font-size:14px;
	padding:10px;
}
.List_add_butt{
	width:40px;
	height:40px;
	background:url(images/sys/pcat_add.png) <?=$clr1?> no-repeat center center;		
}/*
.List_del_butt{
	width:40px;
	height:40px;
	background:url(images/delete2.png) <?=$clr5?> no-repeat center center;		
}
.List_add_butt:hover,.editToList:hover,.delToList:hover{ background-color:<?=$clr11?>;cursor:pointer;}
.sdditionIcon{
	/*background-repeat:no-repeat;
	background-position:center center;
	background-color: <?=$clr2?>;
	width: 40px;
	height: 40px;
	float: <?=$Xalign?>;
}
#link_table , #link_col{width:160px;}*/
.co_filter{
	display:none;
	background-color:<?=$clr11?>;
	width:220px;
	position:absolute;
	top:100px;
	<?=$Xalign?>:0px;
	padding:10px;
	padding-bottom:20px;
	color:#fff;
	height:200px;
	z-index:1;
}
.filterForm{
	height:120px;
	overflow-x:hidden;
}
.filterForm div[txt]{
	padding-top:10px;
	padding-bottom:3px;
}
.filterForm input[type=text] ,.filterForm input[type=number] , .filterForm select{
	width:100%;	
	height:25px;
	line-height:25px;
	border:1px solid #e5e7ea;
	text-indent:10px;
	font-family:'f1';
	font-size:12px;
}
.filBut{
	width:100px;
	height:25px;
	line-height:25px;
	border:1px solid #e5e7ea;
	font-size:12px;
	text-align:center;
	margin-bottom:10px;
	background-color:#fff;
	color:<?=$clr1111?>;
}
.filBut:hover{
	background-color:<?=$clr1111?>;
	cursor:pointer;
	color:#fff;
}
.ser_icons{
	height:40px;	
	margin-top:10px;
	background-color: <?=$clr1111?>
}
.ser_icons div {
	width:100%;
	height:40px;
	background-repeat:no-repeat;
	background-position:center center;
	margin-<?=$Xalign?>:10px;	
	border-radius:5px;
	bottom:0px;
}
.ser_icons div:hover{ background-color:rgba(0,0,0,0.1); cursor:pointer;}
.fil_rest,.fil_rest2{background-image:url(images/sys/reset.png);}
.fil_rest_in{
	background:url(images/sys/reset.png) no-repeat center center;
	background-color:<?=$clr1111?>;
	width:32px;
	height:32px;
	margin:10px;
	border-radius:2px;
}.fil_rest_in:hover{background-color:<?=$clr1?>; cursor:pointer;}
.sarTap{	
	margin:10px;
	margin-<?=$align?>:0px;
	padding:3px;
	padding-left:10px;
	padding-right:10px;
	line-height:25px;
	background:url(images/sys/ser_icon.png) <?=$clr1111?> no-repeat <?=$align?> 0px;
	color:#fff;
	border-radius:2px;
}
.sarTap{position:relative;}
.sarTap div:first-child{ margin-<?=$align?>:30px;}
.sarTap div{
	padding-<?=$Xalign?>:10px;
	margin-<?=$Xalign?>:10px;
	border-<?=$Xalign?>:1px #ccc solid;
	margin-top:3px;
	margin-bottom:3px;
	height:18px;
	line-height:17px;
	position:relative;
	white-space:nowrap;
}
.sarTap div:last-child{ border:0px;}
.slidSelect{padding-<?=$align?>:44px;}
.slidSelect2{padding-<?=$align?>:88px;}
.slidSelect select{max-width:458px;}
th[so_no]{background-position:right top;background-repeat:no-repeat;}
th[so_up]{background-image:url(images/sys/i_sort_up.png);}
th[so_down]{background-image:url(images/sys/i_sort_down.png);}
th[so_no]:hover, th[so_act]{
	background-color:<?=$clr2?>;
	cursor:pointer;
}
/*
th aside {
	position:absolute;
	margin-top:-14px;
	margin-<?=$align?>:-3px;
	float:left;
	background-position:right center;
	background-repeat:no-repeat;
	background-image:url(images/icon_sort.png);
	width:14px;
	height:14px;
	font-size:24px;
	opacity:0.3;
	filter:alpha(opacity=30);
}*/
.td_sort_act{
	background-color:<?=$clr44?>;
}
.centerSideInHeader{	
	margin:0px 10px;
	position:relative;
	float:<?=$align?>;
	clear:both;
}
.centerSideInHeaderFull{
	position:relative;
	float:<?=$align?>;
	clear:both;
}
.check_label{
	height:40px;
	line-height:40px;
	font-size:12px;
}
.filter_title{
	font-size:16px;
	line-height:40px;
	padding-top:10px;
	border-bottom:1px #A0FFA2 dashed;
}
.filterBott{
	background-color:#fff;
	padding:5px;
	line-height:20px;
	color:<?=$clr1111?>;
	font-family:'f1';
	text-align:center;
	margin-top:15px;
	margin-bottom:5px;
	border-radius:2px;
	border-bottom:3px <?=$clr1111?> solid;
	font-size:16px;
}
.filterBott:hover{
	background-color:<?=$clr1111?>;
	color:#fff;
	cursor:pointer;
}
.w-auto{width:auto; max-width:auto;}
.noneMarPad{ margin:0px; padding:0px;}
.photoBloc{
	background-repeat:no-repeat;
	background-position:center center;
	margin:auto;
}
.repBlock{
	margin:40px 10px 40px 10px;
	background-color:<?=$clr4?>;
	padding:10px;
}
.repBlock div{
	font-family:'f1', tahoma;
	font-size:18px;
	margin:10px;
}
.rep_header{
	margin:10px 0px;
}
.rep_header select{
	height: 40px;
	margin-bottom:10px;
	background-color: #f5f5f5;
}
.rep_header div{
	height:40px;
	line-height:40px;
	padding:0px 10px;
	background-color:#eee;		
	color:#000;		
	border:1px #e5e5e5 solid;
	border-bottom:3px #e5e5e5 solid;
	font-family:'f1',tahoma;
	white-space:nowrap;
	box-sizing: border-box;
}
.rep_header div.act{
	background-color:<?=$clr1?>;
	color:#fff;	
	border-bottom:3px <?=$clr1111?> solid;
}
.rep_header div.act:hover{background-color:<?=$clr11?>;}
.rep_header div:hover{background-color:#ccc; cursor:pointer;}
.reportList{ height:30px;}
.MultiBlc{width:100%; max-height:172px; overflow-x:hidden}
.MultiBlc .cMul{
	margin-<?=$Xalign?>:5px;
	border:1px #e5e7ea solid;
	border-radius:2px;
	margin-bottom:5px;
	height:36px;
	line-height:36px;
	float:<?=$align?>;
	cursor:pointer;
	padding-<?=$Xalign?>:10px;
	text-indent:30px;
	white-space:nowrap;
}
.MultiBlc .cMul[ch=off]{
	background:url(images/sys/mche.png)  no-repeat <?=$align?> top;
	border:1px #e5e7ea solid;
}
.MultiBlc .cMul[ch=off]:hover{ background-color:#f5f5f5;}
.MultiBlc .cMul[ch=on]{
	background:url(images/sys/mche.png) <?=$clr1?> no-repeat <?=$align?> bottom;
	border:1px <?=$clr1111?> solid;
	color:#fff;
}
.MultiBlc .cMul[ch=on]:hover{ background-color:<?=$clr1111?>;}
.listTitle{
	color:<?=$clr1?>;
	line-height:40px;
}
.listTitle2{
	margin-top:-10px;
	color:<?=$clr5?>;
	line-height:40px;
}
.mod_link{
	line-height:40px;
}/*
.noPhoto{
	background:url(images/no_photo.png) no-repeat center center;
}*/
.winButts{
	height:45px;
	position:fixed;
	z-index:200;
	<?=$Xalign?>:0px;
	top:0px;
}
.winButts > div{
	height:45px;
	line-height:45px;
	width:45px;
	border-<?=$align?>:1px <?=$clr111?> solid;
	background-position:center center;
	background-repeat:no-repeat;
	float:<?=$Xalign?>;
	background-color:<?=$clr1111?>;
}
.winButts > div:hover{background-color:<?=$clr11?>; cursor:pointer;}
.winButts > div > div{
	background-color:<?=$clr5?>; 
	font-family:'ff'; 
	font-size:12px; 
	height:15px;
	line-height:16px;
	min-width:15px; 
	color:#fff;
	position:absolute;
	text-align:center;
	border-radius:10px;
	margin-top:5px;
	margin-<?=$align?>:25px;
	padding:2px;
	border:1px <?=$clr55?> solid;
}
.winButts .wB_x{ background-image:url(images/sys/cancel.png);background-color:<?=$clr55?>;}
.winButts .wB_x:hover{background-color:<?=$clr5?>;}
.wB_del{background:url(images/sys/icon_c_del.png);}
.upimageCon{
	border:1px #ccc solid;
	padding:2px;
	position:relative;
	min-height:50px;
	border-radius:2px;
}
.imgUp{
    width:50px;
    height:50px;
	text-align:center;
	color:#fff;
	font-family:tahoma;
	margin:2px;
	border-radius:2px;
	background:url(images/sys/cam.png) <?=$clr1?> no-repeat center center;
}
.fileUp{
    width:50px;
    height:50px;
	text-align:center;
	color:#fff;
	font-family:tahoma;
	margin:2px;
	border-radius:2px;
	background:url(images/sys/upload.png) <?=$clr1?> no-repeat center center;
	
}
.imgUp:hover,.fileUp:hover{background-color:<?=$clr1111?>; cursor: pointer;}
.imgUpHol{
	position: relative;
    overflow: hidden;
}
.imgUpHol input {
    position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
    opacity: 0.0;
    filter: alpha(opacity=0); 
    font-size: 300px;
	height: 200px;
}
.lod_img_con{
	margin:auto;
	width:90%;
	color:#fff;
	margin-top:40px;
}
.lod_img_con div{text-align:center;}
.progressShow{
	margin-top:20px;
	margin-bottom:20px;
	height:10px;
	width:100%;
	border:1px #000 solid;
	background-color:rgba(204,204,204,0.5);
	border-radius:2px;
}
.progressShow div{
	height:10px;
	width:1px;
	background:url(images/sys/preloader2.gif) <?=$clr1?> <?=$align?> center;
	border-radius:2px;
}
.uibox{
	position:relative;
	width:50px;
	height:50px;	
	border-radius:2px;
	background-repeat:no-repeat;
	background-position:center center;
	margin:2px;
	border: 1px #ccc solid;
	box-sizing: border-box;
}
.uibox:hover{cursor:pointer;}
.imgHolder{
	margin:10px;
	position:relative;
	margin-top:60px;
}
.imgHolder img{border:1px #000 solid;}
.imagw_h_bar{
	position:absolute;
	top:0px;
	height:50px;
	width:100%;
	left:0px;
	background-color:<?=$clr1?>;
	z-index:3;
}
.winOprNote{
	margin:10px;
	color:<?=$clr1111?>;
	font-size:18px;
}
.winOprNote_err{
	margin:10px;
	color:<?=$clr5?>;
	font-size:18px;
}
.lh1{line-height:1px;}.lh20{line-height:20px;}
.lh30{line-height:30px;}.lh40{line-height:40px;}.lh50{line-height:50px;}.lh60{line-height:60px;}
.ser_but{
	width:38px;
	height:38px;
	background:url(images/sys/ser_icon.png) <?=$clr1?> no-repeat center center; 
	margin:5px;
	margin-top:0px;
	margin-<?=$align?>:0px;
	border-radius:2px;
}
.ser_but:hover{
	cursor:pointer;
	background-color:<?=$clr11?>;
}
.bigselText{
	height:36px;
	line-height:36px;
	border:1px #ccc solid;
	overflow:hidden;
	text-indent:10px;
	margin:0px;
	padding:0px;
	border-radius:2px;
    background-color: #fff;
}
#list_ser_option{
	height:38px;
	background:url(images/sys/pcat_ser.png) no-repeat <?=$align?> center; 
	margin:5px;
	margin-top:0px;
	margin-<?=$align?>:0px;
	border-radius:2px;
	text-indent:40px;
}
.bigselText:hover{background-color:#eee; cursor:pointer;}
.listOptbutt{
	line-height:20px;
	border:1px #ccc solid;
	margin-bottom:10px;
	/*text-align:center;*/
	padding:10px; 
	font-size:16px;
	border-radius:2px;
	background-color:#eee;
}
.listOptbutt:hover{cursor:pointer; background-color:<?=$clr1?>;color:#fff;}
.whIbox{
	border:1px #ccc solid;
	margin:10px;
	width:150px;
	border-radius:5px 5px 0px 0px;
}
.whIbox:hover{ background-color:#eee; cursor:pointer;}
.wh_bal{
	line-height:40px;
	height:40px;
	text-align:center;
	font-size:30px;
}
.wh_bal2{
	width:150px;
	line-height:25px;
	height:25px;
	text-align:center;
}/*
.wh_bal2 div{
	text-align:right;
	width:75px;
	font-size:14px;
	color:#fff;	
}
.wh_bal2 div:first-child{
	background:url(images/in.png) #57ba52 no-repeat right 2px;
	text-indent:30px;
}
.wh_bal2 div:last-child{
	background:url(images/out.png) #477bcc no-repeat right 2px;
	text-indent:30px;
}
.wh_balT{
	text-align:center;
	line-height:30px;
	height:30px;
	overflow:hidden;
	border-top:1px #ccc dotted;
	width:100%;
	background-color:#eee;
}
.perIcon{
	width:80px;
	height:40px;
	border-radius:2px;
	background-image:url(images/per_icon.png);
	background-repeat:no-repeat;
	background-position:<?=$Xalign?> center;
	cursor:pointer;
}
.perIcon div{
	width:40px;
	height:40px;
	line-height:40px;
	background-color:<?=$clr5?>;
	color:#fff;	
	font-size:14px;
	position:absolute;
}
.hh1_cont{position:fixed; margin:0px; z-index:1;}*/
.barReader[mode]{
	width:110px;
	height:50px;
	background-image:url(images/sys/barcode.png);
	background-repeat:no-repeat;
	background-position:center center;
}
.barReader[mode=a]:hover{background-color:#999;cursor:pointer;}
.barReader[mode=a]{background-color:#ccc;}
.barReader[mode=b]{background-color:#0c0;}
.bc_text{height:40px;position:fixed; top:-1000px;}
.barReader div{
	width:20px;
	height:20px;
	line-height:20px;
	background-color:<?=$clr5?>;
	border-radius:20px;
	padding-top:10px;
	display:none;
	color:#fff;
	text-align:center;
	font-size:18px;
}
.navMSG{	
	width:100%;
	height:100%;
	position:absolute;
	top:0px;
	z-index:150;
	display:none;
	background-color:rgba(0,0,0,0.3);	
}
.navMSG > div{
	cursor:pointer;
	max-width:400px;
	background-color:#FF0;
	line-height:30px;
	margin-left:auto;
	margin-right:auto;
	text-align:center;
	border-radius:5px;
	color:#000;
	padding:5px;
	padding-left:15px;
	padding-right:15px;
	box-shadow:#999 0px 0px 15px ;
	margin-top:35px;
}

.colorLbox{
	width:80px;
	height:36px;
	line-height:36px;
	color:#fff;
	text-shadow:0px 0px 1px #000000;	
	text-transform:uppercase;
	border:1px #f5f5f5 solid;
	font-size: 16px;
	font-family: 'ff';
	font-weight: bold;
}
.lh_days> div{
	border:1px #e8e8e8 solid;
	border-bottom:0px;
	height:6px;
	background-color:rgba(0,0,0,0.03);
}
.lh_days> div:hover{
	background-color:rgba(0,0,0,0.1);
}
.lh_days> div:last-child{border:1px #e8e8e8 solid;}
.lh_days> div > div{
	position:absolute;
	background-color:rgba(0,0,153,0.2);
	height:6px;
}
.lh_days> div > div:hover{
	background-color:rgba(250,50,50,0.5);
}
.lh_poi{height:12px;}
.lh_poi > section{
	border-<?=$align?>:1px #ccc solid;
	width:4.166%;
	position:absolute;
	height:12px;
	text-indent:3px;
	font-family:'ff';
}
.snc_prog{
	width: 100%;
	background-color: #eee;
	height: 5px;
}
.snc_prog > div{
	width: 20%;
	background-color: <?=$clr6?>;
	height: 5px;
}
/**********IC COLOR***************************************************/
.icc1{background-color: <?=$clr1?>;}.icc1:hover{background-color:<?=$clr1111?>;cursor: pointer;}
.icc2{background-color: <?=$clr5?>;}.icc2:hover{background-color:<?=$clr55?>; cursor: pointer;}
.icc3{background-color: #aaa;}.icc3:hover{background-color:#999a; cursor: pointer;}
.icc4{background-color: <?=$clr6?>;}.icc4:hover{background-color:<?=$clr66?>; cursor: pointer;}
.icc5{background-color: <?=$clr7?>;}.icc5:hover{background-color:<?=$clr77?>; cursor: pointer;}
.icc11{background-color:#5c95c5;}.icc11:hover{background-color:#337ab7;cursor:pointer;}
.icc22{background-color:#e17572;}.icc22:hover{background-color:#d9534f;cursor:pointer;}
.icc33{background-color:#7dc67d;}.icc33:hover{background-color:#5cb85c;cursor:pointer;}
/**********IC40**************************************/
.ic40{position: relative;width:40px; height: 40px; border-radius: 2px; margin: 3px; background-position: center center; background-repeat: no-repeat;}
.ic40x{width:40px; height:40px;border-radius:2px;margin:0px;background-position:center center;background-repeat: no-repeat;}
.ic40w{width:40px;height:40px;border-radius:2px;margin:0px 3px;background-position:center center;background-repeat: no-repeat;}
.ic40h{width:40px;height:40px;border-radius:2px;margin:3px 0px;background-position:center center;background-repeat: no-repeat;}
.ic40n{line-height:40px;color:#fff;font-size:18px;font-family:'ff';font-weight:bold;text-align: center;}
.ic40Txt{
	text-indent:30px;
	padding: 0px 10px;
	margin: 0px;
	font-family:'f1';
	font-size:14px;
	line-height: 40px;
	color: #fff;	
	width:auto;
	min-width: 100px;
	text-align:<?=$align?>;
	background-position:<?=$align?> center;
	overflow: hidden;	
}
.ic40 div,.ic40x div ,.ic40w div ,.ic40h div{
	height: 12px;
	line-height: 12px;
	border-radius: 10px; 
	margin: 3px;
	background-color:<?=$clr55?>;
	border:1px #999 solid;
	color:#fff; 
	float:<?=$align?>; 
	padding:0px 3px 0px 3px;
	font-size:10px; 
	position:absolute; 
	margin-top:-4px; 
	margin-<?=$align?>:-4px;
}
.ic40 div[n=a0],.ic40x div[n=a0]{background-color:#ddd;	color:#999;}
.ic40_add{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> 0px;}
.ic40_del{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -40px;}
.ic40_print{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -80px;}
.ic40_edit{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -120px;}
.ic40_ref{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -160px;}
.ic40_info{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -200px;}
.ic40_link{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -240px;}
.ic40_done{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -280px;}
.ic40_send{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -320px;}
.ic40_time{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -360px;}
.ic40_excel{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -400px;}
.ic40_save{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -440px;}
.ic40_set{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -480px;}
.ic40_report{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -520px;}
.ic40_search{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -560px;}
.ic40_reload{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -600px;}
.ic40_price{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -640px;}
.ic40_play{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -680px;}
.ic40_stop{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -720px;}
.ic40_pus{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -760px;}
.ic40_download{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -800px;}
.ic40_ord{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -840px;}
.ic40_x{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -880px;}
.ic40_image{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -920px;}
.ic40_per{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -960px;}
.ic40_note{background-image:url(images/sys/ic40_icons.png);background-position: <?=$align?> -1000px;}
/**********IC30***************************************************/
.ic30{position: relative;width:30px; height: 30px; border-radius: 2px; margin: 3px; background-position: center center; background-repeat: no-repeat;}
.ic30x{width:30px; height:30px;border-radius:2px;margin:0px;background-position:center center;background-repeat: no-repeat;}
.ic30w{width:30px;height:30px;border-radius:2px;margin:0px 3px;background-position:center center;background-repeat: no-repeat;}
.ic30h{width:30px;height:30px;border-radius:2px;margin:3px 0px;background-position:center center;background-repeat: no-repeat;}
.ic30n{line-height:30px;color:#fff;font-size:18px;font-family:'ff';font-weight:bold;text-align: center;}
.ic30Txt{
	text-indent:20px;
	padding: 0px 10px;
	margin: 0px;
	font-family:'f1';
	font-size:12px;
	line-height:30px;
	color: #fff;	
	width:auto;
	min-width:80px;
	text-align:<?=$align?>;
	background-position:<?=$Xalign?> center;
	overflow: hidden;
}
.ic30 div,.ic30x div ,.ic30w div ,.ic30h div{
	height: 12px;
	line-height: 12px;
	border-radius: 10px; 
	margin: 3px;
	background-color:<?=$clr55?>;
	border:1px #999 solid;
	color:#fff; 
	float:<?=$align?>; 
	padding:0px 3px 0px 3px;
	font-size:10px; 
	position:absolute; 
	margin-top:-4px; 
	margin-<?=$align?>:-4px;
}
.ic30 div[n=a0],.ic30x div[n=a0]{background-color:#ddd;	color:#999;}
.ic30_add{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> 0px;}
.ic30_del{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -30px;}
.ic30_print{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -60px;}
.ic30_edit{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -90px;}
.ic30_ref{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -120px;}
.ic30_info{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -150px;}
.ic30_link{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -180px;}
.ic30_done{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -210px;}
.ic30_send{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -240px;}
.ic30_time{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -270px;}
.ic30_excel{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -300px;}
.ic30_save{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -330px;}
.ic30_set{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -360px;}
.ic30_report{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -390px;}
.ic30_search{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -420px;}
.ic30_reload{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -450px;}
.ic30_price{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -480px;}
.ic30_play{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -510px;}
.ic30_stop{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -540px;}
.ic30_pus{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -570px;}
.ic30_download{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -600px;}
.ic30_ord{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -630px;}
.ic30_x{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -660px;}
.ic30_image{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -690px;}
.ic30_per{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -720px;}
.ic30_note{background-image:url(images/sys/ic30_icons.png);background-position: <?=$align?> -750px;}
/**********I40***************************************************/
.i40{width:40px;height:40px;background-position:center center;background-repeat:no-repeat;}
.i40:hover{background-color:rgba(0,0,0,0.1);cursor: pointer;}
.i40_add{background-image:url(images/sys/i40_icons.png);background-position: 0px center;}
.i40_del{background-image:url(images/sys/i40_icons.png);background-position: -40px center;}
.i40_res{background-image:url(images/sys/i40_icons.png);background-position: -80px center;}
.i40_done{background-image:url(images/sys/i40_icons.png);background-position: -120px center;}
.i40_edit{background-image:url(images/sys/i40_icons.png);background-position: -160px center;}
.i40_info{background-image:url(images/sys/i40_icons.png);background-position: -200px center;}
.i40_price{background-image:url(images/sys/i40_icons.png);background-position: -240px center;}
.i40_view{background-image:url(images/sys/i40_icons.png);background-position: -280px center;}
.i40_save{background-image:url(images/sys/i40_icons.png);background-position: -320px center;}
.i40_set{background-image:url(images/sys/i40_icons.png);background-position: -360px center;}
.i40_print{background-image:url(images/sys/i40_icons.png);background-position: -400px center;}
.i40_loc{background-image:url(images/sys/i40_icons.png);background-position: -440px center;}
.i40_time{background-image:url(images/sys/i40_icons.png);background-position: -480px center;}
.i40_report{background-image:url(images/sys/i40_icons.png);background-position: -520px center;}
.i40_up{background-image:url(images/sys/i40_icons.png);background-position: -560px center;}
.i40_down{background-image:url(images/sys/i40_icons.png);background-position: -600px center;}
.i40_link{background-image:url(images/sys/i40_icons.png);background-position: -640px center;}
.i40_ser{background-image:url(images/sys/i40_icons.png);background-position: -680px center;}
.i40_cal{background-image:url(images/sys/i40_icons.png);background-position: -720px center;}
.i40_send{background-image:url(images/sys/i40_icons.png);background-position: -760px center;}
.i40_ord{background-image:url(images/sys/i40_icons.png);background-position: -800px center;}
.i40_x{background-image:url(images/sys/i40_icons.png);background-position: -840px center;}
/**********I30***************************************************/
.i30{width:30px;height:30px;background-position:center center;background-repeat:no-repeat;}
.i30:hover{background-color:rgba(0,0,0,0.1);cursor: pointer;}
.i30_add{background-image:url(images/sys/i30_icons.png);background-position: 0px center;}
.i30_del{background-image:url(images/sys/i30_icons.png);background-position: -30px center;}
.i30_res{background-image:url(images/sys/i30_icons.png);background-position: -60px center;}
.i30_done{background-image:url(images/sys/i30_icons.png);background-position: -90px center;}
.i30_edit{background-image:url(images/sys/i30_icons.png);background-position: -120px center;}
.i30_info{background-image:url(images/sys/i30_icons.png);background-position: -150px center;}
.i30_price{background-image:url(images/sys/i30_icons.png);background-position: -180px center;}
.i30_view{background-image:url(images/sys/i30_icons.png);background-position: -210px center;}
.i30_save{background-image:url(images/sys/i30_icons.png);background-position: -240px center;}
.i30_set{background-image:url(images/sys/i30_icons.png);background-position: -270px center;}
.i30_print{background-image:url(images/sys/i30_icons.png);background-position: -300px center;}
.i30_loc{background-image:url(images/sys/i30_icons.png);background-position: -330px center;}
.i30_time{background-image:url(images/sys/i30_icons.png);background-position: -360px center;}
.i30_report{background-image:url(images/sys/i30_icons.png);background-position: -390px center;}
.i30_up{background-image:url(images/sys/i30_icons.png);background-position: -420px center;}
.i30_down{background-image:url(images/sys/i30_icons.png);background-position: -450px center;}
.i30_link{background-image:url(images/sys/i30_icons.png);background-position: -480px center;}
.i30_ser{background-image:url(images/sys/i30_icons.png);background-position: -510px center;}
.i30_cal{background-image:url(images/sys/i30_icons.png);background-position: -540px center;}
.i30_send{background-image:url(images/sys/i30_icons.png);background-position: -570px center;}
.i30_ord{background-image:url(images/sys/i30_icons.png);background-position: -600px center;}
.i30_x{background-image:url(images/sys/i30_icons.png);background-position: -630px center;}
/*************************************************************/
.ti40{
	text-indent: 44px;
	background-position: center <?=$align?>;
	background-repeat: no-repeat;
}
.mover{border-radius:20px;width:40px; height:40px; background:url(images/sys/move.png) <?=$clr3?> no-repeat center center;}
.mover:hover{background-color:<?=$clr2?>; cursor:move;}
input[but]{
	height:40px;
	line-height:40px;
	width:120px;
	border-bottom:2px solid #ddd;
	padding: 0px;
	text-align: center;
	text-indent: 0px;
}
.radioBlc_each[par=txt] .ri_labl{font-family:'f1';}
/****/

/****/
.cenLoader{
	position:absolute;
	top: 40px;
	z-index: 2;
	line-height:60px;
	height: 60px;
	min-width:100%;	
	display: none;
	background-color:#fbf396;
}
.cenLoader div{
	width:220px;	
	margin: 0px auto;
}
.short_loader{
	background:url(images/load.gif) no-repeat center;
	width:40px;
	height:40px;
}

    
.repNavInput{
	width:100%;
	line-height: 40px;
	height: 40px;
	border: 3px <?=$clr2?> solid;
	margin: 0px;
	padding: 0px;
	box-sizing: border-box;
	text-align: center;	
}
.repNavInput:focus {
  border: 3px <?=$clr2?> solid;
}
.dateHeader{
	height:40px;
	background-color:<?=$clr2?>;
	margin:5px;
	margin-bottom:0px;
	border-radius:2px;
}
.dHeader{
	line-height:40px;
	color:#fff;
	font-size:16px;
	text-align:center;
	padding-left:10px;
	padding-right:10px;
}
.dHeader:hover{ background-color:<?=$clr1?>; cursor:pointer;}
.dHYear{
	margin-top:10px;
	height:30px;
	line-height:30px;
	color:#fff;
	font-size:20px;
	text-align:center;
	width:80px;
}
.dth{
	width:40px;
	height:40px;
}
.dth:hover{ background-color:<?=$clr1?>; cursor:pointer;}
.dt_l{ background:url(images/sys/date_arows.png) no-repeat <?=$align?> center;}
.dt_r{ background:url(images/sys/date_arows.png) no-repeat <?=$Xalign?> center;}
.txt_Over:hover{color:<?=$clr1?>; cursor:pointer; display:block;}

.ropTool .dateHead{
	height:40px;
	background-color:<?=$clr2?>;	
	margin:10px 0px;
	border-radius:2px;
}
.ropTool input{
	width:100%;
	line-height: 40px;
}

.catListStyle > div{
	line-height:20px;
	padding:10px;
	margin-bottom:5px;
	border-radius:2px;
	border-bottom:2px #ccc solid;	
	margin-<?=$Xalign?>:3px;
	font-family:'f1',tahoma;
	font-size:14px;	
	background-color:#eee;
	margin-<?=$Xalign?>:8px;
	position: relative;
}
.catListStyle > div:hover{
	background-color:#ccc;
	cursor:pointer;
	border-bottom:2px #ccc solid; 
}
.catListStyle > [actCat]{
	line-height:20px;
	padding:12px;
	background:url(images/sys/over_arrw_<?=$align?>.png) <?=$clr1?> no-repeat <?=$Xalign?> center;
	color:#fff;
	border-bottom:0px #fff solid;	
	margin-<?=$Xalign?>:0px;
}
.catListStyle > [actCat]:hover{
	background-color:<?=$clr11?>;
	cursor:pointer;
	border-bottom:0px #fff solid;
}
.listStyle > div{
	line-height:20px;
	padding:10px;
	margin-bottom:5px;
	border-radius:2px;
	border-bottom:2px #ccc solid;
	font-family:'f1',tahoma;
	font-size:14px;	
	background-color:#eee;	
	position: relative;
}
.listStyle > div:hover{
	background-color:#ccc;	
	cursor:pointer;	
}
.listStyle > [act]{
	line-height:20px;	
	background-color:<?=$clr1?>;
	color:#fff;	
}
.listStyle > [act]:hover{
	background-color:<?=$clr11?>;
	cursor:pointer;	
}
/**********favorite list****************/
.thicF{
	width:40px;
	height:40px;
	box-sizing:border-box;	
	background-repeat: no-repeat;
	background-image: url(images/sys/mwtopicon.png);
}
.thicF:hover{background-color:<?=$clr2?>; cursor: pointer;}
.favSet{background-position:-360px 0px;}
.favOrd{background-position:-400px 0px;}
.favAdd{background-position:-440px 0px;}
.favDel{background-position:-480px 0px;}
.profEdit{background-position:-520px 0px;}
.favHopr{
	line-height: 40px;	
	width: 100%;
	position: relative;
	float:<?=$align?>;
	background-color:#000;
	color:#ccc;
	margin-bottom: 20px;
}
.favHopr:hover{
	background-color:<?=$clr1111?>;
	color:#fff;
	cursor: pointer;
}
.mp_title{
	
	background-color: #000;		
	box-sizing:padding-box;
	padding: 10px 0px 10px 0px;
	margin-bottom: 10px;
}
/*********************************/	
.fmOrdMod div{
	background-color:<?=$clr3?>;
	height:40px;
	line-height:40px;
	margin-bottom:10px;
	color:#fff;
	border-radius:1px;
}
.fmOrdMod div:hover{background-color:<?=$clr2?>; cursor:pointer;}
.cMulSel{
	height: 30px;
	line-height: 30px;
	padding: 5px 10px 5px 10px;
	margin: 2px;
	border: 1px #ccc solid;
	float: <?=$align?>;
	color: #666;
	font-size: 14px;
	border-radius: 2px;
}
/***************************/
.notificationsMenu{
	line-height: 24px;
	font-size: 15px;
	font-weight: bold;
	text-align: center;
	width: 33px;
	height: 25px;
	border-<?=$align?>: 1px solid #ccc;
	color: transparent;
	text-shadow: 0 0 0 <?=$clr1?>;
	/*background:url(images/bell.png) no-repeat center center;*/
}
.notificationsMenu:hover{
	cursor:default;
	background-color: <?=$clr1?>;
	color: transparent;
	text-shadow: 0 0 0 #fff;
}

@keyframes redF1 {	
    0%  {background-color: #cc4646;}
	60%  {background-color: #cc4646;}    
}
.redFlash{
	background-color:<?=$clr5?>;	
    animation-name:redF1;
    animation-duration:0.5s;
	animation-iteration-count: infinite;
	z-index: 1;
	color:#fff;	
}
.act_0{background:url(images/sys/act_0.png) no-repeat center center;width:30px;height: 30px; }
.act_1{background:url(images/sys/act_1.png) no-repeat center center;width:30px;height: 30px; }

@keyframes fl3 {
	50%  {background-color: #ccc;}
    
    100%  {background-color: #4dc121;}	
}
.fl3{
	background-color:<?=$clr5?>;	
    animation-name:fl3;
    animation-duration:0.3s;
	animation-iteration-count: infinite;
	z-index: 1;
	color:#fff;
}
.th_menu_src input{
	background-color:<?=$clr3?>;
	border:0px;
	width: 100%;
	height:40px;
	padding: 0px;
	margin: 0px;
	
	color: #f5f5f5;
	outline: none;
}


.highcharts-title{
	font-family:'f1',tahoma;
	font-size:18px;
}

.highcharts-title {font-size:22px; font-family: 'f1';}
.helpTree > div{
	line-height: 25px;
	text-indent:5px;
	margin-top: 5px;
	width: 100%;
	float:<?=$align?>;
	position: relative;
}
.helpTree div[t]{
	line-height: 20px;
	font-family: 'f1';	
	margin-<?=$align?>:5px;
	float:<?=$align?>;
}
.helpTree div[t=off]:hover{
	cursor: pointer;
	color: <?=$clr8?>;
}
.helpTree div[t=off]{color:#666;}
.helpTree div[t=on]{color:<?=$clr5?>;}

.helpTree div[s]{	
	width: 20px;
	height: 20px;
	background-position: center center;
	background-repeat: no-repeat;
	
	float:<?=$align?>;
	
}
.helpTree div[s=off]{background-image: url(images/sys/tree1.png);}
.helpTree div[s=on]{background-image: url(images/sys/tree0.png);}
.helpTree div[ms] div{
	margin-<?=$align?>: 20px;
	margin-<?=$Xalign?>: 10px;
	margin-bottom: 5px;
	border-bottom: 1px #eee dotted
}
.helpTree div[sTit]:hover{
	color:<?=$clr1?>;
	cursor: pointer;
}
.helpDet .vid{
	line-height: 20px;
	margin-bottom: 5px;
	background: url(images/sys/hlp_video.png) no-repeat <?=$align?> top;
	text-indent: 30px;
	color:<?=$clr5?>;
	padding: 2px;
}
.helpDet .vid:hover{
	 background-color: #f5f5f5;
	 cursor: pointer;
}
.setCat div{
	border:1px #ccc solid;
	margin-bottom:5px;
}
.setCat div:hover{
	background-color:<?=$clr1?>;
	cursor: pointer;
	color: #fff;
}
.setCat div[act]{
	background-color:<?=$clr1111?>;
	cursor: pointer;
	color: #fff;
}
/***********************************************************/
.mgA{margin:0px auto;}
.pd20{padding-left:20px;padding-right:20px;}.pd10{padding-left:10px;padding-right:10px;}.pd5{padding-left:5px;padding-right:5px;}
.mg20{margin-left:20px; margin-right:20px;}.mg10{margin-left:10px; margin-right:10px;}.mg5{margin-left:5px; margin-right:5px;}
.pd20f{padding:20px;}.pd10f{padding:10px;}.pd5f{padding:5px;}    
.mg20f{margin:20px;}.mg10f{margin:10px;}.mg5f{margin:5px;}
.pd20v{padding-top:20px;padding-bottom:20px;}.pd10v{padding-top:10px;padding-bottom:10px;}.pd5v{padding-top:5px;padding-bottom:5px;}
.mg20v{margin-top:20px; margin-bottom:20px;}.mg10v{margin-top:10px; margin-bottom:10px;}.mg5v{margin-top:5px; margin-bottom:5px;}
.mg20t{margin-top:20px;}.mg10t{margin-top:10px;}.mg5t{margin-top:5px;}
.mg20b{margin-bottom:20px;}.mg10b{margin-bottom:10px;}.mg5b{margin-bottom:5px;}
.pd20t{padding-top:20px;}.pd10t{padding-top:10px;}.pd5t{padding-top:5px;}
.pd20b{padding-bottom:20px;}.pd10b{padding-bottom:10px;}.pd5b{padding-bottom:5px;}
.mg20l{margin-<?=$align?>:20px;}.mg10l{margin-<?=$align?>:10px;}.mg5l{margin-<?=$align?>:5px;}
.mg20r{margin-<?=$Xalign?>:20px;}.mg10r{margin-<?=$Xalign?>:10px;}.mg5r{margin-<?=$Xalign?>:5px;}
.pd20l{padding-<?=$align?>:20px;}.pd10l{padding-<?=$align?>:10px;}.pd5l{padding-<?=$align?>:5px;}
.pd20r{padding-<?=$Xalign?>:20px;}.pd10r{padding-<?=$Xalign?>:10px;}.pd5r{padding-<?=$Xalign?>:5px;}
/***********************************************************/
.br0{border-radius:0px;}
.br2{border-radius:2px;}
.br5{border-radius:5px;}
.br10{border-radius:10px;}
.br50{border-radius:50%;}
.bord0{border:0px #000 solid;}

    
.ui-tooltip > div{ 
   padding:5px ;
   border: 3px #eee solid;
   font-family: 'f1',tahoma;
}
[HhB]{
    cursor:help;
}
/*************************UPBOX**************************************/
.upBox{    
    height:70px;
	width:100%;	
	border:1px #ccc solid;	
	background-size: 70px auto;
    position: relative;
    box-sizing: border-box;    
}
.upBox[m="1"]{
    display:grid;
    grid-template-columns:70px 1fr;
    grid-template-rows:68px;
}
.upBox[m="0"] .dataBar{
    width: 100%;
}
.upBox [addImg]{
    height: 100%;
    float: <?=$align?>;
    cursor: pointer;
    border-<?=$Xalign?>:1px #ccc solid;
	background:url("images/sys/add_b.png") #ffe no-repeat center center;
	box-sizing: border-box;
    box-sizing: content-box;    
}
.upBox [addImg]:hover{
    height: 66px;
    background-color:#eee;border:1px <?=$clr2?> dashed;
}
.upBox [add]{width:100%;}
.upBox [addB]{width:70px;}
.upBox [addImg].upBox_over{
    height: 66px;
	border:1px <?=$clr2?> dashed;
	background-color: <?=$clr666?>;   
}
.dataBar{
    padding:0px 10px;
    height:68px;
    float: <?=$align?>;    
    box-sizing: border-box;
    position: relative;
}
.dataBar > div{
    margin-top:8px;
    margin-bottom:7px;    
    position: relative;
}
.upBox [delI]{
    width:30px;
    height:50px;
    background: url("images/sys/cancel.png") #F8ACAD no-repeat center center;
    float:<?=$Xalign?>;
}
.upBox [delI]:hover{
    background-color:<?=$clr5?>;
    cursor:pointer;
}
.upBox [szI]{
    font-family: 'ff' tahoma;
    color:<?=$clr55?>;
}
.upBox [imgC]{
    display:grid;
    grid-template-columns:60px 1fr;
    grid-template-rows:50px;
    background-color: #f5f5f5;
    border:1px #ccc solid;
}
.progRes{
	width:100%;
	/*max-width: 520px;	*/
	height: 68px;	
	padding: 10px;	
    background-color: #efe;
    position: absolute;
    z-index: 1;
}
.progResDel{
	width:100%;	
	height: 68px;	
	padding: 10px;    
    position: absolute;
    z-index: 1;
    background-color:#fee;
    text-indent: 40px;
}
.progResDel div{
	margin: 0px auto;
	height: 48px;
    line-height: 48px;
    background: url("images/sys/load.gif") no-repeat <?=$align?> center;
    text-indent:20px;
}
.ub_sta{
    max-height: 40px;
    min-height: 30px;    
	line-height: 20px;
	color:#464a53;
    direction:ltr;
    overflow:hidden;
}
.ub_sta ff{
    color:<?=$clr5?>;
    font-size: 12px;
}
.progBar{
	height: 12px;
	background-color:#eee;
	border-radius: 2px;
}
.progBar div{
	height: 12px;
    width:0%;
	line-height: 12px;
	background-image:url("images/sys/preloader.gif");
	background-position: <?=$align?> center;
	background-size: 12px 12px;;
	border-radius: 2px;
	font-size: 10px;
	color: #fff;
	overflow: hidden;
	text-align: center;
}
/*************************TP**************************************/
.editEidtor{
    width: 100%;
    height: 40px;
    border: 1px #ccc solid;
    background:url("images/sys/editEditor.png") #f8f8f8 no-repeat <?=$align?> center;
}
.editEidtor > div{    
    margin-<?=$align?>: 50px;
    line-height: 40px;
    color: #666;
}
.editEidtor:hover{
    cursor:pointer;
    background-color: #eee;
}
.ic40_tp_c1{background-image:url("images/sys/tp/c1.png");}
.ic40_tp_c11{background-image:url("images/sys/tp/c11.png");}
.ic40_tp_c111{background-image:url("images/sys/tp/c111.png");}
.ic40_tp_c12{background-image:url("images/sys/tp/c12.png");}
.ic40_tp_c21{background-image:url("images/sys/tp/c21.png");}
.ic40_tp_c12{background-image:url("images/sys/tp/c21.png");}
.ic40_tp_h1{background-image:url("images/sys/tp/h1.png");}
.ic40_tp_h2{background-image:url("images/sys/tp/h2.png");}
.ic40_tp_h3{background-image:url("images/sys/tp/h3.png");}
.ic40_tp_h4{background-image:url("images/sys/tp/h4.png");}
.ic40_tp_p{background-image:url("images/sys/tp/p.png");}    
.ic40_tp_hp{background-image:url("images/sys/tp/hp.png");}
.ic40_tp_img{background-image:url("images/sys/tp/img.png");}

/*******************************************/ 
.tpEditorRows , .tpEditorRowsTemp{
	border:0px solid #ddd;
    margin: 10px;	
}
.tpEditorRows > div , .tpEditorRowsTemp> div{
    border:1px #ddd dashed;
    padding:5px;    
    background-color: #eee;     
}
.tpEditorRows [tp_type],.tpEditorRowsTemp [tp_type]{display: grid;}
.tpEditorRows [tp_type="1"]{grid-template-columns:40px 1fr 40px;gap:5px;}
.tpEditorRows [tp_type="11"]{grid-template-columns:40px 1fr 1fr 40px;gap:5px;}
.tpEditorRows [tp_type="111"]{grid-template-columns:40px 1fr 1fr 1fr 40px;gap:5px;}
.tpEditorRows [tp_type="21"]{grid-template-columns:40px 2fr 1fr 40px;gap:5px;}
.tpEditorRows [tp_type="12"]{grid-template-columns:40px 1fr 2fr 40px;gap:5px;}

.tpEditorRowsTemp [tp_type="1"]{grid-template-columns:1fr;gap:5px;}
.tpEditorRowsTemp [tp_type="11"]{grid-template-columns:1fr 1fr;gap:5px;}
.tpEditorRowsTemp [tp_type="111"]{grid-template-columns:1fr 1fr 1fr;gap:5px;}
.tpEditorRowsTemp [tp_type="21"]{grid-template-columns:2fr 1fr;gap:5px;}
.tpEditorRowsTemp [tp_type="12"]{grid-template-columns:1fr 2fr;gap:5px;}
[tpAct]{background-color: <?=$clr1111?>;}
.tpEditorRows .reSoHold{
    padding:0px;
    width:40px;
    min-height:60px;
    border:0px #ddd dashed;
}
.tpEditorRows [tpBlcCode]{
    background-color: #fff;
    border:1px #ddd dashed;
    padding: 10px;
    display: grid;
    grid-template-rows: 1fr 30px;
}
.tp_toolList{overflow-x: hidden;}
[emptyTp]{
    position: relative;
    background-color: #ddd;
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    min-height: 80px;
    margin-bottom: 10px;
}
[emptyTp=img]{background-image: url("images/sys/tp/img.png");}
[emptyTp=h2]{background-image: url("images/sys/tp/h2.png");}
[emptyTp=h3]{background-image: url("images/sys/tp/h3.png");}
[emptyTp=h4]{background-image: url("images/sys/tp/h4.png");}
[emptyTp=hp]{background-image: url("images/sys/tp/hp.png");}
[emptyTp=p]{background-image: url("images/sys/tp/p.png");}
/****/
.tpEditorDemo{padding: 20px;}
.tpEditorDemo [tpBlc]{padding: 0px;}
.tpEditorDemo [tp_t]{display: grid;}
.tpEditorDemo h2{font-size:18px;}
.tpEditorDemo h3{font-size:16px;}
.tpEditorDemo h4{font-size:14px;}
.tpEditorDemo p{font-size:12px; line-height: 20px;}


.tpEditorDemo [tp_t="1"]{grid-template-columns:1fr;gap:10px;}
.tpEditorDemo [tp_t="11"]{grid-template-columns:1fr 1fr;gap:10px;}
.tpEditorDemo [tp_t="111"]{grid-template-columns:1fr 1fr 1fr;gap:10px;}
.tpEditorDemo [tp_t="21"]{grid-template-columns:2fr 1fr;gap:10px;}
.tpEditorDemo [tp_t="12"]{grid-template-columns:1fr 2fr;gap:10px;}
    
@media only screen and (max-width:700px) {
	.tpEditorDemo [tp_t="1"]{grid-template-columns:1fr;gap:10px;}
    .tpEditorDemo [tp_t="11"]{grid-template-columns:1fr 1fr;gap:10px;}
    .tpEditorDemo [tp_t="111"]{grid-template-columns:1fr;gap:10px;}
    .tpEditorDemo [tp_t="21"]{grid-template-columns:1fr 1fr;gap:10px;}
    .tpEditorDemo [tp_t="12"]{grid-template-columns:1fr 1fr;gap:10px;}
}
@media only screen and (max-width:500px) {
	.tpEditorDemo [tp_t="1"]{grid-template-columns:1fr;gap:10px;}
    .tpEditorDemo [tp_t="11"]{grid-template-columns:1fr;gap:10px;}
    .tpEditorDemo [tp_t="111"]{grid-template-columns:1fr;gap:10px;}
    .tpEditorDemo [tp_t="21"]{grid-template-columns:1fr;gap:10px;}
    .tpEditorDemo [tp_t="12"]{grid-template-columns:1fr;gap:10px;}
}
/*************************VI**************************************/
.imgViewer{
    width: auto;
    display: flex;
    gap:5px;
    margin:5px;
    padding:5px;
    border:1px #ccc solid;
    flex-wrap:  wrap ;
    background: #eee;
    border-radius: 3px;
}
.imgViewer [iv]{
    border:1px #ccc solid;
    background: #fff;
    border-radius:3px;
    position: relative;    
    padding:5px; 
    width:auto;
}
.imgViewer [iv]:hover > div {display: block; cursor: pointer;}
.imgViewer [iv] img{
    margin: 0px;
    background: #fff;
    border-radius: 2px;
    position: relative;
}
.imgViewer [iv] >div{
    position: absolute;
    background:rgba(0,0,0,.5);
    height: 100%;
    width: 100%;
    margin-top: -5px;
    margin-<?=$align?>: -5px;
    z-index: 2;
    display: none;
    background-image: url("images/sys/iv/imgZoom.png");
    background-position: center center;
    background-repeat: no-repeat;
}
.IVWin{
    position: fixed;
    display: grid;
    grid-template-columns:200px 1fr;
    grid-template-rows: 41px 1fr;
    top:0;
    width:100%;
    height:100%;
    background-color:#000;
    z-index: 1000;
    overflow: hidden;    
    box-sizing: border-box;
}
.IVWin .ivTool{
    background-color:#222;
    border-bottom:1px #333 solid;
}
.IVWin .ivTool div{
    width:40px;
    height: 40px;       
    background-repeat: no-repeat;
    background-position: center;
    background-size: 40px 40px;
}
.IVWin .ivTool div:hover{
    cursor: pointer;
    background-color: #333;
}
.IVWin .ivTool div[x]{
    background-color:#933;
    background-image: url("images/sys/cancel.png");
    background-size: 25px 25px;
}
.IVWin .ivTool div[x]:hover{background-color:#B53335;}
.IVWin .ivTool div[zOut]{background-image: url("images/sys/iv/iv_zIn.png");}
.IVWin .ivTool div[zIn]{background-image: url("images/sys/iv/iv_zOut.png");}
.IVWin .ivTool div[org]{background-image: url("images/sys/iv/iv_zOrg.png");}
.IVWin .ivTool div[str]{background-image: url("images/sys/iv/iv_zStr.png");}
.IVWin .ivInfo{
    grid-row:span 2;
    background-color: #eee;
    border-<?=$Xalign?>:3px #ccc solid;
}
.IVWin .iv_infoIn{
    display: grid;
    grid-template-columns: 1fr;
    gap:6px 10px;
    margin: 10px 0;
}
.IVWin .iv_infoIn > div{
    font-family: 'f1';
    font-size: 16px;    
}
.IVWin .iv_infoIn [t]{font-size: 11px;color: #888;line-height:12px;}
.IVWin .iv_infoIn [v]{color: <?=$clr1?>; margin-bottom: 10px;line-height:15px;}
.IVWin .ivSrc{     
    overflow:hidden;
    position: relative;
    display: grid;
    grid-template: 1fr / 1fr;
    direction:ltr;
}
.IVWin #ivBox{  
    margin: auto;     
    position: relative;
    padding:0px;
    background-color: #666;    
    cursor: all-scroll;
    
}
.IVWin [ivLoader]{

}
.IVWin [ivLoader] [t]{
    color: #fff;
    font-family: 42px;
    font-family: 'f1';
    margin-bottom: 10px;
    text-align: center;
}
.IVWin [ivLoader] [l]{
    width: 240px;
    max-width: 100%;
    height:8px;    
    background-color: #eee;      
}
.IVWin [ivLoader] [l] div{
    width:0px;
    height:8px;
    background-color:#6ABF71;
    background-size: 15px auto;    
    color: #fff;    
    overflow: hidden;
    text-align: center;
}
.onlBlc {    
	margin:10px 0px;;
    border: 0px;
    display: flex;  
    flex-wrap:wrap;
    gap: 10px;
    align-items: stretch  ;
    max-width: 100%;
    padding: 10px;
}
/****/
.onlBlc > div{
    background-color: #fff;
    display: grid;
    grid-template-columns: 80px 1fr ;
    width:250px;
    text-align: center;
    font-family: 'f1';
    padding: 10px;
    align-items: center;
    height:auto;
    border-radius: 5px;
}
.onlBlc  div{    
    text-align: center;
    font-family: 'f1';
    height: auto;
}
.onlBlc [mod]{
    border-top: 1px #eee solid;
    grid-column: span 2;
    padding: 10px 0;
}
.onlBlc [n]{
    font-size: 14px;    
}
.onlBlc [g]{
    font-size: 12px;
    color:<?=$clr8?>;
    margin-bottom: 10px;
}

.onlBlc [s='0']{display:none;}
.onlBlc [s='1']{display: block;}

.onlBlc [t]{	
	font-family: 'f1';
	color:<?=$clr55?>;
	font-size: 22px;
	font-weight: bold;    
    margin: 10px;
}
.onlBlc [mod] div{	
    margin:3px 3px;    
    padding: 1px 5px;
    float: <?=$align?>;
    font-size: 10px;
    border-<?=$Xalign?>:1px #ccc solid;
    font-family: 'f1';
}
.onlBlc [mod] div:last-child{
    border-<?=$Xalign?>:0px #ccc solid;
}
.onlBlc [mod] [b='0']{color: <?=$clr2?>;}
.onlBlc [mod] [b='1']{color: #ccc;}
    
    
.infoTable_s{
    border: 1px #ccc solid;
    border-collapse:collapse;
	border-collapse:separate;
}
.infoTable_s th{
	height:40px;
	background-color:#eee;
	color:#000;
	border-bottom:1px solid #cacbd0;	
    padding: 0px 10px;
    font-family: 'f1';
    text-align: <?=$align?>;
}
.infoTable_s td{
	height:30px;
	color:#676771;
	border-bottom:1px solid #eaeaea;	
    padding: 6px 10px;
    font-family: 'f1';
}
.infoTable_s td[txt]{
    font-family: 'f1';
    font-size: 14px;
}    
.infoTable_s td span{
	color:<?=$clr1?>;
}
.infoTable_s td:last-child{
	border-<?=$Xalign?>:1px solid #eaeaea;
}
.infoTable_s tr:first-child td{
	border-top:1px solid #eaeaea;
}

/************************************/
[sync_item],[sync_day]{
    line-height: 30px;
    border: 1px #eee solid;
    margin-bottom: 5px;
    padding: 0px 10px;
    background-position: <?=$Xalign?> center;
    background-repeat: no-repeat;
    border-radius:5px;
    color: #666
}
[sync_day]{
    background-color: #fff;
}
[sync_item][status='0'],[sync_day][status='0']{
    background-color: #f5f5f5;
    background-image: url("images/den/ic30_os4.png");
}
[sync_item][status='1'],[sync_day][status='1']{
    background-color: #DEEBF7;
    background-image: url("images/sys/load.gif");
    background-origin: content-box;
}
[sync_item][status='2'],[sync_day][status='2']{
    background-color: #E8F7E6;
    background-image: url("images/den/ic30_os2.png");
}
/*************************************/
.of{overflow:hidden;}
.pa{position:absolute;}
.ofx{overflow-x:hidden;}
.ofy{overflow-y:hidden;}
.ofxy{overflow:auto;overflow-x:visible;position:relative;}
.in{display:inline-block;}
.pr{position:relative;}
[act_s1]{background-color:<?=$clr777?>;}




/******************************************* */
.winBody{
	height: 100%;	
	display: grid;
	grid-template-rows: auto 1fr auto;
	overflow: hidden;
	max-height: calc(100vh - 60px);
	/* width:auto; */
}
.formHeader{
	padding-inline:10px;

}
.JQwin {
	min-width: 650px;
}
[role="dialog"]:has( .winBody){min-width: 650px;}
.formBody{
	padding:10px;
	margin: 10px;
	overflow-x: hidden;
	background-color: #fff;
	border: 2px #ddd solid;
	width:inherit;
	min-width: minmax(650px 100%);
	border-radius: 5px;
	
}
.formFooter{
	padding:10px;
	padding-top: 0;
}

.formTable{width:100%;}
.formTable tr{
	/* display: flex;
	flex-direction: column; */
}
.formTable td{
	border-bottom:2px #f5f5f5 solid;
	padding:6px;
}
.formTable td[i] span{
	font-size:11px;
	color:#ccc;
}
.formTable td[n]{
	color:<?=$clr1111?>;
	font-family:'f1',tahoma;
	font-size:14px;	
	height:38px;
	width: 130px;
}
.formTable td[n] span{
	color:<?=$clr5?>;
}
.formTable td[n] b{
	font-size:12px;
	color:#999;
	font-weight:normal;
	font-family:Tahoma, Geneva, sans-serif;
}
@media only screen and (max-width:650px) {	
	.formBody{		
		min-width:auto;
	}
	.JQwin {
		min-width: auto;
	}
	[role="dialog"]{min-width: auto;}
	.formTable tr{
		display: flex;
		flex-direction: column;
	}
	.formTable td , .formTable td[n]{
		width: auto;
	}
	.formTable tr{
		border: 1px #ccc solid;
		margin-bottom: 10px;
		background-color: #f5f5f5;
		border-radius: 5px;
	}
	.formTable td[n]{
		height: auto;
		border-bottom: 0px;
	}
}

</style>