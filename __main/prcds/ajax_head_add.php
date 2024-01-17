<?
/********this file for Project vars in ajax********/
$SP_1='';
if($_SESSION['m_id']){$SP_1=$_SESSION['m_id'];}
if($SP_1){$endsCon=" clinic_id=' ".$SP_1." ' ";}else{$endsCon=" clinic_id!=0 ";}
?>