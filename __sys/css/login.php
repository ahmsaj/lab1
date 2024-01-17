<? session_start();
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.cbg1{background-color:<?=$clr1?>;}.cbg11{background-color:<?=$clr11?>;}
.cbgl11{background-color:<?=$clr111?>;}.cbgl111{background-color:<?=$clr1111?>;}
.cbg2{background-color:<?=$clr2?>;}.cbg3{background-color:<?=$clr3?>;}
.cbg4{background-color:<?=$clr4?>;}.cbg44{background-color:<?=$clr44?>;}.cbg444{background-color:<?=$clr444?>;}
.cbg5{background-color:<?=$clr5?>;}.cbg55{background-color:<?=$clr55?>;}.cbg555{background-color:<?=$clr555?>;}
.cbg6{background-color:<?=$clr6?>;}.cbg66{background-color:<?=$clr66?>;}.cbg666{background-color:<?=$clr666?>;}
.cbg7{background-color:<?=$clr7?>;}.cbg77{background-color:<?=$clr77?>;}.cbg777{background-color:<?=$clr777?>;}
.cbg8{background-color:<?=$clr8?>;}.cbg88{background-color:<?=$clr88?>;}.cbg888{background-color:<?=$clr888?>;}
.clr1{color:<?=$clr1?>;}.clr11{color:<?=$clr11?>;}
.colrl111{color:<?=$clr111?>;}.colrl1111{color:<?=$clr1111?>;}
.clr2{color:<?=$clr2?>;}.clr3{color:<?=$clr3?>;}
.clr4{color:<?=$clr4?>;}.clr44{color:<?=$clr44?>;}
.clr5{color:<?=$clr5?>;}.clr55{color:<?=$clr55?>;}.clr555{color:<?=$clr555?>;}
.clr6{color:<?=$clr6?>;}.clr66{color:<?=$clr66?>;}.clr666{color:<?=$clr666?>;}
.clr7{color:<?=$clr7?>;}.clr77{color:<?=$clr77?>;}.clr777{color:<?=$clr777?>;}
.clr8{color:<?=$clr8?>;}.clr88{color:<?=$clr88?>;}.clr888{color:<?=$clr888?>;}
@font-face{font-family:'f1';src:url('library/fonts/TheSans-Bold-alinma.ttf') format('woff');}
@font-face{font-family:'f2';src:url('library/fonts/The-Sans-Plain-alinma.ttf') format('woff'));}
@font-face{font-family:'ff';src:url('library/fonts/MyriadSetPro-Thin.woff') format('woff');}
<? if($_SESSION['lg_d']=='ltr'){?>
	start{}
	body{direction:ltr;}		
	.fl{float:left;}
	.fr{float:right;}
<? }else{?>
	start{}
	body{direction:rtl}
	.fr{float:left;}
	.fl{float:right;}	
<? }?>
start{}
body{
	background-color:<?=$clr44?>;
	font-family:'f1',Tahoma, Geneva;
	font-size:12px;
	color:#003;
	margin:10px;
	overflow:hidden;
    margin:0px;
    background-color:#fff;
    overflow:hidden;    
}
.log{
	font-family:'f1',Tahoma, Geneva;
	width:362px;
	margin-left:auto;
	margin-right:auto;
	height:100%;
	font-weight:100;
	
}
.log_in{
	background-color:<?=$clr1111?>;
	padding: 30px;
	padding-top: 0px;
	border-radius: 5px;
	box-sizing: border-box;
	border:1px <?=$clr3?> solid;	
	width:362px;
	box-shadow: 5px 5px #ccc;
	box-shadow:  0px 0px 27px 4px rgba(0,0,0,0.2);
}
.title{
	font-size:18px;
	color:#fff;
	text-align:center;
	margin:20px 0px;
}
.inp_div{	
	float:left;
	width:100%;
	margin:5px 0px;	
}
.i_u{
	width:39px;
	height:40px;
	background:url(images/sys/i_u.png) <?=$clr1?> no-repeat center center;
}
.i_p{
	width:39px;
	height:40px;
	background:url(images/sys/i_p.png) <?=$clr1?> no-repeat center center;
}
.inp_div input{
	border:0px;
	width:258px;
	height:40px;
	line-height:40px;
	background-color:#fff;
	color:<?=$clr2?>;
	font-family:'f1',tahoma;
	text-indent:10px;
	box-sizing: border-box;
	border-radius: 0px;
}
.inp_div input:focus{border-radius: 0px; border:0px;outline: none;color:<?=$clr2?>; }
.logSubmit{
	float:right;
	margin-top:15px;
	font-family:'f1';
	width:100%;
}
.logSubmit input{
	width:100%;
	height:44px;
	color:#fff;
	border:0px;
	border-bottom:4px solid <?=$clr2?>;
	border-radius:0px;
	cursor:pointer;
	font-family:'f1';
	font-size:16px;
	background-color:<?=$clr3?>;
}
.logSubmit input:hover{background-color:<?=$clr2?>;}
.logo{
	width:100%;
	height:200px;
	margin-left:auto;
	margin-right:auto;
	background-repeat:no-repeat;
	background-position:center center;
}
.logMas{	
	text-align:<?=$lign?>;
	color:#fff;
	clear:both;
	line-height: 30px;	
	background-color:<?=$clr55?>;
	margin-top: 20px;
	float:<?=$align?>;	
	border-radius: 2px;
	padding:0px 10px;
}
.power{
	float:left;
	line-height: 40px;
	color:#555;
	text-align: left;
	padding-left: 25px;
	font-weight: bold;
	font-family: 'ff';
	background: url(images/sys/power_icon.png) no-repeat left center;
}
.power a{	
	color:#000;
	text-decoration: none;
}
</style>