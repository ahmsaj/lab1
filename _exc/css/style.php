
<? session_start();/**EXC***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}

.ic60{width:60px; height: 60px; border-radius: 2px; margin: 3px; background-position: center center; background-repeat: no-repeat; background-image:url(images/icon_flag_finish4.png);}
.ic40_exc_report{background-image:url(images/exc_report_icon.png);}
.ic40_add_new{background-image:url(images/exc_icon_add_new.png);}
.ic40_up2{background-image:url(images/exc_icon_up.png);}
.ic40_down2{background-image:url(images/exc_icon_down.png); bottom;}
.ic40_play{background-image:url(images/exc_play.png);}
.ic40_stop{background-image:url(images/exc_stop.png);}
.ic40_pus{background-image:url(images/exc_pus.png);}
.ic40_code{background-image:url(images/exc_icon_code.png);}
.ic40_icon_finish{background-image: url(images/exc_icon_finish.png);}
.ic40_icon_continue{background-image: url(images/exc_icon_continue.png);}
.ic40_exc_export{background-image:url(images/exc_export.png); bottom;}

.reportFin{
	border:1px #999 solid;
	border-bottom:6px #666 solid;	
	float:<?=$align?>;
	width:50%;
	margin-top:15%;
	margin-right:25%;
	
	padding-bottom:0px;
	text-align:center;
	margin-<?=$Xalign?>:8px;
	background-color: antiquewhite;
	border-radius: 4px;
}
.bLine{border-bottom:1px #999 solid; margin-bottom:10px;}
.snc_prog1{
	width: 100%;
	background-color: #eee;
	height: 5px;
}
.snc_prog1> div{
	width: 20%;
	background-color: <?=$clr1?>;
	height: 5px;
}
	
#list_f{
	border:1px #eee solid;
	padding-top:5px;
	padding:5px;
	width:94%;
}
#list_f > div[rank]{
	border-radius: 2px;
	width:auto;
	background-color:#FFFD00;
	height: 40px;
	border: 1px #D4D4D4 solid;
	margin-bottom:5px;

}

#list_f  div[t]{
	width:85%;
	height: 40px;
	line-height:40px;
	text-align: center;
	font-family: 'f1';
	font-size: 14px;
	background-color: #eee;
	float:<?=$align?>;
}
	
#list_f  div[x] {
	width: 15%;
	height: 40px;
	background: no-repeat url('images/sys/cancel.png') #000 center center;
	float:<?=$align?>;
}
#list_f  div[x]:hover{
	cursor: pointer;
}
	

input[mm] {
 background-color::;
  width: 100%;
  padding: 5px 18px;
  margin: 8px 8px;
  box-sizing: border-box;
  	
  border: 1px solid #555;
  outline: none;
}
input[mm]:focus {
  background-color: lightblue;
}
.clr_bord{
	border-color: #eaeaea;
	border-width:2px;
}
#error{
	color:<?=$clr5?>;
	font-size:12px;
	margin-top:2px;
}
.titleStyle{
	padding-bottom:5px;
	border-bottom:1px #fafafa solid;
}
.titleStyle div[tit]{
	color:<?=$clr1111?>;
	font-family:'f1',tahoma;
	font-size:14px;
	margin-top:10px;
	margin-bottom:10px;
}
.titleStyle span{
	margin-right:20px;
	color:<?=$clr1111?>;
	font-family:'f1',tahoma;
	font-size:14px;
	margin-top:10px;
	margin-bottom:10px;
}

div[field_rank]{
	margin-left:10px;
	border:1px #ccc solid;
	margin-bottom: 5px;
	border-radius:3px;
	height:35px;
	color:#fff;
	text-align: center;
	line-height:25px;
	
}
div[all]  div[rr]{background-color:#999; }
div[all]  div[n]{background-color:#aaa; }
div[all]  div[n]:hover{background-color:#999; cursor:pointer;}

div[choosen]  div[rr]{background-color:<?=$clr1?>; }
div[choosen]  div[n]{background-color:<?=$clr111?>; }
div[choosen]  div[n]:hover{background-color:<?=$clr1?>; cursor:pointer;}

.buutAdd{
	width:35px;
	height:35px;
	background:url(images/addpat.png) #eee no-repeat center center;
	border-radius:20px;
	margin:0px auto;
}
.buutAdd:hover{background-color:#fff; cursor:pointer;}
	
.winButts2{
	float:right;
	height:45px;
	position:absolute;
	z-index:500;
	<?=$Xalign?>:0;
	top:0;
}
.winButts2 > div{	
	height:45px;
	line-height:45px;
	width:45px;
	border-<?=$align?>:1px <?=$clr111?> solid;
	background-position:center center;
	background-repeat:no-repeat;
	float:<?=$Xalign?>;
}
.winButts2 > div:hover{background-color:<?=$clr1111?>; cursor:pointer;}	

.exc_upimageCon{
	border:0px;
	margin:0px;
	padding:0px;
	min-height:30px;
}
	
.exc_input{
	width:100%;
	max-width:840px;
	height:34px;
	line-height:34px;	
	text-indent:10px;
	font-family:Tahoma, Geneva, sans-serif;
	border-radius:2px;
	font-size:14px;
	border:1px solid #ddd;
	color:#666;
}


</style>