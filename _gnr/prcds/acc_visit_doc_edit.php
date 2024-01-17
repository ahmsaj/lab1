<? include("../../__sys/prcds/ajax_header.php");
if($chPer[2] && isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$table=$visXTables[$t];
	$table2=$srvXTables[$t];
	$q=$q2='';
	$req=1;
	if($t!=2){list($doctor,$clinic)=get_val($table,'doctor,clinic',$id);}	
	if($t==1){$q=" grp_code='7htoys03le' and subgrp in($clinic) ";}
	if($t==5){$q=" grp_code='9yjlzayzp'  and subgrp in($clinic) ";}
	if($t==6){$q=" grp_code='66hd2fomwt' and subgrp in($clinic) ";}
	if($t==7){$q=" grp_code='9k0a1zy2ww' and subgrp in($clinic) ";}
	if($t==3){		
		list($ray_tec,$oldDoc)=get_val($table,'ray_tec,doctor',$id);		
		$ray_tecCln=get_val('_users','subgrp',$ray_tec);
		$q=" grp_code = 'nlh8spit9q' and FIND_IN_SET($clinic,`subgrp`) ";
		//if($ray_tec){
			$q2=" ($q) or (grp_code ='1ceddvqi3g' and FIND_IN_SET($clinic,`subgrp`) )  ";	
		//}else{
			//$q2=$q;
		//}
		$req=0;
	} 
	
	if(isset($_POST['save'])){		
		$doc=pp($_POST['doc']);		
		if(getTotalCO('_users'," $q and id='$doc' ") || ($t==3 && $doc==0)){
			if($t==3){
				$tec=pp($_POST['tec']);
				if(!$doc){$doc=0;}
				$visDoc=$doc;
				//if($doc!=$tec){$visDoc=0;}
				//echo "UPDATE $table set doctor='$visDoc' , ray_tec='$tec' where id='$id' ";
				mysql_q("UPDATE $table set doctor='$visDoc' , ray_tec='$tec' where id='$id' ");
				if($doc==$tec || ($oldDoc && $doc==0)){
					mysql_q("UPDATE $table2 set doc='$doc' where visit_id='$id' ");
					mysql_q("UPDATE xry_x_pro_radiography_report set doc='$doc' where id in(select id from $table2 where visit_id='$id' ");
					mysql_q("UPDATE gnr_x_insurance_rec set doc='$doc' where visit='$id' and mood='$t' ");
				}else{
					if(($oldDoc!=$doc)){
						$sql="select * from $table2 where visit_id='$id'";
						$res=mysql_q($sql);
						while($r=mysql_f($res)){
							$s_id=$r['id'];
							$s_doc=$r['doc'];
							if($s_doc!=0){
								mysql_q("UPDATE $table2 set doc='$doc' where id='$s_id' ");
								mysql_q("UPDATE xry_x_pro_radiography_report set doc='$doc' where id ='$s_id' ");
								mysql_q("UPDATE gnr_x_insurance_rec set doc='$doc' where service_x='$s_id' and mood='$t' ");
							}
						}
					}
				}
			}else{
				mysql_q("UPDATE $table set doctor='$doc' where id='$id' ");
				mysql_q("UPDATE $table2 set doc='$doc' where visit_id='$id' ");
				mysql_q("UPDATE gnr_x_insurance_rec set doc='$doc' where visit='$id' and mood='$t' ");
				mysql_q("UPDATE gnr_x_visits_services_alert set doc='$doc' where visit_id='$id' and mood='$t' ");
				mysql_q("UPDATE gnr_x_roles set doctor='$doc' where vis='$id' and mood='$t' ");
			}
			echo 1;
		}
	}else{
		?><div class="win_body">
		<div class="form_header f1 fs18 clr1 lh40"><?=k_sel_altr_doc?></div>
		<div class="form_body so" >
			<form name="acc_form_doc" id="acc_form_doc" action="<?=$f_path.'X/gnr_acc_visit_doc_edit.php'?>" method="post"
			cb="showAcc(<?=$id?>,<?=$t?>)" bv="">
			<input type="hidden" name="id" value="<?=$id?>"/>
			<input type="hidden" name="t" value="<?=$t?>"/>
			<input type="hidden" name="save" value="1"/>
			
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
				<tr>
					<td txt><?=k_doctor?></td>
					<td><?=make_Combo_box('_users','name_'.$lg,'id','where '.$q,'doc',$req,$doctor,' t ');?></td>
				</tr>
				<? if($t==3){?>
					<tr>
						<td txt><?=k_technician?></td>
						<td><?=make_Combo_box('_users','name_'.$lg,'id','where '.$q2,'tec',1,$ray_tec,' t ');?></td>
					</tr>				
				<? }?>
			</table>
			</form>
		</div>
		<div class="form_fot fr" >
			<div class="bu bu_t1 fl" onclick="sub('acc_form_doc')"><?=k_save?></div>		
			<div class="bu bu_t2 fr" onclick="win('close','#m_info2');" ><?=k_close?></div>
		</div>
		</div><?
	}
}?>
