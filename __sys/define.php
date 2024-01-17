<?php /***SYS***/
include("../__sys/mods/protected.php");
$ProVer=$projectVersion;
$f_path=_path.$lg.'/';
$m_path=_path;
$Xalign=k_Xalign;
$align=k_align;
/////--------------info----------------------------
$sql="select `code`,`value_$lg` from _information ";
$res=mysql_q($sql);$rows=mysql_n($res);
while($r=mysql_f($res)){$s_id=$r['code'];$s_value=$r['value_'.$lg];
define('_info_'.$s_id,$s_value);}
/////--------------setting---------------------
$sql="select `code`,`val` from _settings ";
$res=mysql_q($sql);$rows=mysql_n($res);
while($r=mysql_f($res)){$s_id=$r['code'];$s_value=$r['val'];define('_set_'.$s_id,get_key($s_value));}
$_SESSION['blc_sel']=_set_auksyptkd;
define('_F_notes',_set_t79d32mpq9);
define('_listMin',_set_h2m94u475x);
define('_listMinSer',_set_xl6bb1581m);
//$_SESSION['apim']=$m_id;
/*****************************************/
$modTable=array('','_modules','_modules_');
$filterTypes=array(1=>'1,2',2=>'1,3',3=>'4',4=>'2',5=>'1,2',6=>'1',7=>'2',8=>'2',9=>'1',10=>'0',11=>'4',12=>'0',13=>'2',14=>'1,2',);
$filtTypeName=array('',k_equ,k_like,k_range,k_sorted);
$filter='';
$sort_arr=array('','ASC','DESC');
/*****************************************/
$monthsNames=array('',k_month_1,k_month_2,k_month_3,k_month_4,k_month_5,k_month_6,k_month_7,k_month_8,k_month_9,k_month_10,k_month_11,k_month_12);
$wakeeDays=array(k_week_d_1,k_week_d_2,k_week_d_3,k_week_d_4,k_week_d_5,k_week_d_6,k_week_d_7);
$wakeeDaysClr=array('#5aa2a5','#b67aa7','#498449','#a88860','#5b78a5','#674985','#a45a5a');
$weekMod=array(6,0,1,2,3,4,5);
//$weekMod=array(1,2,3,4,5,6,0);
$TimeZon=_set_adldd2qmz8;
$TimeZon_secs=($TimeZon*60*60);
$now=date('U')+$TimeZon_secs;
$ss_day=$now-($now%86400);
$ee_day=$ss_day+86400;
/*****************************************/
$defImgEx=$_defImgTyp;
/******index*******/
if($MO_ID=='mxk640owj'){
	$index_type_logTxt=modListToArray('625bdfckjg');
	$index_type_phyTxt=modListToArray('vge9mquh2a');
	$index_algoTxt=modListToArray('tzgu0h2fwv');
	$index_lockTxt=modListToArray('8f6h47qqc');
}
/*****************************************/
$backupStatus=[
	'جاهز لأخذ النسخة الاحتياطية',
	'غير مكتمل',
	'مكتمل',
];
$backupTableStatus=[
	'لم يحفظ بعد',
	'غير مكتمل',
	'مكتمل',
];

?>