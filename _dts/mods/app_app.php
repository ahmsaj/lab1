<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'action:'.k_refresh.':ti_ref:dtsApp(1)');?>
<div class="centerSideInHeader"><div class="lh50 clr1 f1 fs18 uLine">عدد المواعيد ( <ff id="tot"></ff> )</div></div>
<div class="centerSideIn so"></div>
<script>sezPage='dtsapp';$(document).ready(function(e){dtsApp(1);refPage('dts1',10000);});</script>