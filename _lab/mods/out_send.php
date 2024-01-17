<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'ser|action:ارسال:ti_send hide:send_sampels_do(0,0);');?>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideIn so">
<?
$customFiltter='
5:'.k_date.':d1|
1:'.k_analysis.':p1|
1:'.k_test_code.':p5|
1:'.k_short_name.':p6|
1:'.k_patient_name.':p2|
1:'.k_fth_name.':p3|
1:'.k_l_name.':p4|
4:'.k_sex.':p7:1-'.k_male.'^2-'.k_female.'|
';
$customPageFiltter='lab_out_send';
?>
</div>
<script>sezPage='sampels_sends';$(document).ready(function(e){Open_co_filter(1); loadFitterCostom('<?=$customPageFiltter?>');});</script>