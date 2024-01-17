<? session_start();/***CLN***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.clicList{
	box-sizing: border-box;
	position:relative;
	width:50%;
	border-<?=$Xalign?>:1px #ccc solid;
}
.visListT{
	box-sizing: border-box;
	padding-left:10px;
	padding-right:10px;
	position:relative;
	width:230px;
}

.clicListInTitle{
	border-bottom: 4px <?=$clr1?> solid;
	margin-top: 10px;
	position: relative;
	width: 100%;
}
.visTab{
	line-height:40px;
	background-color:#eee;
	border: 0px;
	margin: 0px;	
	width: 50%;
	max-width: 200px;
	color:#666;
}
.visTab[s=off]:hover{
	background-color:#ccc;
	cursor: pointer;
}
.visTab[s=on]{background-color:<?=$clr1?>;color: #fff;}

.cli_blc2{
	line-height:41px;
	width: 100%;
	margin:2px;
	white-space:nowrap;	
	background-color:<?=$clr2?>;
	color:#fff;
}
.cli_blc2:hover{background-color:<?=$clr3?>; cursor:pointer; }
.cli_icon{
	height:30px;
	width:30px;
	margin:3px;
	margin-<?=$Xalign?>:10px;
	padding-<?=$Xalign?>:5px;
	border-<?=$Xalign?>:1px #999 solid;
}
.cli_name2{
	border-top:1px #eee solid;
	padding-top: 5px;
}
.cli_blc3{
	min-width:40px;
	border:1px #666 solid;
	white-space:nowrap;
	border-bottom:4px <?=$clr3?> solid;
	margin: 5px auto;
	margin-bottom: 10px;	
}
.cli_name{
	margin-top:10px;
	margin-bottom:5px;
	color:<?=$clr1111?>;
	width:100%;
}
.cdoc_name{	
	border-top:1px #eee solid;
}
.cdoc_name2{	
	border-top:1px #eee solid;
}
.bar{
	height:8px;
	background-color:#ccc;
	width:100%;
	float:<?=$align?>;
	position:relative;
	margin-bottom:5px;
}
.bar div{height:4px;}
.bar div[a]{background-color:<?=$clr1?>;}
.bar div[b]{background-color:<?=$clr3?>;}
.bar .pointer {
	position:absolute;
	width:1px;
	border-<?=$align?>:2px <?=$clr5?> solid;
	height:12px;
}
.cs2_t1{background-color:<?=$clr6?>; color:#fff;}
.cs2_t2{background-color:<?=$clr5?>; color:#fff;}
.x_clinic{
	width:100%;
	background-color:<?=$clr5?>;
	position:absolute;
	height:0px;
	line-height:0px;
	z-index:2;
	margin-top:-50px;	
	text-align:center;	
	color:#fff	
}
.cli_blc:hover > .x_clinic{
	width:100%;
	background-color:<?=$clr5?>;
	position:absolute;
	height:100%;
	line-height: 100px;;
	margin-top:0px;
	z-index:2;		
	text-align:center;	
	color:#fff;
	cursor: no-drop;
	opacity: 0.95;
}
.x_visit_List{
	border:1px #999 solid;
	border-bottom:4px #666 solid;	
	float:<?=$align?>;
	width:100%;
	margin-bottom:8px;
	padding-bottom:0px;
	text-align:center;
	margin-<?=$Xalign?>:8px;
}
.cli_blc[s=x1]{background-color: #fcc; }
.cli_blc[s=x2]{background-color: #ccc; }
.x_visit_List_act:hover{background-color:#eee; cursor:pointer;}
.ex_s0,.ex_s2{ background-color:#ccc; color:#fff;}
.ex_s1,.ex_s3{ background-color:<?=$clr6?>; color:#fff;}
.ins_s0{ background-color:#ccc; color:#fff;}
.ins_s1{ background-color:<?=$clr77?>; color:#fff;}
.ins_s2{ background-color:<?=$clr6?>; color:#fff;}
.docRows{
	border:1px #ccc solid;
	padding:5px;
	margin:5px;
	max-width:200px;
	text-align:center
}
.clic_bar{
	background-color:#eee;
	border-bottom:1px #ccc solid;
	border-top:1px #ccc solid;
	margin-bottom:30px;
	position:relative;
	height:15px;
	line-height:15px;
}
.clic_bar_in{
	height:15px;
	line-height:15px;
	color:#fff;
	text-indent:5px;
	font-size:11px;
	position:absolute;
}
.clic_bar_in span{font-size:10px;}
.cbn_1{background-color:<?=$clr1?>;}
.cbn_1:hover{background-color:<?=$clr111?>;cursor:pointer;}
.cbn_2{background-color:<?=$clr5?>;}
.cbn_2:hover{background-color:<?=$clr55?>;cursor:pointer;}
.datesTable{
	margin:10px;
	border:1px #ccc solid;
	padding:10px;
}
.timePointer{
	position:absolute;
	height:32px;
	margin-top:-14px;
	width:100%;
	z-index:-1;
}
.timePointer div:first-child{margin-<?=$align?>:0px;}
.timePointer div{ border-<?=$align?>:1px #ccc solid; float:<?=$align?>; height:100%; margin-<?=$align?>:-1px;}
.cliLine{
	border-top:1px #eee dotted;
	width:100%;
	height:20px;
}
.cobg1{
	 background-color:#099;
}
.buutAdd{
	width:35px;
	height:35px;
	background:url(images/addpat.png) #eee no-repeat center center;
	border-radius:20px;
	margin:0px auto;
}
.buutAdd:hover{background-color:#fff; cursor:pointer;}
.buutAdd2{
	width:35px;
	height:35px;
	background:url(images/addpat.png) <?=$clr1?> no-repeat center center;
	border-radius:20px;
	margin:0px auto;
}
.buutAdd2:hover{background-color:<?=$clr1111?>; cursor:pointer;}
.finshSrv{
	width:40px;
	height:40px;
	background-repeat:no-repeat;
	background-position:center center;	
	border-radius:20px;
	margin:2px;
	
}
.finshSrv0{background-color:#ccc;background-image:url(images/prv_icon2.png);}
.finshSrv0:hover{background-color:#aaa;cursor:pointer;}
.finshSrv1{background-color:#6d6;background-image:url(images/end.png);}
.finshSrv2{background-color:#e2d034;background-image:url(images/prv_icon2.png);}
.finshSrv3{background-color:#F00;background-image:url(images/delete2.png);}
.finshSrv3:hover,.finshSrv2:hover{background-color:#e00; cursor:pointer}
.visRows3{
	border:1px #aaa solid;
	margin-bottom:10px;
	border-radius:0px;
	background-color:#FF0;
	width: 100%;
}
.visRows3 div[r1]{
	height:30px;	
}
.visRows3 div[a]{
	background-color:#FF0;
	color:#000;
	border: 1px #ccc solid;
}
.visRows4{
	margin-bottom:10px;
	background-color:#fee;
	border:1px #ccc solid;
	width: 100%;
}
.visRows4:hover{cursor:pointer; background-color:#faa;}

.visRows:hover{border:1px #000 solid; cursor:pointer;}
.visRows div[r1]{
	height:50px;
	border-bottom:1px #999 solid
}
.visRows div[a] , .visRows3 div[a]{
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

.visRows div[b]{
	height:50px;
	line-height:25px;	
	text-align:center;
	background-color:#eee;
}
.visRows div[c]{
	width:50px;
	height:50px;
	line-height:50px;
	text-align:center;
	color:#fff;
	font-family:'ff';
	font-size:22px;
	font-weight:bold;
}
.visInDoc{ line-height:20px;height:40px; padding:0px; overflow:hidden;}
.visRows div[d]{background-color:#ddd;}

/************************************/
.toolsCont{
	padding:9px;
	background-color:<?=$clr1111?>;
	position:absolute;
	top:100px;
	max-width:192px;
	z-index:10;
	<?=$Xalign?>:70px;
	display:none;
}
.toolsCont > div{
	width:60px;
	height:60px;
	background-position-y:top;
	background-repeat:no-repeat;
	margin:2px;
	border-radius:2px;
}
.toolsCont > div:hover{background-color:<?=$clr11?>;cursor:pointer;}
.toolsCont > div > div{font-family:'f1'; text-align:center;margin-top:52px;color:<?=$clr1?>;font-size:10px;}
.toolsCont > div:hover > div{color:#fff;}
.topBar{
	height:50px;
	margin-top:5px;
}
.slidNote{
	margin:10px;
	margin-top:20px;
	border:1px #999 solid;
	background-color:#666;
	color:#fff;
	border-radius:5px;
	background-image:url(images/arr_downs.png);
	background-repeat:no-repeat;
	background-position:<?=$align?> center;
	text-indent:40px;
	max-width:250px;
}
.slidNote:hover{background-color:<?=$clr1?>; cursor:pointer;}
.r90{
	-ms-transform: rotate(270);
	-webkit-transform: rotate(270deg);
	transform: rotate(270deg);		
}
.Xcolum2{
	border-right:1px <?=$clr3?> solid;
	width:30px;
	max-width:120px;
}
.cTot{
	position:absolute;
	background-color:<?=$clr5?>;
	padding:4px;
	color:#fff;
	border-radius:50px;
	font-size:1vw;	
	text-align:center;
	top:3px;
}
.Xcolum2:last-child{
	border-left:1px #999 solid;	
}
.Xcolum{
	width:30px;
}
.xx_header{
	margin:5px;
	height:80px;
	border:1px #999 solid;
}
.xx_r_s{
	border-left:1px #999 solid;
}
.xc_icon{
	width:34px;
	height:34px;
	padding:3px;
}
.xc_code{
	border-top:1px #999 solid;
	width:40px;
	height:40px;
	line-height:40px;
	text-align:center;
	font-size:30px;
}
.clinic_name{
	height:60px;
	line-height:60px;
	padding:10px;
	text-align:center;
	font-size:28px;
	color:#fff;
}
.XcolumIn{
	margin:5px;
	margin-top:10px;	
	height:100%;
	border:1px #999 solid;
	background-color:#f5f5f5
}
.xcn{ width:50%;}
.m_bgx{
	z-index:-1;
	width:100%;
	height:50px;
	position:absolute;
	background-color:<?=$clr44?>;
	border-bottom:5px <?=$clr2?> solid;
}
.b_bgx{
	position:absolute;
	bottom:0px;

	background-color:#fff;
	width:100%;
	border-top:2px #999 solid;
}
.Xcolum2 div[a]{
	height:90px;
	border-bottom:1px #ccc solid;
	text-align:center;
	text-indent:10px;
	background-color:<?=$clr1?>;
	color:#fff;
	overflow:hidden;
}
.Xcolum2 div[a] div{white-space:nowrap;}
.Xcolum2 div[aa]{		
	border-bottom:1px #fff solid;
	background-color:<?=$clr1?>;
	color:#fff;
	text-align:center;
	font-size:40px;
}
div[rr]{	
	text-align:center;	
	font-weight:bold;
	border:1px #999 solid;
	overflow:hidden;
	font-size:35px;
}
.Xcolum2 div[b]{
	height:40px;
	border-bottom:5px <?=$clr3?> solid;
	text-align:center;
	background-color:<?=$clr44?>;
	padding:3px;
}
div[rr]{	
	text-align:center;	
	font-weight:bold;
	border-bottom:2px #999 solid;
	overflow:hidden;
}
div[rr] div[r_a]{
	font-size:50px;
	font-family:'ff';
	height:80px;
	line-height:80px;
}
div[rr] div[r_a2]{	
	font-family:'ff';
}
div[rr] div[r_a] span{line-height:10px;font-family:'ff';}
div[rr] div[r_b]{
	font-size:16px;
	font-family:'ff';
}
div[rr] div[r_c]{	
	font-family:'ff';	
	font-weight:bold;
	color:#fff;
}
div[sr=s0]{background-color:<?=$clr4?>;}
div[sr=s1]{
	background-color:<?=$clr5?>;	
    animation-name:changeColor;
    animation-duration:0.3s;
	animation-iteration-count:infinite;
}
div[sr=s2]{background-color:<?=$clr6?>;}
div[sr=s3]{background-color:#FF3;}
div[sr=s9]{background-color:<?=$clr5?>;}
div[sr=s91]{background-color:#fc5e27;}
div[sr=s92]{background-color:#63bdde;}
.titleInXC{
	text-align:center;	
	font-weight:bold;
	border:1px #999 solid;
	overflow:hidden;
	font-size:30px;
}
.InXC1{background-color:#ccc;}
.InXC2{background-color:#ee0;}
.timeStatus{
	background-color:<?=$clr111?>;
	width:100px;
	height:60px;
}
.timeStatus:hover{background-color:<?=$clr1111?>; cursor:pointer;}
.timeStatus div[line]{height:29px; border-bottom:1px <?=$clr11?> solid;}
.timeStatus div[num]{
	height:30px;
	line-height:30px;
	width:64px;
	text-align:center;
	color:#fff;
}
.timeStatus div[icon]{
	height:30px; 
	width:34px;
	background:url(images/prv_icon1.png) <?=$clr1111?> no-repeat center center ;
}
.timeStatus div[line2]{height:30px;}
.timeStatus div[num2]{
	height:30px;
	line-height:30px;
	width:64px;
	text-align:center;
	color:#fff;
}
.timeStatus div[icon2]{
	height:30px; 
	width:34px;
	background:url(images/prv_icon2.png) <?=$clr1111?> no-repeat center center ;
}
.per_h1{
	width:240px;
	background-color:#e5e7ea;
}
.per_h11:hover{
	background-color:#ccc;
	cursor:pointer;
}
.per_h11{
	height:45px;	
}
.per_h12{
	height:25px;
	background-color:#ddd;
	color: #333
}
.pa_icon{
	height:45px;
	width:45px;
	background:url(images/pat_icon2.png) <?=$clr3?> no-repeat center center;
}
.pa_name{	
	height:45px;
	line-height:45px;
	text-indent:5px;
}
.inf_name{
	height:25px;
	line-height:25px;
	text-indent:5px;
	color:#333;
}
.blod_box{
	height:30px;
	width: 40px;
	line-height:30px;	
	text-align:center;
	color:#fff;
	font-weight:bold;
	font-size:16px;
	background:url(images/blood_ico.png) <?=$clr5?> no-repeat center 50px;
	letter-spacing:2px;
	text-transform:uppercase;
	overflow:hidden;
	direction: ltr;
}
.blod_box:hover{background-color:<?=$clr55?>;cursor:pointer;}
.blod_box_0{background:url(images/blood_ico.png) <?=$clr5?> no-repeat center center;}
.bloods{
	padding:5px;
	width:198px;
	position:absolute;	
	background-color:<?=$clr5?>;
	margin-top:60px;
	display:none;
	z-index:11;
	margin-<?=$align?>:-208px;
}
.bloods > div{
	width:54px;
	height:54px;
	border:1px solid #eee;
	border-radius:3px;
	margin:5px;		
}
.bloods > div:hover{
	background-color:<?=$clr55?>;
	cursor:pointer;
}
.bloods > div > div{
	width:32px;
	height:32px;
	background-repeat:no-repeat;
	margin:11px;
}
.bloo_{
	width:32px;
	height:32px;
}
.bloo_0{background-image:url(images/blood0.png);background-position:center center;}
.bloo_o1{background:url(images/blood_types.png); background-position:-4px -4px;}
.bloo_o0{background:url(images/blood_types.png); background-position:-4px -44px;}
.bloo_a1{background:url(images/blood_types.png); background-position:-44px -4px;}
.bloo_a0{background:url(images/blood_types.png); background-position:-44px -44px;}
.bloo_b1{background:url(images/blood_types.png); background-position:-84px -4px;}
.bloo_b0{background:url(images/blood_types.png); background-position:-84px -44px;}
.bloo_ab1{background:url(images/blood_types.png); background-position:-124px -4px;}
.bloo_ab0{background:url(images/blood_types.png); background-position:-124px -44px;}
.bloo_{background:url(images/blood0.png); background-position:center center;}
.cost_icon{
	height:70px;
	width: 70px;
	background:url(images/cost_icon.png) <?=$clr111?> no-repeat center center;
	cursor:pointer;
}
.cost_icon:hover{background-color:<?=$clr11?>;}
.datesline{
	width:100%;
	height:50px;
	background-color:#eee;
	border-bottom:1px #ccc solid;	
	position:relative;
}
.topBar{
	height:50px;
	margin-top:5px;
}
.addPati{
	width:43px;
	height:43px;
	background:url(images/pcat_add.png) <?=$clr1?> no-repeat center center; 
}
.addPati:hover{
	cursor:pointer;
	background-color:<?=$clr11?>;
}
.ser_no{
	width:100px;
	height:43px;
	padding-<?=$Xalign?>:20px;
}
.ser_pa{
	width:440px;
	height:43px;
	padding-<?=$Xalign?>:20px;
}
.msg_y{
	font-size:16px;
	margin:10px;
}
#pa_list{
	border:1px solid #e6e8eb;
	height:250px;
	margin:5px 0px;
	padding:10px;
}
.add_listT {
	overflow-x:hidden;
	padding-<?=$Xalign?>:10px;
}
.buttSave{display:none;}
.addvisitBox{
	width:280px;
	margin:20px;
	padding:10px;
	border:1px solid <?=$clr1?>;
}
.listDataSelCon{
	height:54px;
}
.listDataSel input{
	height:40px;
	border:1px solid #e5e7ea;
	background:url(images/pcat_ser.png) no-repeat <?=$Xalign?> center;
	max-width:100%;
}
.blc_win_title_icons div:hover{background-color:<?=$clr11?>;cursor:pointer;}
.editToList{background:url(images/icon_c_edit.png) <?=$clr1?> no-repeat center center;}
.delToList{background:url(images/delete2.png) <?=$clr5?> no-repeat center center;}
.printToList{background:url(images/icon_c_print.png) <?=$clr1?> no-repeat center center;}
.saveToList{background:url(images/b_save.png) <?=$clr1?> no-repeat center center;}
.save2ToList{background:url(images/icon_save.png) <?=$clr1?> no-repeat center center;}
.loadToList{background:url(images/icon_load.png) <?=$clr1?> no-repeat center center;}
.ve2ToL{width:40px;height:40px; margin-<?=$align?>:10px; border-radius:5px; cursor:pointer;}
.save2ToList2{background:url(images/icon_save.png) <?=$clr1?> no-repeat center center;}
.loadToList2{background:url(images/icon_load.png) <?=$clr5?> no-repeat center center;}
.save2ToList2:hover{background-color:<?=$clr1111?>}
.loadToList2:hover{background-color:<?=$clr55?>;}
.proTab_in{
	border:1px solid #e5e7ea;
	padding:10px;
	overflow:hidden;
	border-radius:2px;
}
.op_list > div{
	min-height:12px;
	background-color:#e7e9eb;
	margin-<?=$Xalign?>:10px;
	margin-bottom:5px;	
	padding:10px;
	color:#676771;
	border-radius:2px;
	font-family:'f1',tahoma;
	font-size:16px;	
	border-bottom:1px #999 solid;
}
.op_list > div span{ font-family:'f1',tahoma;font-size:16px;}
.op_list > div:hover{
	cursor:pointer;
	color:#fff;
	background:url(images/icon_edit22.png) #999 no-repeat <?=$align?> 5px;
	text-indent:30px;
}
.sel_option{
	width:150px;
	border:1px solid <?=$clr4?>;
	border-<?=$align?>:0px;
	padding:10px;
	overflow-x:hidden;
}
.listButt{	
	background-color:<?=$clr4?>;
	margin-bottom:10px;
	margin-<?=$Xalign?>:10px;
	height:35px;
	line-height:35px;
	color:#fff;
	border-radius:2px;
	border-bottom:2px <?=$clr1111?> solid;
}
.delTag{
	position:absolute;	
	background:url(images/delete2.png) <?=$clr1111?> no-repeat center center;
	height:38px;
	width:38px;
	line-height:38px;
	text-align:center;
	font-size:16px;
	display:none;
	cursor:pointer;
}
.strTag{
	height:30px;
	line-height:35px;
	text-align:center;
	padding-left:20px;
	padding-right:20px;
	font-family:'f1',tahoma;
	font-size:14px;
}
.secTitle{
	height:40px;
	line-height:40px;
	color:#a1aab7;
	border-bottom:1px solid #ccc;
	background-color:#eee;	
	border-radius:5px 5px 0px 0px;
}
.secCon{
	margin:18px;
	line-height:18px;
	color:<?=$clr2?>;
	overflow-x:hidden;
}
.secCon div{font-family:'f1',tahoma; font-size:14px; color:<?=$clr3?>}
.editMad{
	width:32px;
	height:32px;
	margin:4px;
	background:url(images/icon_edit2.png) no-repeat left center;
}
.editMad:hover{
	background-position:right center;
	cursor:pointer;
}
.madTitle{
	margin-<?=$align?>:18px;
	font-family:'f1',Tahoma, Geneva;
	font-size:16px;
	color:#666;
	white-space:nowrap;
}
.listData2 , .listData{
	width:280px;
	height:100%;
	border-<?=$Xalign?>:1px solid <?=$clr4?>;
}
.listDataSelCon2{
	height:54px;
}
.listDataSelCon22{
	padding-top:10px;
	height:50px;
	border-bottom:1px #ccc dotted;
}
.listDataSel2 input{
	height:36px;
	width:100%;
	border:2px solid #e5e7ea;
	background:url(images/pcat_ser.png) no-repeat <?=$Xalign?> center;
	max-width:100%;
}
.list_option , .list_option2{
	height:100%;
	position:relative;
	overflow-x:hidden;	
	
}
.op_list2 , .op_list{
	height:100%;
	width:100%;
}
.option_selected2 , .option_selected {
	width:100px;
	height:100%;
	padding-<?=$align?>:10px;
	overflow-x:hidden;
}
.op_list2 > div{
	min-height:12px;
	background-color:#e7e9eb;
	margin-<?=$Xalign?>:10px;
	margin-bottom:5px;	
	padding:10px;
	color:#676771;
	border-radius:2px;
	font-family:'f1',tahoma;
	font-size:16px;	
	border-bottom:1px #999 solid;
}
.op_list2 > div span{ font-family:'f1',tahoma;font-size:16px;}
.op_list2 > div:hover{
	cursor:pointer;
	color:#fff;
	background:url(images/icon_edit22.png) #999 no-repeat <?=$align?> 5px;
	text-indent:30px;
}
.sel_mad{
	width:500px;
	height:50px;
	margin:5px;
	margin-<?=$align?>:10px;
}
.mad_info{
	 overflow:hidden;
}
.paRow{ cursor:pointer;	}
.av{height:350px;}
.madTabs > div{
	width:28%;
	height:80%;
	border:1px solid #ccc;
	margin-<?=$Xalign?>:10px;
	border-radius:2px;
	background-color:#fcfcfc;
}
.madTabs > div:last-child{
	margin-<?=$Xalign?>:0px;
}
.bloo_icon{
	height:32px;
	line-height:32px;
	background-repeat:no-repeat;
	background-position:center top;
	color:<?=$clr1?>;
	font-size:30px;
	text-align:center;
	font-family:'ff',Tahoma, Geneva;
}
.bloo_icon div{
	margin:0px auto;
	width:32px;
}
.sec_Text{
	color:#989da0;
	text-align:center;
}
.pb1{
	height:8px;
	margin:3px;
}
.pb2{
	height:32px;
	margin:3px;
	font-size:18px;
	font-family:'f1',Tahoma, Geneva;
	text-align:center;
}
.pb3{
	color:#a1aab7;
	font-size:15px;;
	text-align:center;
	margin-top:-5px;
}
.f_info{ background-color:#ccc;}
.f_info div{ height:40px; line-height:40px;text-align:center; min-width:40px; font-size:18px;}
.fic_money{
	width:40px;
	height:40px;
	background:url(images/fic_money.png) #666 no-repeat center center;
}
.fic_vis{
	width:40px;
	height:40px;
	background:url(images/fic_vis.png) #666 no-repeat center center;
}
.pr_tda{}
.ServSel{
	width:150px;
	background-color:#ccc;
	height:50px;
	text-align:center;
}
.ServSel2{
	width:500px;
	height:50px;
	margin-left:5px;
	margin-right:5px;
}
.pr_tda{line-height:25px; width:100%;}
.pti_bar{
	width:100%;
	height:18px;
	background:url(images/date_e1-old.png) #ccc;
	border-<?=$align?>:0px #ccc solid;
	border-top:0px #ccc solid;
	border-bottom:0px #aaa solid;	
}
.pti_bar_in{
	width:0%;
	background:url(images/preloader3.gif) <?=$clr111?> center center;
	height:18px;
	max-width:100%;
}
.pti_bar_in div{
	width:10px;
	height:7px;
	background:url(images/pnar2.png) no-repeat center top;
	margin-left:-4px;
	margin-top:1px;
}
.srvParts > div{
	height:18px;
	line-height:18px;	
	min-width:10px;
	
}
.srvParts > div > div{
	border-<?=$align?>:2px #eee solid;
	height:18px;
	font-weight:bold;
	font-family:'ff';
	font-size:14px;
	text-align:center;

}
.srvParts > div:first-child > div{border-<?=$align?>:0px #eee solid;}
.endServ{
	background-color:<?=$clr6?>;
}
.b_bgx{
	position:absolute;
	bottom:0px;
	background-color:#fff;
	width:100%;
	border-top:2px #999 solid;
}
.xdataTable td{
	height:80px;
	line-height:40px;
	min-width:20px;
	border-radius:5px;
	color: #000;
	/*text-shadow:#000 0px 0px 2px ;*/
}
.list_del{
	width:40px;
	height:40px;
	background-image:url(images/list_del.png);
	background-color:<?=$clr5?>;
	background-position: right center;	
}
.list_del:hover{
	background-position: left center;
	cursor:pointer;
	border-radius:20px;	
}
.swWin{
	position:absolute;
	width:216px;
	background-color:<?=$clr111?>;
	border:2px <?=$clr11?> solid;
	margin-top:70px;	
	z-index:12;
	display:none;
	padding:10px;
	overflow-x:hidden;
	max-height:280px;
}
.swWin > div:last-child{ border-bottom:0px;}
.swWin > div{
	border:0px #999 solid;
	padding-left:5px;
	padding-right:5px;
	border-bottom:1px <?=$clr11?> solid;
	text-align:center;
}
.swWin > div:hover{
	background-color:<?=$clr11?>;
	cursor:pointer;
}
.sut_box{ width:40px; height:40px; background-color:transparent; z-index: 1;}
.sevises_list{
	margin-top:10px;
}
.ser_noo{
	width:30px;
	height:30px;
	background-color:<?=$clr1?>;
	text-align:center;
	margin-<?=$Xalign?>:10px;
	color:#fff;
	border-radius:20px;
}
.ad_po{
	height:80px;
	border-top:1px #ccc solid;
	background-color:#dadada;
}
.finshSrvS{
	width:40px;
	height:40px;
	background-repeat:no-repeat;
	background-position:center center;
	background-image:url(images/end.png);
	border-radius:20px;
	cursor:pointer; 
	margin:2px;
}
.finshSrvS0{background-color:#ccc;background-image: url(images/re_icon.png);}
.finshSrvS0:hover{background-color:#999;}
.finshSrvS1{background-color:#6d6;}
.finshSrvS1:hover{background-color:#6f6;}
.finshSrvS2{background-color:#e2d034;background-image: url(images/prv_icon.png);}
.finshSrvS3{background-color:<?=$clr1?>;background-image: url(images/print_ic.png);}
.finshSrvS3:hover{background-color:<?=$clr1111?>;}
.finshSrvS6{background-color:#e2d034;background-image: url(images/end.png);}
.list_edit_1{
	position:absolute;
	margin:0px;
	margin-top:-10px;
	margin-<?=$align?>:-10px;
	width:38px;
	height:42px;
	padding:0px;
}
.list_edit_1:hover{background-color:rgba(0,0,0,0.1);}
.siftBreak{
	border:0px;
	border-bottom:1px #666 dotted;
	width:100%;
	height:10px;
	margin-bottom:10px;
	position:relative 
}
.his_cont{
	padding-<?=$Xalign?>:10px;
}
.bod_info{
	overflow-x:hidden;
	margin-bottom:10px;
	padding-<?=$align?>:10px;
}
.fot_info{
	width:100%;
}
.ds_emsg{
	color:#F00;
	margin-top:20px;
}
.t_dates tr td:hover{
	background-color:#e2fbe2;
	cursor:pointer;
}
.hisList{
	position:relative;
	margin:5px 40px 5px 40px;
	border-radius:5px; 
	border:1px #ccc solid;
}
.hisList_d{
	height:40px;
	background-color:<?=$clr3?>;
	color:#eee;
	border-radius:5px 5px 0px 0px;
	border:1px #ccc solid;
}
.hisList_d div{
	height:40px;
	line-height:40px;
	padding-<?=$align?>:10px;
}
.hisList_d div[d]{font-size:22px;}
.hisList_d div[m]{font-size:16px;}
.hisList_d div[y]{font-size:22px;}
.hisList_d div[s]{
	background-color:<?=$clr2?>;font-size:14px;border-top-<?=$Xalign?>-radius:10px;padding-<?=$Xalign?>:10px;
}
.hisList_d div[s] span{ font-family:'ff',tahoma; font-size:16px;}
.his_con{
	position:relative; 
	line-height:35px;	
	border-bottom:1px #ccc dashed;
	font-size:16px;	
	margin:10px 10px 10px 10px;
	color:<?=$clr3?>;
	border: 1px #eee solid;
	padding: 10px;
	border-radius: 3px;
}
.his_con:hover{ background-color: #f9f9f9;}
.his_con > div[t]{	
	line-height:30px;	
	color:#000;
	
	
}
.his_con > div[r]{	
	line-height:20px;			
	padding: 4px 0px;
	color:<?=$clr9?>;
}
.his_icon1{
	position:absolute;height:40px;width:40px;top:0px;
	background:url(images/tab_p2.png) no-repeat center bottom;	
}
.his_icon2{
	position:absolute;height:40px;width:40px;top:0px;
	background:url(images/tab_p3.png) no-repeat center bottom;
}
.his_icon3{
	position:absolute;
	height:40px;width:40px;top:0px;
	background:url(images/tab_p5.png) no-repeat center bottom;
}
.his_con3{
	background-color:#eee;
	height:40px;
	margin-top:5px;
	border-radius:0px 0px 5px 5px;
	border-top:1px #ccc solid
}
.det_icon{margin=<?=$align?>:10px;}
.det_icon > div{
	height:40px;
	width:40px;
	float:<?=$align?>;
	border-<?=$Xalign?>:1px solid #ccc;
}
.det_icon > div:hover{cursor:pointer; background-color:<?=$clr3?>;}
.svi_0{ background:url(images/butt_icons.png) no-repeat 0px top;}
.svi_0:hover{ background:url(images/butt_icons.png) no-repeat 0px bottom;}
.svi_1{ background:url(images/butt_icons.png) no-repeat -40px top;}
.svi_1:hover{ background:url(images/butt_icons.png) no-repeat -40px bottom;}
.svi_2{ background:url(images/butt_icons.png) no-repeat -80px top;}
.svi_2:hover{ background:url(images/butt_icons.png) no-repeat -80px bottom;}
.svi_3{ background:url(images/butt_icons.png) no-repeat -120px top;}
.svi_3:hover{ background:url(images/butt_icons.png) no-repeat -120px bottom;}
.svi_4{ background:url(images/butt_icons.png) no-repeat -160px top;}
.svi_4:hover{ background:url(images/butt_icons.png) no-repeat -160px bottom;}
.svi_5{ background:url(images/butt_icons.png) no-repeat -200px top;}
.svi_5:hover{ background:url(images/butt_icons.png) no-repeat -200px bottom;}
.svi_6{ background:url(images/butt_icons.png) no-repeat -240px top;}
.svi_6:hover{ background:url(images/butt_icons.png) no-repeat -240px bottom;}
.info_icon{
	height:37px;
	width:37px;
	background:url(images/icon_c_info.png) <?=$clr1?> no-repeat center center;
	margin:5px;
	border-radius:20px;	
}
.info_icon:hover{
	cursor:pointer;
	background-color:<?=$clr11?>;
}
.info_data{
	margin:40px;
}
.tab15{
	height:100%;
}
.vis_bettween{
	margin-left:40px;
	margin-right:40px;
	height:80px;
}
.vis_bettween_in{
	margin-left:auto;
	margin-right:auto;
	width:280px;
	height:80px;	
	position:relative;
}
.vis_bettween_in div {}
.vis_b_l{height:80px;background:url(images/his_arrow.png) <?=$clr1?> no-repeat <?=$align?> center; width:40px;}
.vis_b_r{height:80px;background:url(images/his_arrow.png) <?=$clr1?> no-repeat <?=$Xalign?> center; width:40px;}
.vis_b_c{
	margin-top:20px;
	border-radius:5px;
	line-height:40px;
	background-color:<?=$clr1?>;
	color:#fff;
	width:200px;
	height:40px;
	text-align:center;
	font-family:'f1',tahoma;
	font-size:16px;
}
.vis_b_c span{font-family:'ff',tahoma; font-size:18px;	}
.sel_AnaHov:hover{
	color:<?=$clr5?>;
	cursor:pointer;
	background:url(images/del.png) no-repeat <?=$align?> center;
}
.loader{background:url(images/load.gif) no-repeat <?=$align?> center; text-indent:20px;}
.xp_box{
	width:120px;
	height:140px;
	border:1px #ccc solid;
	margin-<?=$Xalign?>:10px;
	border-radius:2px;
}
.xp_box:hover{ background-color:<?=$clr111?>; cursor:pointer;}
.xp_box_p{
	width:110px;
	height:110px;
	margin:5px;
}
.xp_box_n{
	text-align:center;
	font-size:14px;
	font-weight:bold;
}
.xp_box_n2{
	text-align:center;
	font-size:14px;
	font-weight:bold;
	background-color:<?=$clr3?>;
	color:#fff;
	margin-bottom:10px;
	line-height:30px;
	border-radius:2px;
}
.xph_types{
	width:100%;
	overflow-x:hidden;
}
.xp_type_col{
	width:120px;
	border-<?=$Xalign?>:1px #ccc dotted;
	margin-<?=$Xalign?>:10px;
	padding-<?=$Xalign?>:10px;
	height:100%;
}
.assi_ls{
	height:auto;
	margin-bottom:5px;
	border-radius:2px;
	border-bottom:1px #999 solid;	
	margin-<?=$Xalign?>:3px;
	position:relative;
	background-color:#eee;
}
.assi_ls:hover{background-color:#ddd;cursor:pointer;}
.assi_ls_t1{
	font-size:18px;
	font-family:'f1';
	margin-left:10px;
	margin-right:10px;
	padding-top:10px;
}
.assi_ls_t2{
	font-size:14px;
	margin-left:10px;
	margin-right:10px;
}
.assi_ls_t3{
	font-size:18px;
	margin-left:10px;
	margin-right:10px;
	margin-bottom:5px;
}
.sel_mdc{
	padding:10px;
	border-bottom:1px #eee dashed;
	border-radius:2px;
}
.sel_mdc:hover{ background-color:#f5f5f5;}
.sel_mdc:hover .blc_win_title_icons{
	display:block;
}
.MDways{
	margin-top:10px;
}
.MDways > div{
	width:33%;
	border-<?=$Xalign?>:1px #ccc solid;
	height:100%;
}
.MDways > div:last-child{
	border:0px;
}
.MDways_in{
	margin:0px 10px 0px 10px;
	height:100%;
	overflow-x:hidden;
	margin-top:10px;
}
.t45{
	margin-left:10px;
	margin-right:10px;
}
.MDways_in div{
	line-height:40px;
	margin-bottom:5px;
	border-radius:2px;
	margin-<?=$Xalign?>:3px;
	font-family:'f1',tahoma;
	font-size:14px;
	text-align:center;	
}
.MDways_in .nor_box{background-color:#eee;border-bottom:2px #ccc solid;}
.MDways_in .nor_box:hover{background-color:#ddd; cursor:pointer;}
.MDways_in .act_box{background-color:<?=$clr1?>;border-bottom:2px <?=$clr1111?> solid;color:#fff;}
.tamplist div , .tamplist2{
	line-height:20px;
	margin-bottom:5px;
	border-radius:2px;
	margin-<?=$Xalign?>:3px;
	font-family:'f1',tahoma;
	font-size:14px;
	text-align:center;
	background-color:#eee;border-bottom:2px #ccc solid;	
	padding-top:10px;
	padding-bottom:10px;
}
.tamplist{ overflow-x:hidden; margin-top:10px;}
.tamplist div:hover , .tamplist2:hover{background-color:<?=$clr1?>;border-bottom:2px <?=$clr1111?> solid;color:#fff; cursor:pointer;}
.t_e{ clear:both; height:10px;}
.ann_note{
	margin-top:10px;
	color:#999;
	font-size:14px;
	font-family:'f1',tahoma;
}
.anName{
	font-size:14px;
	padding-<?=$Xalign?>:10px;
	width:200px;
}
.ann_val{
	font-size:22px;
	color:#000;
	font-weight:bold;
}
.addToList{
	border:0px;
	background-color:<?=$clr1?>
}
.toolrow{
	padding:12px;
	line-height:20px;
	font-family:'f1',tahoma;
	border:1px #ccc solid;
	margin:10px;
	border-radius:2px;
	font-size:16px;
	cursor:pointer;
	text-indent:25px;
}
.toolrow div{ margin-top:-11px;margin-<?=$Xalign?>:-11px}
.toolrow input{width:60px;}
.toolrow[s=x]{background:url(images/checked0.png) #eee no-repeat <?=$align?> center;}
.toolrow[s=x] input{ display:none;}
.toolrow[s=y]{background:url(images/checked1.png) <?=$clr111?> no-repeat <?=$align?> center;}
.toolList{overflow-x:hidden; width:100%;}
#opr_tools_d{margin:10px;}
#opr_tools_d div{
	font-size:16px;
	line-height:22px;
}
#opr_tools_d div[nb]{
	margin-<?=$align?>:10px;
	font-size:20px;
}
.oprToolEdit{
	line-height:20px;
	background-color:<?=$clr1?>;
	color:#fff;
	padding:10px;
	border-radius:2px;
	text-align:center;
	font-size:16px;	
}
.oprToolEdit:hover{background:<?=$clr11?>; cursor:pointer;}
.win_inside_con{
	height:100%;
	width:100%;
	overflow:hidden;	
}
.win_m3_1{
	margin:0px;
	width:230px;
	border-<?=$Xalign?>:1px #e5e7ea solid;
	height:100%;
	padding-<?=$Xalign?>:10px;
}
.ana_ls , .opr_ls , .addToList{
	height:40px;
	margin-bottom:5px;
	border-radius:2px;
	border-bottom:1px #999 solid;	
	margin-<?=$Xalign?>:3px;
	background-color:#eee;
	box-sizing: border-box;
}
.ana_ls:hover ,  .opr_ls:hover{ background-color:#ccc; cursor:pointer;}

.ana_ls2{
	margin-bottom:5px;
	border-radius:2px;
	border-bottom:1px #999 solid;	
	margin-<?=$Xalign?>:3px;
	background-color:#eee;
}
.ana_ls2:hover , .xph_ls:hover, .opr_ls:hover{ background-color:#ccc; cursor:pointer;}


.actCat .w_li_num{background:url(images/checked1.png) no-repeat center center;}
.norCat .w_li_num{background:url(images/checked0.png) no-repeat center center;}
.w_li_num , .w_li_date{
	line-height:40px;
	font-family:'ff',tahoma;
	text-align:center;
	font-size:14px;
	overflow:hidden;
}
.blc_win_list .w_li_num{
	width:40px; 
	height:30px;
	margin-top:5px;
	line-height:30px;
	font-weight:bold;
	border-<?=$Xalign?>:1px #ccc solid;
}
.opr_ls .w_li_date{font-family:'f1',tahoma;}
.blc_win_list .w_li_date{padding-<?=$align?>:10px;}
.blc_win_list  .addToList {background-color:<?=$clr1?>;}
.blc_win_list  .addToList:hover{background-color:<?=$clr11?>;}
.blc_win_content{
	height:100%;
	margin-<?=$align?>:10px;	
}
.blc_win_content_in{
	height:100px;
	margin-top:10px;
	overflow-x:hidden;
}
.winOprNote{
	margin:10px;
	color:<?=$clr1111?>;
	font-size:18px;
}
.winOprNote_err{
	margin:10px;
	color:<?=$clr5?>;
	font-size:18px;
}
.addToList{
	width:40px;
	height:40px;
	background:url(images/pcat_add.png) <?=$clr1?> no-repeat center center;	
	border-radius:2px;
	margin-<?=$Xalign?>:10px;
}
.addToList:hover{cursor:pointer; background-color:<?=$clr11?>}
.blc_win_title_icons div{
	width:40px;
	height:40px;
	margin-<?=$align?>:5px;
	border-radius:2px;
}
.topNav{
	background-color:<?=$clr5?>;
	position:absolute;
	display:none;
	width:18px;
	height:18px;
	line-height:18px;
	text-align:center;	
	border-radius:10px;
	color:#fff;
	font-size:12px;
	margin-top:5px;
	margin-<?=$align?>:5px;
}
.note_contt{margin:10px;}
.note_contt textarea{max-width:none; height:50px;}
.dbOver{max-width:100px;}
.dbOver:hover{ cursor:pointer; background-color:#eee;}
.repDel{ width:40px; height:40px; background:url(images/sys/icon_c_del.png) <?=$clr5?> no-repeat center center; border-radius:10px;}
.repDel:hover{background-color:<?=$clr55?>; cursor:pointer;}
.serBlc{width:220px; height:70px; background-color:<?=$clr1?>;}
.serBlc input{margin:5px; width:210px; height:26px; line-height:26px;}
.dashBloc{
	border:1px <?=$clr1?> solid;
	border-bottom:5px <?=$clr1?> solid;
	margin:5px;padding:10px;
	margin-bottom:10px;
	max-width:500px;
	border-radius:0px;	
}
.dB2{
	max-width:120px;
}
.dashBloc:hover{
	background-color:<?=$clr44?>;
	cursor:pointer;
}
.dashBloc div[n]{
	text-align:center;
	font-size:32px;
	font-family:'ff';
	line-height:35px;
	height:35px;
	font-weight:bold;
}
.dashBloc div[nn]{
	text-align:center;
	font-size:18px;
	font-family:'ff';
	line-height:35px;
	height:35px;
	font-weight:bold;
	color:<?=$clr6?>;
}
.dashBloc div[t]{
	text-align:center;
	font-size:14px;
	font-family:'f1';
	border-top:1px #ccc solid;
	padding-top:10px;
}
.dashBloc div[tt]{
	text-align:center;
	font-size:14px;
	font-family:'f1';
	border-top:1px #ccc solid;
	padding-top:10px;
	height:40px;
}
.dashBloc div[d]{
	text-align:center;	
	border-top:1px #ccc solid;
	padding-top:5px;
	padding-bottom:5px;
	width:100%;
}
.dashBloc div[d] div{
	display: inline-block;
	width:45%;
	line-height:20px;
	height:20px;
	font-family:'ff';
	font-size:16px;
	font-weight:bold;
}
.dashBloc div[d] div[i]{color:<?=$clr6?>; border-<?=$Xalign?>:1px #ccc solid;}
.dashBloc div[d] div[o]{color:<?=$clr5?>;}
.dashBloc div[d] div[p]{color:#000;}
.dashDet{}
.dashDet > div{box-sizing: border-box; border-<?=$Xalign?>:1px #ccc solid; padding-left: 5px; padding-right: 5px; width:16.5%}
.dashDet > div > div{line-height: 20px;}
.dashDet > div:last-child{box-sizing: border-box; border-<?=$Xalign?>:0px #ccc solid;}
.ass_no{margin:10px 40px -20px 40px;}
#report{
	font-size:16px;
	font-family:Tahoma, Geneva, sans-serif;
	line-height:24px;
	max-width:100%;
	margin-top:10px;
	min-height:100px;
	padding:10px;
	text-indent:0px;
	font-family:'f1',tahoma;
}
.print_div{
	height:60px;
	margin-top:-40px;
}
.win_buttx{
	margin-left:40px;
	margin-right:40px;
	margin-top:-20px;
}
.xxph{
	margin-top:10px;
}
.xph_blc{
	width:100px;
	height:40px;
	line-height:40px;
	background-color:<?=$clr4?>;
	text-align:center;
	margin:3px;
	border-radius:5px;
}
.xph_blc:hover{background-color:<?=$clr11?>;cursor:pointer;color:#fff;}
.xph_blcAct{
	width:100px;
	height:40px;
	line-height:40px;
	text-align:center;
	margin:3px;
	border-radius:5px;
	background-color:<?=$clr1?>;
	cursor:pointer;
	color:#fff;
}
.butt_list{
	text-align:center;
	min-height:12px;
	background-color:#e7e9eb;
	margin-left:auto;
	margin-right:auto;
	margin-bottom:5px;	
	padding:15px;
	color:#676771;
}
.butt_list:hover{
	cursor:pointer;
	background-color:<?=$clr1?>;
	color:#fff;
}
.mad_way{
	font-size:12px;
	margin-top:3px;
	color:#333;
}
.b_tabs{ margin-top:10px; height:160px;position:relative}
.b_tabs_in{ margin-top:10px;}
.b_tabs > div:hover{background-color:<?=$clr44?>;}
.b_tabs > div{
	float:<?=$align?>;
	width:33%;
	height:160px;
	border-<?=$Xalign?>:1px solid #e5e7ea;
	color:<?=$clr3?>;
	text-align:center;
	cursor:pointer;
	font-size:14px;
}
.b_tabs > div:last-child{
	border-<?=$Xalign?>:0px solid #e5e7ea;
}
.b_tabs > div > div{
	width:100px;
	height:110px;
	margin-top:20px;
	margin-left:auto;
	margin-right:auto;
	background-repeat:no-repeat;
	background-image:url(images/assi_icons.png);
}
.btab1{background-position:-100px center;}
.btab2{background-position:-300px center;}
.btab3{background-position:-500px center;}
.actbt{
	border-bottom:0px;
}
.cli_icon2{	
	width:80%;	
	margin:5px auto;
}
.cli_blc[type=n]{
	width:100%;
	max-width: 150px;
	margin:2px;	
	border:1px <?=$clr1?> solid;
	border-bottom:2px #666 solid;
	white-space:nowrap;	
	position:relative;
}
.cli_blc[type=n]:hover{background-color:#eee; cursor:pointer;}
.disTable td{
	background-color:#eee;
	height:30px;
	line-height:30px;
	text-align:center;
	font-size:18px;
	font-family:'ff';
	font-weight:bold;
	border-radius:2px;	
}
.disTable td:hover{background-color:#ccc;cursor:pointer;}
.disTable td[act]{
	background-color:<?=$clr1?>;
	color:#fff;
}
.clicINfIco{width: 38px; height: 37px; background:url(images/prv_icon.png) <?=$clr1?> no-repeat center center; position:static;z-index: 50}
.clicINfIco:hover{background: <?$clr1111?>; cursor: pointer;}
.docPhoto{
	height:60px;
	width:60px;
	margin:auto 5px;
	background-repeat:no-repeat;
	background-position:center center;
}


.vis_pat_list{
	box-sizing: border-box;
	width:200px;
	border-<?=$Xalign?>:1px #ccc solid;	
	margin-<?=$Xalign?>: 5px;
	padding-<?=$Xalign?>: 15px;
}
.vis_pat_list_r{	
	padding-<?=$Xalign?>: 5px;
}
.plistV > div{
	box-sizing: border-box;
	border: 1px #ccc solid;
	border-<?=$align?>: 5px #ccc solid;
	margin: 5px;
	padding: 5px;
	cursor: pointer;
	height: 50px;
	border-radius: 1px;	
}
.plistV div[n]{text-align:<?=$Xalign?>;}
.plistV > div:hover{
	background-color: <?=$clr44?>;
	border: 1px <?=$clr1?> solid;
	border-<?=$align?>: 5px <?=$clr1?> solid;
}
.plistV div[np]{
	border: 1px <?=$clr1?> solid;
	border-<?=$align?>: 5px <?=$clr1?> solid;
	color: #fff;
	background-color: <?=$clr1?>;
}
.plistV div[np]:hover{background-color: <?=$clr1111?>;}
.nqn{
	border:2px #ccc solid;
	min-height:40px;
	margin-bottom:10px;
	padding:5px;
	overflow-x:hidden;
}
.nqn div{
	padding:3px;
	line-height:30px;
	color:#fff;
	margin:2px;
	border-radius:3px;
	text-align:center;
	min-width:20px;
}
.nqn div[v]{background-color:<?=$clr2?>;}
.nqn div[n]{background-color:<?=$clr1?>;}
.nqn div[o]{background-color:<?=$clr5?>;}
.q_tool > div{
	min-width:40px;
	height:40px;
	line-height:40px;	
	text-align:center;
	color:#fff;
	margin:3px;
	font-family:'ff';
	font-size:20px;
	border-radius:6px;
	cursor:pointer;
}
.q_tool > div[c]{background-color:<?=$clr6?>;}
.q_tool > div[c]:hover{background-color:<?=$clr5?>;}
.q_tool > div[n] > div{height:35px;padding-left:5px; padding-right:5px;}
.q_tool > div[n] > div[nn]{	
	width:30px;
	height:40px;		
	background-image:url(images/icon_c_move.png);
	background-repeat:no-repeat;
	background-position:center center;
	cursor:pointer;
}
#qnoO{margin-top:6px;width:60px; height:26px;}
.q_tool > div[o]{background-color:<?=$clr5?>;}.q_tool div[o]:hover{background-color:<?=$clr55?>;}
.q_tool > div[v]{background-color:<?=$clr1?>;}.q_tool div[v]:hover,.q_tool div[n]:hover{background-color:<?=$clr1111?>;}
.q_tool > div[n]{background-color:<?=$clr1?>;}
.q_list3 > div{
	background-color:<?=$clr1?>;
	line-height:18px;
	margin:3px;
	color:#fff;
}
.q_list3 > div[t]{background-color:<?=$clr1111?>;}
.q_list3 > div:hover{
	background-color:<?=$clr1111?>;
	cursor:pointer;
}
.q_list3 > div > div{	
	line-height:30px; 
	height:30px; 
} 
.q_list3 > div > div[n]{
	background-color:<?=$clr2?>; 
	line-height:30px; 
	height:30px; 
	width:40px;
	text-align:center;
	font-family:'ff';
} 
.q_list3 > div > div[i]{
	background:url(images/rd_1.png) <?=$clr2?> no-repeat center center;height:30px; width:30px;
}
.q_list3 > div > div[s2]{
	background:url(images/rd_2.png) <?=$clr2?> no-repeat center center;height:30px; width:30px;
} 
.q_list3 > div > div[s3]{
	background:url(images/rd_3.png) <?=$clr2?> no-repeat center center;height:30px; width:30px;
} 
.q_list3 > div > div[t]{
	line-height:30px; 
	height:30px;
	padding-left:5px;
	padding-right:5px;	
} 
.alert_x{width: 25px; height: 25px; background:url(images/sys/cancel.png) no-repeat center center;}
/****************************NewDesign****************/
.cp_s1{
	background-color: #2d2d2d;
	border-<?=$Xalign?>:0px solid #e84c3d;	
}
#timeSec{
	min-height: 80px;
	width: 280px;
	padding: 10px;
	background-color: #444;
	color:#eee;
	border-top: 1px #666 solid;
}
.cp_s1_b1 div{
	font-size: 16px;
}
.cp_s1_b2{
	line-height: 74px;
	border-<?=$Xalign?>:1px solid #e77e23;
	/*background: url(images/cln_prv_prc.png) #d55401 no-repeat <?=$align?> center;*/
	background-color: #d55401;
	color: #fff;
	text-indent: 10px;
	width: 100%;
	height: 74px;
	font-size: 16px;	
	border-bottom: 4px solid #e77e23;	
}
.cp_s1_b2 div[r]{
	float: <?=$Xalign?>;
	width: 40px;
	height: 74px;
	background: url(images/sys/date_arows.png) no-repeat <?=$Xalign?> center;
}
.cp_s1_b2 [tit1]{
	width:235px;
	line-height: 25px;
	font-family: 'f1';	
	overflow: hidden;
	margin-top: 12px;
}
.cp_s1_b2 [tit2]{
	width:235px;
	line-height: 25px;
	
	overflow: hidden;
}
.cp_s1_b2:hover{
	background-color:#f06c01;
	cursor: pointer;
}
.cp_s1_b3{
	line-height: 50px;	
	background: url(images/cln_prv_prc.png) #1bbc9d no-repeat <?=$align?> center;
	color: #fff;
	text-indent: 50px;	
	border-<?=$align?>:6px #16a086 solid;
	
}
.cp_s1_b3:hover{	
	background-color: #16a086;
	cursor:pointer;
}
.cp_s1_b3_icon{	
	width:50px;
	height:50px;
	background: url(images/i40_set.png) #16a086 no-repeat center center;	
}
.cp_s2{
	background-color: #eee;
}
.cp_s3{
	background-color: #fff;
}
.cp_s{
	background-color: #1e1f23;
}
.addons > div{
	height:50px;
	line-height: 50px;
	font-family: 'f1';	
	background-color: #444;
	color:#eee;
	border:0px solid #000;
	border-<?=$align?>-width: 6px;
	text-indent: 50px;
	margin-top: 0px;
	border-bottom:1px #555 solid;
	background-repeat: no-repeat;
	background-position: <?=$align?> center;
}
.addons > div:hover{
	background-color: #666;cursor: pointer;
}
.addons > div[act='1']{
	background-color:#000;
}
.prvLoader{
	position: absolute;
	z-index: 1;
	margin-<?=$align?>:280px;	
	background: url(images/loader3.gif) #ffed43 no-repeat center 40px;
	width: 320px;
	height: 70px;
	color:#3a3a3a;
	font-size: 16px;
	line-height: 50px;
	text-align: center;
	font-family: 'f1';
	border-bottom: 4px solid #ffc805;
	display: none;
}
.cp_tit_srv{
	background-color: #f06c01;
	width: 100%;
	height: 70px;
	color:#e5e5e5;
	font-size: 16px;	
	border-bottom: 4px solid #f58e3a;
}
.cp_headIcon{
	height: 45px;
	width: 50px;
	background: url(images/cln_prv_srv.png) no-repeat center -2px;
}
.cp_tit_srv_1{
	line-height: 45px;
	height: 45px;
	color: #fff;
}
.cp_srvList > div{
	float: <?=$align?>;
	background-color:#fff;
	width: 100%;
	padding-top:10px;
	margin-bottom: 10px;
	border-radius: 1px;
	border-bottom:4px #ccc solid;
}
.cp_srvList > div:hover{border-bottom:4px #aaa solid;}
.cp_srvList div[tit]{	
	margin-bottom:5x;
	padding-bottom: 5px;
	line-height: 18px;
	border-bottom:0px #eee solid;
	overflow: hidden;
	line-height: 20px;
}
.mp_list_tit{	
	width: 100%;
	height: 70px;
	color:#e5e5e5;
	font-size: 16px;	
	border-bottom: 4px solid #333;
}
.mp_list_tit_txt{
	font-family: 'f1';
	line-height: 40px;
	font-size:16px;
	text-indent: 50px;
	color: #fff;
	background-repeat: no-repeat;
	background-position: <?=$align?> center;
	text-shadow: 0px 0px 3px #000;
}
.mp_list_tit input{
	background: url(images/sys/ser_icon.png) no-repeat <?=$Xalign?> center;
	background-color: rgba(0,0,0,0.2);
	border: 0px;
	outline: none;
	padding: 0px 10px;
	height: 30px;
	width: 320px;
	color: #fff;
}
.mp_list_tit input::placeholder{color:#ccc;}
.p_blcList > div{
	float: <?=$align?>;
	background-color:#fff;
	width: 100%;
	padding-top:10px;
	margin-bottom: 10px;
	border-radius: 1px;
	border-bottom:4px #ccc solid;
}
.p_blcList > div:hover{border-bottom:4px #aaa solid;}
.p_blcList div[tit]{	
	margin-bottom:5x;
	padding-bottom: 5px;
	line-height: 18px;
	border-bottom:0px #eee solid;
	overflow: hidden;
	line-height: 20px;
}
.patsIco{
	width:40px;
	height:40px;
	background:url(images/prv_icon1.png) no-repeat center center;
}
[prvSw]:hover{cursor: pointer; background-color: <?=$clr1111?>}
/***************/


.prvTop_dts{background-position:0px 0px;}
.prvTop_doc{background-position:-50px 0px;}
.prvTop_rec{background-position:-100px 0px;}
.prvTop_pre{background-position:-150px 0px;}
.prvTop_ana{background-position:-200px 0px;}
.prvTop_xry{background-position:-250px 0px;}
.prvTop_opr{background-position:-300px 0px;}
.prvTop_rep{background-position:-350px 0px;}
.prvTop_ass{background-position:-400px 0px;}
</style>