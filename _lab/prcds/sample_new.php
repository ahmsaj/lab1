<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$sql="select * from lab_x_visits_samlpes where id='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$sam_id=$r['id'];
		$visit_id=$r['visit_id'];
		$pkg_id=$r['pkg_id'];
		$services=$r['services'];
		$no=$r['no'];
		$date=$r['date'];
		$S_status=$r['status'];
		$rack=$r['rack'];
		$rack_pos=$r['rack_pos'];
		$o_no=$r['no'];
		$p=$r['patient'];
		if(isset($_POST['sub'])){
			$no=pp($_POST['no']);
			$old_ser=array();
			$new_ser=array();
			$o_arr='';
			$n_arr='';
			$sql="select * from lab_x_visits_services where id IN($services)";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					if(isset($_POST['s_'.$s_id])){array_push($new_ser,$s_id);}else{array_push($old_ser,$s_id);}
				}
			}
			$o_arr=implode(',',$old_ser);
			$n_arr=implode(',',$new_ser);
			if($o_arr && $n_arr){
				$no=pp($_POST['no']);
				$pkg=pp($_POST['pkg']);				
				if(mysql_q("INSERT INTO lab_x_visits_samlpes (`visit_id`,`pkg_id`,`services`,`user`,`date`,`patient`,`sub_s`,`no`,`status`,`take_date`) 
					values ('$visit_id','$pkg','$n_arr','$thisUser','$now','$p','$id','$no','2','$now')")){
					mysql_q("UPDATE lab_x_visits_samlpes set `services`='$o_arr' where id='$id'");
					echo 1;
				}else{echo 0;}
			}else{echo 0;}
			
		}else{
			//$cb='r_samples_work(1);$(\'#rsno\').val('.$o_no.');resvLSNoDo3();';
			//if($t==2){$cb='r_samples_ref(1);win(\'close\',\'#m_info3\');findRack(ActRack)';}
			$cb='newSamplCB('.$t.','.$o_no.',[1])';?>
            <div class="win_body">
                <div class="form_body so">			
                    <div style="margin:0px;">
                    <div class="fl">
                        <div class="fl lh50"><?=get_samlpViewC('x',$pkg_id,1)?></div>
                        <div class="fl f1 fs20 lh50"><?=get_val('lab_m_samples_packages','name_'.$lg,$pkg_id).' <ff> ( '.$no.' )</ff>'?></div>
                    </div>
                    <div class="fr">
                        <div class="f1 clr1111 fs14 lh30"><?=$lrStatus[$S_status]?> : <ff><?=dateToTimeS2($now-$date)?></ff></div>
                        <div class="fl" dir="ltr"><ff><?=getSampleAddr($rack,$rack_pos) ?></ff></div>        
                    </div>             
                    </div>
                    <div class="uLine cb"></div>        
                    <form name="subs_form" id="subs_form" action="<?=$f_path?>X/lab_sample_new.php" method="post" cb="<?=$cb?>" bv="a">  
                    <input type="hidden" name="id" value="<?=$id?>"/><input type="hidden" name="t" value="<?=$t?>"/>
                    <input type="hidden" name="sub" value="1" /><?
                    $sql="select * , x.id as xid from lab_x_visits_services x , lab_m_services z where x.service=z.id and  x.id IN($services)";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows>0){
                        echo '
                        <div class="f1 fs18 lh40 clr1">'.k_sel_tes_lnk_nsam.'</div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" ssr>';
                        while($r=mysql_f($res)){
                            $s_id=$r['xid'];
                            $name=$r['short_name'];
							$outlab=$r['outlab'];
                            $status=$r['status']; 
							$outTxt='';
							if($outlab){$outTxt='<div class="f1 clr5 lh20">'.k_out_test.'</div>';}                           				
                            echo '<tr>
                            <td width="30" no="'.$s_id.'"><input type="checkbox" name="s_'.$s_id.'" value="'.$s_id.'"/> </td>
                            <td class="ff B fs16">'.$name.$outTxt.'</td>                            
                            </tr>';
                        }
                        echo '</table>
                        <div class="f1 fs18 lh40 clr1">'.k_tube.'</div>
                        <div>'.make_Combo_box('lab_m_samples_packages','name_'.$lg,'id','','pkg',0,$pkg_id).'</div>
						<div class="f1 fs18 lh40 clr1">'.k_num_nw_sam.'</div>
                        <div><input type="text" name="no" required /></div>';
                    }?>
                    </form>
                </div>
                <div class="form_fot fr">
                    <div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
                    <div class="bu bu_t3 fl" id="saveButt" onclick="sub('subs_form')"><?=k_save?></div>
                </div>
            </div><?
		}
	}
}?>