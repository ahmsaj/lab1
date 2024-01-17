<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'ser');?>
<div class="centerSideIn so"></div><?
$customFiltter='
5:'.k_date.':d1|
1:'.k_patient_name.':p2|
1:'.k_fth_name.':p3|
1:'.k_l_name.':p4|
4:'.k_sex.':p5:1-'.k_male.'^2-'.k_female.'|
3:'.k_dr.':p6:_users^id^name_(L)^where `grp_code` =\'nlh8spit9q\'|
3:'.k_technician.':p7:_users^id^name_(L)^where `grp_code` =\'1ceddvqi3g\'|

';
$customPageFiltter='xry_report_print';?>
<script>$(document).ready(function(e){Open_co_filter(1); loadFitterCostom('<?=$customPageFiltter?>');});</script>
