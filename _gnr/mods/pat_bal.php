<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,"ser|action:".k_refresh.":ti_ref:loadFitterCostom('gnr_patient_bal')");?>
<div class="centerSideIn so"></div><?
$customFiltter='
1:'.k_pat_num.':p2|
1:'.k_name.':p3|
1:'.k_l_name.':p4|
1:'.k_fth_name.':p5|
';
$customPageFiltter='gnr_patient_bal';?>
<script>$(document).ready(function(e){Open_co_filter(1); loadFitterCostom('<?=$customPageFiltter?>');});</script>
