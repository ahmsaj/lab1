<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('xry_x_visits_requested',$id);
	if($r['r']){
        $staus=$r['status'];
        $patient=$r['patient'];
        $clinic=$r['x_clinic'];
        $doc=$r['doc'];        
        if($staus<2 && $doc==$thisUser){
            if(mysql_q("UPDATE xry_x_visits_requested SET status='1' where id='$id' and status=0 ")){
                mysql_q("UPDATE xry_x_visits_requested_items SET action='1' where r_id='$id' ");
                if(getTotalCo('gnr_x_temp_oprs',"type=8 and vis='$id' ")==0){     
                    addTempOpr($patient,8,3,$clinic,$id);                   
                }
                echo 1;
            }
        }
	}
}?>
<? //include("../../__sys/prcds/ajax_header.php");
/*
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=k_no_req_num?></div>
	<div class="form_body so">
		<?
		list($r_status,$x_clinic)=get_val('xry_x_visits_requested','status,x_clinic',$id);
		if($r_status<2){
			$sql="select * from xry_x_visits_requested_items where r_id='$id' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<form name="l_xp" id="l_xp" action="<?=$f_path?>X/gnr_preview_radiology_send_save.php" method="post" cb="win('close','#m_info2');m_xphotoN([1])" bv="a">
				<input type="hidden" name="id" value="<?=$id?>" />
				<div class="lh40 clr5 f1 fs14"><?=k_cant_edit_setts_note?></div>
				<div class="f1 fs18 lh40 clr1"><?=get_val('gnr_m_clinics','name_'.$lg,$x_clinic)?></div>
				<table border="0" width="100%" cellspacing="0" cellpadding="4" class="grad_s" type="static">
				<tr><th width="50%"><?=k_photo?></th><th></th></tr>
				<?
				while($r=mysql_f($res)){
					$x_id=$r['id'];
					$status=$r['status'];
					$xphoto=$r['xphoto'];
					$act=$r['act'];
					$service_id=$r['service_id'];
					$mad_name=get_val('xry_m_services','name_'.$lg,$xphoto);
					$msg='';
					if($act==0){
						$msg='<div class="clr5 f1">'.k_not_available_in_xray.'</div>';
					}?>
					<tr>   
						<td class="f1 fs14" ><?=splitNo($mad_name).$msg?></td>					
						<td class="f1 fs16" >					
						<div class="radioBlc so fl" name="a_<?=$x_id?>" req="1" ><? 
							$ch='checked';
							if($act==1){
								$ch='';?>
								<input type="radio"  name="a_<?=$x_id?>" value="1"  checked /><label><?=k_hospital_xray?></label>
							<? }?>
							<input type="radio"  name="a_<?=$x_id?>" value="2" <?=$ch?>/><label><?=k_external_xry?></label>
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
		<? if($r_status<2){?><div class="bu bu_t3 fl " onclick="sub('l_xp');"><?=k_save?></div><? }?>
    </div>
    </div><?
}*/?>