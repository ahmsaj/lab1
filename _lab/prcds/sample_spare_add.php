<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['id_spare'])){
	$id=pp($_POST['id']);
	$id_spare=pp($_POST['id_spare']);
	
	$rec=getRec('lab_x_visits_samlpes',$id);
	if($rec['r']){
		$cData=getColumesData('jzankern0',1);
		
		if($id_spare){
			$rec2=getRec('lab_x_visits_samlpes',$id_spare);
			$s_taker=$rec2['s_taker'];if($s_taker==0){$s_taker=getSam_Teker($rec2['visit_id']);}
			$pkg_id=$rec2['pkg_id'];
			$no=$rec2['no'];			
		}else{
			$s_taker=$rec['s_taker'];if($s_taker==0){$s_taker=getSam_Teker($rec['visit_id']);}
			$pkg_id=$rec['pkg_id'];
		
		}?>
        <div class="win_body">
        <div class="form_header lh40 f1 fs18 clr1">
		<?=k_bu_sm_sm?> (<?=get_val('lab_m_samples_packages','name_'.$lg,$rec['pkg_id'])?> 
		<? if($rec['no']){ echo '<ff>'.$rec['no'].'</ff>';}?> )
		</div>
        <div class="form_body so">		
        <form name="lsss_form" id="lsss_form" action="<?=$f_path?>X/lab_sample_spare_save.php" method="post" cb="setLNoCB([1]);" bv="id">
        <input type="hidden" name="id" value="<?=$id?>"/>
        <input type="hidden" name="id_spare" value="<?=$id_spare?>"/><?
        echo '<table class="fTable" cellpadding="0" cellspacing="0" border="0">
		<tr><td n>'.k_tk_sams.'</td>
        <td i>'.co_getFormInput(0,$cData['0enuor5p1i'],$s_taker,0,1).'</td></tr>
		
		<tr><td n>'.k_sample.'</td>
        <td i>'.co_getFormInput(0,$cData['flv0yzwyja'],$pkg_id,0,1).'</td></tr> 
        <tr><td n>'.k_ent_num_sams.'</td>
        <td i><input type="number" name="no" id="lsNN" value="'.$no.'"  required/><td></tr></table>';        
        ?>
        </div>
        </form>
        <div class="form_fot fr">
            <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
            <div class="bu bu_t3 fl" onclick="sub('lsss_form');"><?=k_save?></div>               
        </div>
        </div><?
	}
}?>
