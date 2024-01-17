<? include("../../__sys/mods/protected.php");?>
<?
echo header_sec($def_title,'ser');?>
<div class="centerSideIn so"></div><?
$customFiltter='
1:'.k_visit_num.':p1|
5:'.k_bokng.':d1|
1:'.k_patient_name.':p2|
1:'.k_fth_name.':p3|
1:'.k_l_name.':p4|
4:'.k_sex.':p5:1-'.k_male.'^2-'.k_female.'|
3:'.k_reception.':p6:_users^id^name_(L)^where `grp_code` IN(\'pfx33zco65\')|
3:حاجز الموعد:p61:_users^id^name_(L)^where `grp_code` IN(\'pfx33zco65\',\'7htoys03le\')|
3:'.k_insure_comp.':pIns:gnr_m_insurance_prov^id^name_(L)^|';
if(!in_array($thisGrp,array('7htoys03le'))){$customFiltter.="3:".k_dr.":p7:_users^id^name_(L)^where `grp_code` IN('7htoys03le')|";}
$customFiltter.='3:'.k_clinic.':p8:gnr_m_clinics^id^name_(L)^where type IN(1,3)|
4:'.k_status.':p9:'.getModParAsList('tug0r81upf').'|
4:'.k_pay_type.':p11:'.getModParAsList('n86k4sdvd').'|
6:'.k_urgent.':p12|
';
$customPageFiltter='cln_acc_visit_review';
?>
<script>$(document).ready(function(e){Open_co_filter(1); loadFitterCostom('<?=$customPageFiltter?>');});</script>
