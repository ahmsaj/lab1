<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if($id){
		$sql="select pkg_id , count(pkg_id) c from lab_x_visits_samlpes where grp='$id' group by pkg_id order by c DESC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;				
			$thisP=0;				
			while($r=mysql_f($res)){
				$c=$r['c'];					
				$pkg_id=$r['pkg_id'];				
				$total_samples.='<div class="fl lh50 pd5">
					<div class="fl lh40 pd10 cbg2 clrw"><ff>'.$c.'</ff></div>
					<div class="fl lh40 cbg1 clrw f1 fs16 pd10">
						'.get_val('lab_m_samples_packages','name_'.$lg,$pkg_id).'
					</div>&nbsp;
				</div>';
			}
		}
		
		$rec=getRec('lab_x_visits_samlpes_group',$id);
		$sql="select * from lab_x_visits_samlpes where grp='$id' order by patient ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		?>
		<div class=" uLine mg10 lh40">
		<div class="f1 fs18 lh40 clr1 fl"><?=k_paym?> : <span class="f1 fs18 lh40 clr6"><?=splitNo($rec['name'])?></span> | <?=k_samples_num?> :<ff class="clr6"> ( <?=$rows?> ) </ff></div>
			<div class="fr ic40 icc2 ic40_print" title="<?=k_print?>" onclick="printSG(<?=$id?>)"></div>
			<? if($rec['status']==0){
				echo '<div class="fr ic40 icc1 ic40_send" onclick="sendSG('.$id.')" title="'.k_send.'" ></div>';
			}?>
			<div class="lh50 fl w100 f1 fs16"><?=$total_samples?></div>
			&nbsp;
		</div>
		<div fix="hp:51" class="mg10 ofx so cb"><?
			if($rows>0){
				$i=0;
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
				<tr><th>'.k_sample.'</th><th>'.k_patient.'</th><th>'.k_tk_sams.'</th><th>'.k_tests.'</th><th>'.k_tim.'</th></tr>';
				$thisP=0;
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$visit_id=$r['visit_id'];
					$pkg_id=$r['pkg_id'];
					$services=$r['services'];
					$no=$r['no'];
					$s_taker=$r['s_taker'];
					$date=$r['date'];
					$status=$r['status'];		
					$fast=$r['fast'];
					$sub_s=$r['sub_s'];
					$per_s=$r['per_s'];
					$p=$r['patient'];
					$p_data=get_p_name($p,3);

					$fastTxt='';if($fast){$fastTxt='<div class="cb f1 clr5">'.k_emergency.'</div>';}
					$perTxt='';if($per_s){$perTxt='<div class="cb f1 clr5">'.k_bu_sam.'</div>';}

					echo '<tr>
					<td>'.get_samlpViewC(0,$pkg_id,2,$no).$fastTxt.$perTxt.'</td>';
					if($p!=$thisP){
						$pT=getTotalCO('lab_x_visits_samlpes',"status=2 and visit_id ='$visit_id' and grp='$id' and patient='$p'");
						echo '<td rowspan="'.$pT.'"><div class="f1 lh20">'.$p_data[0].' ('.$p_data[1].')</div></td>';
					}
					echo '<td class="f1 fs14">'.get_val('lab_m_samples_takers','name',$s_taker).'</td>
					<td>'.getLinkedAna(2,0,$services).'</td>
					<td>'.dateToTimeS2($now-$date).'</td>
					</tr>';
					$thisP=$p;
				}
				echo '</table>';
			}?>
				
		</div>
		<?
	}else{
		$sql="select pkg_id , count(pkg_id) c from lab_x_visits_samlpes where grp='0' and status=2 group by pkg_id order by c DESC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;				
			$thisP=0;				
			while($r=mysql_f($res)){
				$c=$r['c'];					
				$pkg_id=$r['pkg_id'];
				$total_samples.='<div class="fl lh50 pd5">
					<div class="fl lh40 pd10 cbg2 clrw"><ff>'.$c.'</ff></div>
					<div class="fl lh40 cbg1 clrw f1 fs16 pd10">
						'.get_val('lab_m_samples_packages','name_'.$lg,$pkg_id).'
					</div>&nbsp;
				</div>';
			}
		}
		
		$sql="select * from lab_x_visits_samlpes where grp=0 and status=2 order by patient ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);?>
		
		<div class=" uLine mg10 lh40">
			<div class="f1 fs18 lh40 clr1 fl"> <?=k_samples_unassembled?> <ff> ( <?=$rows?> ) </ff></div>
			<div class="fr ic40 icc2 ic40_add hide" title="<?=k_add_samples_group?>" onclick="addTosGrp()"></div> 
			<div class="lh50 fl w100 f1 fs16"><?=$total_samples?></div>&nbsp;
		</div>
		<div fix="hp:51" class="mg10 ofx so cb">
			<form name="sampgrp" id="sampgrp" method="post" action="<?=$f_path?>X/lab_sample_groups_select_save.php" cb="sampelsGropInfo([1]);" bv="a">
			<input type="hidden" name="grp_id" id="grp_id" value="0"/>
			<input type="hidden" name="grp_name" id="grp_name" value=""/><?			
			if($rows>0){
				$i=0;
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
				<tr><th style="width: 30px;"><input type="checkbox" class="" par="check_all" name="ic40_add"/></th><th>'.k_sample.'</th><th>'.k_patient.'</th><th>'.k_tk_sams.'</th><th>'.k_tests.'</th><th>'.k_tim.'</th></tr>';
				$thisP=0;
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$visit_id=$r['visit_id'];
					$pkg_id=$r['pkg_id'];
					$services=$r['services'];
					$no=$r['no'];
					$s_taker=$r['s_taker'];
					$date=$r['date'];
					$status=$r['status'];		
					$fast=$r['fast'];
					$sub_s=$r['sub_s'];
					$per_s=$r['per_s'];
					$p=$r['patient'];
					$p_data=get_p_name($p,3);

					$fastTxt='';if($fast){$fastTxt='<div class="cb f1 clr5">'.k_emergency.'</div>';}
					$perTxt='';if($per_s){$perTxt='<div class="cb f1 clr5">'.k_bu_sam.'</div>';}

					echo '<tr>
					<td params="'.$s_id.'">
					<input name="rec[]" type="checkbox" par="grd_chek" value="'.$s_id.'" /></td>
					<td>'.get_samlpViewC(0,$pkg_id,2,$no).$fastTxt.$perTxt.'</td>';
					if($p!=$thisP){
						$pT=getTotalCO('lab_x_visits_samlpes',"status=2 and patient='$p'");
						echo '<td rowspan="'.$pT.'"><div class="f1 lh20">'.$p_data[0].' ('.$p_data[1].')</div></td>';
					}
					echo '<td class="f1 fs14">'.get_val('lab_m_samples_takers','name',$s_taker).'</td>
					<td>'.getLinkedAna(2,0,$services).'</td>
					<td>'.dateToTimeS2($now-$date).'</td>
					</tr>';
					$thisP=$p;
				}
				echo '</table>';
			}?>
			</form>
		</div>
		<?
	}
}?>