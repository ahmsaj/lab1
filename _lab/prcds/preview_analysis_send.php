<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=k_chos_test_hospital_outside?></div>
	<div class="form_body so">
		<?
		$r_status=get_val('lab_x_visits_requested','status',$id);
		if($r_status<2){
			$sql="select * from lab_x_visits_requested_items where r_id='$id' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<form name="l_ana" id="l_ana" action="<?=$f_path?>X/lab_preview_analysis_send_save.php" method="post" cb="win('close','#m_info2');Analysis([1],<?=_set_9jfawiejb9?>)" bv="a">
				<input type="hidden" name="id" value="<?=$id?>" />
				<div class="lh40 clr5 f1 fs14"><?=k_cant_edit_setts_note?></div>
				<table border="0" width="100%" cellspacing="0" cellpadding="4" class="grad_s" type="static">
				<tr><th width="50%"><?=k_analysis?></th><th></th></tr>
				<?
				while($r=mysql_f($res)){
					$x_id=$r['id'];
					$status=$r['status'];
					$ana=$r['ana'];
					$act=$r['act'];
					$service_id=$r['service_id'];
					$mad_name=get_val('lab_m_services','short_name',$ana);
					$msg='';
					if($act==0){
						$msg='<div class="clr5 f1">'.k_lab_not_available.'</div>';
					}?>
					<tr>   
						<td class="f1 fs16" ><?=splitNo($mad_name).$msg?></td>					
						<td class="f1 fs16" >					
						<div class="radioBlc so fl" name="a_<?=$x_id?>" req="1" ><? 
							$ch='checked';
							if($act==1){
								$ch='';?>
								<input type="radio"  name="a_<?=$x_id?>" value="1"  checked /><label><?=k_hospital_lab?></label>
							<? }?>
							<input type="radio"  name="a_<?=$x_id?>" value="2" <?=$ch?>/><label><?=k_lab_external?></label>
						</div>
					</tr><?
				}?>		
				</table>
				</form><?
			}
		}else{
			echo '<div class="f1 fs16 clr5 lh40">'.k_request_cant_send.'</div>';
		}?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
		<? if($r_status<2){?><div class="bu bu_t3 fl " onclick="sub('l_ana');"><?=k_save?></div><? }?>
    </div>
    </div><?
}?>