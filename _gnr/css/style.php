<? session_start();/***GNR***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');
//include('../../_gnr/define.php');
$clinicTypesCol=array('','#85b24d','#ed475f','#009ad2','#99a','#dc6ed6','#d86bf7','#43D8AC');
?>
<style>
start{}
:root{<? foreach($clinicTypesCol as $k=>$v){if($k){echo '--CT'.$k.':'.$v.';';}}?>}
.icc81{background-color:#8a2068;}
.icc82{background-color:#48246a;}
.icc83{background-color:#11226d;}
.icc84{background-color:#00421a;}
.ti_wait{background:url(images/mad_icon2.png) no-repeat 0px top;}
.ti_wait:hover{background-position:0px bottom;}
.ti_pay{background:url(images/mad_icon2.png) no-repeat -180px top;}
.ti_pay:hover{background-position:-180px bottom;}
.ci_acc{background:url(images/icon_c_acc.png) no-repeat center center;}
.ti_1{background-image:url(images/top_icons.png);background-position:-60px top;}
.ti_1:hover{background-position:-60px bottom;}
.ti_2{background-image:url(images/top_icons.png);background-position:-120px top;}
.ti_2:hover{background-position:-120px bottom;}
.ti_3{background-image:url(images/top_icons.png);background-position:-180px top;}
.ti_3:hover{background-position:-180px bottom;}
.ti_4{background-image:url(images/top_icons.png);background-position:-240px top;}
.ti_4:hover{background-position:-240px bottom;}
.ti_5{background-image:url(images/top_icons.png);background-position:-300px top;}
.ti_5:hover{background-position:-300px bottom;}
.ti_6{background-image:url(images/top_icons.png);background-position:-360px top;}
.ti_6:hover{background-position:-360px bottom;}
.ti_7{background-image:url(images/top_icons.png);background-position:0px top;}
.ti_7:hover{background-position:0px bottom;}
.ti_77{background-image:url(images/top_icons.png);background-position:0px bottom;}
.ti_77:hover{background-position:0px bottom; background-color: <?=$clr55?>}
.ti_8{background-image:url(images/top_icons.png);background-position:-480px top;}
.ti_8:hover{background-position:-480px bottom;}
.ti_0{background:url(images/arr_downs.png) no-repeat center center;}
.ti_0:hover{background-color:<?=$clr11?>; cursor:pointer;}
.ti_tickt{background:url(images/mad_icon2.png) no-repeat -60px top;}
.ti_tickt:hover{background-position:-60px bottom;}
.ti_card{background:url(images/mad_icon2.png) no-repeat -540px top;}
.ti_card:hover{background-position:-540px bottom;}
.ti_merge{background:url(images/mad_icon2.png) no-repeat -300px top;}
.ti_merge:hover{background-position:-300px bottom;}
.ti_docs{background:url(images/mad_icon2.png) no-repeat -360px top;}
.ti_docs:hover{background-position:-360px bottom;}
.ti_hrec{background:url(images/mad_icon2.png) no-repeat -480px top;}
.ti_hrec:hover{background-position:-480px bottom;}
.ti_work_time{background:url(images/mad_icon2.png) no-repeat -660px top;}
.ti_work_time:hover{background-position:-660px bottom;}
.ti_role{background:url(images/mad_icon2.png) no-repeat -720px top;}
.ti_role:hover{background-position:-720px bottom;}
.ti_offer{background:url(images/mad_icon2.png) no-repeat -780px top;}
.ti_offer:hover{background-position:-780px bottom;}
.rvbu > div:hover{opacity:0.7;filter:alpha(opacity=70); cursor:pointer;}
.rvbu_1{background-image:url(images/rvbu1.png);background-color:<?=$clr6?>;height:120px;}
.rvbu_2{background-image:url(images/rvbu2.png);background-color:<?=$clr5?>;height:120px;}
/* .rvbu{width:50%;} */
.rvbu > div{
	width:120px;
	background-position:center center;
	background-repeat:no-repeat;
	margin:20px;
	border-radius:5px;
}
.ic40_det{background-image:url(images/re_icon.png);background-position: <?=$align?> center;}
.ic40_emerg{background-image:url(images/ic_emerg.png);}
.ic40_vedio{background-image:url(images/ic40_vedio.png);}
.ic40_loc{background-image:url(images/gnr/ic40_loc.png);}
.i30_min{background-image:url(images/min.png);}
.i30_max{background-image:url(images/max.png);}
.ti_stop{background:url(images/mad_icon2.png) no-repeat <?=$clr5?> -900px top;}
.ti_stop:hover{background-color:<?=$clr5?>; background-position:-900px bottom;}
.ti_send{background:url(images/mad_icon2.png) no-repeat <?=$clr1?> -840px top;}
.ti_send:hover{background-color:<?=$clr1?>; background-position:-840px bottom;}
.ti_stop2{background:url(images/mad_icon2.png) no-repeat <?=$clr5?> -960px top;}
.ti_stop2:hover{background-color:<?=$clr5?>; background-position:-960px bottom;}
.stu0{background: url(images/blood0.png) #ccc no-repeat center center;}
.stu1{background:url(images/bell.png) <?=$clr1?> no-repeat center center;}
.stu1:hover{background-color:<?=$clr11?>; cursor:pointer;}
.stu2{
	background-image:url(images/icon_c_move.png);
	background-repeat:no-repeat;
	background-position:center center;
    
	background-color: <?=$clr5?>;	
    animation-name: changeColor;
    animation-duration: 0.2s;
	animation-iteration-count: infinite;
	z-index: 1;
}
.stu2:hover{background-color:<?=$clr11?>; cursor:pointer;}
.stu3{background: url(images/icon_c_enter.png) <?=$clr6?> no-repeat center center;}
.stu3:hover{background-color:<?=$clr6?>; cursor:pointer;}
.stu4{background: url(images/prv_icon.png) <?=$clr6?> no-repeat center center;}
.stu4:hover{background-color:<?=$clr6?>; cursor:pointer;}
.ana_list_cat > div , .par_list_cat > div{
	line-height:20px;
	padding:10px;
	margin-bottom:5px;
	border-radius:2px;
	border-bottom:2px #ccc solid;	
	margin-<?=$Xalign?>:3px;
	font-family:'f1',tahoma;
	font-size:14px;	
	background-color:#eee;
	margin-<?=$Xalign?>:8px;
	position: relative;
}
.ana_list_cat .actCat , .par_list_cat .actCat{
	line-height:20px;
	padding:10px;
	background:url(images/sys/over_arrw_<?=$align?>.png) <?=$clr1?> no-repeat <?=$Xalign?> center;
	color:#fff;
	border-bottom:0px #fff solid;
	margin-<?=$Xalign?>:0px;
}
.ana_list_cat .norCat:hover , .par_list_cat .norCat:hover{
	background-color:#ccc;
	cursor:pointer;
	border-bottom:2px #ccc solid; 

}
.ana_list_mdc > div , .par_list_mdc > div{
	line-height:20px;
	margin-bottom:5px;
	border-radius:2px;
	border-bottom:2px <?=$clr1111?> solid;	
	margin-<?=$Xalign?>:3px;
	font-family:'f1',tahoma;
	font-size:14px;	
	text-align:center;
	background-color:<?=$clr1?>;
	margin-<?=$align?>:5px;
	color:#fff;
	padding:10px;
	position: relative;
}
.ana_list_mdc div:hover , .par_list_mdc > div:hover{ cursor:pointer;background-color:<?=$clr1111?>; color:#fff;}
#anaSelected{margin-top:10px; overflow-x:hidden;}
.sel_Ana{
	font-size:14px;
	color:#999;	
	margin:5px;
	margin-bottom:5px;
	text-indent:22px;
	padding:5px;
	font-family:'f1',tahoma;
	max-width:250px;
	border-radius:2px;
}
.list_cat{
	height:100%;
	width:360px;
	border-<?=$Xalign?>:1px #ccc solid;
	padding-<?=$Xalign?>:10px;
}
.ana_list , .mad2_list{
	margin-top:10px;
	overflow-x:hidden;
	padding-<?=$Xalign?>:2px;
	width:168px;
}
.ana_list:last-child ,.mad2_list:last-child {width:185px;border-<?=$align?>:1px #ccc solid; }
.anaSel{
	height:100%;
	margin-<?=$align?>:10px;
}
.blc_win_title{
	height:40px;
	line-height:40px;
	font-size:18px;
	color:<?=$clr3?>;
	border-bottom:1px #ccc dotted;
}
.bwt_icon0{text-indent:45px;background:url(images/tab_h1.png) no-repeat <?=$align?> bottom;}
.bwt_icon1{text-indent:45px;background:url(images/tab_h3.png) no-repeat <?=$align?> bottom;}
.bwt_icon2{text-indent:45px;background:url(images/list_icon.png) no-repeat <?=$align?> center;}
.bwt_icon3{text-indent:45px;background:url(images/tab_h4.png) no-repeat <?=$align?> bottom;}
.bwt_icon4{text-indent:45px;background:url(images/tab_h5.png) no-repeat <?=$align?> bottom;}
.bwt_icon5{text-indent:45px;background:url(images/tab_h9.png) no-repeat <?=$align?> bottom;}
.bwt_icon6{text-indent:45px;background:url(images/tab_h7.png) no-repeat <?=$align?> bottom;}
.bwt_icon7{text-indent:45px;background:url(images/tab_h2.png) no-repeat <?=$align?> bottom;}
.bwt_icon8{text-indent:45px;background:url(images/tab_h6.png) no-repeat <?=$align?> bottom;}
.blc_win_title div{
	line-height:40px;
	font-family:'ff', tahoma;
	font-size:24px;
	text-indent:0px;
	text-align:<?=$Xalign?>
}
.blc_win_list{margin-top:10px;overflow-x:hidden;}
.iconTitle{ text-indent:50px; background-position:right center; background-repeat:no-repeat;}
.serTotal{
	line-height:30px;
	height:30px;
	color:#fff;
	background-color:<?=$clr1?>;
	width:80px;
	text-align:center;
	border-radius:2px;
}
.visRows2{ background-color:<?=$clr5?>; color:#fff; padding:10px; margin-bottom:10px; border-radius:5px;}
.visRows22{
	background-color: <?=$clr5?>;	
    animation-name: changeColor;
    animation-duration: 0.3s;
	animation-iteration-count: infinite;
	color:#fff; padding:10px; margin-bottom:10px; border-radius:5px;
}
.ti_play{background:url(images/mad_icon2.png) no-repeat <?=$clr6?> -120px top;}
.ti_play:hover{background-color:<?=$clr6?>; background-position:-120px bottom;}
.repButt{ width:40px; height:40px; background:url(images/icon_edit22.png) <?=$clr1?> no-repeat center center; border-radius:10px;}
.repButt:hover{background-color:<?=$clr11?>; cursor:pointer;}
td div[bb]{
	border-bottom:1px #ddd solid;
	padding:10px;	
	position:relative;

}
td div[bb]:last-child{border-bottom:0px #eee solid;}
.unitAna{ margin-top:5px;}
.reprort_s div[bt]{
	border-bottom:1px #ddd solid;	
	position:relative;	
	margin-bottom: 5px;
}
.reprort_s div[bb]:hover{background-color:#f9f9f9;}
div[part=norval]{
	/*line-height:29px;
	width:100%;*/
}
.reprort_w > div[r] , .reprort_s > div[r]{
	width:100%; 
	border-bottom:1px #ddd solid;
	margin-bottom:10px;
	padding-bottom:5px;
}
.reprort_s > div[r]{border-bottom:0px;}
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
	height:100%;
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
.iconPrint{background-image:url(images/print_ic.png);}
.iconDelv{background-image:url(images/end.png);}
.x_serv{line-height:20px;
margin-left:10px;
margin-right:10px;
background-color:<?=$clr5?>;
padding:10px;
color:#fff;
border-radius:4px;
}
.x_serv:hover{background-color:<?=$clr55?>; cursor:pointer;}
.x_serv ff[f]{ padding-left:5px; padding-right:5px;}
.x_serv ff[f]:hover{background-color:#f00; border-radius:4px;}
.chrCon{margin:0.2%;  height:50%;}
#chart1{width:34%;}
#chart2{width:64%;}
.dashTable td{text-align:center;height:20px;}
.dashTable th{text-align:center; background-color:#eee}
@keyframes changeColor {
	0%   {background-color: <?=$clr5?>;}
    98%  {background-color: #ff9797;}
    100%  {background-color: <?=$clr5?>;}    
}
@keyframes changeColor2 {
	0%   {background-color: #faa74d;}
    50%  {background-color: #faa344;}
    100%  {background-color: #faa74d;}    
}
@keyframes changeColor3 {
	0%   {background-color: #da4646; ;}
    50%  {background-color: #da4646;}
    100%  {background-color: #cc4646;}	
}
.alert_nav{	
	bottom:0px;
	<?=$Xalign?>:0px;
	position: fixed;
	z-index: 2;
	display:none;
}
.alert_nav_in{
	width:200px;
	padding: 10px;	
	background-color:#f6ef99;		
	color:#646352;	
}
.alert_nav_in:hover{
	background-color:#fef372;
	cursor:pointer;	
}
.alert_nav_in2{
	min-width:40px;	
    height:40px;
	background-color:<?=$clr5?>;	
	color:#fff;	
	line-height:40px;
    border-radius: 25px;
    margin: 5px;
    text-align: center;
    font-size: 20px;
    font-family: 'ff',tahoma;
    border: 1px <?=$clr55?> solid;
    font-weight: bold;
    background: url("images/bell.png")<?=$clr5?> no-repeat center center;
    background-size: 30px 30px;
    box-sizing: border-box;
}
.alert_nav_in2 div{
    min-width:20px;	
    height:20px;
	background-color:<?=$clr55?>;	
	color:#fff;	
	line-height:20px;
    border-radius: 25px;
    margin-top: -8px;
    margin-<?=$align?>: -5px;
    text-align: center;
    font-size: 12px;
    font-family: 'ff',tahoma;    
    font-weight: bold;
    box-sizing: border-box;
    position: absolute;
}
.alert_nav_in2:hover{
	background-color:<?=$clr55?>;
	cursor:pointer;	
}

.selSex{	
	width: 100%
}
.selSex div{	
	width: 120px;
	height: 120px;
	margin: 20px;
	border-radius: 5px;
}
.selSex div:hover{opacity:0.8; filter:alpha(opacity=80); cursor: pointer;}
.selSex div[s1]{background:url(images/ic_male.png) #5bbaea no-repeat center center; margin-<?=$Xalign?>: 0px}
.selSex div[s2]{background:url(images/ic_female.png) #f05fa2 no-repeat center center;}

.dashPerview div{
	line-height: 40px;
	border: 1px #ccc solid;
	padding-left: 10px;
	padding-right: 10px;
	margin-<?=$Xalign?>:10px;
	color: #fff;
	border-radius: 2px;
	float: <?=$align?>;
	font-size: 14px;
	font-family: 'f1';
	text-shadow: #000 0px 0px 8px ;
}
.dashPerview div[s0]{background-color:#ccc;}
.dashPerview div[s1]{background-color:#ea2f2f;}
.dashPerview div[s2]{background-color:#2a78c1;}
.dashPerview div[s3]{background-color:#ffff33;}
.dashPerview div[s4]{background-color:#3bbf34;}
.flasher{
	background-color:<?=$clr5?>;	
    animation-name:changeColor3;
    animation-duration:0.5s;
	animation-iteration-count: infinite;
	z-index: 1;
	color:#fff;
}
.flasher span{color:#fff;}
.flasher2{	
    animation-name:changeColor2;
    animation-duration:0.5s;
	animation-iteration-count: infinite;
	z-index: 1;
}
.vitslList >div {
	line-height: 20px;
	padding: 10px;
	background-color: <?=$clr1?>;
	margin-bottom: 5px;
	color:#fff;
	border-radius: 2px;
}
.vitslList >div:hover {
	background-color: <?=$clr1111?>;
	cursor: pointer;
}
.visDocList{
	box-sizing: border-box;
	padding-left:10px;
	padding-right:10px;
	position:relative;
	border-<?=$Xalign?>: 1px #ccc solid;
	width:33%;
}
.viewRep , .viewRep p , .viewRep span{
	font-family: 'f1';
	font-size: 14px;
	text-align: justify;
}
.addOpt{
	background-color: <?=$clr1?>;
	width: 288px;
	position: fixed;
	<?=$Xalign?>:0px;
	margin-top: 60px;
	z-index: 20;
	display: none;
}
.addOpt div{
	font-size: 14px;
	line-height: 40px;
	border-bottom: 1px #eee solid;
	text-align: center;
	font-family: 'f1';
	color: #fff;
}
.addOpt div:hover{
	background-color: <?=$clr1111?>;
	cursor: pointer;
}
.offerList{
	line-height: 20px;
	margin: 10px 0px 5px 0px;
	padding: 10px;
	border-radius: 2px;
	color: #fff;
}
.offerItem:hover{
	background-color: <?=$clr5?>;
	color:#fff;
	cursor: pointer;
}
.offerItVi{	
	height: 30px;
	line-height: 30px;	
	padding-<?=$Xalign?>:10px;
	margin: 0px auto;
	display: inline-block;
    border-radius: 5px;
    
}
.offerItVi::before{
    float: <?=$align?>;
    content:'';    
    width: 30px;
    height: 30px;
    background: url("images/sys/act_0.png") no-repeat center center;
    background-size: 60%;
}
.offerItVi:hover{
	background-color:<?=$clr5?>;
	color:#fff;
	cursor: pointer;
}
.offerItVi:hover::before{
    float: <?=$align?>;
    content:'';    
    width: 30px;
    height: 30px;
    background:url(images/sys/cancel.png) no-repeat center center;
    background-size: 80%;
}
.ti40_pres{background-image: url(images/ti_pres.png);}
.ti40_list{background-image: url(images/list_icon.png);}

.allPrescs > div{
	margin-bottom:10px;
	border-bottom: 3px #999 solid;
	border-radius: 2px;
	background-color:#eee;
}.allPrescs > div:hover{
	background-color:#ccc;
	cursor: pointer;
}
.allPrescs > div[actPerLis]{
	background-color:<?=$clr111?>;
	border-bottom: 3px <?=$clr1111?> solid;
}
/*******Dash****/
.dashBlock{
	background-color:#fefefe;
	margin: 10px;
	padding: 10px; 
	border: 2px #999 solid;		
	position:relative;	
	height: 380px;
}
.dashBlockIn{
	background-color:#fefefe;
	margin: 10px;
	padding: 10px; 
	border: 1px #999 solid;
	border-bottom: 8px #aaa solid;
	position:relative;
	height: 285px;		
}	
.dashLineInfo{
	width:100%;
	margin-bottom:10px
}
.dashLineInfo:last-child{		
	margin-bottom:0px
}
.dashLineInfo > [num]{
	line-height:70px;
	height:60px;
	text-align: center;
	font-family: 'ff';
	font-size:50px;


}
.dashLineInfo > [txt]{
	line-height:20px;
	text-align: center;		
	font-size:12px;
}
.dashLineInfo > [ico]{
	width:100px;
	height:80px;
	margin-bottom: 10px;
}
.dash_icon_cash{background:url(images/dash_icon_cash.png) no-repeat center center;}
.dash_icon_srv{background:url(images/dash_icon_srv.png) no-repeat center center;}
.dash_icon_srv_d{background:url(images/dash_icon_srv_d.png) no-repeat center center;}
.dash_icon_pat{background:url(images/dash_icon_pat.png) no-repeat center center;}
.dash_icon_appo{background:url(images/dash_icon_appo.png) no-repeat center center;}
.dash_icon_xdate{background:url(images/dash_icon_xdate.png) no-repeat center center;}
.dash_icon_date2{background:url(images/dash_icon_date2.png) no-repeat center center;}
.dash_icon_wait{background:url(images/dash_icon_wait.png) no-repeat center center;}

.biin{		
	margin: 4px;
	border: 1px #ccc solid;
	border-bottom: 4px #ccc solid;
	height: 80px;		
}
.fsB{font-size: 30px; font-family: 'ff'; line-height:40px; }
.fsB2{font-size: 18px; font-family: 'ff'; line-height:20px; }
.dbi{
	float: <?=$align?>;		
	height: auto;
	position:relative;
	width: 33%;
}	
@media screen and (max-width:1100px){.dbi{width: 50%;}}
@media screen and (max-width:800px){.dbi{width: 100%;}}

.rep_cont *{
	font-family: tahoma;
	font-weight: bold;
}
.rep_cont{
	background-color:#fff;
	padding: 0px; 			
}
.ic40_addimage{background-image:url(images/icon_add_image.png);}
.ic40_adddoc{background-image:url(images/icon_add_doc.png);}
.ic40_docs{background-image:url(images/ic_docs.png);}
/****ُEditor*********************************************/
.contentEditor , .contentEditor span{font-size:18px; margin-bottom:50px; text-align:justify; line-height:30px;}
.contentEditor a{color:#35aada; font-family:'f1',tahoma;font-size:16px; font-weight:bold;}
.contentEditor a:hover{color:#405caa;}
/**********************************************/
.pd0{
	padding: 0px;		
}

.dashPerview2 > div{
	line-height: 35px;								
	border-radius: 2px;
	float: <?=$align?>;
	margin-bottom:4px;
	margin-top:7px;
	background-color:#fff;

}
.dashPerview2 div[s0]{border-bottom:5px #ccc solid;}
.dashPerview2 div[s1]{border-bottom:5px #ea2f2f solid;}
.dashPerview2 div[s2]{border-bottom:5px #2a78c1 solid;}
.dashPerview2 div[s3]{border-bottom:5px #ffff33 solid;}
.dashPerview2 div[s4]{border-bottom:5px #3bbf34 solid;}
.partIcon{
	width:90px;
	height:90px;
	margin-bottom: 10px;
	padding: 10px;
}
	

.butPRopt{
	border-bottom: 1px #999 dashed;
	padding-bottom: 5px;
	margin: 10px 0px 10px 0px;
}
.butPRopt > div {
	height: 35px ;
	line-height: 35px;
	background-color:;
	margin-bottom: 5px;
	font-family: 'f1',tahoma;
	text-indent: 40px;
	font-size: 12px;
	border-radius: 2px;
	cursor: pointer;
	background-image: url(images/sys/mche.png);
	background-color: #eee;
	background-repeat: no-repeat;
	background-position: top <?=$align?>;
}
.butPRopt > div > span {
	font-family: 'ff';
	font-size: 14px;
	font-weight: bold;
}
.butPRopt > div:hover {
	background-color: #ccc;	
}
.butPRopt > div[act] {	
	background-position: bottom <?=$align?>;
	color: #fff;
}
.pr_src{background-color:#ddd;}
#pr_data{
	background-color:#eee;
}
.cbgx33{
	background-color:#463dc2;
}
.op1 > div , .op2 > div{border-<?=$align?>-width: 5px;border-<?=$align?>-style: solid;}

.op1 > div[n1]{border-color:#5c7148;}
.op1 > div[n1][act]{background-color:#88b14b;}
.op1 > div[n1][act]:hover{background-color: #5c7148;}

.op2 > div[a]{border-color:#333;}
.op2 > div[a][act]{background-color:#666;}
.op2 > div[a][act]:hover{background-color: #666;}

.op2 > div[n2]{border-color:#b22e4d;}
.op2 > div[n2][act]{background-color:#dc395f;}
.op2 > div[n2][act]:hover{background-color: #b22e4d;}

.op2 > div[n3]{border-color:#0c4c8a;}
.op2 > div[n3][act]{background-color:#5587a2;}
.op2 > div[n3][act]:hover{background-color: #0c4c8a;}

.op2 > div[n4]{border-color:#c04a2a;}
.op2 > div[n4][act]{background-color:#ee7554;}
.op2 > div[n4][act]:hover{background-color: #c04a2a;}

.op2 > div[n5]{border-color:#a38166;}
.op2 > div[n5][act]{background-color:#caac93;}
.op2 > div[n5][act]:hover{background-color:#a38166;}

.op2 > div[n6]{border-color:#63a5b1;}
.op2 > div[n6][act]{background-color:#83bfca;}
.op2 > div[n6][act]:hover{background-color:#63a5b1;}
.pr_videt{max-width: 800px;position: relative;}
.pr_bHead,.pr_month{border-bottom-width: 1px;border-bottom-style: solid;}

.pr_bHead[n1],.pr_month[n1]{border-color:#5c7148;background-color:#88b14b;}
.pr_bHead[n2],.pr_month[n2]{border-color:#b22e4d;background-color:#dc395f;}
.pr_bHead[n3],.pr_month[n3]{border-color:#0c4c8a;background-color:#5587a2;}
.pr_bHead[n4],.pr_month[n4]{border-color:#c04a2a;background-color:#ee7554;}
.pr_bHead[n5],.pr_month[n5]{border-color:#a38166;background-color:#caac93;}
.pr_bHead[n6],.pr_month[n6]{border-color:#63a5b1;background-color:#83bfca;}

.pr_bHead{
	heigth:38px;
	line-height: 38px;	
	margin-top: 10px;
	margin-<?=$align?>: 10px;
	color:#fff;
	font-family: 'f1';
	font-size: 18px;
	border-radius: 1px 1px 0px 0px;	
}
.pr_bHead div[n]{
	line-height:40px;
	width: 80px;
	font-family: 'ff';
	font-size:20px;
	text-align: center;
	background-color: rgba(0,0,0,0.3);
	border-radius: 1px 1px 0px 0px;
}
.pr_bHead div[t]{	
	text-align: center;
	line-height:40px;
}
.pr_bHead div[x]{	
	height:40px;
	width: 40px;
	font-family: 'ff';
	font-size:20px;
	text-align: center;
	background-color: rgba(0,0,0,0.4);	
	border-radius: 1px 1px 0px 0px;
}
.pr_bHead div[x]:hover{
	cursor: pointer;
	background-color: rgba(0,0,0,0.6);	
}
.pr_bHead div[x='1']{
	background-image: url(images/up_down.png);
	background-position: center bottom;
}
.pr_bHead div[x='2']{
	background-image: url(images/up_down.png);
	background-position: center top;
}
.pr_bbody{	
	border:1px #bbb solid;
	border-bottom:3px #bbb solid;
	margin-bottom: 10px;
	margin-<?=$align?>: 10px;	
	min-height: 40px;
	padding: 10px;
	background-color:#fff;
	border-radius: 0px 0px 1px 1px;	
	
}

.pr_year{
	line-height:40px;
	background-color:<?=$clr2?>;
	width:100px;
	color:#fff;
	text-align: center;
	font-family: 'ff';
	font-size: 20px;
	margin: 10px 0px 20px 0px;
	font-weight: bold;
	letter-spacing: 5px;
	border-radius: 0px;
	z-index: 4;
	position: relative;
	box-shadow: 0px 1px 3px #000;
	border-bottom:2px #aaa solid;	
}
.pr_month{
	line-height:20px;	
	width:80px;
	color:#fff;
	text-align: center;
	font-family: 'ff';
	font-size: 20px;
	margin-top: 10px;
	padding: 10px 0px 5px 0px;		
	border-radius: 0px;
	border-bottom:2px #333 solid;
	position: relative;
	z-index: 4;
	box-shadow: 0px 1px 3px #000;
	font-family: 'f1';
	font-size: 12px;
}
.pr_month span{
	line-height:30px;
	font-size: 30px;
	font-family: 'ff';
}
.prvLine{
	heigth:100%;	
	border-<?=$Xalign?>:8px #aaa solid;
	width:35px;
	background-color: transparent;
	position: absolute;
	float:<?=$align?>;	
	z-index: 1;
	
}

.MMBo{	
	width: 100%;
	position: absolute;
	margin-top: 141px;
	margin-<?=$align?>: 11px;
	background: rgb(255,255,255);
	background: linear-gradient(0deg, rgba(255,255,255,1) 20%, rgba(255,255,255,0) 100%);
	z-index: 10;
	
}
.butPRoptIcon > div{
	height: 35px ;
	line-height: 35px;
	background-color:;
	margin-bottom: 5px;
	font-family: 'f1',tahoma;
	text-indent: 40px;
	font-size: 12px;
	border-radius: 2px;
	cursor: pointer;	
	background-color: <?=$clr1?>;
	background-repeat: no-repeat;	
	border-<?=$align?>:5px <?=$clr1111?> solid;
	color:#fff;
	
}
.butPRoptIcon > div:hover{
	cursor: pointer;
	background-color: <?=$clr1111?>;
}

.butPRoptIcon > div[i1]{background-image: url(images/prec_icon.png);background-position: <?=$align?> 0px;}
.butPRoptIcon > div[i2]{background-image: url(images/prec_icon.png);background-position: <?=$align?> -35px;}
.butPRoptIcon > div[i3]{background-image: url(images/prec_icon.png);background-position: <?=$align?> -71px;}
.butPRoptIcon > div[i4]{background-image: url(images/prec_icon.png);background-position: <?=$align?> -106px;}
[denOpr][a='1']:hover{background-color:#EEF16D;cursor: pointer;}
.vidLinks div[v]{
	line-height: 20px;
	background-color: #f5f5f5;
	padding: 10px;
	margin-bottom: 10px;
}
.vidLinks div[v]:hover{background-color: #eee;cursor: pointer;}
.vidLinks div[v][act]{background-color:<?=$clr1?>;color: #fff;}
.chrBlc{
	border: 1px #ccc solid;
	border-bottom:#ccc 6px solid;
	padding: 10px;
	margin-bottom: 10px;
	border-radius: 2px;
}
.chrBlc:hover{
	background-color: #f9f9f9;
	cursor: pointer;
}
/***REC***/
.addRecOpr div{
	float: <?=$align?>;
	height: 100px;
	width: 50%;
	background-color: <?=$clr6?>;
	box-sizing: border-box;
	text-align: center;
	color:#fff;
	padding-top: 75px;
	font-family: 'f1';
}
.addRecOpr div[v]{
	background:url(images/rec/rbb1.png)#85b24d no-repeat center center;
}
.addRecOpr div[v]:hover{
	background-color:#6d953f;
	cursor: pointer;
}
.addRecOpr div[d]{
	background:url(images/rec/rbb2.png)#ed475f no-repeat center center;
	border-<?=$Xalign?>: 1px #ccc solid;	
}
.addRecOpr div[d]:hover{
	background-color:#b13148;
	cursor: pointer;
}
.recTabs > div{
	height:50px;
	line-height:55px;
	border-bottom: 1px #666 solid;
	text-indent: 50px;
	font-family:'f1';
	color:#fff;
	font-size: 14px;
	background-color:#666;
	cursor: pointer;
}

.recTabs div[v]{background:url(images/rec/rob1.png) #444 no-repeat <?=$align?> center;}
.recTabs div[d]{background:url(images/rec/rob2.png) #444 no-repeat <?=$align?> center;}
.recTabs div[act]{
	background-color:#4c8bdb;
}
.recTabs div[act]:hover{background-color:#417BC4;}
.recTabs div div{
	width:30px;
	height: 50px;	
	float: <?=$Xalign?>;
}
.recTabs div[act] div{
	background:url(images/sys/arr_w_<?=$align?>.png) no-repeat center center;	
}
.recTabs > div:hover{background-color:#333;}
.recOprs{width:199px;}
.recOprs > div{
	height:50px;
	line-height:55px;
	border-bottom: 1px #555 solid;
	text-indent: 50px;
	font-family:'f1';
	color:#fff;
	font-size: 14px;	
	cursor: pointer;
}

.recOprs div[t=doc]{background:url(images/rec/rec_opr_docs.png) #444 no-repeat <?=$align?> center;}
.recOprs div[t=offer]{background:url(images/rec/rec_opr_offer.png) #444 no-repeat <?=$align?> center;}
.recOprs div[t=role]{background:url(images/rec/rec_opr_role.png) #444 no-repeat <?=$align?> center;}
.recOprs div[t=time]{background:url(images/rec/rec_opr_time.png) #444 no-repeat <?=$align?> center;}
.recOprs div[t=acount]{background:url(images/rec/rec_opr_acount.png) #444 no-repeat <?=$align?> center;}
.recOprs div[t=docs]{background:url(images/rec/rec_opr_docs.png) #444 no-repeat <?=$align?> center;}
.recOprs div[t=lab]{background:url(images/rec/rec_opr_lab.png) #444 no-repeat <?=$align?> center;}
.recOprs div[t=xry]{background:url(images/rec/rec_opr_xry.png) #444 no-repeat <?=$align?> center;}
    
.recOprs div[t=dates]{background:url(images/rec/rob2.png) #444 no-repeat <?=$align?> center;}
.recOprs div[t=visits]{background:url(images/rec/rec_new_pat.png) #444 no-repeat <?=$align?> center;}
    
.recOprs > div:hover{background-color:#333;}

.alertSec{
	background-color: #eee;
	border-right: 2px #ccc solid;
}
.ticketIn{
	height:50px;	
	background:url(images/rec/rec_ticket.png) #f5f5f5 no-repeat <?=$align?> center;
	text-align:<?=$Xalign?>;
    border-<?=$align?>:2px #ccc solid;
    box-sizing: border-box;
}
.ticketIn input{
	line-height: 50px;
	height: 48px;
	text-align: center;
	border: 0px;
	background-color: #f5f5f5 ;    
	width: 230px;
}
.ticketIn .loaderT{
    position: absolute;
	background:url("images/sys/loader.gif") #f5f5f5 no-repeat center center;    
    width:200px;
    margin-<?=$align?>: 40px ;
    height: 49px;
    display:none;
}
.recOprWin{
	float:<?=$align?>;
	position: absolute;
	background-color: #fff;
	margin-<?=$align?>:200px;	
	z-index:3;
	box-sizing: border-box;
	display: none;
}
.recOprWin [h]{
	float:<?=$align?>;
	line-height: 50px;
	width: 100%;
	background-color: #f5f5f5;
	border-bottom: 1px #ddd solid;
    box-sizing: border-box;
}
.recStatus{
	border-top:1px #444 solid;
	background-color: #555;
}
.recStatus [i]{
	float:<?=$align?>;
	width: 30px;
	height: 30px;
	background-color: #444;
	background-position: center center;
}
.recStatus [i][p]{background-image:url(images/rec/rec_st1.png);}
.recStatus [i][m]{background-image:url(images/rec/rec_st2.png);}
.recStatus [v]{
	float:<?=$align?>;
	width: 65px;
	height: 30px;
	text-align: center;	
	color:#fff;
	font-family: 'ff';
	font-size:14px;
	line-height: 30px;
}
.recStatus [patsN]{width:50px;}
.recStatus [boxInc]{width:88px;}
/**/
.recWiz{	
	height: 50px;
	border-bottom: 1px #ccc solid;
	box-sizing: border-box;
	padding:0px 5px;
}
.recWiz > div{    
	line-height:40px;
	height: 40px;
	overflow: hidden;
	border-<?=$Xalign?>:0px #ccc solid;
	text-indent: 0px;
	
	box-sizing: border-box;
	color: #fff;
	margin: 5px 0px;
	background-color: #999;
	background-position:<?=$align?> center,<?=$Xalign?> center;
	background-repeat:no-repeat,no-repeat;
	background-image:url(images/rec/rec_wiz_<?=$align?>.png),url(images/rec/rec_wiz_<?=$align?>2.png);
}

.recWiz div div{
	float:<?=$align?>;
	width: 40px;
	height: 40px;
	margin-<?=$align?>: 10px;
	background-position:center -5px;;
	background-repeat:no-repeat;
	
}
.recWiz [cln] div{background-image:url(images/rec/rec_new_cln.png)}
.recWiz [doc] div{background-image:url(images/rec/rec_new_doc.png);}
.recWiz [pat] div{background-image:url(images/rec/rec_new_pat.png);}
.recWiz [srv] div{background-image:url(images/rec/rec_new_srv.png);}
.recWiz [pay] div{background-image:url(images/rec/rec_new_pay.png);}
.recWiz > div[act]{background-color: #db5031;}
.recWiz > div[end]{background-color: #5f8436;}
.recWiz > div[dis]{background-color: #eee;}
.recClcType div{
	line-height: 40px;
	background-color: #eee;
	margin-top: 10px;
	text-indent: 10px;
	
	border:0px;
	border-<?=$align?>-width:8px ;
	border-style:solid;
	border-color:#666;
	border-bottom:1px #999 solid;
	border-radius:1px;
}
.recClcType div:hover{
	cursor: pointer;
	background-color: #ccc;
}
.recClcType div[act]{
	color:#fff;
	background-color: #444;
}

.cliBlc > div{
	/*min-width: 200px;*/
	/*float: <?=$align?>;*/
	border:1px #aaa solid;
	border-bottom:2px #aaa solid;
	/*margin:5px;*/
	padding:10px 0px;
	border-radius:1px;
	cursor: pointer;
	background-color: #fff;    
}
.cliBlc > div:hover{border:1px #333 solid;border-bottom:2px #333 solid;}
.cliBlc > div [i]{
	width:70px;
	height:55px;
	border-<?=$Xalign?>:1px #ccc solid;
	padding:0px 10px;
	
	box-sizing: border-box;
	text-align: center;
}
.cliBlc > div [i] img{
	width:50px;
	height:50px;
	
}
.cliBlc > div [n]{	
	line-height:30px;
	padding:0px 10px;
}
/**/
.patLV > div{
	box-sizing: border-box;
	border: 1px #ccc solid;
	border-<?=$align?>: 8px #ccc solid;
	/*margin: 5px;*/
	padding:10px 0px;
	cursor: pointer;
	height: 100px;
	border-radius: 1px;	
	
}
.patLV > div[s1]{border-<?=$align?>: 6px #1cb2f7 solid;background-color:#f5f5ff;}
.patLV > div[s2]{border-<?=$align?>: 6px #e91d62 solid;background-color:#fff5f5;}

.patLV > div[s1]:hover{background-color:#ddf;}
.patLV > div[s2]:hover{background-color:#fdd;}
.patLV div[i]{width:80px; text-align: center;}

.patLV div[np]{
	border: 1px <?=$clr1?> solid;	
	color: #fff;
	background-color: <?=$clr1?>;
}
.patLV div[np]:hover{background-color: <?=$clr1111?>;}
/**************************/
.reDocList > div{
	box-sizing: border-box;
	border: 1px #aaa solid;
	border-<?=$align?>: 8px #aaa solid;
	/*margin: 5px;*/
	padding:10px 0px;
	cursor: pointer;
	height: 80px;
	border-radius: 1px;	
	/*float:<?=$align?>;*/
	background-color: #fff;
	cursor:auto;	
}
.reDocList > div:hover{
    background-color:#eee;
    cursor: pointer;
}
.reDocList div[i]{width:60px; text-align: center;}
.srvTotal{
	background: url(images/rec/rec_new_pay.png) <?=$clr66?> no-repeat <?=$align?> center;
	width:140px;
	height: 40px;
	line-height: 40px;	
	text-align: center;
	color: #fff;
	text-indent:40px;
}
.srvEmrg{
	background: url(images/rec/rec_emrg.png) <?=$clr3?> no-repeat <?=$align?> center;
	width:140px;
	height: 40px;
	line-height: 40px;	
	text-align: center;
	color: #fff;
	text-indent:40px;
	cursor: pointer;
}
.srvEmrg:hover{background-color: <?=$clr2?>;}
.srvEmrg[s='1']{background-color: <?=$clr5?>;}
.srvEmrg[s='1']:hover{background-color: <?=$clr55?>;}

.pay_icon{
	height: 50px;
	line-height: 50px;
	text-indent:50px;
	color: #fff;
	font-family: 'f1';
	margin-bottom: 10px;
	background-repeat:no-repeat;
	background-position:<?=$align?> center;
}
.ic40_insr{background-image:url(images/gnr/ic40_insr.png);}
.ic40_char{background-image:url(images/gnr/ic40_char.png);}
.ic40_exem{background-image:url(images/gnr/ic40_exem.png);}
.ic40_offer{background-image:url(images/gnr/ic40_offer.png);}
.payBut{
	background:url(images/rec/ic50_pay.png) #f4370c no-repeat center center;
	text-indent: 30px;	
    width: 50px;
    height: 50px;
    border-<?=$Xalign?>: 3px #ccc solid;
}
.payBut:hover{
	background-color: #a8280c;
    cursor: pointer;
}
.payCard{
	background:url("images/gnr/ic50_card.png") #944cbd no-repeat center center;
	text-indent: 30px;	
    width: 50px;
    height: 50px;
    border-<?=$Xalign?>: 3px #ccc solid;
}
.payCard:hover{
	background-color: #760699;
    cursor: pointer;
}
.payMTN{
	background:url("images/rec/mtn.png") #ffca08 no-repeat center center;
	text-indent: 30px;	
    width: 50px;
    height: 50px;
    border-<?=$Xalign?>: 3px #ccc solid;
}
.payMTN:hover{
	background-color: #760699;
    cursor: pointer;
	filter: brightness(0.9);
}
.ic50_del{
	height: 50px;
	width:50px;
	background: url(images/gnr/ic50_del.png) <?=$clr5?> no-repeat center center;
}
.ic50_back{
	height: 50px;
	width:50px;
	background: url(images/gnr/ic50_back.png) <?=$clr8?> no-repeat center center;
}
.ic50_edit{
	height: 50px;
	width:50px;
	background: url(images/gnr/ic50_edit.png) <?=$clr1?> no-repeat center center;
}
.ic50_print{
	height: 50px;
	width:50px;
	background: url(images/gnr/ic50_print.png) <?=$clr1?> no-repeat center center;
}
.ic50_tik{
	height: 50px;
	width:50px;
	background: url(images/gnr/ic50_tik.png) <?=$clr6?> no-repeat center center;
}
.visPatL input{
	height: 30px;
}
/**********************************/
.rec1Blc > div{    
    border-radius:5px;
    padding:0px 10px;    
    border:1px #999 solid;
}
.rec1Blc [ti]{
    font-size: 16px;
    text-align: right;
    font-family: 'f1' , tahoma;
    color: #fff;
    height:50px;
    line-height:50px;
}
.rec1Blc [ti]::before{
    content: '';
    width:40px;
    height:50px;    
    float:<?=$align?> ;
    margin-<?=$Xalign?>:5px;    
}
.rec1Blc [blcss]{
    border-top: 1px #fff solid;    
    text-align:<?=$align?>;    
}
.rec1Blc [blcss] > div{
    border-top: 1px #fff solid;
    background-color: #fff;
    padding-<?=$align?>:10px ;
    margin: 10px 0px;
    font-family: 'f1' , tahoma;
    border-radius: 3px;
    line-height: 35px;
}
.rec1Blc [blcss] > div:hover{
    background-color: #eee;
    cursor: pointer;
}
.rec1Blc [ins_s]::after,.rec1Blc [chr_s]::after,.rec1Blc [ex_s]::after{
    content: '';
    width:35px;
    height:35px;
    background-color: #fff;
    float:<?=$Xalign?> ;    
    border-<?=$align?>:0px #fff solid;  
    margin: 1px;
    box-sizing: border-box;
}
/***************************/
.rec1Blc_1{background-color: #6A988A;}
.rec1Blc_1 [ti]::before{background: url("images/rec/lv_new.png") no-repeat center center;}
/****/
.rec1Blc_2{background-color: #11226d;}
.rec1Blc_2 [ti]::before{background: url("images/gnr/ic40_insr.png") no-repeat center center;}
.rec1Blc_2 [ins_s='0']::after{background: url("images/gnr/ic30_done0.png") center center;}
.rec1Blc_2 [ins_s='1']::after{background: url("images/gnr/ic30_done1.png") center center;}
.rec1Blc_2 [ins_s='2']::after{background: url("images/gnr/ic30_done2.png") center center;}
/****/
.rec1Blc_3{background-color: #48246a;}
.rec1Blc_3 [ti]::before{background: url("images/gnr/ic40_char.png") no-repeat center center;}
.rec1Blc_3 [chr_s='0']::after{background: url("images/gnr/ic30_done1.png") center center;}
.rec1Blc_3 [chr_s='1']::after{background: url("images/gnr/ic30_done2.png") center center;}
/****/
.rec1Blc_4{background-color: #8a2068;}
.rec1Blc_4 [ti]::before{background: url("images/gnr/ic40_exem.png") no-repeat center center;}
.rec1Blc_4 [ex_s='0']::after{background: url("images/gnr/ic30_done1.png") center center;}
.rec1Blc_4 [ex_s='1']::after{background: url("images/gnr/ic30_done2.png") center center;}
/****/
.rec1Blc_5{background-color: #B52E2E;}
.rec1Blc_5 [ti]::before{background: url("images/gnr/ic40_lab.png") center center;}
/****/
.rec1Blc_6{background-color: #5F74D3;}
.rec1Blc_6 [ti]::before{background: url("images/gnr/ic40_xry.png") center center;}
/****/
.rec1Blc_7{background-color: #4CA288;}
.rec1Blc_7 [ti]::before{background: url("images/gnr/ic40_app.png") center center;}
/**********************/
.visWBlc{
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
.visWBlc[s0] div,.visWBlc[s3] div{opacity: 0.8;}
.visWBlc[s1]{border-color:<?=$clr8?>;}
.visWBlc[s1]:hover{background-color:<?=$clr888?>;}
.visWBlc[s1] span{color:<?=$clr1?>;}
.visWBlc[s2]{border-color:<?=$clr6?>;}
.visWBlc[s2]:hover{background-color:<?=$clr666?>;}
.visWBlc[s2] span{color:<?=$clr6?>;}
.visWBlc[s3]{background-color:<?=$clr7?>;}
.visWBlc[s4]{border-color:<?=$clr5?>;}
.visWBlc[s4]:hover{background-color:<?=$clr555?>;}
.visWBlc[s4] span{color:<?=$clr5?>;}

.visWBlc[s5]{border-color:#ea992f;}
.visWBlc[s5]:hover{background-color:#fbe5c9;}
.visWBlc[s5] span{color:#ea992f;}
/**********************/
.ana_list_catN > div{
    background-color: #fff;
    line-height: 40px;
    border: 1px #ccc solid;
    margin-bottom:5px;
    padding-<?=$align?>:10px;
    font-family: 'f1' ,tahoma;
    cursor: pointer;
    border-radius: 2px;
}
.ana_list_catN > div:hover{
    background-color: #eee;
    border: 1px #ccc solid;
    
}
.ana_list_catN > div[act]{    
    color: #fff;
    background: url("images/sys/arr_w_<?=$align?>.png")  #973155 no-repeat <?=$Xalign?> center; 
    padding: 0px 10px;
    background-origin: content-box;
}

.ana_list_mdcN > div{
    line-height: 30px;
    border: 1px #ccc solid;
    margin-bottom:5px;
    padding-<?=$align?>:10px;
    font-family: 'f1' ,tahoma;
    cursor: pointer;
    border-radius: 2px;
    color: #fff;
    font-size: 14px;
    background: url("images/sys/arr_w_<?=$align?>.png")  #de632d no-repeat <?=$Xalign?> center; 
    padding: 5px 10px;
    background-origin: content-box;
}
.ana_list_mdcN > div:hover{ background-color:#be4e1d; }
.soL1::-webkit-scrollbar-thumb {background-color: #973155;}
.soL1::-webkit-scrollbar-thumb:hover{background-color:#b7114b;}

.soL2::-webkit-scrollbar-thumb {background-color: #de632d;}
.soL2::-webkit-scrollbar-thumb:hover{background-color:#ed500a;}

.soL3::-webkit-scrollbar-thumb {background-color: #7dc67d;}
.soL3::-webkit-scrollbar-thumb:hover{background-color:#5cb85c;}
    
.winLabTmp{
    <?=$Xalign?>:10px;
    position: absolute;
    width: 280px;
    height:180px;
    max-height:50%;
    margin-top: 40px;
    background-color: #fff;
    border:1px #ccc solid;
    box-shadow: 0px 5px 10px #999;
    display: none;
    padding: 20px;
    box-sizing: border-box; 
    z-index: 2;
}
.overTr tr:hover td:first-child{    
    border-<?=$align?>:6px <?=$clr6?> solid;    
    cursor: pointer;
}
.denActC{
   width: 100%;   
   max-width: 500px;
}
[recAlr][mood]{
    background-color: #fff;
    margin-bottom:10px;
    line-height: 25px;
    font-family: 'f1' ,tahoma;
    cursor:pointer;
    border-<?=$align?>-width: 6px;
    border-<?=$align?>-color: #999;
    border-<?=$align?>-style: solid;
    color:#333;
    border-radius: 2px;
    background-origin: border-box;
    position: relative;
    padding:10px 0px; 
    padding-<?=$align?>:10px; 
    padding-<?=$Xalign?>:40px;
}
[recAlr][mood='1']{border-<?=$align?>-color:var(--CT1);}
[recAlr][mood='2']{border-<?=$align?>-color:var(--CT2);}
[recAlr][mood='22']{border-<?=$align?>-color:<?=$clr5?>;color:<?=$clr5?>}
[recAlr][mood='3']{border-<?=$align?>-color:var(--CT3);}
[recAlr][mood='4']{border-<?=$align?>-color:var(--CT4);}
[recAlr][mood='5']{border-<?=$align?>-color:var(--CT5);}
[recAlr][mood='6']{border-<?=$align?>-color:var(--CT6);}
[recAlr][mood='7']{border-<?=$align?>-color:var(--CT7);}
[recAlr][mood][s]::before{
    content: '';
    width:35px;
    height:35px;    
         
    margin:0px 5px;
    margin-top: -5px;
    <?=$Xalign?>: 0px;
    position: absolute;
    
}
[recAlr][mood]:hover{        
    cursor:pointer;
    box-shadow: 0px 0px 5px #999;
    border-<?=$align?>-width: 10px;
}
[recAlr][mood][s='0']::before{background: url("images/gnr/ic30_done1.png") center center;}
[recAlr][mood][s='1']::before{background: url("images/gnr/ic30_done2.png") center center;}
.notsTab > div{
    border-<?=$Xalign?>:1px #ccc solid;
    padding:0px 10px;
    height: 32px;
    line-height: 32px;
    box-sizing: border-box;
}
.notsTab > div::before{
    content:'';
    height: 20px;
    width: 20px;
    margin:6px;
    margin-<?=$align?>:0px;
    border-radius: 10px;    
    float:<?=$align?>;
}
.notsTab > div[s1]::before{background-color: #ddd;}
.notsTab > div[s2]::before{background-color: #f4ec8d;}
.notsTab > div[s3]::before{background-color: #8dbdf4;}
.notsTab > div[s4]::before{background-color: #a0ea78;}
.notsTab > div[s5]::before{background-color: #fcbb7a;}
.notsTab > div[s6]::before{background-color: #ee7575;}

.notsTab > div[s11]::before{background-color: #6A988A;}
.notsTab > div[s12]::before{background-color: #4CA288;}
.notsTab > div[s13]::before{background-color: #11226d;}
.notsTab > div[s14]::before{background-color: #48246a;}
.notsTab > div[s15]::before{background-color: #8a2068;}
.notsTab > div[s16]::before{background-color: #B52E2E;}
.notsTab > div[s17]::before{background-color: #5F74D3;}
    
.clnLis div{
    line-height:20px;
    padding: 10px;
    line-height: 20px;
    background-color: #eee;
    
    color: #666;
    font-family:'f1',tahoma;
    border-radius: 2px;
    margin-bottom: 5px;
}
.clnLis div:hover{
    background-color:<?=$clr444?>;
    cursor: pointer;
}
.clnLis div[act]{
    background-color:<?=$clr7?>;23
}
.clnLis2 div{
    line-height:20px;
    padding: 10px;
    line-height: 20px;
    background-color: <?=$clr6?>;
    color:#fff;
    font-family:'f1',tahoma;
    border-radius: 2px;
    margin-bottom: 5px;
}
.clnLis2 div:hover{
    background-color:<?=$clr66?>;
    cursor: pointer;
}
.clnLis2 div[act]{
    background-color:<?=$clr66?>;
}
@media only screen and (max-width:800px) {
	.recTabs > div{        
        width: 50px;
        font-size: 0px;
    }
    .recOprs > div{
        width: 50px;
        font-size: 0px;
    }
    .addRecOpr div{
        width: 50px;
        height: 50px;
        float: <?=$align?>;
        box-sizing: border-box;
        padding-top: 0px;
        font-family: 'f1';
        font-size: 0px;
              
    }
    .addRecOpr div[v],.addRecOpr div[d]{background-image:url(images/paus.png);}
    .recStatus{width:50px;}
    .recStatus [i]{
        float:<?=$align?>;
        width: 50px;
        height: 50px;
        background-color: #444;
        background-position: center center;
        background-repeat: no-repeat;
        border-top:1px #ccc solid;
    }
    .recStatus [i][p]{width: 50px;height: 50px;background-image:url(images/rec/rec_st1.png);}
    .recStatus [i][m]{width: 50px;height: 50px;background-image:url(images/rec/rec_st2.png);}
    .recStatus [v]{display: none;}
    .recOprWin {margin-<?=$align?>:50px;}
}
.wh50{
    width:50px;
    height: 50px;
    box-sizing: border-box;
    
}
.viewAll{
    background: url("images/gnr/ic30_done0.png") <?=$clr7?> center -4px;
    height: 30px;
    margin-top: -10px;
    float: <?=$align?>;
    padding: 0px;
}
.viewAll:hover{
    background-color:<?=$clr77?>;
    cursor: pointer;
}
    
.visList[mood]{
    background-color: #fff;
    margin-bottom:10px;
    line-height: 45px;
    font-family: 'f1' ,tahoma;
    padding-<?=$align?>:10px; 
    border-<?=$align?>-width: 6px;
    border-<?=$align?>-color: #999;
    border-<?=$align?>-style: solid;
    color:#333;
    border-radius: 2px;
    background-origin: border-box;
    position: relative;
}
.visList[mood]:hover{background-color:#f5f5f5; cursor: pointer}
.visList[mood='1']{border-<?=$align?>-color:var(--CT1);}
.visList[mood='2']{border-<?=$align?>-color:var(--CT2);}
.visList[mood='3']{border-<?=$align?>-color:var(--CT3);}
.visList[mood='4']{border-<?=$align?>-color:var(--CT4);}
.visList[mood='5']{border-<?=$align?>-color:var(--CT5);}
.visList[mood='6']{border-<?=$align?>-color:var(--CT6);}
.visList[mood='7']{border-<?=$align?>-color:var(--CT7);}

.visList[mood][act]{color:#fff;}
.visList[mood='1'][act]{background-color:var(--CT1);}.visList[mood='1'][act] > div{border-color:var(--CT1);}
.visList[mood='2'][act]{background-color:var(--CT2);}.visList[mood='2'][act] > div{border-color:var(--CT2);}
.visList[mood='3'][act]{background-color:var(--CT3);}.visList[mood='3'][act] > div{border-color:var(--CT3);}
.visList[mood='4'][act]{background-color:var(--CT4);}.visList[mood='4'][act] > div{border-color:var(--CT4);}
.visList[mood='5'][act]{background-color:var(--CT5);}.visList[mood='5'][act] > div{border-color:var(--CT5);}
.visList[mood='6'][act]{background-color:var(--CT6);}.visList[mood='6'][act] > div{border-color:var(--CT6);}
.visList[mood='7'][act]{background-color:var(--CT7);}.visList[mood='7'][act] > div{border-color:var(--CT7);}

.visList[mood] > div{
    position: absolute;
    <?=$Xalign?>: 0px;
    width: 25px;
    height: 25px;
    line-height: 25px;
    margin-top: -4px;
    margin-<?=$Xalign?>: -5px;
    background-color: #B91114;
    text-align: center;
    font-family: 'ff',tahoma;
    font-size: 14px;
    font-weight: bold;
    border-radius: 15px;
    color: #fff;
    border:3px #fff solid;

}
.visList[mood] > div[r1]{background-color: #B91114;}
.visList[mood] > div[r2]{background-color: #DD7678;}
.visList[mood] > div[r3]{background-color: #E1BB4C;}
.visList[mood] > div[r4]{background-color: #65E764;}
.visList[mood] > div[r5]{background-color: #338230;}
    
.revStars{height:30px; box-sizing: border-box;}
.revStars div[v]{
	background-color: #ccc;
	float: <?=$align?>;
	height:30px;
    cursor: pointer;
}
.revStars div img{height: 28px;}
    
    
.CMbg1{background-color:var(--CT1);}.CMclr1{color:var(--CT1);}
.CMbg2{background-color:var(--CT2);}.CMclr2{color:var(--CT2);}
.CMbg3{background-color:var(--CT3);}.CMclr3{color:var(--CT3);}
.CMbg4{background-color:var(--CT4);}.CMclr4{color:var(--CT4);}
.CMbg5{background-color:var(--CT5);}.CMclr5{color:var(--CT5);}
.CMbg6{background-color:var(--CT6);}.CMclr6{color:var(--CT6);}
.CMbg7{background-color:var(--CT7);}.CMclr7{color:var(--CT7);}
    
.rateBg1{background-color: #B91114;}.rateClr1{color: #B91114;}
.rateBg2{background-color: #DD7678;}.rateClr2{color: #DD7678;}
.rateBg3{background-color: #E1BB4C;}.rateClr3{color: #E1BB4C;}
.rateBg4{background-color: #65E764;}.rateClr4{color: #65E764;}
.rateBg5{background-color: #338230;}.rateClr5{color: #338230;}
    
.prvOprList{background-color: #1e1f23;width:50px;}
.prvOprList > div{
	width:50px;
	height:50px;
	float: <?=$align?>;
	background-color: #444;	
	border-bottom:1px #666 solid;
}
.prvOprList > div:hover{background-color:#666;cursor:pointer;}
.prvOprList > div:hover div[t]{display: block;}
.prvOprList div[ic]{
	width:50px;
	height:50px;
	float: <?=$align?>;	
	background-repeat: no-repeat;
	background-image: url(images/prv_top_ic.png);
	border:0px;
	border-bottom:1px #666 solid;	
}
.prvOprList div[t]{
	width:150px;
	height:50px;
	float:<?=$align?>;	
	background-repeat: no-repeat;	
	border:0px;
	border-bottom:1px #666 solid;
	position: absolute;
	background-color: #666;
	margin: 0px -150px;
	text-align: center;
	line-height: 50px;
	color: #fff;
	font-family:'f1';
	z-index:3;
	display:none;
	border-<?=$align?>:1px #666 solid;
}
.prvOprList div[act]{
	width:5px;
	height:5px;	
	position:absolute;	
	margin-top:2px;
	margin-<?=$align?>:40px; 
	text-align: center;
	z-index:2;
	border-radius:5px;
}
.prvOprList div[act=off]{background-color: #666;}
.prvOprList div[act=on]{background-color:#FF0004;}
.prvOprList div[ic].prvTop_denOpr{
    background-repeat: no-repeat;	
    background-image:url(images/den/iconOpr.png);
    background-position: 0px 0px;
    background-size: 50px auto;
}
[nursOprs] >div[act] , [nursOprs] >div:hover{
    background-color: #E8DC70;
    cursor: pointer;
}
</style>