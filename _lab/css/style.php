<? session_start();/***LAB***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.ic40_y{background-image:url(images/y.png);}
.ic40_lab_sam{background-image:url(images/lab_sam.png);}
.ic40_lab_vis{background-image:url(images/lab_vis.png);}
.lvisR2  div[s] , .lvisR3  div[s]{
	padding:10px;
	border:1px #ccc solid;
	margin-bottom:10px;
	border-bottom:4px #ccc solid;
	border-radius:2px;	
}
.lvisR3 div[s]{margin-left:5px; margin-right:5px;}
.lvisR3 div[s]:hover{background-color:#eee; cursor:pointer;}
.lvisR2 div[s]:hover{background-color:#eee; cursor:pointer;}
.smpBg{
	width:100%;
	padding:5px 0px 5px 0px;
	text-align:center;
	border-bottom:1px #ccc solid;
}
.smpIcon2{
	width:40px;
	height:35px;
	background:url(images/lab_samp2.png) no-repeat right center;
	border-radius:30px;
	margin:0px 5px 0px 5px;
}
.smpIcon:hover2{ background-position:left center;}
.smpIcon3{
	width:50px;
	height:50px;
	background:url(images/lab_samp.png) no-repeat 0px center;
	border-radius:30px;
	margin:0px 5px 5px 5px;
	border:1px #eee solid;
}
.smpIcon:hover3{ background-position:left center;}
.rakIcon{
	width:70px;
	height:70px;
	background:url(images/rack.png);
	border-radius:4px;
}
.rakIcon:hover{background-color:#fee; cursor:pointer;}
#sContent{	
	border-<?=$Xalign?>:1px #ccc solid;
}
.rackCo{
	margin:0px 10px 10px 10px;
	padding:10px;
	border-radius:5px;
	direction:ltr;
}
.rackCo div[txt]{
	color:#fff;
	font-family:'ff';
	text-shadow:0px 0px 4px #666;
}
.rackTable{border-collapse:collapse; width:100%;}
.rackTable td[s]{
	color:#999;
	border:1px #ccc solid;	
	background-color:#ddd;
	width:500px;
	border-radius:0px;	
}
.rackTable td[m]{
	color:#fff;
	border:1px rgba(102,102,102,0.1) solid;
	background-color:rgba(102,102,102,0.1);
	width:20px;
	padding:0px;
	margin:0px;
	height:20px;
	font-size:1w;
	text-shadow:#000 0px 0px 3px;
}
.rtt{
	height:12px;
	line-height:12px;
	font-size:0.8vw;
	z-index:5;
}
.rts:hover{background-color:#eee; cursor:pointer;}
.rts{
	width:90%;
	height:90%;
	background-color:#FFF;
	border-radius:50%;
	margin:auto;
	margin-top:-10px;
	margin-bottom:5%;
	border:1px #ccc solid;
	overflow:hidden;
	z-index:3;
}
.rts[sw=on]{background-color:#FF0;}
.hideINput{position:absolute;top:-500px;}
.siOver{position:relative;}
.siOver:hover > div{display:block;}
.siOver > div{
	position:absolute;
	margin-top:-25px;
	margin-right:-15px;	
	width:90px;
	display:none;
	z-index:2;	
}
.siOver > div > div{width:35px; height:35px; border-radius:30px; border:2px <?=$clr1111?> solid}
.siOver > div > div:hover{background-color:<?=$clr1111?>;}
.siOver div[a]{ background:url(images/lab_sa.png) <?=$clr1?> no-repeat center center;}
.siOver div[b]{ background:url(images/lab_sb.png) <?=$clr1?> no-repeat center center;}
.printIcon{width:40px; height:40px;background-color:<?=$clr1?>;background: url(images/print_ic.png) <?=$clr1?> no-repeat center center; border-radius:2px;margin:3px;}
.printIcon:hover{background-color:<?=$clr1111?>; cursor:pointer; }
.rackTool div{
	width:35px;
	height:35px;
	background-color:rgba(0,0,0,0.2);
	background-position:center center;
	background-repeat:no-repeat;
	margin-<?=$align?>:5px;
	float:<?=$Xalign?>;
	border-radius:5px;
}
.rackTool div:hover{background-color:rgba(0,0,0,0.3); cursor:pointer;}
.rackTool div[a]{background-image:url(images/ri_1.png);}
.rackTool div[b]{background-image:url(images/ri_2.png);}
.rackTool div[c]{background-image:url(images/ri_3.png);}
.rackTool div[d]{background-image:url(images/ri_4.png);}
.labStatus{
	line-height:60px;
	color:#fff;
	font-size:24px;
	text-align: center;
	font-family: 'ff';
}

.LS_pIcon,.LS_fIcon{
	width:40px;
	height:40px;
	background-color:#ccc;
	margin:3px;
	border-radius:20px;
	cursor:pointer;	
}
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
.q_tool > div[a]{background-color:<?=$clr55?>;}.q_tool div[a]:hover{background-color:<?=$clr1111?>;}
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
.moveBox{
	left:0px;
	top:0px;
	display:none;
	position:absolute;
	width:40px;
	height:40px;
	background:url(images/move.png) <?=$clr5?> no-repeat center center ;
	z-index:200;
}
.rd_icons div:hover{background-color:<?=$clr1111?>;}
.rd_icons div{
	width:40px;
	height:40px;
	margin-<?=$align?>:5px;
	margin-bottom:5px;
	background-color:<?=$clr1?>;
	background-repeat:no-repeat;
	background-image:url(images/r_icon.png);
	border-radius:3px;
	cursor:pointer;
}
.rd_r1{ background-position:0px center;}
.rd_r2{ background-position:-40px center;}
.rd_r3{ background-position:-80px center;}
.rd_b1{overflow-x:hidden;width:250px; border-left:1px #ccc solid; padding:5px;}
.rd_b2{overflow-x:hidden;padding:5px;}
.rd_b2 > div[r]{
	width:100%;
	background-color:#fff;
	margin-bottom:5px;
	padding-bottom:5px;
	border-bottom:1px #eee solid;
}
.rd_b2 > div[r]:hover{ background-color:#eee;}
.rd_b2 > div[s]{
	width:100%;
	min-height:40px;
	border:2px #999 solid;
}
.rd_mover{border-radius:20px;width:40px; height:40px; background:url(images/move.png) <?=$clr3?> no-repeat center center ;}
.rd_mover:hover{background-color:<?=$clr2?>; cursor:move;}
.rdr_del{border-radius:20px;width:40px; height:40px; background:url(images/sys/icon_c_del.png) <?=$clr5?> no-repeat center center;}
.rdr_del:hover{background-color:<?=$clr55?>; cursor:pointer;}
.rd_b2 div[fil]{
	border:2px #ccc solid;
	min-height:36px;
	margin-left:3px;
	margin-right:3px;
	padding-left:5px;
	padding-right:5px;
	text-align:center;

}
.rd_b2 div[fil] > div {
	background-color:<?=$clr1?>;
	color:#fff;
	padding:5px;
	line-height:20px;
	margin:3px;
}
.rd_b2 div[fil] > div[ok]{background-color:<?=$clr1111?>;}
.rd_b2 div[fil] > div:hover{
	background-color:<?=$clr5?>;
	color:#fff;
	cursor:pointer;
}
.rTr_s3{ background-color:#FFc;}
.rTr_s2{ background-color:#cFc;}
.rTr_s1{ background-color:#Fcc;}
.rTr_s9{ background-color:#ddF;}
.smpIcon{
	width:40px;
	height:50px;
	background:url(images/ic_sample.png)#658 no-repeat center center;	
	margin:0px 5px 0px 5px;
}


.LS_pIcon{ background:url(images/print_ic.png) <?=$clr5?> no-repeat center center;}
.LS_pIcon:hover{background-color:<?=$clr55?>;}
.LS_fIcon{ background: url(images/_1.png) <?=$clr1?> no-repeat center center;}
.LS_fIcon:hover{background-color:<?=$clr1111?>;}
.addLRep{
	width:40px;height:40px;
	background:url(images/re_icon.png) <?=$clr1?> no-repeat center center;
	border-radius:25px;
}
.addLRep:hover{background-color:<?=$clr1111?>; cursor:pointer;}
.allLRr{
	border:1px #aaa solid;
	margin-bottom:8px;
	border-radius:1px;
}
.allLRr > div[s]{
	color:#333;
	line-height:25px;
	text-align:center;
	font-size:11px;	
	background-color:rgba(0,0,0,0.05)
}
.allLRr > div[n]{
 	margin:5px;
	line-height:20px;
	text-align:center;
}
.rr_t1{
	width:200px;
	border-<?=$Xalign?>:1px #ccc solid;
	height:100%;
	padding-<?=$Xalign?>:10px;
	margin-<?=$Xalign?>:10px;
	overflow-x:hidden;
}
.rr_t2{
	width:200px;	
	height:100%;
	overflow-x:hidden;
}
.rr_t1 > div[a]{background-color:#efe;}.rr_t1 > div[a]:hover{background-color:#dfd; cursor:pointer;}
.rr_t1 > div[d]{background-color:#f5f5f5;}.rr_t1 > div[d]:hover{background-color:#dfd; cursor:pointer;}
.rr_t1 > div[c]{background-color:#fee;}

.reprort_s:hover .x_val{ display:block;}
.reprort_s:hover{background-color: #eee;}
.xv_msg{
	background-color:#fcc;	
	padding:5px;
	margin-top:10px;
	border-radius:5px;border: 1px <?=$clr5?> solid;
}
.xv_msg .tit{background-color: <?=$clr5?>;border-radius:5px;}
.newSamp{
	width:40px;
	height:40px;
	background-color:;
	border-radius:5px;
	background:url(images/lab_sb.png) <?=$clr1?> no-repeat center center;
}
.newSamp:hover{background-color:<?=$clr1111?>; cursor:pointer;}
.ATIc{
	margin:8px;
	
}
.ATIc div[i]{
	width:150px;
	height:100px;
	background-color:<?=$clr11?>;
	padding:5px;
	background-repeat:no-repeat;
	background-position:center center;
	border-bottom:1px solid <?=$clr11?>;
	border-radius:6px 6px 0px 0px;
}
.ATIc div[t]{
	width:150px;
	background-color:<?=$clr1?>;
	color:#fff;
	text-align:center;
	padding:5px;
	border-radius:0px 0px 6px 6px;
}
.ATIc:hover div[i],.ATIc:hover div[t]{background-color:<?=$clr1111?>; cursor:pointer;}
.aq_list{	
	width:49%;
	height:100%;
	overflow-x:hidden;
}
.aq_list[l]{border-left:1px #ccc solid;}
.aq_list div[no]{
	border:1px #ccc solid;
	margin:0px 5px 5px 5px;
	padding:5px;
	line-height:20px;	
	text-align:center;
	color:#fff;
	border-radius:3px;
}
.aq_list[l] div[no]{background-color:#aaa;}
.aq_list[l] div[no]:hover{background-color:#999; cursor:pointer;}
.aq_list[t] div[no]{background-color:<?=$clr1?>;}
.aq_list[t] div[no]:hover{background-color:<?=$clr1111?>; cursor:pointer;}
.aq_list div[no][d=h]{display:none;}
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
.nqn div[a]{background-color:<?=$clr55?>;}
.grad_s_lab td div[b]{ border-bottom:3px #ccc solid; margin-bottom: 5px;}
.grad_s_lab td div[b]:last-child{ border-bottom:0px #ccc solid; margin-bottom: 0px;}
.grad_s_lab tr td{	
	border:1px  #aaa solid;
	background-color: #f9f9f9;
	padding: 60px;
	border-radius:1px;
	border-bottom:3px #aaa solid; 
}
.grad_s_lab {margin: 0px;}
.grad_s_lab tr td{	
	background-color: #fcfcfc;
	padding: 3px;
}




.l_Reslr{
	position: absolute;
	left:0px;
	margin-top: -10px;
}
.radioBlc_each[par=m0]{background-color: #fcc;}.radioBlc_each[par=m0]:hover{background-color:<?=$clr5?>;}
.radioBlc_each[par=m1]{background-color: #cfc;}.radioBlc_each[par=m1]:hover{background-color:<?=$clr6?>;}
.radioBlc_each[par=m2]{background-color: #ccc;}.radioBlc_each[par=m2]:hover{background-color:<?=$clr1?>;}

.radioBlc_each[par=n][ch="on"]{background-color: #666;color:#fff}.radioBlc_each[par=n][ch="on"]:hover{background-color:#333; }
.radioBlc_each[par=n][ch="off"]{background-color: #ccc;}.radioBlc_each[par=n][ch="off"]:hover{background-color:#aaa;}
.radioBlc_each[par=p][ch="on"]{background-color: #666;color:#fff}.radioBlc_each[par=p][ch="on"]:hover{background-color:#333;}
.radioBlc_each[par=p][ch="off"]{background-color: #ccc;}.radioBlc_each[par=p][ch="off"]:hover{background-color:#aaa;}

.tranTr{background-color:'#eee';opacity: 0.5;}
.lr_int{
	width:250px;
	border-<?=$Xalign?>:1px #ccc solid;
	padding-<?=$Xalign?>:10px;
	margin-<?=$Xalign?>:10px;
	
}
.LiCode{padding: 10px;}
.delText:hover{
	background-color:<?=$clr5?>;
	color:#fff;
}
.dvIcon{
	margin-<?=$align?>:10px;
	height:40px;
	width:40px;
	color:#fff;
	float:<?=$Xalign?>;
	border-radius:3px;
	background-position:center center;
	background-repeat:no-repeat;
	background-color:<?=$clr1?>;
}
.dvIcon:hover{
	background-color:<?=$clr1111?>;
	cursor:pointer;
}
.dv_add{background-image:url(images/pcat_add.png);}
.dv_note{background-image:url(images/re_icon.png);}
.repLNote div{ font-size:12px; color:#999; line-height:14px;}
.refData{
	background-color:#fff;
}
div[part=input] input{max-width:none;}
.outAna{
	width:10px;
	height:10px;
	margin-top:10px;
	position:absolute;
	background-color:#F00;
	border-radius:5px;
}
.send_sams{
	width:40px;
	height:40px;	
	background:url(images/ri_4.png) <?=$clr1?> no-repeat center center;
	margin-<?=$align?>:5px;	
	border-radius:2px;
}

.send_sams:hover{background-color:<?=$clr1111?>; cursor:pointer;}
.samp_grp_list > div{
	line-height: 20px;
	padding: 10px;	
	font-size: 14px;
	font-family: 'f1';	
	border-radius: 2px;
	margin-bottom: 10px;
	border:1px #ccc solid;
	border-bottom:3px <?=$clr1111?> solid;
	margin-<?=$Xalign?>: 5px;
}
.samp_grp_list > div[s='0']{background-color: <?=$clr4?>;}
.samp_grp_list > div[s='1']{background-color: #faf7b2;}
.samp_grp_list > div[s='2']{background-color: #b2cbfa;}

.samp_grp_list > div:hover{opacity: 0.7; filter: alpha(70); cursor: pointer;}
.samp_grp_list > div[n='0']{background-color: <?=$clr111?>;color:#fff;}

.reportRevBlok{
	border:2px #aaa solid;
	margin: 10px;
	padding: 10px;
	border-radius: 5px;
}
.reportRevBlok[s='8']{
	background-color: #ECF7E6;
	display: none;
}
.emegncySide{
 	position:relative; width:250px; 
 }
.mordet:hover{
	background-color: <?=$clr44?>;
	cursor: pointer;border-bottom:1px solid #eee;
	display:block;
}
.emergncy_block{
	margin-bottom:10px;
	background-color:#eee;
	border:1px <?=$clr1?> solid;
	border-bottom:5px <?=$clr1?> solid;
	border-radius:0px;
	width: 100%;
}
.emergncy_block:hover{background-color:<?=$clr44?>;cursor:pointer;}
.fast_ana_dash{
	background-color:#faa;
	border:1px <?=$clr5?> solid;
	border-bottom:5px <?=$clr5?> solid;
 }
.fast_ana_dash:hover{background-color:#faa;}
tspan{font-family: 'ff';}
.grad_lab_enter{border-collapse:collapse;}
.grad_lab_enter td{border:1px #ccc solid;}
/*.grad_lab_enter td div[b]{ border-bottom:3px #ccc solid; margin-bottom: 5px;}*/
/*.grad_lab_enter td div[b]:last-child{ border-bottom:0px #ccc solid; margin-bottom: 0px;}*/
.grad_lab_enter tr td{
	/*padding: 20px;*/	
	padding: 3px;
	height: 30px;
}
.grad_lab_enter tr[last] td{
	border-bottom: 3px #ccc solid;
}
.grad_lab_enter {margin: 0px;}
.grad_lab_enter tr td input{
	height: 34px;
	padding: 0px;
	border-radius: 2px;
	
	border:1px #666 solid;
	box-sizing: border-box;
	
}
.grad_lab_enter tr td textarea{
	height: 90px;
	padding: 0px;
	border-radius: 2px;
	
	border:1px #666 solid;
	box-sizing: border-box;
	
}
.grad_lab_enter tr:nth-child(even) {background: #f5f5f5}
.grad_lab_enter tr:nth-child(odd) {background: #FFF}
#anaresTxtRes{
	padding: 10px;
}
/**********************/
.sampleWBlc{
	width: 100%;	
	margin-bottom: 10px;
	margin-<?=$Xalign?>: 10px;
	background-color: #fff;
	border-width:1px;
	border-<?=$align?>:8px;
	border-style: solid;
	border-radius: 2px;
	border-color:#ccc;
	max-width: 600px;
}
.sampleWBlc[s0] div,.sampleWBlc[s3] div{opacity: 0.8;}
.sampleWBlc[s1]{border-color:<?=$clr1?>;}
.sampleWBlc[s1]:hover{background-color:<?=$clr888?>;cursor:pointer;}
.sampleWBlc[s1] span{color:<?=$clr1?>;}
.sampleWBlc[s2]{border-color:<?=$clr6?>;}
.sampleWBlc[s2]:hover{background-color:<?=$clr666?>;cursor:pointer;}
.sampleWBlc[s2] span{color:<?=$clr6?>;}
.sampleWBlc[s3]{background-color:<?=$clr7?>;}
.sampleWBlc[s4]{border-color:<?=$clr5?>;}
.sampleWBlc[s4]:hover{background-color:<?=$clr555?>;cursor:pointer;}
.sampleWBlc[s4] span{color:<?=$clr5?>;}

.sampleWBlc[s5]{border-color:#ea992f;}
.sampleWBlc[s5]:hover{background-color:#fbe5c9;cursor:pointer;}
.sampleWBlc[s5] span{color:#ea992f;}
/**********************/
.i30_emer{background: url(images/i30_emer.png) no-repeat <?=$align?>;}
.i30_unlink{background: url(images/lab_ic0.png) no-repeat <?=$align?>;}
::placeholder {
  color:#aaa;
  font-family: 'f1';
  font-size:12px;
  font-weight: normal;  
  
}
.samBlc{
	background-color:#fff;	
	border: 1px #999 solid;
	margin-bottom: 10px;
	border-radius: 3px;	
}
.samBlc [shNo]{min-width: 120px; height: 40px; margin: 0px; line-height: 40px;}
.samBlc [shNo][set='1']:hover{
	background-color:<?=$clr777?>;
	cursor: pointer;
}
.samHolder{
	max-width: 500px;
	margin: auto;
}
.sam_menu{
	background: url(images/ic_sample_menu.png) no-repeat center center;
	width:50px;
	height:50px;
	position: relative;
	z-index: 10;
}
.sam_menu:hover{background-color:<?=$clr44?>;z-index: 12;}

.sam_menu > div{
	margin-top: 50px;	
	width: 200px;
	background-color:<?=$clr44?>;
	float:<?=$align?>;
	display: none;	
}
.sam_menu > div > div{
	text-align:<?=$align?>;	
}
.sam_menu > div > div:hover{
	background-color:<?=$clr444?>;
	cursor: pointer;
}
.sam_menu:hover > div {display: block;}

[anaSt]{text-indent:40px;}
[anaSt='5']{color:<?=$clr66?>;background: url(images/lab_ic5.png) #fff no-repeat <?=$align?>;}
[anaSt='0']{color:<?=$clr3?>; background: url(images/lab_ic0.png) #fff no-repeat <?=$align?>; position: relative;}
[anaSt='2']{color:<?=$clr8?>;}
[anaSt='3'],[anaSt='4']{color:<?=$clr5?>;}

.drag:hover,.dragIn:hover{cursor: move; background-color: <?=$clr7?>;}
.dragTop{line-height:0px;}
.dragItem{
	border:3px <?=$clr77?> solid;
	background-color:<?=$clr7?> ;
	z-index: 100;	
}
.dropItem{	
	background-color:<?=$clr666?> ;	
}
.samSrv{
	min-height:60px;
}
.redBord{
	border:3px <?=$clr5?> solid;	
}
[grpWT]:hover{
	background-color: <?=$clr444?>;
	cursor: pointer;
}
[grpWT][act]{
	background-color: <?=$clr7?>;	
}
.anaLis div{
    border-right:8px <?=$clr9?> solid;
}
.anaLis div[act]{    
    border-right:12px <?=$clr6?> solid;
}
</style>