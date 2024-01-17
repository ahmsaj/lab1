<? include("../../__sys/mods/protected.php");?>
<?
echo header_sec($def_title,'ser');?>
<div class="centerSideInHeader so"></div>
<div class="centerSideIn so"></div><?
$customFiltter='
5:'.k_date.':d1|
';
$customPageFiltter='gnr_report_insur_srv';
?>
<script>$(document).ready(function(e){Open_co_filter(1); loadFitterCostom('<?=$customPageFiltter?>');});</script>