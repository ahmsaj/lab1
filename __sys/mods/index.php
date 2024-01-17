<? include("../../__sys/header.php");?>
<script src="<?=$m_path?>library/highstock/js/highstock.js"></script> 
<script src="<?=$m_path?>library/highstock/js/modules/exporting.js"></script>
<? $title=_info_7dvjz4qg9g;indexStartFuns();
echo header_sec($title,'action:'.k_refresh.':ti_ref:dash(1,actDashTab);');
if($thisGrp=='s'){loadMOdBackFiles();}?>
<div class="centerSideInHeaderFull"></div>
<div class="centerSideInFull ofx so"></div>
<script>$(document).ready(function(e){dashRef();dash(1,1);});</script>
<? include("../../__sys/footer.php")?>