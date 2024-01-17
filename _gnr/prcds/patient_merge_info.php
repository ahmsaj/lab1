<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['ids'])){
	$ids=pp($_POST['ids'],'s');	
	$total=array();
	if($ids){
		$pats=get_vals('gnr_m_patients','id',"id IN ($ids)",'arr');
		if(count($pats)>1){?>
			<div class="win_body">
			<div class="form_header lh50">
			<select fix="w:250" id="mPat" t><?
				echo '<option value="0">--- '.k_prim_pat_choos.' ---</option>';
				foreach($pats as $pat){echo '<option value="'.$pat.'">'.$pat.' | '.get_p_name($pat).'</option>';}?>
			</select>
			</div>
			<div class="form_body so"><?
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" >
			<tr><th width="30"></th><th width="250">'.k_the_proced.'</th>';			
			foreach($pats as $pat){echo '<th><ff>'.$pat.' | </ff>'.get_p_name($pat).'</th>';}
			echo'</tr>';
			$i=1;
			foreach($merOprs as $mo){
				echo '<tr><td><ff>'.$i.'</ff></td><td class="f1 fs14 TL">'.$mo[0].'</td>';
				foreach($pats as $pat){
					$n=getTotalCO($mo[1],$mo[2]."='$pat'");
					$total[$pat]+=$n;
					echo '<td><ff>'.$n.'</ff></td>';
				}
				echo '</tr>';
				$i++;
			}
			echo '<tr fot><td class="f1 fs14" colspan="2">'.k_total.'</td>';
			foreach($pats as $pat){echo '<td><ff>'.$total[$pat].'</ff></td>';}
			echo '</tr>';
			echo '</table>';
		}else{
			echo '<div class="f1 fs14 lh40 clr5">'.k_sel_two_pats_to_merge.'</div>';
		}
	}
	?>
    </div>
    <div class="form_fot fr">        
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
        <div class="bu bu_t3 fr" onclick="mergeAlert('<?=$ids?>');"><?=k_merge?></div>
    </div>
    </div><?
}?>