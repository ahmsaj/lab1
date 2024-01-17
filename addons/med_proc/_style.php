<? session_start();/***med_proc***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.prvlBlc > div[items]{
	float: <?=$align?>;
	width: 100%;
	padding: 10px 0px;	
}
.prvlBlc > div[items] > div{
	min-height: 30px;
	border-bottom: 1px #eee solid;
}
.prvlBlc > div[items] div[txt]{
	font-family:'f1';
	color: #666;
	min-height: 30px;
	line-height: 30px;	
}
.prvlBlc > div[items] > div:hover{background-color:#eee;}
.prvlBlc div[tool]{display:none;}
.prvlBlc > div[items] > div:hover div[tool]{display:block;}
.prvlBlc div[inpu]{
	float: <?=$align?>;
	width: 100%;	
	background-color: #ffa;
	border-left: 1px #eee solid;
	border-right: 1px #eee solid;
}
.prvlBlc div[inTxt]{
	background-color: #ffc;
	min-height:20px;
	height: auto;
	line-height:20px;
	border:0px;
	padding:5px;
	font-size:14px;
}
.prvlBlc  div[inTxt] div{font-size: 14px;}
.prvTpmlist > div[tn]{
	float: <?=$align?>;
	background-color:#fff;
	width: 100%;
	padding-top:10px;
	margin-bottom: 10px;
	border-radius: 1px;
	border-bottom:4px #ccc solid;
}
.prvTpmlist > div[tn]:hover{background-color: #fafafa; cursor: pointer;}
.prvTpmlist div[tit]{	
	margin-bottom:5x;
	padding-bottom: 5px;
	line-height: 18px;
	border-bottom:0px #eee solid;
	overflow: hidden;
	line-height: 20px;
}
.prvTpmlist > div[tne]{
	float: <?=$align?>;
	background-color:#FCF085;
	width: 100%;
	padding-top:10px;
	margin-bottom: 10px;
	border-radius: 1px;
	border-bottom:4px #ccc solid;
}
.prvTpmlist > div[tne] [intxt]{
	background-color: #ffc;
	min-height:20px;
	height: auto;
	line-height:20px;
	border:0px;
	padding:5px;
	font-size:14px;	
}
</style>