<? session_start();/***medical_history***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.hisMBlc{
	border-left:4px #ccc solid;
	border-right:4px #ccc solid;
}
.prvHislist > div[ih]{
	float: <?=$align?>;
	background-color:#fff;
	width: 100%;
	padding:10px 0px;
	margin-bottom: 10px;
	border-radius: 1px;
	border-<?=$align?>:4px <?=$addColor?> solid;
	color:<?=$addColor?>;
}
.prvHislist > div[ih]:hover{background-color: #fafafa; cursor: pointer;}
.hisListIn{
	margin-bottom: 10px;
}
.hisListIn [mhit]{
	border-bottom:1px #ccc dashed;
	padding:3px 0px 3px 0px;
	padding:4px;
	width: 100%;
	max-width: 280px;
	float: <?=$align?>;
}
.hisListIn [mhit]:hover{background-color:<?=$clr777?>;}
.hisListIn [mhit]:hover div{display: block;}
.hisListIn [mhit] [t]{
	font-size:14px;
	line-height:30px;
	color:#000;
	margin-bottom:5px;
	display: inline-block;
	border-radius:1px;
	float: <?=$align?>;
}
.hisListIn [mhit] [act]{	
	border-<?=$align?>:3px <?=$clrb?> solid;
	background-color:<?=$clr9?>;
	padding:0px 10px 0px 10px;
	color:#fff;
}
.hisListIn [mhit] [art]{	
	border-<?=$align?>:3px <?=$clr55?> solid;
	background-color:<?=$clr5?>;	
	padding:0px 5px 0px 5px;
	color:#fff;
}
.hisListIn [mhit] [d]{
	line-height:15px;
	color:#333;
	font-family:'ff';
	font-size:14px;
	clear: both;
}
.hisListIn [mhit] [n]{
	line-height:18px;		
	font-size:14px;
	padding:5px 0px 10px 0px;
	color:#f00;
	clear: both;
}
.hidCb{
	width: 15px;
	height: 15px;
	border-radius: 50%;
	margin:7px 0px;
}
