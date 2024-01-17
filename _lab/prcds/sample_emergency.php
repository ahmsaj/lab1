<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=k_energency_tests?></div>
	<div class="form_body so">
	<?
	$sql="select * ,x.id as xid ,x.fast as x_fast from lab_m_services z , lab_x_visits_services x where x.service=z.id and x.visit_id='$id' and z.fast=1 and status IN(0,2,4,5)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<form name="emrgForm" id="emrgForm" action="'.$f_path.'X/lab_sample_emergency_save.php" method="post"  cb="openLabSWin(1,'.$id.')">
			<input type="hidden" name="id" value="'.$id.'"/>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s" over="0">
			<tr><th width="30"></th><th>'.k_analysis.'</th></tr>';
			$rrSrv=0;
			$pkg_ids='';
			while($r=mysql_f($res)){
				$ser_id=$r['xid'];
				$ser_name=$r['short_name'];
				$outlab=$r['outlab'];
				$status=$r['status'];
				$sample_type=$r['sample'];
				$fast=$r['x_fast'];
				$sample_pg=get_val('lab_m_samples','pg',$sample_type);
				$outTxt='';if($outlab){$outTxt='<div class="f1 clr1 lh20"> '.k_out_test.' </div>';}
				$ch='';if($fast){$ch=' checked ';}
				
				$samePkg='';
				if(checkSamePak($lastSample,$sample_pg)){
					$samePkg='<div class="f1 fs14 clr5 Over" onclick="marageAna('.$ser_id.')">'.k_link_ana2samp.'</div>';
				}
				echo '<tr bgcolor="'.$anStatsTxt_Col[$status].'">
				<td class="ff fs16 B lh30"><input type="checkbox" name="s_'.$ser_id.'" '.$ch.' value="1"/></td>
				<td><div class="ff fs16 B lh30 TL">'.$ser_name.$outTxt.$fastTxt.'</div></td>
				</tr>';
			}			
			echo '</table>
			</form>';			
		}
		?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="sub('emrgForm');"><?=k_save?></div>
    </div>
    </div><?
}?>