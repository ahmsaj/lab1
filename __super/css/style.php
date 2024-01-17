<? session_start();
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');
?>
<style>
start{<?=$_SESSION['lg_d']?>}
.mod_ico{
	overflow-x:hidden;
	max-height:200px;
}
.sel_ico{
	 margin:3px;
	 color:#fff;
	 text-align:center;
	 border-radius:4px ;	 
	 width:50px;
	 height:50px;
	 background-repeat: no-repeat;
	 background-position: center center;
}
.sel_ico[sw=off]{background-color:<?=$clr3?>;}
.sel_ico[sw=on]{background-color:<?=$clr1?>;}
.sel_ico[sw=off]:hover{
	 background-color:#666;
	 cursor:pointer;
}
.list_icon{
	background-color:<?=$clr1?>;
	padding:3px;
	border-radius:3px;
	width:32px;
	margin-left:auto; margin-right:auto;
}

/***********************************/
.modm_m{
	width:50%;
	height:100%;
	border-<?=$Xalign?>:1px #ccc solid;
	overflow-x:hidden;
	max-width:500px;
}
.menu_contener div[l]{
	margin:5px;
	margin-bottom:0px;
	color:#fff;
	padding:5px;
	height:32px;
	border-radius:3px;
	overflow:hidden;
}
.modm_mod{
	width:48%;
	height:100%;
	overflow-x:hidden;
	max-width:500px;
}
.modm_mod_list{
	position:static;
}
.modm_mod_list > div{
	margin:5px;
	margin-bottom:0px;
	background-color:<?=$clr3?>;
	color:#fff;
	padding:5px;
	height:32px;
	border-radius:3px;
	overflow:hidden;
}
.modm_mod_list > div:hover{
	background-color:<?=$clr2?>;
	cursor:pointer;
}
.mml_ico{
	width:32px;
	height:32px;
	background-position:right center;
	background-repeat:no-repeat;
	margin-<?=$Xalign?>:10px;
}
.mml_txt{
	line-height:32px;
}
.menu_contener{
	border:1px #ccc dashed;
	margin:5px;
	margin-<?=$align?>:0px;
	min-height:100px;
}
.submenuMod{
	position:relative;
	border:1px #999 dashed;
	margin:5px;
	margin-top:0px;
	min-height:40px;
	border-top:0px;
	padding-bottom:10px;
}
.submenuMod > div{
	margin:5px;
	margin-top:0px;
	color:#fff;
	padding:5px;
	height:32px;
	border-radius:3px;
	overflow:hidden;
}
.editIcon{
	width:40px;
	height:32px;
	background:url(../images/icon_edit22.png) no-repeat center center;	
}
.delIcon{
	width:40px;
	height:32px;
	background:url(../images/icon_c_del.png) no-repeat center center;
	border-<?=$Xalign?>:1px #fff solid;
}
.editIcon:hover , .delIcon:hover{cursor:pointer; background-color:<?=$clr111?>;}
.sel_file{
	 margin:5px;
	 color:#fff;
	 text-align:center;
	 border-radius:2px;
	 padding:5px;
	 height:20px;
}
.sel_file[sw=off]{background-color:#ccc;}
.sel_file[sw=on]{background-color:<?=$clr2?>;}
.sel_file[sw=off]:hover{
	 background-color:#666;
	 cursor:pointer;
}
.mneuOrder{
	width:32px;
	height:32px;
	background-color:<?=$clr1?>;
	border-radius:2px;
	background:url(../images/ord.png) <?=$clr1?> no-repeat center center;
}
.mneuOrder:hover{background-color:<?=$clr1111?>; cursor:pointer;}
.mOrdMod div{background-color:<?=$clr1?>;height:30px; margin-bottom:10px; line-height:30px; color:#fff; border-radius:2px;}
.mOrdMod div:hover{background-color:<?=$clr1111?>; cursor:pointer;}
.fix_bord{
	border:1px #ccc solid;
	margin:10px;
	text-align:center;
	max-width:600px;
	min-height:40px;
	border-radius:4px;
}
#data{
	border:1px #ccc solid;
	margin-top:10px;
	text-align:center;
	max-width:800px;
	min-height:40px;
	border-radius:4px;
}
.fix_bord:hover{background-color:#eee; cursor:pointer;}
.mToolIco{width:330px;}
.mToolIco > div{
	width:40px;
	height: 40px;
	float: <?=$align?>;
	margin: 3px;
	border-radius: 1px;
	position: relative;
	cursor: pointer;	
	background-repeat: no-repeat;
}
.mToolIco > div[t]{background-color:<?=$clr111?>;}.mToolIco > div[t]:hover{background-color:<?=$clr11?>;}
.mToolIco > div[n]{background-color:#ccc; }.mToolIco > div[n]:hover{background-color:#aaa;}
.mToolIco > div > div{
	position:absolute;
	height:15px;
	line-height:15px;
	border:1px solid #eee;
	border-radius:15px;
	color:#fff;
	text-align:center;
	margin-top:-4px;
	<?=$Xalign?>:-4px;
	font-size:10px;
	padding:0px 5px 0px 5px;	
}
.mToolIco > div > div[t]{
	background-color:<?=$clr1?>;
}
.mToolIco > div > div[n]{
	background-color:#ccc;
	display: none;
}
.mt1{background-image:url(images/sys/mticons.png); background-position: 0px center;}
.mt2{background-image:url(images/sys/mticons.png); background-position: -40px center;}
.mt3{background-image:url(images/sys/mticons.png); background-position: -80px center;}
.mt4{background-image:url(images/sys/mticons.png); background-position: -120px center;}
.mt5{background-image:url(images/sys/mticons.png); background-position: -160px center;}
.mt0{background-image:url(images/sys/mticons.png); background-position: -200px center;}
.mt6{background-image:url(images/sys/mticons.png); background-position: -240px center;}
tr[ml] input[v]{width: 120px;}
/******library modules export-import******/
/*import*/
.exp_bord{
	padding:5px;
	font-size:14px;
	line-height: 20px;
}
.exp_bord div[icon]{
	width:18px;
	height:18px;
	color:white;
	font-size: 16px;
	padding-bottom: 2px;
	float:<?=$align?>;
}
.exp_bord div[t]{
	float:<?=$align?>;
	background-color: <?=$cbg4?>;
	width:40px;
}
.exp_bord div[icon][onclick]:hover{
	cursor:pointer;
	background-color:<?=$clr55?>;
}

.cMul[cc='exist'][ch=on]{background-color: <?=$clr6?>; border-color:<?=$clr66?>; }
.cMul[cc='exist'][ch=off]{background-color: #d3f5bc; border-color: #C9C2C2;}
.cMul[cc='not_exist'][ch=on]{background-color: <?=$clr5?>; border-color:<?=$clr55?>;}
.cMul[cc='not_exist'][ch=off]{background-color: #f5bcbc; border-color: #C9C2C2;}

.MultiBlc .cMul[cc='exist'][ch=on]:hover{background-color:<?=$clr66?>;}
.MultiBlc .cMul[cc='exist'][ch=off]:hover{background-color: #d3f5bc; color:black; border-color: black;}
.MultiBlc .cMul[cc='not_exist'][ch=on]:hover{background-color: <?=$clr55?>;}
.MultiBlc .cMul[cc='not_exist'][ch=off]:hover{background-color: #f5bcbc; color:black; border-color: black;}

.langJoin_type_box{
	margin-right:30px;
	margin-top:37px;
	border:1px #eee solid;
	padding:10px 20px 20px 20px;		
}
[modList] [mc][act]{
    background-color:#333;
    color: #fff;
}
[modFil] [fc][act]{
    background-color:#333;
    color: #fff;
}
</style>