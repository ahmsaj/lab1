<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'action:'.k_refresh.':ti_ref:sch_ref(1)');?>
<div class="centerSideInHeader fs18 f1 lh40 clr1">
<?= $wakeeDays[date('w')].' | <ff>'.date('d').' - </ff>'.$monthsNames[date('n')].'<ff> - '.date('Y').'</ff>'?></div>
<div class="centerSideIn so"></div>
<script>sezPage='sch_p';$(document).ready(function(e){sch_ref(1);refPage(4,10000);});</script>