<? session_start();/***SYS***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.cbg1{background-color:<?=$clr1?>;}.cbg11{background-color:<?=$clr11?>;}
.cbg111{background-color:<?=$clr111?>;}.cbg1111{background-color:<?=$clr1111?>;}
.cbg2{background-color:<?=$clr2?>;}.cbg3{background-color:<?=$clr3?>;}
.cbg4{background-color:<?=$clr4?>;}.cbg44{background-color:<?=$clr44?>;}.cbg444{background-color:<?=$clr444?>;}
.cbg5{background-color:<?=$clr5?>;}.cbg55{background-color:<?=$clr55?>;}.cbg555{background-color:<?=$clr555?>;}
.cbg6{background-color:<?=$clr6?>;}.cbg66{background-color:<?=$clr66?>;}.cbg666{background-color:<?=$clr666?>;}
.cbg7{background-color:<?=$clr7?>;}.cbg77{background-color:<?=$clr77?>;}.cbg777{background-color:<?=$clr777?>;}
.cbg8{background-color:<?=$clr8?>;}.cbg88{background-color:<?=$clr88?>;}.cbg888{background-color:<?=$clr888?>;}
.cbg9{background-color:<?=$clr9?>;}
.cbgb{background-color:#000;}
.cbgw{background-color:#fff;}
.clr1{color:<?=$clr1?>;}.clr11{color:<?=$clr11?>;}
.clr111{color:<?=$clr111?>;}.clr1111{color:<?=$clr1111?>;}
.clr2{color:<?=$clr2?>;}.clr3{color:<?=$clr3?>;}
.clr4{color:<?=$clr4?>;}.clr44{color:<?=$clr44?>;}.clr444{color:<?=$clr444?>;}
.clr5{color:<?=$clr5?>;}.clr55{color:<?=$clr55?>;}.clr555{color:<?=$clr555?>;}
.clr6{color:<?=$clr6?>;}.clr66{color:<?=$clr66?>;}.clr666{color:<?=$clr666?>;}
.clr7{color:<?=$clr7?>;}.clr77{color:<?=$clr77?>;}.clr777{color:<?=$clr777?>;}
.clr8{color:<?=$clr8?>;}.clr88{color:<?=$clr88?>;}.clr888{color:<?=$clr888?>;}
.clr9{color:<?=$clr9?>;}
.sh{text-shadow:0px 0px 1px #999;}
.clrw{color:#fff;}
.clrb{color:#000;}
.fl{float:<?=$align?>;}
.fr{float:<?=$Xalign?>;}
@font-face{font-family:'f1';src:url('library/fonts/TheSans-Bold-alinma.ttf') format('woff');}
@font-face{font-family:'f2';src:url('library/fonts/The-Sans-Plain-alinma.ttf') format('woff');}
@font-face{font-family:'ff';src:url('library/fonts/MyriadSetPro-Thin.woff') format('woff');}
@font-face{font-family:'fff';src:url('library/fonts/a/GE SS Two Medium.woff') format('woff');}
<? if($dir=='ltr'){$fontSize=4;}else{$fontSize=0;}?>
start{}
.fs10{font-size:<?=(10+$fontSize)?>px;}.fs12{font-size:<?=(12+$fontSize)?>px;}.fs14{font-size:<?=(14+$fontSize)?>px;}.fs16{font-size:<?=(16+$fontSize)?>px;}.fs18{font-size:<?=(18+$fontSize)?>px;}.fs20{font-size:<?=(20+$fontSize)?>px;}.fs22{font-size:<?=(22+$fontSize)?>px;}.fs24{font-size:<?=(24+$fontSize)?>px;}
@font-face{font-family:'f1s';src:url('library/fonts/a/GE SS Two Medium.woff') format('woff');}
.fs12x{font-size:12px;}.fs14x{font-size:14px;}.fs16x{font-size:16px;}.font18x{font-size:18}.fs20x{font-size:20px;}.fs22x{font-size:22px;}.fs24x{font-size:24px;}
.w100{width:100%;max-width:100%;}.h100{height:100%;max-height:100%;}
.of{overflow:hidden;}
.ofx{overflow-x:hidden;}
.ofy{overflow-y:hidden;}
.cb{clear:both;}
.B{font-weight:bold;}
.U{text-decoration:underline;}
.I{font-style:italic;}
.TC{text-align:center;}
.TL{text-align:<?=$align?>;}
.TR{text-align:<?=$Xalign?>;}
.TJ{text-align:justify;}
.ws{white-space:nowrap;}
.fll{float:left;}
.frr{float:right;}
.pd10{padding-left:10px;padding-right:10px;}
.pd5{padding-left:10px;padding-right:5px;}
.l_bord{box-sizing: border-box;border-<?=$align?>:1px #ccc solid;}
.r_bord{box-sizing: border-box;border-<?=$Xalign?>:1px #ccc solid;}
.t_bord{box-sizing: border-box;border-top:1px #ccc solid;}
.b_bord{box-sizing: border-box;border-bottom:1px #ccc solid;}
.bord{box-sizing: border-box;border:1px #ccc solid;}
header, section, footer, aside, article, figure {display: block;}
body , td , div ,span ,a ,section {font-family:Tahoma, Geneva;}
.f1{font-family:'f1',Tahoma;}
.f1s{font-family:'f1s',Tahoma;}
.f2{font-family:'f2',Tahoma;}
.f3{font-family:'f3',Tahoma;}
.ff{font-family:'ff',Tahoma;}
.fff{font-family:'f1',Tahoma;}
ff{ font-family:'ff'; font-weight:bold; font-size:18px;}
ff14{ font-family:'ff'; font-weight:bold; font-size:14px;}
.lh60{line-height:60px;}.lh50{line-height:50px;}.lh40{line-height:40px;}.lh30{line-height:30px;}.lh20{line-height:20px;}.lh1{line-height:1px;}
body{
	margin:0px;
	font-family:Tahoma, Geneva;
	font-size:12px;
	margin:0px;
}
.c_cont{width: fit-content;margin: 0 auto; display:table;}
img{ border:0px;}
th{font-weight:normal;}
form{ margin:0px; padding:0px;}
a:link , a:visited , a:visited {text-decoration:none;color:#000;}
a:hover{color:#000;}
.stcker{box-sizing:border-box;
}
.baarcode3 img{height:0.8cm; width:auto;}
.baarcode3 div{font-size:9px;}
.p1_title{
	border-bottom:1px solid #999;
	height:1.3cm;
	line-height:1.2cm;
}
.p1_title img{ height:1.1cm;}
.pa_card {
	border:0px solid #eee;
	width:5.4cm;
	height:2.4cm;
	padding:0.3cm;
	padding-top:0cm;
}
.pa_card div[b]{
	border:1px solid #eee;
	width:10cm;
	height:7.5cm;
}
.baarcode22{
	height: 34px;
	margin-top: 4px;}
.baarcode22 img{	
	height:1.3cm;
}
.baarcode img{
	height:1cm;
	width: 4.4cm;
}
.pa_receipt{
	border:1px #ccc solid;
	width:7cm;
	min-height:9cm;
	padding:0.5cm;
}
.reccp_no{
	font-size:70px;
	line-height: 50px;
	text-align:center;
	margin-left:auto;
	margin-right:auto;
	padding:10px;
	margin:10px;
}
.cutLine{
	border-top:2px #000 dashed;
	margin-top: 0.3cm;
	padding-top: 0.3cm;
}
.reccp_no2{
	font-size:40px;
	text-align:center;
	margin-left:auto;
	margin-right:auto;
	padding:10px;
	margin:10px;
	width: auto;
}
.recp_note{ border-top:1px #ccc solid; margin-top:0.3cm; padding-top:0.3cm}
.print_page{
	width:11.4cm;
	height:21cm;
	margin:0px auto;
}
.print_page5{
	width:14.85cm;
	height:21cm;
	margin:0px auto;
    padding: 0.5cm 1cm;
    box-sizing: border-box;
    position: relative;
}
.print_page5_footer{
    bottom: 0px;
    position: absolute;
    width:13.7cm;    
    box-sizing:border-box;
    margin:0.5cm auto;
    padding: 10px;
    background-color: #fff;
    border-top:1px #eee solid;
}
.print_pageW5{
	width:20.5cm;
	height:14cm;
	margin:0px auto;
	border:0px #f8f8f8 solid;
}
.print_page6{
	width:10cm;
	height:15cm;
	margin:0px auto;
	border:1px #f8f8f8 solid;
}
.print_pageIn{	
	margin:0px 1.5cm;
}
.p_header{height:3.7cm; margin-top:-0.3cm}
.p_body{
	height:11.3cm; 
	margin-top:0.1cm;
}

.info11{
	height:1.4cm;
}
.v_num{
	height:1.4cm;
	line-height:1.4cm;
	width:1.4cm;
	border:1px solid #e9ebed;
	text-align:center;
	font-size:18px;
	color:<?=$clr1?>;
	margin-<?=$Xalign?>:0.1cm;
}
.pat_name{
	height:1.4cm;
	width:5.2cm;
	border:1px solid #e9ebed;
}
.i12{
	margin:0cm 0.3cm;
	margin-top:0.25cm;
	color:#a1aab7;
	font-size:12px;
}
.i13{
	color:#2f3d44;
	font-size:14px;
	margin-left:0.3cm;
	margin-right:0.3cm;
	margin-top:0.1cm;
}
.baarcode2 img{
	height:1.45cm;	
}
.baarcode3 img{
	height:0.7cm;
	width:3.4cm;
}
.p_footer{
	height:3.78cm;
	border:2px solid #e7e9eb;
	text-align:center;
}
.p_footer6{
	margin-top:2cm;
	height:6cm;
	border-bottom:2px solid #e7e9eb;
	text-align:center;
}
.p_footer2{
	position:absolute;
	top:18cm;
	left:0px;
	text-align:center;
	width:100%;
}
.fo1{font-size:24px;color:<?=$clr1?>;	margin-top:0.3cm}
.fo2{font-size:12px; color:#a1aab7; margin-bottom:0.3cm; margin-left:0.3cm; margin-right:0.3cm;}
.fo3{font-size:12px; color:#2f3d44;margin-bottom:0.1cm; margin-left:0.3cm; margin-right:0.3cm;}
.fo4{font-size:14px; color:#2f3d44; margin-left:0.3cm; margin-right:0.3cm;}
.fo-1{font-size:32px; color:<?=$clr1?>;}
.fo-2{font-size:18px; color:#a1aab7; text-align:center;}
.fo-3{ color:#2f3d44; margin-top:0.8cm;}
.fo-4{font-size:16px; color:#2f3d44; margin-left:0.3cm; margin-right:0.3cm;}
.p_footer66{margin-top:0.5cm;}
.p_type{
	color:#2f3d44;
	font-size:18px;
}
.p_date{
	font-size:13px;
	color:#2f3d44;
}
.sel_mdc_p{
	line-height:35px;
	font-size:13px;
	color:#aaa;
    border-bottom: 1px #999 solid;
    margin-bottom: 10px;
}
.sel_mdc_p div{
	padding-bottom: 2px;
	line-height:20px;
}
.sel_mdc_p span{
	font-size:15px;
	color:#000;
}
.print_Line{
	position:absolute;
	height:12cm; 
	width:11.4cm;
}
.print_Line div{
	height:34px;
	border-bottom:0px solid #f5f5f5;
}
.mdsWayP{
	font-size:12px;
	margin-top:-10px;
	margin-bottom:10px;
}
.pat_age{
	position:absolute;
	margin-<?=$align?>:180px;
	width:45px;
	height:45px;
	text-align:center;
	border-<?=$align?>:1px #ccc dotted;
	margin-top:3px;
}
.age{
	font-size:22px;
	margin-top:4px;
}
.age2{
	font-size:16px;
	margin-top:-4px;
}
.grad_s{border-collapse:collapse;}
/*.grad_s tr:nth-child(even){background-color: #eee;}*/
.grad_s th {
	height:20px;
	border:1px solid #999;
	font-size:12px;
	font-family:'f1',tahoma;
	background-color:#fff;
	color:#000;border-bottom: 3px #999 solid;
}
.grad_s tr[fot]{
	height:20px;
	border:1px solid #999;
	font-size:12px;
	font-family:'f1',tahoma;	
	color:#000;
	border-top: 3px #999 solid;
}
.grad_s td{
	height:25px;
	border:1px solid #999;
	text-align:center;
	
}
.grad_s td ff{font-size:16px; color:#000}
.grad_s td span{font-size:12px; color:#f00}
.grad_s  th > b{
	color:#e6e7e7;
	font-family:tahoma;
	font-size:10px;
	font-weight:normal;
}
/*.grad_s  td{
	height:40px;
	color:#676771;
	border-bottom:1px solid #ccc;
	border:1px solid #ccc;
	text-align:center;
}
.grad_s >  tr > td[txt]{
	font-size: 16px;
	font-family: 'f1';
}
.grad_s select , .grad_s option{
	font-size: 16px;
	font-family: 'f1';
}*/
.g_info > tr > td:first-child{
	text-align:<?=$Xalign?>;
	font-weight:bold;	
}
.g_info > tr > td:last-child{
	text-align:<?=$align?>;
	padding-left:10px;
	padding-right:10px;
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
.grad_s22{border-collapse:collapse;}
.grad_s22  th{
	height:35px;
	border:1px solid #999;
	font-family:'f1',tahoma;
	font-size:14px;
	font-weight:bold;
}
.grad_s22 > tr > th > b{
	color:#e6e7e7;
	font-family:tahoma;
	font-size:10px;
	font-weight:normal;
}
.grad_s22 > tbody > tr > td{
	height:32px;
	color:#000;
	border:1px #999 solid ;
	text-align:center;
}
/*********/
.grad_m{border-collapse:collapse;}
.grad_m  th{
	height:35px;
	border:1px solid #ccc;
	font-family:'f1',tahoma;
	font-size:12px;
	font-weight:bold;
}
.grad_m > tr > th > b{
	color:#e6e7e7;
	font-family:tahoma;
	font-size:10px;
	font-weight:normal;
}
.grad_m > tbody > tr > td{
	height:25px;
	color:#000;
	border:1px #ccc solid ;
	text-align:center;
}
/**********/
.tableCon{border:1px #999 solid; padding:2px; margin-top:0.5cm}
.printItems div{
	line-height:30px;
}
.h3pri{border-bottom:2px #ccc solid; height:80px;width:100%;margin-bottom:20px;}
.h3pri div{height:80px; line-height:60px;}
.h3pri img{height:60px;}
.footerpri{
	position:absolute;
	border-top:2px #ccc solid;
	height:80px;
	width:19cm;
	margin-top:20px;
	text-align:center;
	line-height:50px;
	font-size:14px;
	top:27cm;
}
.export_tab{border-collapse:collapse;}
.export_tab  th{
	height:35px;
	border:1px solid #999;
	font-family:'f1',tahoma;
	font-size:14px;
	font-weight:bold;
}
.export_tab > tr > th > b{
	color:#e6e7e7;
	font-family:tahoma;
	font-size:10px;
	font-weight:normal;
}
.export_tab > tbody > tr > td{
	height:32px;
	color:#000;
	border:1px #999 solid ;
	text-align:center;
}
.p5Header{height:2.3cm; margin:0.5cm; border-bottom:1px #ccc solid; margin-bottom:0.5cm;}
.p5Header2{height:3.5cm;padding-top:0.5cm; border-bottom:1px #ccc solid;}
.h_logo{text-align:<?=$Xalign?>;}
.h_logo img{ height:2.2cm;}
/*.h_logo2 img{ height:3cm;}*/
.h_logo_p4 img{width:100%;}
.h_logo_p4{ height:3cm; overflow: hidden;}
.page_inn{ margin:0.5cm;}
.infoTableee td{ font-size:12px;}
.infoTableee{border-collapse:collapse;}
.infoTableee td{
	height:20px;
	border:1px solid #ccc;
}
.print_page4{
	width:21cm;
	float:<?=$align?>;	
}
.print_page4W{
	width:29cm;
	float:<?=$align?>;	
}
.grad_li{border-collapse:collapse;}
.grad_li th{
	height:20px;
	border:1px solid #999;
	font-size:14px;
	font-weight:bold;
	font-family:'f1',tahoma;
}
.grad_li td{
	height:25px;
	border:1px solid #999;
	text-align:center;
	font-size:12px;
}
.page-break{page-break-before: always; }
.grad_print{border-collapse:collapse;}
.grad_print tr:nth-child(even){background-color: #eee;}
.grad_print2 tr:nth-child(even){background-color: #fff;}
.grad_print th , .grad_print tr[fot]{
	height:20px;
	border:1px solid #999;
	font-size:12px;
	font-family:'f1',tahoma;
	background-color:#fff;
	color:#000;border-bottom: 3px #999 solid;
}
.grad_print td{
	height:25px;
	border:1px solid #999;
	text-align:center;
}
.grad_print td ff{font-size:14px;}
.grad_print td span{font-size:12px; color:#f00}
.grad_print2 td[b]{border-top:2px #333 solid;}
.print_total td{background-color:#666; color:#fff;}
.printRep p , .printRep li{line-height:30px;font-size:14px;}
.printRep strong{line-height:30px;font-size:14px;}
.dashBloc{
	border:1px <?=$clr1?> solid;
	border-bottom:5px <?=$clr1?> solid;
	margin:5px;padding:10px;
	margin-bottom:10px;	
	border-radius:0px;
	width:45%;
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
.dashDet > div{box-sizing: border-box; border-<?=$Xalign?>:1px #ccc solid; padding-left: 5px; padding-right: 5px; width:25%}
.dashDet > div > div{line-height: 20px;}
.dashDet > div:last-child{box-sizing: border-box; border-<?=$Xalign?>:0px #ccc solid;}

.dashBloc div[d] div[i]{color:<?=$clr6?>; border-<?=$Xalign?>:1px #ccc solid;}
.dashBloc div[d] div[o]{color:<?=$clr5?>;}
.dashBloc div[d] div[p]{color:#000;}
.uLine{border-bottom:1px #ddd solid; margin-bottom:10px; box-sizing: border-box; box-sizing: padding-box;}
.uLine2{border-bottom:1px #eee solid; margin-bottom:10px; box-sizing: border-box; box-sizing: padding-box;}
.tdb2{ border-bottom:2px #333 solid;}
.reprort_w{}
.reprort_w > div[r] , .reprort_s > div[r]{
	width:100%; 
	border-bottom:1px #ddd solid;
	margin-bottom:10px;
	padding-bottom:5px;
}
.reprort_s > div[r]{border-bottom:0px;}
.reprort_w div > div[b]{
	margin:5px;
	padding:10px;
	border-radius:5px;
	text-indent:5px;
	border:1px #ddd dashed;
}
.reprort_w div > div[b][n]{background-color:#f9f9f9;}
.reprort_w div > div[b][s]{background-color:#eeffee;}
.reprort_w div > div[t]{margin:5px;text-indent:5px;}
.reprort_w > div[r=r1] > div , .reprort_s > div[r=r1] > div{width:100%;}
.reprort_w > div[r=r2] > div , .reprort_s > div[r=r2] > div{width:50%;}
.reprort_w > div[r=r3] > div , .reprort_s > div[r=r3] > div{width:33.33%;}
.reprort_s div > div[b]{
	margin:5px;
	padding:10px;
	text-indent:5px;	
}
.reprort_s div[bb]{
	border:2px #eee solid;
	margin:5px;
	padding:10px;
	border-radius:5px;
	height:100%;
	position:relative;
	min-height:50px;
}
.reprort_s div[bt]{
	border-bottom:2px #eee solid;
	margin:5px;
	padding:10px;
	border-radius:5px;
	height:100%;
	position:relative;
	background-color:#f5f5f5;
}
.x_val{display:none;}
div no , td no{ font-family: 'ff';font-weight: bold;}
.anaTitle{
	line-height: 25px;
	height: 25px;
	background-color: #ccc;
	text-indent: 15px;
	border-radius:2px 2px 0px 0px;
	width: 100%;
}
.LCatBord{ border:2px #ccc solid; padding:5px; margin-bottom: 5px; border-radius:0px 0px 2px 2px;}
.LSerBord{ border:2px #ddd solid; padding:5px; margin-bottom: 5px; border-radius:0px 0px 2px 2px;}
.anaTitleSub{
	line-height:25px;
	height: 25px;
	background-color: #ddd;	
	border-radius:2px 2px 0px 0px;    
}
.anaTitleSub2{
	line-height: 25px;
	height: 25px;
	background-color: #eee;	
}
.reporPrnRow{	
	/*border-bottom: 1px #ccc solid;*/
	padding:2px;
	/*margin-bottom: 5px;*/
	line-height: 15px;
}
.rprName{width: 35%;font-size: 11px;}
.rprVal{width: 15%; background-color: #eee; text-align: center;font-size: 12px;}
.rprVal100{width: 100%; background-color: #ddd; text-align: center;}
.rprVall{width: 15%; text-align: center;background-color: #eee; }
.rprUnit{width: 14%;  font-size: 11px;}
.rprNor{width: 20%; font-size: 11px;}
.rprVal2{width: 5%; background-color: #eee; text-align: center}
.rprVal3{width: 25%; }
.rprVal4{width: 55%; }
.rprVal5{width: 60%; }
.rprVal1row{ width: 100%; height: 100%; background-color: #eee; padding:5px 2px 5px 3px;}
.labResTable{
	border:2px #ddd solid;
	width:100%;
	padding: 10px;
	border-radius: 5px;
	margin-bottom: 10px;
	text-align: <?=$align?>;	
}
.labResTable th{
	border-bottom:1px #ddd solid;		
	border-radius: 0px;
	text-align: <?=$align?>;
	font-weight: bold;
	font-family: 'f1';
	font-size: 14px;
	padding-left: 10px;
	padding-right: 10px;
}
.labResTable td{
	border-bottom:1px #ddd solid;		
	border-radius: 0px;
	padding-left: 10px;
	padding-right: 10px;
	font-size: 11px;
}
.LP4{
	width:20cm;
	padding-left: 0.5cm;
	padding-right: 0.5cm;
	float:<?=$align?>;	
}
.LPF4{
	width:20cm;
	padding-left: 0.5cm;
	padding-right: 0.5cm;
	float:<?=$align?>;	
}
.LP4Head{
	min-height:3.5cm;
	padding-top:0.5cm;
	/*border-bottom:1px #ccc solid;*/
	overflow: hidden;
}
.LPF4Head{	
	padding-top:0.5cm;	
	overflow: hidden;
}
.LPF4Fot{padding-bottom:0.5cm;}
.LP4Head2{
	height:1.13cm;
	/*border-bottom:1px #ccc solid;*/
	overflow: hidden;
}
.LP4Body{min-height:10cm; padding-top:0.5cm; border-bottom:1px #ccc solid;}
.LP4Fot{height:1cm;padding-bottom:0.5cm;}
.LP4{ page-break-inside:auto;}
.breakPage{ page-break-inside:avoid; page-break-after:auto; }
.p_emrg{
	background-color: #9E0F10;
	color: #fff;
}
.p_Hprice{background-color: #ccc;}
.dateTimePrint{
	line-height: 65px;
	font-size: 50px;
}
/************************************Pages*********************/
.pp4{
	width:21cm;
	float:<?=$align?>;
}
.pp4w{
	width:29cm;
	float:<?=$align?>;
	
}
.ppin{
	margin: 0.5cm;
}
.ppinHead{	
	padding-top:0.5cm;	
	overflow: hidden;
	/*background-color: #ccc;*/
	float:<?=$align?>;
	width: 100%;
}
.border2{
	border:2px #ccc solid;
	padding: 10px;
}
.table5 td{border-bottom:1px #ccc solid;}
.uc{text-transform: uppercase;}
/***********************************************************/
.fl_d{direction:ltr;}
.fll{float:left;}
.frr{float:right;}
.of{overflow:hidden;}
.pa{position:absolute;}
.ofx{overflow-x:hidden;}
.ofy{overflow-y:hidden;}
.ofxy{overflow:auto;overflow-x:visible;position:relative;}
.in{display:inline-block;}
.pr{position:relative;}

/***********************************************************/
.mgA{margin:0px auto;}
.pd20{padding-left:20px;padding-right:20px;}.pd10{padding-left:10px;padding-right:10px;}.pd5{padding-left:5px;padding-right:5px;}
.mg20{margin-left:20px; margin-right:20px;}.mg10{margin-left:10px; margin-right:10px;}.mg5{margin-left:5px; margin-right:5px;}
.pd20f{padding:20px;}.pd10f{padding:10px;}.pd5f{padding:5px;}
.mg20f{margin:20px;}.mg10f{margin:10px;}.mg5f{margin:5px;}
.pd20v{padding-top:20px;padding-bottom:20px;}.pd10v{padding-top:10px;padding-bottom:10px;}.pd5v{padding-top:5px;padding-bottom:5px;}    
.mg20v{margin-top:20px; margin-bottom:20px;}.mg10v{margin-top:10px; margin-bottom:10px;}.mg5v{margin-top:5px; margin-bottom:5px;}    
.mg20t{margin-top:20px;}.mg10t{margin-top:10px;}.mg5t{margin-top:5px;}    
.mg20b{margin-bottom:20px;}.mg10b{margin-bottom:10px;}.mg5b{margin-bottom:5px;}    
.pd20t{padding-top:20px;}.pd10t{padding-top:10px;}.pd5t{padding-top:5px;}
.pd20b{padding-bottom:20px;}.pd10b{padding-bottom:10px;}.pd5b{padding-bottom:5px;}
.mg20l{margin-<?=$align?>:20px;}.mg10l{margin-<?=$align?>:10px;}.mg5l{margin-<?=$align?>:5px;}    
.mg20r{margin-<?=$Xalign?>:20px;}.mg10r{margin-<?=$Xalign?>:10px;}.mg5r{margin-<?=$Xalign?>:5px;}    
.pd20l{padding-<?=$align?>:20px;}.pd10l{padding-<?=$align?>:10px;}.pd5l{padding-<?=$align?>:5px;}
.pd20r{padding-<?=$Xalign?>:20px;}.pd10r{padding-<?=$Xalign?>:10px;}.pd5r{padding-<?=$Xalign?>:5px;}
/***********************************************************/
    
.br0{border-radius:0px;}
.br2{border-radius:2px;}
.br5{border-radius:5px;}
.br10{border-radius:10px;}
.br50{border-radius:50%;}
.bord0{border:0px #000 solid;}
    
.prnit_med_page{
    height: 21.5cm;
    width:11cm;
    margin: 0 auto;    
    display: grid;
    grid-template-rows: auto auto 1fr auto;    
}
.pmp_head{    
    height: 3.5cm;    
    overflow: hidden;		
}
.pmp_info{
    padding: 0.3cm 0;
}
.pmp_data{
    
}
.pmp_footer{    
    padding: 0.3cm 0;
}
/******************/
.prnit_med_page5{
    height: 18.5cm;
    width:14.5cm;
    margin: 0 auto;    
    display: grid;
    grid-template-rows: auto auto 1fr auto;     
}
.prnit_med_page5 .pmp_head{    
    height: 3.5cm;    
    overflow: hidden;		
}
.prnit_med_page5 .pmp_info{
    padding: 0.3cm 0;
}
.prnit_med_page5 .pmp_data{
    
}
.prnit_med_page5 .pmp_footer{    
    padding: 0.3cm 0;
}
/******************/
.infoTable {
    width: 100%;    
}
.infoTable td{
    padding: 5px 0px 5px 0px;
}
.infoTable td:last-child{
    text-align: left
}
.rx_logo{
    width: 2cm;
    background:url("images/rx.png") center center no-repeat;
    background-size: 70% auto
}
.doctor_sign{
    width: 50%;    
    margin-<?=$align?>: auto;
    text-align: center;
    padding:0.3cm 0;
    
}
</style>