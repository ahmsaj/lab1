<div class="centerSideInFull of h100">
    <div class="fxg h100" fxg="gtc:280px 1fr|gtr:53px 1fr">
        <div class="bo_title">الإجراءات</div>
        <div class="lh50 cbg4">
			<div class="fr ic40x ic40_ref icc33 mg5f" onclick="boReload()"></div>
			<div class="f1 fs18 lh50 cbg4 pd10" id="bo_title"></div>			
		</div>
        <div class="fl bo_list">
            <div class="ofx so bo_oprs" fix1="hp:53"><?
            foreach($boxOpr as $k=>$bo){
                $name=$bo['n'];			
                $code=$bo['a'];
                $iconT=$bo['i'];
                echo '<div class="fs14" style="border-'.$align.'-color:'.$color.';
                background-image:url(../images/box/'.$iconT.'.png);" code="'.$k.'" >'.$name.'</div>';
            }?>
            </div>
        </div>        
        <div class="h100 of" id="bo_dets" class="cbgw"></div>        
    </div>
</div>
<script>$(document).ready(function(e){setBoxOpr();});</script>