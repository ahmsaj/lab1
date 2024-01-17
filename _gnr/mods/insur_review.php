<? include("../../__sys/mods/protected.php");?>
<?
echo header_sec($def_title,'ser');?>
<div class="centerSideIn so"></div><?
$customFiltter='
1:'.k_insurance_no.' :p0|
1:'.k_bill_number.' :p11|
1:'.k_visit_num.':p1|
5:'.k_date.':d1|
1:'.k_patient_name.':p2|
1:'.k_fth_name.':p3|
1:'.k_l_name.':p4|
4:'.k_sex.':p5:1-'.k_male.'^2-'.k_female.'|';
if($thisGrp!='kzfr3ekg3'){$customFiltter.="3:".k_input.":p6:_users^id^name_(L)^where `grp_code` IN('kzfr3ekg3')|";}
$customFiltter.='
3:'.k_insure_comp.':p8:gnr_m_insurance_prov^id^name_(L)^|
3:'.k_doctor.':p7:_users^id^name_(L)^where grp_code IN(\'7htoys03le\',\'nlh8spit9q\',\'b3pfukslow\')|
4:'.k_status.':p9:'.getModParAsList('kvgib0ap7').'
';
$customPageFiltter='gnr_insur_review';
?>
<script>$(document).ready(function(e){Open_co_filter(1); loadFitterCostom('<?=$customPageFiltter?>');});</script>
