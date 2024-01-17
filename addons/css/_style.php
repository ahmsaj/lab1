<? session_start();/***Addons***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
/**************************************/
.inWin{
	background-color:#fff;
	position:absolute;
	display:none;
	border-left:1px #999 solid;
	border-right:1px #999 solid;	
	box-shadow: 0px 0px 4px 1px rgba(0,0,0,0.5);
	z-index:3;
    box-sizing: border-box;
    
}
.inWin div[h]{	
	float:<?=$align?>;
	width:100%;
	line-height:50px;
	height:50px;
	margin-bottom:0px;
	border-bottom:1px #ccc solid;
    padding:0px 10px;
    box-sizing: border-box;
    background-color: #fed8b7;
	
}
.inWin div[b]{
	float:<?=$align?>;
	background-color:#fff;
	box-sizing: border-box;
	border:0px #ccc solid;
    margin: 10px;
}
[inWin='1']{margin-<?=$align?>: 600px; width: calc(100% - 600px);}
[inWin='2']{margin-<?=$align?>: 280px; width: calc(100% - 280px);}
    
[inWin='2'] div[b]{
    margin:0px;
    box-sizing: border-box;
}
.prvlBlc{
	background-color: #f9f9f9;
	padding:10px;	
	float: <?=$align?>;
	margin-top:10px;
	border:1px #ccc solid;
	border-<?=$Xalign?>:4px #ccc solid;
	border-<?=$align?>-style:solid;
	border-<?=$align?>-width:4px;
	border-radius:1px;
}
.prvl_title{
	/* float: <?=$align?>; */
	width: 100%;
	height: 30px;
	line-height: 30px;
}
[blcIn]{
 	border-top: 1px #ddd solid;
	margin-top: 5px;
}
.prvl_title > div[n]{	
		
}
.loadeText{line-height: 30px; border-bottom:0px;}
.minmize40:hover{background-color:#ccc;}
.mpDet [vis]{	
	padding: 10px 0px;
	border: 1px #eee solid;
	border-bottom: 4px #eee solid;
	background-color: #fafafa;
	margin: 0px 5px 10px 5px;
	padding: 10px;
	border-radius:1px;
	
}
.mpDet [hd]{
	font-size: 14px;
	padding-bottom:5px;
	color:<?=$clr8?>;
}
.mpDet [rec]{	
	line-height: 25px;
	color:#666;
	font-family:'f1';
	
}