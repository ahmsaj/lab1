<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'ser');?>
<div class="centerSideIn so"></div><?
$customFiltter='
1:'.k_visit_num.':v1|
1:'.k_pat_num.':p1|
1:'.k_patient_name.':p2|
1:'.k_l_name.':p4|
1:'.k_fth_name.':p3';
$customPageFiltter='gnr_invoice';?>
<script>
sezPage='invs';
$(document).ready(function(e){
	Open_co_filter(1); 
	loadFitterCostom('<?=$customPageFiltter?>');
});


</script>