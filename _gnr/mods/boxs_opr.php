<? include("../../__sys/mods/protected.php");?>
<div class="centerSideInFull of">
	<div class="fl bo_list" fix="w:280|hp:0">
		<div class="bo_title">الإجراءات</div>
		<div class="ofx so bo_oprs" fix="hp:53"><?
		foreach($boxOpr as $k=>$bo){
			$name=$bo['n'];			
			$code=$bo['a'];
			$iconT=$bo['i'];
			echo '<div class="fs14" style="border-'.$align.'-color:'.$color.';
			background-image:url(../images/box/'.$iconT.'.png);" code="'.$k.'" >'.$name.'</div>';
		}?>
		</div>
	</div>
	<div class="fl of "fix="wp:280|hp:0">
		<div class="lh50 cbg4" fix="h:50">
			<div class="fr ic40x ic40_ref icc33 mg5f" onclick="boReload()"></div>
			<div class="f1 fs18 lh50 cbg4 pd10" id="bo_title"></div>			
		</div>
		<div class="of" fix="hp:50" id="bo_dets"></div>
	</div>
	
</div>
<script>$(document).ready(function(e){setBoxOpr();});</script>