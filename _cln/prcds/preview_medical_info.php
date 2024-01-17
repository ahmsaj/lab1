<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'])){
	$p_id=pp($_POST['p_id']);
	$blood=get_val('gnr_m_patients','blood',$p_id);
	if($blood=='0'){
		echo $blood=k_not_yet_determined;
	}else{?>
		<script>
			Bcode='<?=substr($blood,0,-1);?>';
			Bplus='<?=substr($blood,-1);?>';
        </script><?
	}?>
    <div class="madTabs">
        <div class="fl">
            <div class="secTitle"><div class="fl madTitle"><?=k_allergy?></div><div class="fr editMad" onclick="editMadInfo(1)"></div></div>
            <div class="secCon so"><div><?=showMadInfo(1,$p_id,0)?></div></div>
        </div>
        
        <div class="fl">
       		<div class="secTitle"><div class="fl madTitle"><?=k_prev_surgeries?></div><div class="fr editMad" onclick="editMadInfo(2)"></div></div>
            <div class="secCon so"><div><?=showMadInfo(2,$p_id,0)?></div></div>
        </div>
        
        <div class="fl">
        	<div class="secTitle"><div class="fl madTitle"><?=k_ch_diseases?></div><div class="fr editMad" onclick="editMadInfo(3)"></div></div>
            <div class="secCon so"><div><?=showMadInfo(3,$p_id,0)?></div></div>
        </div>
        <div class="fl">
            <div class="secTitle"><div class="fl madTitle"><?=k_medicines?></div><div class="fr editMad" onclick="editMadInfo(4)"></div></div>
            <div class="secCon so"><div><?=showMadInfo(4,$p_id,0)?></div></div>
        </div>
	</div><script>fixPage();</script><?
}?>