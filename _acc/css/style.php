<? session_start();/***ACC***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.bo_list{
	background-color: #2d2d2d;
	border-<?=$Xalign?>:0px solid #e84c3d;	
}
.bo_title{
	line-height:50px;
	color: #fff;
	font-size:16px;
	font-family:'f1';
	text-align: center;
	background-color: #e46600;
	border-bottom: 4px #eb8b31 solid;
}
#bo_dets{
	background-color: #f9f9f9;	
}
.bo_oprs > div{
	height:50px;
	line-height: 50px;
	font-family: 'f1';	
	background-color: #444;
	color:#eee;
	border:0px solid #000;
	border-<?=$align?>: 6px #666 solid; 
	text-indent: 50px;
	margin-top: 0px;
	border-bottom:1px #555 solid;
	background-repeat: no-repeat;
	background-position: <?=$align?> center;
}
.bo_oprs > div:hover{
	background-color: #666;
	cursor: pointer;
	border-<?=$align?>: 6px #3d886c solid;
}
.bo_oprs > div[act]{
	background-color:#3ea286;
	border-<?=$align?>: 6px #14c683 solid;
}
.setTab tr{display:none;}
.setTab{max-width: 750px;}
</style>