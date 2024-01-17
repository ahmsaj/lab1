<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['r'])){
	$id=pp($_POST['id']);
	$selTemp=pp($_POST['r']);
	$r=getRec('xry_x_visits_services',$id);
	$tWork=getTotalCO('xry_x_visits_services',"doc='$thisUser' and status=6 and id!='$id'");
	$saveB=1;
	if($r['r']){
		$status=$r['status'];
		$service=$r['service'];
		$pat=$r['patient'];
		$doc=$r['doc'];
		if($doc==$thisUser){$tWork=0;}
		$vis=$r['visit_id'];
		dcm_PACS_to_DB($pat,$id);	
		list($d_txt,$doc_ask,$photos,$part,$report,$mas,$kv,$film,$doc,$ray_tec)=get_val('xry_x_pro_radiography_report','report,doc_ask,photos,part,report,mas,kv,film,doc,ray_tec',$id);
		if(!$mas){$mas='';}
		if(!$kv){$kv='';}?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($pat).' ( '.get_val('xry_m_services','name_'.$lg,$service).' )';
		if($status==6){
			if(modPer('b8kpe202f3','0')){?>
			<div class="ic40x icc1 ic40_docs fr ic40Txt" onclick="patDocs(<?=$pat?>,1)"> <?=k_documents?></div><?
			}?>
			<div class="ic40w icc2 ic40_det fr ic40Txt mg10" onclick="pat_hl_rec(1,<?=$pat?>,'<?=$patName?>')"><?=k_med_rec?></div>
		<? }
		if($status==1){
			$tWork=0;$saveB=0;
			$d_finish=get_val('xry_x_pro_radiography_report','date',$id);
			echo '<div class="ic40x icc4 ic40_print fr ic40Txt" onclick="x_report_print('.$id.')">'.k_print.'</div>';
			if(inThisDay($d_finish)){
				echo '<div class="fr ic40w br0 icc1 ic40_edit ic40Txt mg10" onclick="xry_openSrv('.$id.','.$vis.')">'.k_open_srv_again.'</div>';
			}
		}?>
			
		</div>
		<div class="form_body of" type="pd0"><?
			if($tWork==0){?>
			<div class="fl of r_bord" fix="w:280|hp:0">
				<? if($status==6 || $status==0){?>
				<div class="fl lh40 pd10f w100 b_bord cbg44">
					<div class="ic40x icc4 br0 ic40_add fl" 
					onclick="addXryTmpRep()"></div>
					<div class="fl" fix="wp:40">
					<select onChange="xry_erep(<?=$id?>,this.value)" t >
					<option value="0"><?=k_rep_tamplet?></option><?
					$sql="select * from xry_m_pro_radiography_report_templates where doc='$thisUser' and srv='$service' order by def DESC , id ASC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						$options='';
						while($r=mysql_f($res)){
							$r_id=$r['id'];
							$def=$r['def'];
							$title=$r['title'];
							$content=$r['content'];
							$sel='';
							if($selTemp==$r_id){$report=$content;}
							$options.='<option value="'.$r_id.'" '.$sel.'>'.$title.'</option>';
						}				
					}?>
					<?=$options?>
					</select>
					</div>
				</div>
				<? } ?>
				<div class="fl ofx so r_bord pd10" fix="w:280|hp:40"><?
				echo dicom_link($pat,$id,3,1);
				if($mas){echo '<div class="fs16 lh30 fl w100">MAS :  <ff class="clr1">'.$mas.'</ff></div>';}
				if($kv){echo '<div class="fs16 lh30 w100">KV :  <ff class="clr1">'.$kv.'</ff></div>';}
				if($film){echo '<div class="fs16 lh30 f1">'.k_film_type.' : <ff class="clr1">'.$films[$film].'</ff></div>';}
				if($doc_ask){
					echo '<div class="fs16 lh30 f1">'.k_doc_req_rep.' : <span class="fs16 lh40 f1 clr1">'.get_val('gnr_m_doc_req','name',$doc_ask).'</span></div>';
				}
				if($part){
					echo '<div class="fs16 lh30 f1">'.k_photo_area.' : <span class="fs16 lh40 f1 clr1">'.get_vals('xry_m_services_parts','name'," id IN ($part) " ,' | ').'</span></div>';
				}
				if($photos){
					echo '<div class="fl pd10v w100">'.imgViewer($photos,250,160).'</div>';
				}?>
				</div>
			</div>
			<div class="fl ofx so " fix="wp:280|hp:0">
				<? if($status==6 || $status==0){?>
				<form name="x_rep_form" id="x_rep_form" action="<?=$f_path?>X/xry_preview_x_report_save.php" method="post" ><?				
					if($doc==0){
						if(mysql_q("UPDATE xry_x_visits_services SET doc='$thisUser' where id='$id' and status=6 and doc=0 ")){$doc=$thisUser;}
					}
					if($doc==0 || $doc==$thisUser){		
						if($d_txt==''){$d_txt=$def_txt;}
						echo '<div class="editorHolder"><textarea name="cof_8q8n7fk5g2" class="f1 fs16 lh20 m_editor" id="report_txt">'.$report.'</textarea></div>';
					}else{
						echo '<div class="f1 fs16 clr5 lh40">'.k_report_received_another_doc.'</div>';
						$saveB=0;
					}?>
				</form>
				<?}
				if($status==1){
					echo '<div class="xRepView cbg444 pd10f bord mg10f">'.$report.'</div>';
				}
				?>
			</div><?
			}else{
				echo '<div class="f1 fs16 clr5 lh40 pd10f">'.k_cant_write_two_reports.'</div>';
				$saveB=0;
			}?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="xry_vit_d_ref(0);win('close','#full_win1');"><?=k_close?></div>
			<? if($saveB){?><div class="bu bu_t3 fl" onclick="xry_erepSave();"><?=k_save?></div><? }?>
			<? if($ray_tec!=$thisUser && $tWork==0){?>
			<div class="bu bu_t4 fl" onclick="xry_xRep(<?=$id?>);"><?=k_unlink_taken_report?></div>
			<? }?>
		</div>
		</div><?
	}
}?>