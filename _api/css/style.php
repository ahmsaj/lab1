<? session_start();/***API***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
.SNPrograss{
    height: 10px;
    background-color: #eee;
    width: 100%;
    margin-bottom: 10px;    
}
.SNPrograss div{height: 10px;}
.SNPrograss div[o]{background-color: #4BCF62;}
.SNPrograss div[e]{background-color: #DF5959;}
.chatList{
    border-radius: 5px;   
    border: 1px #ddd solid;
}
.chatList[act]{
    background-color:#E1F3C8;
    border: 1px #999 solid;
}
.chatList[act]:hover{
    background-color:#DEF7BB;
}
.chatList:hover{
    cursor: pointer;
    background-color:#f5f5f5;
}
.chatList [n]{
    border-radius: 50%;
    height:20px;
    line-height: 20px;
    min-width:20px;
    background-color:<?=$clr5?>;
    text-align: center;
    color: #fff;
}
.chatList [n='0']{
    display: none;
}
.mesIn{padding: 40px;}
.mesIn [t]{
    margin-bottom: 10px;
    width:100%;
    float:<?=$align?>;
    clear: both;
    display: inline;
    width: 100%;
    box-sizing: border-box;
    max-width: 650px;    
}
.mesIn [t] > div{
    max-width:300px;
    min-width:150px;
    border-radius:5px;
    padding: 10px;
    border: 1px #eee solid;
    line-height:20px;
    font-family: 'f1',tahoma;
}
.mesIn [t='1'] div{
    text-align:<?=$align?>;
    background-color: #E0F4F7;
    float:<?=$Xalign?>;
}
.mesIn [t='2'] div{
    text-align:<?=$align?>;    
    background-color: #E4F1D7;
    float:<?=$align?>;
}
.mesIn [t='3']{
    width: 100%;
    text-align:center;    
    background-color: #eee;
    margin:10px auto;
    padding: 10px; 0px;
    border-radius:5px;
    font-family: 'f1',tahoma;
}
.mesIn [t='4'] div{
    text-align:<?=$align?>;    
    float:<?=$align?>;  
    background-color: #eee;
}
.mesIn [t] > div > div{
    width: 100%;
    font-size: 10px;
    line-height: 20px;
    color: #999;
    background-position:<?=$Xalign?> center;
    background-repeat:no-repeat;
}  
.mesIn [t][s='0'] div div{background-image:url("images/r0.png");}
.mesIn [t][s='1'] div div{background-image:url("images/r1.png");}
.mesIn [t][s='2'] div div{background-image:url("images/sys/loader.gif");}
.blcCaht{
    position: absolute;
    width: 100%;
    height: 100%;
    text-align: center;
    background-color:rgba(255,255,255,1); 
    display: none1;
}
.blcCaht > div{        
    width: 100%;
    text-align: ;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    position: relative;
}
.blcCaht > div > div{
    margin: 0px auto;
    width:400px;
    background:url("images/preloader3.gif") #eee;
    border-radius: 10px;
    padding:10px;
    color:#fff;
    
}
#api_data input{
    height: 30px;
}
.docLinks div[t]{
    
}
.docLinks div[t]:hover{
	background-color: #eee;
	cursor: pointer;
}
.docLinks .act{
	background-color: #999;
	color: #fff;
}
.docLinks  div[t].act:hover{
	background-color: #666;
}
.complList[st="0"]{background-color: #fff;}
.complList[st="1"]{background-color: #f5f7b6;}
.complList[st="2"]{background-color: #C7E4F9;}
.complList[st="3"]{background-color: #c7f9c8;}
</style>