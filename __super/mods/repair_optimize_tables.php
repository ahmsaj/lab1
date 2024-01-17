<?=header_sec($def_title,'');?>
<div class="centerSideInFull of " >
	<div class="b_bord" fix="h:60" style="margin-top:10px;">
		<div t id="repair" class="cbg4 fl clr11 f1 mg10 pd10 Over lh40"> <?=k_repair?> ( REPAIR )</div>

		<div t id="optimize" class="cbg4 fl clr11 f1 mg10 pd10 Over lh40" > <?=k_optimize?> ( OPTIMIZE )</div>
	</div>
	<!------------------------------------------------------->
	<!--import view-->
	<div id="result" style="padding:10px;" fix="hp:60"></div>

</div>
<script>
	$(document).ready(function(e){ repair_view_fix(); });
</script>
