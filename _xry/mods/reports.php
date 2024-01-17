<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title);
$doc=$thisUser;?>
<script>sezPage='xry_Report';repCode='xry';</script>
<script src="<?=$m_path?>library/highstock/js/highstock.js"></script> 
<script src="<?=$m_path?>library/highstock/js/modules/exporting.js"></script>
<script src="<?=$m_path?>library/highstock/js/highcharts-more.js"></script>
<div class="centerSideInHeader"><? //echo $PER_ID;

$tab=0;
if($PER_ID=='pblglp0640'){$page=1;
?>
    <div class="rep_header fr"><input type="hidden" id="rep_fil" /></div>
    <div class="rep_header fl">
        <div n="n0" f="1" class="fl act" onclick="loadReport(<?=$page?>,0,0);"><?=k_daily_report?></div>
        <div n="n1" f="1" class="fl" onclick="loadReport(<?=$page?>,1,0);"><?=k_monthly_report?></div>
        <div n="n2" f="0" class="fl" onclick="loadReport(<?=$page?>,2,0);"><?=k_rp_dte?></div>        
    </div><?
}
if($PER_ID=='igot20oqaa'){$page=2;
?>
    <div class="rep_header fr"><input type="hidden" id="rep_fil" /></div>
    <div class="rep_header fl">
        <div n="n0" f="1" class="fl act" onclick="loadReport(<?=$page?>,0,0);"><?=k_daily_report?></div>
        <div n="n1" f="1" class="fl" onclick="loadReport(<?=$page?>,1,0);"><?=k_monthly_report?></div>
        <div n="n2" f="0" class="fl" onclick="loadReport(<?=$page?>,2,0);"><?=k_rp_dte?></div>        
    </div><?
}
if($PER_ID=='r8ga8jvbwq'){$page=3;?>
    <div class="rep_header fr"><?
        $options='<option value="0">'.k_alclincs.'</option>';
        $sql="select * from gnr_m_clinics  where type=3 order by ord ASC"; 
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){
            while($r=mysql_f($res)){
                $id=$r['id'];
                $name=$r['name_'.$lg];
                $options.='<option value="'.$id.'">'.$name.'</option>';
            }
        }?>
        <select id="rep_fil" class="reportList" onChange="ReloadReport();"><?=$options?></select>
    </div>
    <div class="rep_header fl">
        <div n="n0" f="1" class="fl act" onclick="loadReport(<?=$page?>,0,0);"><?=k_daily_report?></div>
        <div n="n1" f="1" class="fl" onclick="loadReport(<?=$page?>,1,0);"><?=k_monthly_report?></div>		
        <div n="n2" f="1" class="fl" onclick="loadReport(<?=$page?>,2,0);"><?=k_annual_report?></div>
		<div n="n3" f="1" class="fl" onclick="loadReport(<?=$page?>,3,0);"><?=k_general_report?></div>
        <div n="n4" f="1" class="fl" onclick="loadReport(<?=$page?>,4,0);"><?=k_rp_dte?></div>
		
		<div n="n5" f="0" class="fl" onclick="loadReport(<?=$page?>,5,0);"><?=k_mth_tls_xry?></div>
        <div n="n6" f="0" class="fl" onclick="loadReport(<?=$page?>,6,0);"><?=k_mth_xry_tim?></div>
    </div><?
}
?>
<script>$(document).ready(function(){loadReport(<?=$page?>,<?=$tab?>,0,0);})</script>
<div id="rep_header_add" class="cb"></div></div><div class="centerSideIn so"><div id="reportCont"></div></div>