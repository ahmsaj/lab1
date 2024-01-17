<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'ser|action:'.k_export.':ti_res:sub(\'cons_t\');');?>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideIn so"></div>
<?
$customFiltter='
5:'.k_date.':d1|
3:'.k_item.':p1:str_m_items^id^name|
3:'.k_tclinic.':p2:gnr_m_clinics^id^name_ar|
3:'.k_doctor.':p3:_users^id^name_ar^where `grp_code` IN(\'7htoys03le\')|
';
$customPageFiltter='gnr_total-cons';
?>
<script>$(document).ready(function(e){Open_co_filter(1); loadFitterCostom('<?=$customPageFiltter?>');});</script>
