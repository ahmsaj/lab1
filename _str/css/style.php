<? session_start();/***STR***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.pacIcon{
	width:100%;
	height: 100%;
	max-width:200px;
	max-height:100%;
	min-height: 130px;
	background-color: <?=$clr1?>;
	background-size: contain;
	background-position: center center;
	margin: 0px auto;
}
.pacIcon1{ background-image: url(images/pac1.png);}
.pacIcon2{ background-image: url(images/pac2.png);}
.pacIcon11{ background-image: url(images/pac11.png);}
.pacIcon22{ background-image: url(images/pac22.png);}	
.shItTree{
	margin-top: -20px;
	margin-<?=$align?>: -20px;
	border-<?=$Xalign?>:1px #ccc solid;
	width: 250px;
	height: 200px;
	background-color: <?=$clr44?>;
	padding:0px 10px;
	position: absolute;
}
.shItDet{
	margin-top: -20px;
	margin-<?=$align?>: 251px;
	width: 250px;
	height: 200px;	
	padding:0px 10px;
	position: absolute;
}
.strItDetIn{	
	width: 100%;
	height: 200px;	
	padding:0px 10px;	
	position: absolute;	
	overflow-x:hidden;
	padding-<?=$Xalign?>: 2px;
}
.strIttitle{	
	border-bottom: 1px #ccc solid;
	margin-bottom: 10px;
}
.shItTreeIN{
	overflow-x:hidden;
	height: 200px;		
	padding-<?=$Xalign?>: 2px;		
}
.shItTreeIN div[m]{
	padding: 5px;
	background-color: <?=$clr1111?>;	
	background-position: right center;
	background-repeat: no-repeat;
	margin-bottom:5px; 
	border-radius: 2px;
	color: #fff;	
}
.shItTreeIN div[s]{
	padding: 5px;
	background-color: <?=$clr1?>;	
	background-position: right center;
	background-repeat: no-repeat;
	margin-bottom:5px; 
	border-radius: 2px;
	margin-right: 10px;
	color: #fff;	
}
.shItTreeIN div[sw=on]{background-image: url(images/treeArr.png);padding-<?=$align?>:20px;}
.shItTreeIN div[sw=off]{background-image: url(images/treeArr_2.png);padding-<?=$align?>:20px;}
.shItTreeIN div[i]{
	padding: 5px;
	background-color: #666;	
	background-position: right center;
	background-repeat: no-repeat;
	margin-bottom:5px; 
	border-radius: 2px;
	margin-right: 20px;
	color: #fff;	
}
.shItTreeIN div[ii]{
	padding: 5px;
	background-color: #ccc;	
	background-position: right center;
	background-repeat: no-repeat;
	margin-bottom:5px; 
	border-radius: 2px;
	margin-right: 20px;
	color: #fff;
}
.shItTreeIN div[i] span{background-color: #333;padding: 2px;}
.shItTreeIN div[m]:hover , .shItTreeIN div[s]:hover, .shItTreeIN div[i]:hover{opacity: 0.8; cursor: pointer;}
.treeButt{
	width:24px;
	line-height:24px;
	background-color: <?=$clr1?>;
	text-align: center;
	margin-bottom: 5px;
	color: #fff;
	font-size: 22px;
	border-radius: 2px;
	display: block;
}
.treeButt:hover{background-color: <?=$clr111?>;cursor: pointer;}
</style>