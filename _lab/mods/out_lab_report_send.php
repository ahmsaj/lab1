<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,"ser|action:".k_refresh.":ti_ref:loadFitterCostom('lab_out_lab_report_send')");?>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideIn so">
<?
$customFiltter='
1:'.k_visit_num.':p1|
1:'.k_patient_name.':p3|
1:'.k_fth_name.':p5|
1:'.k_l_name.':p6|
1:'.k_analysis_name.':p2|
5:'.k_send_date.':d1|
';
$customPageFiltter='lab_out_lab_report_send';
?>
</div>
<script>sezPage='lab_out_lab_report_send';$(document).ready(function(e){Open_co_filter(1); loadFitterCostom('<?=$customPageFiltter?>');});</script>