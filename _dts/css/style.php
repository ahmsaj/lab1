<? session_start();/***DTS***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.ti_date{background:url(images/mad_icon2.png) no-repeat -420px top;}
.ti_date:hover{background-position:-420px bottom;}

#nd_c{width: 100%;}
.cli_icon4{	
	width:80%;	
	margin:5px auto;
}
.dat_list{
	box-sizing: border-box;
	border: 1px #ccc solid;
	padding: 10px;
	padding-top: 5px;
	margin-bottom: 10px;
	border-radius: 2px;
	width:100%;
	
}
.dat_list:hover{background-color: #eee;cursor: pointer; }
.dat_list[act],.dat_list[act]:hover{background-color: <?=$clr44?>;
border-bottom:5px <?=$clr1?> solid;cursor:auto;}	

.dat_list_icon{
	width: 44px;
	height: 40px;
	border-<?=$Xalign?>:1px <?=$clr1?> solid;
}
[Ctxt][act]{background-color: <?=$clr44?>;}
[Ctxt][act]:hover{background-color: <?=$clr4?>;}

.dt_he1{
	width:200px;

	box-sizing: border-box;
}
.dt_lines{
	width: 100%;}
.dt_lines > div{
	width: 100%;
	border-bottom:1px #ccc solid;	
	box-sizing: border-box;	
}
.dt_lines > div:first-child{border-top:1px #ccc solid;}
.dt_lines div[t]{
	border-left:1px #ccc solid;
	border-right:1px #ccc solid;
	box-sizing: border-box;
	height: 60px;
	width: 100px;
	text-align: center;
	line-height:20px;
	background-color: #999;color:#fff;
	padding-top: 10px;
	font-size: 14px;
}
.dt_lines div[c]{	

}
.dt_point{
	width:100%;
	height:30px;	
	margin-right: 99px;
}
.dt_point > div{
	font-size: 12px;
	height:30px;
	line-height: 30px;
	text-indent: 3px;

}
.dblc{
	box-sizing: border-box;
	height:60px;
	border-<?=$Xalign?>:1px #ccc solid;
}

.dblc_s1{background-color: #eee;}
.dblc_basy{background-color: <?=$clr1?>;background-image:url(images/date_e1.png);}

.dblc_1{background-color: #F4ED8E;border-<?=$Xalign?>:1px #ccc solid;}.dblc_1:hover{background-color: #f5ec74; cursor: pointer;}
.dblc_2{background-color: #faa;border-<?=$Xalign?>:1px #ccc solid;}
.dblc_3{background-color: #B5B8F7;border-<?=$Xalign?>:1px #ccc solid;}
.dblc_4{background-color: #ed9191;border-<?=$Xalign?>:1px #ccc solid;}

.sDoc0{border-bottom: 5px #ccc solid;}
.sDoc1{border-bottom: 5px #52CB6B solid;}
.slidBar{	
	box-sizing: border-box;
	height:60px;
	border:1px #ccc solid;
	background-color: #F4ED8E;	
	width: 100%;
}
.slidBar > div{
	box-sizing: border-box;
	height:58px;
	background-color:<?=$clr111?>;
	background-image:url(images/date_e1.png);
	width:1%;
	border-left:1px #ccc solid;
	border-rigth:1px #ccc solid;
}
.slidBar_t div {
	margin-top: 20px;
	line-height: 30px;
	font-size: 18px;
	font-family: 'ff';
	font-weight:bold;
	
}
.slidBar_b{
	box-sizing: border-box;
	border-left:1px #ccc solid;
	border-right:1px #ccc solid;
	height: 20px;
	width: 100%;	
}
.slidBar_b div{ padding: 5px;padding-top: 3px;}

.dt_pat_list{
	box-sizing: border-box;
	width:200px;
	border-<?=$Xalign?>:1px #ccc solid;	
	margin-<?=$Xalign?>: 5px;
	padding-<?=$Xalign?>: 15px;
}
.dt_pat_list_r{	
	padding-<?=$Xalign?>: 5px;
}
.plistD > div{
	box-sizing: border-box;
	border: 1px #ccc solid;
	border-<?=$align?>: 5px #ccc solid;
	margin: 5px;
	padding: 5px;
	cursor: pointer;
	height: 50px;
	border-radius: 1px;	
}
.plistD div[n]{text-align:<?=$Xalign?>;}
.plistD > div:hover{
	background-color: <?=$clr44?>;
	border: 1px <?=$clr1?> solid;
	border-<?=$align?>: 5px <?=$clr1?> solid;
}
.plistD div[np]{

	border: 1px <?=$clr1?> solid;
	border-<?=$align?>: 5px <?=$clr1?> solid;
	color: #fff;
	background-color: <?=$clr1?>;
}
.plistD div[np]:hover{background-color: <?=$clr1111?>;}


.dateResTimer{padding: 10px;padding-<?=$align?>:0px;;position: relative;}
.drt_row{
	box-sizing: border-box;		
	border:1px #ccc solid;
	border-bottom: 0px;
	height: 40px;		
}
.drt_row:last-of-type{border-bottom:1px #ccc solid;}	
.drt_row .ic{
	box-sizing: border-box;		
	border-<?=$Xalign?>:1px #ccc solid;
	padding: 5px;
	height: 40px;		
	background-color:#eee;
	width:40px;
}
.drt_row .ic:hover{background-color:<?=$clr44?>;cursor: pointer;}	
.drt_row .ti{
	box-sizing: border-box;
	height: 39px;
	width: 100%;
	position: relative;
}
.drt_rowHead{
	box-sizing: border-box;
	position: fixed;
	z-index:2;
	background-color: #fff;
	margin: 0px;
	margin-<?=$align?>:0px;
	border-bottom:1px #ccc solid;
	height: 20px;
}
.drt_row2{
	box-sizing: border-box;
	height: 20px;
	margin-<?=$align?>:40px;	
}
.drt_row2  div{
	box-sizing: border-box;
	border-<?=$align?>:1px #ccc solid;
	height:20px; 
	line-height:20px;
	
}
.visRowsDate{	
	border: 1px #ccc solid;
	width: 100%;
	margin-bottom: 10px;
	box-sizing: border-box;
	border-bottom: 2px #ccc solid;
	background-color: #666;
}
.visRowsDate div[a]{
	line-height: 40px;
	height: 40px;
	width:80px;
	font-size: 20px;			
	color:#fff;
	box-sizing: border-box;	
	background-color: #666;
}
.visRowsDate div[a1]{background-color: #ccc;}		
.visRowsDate div[b]{
	line-height: 35px;
	height: 35px;
	font-size: 16px;					
	box-sizing: border-box;
	text-align: center;
}
.visRowsDate div[c]{
	line-height: 20px;
	height: 25px;
	font-size: 14px;				
	box-sizing: border-box;
	text-align: center;			

}
.stsS_1{background-color: #eee;color:#999;}
.stsS_2{background-color: #faf7b2;}
.stsS_3{background-color: #b2edfa;}

.dateLinSW{
	border:1px #ccc solid;
	padding: 10px;
	background-color: #eee;

}
.dtsPointer{		
	height:40px;				
	position: absolute;		
	background-color: #fff5f5;		
	z-index: -1;
	box-sizing: border-box;
	border-<?=$Xalign?>:1px #f00 solid;
}
.dts_bl{
	box-sizing: border-box;
	height:40px;		
	border:1px #ccc solid;
	cursor: pointer;
}	
.dts_bl_1{background-color: #ddd;}
.dts_bl_2{background-color: #f4ec8d;}
.dts_bl_3{background-color: #8dbdf4;}
.dts_bl_4{background-color: #a0ea78;}
.dts_bl_5{background-color: #ee7575;}
.dts_bl_6{background-color: #ee7575;}
.clsDate{
	border:1px #ccc solid;
	width: 100%;			
	margin-bottom: 10px;
	box-sizing:border-box;
	background-color: #f7f69f;

}
.clsDate div[a]{
	width:50px;
	background-color: #535353;
	color: #fff;
	line-height: 30px;
	text-align: center;
}
.clsDate div[b]{			
	text-align: center;
	line-height: 30px;
}
.dInfo{
	background-color:<?=$clr2?>;
	width: 40px;
	height: 20px;
	line-height: 20px;
	text-align: center;
	color: #fff;
	font-family:'f214';
	font-size: 14px;	
}
.dInfo:hover{background-color:<?=$clr1?>;cursor: pointer;}
.denPrBar{
	width:100%;
	background-color: #eee;		
}
.denPrBar div{		
	height: 10px;	
	
}
/******new******/
.dts_list{
	box-sizing: border-box;
	border: 1px #ccc solid;
	padding: 10px;
	padding-top: 5px;
	margin-bottom: 10px;
	border-radius: 2px;
	width:100%;
    border-<?=$align?>:5px <?=$clr9?> solid;
}
.dts_list:hover{
    background-color: #eee;cursor: pointer; 
}
.dts_list[act],.dat_list[act]:hover{
    background-color: <?=$clr666?>;
    border-<?=$align?>:5px <?=$clr6?> solid;
    cursor:auto;
}
.dtsTab{border-collapse:collapse;}
.dtsTab th{
	height:20px;
	border-bottom:1px solid #ccc;
    background-color:#fff;
}
.dtsTab th > div{
    position: absolute;    
    width: 100%;
    z-index:0;
    overflow: hidden;
    height:100%;
}
.dtsTab th > div > div{	
    line-height:20px;
    height:100%;
	font-family:'ff' , tahoma;
	font-size:10px;
	font-weight:normal;
    font-size:16px;
    border-<?=$align?>:1px solid #ccc;
    box-sizing: border-box;
    text-align: <?=$align?>;
    text-indent: 4px;
    z-index:1;
    font-weight: bold;
    overflow: hidden;    
}

.dtsTab  td{
	height:40px;
	color:#fff;
	border:1px solid #ccc;
	text-align:center;
    position: relative;
    z-index: 2;
}
.dtsTab td > div{
    position: relative;        
    opacity: 0.7;
}
.dtsTab td  div:hover{    
    opacity:0.9;    
}
#dts_Mload{
    position: relative;
    z-index:5;
}
.dtsTab .dblc{
	box-sizing: border-box;
	height:40px;
	border-<?=$Xalign?>:0px #000 solid;
}
.dtsTab .dblc_s1{background-color: #eee}
.dtsTab .dblc_1{
    background: url("images/gnr/dtsS1.png") #F4ED8E no-repeat <?=$align?> top;
    color:#333;
    font-size: 18px;
    text-align: <?=$align?>;
    text-indent: 4px;
}
.dtsTab .dblc_1:hover{
    background-color: #f5ec74;
    cursor: pointer;
    border:5px #F1EDBA solid;
    box-shadow:0px 0px 15px #999;
    z-index: 15
}
.dtsTab .dblc_2{    
    background: url("images/gnr/dtsS2.png") #faa no-repeat <?=$align?> top;
}
.dtsTab .dblc_3{background-color: #B5B8F7;}
.dtsTab .dblc_4{background-color: #ed9191;}

.dtsTab .sDoc0{border-bottom: 0px #ccc solid;}
.dtsTab .sDoc1{border-bottom: 0px #999 solid;}
.dtsTab .dblc_basy{
    height: 40px;  
    background-color:#fff;;
    background-image:url();
    z-index: 2;
}
.dtsTab .dblc_basy1{
    height: 25px;    
    background:url(images/gnr/dtsS3.png) #57a3ce no-repeat <?=$align?> top;
    width:100%
}
.dtsTab .dblc_basy1[f]{
    height: 40px;    
}
.dtsTab .dblc_basy2{
    height: 15px;
    background:url(images/gnr/dtsS3.png) #fc9f2d no-repeat <?=$align?> center;
    width:100%
}
.dtsTab .dblc_basy3{
    height: 15px;
    background:url(images/gnr/dtsS1.png) #ccc no-repeat <?=$align?> center;
    width:100%
}
.dtsTab .dblc_basy4{
    height: 15px;
    background: url("images/gnr/dtsS2.png") #F175C2 no-repeat <?=$align?> center;
    width:100%
}
.dtsSliderBlcs{
    box-sizing: border-box;
    position: absolute;
    z-index: 1;
}
.dtsSliderBlcs div[b]{
    box-sizing: border-box;
    border-<?=$Xalign?>:1px #ccc solid;
    height: 70px;
    line-height:20px;
    overflow: hidden;
    text-indent: 3px;
    color: #888;
}
.timeLine{
    float:<?=$align?>;
    background-color:rgba(245,18,20,.3);
    height: 20px;
    position: absolute;
    border-<?=$Xalign?>: 1px #f00 solid

}
.dtsSliderBlcs div:last-child{    
    border-<?=$Xalign?>:0px #ccc solid;
}
.dtsSlider,.dtsSlider2{
    margin-top:19px;
    border-top:1px #ccc solid;
    border-bottom:1px #ccc solid;
    height: 51px;
    position: relative;
}
.dtsSlider > div{
    height: 50px;
    background-color:<?=$clr1?>;
    background: url("images/date_e2.png") <?=$clr1?>;
    z-index: 2;    
}
.dtsSlider2{
    margin-top:0px;
    border-top:0px #ccc solid;
    border-botom: 1px #ccc solid;
    height:31px;
}
.dtsSlider2  div{
    height:30px;       
    z-index: 2;    
}
.dtsSlider > div:hover{
    cursor: e-resize;
    opacity: .7;
}
.dtsSlider > div > div{
    width: 100%;
    background-color: rgba(255,0,4,.2);
    box-sizing: border-box;
    height: 20px;    
    margin-top: -20px;    
    position:absolute;
}
 /*************************************/
.dtsTabR{border-collapse:collapse;}
.dtsTabR th{
	height:20px;
	border-bottom:2px solid #ccc;
    background-color:#fff;
}
.dtsTabR th > div{
    position: absolute;    
    width: 100%;
    z-index:0;
    overflow: hidden;
    height:100%; 
    
}
.dtsTabR [cl]{  
    text-align: <?=$Xalign?>;    
}
.dtsTabR th > div > div{	
    line-height:22px;
    height:100%;
	font-family:'ff' , tahoma;
	font-size:10px;
	font-weight:normal;
    font-size:16px;
    border-<?=$align?>:1px solid #eee;
    box-sizing: border-box;
    text-align: <?=$align?>;
    text-indent: 4px;
    z-index:1;
    font-weight: bold;
    overflow: hidden;    
}
.dtsTabR th > div > div:nth-child(1){
    border-<?=$align?>:1px solid #ccc;
}
.dtsTabR td{
	height:40px;    
	color:#fff;
	border-bottom:1px solid #eee;
	text-align:center;
    position: relative;
    z-index: 2;
    
}
.dtsTabR td[clinc]{
    width: 40px;
    opacity:1;
}
.dtsTabR td[clinc] img{
    margin-top: 5px;
	width:30px;
    height: 30px;
    opacity: 1;    
}
.dtsTabR td > div{
    height:40px;
    position: relative;        
    opacity: 0.7;
    z-index: 1;
}
.dtsTabR td  div:hover{    
    opacity:0.9;    
}
.dtsTabR td[dtsClinc]:hover{
    background-color: #CDC66A;
    cursor: pointer;
}
.dtsTabR td > div[c]{
    opacity: 1;
    z-index: 1;
    width:30px;
    height: 30px;
    margin: 5px auto;
}
.dtsPointerN{					
	position: absolute;		
	background-color: rgba(253,192,193,.2);		
	z-index: -1;
	box-sizing: border-box;
	border-<?=$Xalign?>:1px #f00 solid;    
}
.dtsPointerN > div {
    float:<?=$Xalign?>;
    font-family:'ff' , tahoma;
    font-size: 14px;
    background-color:<?=$clr55?>;
    color:#fff;
    padding:0px 6px;    
    text-align:center;    
}
[dtsBlc] div{            
    box-sizing: border-box;    
}
.dtb,.dtb2{
    box-sizing: border-box;
    cursor: pointer;
    border-left:1px solid rgba(255,255,255,.8);
    background-color: #eee;
}
.dtb_in1{
    height:25px;
    border-bottom:1px solid rgba(255,255,255,.8);
    border-left:0px solid rgba(255,255,255,.8);
}   
.dtb_in2{
    height:15px;
    border-left:0px solid rgba(255,255,255,.8);
    filter: brightness(1.1);
}   
.dtb:hover,.dtb_in1:hover,.dtb_in2:hover{
    box-shadow:0px 0px 10px #aaa;
    z-index: 15;
    cursor: pointer;
    filter: brightness(0.95);
    border:3px solid rgba(255,255,255,.8);
}

.dtb1{background-color: #ddd;}
.dtb2{background-color: #f4ec8d;}
.dtb3{background-color: #8dbdf4;}
.dtb4{background-color: #a0ea78;}
.dtb5{background-color: #ee7575;}
.dtb6{background-color: #ee7575;}
.clsDateN{
	border:1px #ccc solid;
	width: 100%;			
	margin-bottom:5px;
	
	background-color:#fff;
    line-height:40px;
    border-radius:1px;
}
.clsDateN div[a]{
	width:50px;
	background-color: rgba(0,0,0,.5);
	color: #fff;
	line-height:30px;
	text-align:center;
    line-height:40px;
    border-radius:1px;
}
.clsDateN div[b]{			
	text-align: center;
	line-height:40px;

}
    