<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title);
$doc=$thisUser;?>
<script>sezPage='gnr_Report';repCode='gnr';</script>
<script src="<?=$m_path?>library/highstock/js/highstock.js"></script> 
<script src="<?=$m_path?>library/highstock/js/modules/exporting.js"></script>
<script src="<?=$m_path?>library/highstock/js/highcharts-more.js"></script>
<div class="centerSideInHeader"><? //echo $PER_ID;

$tab=0;
if($PER_ID=='2ba1w3kgnm'){$page=0;?>
    <div class="rep_header fr">
        <select id="rep_fil" class="reportList" onChange="ReloadReport();">
			<option value="0"><?=k_all_deps?></option>
			<option value="1"><?=k_clinics?></option>
			<!--<option value="2">المخبر</option>-->
			<option value="3"><?=k_txry?></option>
			<!--<option value="4">الأسنان</option>-->
			<option value="5"><?=k_tbty?></option>
			<option value="6"><?=k_tlaser?></option>
		</select>
    </div>
    <div class="rep_header fl">
        <div n="n0" f="0" class="fl act" onclick="loadReport(<?=$page?>,0,0);"><?=k_vis_chart?></div>		
		<div n="n2" f="1" class="fl act" onclick="loadReport(<?=$page?>,2,0);"><?=k_blnc_day?></div>
		<div n="n3" f="1" class="fl act" onclick="loadReport(<?=$page?>,3,0);"><?=k_blnc_mnth?></div>
    </div><?
}
/*****************************/
?>
<script>$(document).ready(function(){loadReport(<?=$page?>,<?=$tab?>,0,0);})</script>
<div id="rep_header_add" class="cb"></div></div><div class="centerSideIn so"><div id="reportCont"></div></div>