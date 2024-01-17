<? session_start();/***BTY***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.ti_calbir{background:url(images/mad_icon2.png) no-repeat -600px top;}
.ti_calbir:hover{background-position:-600px bottom;}
.visRowsDen{
	border:1px #aaa solid;
	margin-bottom:10px;
	border-radius:0px;
	background-color:#eee;
	width: 100%;
}
.vrd2{background-color:#fcff00;}
.visRowsDen:hover{background-color:#ccc;}
.visRowsDen div[a]{
	width:50px;
	height:50px;
	line-height:50px;
	background-color:#666;
	text-align:center;
	color:#fff;
	font-family:'ff';
	font-size:22px;
	font-weight:bold;
}

.visRowsDen div[b]{
	height:50px;
	line-height:25px;
	text-align:center;
}
.visRowsDen div[c]{
	width:50px;
	height:50px;
	line-height:50px;
	text-align:center;
	color:#fff;
	font-family:'ff';
	font-size:22px;
	font-weight:bold;
}
/**********************************************/
div[lsrSer]{
	background-color:#d5d5d5;
	text-indent: 10px;
	margin-bottom: 10px;		
	border-radius: 2px;
}
div[lsrPrt]{
	background-color:#f5f5f5;
	text-indent: 10px;
	margin-bottom: 10px;		
	border-radius: 2px;
}
/**********************************************/
.lp_s1{
	background-color: #2d2d2d;
	border-<?=$Xalign?>:0px solid #e84c3d;
}
#timeSc{
	min-height:74px;
	width:320px;
	padding:10px;
	background-color: #444;
	color:#eee;
	border-top:1px #666 solid;
}
.lp_s1_b2{
	line-height:74px;
	background-color: #eb4960;
	color: #fff;
	text-indent: 10px;
	width: 100%;
	height:74px;
	font-size: 16px;	
	border-bottom: 4px solid #f4837d;	
}
.lp_s1_b2 [tit1]{	
	line-height: 25px;
	font-family: 'f1';	
	overflow: hidden;
	margin-top: 12px;
}
table.vs_table{	
	border:1px #eee solid;
	max-width:1000px;
}
table.vs_table th{	
	padding:5px;
	font-family:'f1';
	border-bottom:1px #eee solid;
	line-height:40px;
	background-color:#fff;
	border-bottom: 2px #ccc solid;
}
table.vs_table td{
	border-bottom: 1px #eee solid;
	background-color:#fdfdfd;
	padding: 5px;
	line-height:40px;
}

table.vs_table input{
	height: 30px;
}
.f9{
	background-color: #f9f9f9;
}

.lasBut > div{
	height:50px;
	line-height: 50px;
	font-family: 'f1';	
	background-color: #444;
	color:#eee;
	border:0px solid #000;	
	text-indent: 50px;
	margin-top: 0px;
	border-bottom:1px #555 solid;
	background-repeat: no-repeat;
	background-position: <?=$align?> center;
}
.lasBut > div:hover{
	background-color: #666;cursor: pointer;
}
.lasBut > div[act='1']{
	background-color:#000;
}
.lasBut .appo{
	background-image: url("images/rob2.png");
}
.lasBut .titr{
	background-image: url("images/titr.png");
}
.lasBut .notes{
	background-image: url("images/notes_icon.png");
}
table.vs_table input[btyInp]{font-size: 20px;height: 40px;}
table.vs_table input[btyInp2]{height: 50px;}
</style>