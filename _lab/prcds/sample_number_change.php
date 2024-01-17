<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['opr'])){
	$id=pp($_POST['id']);
	$opr=pp($_POST['opr']);	
	$sql="select * from lab_x_visits_samlpes where id='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$cData=getColumesData('jzankern0',1);
	if($rows>0){
		$r=mysql_f($res);
		if($opr==0){
		$pkg_id=$r['pkg_id'];
		$visit_id=$r['visit_id'];
		$services=$r['services'];
		$no=$r['no'];
		$s_out=$r['s_out'];
		$s_taker=$r['s_taker'];
		if($s_taker==0){$s_taker=getSam_Teker($visit_id);}
		$status=$r['status'];
		$s_outCheck=''; if($s_out){$s_outCheck=" checked ";}?>
        <div class="win_body">
        <div class="form_header lh40 f1 fs18 clr1"><?=get_val('lab_m_samples_packages','name_'.$lg,$pkg_id)?></div>
        <div class="form_body so">
        <? if($status<2){?>
        <form name="lsno_form" id="lsno_form" action="<?=$f_path?>X/lab_sample_number_change.php" method="post" cb="setLNoCB([1]);" bv="id">
        <input type="hidden" name="opr" value="1"/>
        <input type="hidden" name="id" value="<?=$id?>"/><?
        echo '<table class="fTable" cellpadding="0" cellspacing="0" border="0">
		<tr><td n>'.k_ext_sams.'</td>
		<td i><input type="checkbox" name="s_out" '.$s_outCheck.'/></td></tr>
        
		<tr><td n>'.k_tk_sams.'</td>
        <td i>'.co_getFormInput(0,$cData['0enuor5p1i'],$s_taker,0,1).'</td></tr>
		
        <tr><td n>'.k_ent_num_sams.'</td>
        <td i><input type="number" name="no" id="lsNN" value="'.$no.'"/><td></tr></table>';
        
        }else{echo '<div class="f1 fs18 clr5">'.k_dat_cant_modf.'</div>';}?>
        </div>
        </form>
        <div class="form_fot fr">
            <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
            <div class="bu bu_t3 fl" onclick="slNo(1,<?=$id?>);"><?=k_save?></div>               
        </div>
        </div><?
		}else{
			$s_out=0;if(isset($_POST['s_out'])){$s_out=1;}
			$no=pp($_POST['no']);
			$st=pp($_POST['cof_0enuor5p1i']);
			if($no){
				if(getTotalCO('lab_x_visits_samlpes'," no='$no' and id!='$id'")==0){
					if(mysql_q("UPDATE lab_x_visits_samlpes set no='$no' , s_taker='$st' , `s_out`='$s_out' , status=1 where id='$id'")){
						$visit_id=get_val('lab_x_visits_samlpes','visit_id',$id);
						endLabVist($visit_id);						
						echo 1;
					}
				}else{echo 0;}
			}
		}
	}
}?>