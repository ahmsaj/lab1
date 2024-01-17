<? include("../../__sys/mods/protected.php");?>
<?
$ittle=$def_title;
echo header_sec($ittle,'ser|action:'.k_merge.':ti_merge:mergePats()');?>
<div class="centerSideIn so"></div><?
$customFiltter='
1:'.k_num.' :p1|
1:'.k_name.':p2|
1:'.k_l_name.':p3|
1:'.k_fth_name.':p4|
1:'.k_mobile.':p5|
1:'.k_phone.':p6|
4:'.k_sex.':p7:1-'.k_male.'^2-'.k_female.'|';
$customPageFiltter='gnr_patient_merge';?>
<script>$(document).ready(function(e){Open_co_filter(1);loadFitterCostom('<?=$customPageFiltter?>'); 
})</script>
