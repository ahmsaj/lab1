<? session_start();/***vital_signs***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
table.vs_table{
	text-align:center;
	border:1px #eee solid;
}
table.vs_table td{
	border-bottom: 1px #eee solid;
	background-color:#fdfdfd;
}
table.vs_table th{
	text-align:center;
	font-family:'f1';
	border-bottom:1px #eee solid;
	line-height:30px;
	background-color:#fff;
	border-bottom: 2px #ccc solid;
}
table.vs_table input{
	height: 30px;
}
.f9{
	background-color: #f9f9f9;
}
#vs_ItTot{height: 40px;}
.prvTpmlist > div[vs]{
	float: <?=$align?>;
	background-color:#fff;
	width: 100%;	
	margin-bottom: 10px;
	border-radius: 1px;
	border-bottom:4px #ccc solid;
}
.prvTpmlist > div[vs]:hover{background-color: #fafafa; cursor: pointer;}
.prvTpmlist > div[vs][act]{
	background-color: <?=$clr7?>;
}
#vs_ItData [vs_but]{
	line-height: 40px;
	margin-bottom: 10px;
	color: #fff;
	border-radius: 1px;
}
#vs_ItData [vs_but]:hover{opacity: 0.8;cursor:pointer;}
.vsView > div{
	width:150px;
	border:1px #ccc solid;
	margin: 10px;
	text-align: center;	
	box-sizing: border-box;
	border-radius: 2px;
}
.vsView [t]{
	font-family: 'f1';	
	line-height: 40px;
	color: #666;
}
.vsView [n]{
	font-size: 48px;
	font-family:'ff';
	height: 120px;
	line-height: 120px;
	background-color: #fcfcfc;
	margin: 10px;
}
