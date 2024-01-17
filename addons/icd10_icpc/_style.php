<? session_start();/***icd10_icpc***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.prvlBlc > div[ic_items]{
	float: <?=$align?>;
	width: 100%;
	padding: 10px 0px;	
}
.prvlBlc > div[ic_items] > div{
	min-height: 30px;
	border-bottom: 1px #eee solid;
}
.prvlBlc > div[ic_items] div[txt]{
	font-family:'f1';
	color: #666;
	min-height: 30px;
	line-height: 30px;
}
.prvlBlc > div[ic_items] div[txt] ff{	
	color: <?=$clr8?>;
	min-height: 30px;
	line-height: 30px;		
	font-size:14px;
}
.prvlBlc > div[ic_items] > div:hover{background-color:#eee;}
.prvlBlc div[tool]{display:none;}
.prvlBlc > div[ic_items] > div:hover div[tool]{display:block;}
.prvTpmlist > div[ic]{
	float: <?=$align?>;
	background-color:#fff;
	width: 100%;
	padding-top:10px;
	margin-bottom: 10px;
	border-radius: 1px;
	border-bottom:4px #ccc solid;
}
.prvTpmlist > div[ic]:hover{background-color: #fafafa; cursor: pointer;}