<? session_start();/***XRY***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.oscTi{
	width:100px;
	height: 60px;
	color: #fff;
	font-family: 'ff';
}
.oscTi div{
	text-align: center;
	font-family: 'arial';
	font-weight: bold;
}
.oscTi div[t1]{	
	line-height: 35px;	
	font-size: 22px;
	border-bottom: 1px #fff solid;
	
}
.oscTi div[t2]{	
	line-height: 25px;	
	font-size: 16px;
}
#osc_pro_butts div{
	
	background-color:#eee ;
	color:#000;
	padding: 10px;
	line-height: 30px;
	border-bottom: 1px #999 solid;
	font-size: 16px;
}
#osc_pro_butts div:hover{
	background-color:#999;
	color:#fff;
	cursor: pointer;
	 
}
</style>