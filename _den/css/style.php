<? session_start();/***DEN***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');
$bC_f='#f5f5f5';
$bC_m='#e5e5e5';
$bC_d='#ddd';
$bC_l='#ccc';
$t_bordd_l='#333';
?>
<style>
start{}
.ti_mouth{background:url(images/mad_icon2.png) no-repeat -240px top;}
.ti_mouth:hover{background-position:-240px bottom;}
.ti_opr_den{background:url(images/mad_icon2.png) no-repeat -1020px top;}
.ti_opr_den:hover{background-position:-1020px bottom;}
.butDen{
	padding: 0px 0px;
}
.butDen div{
	line-height: 40px;	
	font-family:'f1';
	font-size: 14px;
	color: #fff;
	border-bottom: 1px #444 solid;
	background-position: <?=$align?> bottom;
	background-repeat: no-repeat;
	text-indent: 50px;	
}
.butDen div:hover{
	background-color:#333;
	cursor: pointer;
}
.butDen div[act]{
	background-position: <?=$align?> top;
	background-color:#fff;
	color:<?=$clr3?>;	
}
.butDen div[den_i1]{
	background-image: url(images/den_opricon_1.png);
}
.butDen div[den_i2]{
	background-image: url(images/den_opricon_2.png)
}
.levDes{
	border-<?=$align?>:4px #ccc solid;
	background-color:#f5f5f5;
}
/******************************************************/
.visRowsDen{
	border:1px #aaa solid;
	margin-bottom:10px;
	border-radius:0px;
	background-color:#eee;
	width: 100%;
}
.vrd2{background-color:#fcff00;}
.visRowsDen:hover{background-color:#ccc;}
.visRowsDen div[a]{
	width:50px;
	height:50px;
	line-height:50px;
	background-color:#666;
	text-align:center;
	color:#fff;
	font-family:'ff';
	font-size:22px;
	font-weight:bold;
}

.visRowsDen div[b]{
	height:50px;
	line-height:25px;
	text-align:center;
}
.visRowsDen div[c]{
	width:50px;
	height:50px;
	line-height:50px;
	text-align:center;
	color:#fff;
	font-family:'ff';
	font-size:22px;
	font-weight:bold;
}
/**********************************************/


.teethCont{margin:5px;}
.teethTable{border-collapse: collapse;}
.teethTable div{box-sizing: border-box;}
.teethTable tr[box] td{
	text-align: center;
	border:1px #ccc solid;
	margin:2px;
}
.TtNO{
	height:30px;
	font-size: 14px;
	color: #ccc;
	
}
.teethTable tr[box] td > div{	
	border-radius: 0px;
	height: 53px;
	line-height:53px;
}
.teethTable tr[box] td > div > div{background-color: #eee; height: 50px; line-height: 33px}
.teethTable tr[root] td{
	padding: 0px;
	border-bottom:1px #eee solid;
}
.teethTable tr[root] td > div > div{
	text-align: center;			
	height: 30px;
	width: 5px;
	margin:2px;
	background-color: #ccc ;
	border:0px #ccc solid;
	border-radius: 8px;
	border-bottom: 0px;
}
.teethTable td[tpn1],td[tpn2],td[tpn5],td[tpn6]{		
	border-bottom: 1px #ccc solid;
	padding: 0px;
	height: 40px;
}

.teethTable td[tpn3],td[tpn4],td[tpn7],td[tpn8]{		
	border-top: 1px #eee solid;
	padding: 0px
	height: 40px;
}
.Troot{
	height:40px;
	border:1px #ccc solid;
	width:100px;
}

.teethTable td[teeth] > div > div{text-align: center;border-radius: 5px; }
/********************************************/
/********************************************/
div[tBor1],div[tBor5]{border-right: 3px solid <?=$t_bordd_l?>;border-bottom: 3px solid <?=$t_bordd_l?>;}
div[tBor1][n],div[tBor5][n]{background: linear-gradient(to bottom right, #fff 96%, #000 4%);}
div[tBor2],div[tBor6]{border-left: 3px solid <?=$t_bordd_l?>;border-bottom: 3px solid <?=$t_bordd_l?>;}
div[tBor2][n],div[tBor6][n]{background: linear-gradient(to bottom left, #fff 96%, #000 4%);}
div[tBor3],div[tBor7]{border-left: 3px solid <?=$t_bordd_l?>;border-top: 3px solid <?=$t_bordd_l?>;}
div[tBor3][n],div[tBor7][n]{background: linear-gradient(to top left, #fff 96%, #000 4%);}
div[tBor4],div[tBor8]{border-right: 3px solid <?=$t_bordd_l?>;border-top: 3px solid <?=$t_bordd_l?>;}
div[tBor4][n],div[tBor8][n]{background: linear-gradient(to top right, #fff 96%, #000 4%);}
div[tBor1] > div , div[tBor5] > div {	
	border-top: 10px solid <?=$bC_f?>;
    border-left: 10px solid <?=$bC_d?>;
    border-right: 10px solid <?=$bC_m?>;
	border-bottom: 10px solid <?=$bC_l?>;	
}
div[tBor2] > div,div[tBor6] > div{
	border-top: 10px solid <?=$bC_f?>;
    border-left: 10px solid <?=$bC_m?>;
    border-right: 10px solid <?=$bC_d?>;
	border-bottom: 10px solid <?=$bC_l?>;
}
div[tBor3] > div,div[tBor7] > div{
	border-top: 10px solid <?=$bC_l?>;
    border-left: 10px solid <?=$bC_m?>;
    border-right: 10px solid <?=$bC_d?>;
	border-bottom: 10px solid <?=$bC_f?>;
}
div[tBor4] > div,div[tBor8] > div{
	border-top: 10px solid <?=$bC_l?>;
    border-left: 10px solid <?=$bC_d?>;
    border-right: 10px solid <?=$bC_m?>;
	border-bottom: 10px solid <?=$bC_f?>;
}
.ic40_den_root{background-image:url(images/den_icon_root.png);}
.ic40_den_teeth{background-image:url(images/den_icon_teeth.png);}


/****************************/

div[tp]{
	width: 50%;
	box-sizing: border-box;
	text-align: center;
	height: 50%;	
	color: #333;
	font-weight: bold;
}
div[tp1],div[tp5]{border-bottom: 2px #666 solid;border-right: 2px #666 solid;padding-right: 20px;}
div[tp2],div[tp6]{border-bottom: 2px #666 solid;border-left: 2px #666 solid;padding-left: 20px;}
div[tp3],div[tp7]{border-top: 2px #666 solid;border-left: 2px #666 solid;padding-left: 20px;}
div[tp4],div[tp8]{border-top: 2px #666 solid;border-right: 2px #666 solid;padding-right: 20px;}

@media screen and (max-width:1100px) {    
    div[tp]{width: 100%;} 
	div[tp1],div[tp5]{border-right: 0px #999 solid;}
	div[tp2],div[tp6]{border-left: 0px #999 solid;}
	div[tp3],div[tp7]{border-left: 0px #999 solid;}
	div[tp4],div[tp8]{border-right: 0px #999 solid;}
}
/********************************************/
.tBoxInfo{
	margin: auto;
	padding: 20px;
}
.tBoxInfo  td[face]{
	text-transform: uppercase;
}
.tInfoTable{
	border-collapse: collapse;
	border: 0px #f00 solid;	
}
.tInfoTable td[a=off]{
	border:4px #999 solid;
	text-align: center;
	font-size: 32px;
	background-color: rgba(0,0,0,0.2);
}
.tInfoTable td[a]:hover{cursor: pointer;background-color:rgba(0,0,0,0.3);}

/*.tInfoTable td[a=off]:hover{background-color:rgba(0,0,0,0.3);}*/
.tInfoTableIN{border-collapse: collapse; background-color: #fff; border: 0px #fff solid;}
.tInfoTableIN td{border:2px #999 solid; width: 20%;font-family: 'ff';}
/*
.tInfoTable td[a=on]{
	border:4px #999 solid;
	text-align: center;
	font-size: 32px;
	background-color: rgba(245,236,89,0.8);
}
.tInfoTable td[a=on]:hover{background-color:rgba(245,236,89,0.9);}*/

.tInfoTable td[x]{
	/*background-color: rgba(255,255,255,0.9);*/
}

.tInfoTable2 {
	border-collapse: collapse;
}
.tInfoTable2 td{
	border:1px #ccc solid;
	text-align: center;
	font-size: 14px;
	height:40px;
}
.tInfoTable2 td:hover{cursor: pointer;background-color:#eee;}
.tInfoTable2 td[act]{background-color:#E5EE55;}
.tInfoTable2 td[bor]{border-left:5px #ccc solid;}
.tInfoTable2 tr[r1] td{border-bottom:5px #ccc solid;}


.tToolI div{
	width: 40px;
	height: 40px;
	border: 2px #aaa solid;
	margin: 5px;
	padding: 5px;
	border-radius: 3px;
	border-bottom-width: 6px;
}
.tToolI div:hover{background-color: #90C4F4; cursor: pointer;}
.teethHis > div{
	/*border: 1px #999 solid;*/
	border: 1px #ccc solid;
	margin: 5px;
	padding: 5px;
	background-color: #f5f5f5;
}
.teethHis > div:hover{
	background-color: #eee;
	cursor: pointer;
}
/*
.teethHis > div[part_1]{background-color: #e2f9ff;}
.teethHis > div[part_2]{background-color: #ffe2fc;}*/
/**********************************************/
.tt_icon_c{ background-image: url(images/den_ab_icon.png); background-position:<?=$align?> bottom;}
.tt_icon_a{ background-image: url(images/den_ab_icon.png); background-position:<?=$align?> top;}
.oprDen > div{
	font-family: 'f1';
	font-size:14px;
	line-height: 25px;		
	border-bottom: 0px #999 solid;
	background-color: #eee;	
	margin-bottom: 10px;
	
	border:1px #aaa solid;
	border-bottom: 8px #aaa solid;
	
}
.oprDen > div:hover{
	cursor: pointer;
	border-bottom: 8px <?=$clr3?> solid;	
}
.oprDen > div[act]{
	border:1px <?=$clr2?> solid;
	border-bottom: 8px <?=$clr2?> solid;	
}

.oprDen div[s]{
	line-height: 30px;
	font-family: 'f1';
	font-size:16px;		
	padding:5px 5px;	
	background-color:rgba(0,0,0,0.05);
	
}
.oprDen div[d]{
	line-height: 30px;
	font-family: 'ff';
	font-size:14px;
	font-weight: bold;
	float: <?=$Xalign?>;
	padding-<?=$Xalign?>: 5px;
}
.oprDen div[t]{	
	float:<?=$align?>;	
	padding: 3px ;
}
.oprDen div[t] div{
	line-height: 24px;
	height: 24px;
	width: 24px;
	font-family: 'ff';
	font-size:14px;
	font-weight: bold;
	float:<?=$align?>;
	margin-<?=$Xalign?>: 3px;
	background-color:rgba(255,255,255,0.5);	
	text-align: center;	
}

td[tdno][sel]{
	background-color: #F7EA70;	
}
.rootMap{
}
.rr{
	border:3px #999 solid;
	color:#000;
	border-radius: 50%;
	width: 40px;
	height: 40px;
	line-height: 40px;
	text-align: center;

	margin: 5px auto 5px auto;
	font-size: 16px;
	font-weight: bold;
	box-sizing: border-box;
	box-sizing: content-box;		
}
.rr:hover{
	border:3px #000 solid;
	border-radius: 20px;
	color:#000;
	cursor: pointer;
}

.tInfoTable3{
	border-collapse: collapse;
	border:2px #fff solid;
	margin: 0 auto;

	width: 100%;
	height: 100%;
}
.tInfoTable3 td{
	border: 2px #ccc solid;
	text-align: center;
	margin: 20px;
}
.tRoott{
	border-collapse: collapse;
	margin: 10px auto;
	/*border:3px #ccc double;*/
	border-radius: 30px;
	background-color: #eee;
}
.tRoott td{				
	border:2px #fff dashed;
	border-radius: 30px;
	text-align: center;
}
.tRoott td{	text-align: center;}
.teethSs > div{
	border:1px #ccc solid;
	float: <?=$align?>;
	margin: 4px;
	width: 120px;
	border-radius: 1px;
}
.teethSs > div:hover{
	background-color: #eee;
	cursor: pointer;
}
.teethSs div[img]{
	height: 100px;
	border-bottom:1px #ccc solid;
	padding: 10px
}
.teethSs div[txt]{
	height:30px;
	line-height:30px;
	text-align: center;
	font-family:'f1';
}
.hiOpBlc{ 
	border: 1px #aaa solid;
	margin-bottom: 10px;
	background-color: #f5f5f5;
	padding: 10px;
	border-radius: 2px;
}
div[actts]{
	background-color: <?=$clr6?>;
}
[denOpr][a='1']:hover{background-color:#EEF16D;cursor: pointer;}
/*****************New**************************/
.ic40_sw{background-image:url("images/sys/ic40_sw.png");}
.d_c1_b1 > div{
	line-height:50px;
    height: 50px;
	background-color: #666;
	color: #fff;
	text-indent: 10px;
	width: 100%;
	border-bottom: 1px #888 solid;
	font-size: 16px;  
    box-sizing: border-box;
}
.d_c1_b1 [dOpr='1'] [dIc]{background: url(images/den/opr1.png) no-repeat center center;}
.d_c1_b1 [dOpr='1'][act]{background-color: #85b24d;}
.d_c1_b1 [dOpr='1']{border-<?=$align?>:8px #85b24d solid;}
.d_c1_b1 [dOpr='1']:hover{
    filter: brightness(1.1);
    cursor: pointer;
    background-color: #85b24d;
    border-<?=$align?>:0px #85b24d solid;
}
    
.d_c1_b1 [dOpr='2'] [dIc]{background: url(images/den/opr2.png) no-repeat center center;}
.d_c1_b1 [dOpr='2'][act]{background-color: #009ad2;}
.d_c1_b1 [dOpr='2']{border-<?=$align?>:8px #009ad2 solid;}
.d_c1_b1 [dOpr='2']:hover{
    filter: brightness(1.1);
    cursor: pointer;
    background-color: #009ad2;
    border-<?=$align?>:0px #009ad2 solid;
}

.d_c1_b1 [dOpr='3'] [dIc]{background: url(images/den/opr3.png) no-repeat center center;}
.d_c1_b1 [dOpr='3'][act]{background-color: #b24dac;}
.d_c1_b1 [dOpr='3']{border-<?=$align?>:8px #b24dac solid;}
.d_c1_b1 [dOpr='3']:hover{
    filter: brightness(1.1);
    cursor: pointer;
    background-color: #b24dac;
    border-<?=$align?>:0px #b24dac solid;
}
.d_c1_b1 [arr]{
    float: <?=$Xalign?>;
    width: 40px;
    height: 50px;
    background: url("images/treeArr_left.png") no-repeat <?=$Xalign?> center;    
}

#timeSecDen{
	min-height: 80px;
	width: 280px;
	padding: 10px;
	background-color: #444;
	color:#eee;
    border-bottom: 1px #666 solid;
}
.patBlc{
    min-height: 60px;
    background-color: #49494b;
    border-bottom: 2px #666 solid;
}
[prvVisTool]{
    border-bottom: 1px #666 solid;
}
.patBlc:hover{
    background-color: #363636;
    cursor: pointer;
}
    
.dListTit{
    min-height: 40px;
    line-height: 40px;
    color: #fff;
}
.dListT1{
    background-color: #85b24d;
}
.dListT1 [dIc]{
    background: url(images/den/opr1.png) no-repeat center center;
    background-size: 80% 80%
}
.orpInfoTi{
    min-height: 80px;
}
.denOpsL > div{
    box-sizing: border-box;
    border:2px #ddd solid;
    background-color:#fff;
}
.denOpsL > div:hover{
    cursor: pointer;
    box-shadow:0px 0px 8px #999 ;
}
.denOpsL > div[act]{
    border:2px #aaa solid;
    background-color:#f5f5f5;
}
[dSta]{
    line-height:30px;    
    text-indent:30px;
    background-size: 25px 25px;
}
[dSta='0']{
    color: #aaa;
    background: url("images/den/ic30_os0.png") no-repeat <?=$align?> top;
}
[dSta='1']{
    color: #00b0f0;
    background: url("images/den/ic30_os1.png") no-repeat <?=$align?> top;
}
[dSta='2']{
    color: #31b02e;
    background: url("images/den/ic30_os2.png") no-repeat <?=$align?> top;
}
[dSta='3']{
    color: #D35353;
    background: url("images/den/ic30_os3.png") no-repeat <?=$align?> top;
}
[dSta='4']{
    color: #999;
    background: url("images/den/ic30_os4.png") no-repeat <?=$align?> center;
}
.oprlS1{
    background-color: #f8f8f8;
}
.oprlS2{
    background-color: #efe;
}
.teethNo{
    background-color: #eee;
    margin-top: 6px;
}
.teethNo > div{
    width: 20px;
    height: 20px;
    line-height: 20px;
    background-color: #4d516e;
    border-radius:3px;
    color: #fff;
    text-align: center;
    float:<?=$align?>;
    font-size: 12px;
    font-family: 'ff',tahoma;
    font-weight: bold;
    margin-bottom:3px;
    margin-<?=$Xalign?>:3px;
}
/********************/
.theethMsg{
    height: 40px;
    line-height: 40px;
    background-color:#fff;
	position:absolute;
	display:none;	
	box-shadow: 0px 0px 5px #666;
	z-index:4;    
    margin-<?=$align?>: 280px;
    margin-<?=$Xalign?>: 50px;
    color: #fff;
    text-shadow: 0 0 5px #999;
}
@media screen and (max-width:1200px){.theethMsg{margin-<?=$align?>: 240px;}}
.theethMsgS{
    height: 40px;
    line-height: 40px;
    background-color:#fff;
	position:absolute;
	display:none;	
	box-shadow: 0px 0px 5px #666;
	z-index:4;
    color: #fff;
    text-shadow: 0 0 5px #999;
}
.inWinD{
	background-color:#fff;
	position:absolute;
	display:none;
	border-left:1px #999 solid;
	border-right:1px #999 solid;	
	box-shadow: 0px 0px 5px #666;
	z-index:3;
    box-sizing:content-box;
    margin-<?=$align?>: 240px;
    margin-<?=$Xalign?>: 50px;
}
.inWinD div[h]{	
	float:<?=$align?>;
	width:100%;
	line-height:40px;
	height:40px;
	margin-bottom:0px;
	border-bottom:1px #ccc solid;
    padding-<?=$align?>:5px;
    box-sizing: border-box;
    background-color: #E8FFE0;
}
.inWinD div[b]{
	float:<?=$align?>;
	background-color:#fff;
	box-sizing: border-box;
	border:0px #ccc solid;    
}
@media screen and (max-width:1000px){.inWinD{margin-<?=$align?>: 0px;margin-<?=$Xalign?>:0px;}}
.denCatList div{
    background-color:#fff;
    line-height: 30px;
    padding: 5px 10px;
    margin-bottom: 10px;
    font-family: 'f1';
    border-radius:3px;
}
.denCatList div:hover{
    cursor: pointer;
    background-color: #f5f5f5;
}
.denCatList div[act]{
    cursor: pointer;
    background-color:<?=$clr2?>;
    color:#fff;
}
/**/
.denOprList div{
    background-color:#fff;
    line-height: 30px;
    padding: 5px 10px;
    margin-bottom: 10px;
    font-family: 'f1';
    border-radius:3px;
    border:1px #ddd solid;
}
.denOprList div:hover{
    cursor: pointer;
    background-color: #eee;
}
.denOprList div[act]{
    cursor: pointer;
    background-color:<?=$clr2?>;
    color:#fff;
}
#d_oprDet input{
    height: 30px;
    margin-bottom: 10px;
}
#d_oprDet textarea{
    height: 60px;
    margin-bottom: 10px;
}/*
.teethTable{
	border-collapse: inherit;
}
.teethTable td{
	border:1px #ccc solid;
	text-align: center;
	font-size: 14px;
	height:25px;
    font-family:'ff',tahoma;
    font-weight: bold;
    margin: 1px;
    border-radius:3px;
    background-color: #fff;
}
.teethTable td:hover{cursor: pointer;background-color:#eee;}
.teethTable td[act]{background-color:#E5EE55;}
.teethTable td[br]{border-left:2px #999 solid;}
.teethTable td[bl]{border-right:2px #999 solid;}
.teethTable tr[r1] td{border-bottom:2px #999 solid;}
.teethTable tr[r2] td{border-top:2px #999 solid;}*/
    
.teethTab > div{padding:20px;}
.teethTab > div > div{
    float: left;
    border:1px #ccc solid;
	text-align: center;
	font-size: 14px;
	line-height:100%;
    text-align: center;
    padding:10px 3px;
    font-family:'ff',tahoma;
    font-weight: bold;
    margin:2px;
    border-radius:3px;
    background-color: #fff;
}
.teethTab > div > div:hover{cursor: pointer;background-color: #eee;}
.teethTab > div > div[act]{background-color: #FFF3A8;}
@media screen and (max-width:1300px){.teethTab > div{margin-bottom:20px;}}
.teethTab [r1]{padding: 5px; border-bottom:1px #999 solid; border-right:1px #999 solid;}
.teethTab [r2]{padding: 5px; border-bottom:1px #999 solid; border-left:1px #999 solid;}
.teethTab [r3]{padding: 5px; border-top:1px #999 solid; border-right:1px #999 solid;}
.teethTab [r4]{padding: 5px; border-top:1px #999 solid; border-left:1px #999 solid;}

.addDTxt{
    background: url("images/gnr/dtsS1.png")#fff no-repeat <?=$align?> center;
    margin-top:10px;
    padding-<?=$align?>: 30px;
    height: 35px;
    line-height: 35px;
    font-family: 'f1',tahoma;
}    
.addDTxt input{
    background: url("images/sys/add_b.png")#fff no-repeat <?=$align?> center;
    margin-top:10px;
    padding-<?=$align?>: 30px;
    height: 35px;
    line-height: 35px;
    font-family: 'f1',tahoma;
    border:1px #eee solid;    
    margin-<?=$Xalign?>:5px;
}
[levAdd]{margin-top:10px;}
[levAddRow]{
    box-sizing: border-box;
    margin-top: 10px;
    width: 100%;
    height: 44px;
    display: grid;
    grid-template-columns: 1fr 32px 32px;
    background-color: #eee;
    padding: 5px;
    padding-<?=$Xalign?>:5px;
    border-radius: 3px;
    border: 1px #ddd solid;
}
[noteInput] input{    
    height: 30px;
    font-family:'f1',tahoma;
}
[levT]{
    margin-<?=$Xalign?>:10px;
}
.levTxt{
    display: grid;
    grid-template-columns:auto 1fr 30px 30px;
    border-bottom: 1px #eee solid;
    padding:5px 0;
}
.levTxt:hover{background-color: #eee;}
.levTxt [butt]{display: none;}
.levTxt:hover [butt]{display: block;}
.levTxt [d]{
    color: <?=$clr8?>;
    margin-<?=$Xalign?>:10px; 
}
[levTxt][new]{
    background-color:rgba(255,255,255,0.00);
    animation-name: changeBg;
    animation-duration:5s;
}

@keyframes changeBg{
  from {background-color:#E6ED72;}
  to {background-color:rgba(255,255,255,0.00);}
}
[levDelCnc]{
    position: absolute;    
    height: 40px;
    line-height: 40px;
    left:80px;
    width:80px;
    padding: 0 10px;
    text-align: center;
    display: none;
}
/**********************************************/
.tt_ic{    
    text-indent: 40px;    
    color: #fff;
    background-size: 80% auto;
    
}
.tt_ic_c{ background: url(images/den_ab_icon.png) #44a0e3 no-repeat <?=$align?> bottom;}
.tt_ic_a{ background: url(images/den_ab_icon.png) #693599 no-repeat <?=$align?> top;}

[viewType='1']{
    display: grid;
    grid-template-columns:280px 320px 1fr 50px;
    grid-template-rows:100%    
}
@media screen and (max-width:1300px){[viewType='1']{grid-template-columns:280px 240px 1fr 50px;}}
[viewType='2']{    
    display: grid;
    grid-template-columns:280px 1fr 50px;
    grid-template-rows:100%    
}
@media screen and (max-width:1200px){[viewType='2']{grid-template-columns: 280px 1fr 50px;}}
[viewType='3']{    
    display: grid;
    grid-template-columns:280px 300px 1fr 50px;
    grid-template-rows:100%    
}
@media screen and (max-width:1200px){[viewType='3']{grid-template-columns: 280px 280px 1fr 50px;}}
#swButt div::after{
    float: <?=$Xalign?>;
    content:'';
    width:20px;
    height: 40px;
    background: url("images/sys/arr_w_<?=$align?>.png") no-repeat <?=$Xalign?> center;
}
#teethMap[selMood='1'] [t] , #teethMap[selMood='2'] [r]{
    border: 2px #000 dashed;
}
#teethMap[selMood='1'] [t]:hover,#teethMap[selMood='2'] [r]:hover{
    border: 2px #f00 dashed;
}

[teethInfo][selMoodS='1'] [p]{
    border: 2px #000 dashed;
}
[teethInfo][selMoodS='1'] [p]:hover{
    border: 2px #f00 dashed;
    color: #f00;
    cursor: pointer;
}
.teeTab > div{padding:10px;}
.teeTab > div > div{		
	line-height:100%;
    text-align: center;    
    font-family:'ff',tahoma;
    font-weight: bold;
    margin:2px;
    border-radius:5px;
}
.teeTab > div> div> div[r]{
    border:1px #ccc solid;
    border-radius:5px;
    font-family:'ff',tahoma;
    font-weight: bold;
    background-color: #fff;
    line-height: 20px;
    height: 20px;
    margin:3px 0;
    display: flex;    
    justify-content: center;
}
.teeTab > div> div> div[r]:hover{cursor: pointer;border:1px #666 solid;}
.teeTab [ER]{
    width: 4px;
    height: 4px;
    line-height:15px;
    float:left;
    background-color: #fff;
    margin: 8px 1px;
    border-radius:5px;
    font-size: 10px;
    background-color: #ccc;
}
.teeTab [ER='1']{
    background-color: #000;
    border: 1px #ccc solid;
    width: 5px;
    height: 5px;
    margin: 6px 1px;
}
.teeTab div[t]{
    border-radius:5px;
    border:1px #ccc solid;    
    background-color: #fff;    
    margin:2px 0;
    display: grid;
    grid-template-columns: 6px auto 6px;
    grid-template-rows:6px auto 6xp;
    overflow: hidden;
    color: #000;
    font-weight: bold;
    font-size:2px;
    font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
    box-sizing: border-box;
}
.teeTab div[t]:hover{cursor: pointer;border:1px #666 solid;}
.teeTab div[t] div{    
    font-family: 'ff';
    line-height: 21px;    
    box-sizing: border-box;
    border-radius: 3px;    
}
.teeTab div[t] div[n]{    
    font-size: 14px;
    border-radius:0px;
    font-weight: bold;    
    border:1px #fff dotted;
    text-shadow: 0px 0px 1px #fff,0px 0px 1px #fff,0px 0px 1px #fff,0px 0px 1px #fff;
}   
.teeTab div[t] div[c]{
    padding: 0;
    margin: 0;
    width:10px;
    height:10px;    
}
@media screen and (max-width:1000px){
    .teeTab > div{margin:5px 10px;}
    .teeTab div[t] div[n]{line-height: 20px;}
    .teeTab div[r]{line-height: 20px;}
}
.teeTab [r1] , .teeTab [r5]{padding: 5px; border-bottom:1px #999 solid; border-right:1px #999 solid;}
.teeTab [r2] , .teeTab [r6]{padding: 5px; border-bottom:1px #999 solid; border-left:1px #999 solid;}
.teeTab [r4] , .teeTab [r8]{padding: 5px; border-top:1px #999 solid; border-right:1px #999 solid;}
.teeTab [r3] , .teeTab [r7]{padding: 5px; border-top:1px #999 solid; border-left:1px #999 solid;}


.tToolH div[no],.tToolH div[noP]{
    display: grid;
    grid-template-columns: 35px 1fr;
    background-position: <?=$align?> center;
    height: 35px;
    line-height: 35px;
    margin-top: 5px;
    border-radius:3px;
    box-sizing: border-box;
}
.tToolH div[no]:hover,.tToolH div[noP]:hover,.tToolH div[noS]:hover{
    filter: brightness(0.9);
    cursor: pointer;
}
.tToolH div[noS]{
    height: 30px;
    line-height: 30px;       
    color: #fff;
    text-align: center;
    font-size: 10px;
}
.tToolH div[i]{   
    height: 33px;
    width: 35px;
    padding:5px;
    background-color: #fff;
    border-radius:2px;
    box-sizing: border-box;
}
.tToolH div[t]{
    height: 35px;
    line-height:35px;       
    color: #fff; 
}

.tToolHS div[no],.tToolHS div[noP]{
    display: grid;
    grid-template-columns: 35px 1fr;
    background-position: <?=$align?> center;
    height: 35px;
    line-height: 35px;
    margin-top: 5px;
    border-radius:3px;
    box-sizing: border-box;
}
.tToolHS div[no]:hover,.tToolHS div[noP]:hover,.tToolHS div[noS]:hover{
    filter: brightness(0.9);
    cursor: pointer;
}
.tToolHS div[noS]{
    height: 30px;
    line-height: 30px;       
    color: #fff;
    text-align: center;
    font-size: 10px;
}
.tToolHS div[i]{   
    height: 33px;
    width: 35px;
    padding:5px;
    background-color: #fff;
    border-radius:2px;
    box-sizing: border-box;
}
.tToolHS div[t]{
    height: 35px;
    line-height:35px;       
    color: #fff; 
}

[subTee]{display: none;}
.tBoxHold{
    margin: auto 0;
    display: grid;
    grid-template-columns:1fr 30vw 1fr;
    grid-template-rows: min(30vw,50vh);
    align-self: center;    
}
.mainTeeth{
    display: grid;
    grid-template-columns:1fr 2fr 1fr;
    grid-template-rows:1fr 2fr 1fr;
    grid-gap:5px;
    border:1px #ccc solid;
       border-radius:5%;
    box-sizing: border-box;
    padding: 10px;
}
.mainTeeth > div{
    display: grid;
    box-sizing: border-box;
    line-height:auto;
    text-align: center;
    font-size: 50px;
    align-items: center;
}
.mainTeeth > div[p]{
    border:2px #ccc solid;
    text-shadow:0px 0px 2px #fff,0px 0px 2px #fff,0px 0px 2px #fff,0px 0px 2px #fff;
    border-radius: 10px;
    text-transform: uppercase;
    font-family: 'ff';
    background-color: #fff;
}
.disBlock{
    filter: grayscale(5);    
}
.tLoader{
    background: url("images/sys/load.gif") no-repeat center center;
}
[theethMap='1']{
    display: grid;
    grid-template-columns:1fr 3fr;
    grid-template-rows:40px 3fr 0px;
}
[theethMap='2']{
    display: grid;
    grid-template-columns:0 1fr;
    grid-template-rows:40px 182px 1fr;
}
[theethMap='2'] [hPart]{
    padding: 0px;
    margin: 0px;
}
@media screen and (max-height:550px){
    [theethMap='2']{
        display: grid;
        grid-template-columns:0px 3fr;
        grid-template-rows:40px 86px 3fr;
    }
    [theethMap='2'] [teNote]{
        display:none;
    }
}
.teeTab div[t][actTeethSel],.teeTab div[r][actTeethSel]{    
    border-left:5px #000 solid;
    border-right:5px #000 solid;
    box-sizing: border-box;
    
}
div[tB1],div[tB5]{
    border-right: 5px solid <?=$t_bordd_l?>;border-bottom: 5px solid <?=$t_bordd_l?>;
    border-bottom-right-radius: 0%;
}
div[tB2],div[tB6]{
    border-left: 5px solid <?=$t_bordd_l?>;border-bottom: 5px solid <?=$t_bordd_l?>;
    border-bottom-left-radius: 0%;
}
div[tB3],div[tB7]{
    border-left: 5px solid <?=$t_bordd_l?>;border-top: 5px solid <?=$t_bordd_l?>;
    border-top-left-radius: 0%;
}
div[tB4],div[tB8]{
    border-right: 5px solid <?=$t_bordd_l?>;border-top: 5px solid <?=$t_bordd_l?>;
    border-top-right-radius: 0%;
}
.mainRoot{
    grid-gap:5px;
    border:1px #ccc solid;
    border-radius:5%;
    box-sizing: border-box;
    padding: 10px;
    margin: auto ;
    max-width: 200px;
    max-height: 300px;
    padding: auto
}
.tRooTab{
	border-radius: 10px;
}
.tRooTab td{				
	border:1px #ccc dashed;
	border-radius: 10px;
	text-align: center;    
}
.tRooTab td{text-align: center;}
.tRooTab div{
    text-transform: uppercase;    
    background-color: #fff;
    font-size: 14px;
    font-family: 'ff';
    font-weight: bold;
    width: 60px;
    height: 60px;
    line-height: 58px;
	border:2px #999 solid;
	color:#333;
	border-radius: 50%;	
	text-align: center;
	margin: 5px auto 5px auto;
	box-sizing: border-box;			
}
[teethInfo][selMoodS='1'] .rrr,[teethInfo][selMoodS='2'] .rrr{
    border: 2px #000 dashed;
}
[teethInfo][selMoodS='1'] .rrr:hover,[teethInfo][selMoodS='2'] .rrr:hover{
    border: 2px #f00 dashed;
    color: #f00;
    cursor: pointer;
}
.denOthOpr{border-top:3px #999 solid;}
.denOthOpr > div{
	height:50px;
	line-height: 50px;
	font-family: 'f1';	
	background-color: #333;
	color:#eee;
	text-indent: 50px;
	margin-top: 0px;
	border-bottom:1px #555 solid;
	background-repeat: no-repeat;
	background-position: <?=$align?> center;
    background-image: url("images/add/mr.png")
}
.denOthOpr > div:hover{
	background-color: #555;cursor: pointer;
}
.denOthOpr > div[act='1']{background-color:#000;}
/*******************/
.denMHis [mhit] [act]{		
	background-color:<?=$clr9?>;
	padding:5px;
	color:#fff;
    border-radius: 5px;
    text-align: center;
}
.denMHis [mhit] [art]{		
	background-color:<?=$clr5?>;	
	padding:5px;
	color:#fff;
    border-radius: 5px;
    text-align: center;
}
.denMHis [mhit]:hover .oprDenH{display: block;}
.oprDenH{
    z-index: 100;
    min-height: 40px;
    float: left;
}
.hidCb{
	width: 15px;
	height: 15px;
	border-radius: 50%;
	margin:7px 0px;
}
.prvHislistDen > div[ih]{
	background-color:#fff;
	width: 100%;
	padding:10px 0px;
	margin-bottom: 10px;
	border-radius:5px;	
    border:1px #ccc solid;
	color:<?=$addColor?>;
}
.prvHislistDen > div[ih]:hover{background-color: #eee; cursor: pointer;}
/****/
.denCliTi{
    background-color: #b24dac;
    color: #fff;
}
.clinicDenList > div{
    height: 40px;
    line-height: 40px;
    border-bottom: 1px #ccc solid;
    display: grid;
    grid-template-columns: 40px 1fr 20px;
}
.clinicDenList [arr]{
    height: 40px;
    background: url("images/treeArr_left.png")  no-repeat <?=$Xalign?> center;
    filter: brightness(.5);
}
.clinicDenList > div:hover{
    background-color: #ddbbdb;
    cursor: pointer;
}
.clinicDenList > div[act]{
    background-color: #dbc5da;    
}
.clinicDenList div[i]{
    height: 40px;
    width: 40px;
    padding: 6px;
    box-sizing: border-box;
    text-align: center;
}
.clinicDenList div[t]{
    font-family: 'f1';
}
.clinicDenListIn > div{
    margin-bottom: 10px;
    border:1px #ccc solid;
    background-color: #eee;
    border-radius: 5px;
    padding:0px 10px;
}
.clinicDenListIn  div[tit]{
    height: 40px;
    line-height: 40px;
    border-bottom: 1px #eee solid;
    display: grid;
    grid-template-columns:30px 1fr 40px;
    border-bottom: 1px #ccc solid;
}
.clinicDenListIn div[i]{
    height: 40px;
    width: 30px;
    padding-top:6px;
    padding-<?=$Xalign?>: 5px;
    box-sizing: border-box;
    text-align: center;    
}
.clinicDenListIn div[t]{
    font-family: 'f1';
    font-size: 14px;
}
.denClnForm{

}
.denClnForm .dciM{
    width:100%;
    max-width:615px;
}
.denClnForm div[ti]{
    font-family: 'f1';    
    padding-<?=$Xalign?>:10px;
    min-height: 40px;
    line-height: 40px;
}
.denClnForm div[in]{    
    margin-bottom:20px;
    padding: 5px;
    padding-bottom:0px;
    
}
.denClnForm [st]{    
    min-width:200px;    
}
.denClnForm [st=dcv1]{ background-color: #EEF5FF}
.denClnForm [st=dcv1]:hover{background-color: #5D9FFF}
.denClnForm [st=dcv1][ch=on]{background-color: #0052CB;color: #fff;}
    
.denClnForm [st=dcv2]{ background-color: #EBFFED}
.denClnForm [st=dcv2]:hover{background-color: #34AF41}
.denClnForm [st=dcv2][ch=on]{background-color: #44A24E;color: #fff;}
    
.denClnForm [st=dcv3]{ background-color: #F9E8E8}
.denClnForm [st=dcv3]:hover{background-color: #C75B5B}
.denClnForm [st=dcv3][ch=on]{background-color: #AF2D2D;color: #fff;}   
.dciS_1{ color: #000;}
.dciS_2{ color: #30B34B;}
.dciS_3{ color: #BC3142;}
</style>