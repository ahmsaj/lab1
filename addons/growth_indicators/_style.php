<? session_start();/***growth_indicators***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
table.gi_table{
	text-align:center;
	border:1px #eee solid;
}
table.gi_table td{
	border-bottom: 1px #eee solid;
	background-color:#fdfdfd;
}
table.gi_table th{
	text-align:center;
	font-family:'f1';
	border-bottom:1px #eee solid;
	line-height:20px;
	background-color:#fff;
	border-bottom: 2px #ccc solid;
}
table.gi_table th.act{
	border-bottom: 2px <?=$clr6?> solid;
}
table.gi_table th.act:hover{	
	background-color:<?=$clr666?>;cursor: pointer;
}
table.gi_table input{
	height: 30px;
}
.f9{
	background-color: #f9f9f9;
}
table.gi_table [cb]{
	height: 30px;
	line-height: 30px;
	min-width: 40px;	
	color: #fff;
	font-family: 'ff';
	font-size:16px;
	border-radius: 1px;
	font-weight: bold;
	margin: auto;
}
.igInIc{height:40px;width:40px;}
.sexIc_1{background: url(images/sex_ic_1.png) no-repeat center center;}
.sexIc_2{background: url(images/sex_ic_2.png) no-repeat center center;}
.ic_father{background: url(images/ic_father.png) no-repeat center center;}
.ic_mother{background: url(images/ic_mother.png) no-repeat center center;}
.ic_tall{background: url(images/ic_tall.png) no-repeat center center;}
.sexClr_1{color:#45a3e3;}
.sexClr_2{color:#ed0082;}
/*******************/
#gi_ItTot{height: 40px;}
.prvTpmlist > div[gi]{
	float: <?=$align?>;
	background-color:#fff;
	width: 100%;	
	margin-bottom: 10px;
	border-radius: 1px;
	border-bottom:4px #ccc solid;
}
.prvTpmlist > div[gi]:hover{background-color: #fafafa; cursor: pointer;}
.prvTpmlist > div[gi][act]{
	background-color: <?=$clr7?>;
}
#gi_ItData [gi_but]{
	line-height: 40px;
	margin-bottom: 10px;
	color: #fff;
	border-radius: 1px;
}
#gi_ItData [gi_but]:hover{opacity: 0.8;cursor:pointer;}
.giView > div{
	
}
