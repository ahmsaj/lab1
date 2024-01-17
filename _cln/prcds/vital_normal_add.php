<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['r_id'] , $_POST['t'])){
	$r_id=pp($_POST['r_id']);
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);	
	$sel_sex=0;
	$sel_age=0;
	$sql="select * from cln_m_vital where id='$r_id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$r_name=$r['name_'.$lg];
		$serv=$r['serv'];
		$type=$r['type'];
		$unit=$r['unit'];
	}
	$sel1=" checked ";
	if($id){
		$sql="select * from cln_m_vital_normal where id='$id'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$sex=$r['sex'];
			$age=$r['age'];			
			$add_pars=$r['add_pars'];
			$value=$r['value'];
			if($age){
				$a=explode(',',$age);
				$age0=$a[0];
				$age1=$a[1];
				$age2=$a[2];
			}
			
			if($type==1){				
				$pp=explode(',',$value);
				$p1=$pp[0];
				$p2=$pp[1];
				$p4=$pp[2];
				$p5=$pp[3];
				if($p1==0 && $p5==0){$p1=$p5='';}				
				$ap=explode(',',$add_pars);
				if(count($ap)>1){
					$p6=$ap[0];
					if($ap[1]==1){$sel1=' checked '; $sel2='';}
					if($ap[1]==2){$sel1=''; $sel2=' checked ';}
				}
			}
			if($type==2){
				$pp=explode(',',$value);
				$p1=$pp[0];
				$p2=$pp[1];
			}			
		}else{			
			exit;
		}	
	
	}?>
	
	<div class="win_body">
    <div class="form_header">
		<div class="fl lh40 fs18 f1 clr1 ws"><?=$r_name?> <? if($unit_c){echo '<ff> [ '.$unit_c.' ] </ff>';}?></div>
    </div>
	<div class="form_body so">
    <form name="lvv_form" id="lvv_form" action="<?=$f_path.'X/cln_vital_normal_save.php'?>" method="post" cb="vitalNormal(<?=$r_id?>)" bv="">
    <input type="hidden" name="id" value="<?=$id?>" />
    <input type="hidden" name="r_id" value="<?=$r_id?>" />
    <input type="hidden" name="t" value="<?=$t?>" />
	<?
	if($type==1){$sel_sex=1;$sel_age=1;}
	if($type==2){$sel_sex=1;$sel_age=1;}
		
	if($sel_sex || $sel_age){
		$step='';		
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" >';
		if($sel_sex){
			echo '
			<tr>
				<td class="f1 lh40 fs16 clr1" width="10%" >'.k_sex.':</td>
				<td colspan="3">
				<select class="f1 fs14" name="sex" style="font-size:18px">';
				foreach($sex_types as $key => $t){
					$sel='';
					if($sex==$key)$sel=" selected ";
					echo '<option  value="'.$key.'" class="f1 fs14" '.$sel.'>'.$t.'</option>';
				}
				echo '</select>
				</td>
			</tr>';
		}
		if($sel_age){
			echo '
			<tr>
			<td class="f1 lh40 fs16 clr1" width="10%">'.k_age.':</td>						
			<td width="33%">
			<input type="number" name="age1" id="l_age1" value="'.$age1.'" placeholder="'.k_from.'" class="ff fs18 TC" onkeyup="vitalCheckAge()"/></td>
			<td width="33%">
			<input type="number" name="age2" id="l_age2" value="'.$age2.'" placeholder="'.k_to.'" class="ff fs18 TC" onkeyup="vitalCheckAge()"/></td>
			<td width="33%">
				<select class="f1 fs14 TC" name="age0" id="l_age0" style="font-size:18px">';
				foreach($age_types as $key => $a){
					$sel='';
					if($age0==$key)$sel=" selected ";
					echo '<option value="'.$key.'" class="f1 fs14" '.$sel.'>'.$a.'</option>';
				}			
				echo '</select>		
			</td>
			</tr>
			';
		}
		echo '</table>';
		echo '<div class="uLine">&nbsp;</div>';
	}
	
    if($type==1){
		$step='';
		if($unit_d){$step='step="0.'.str_repeat('0',$unit_d-1).'1"';}
		echo '
		<table width="100%" border="0" cellspacing="0" cellpadding="4">               
		<tr>
		<td class="f1 TC clr5">'.k_min_crtcl.'</td>
		<td class="f1 TC clr6">'.k_min_nor.'</td>
		<td class="f1 TC clr6">'.k_max_nor.'</td>
		<td class="f1 TC clr5">'.k_max_crtcl.'</td>
		</tr>
		<tr>
		<td><input name="p1" id="p1" type="number" '.$step.' value="'.$p1.'"></td>
		<td><input name="p2" id="p2" type="number" '.$step.' value="'.$p2.'" required></td>
		<td><input name="p4" id="p4" type="number" '.$step.' value="'.$p4.'" required></td>
		<td><input name="p5" id="p5" type="number" '.$step.' value="'.$p5.'"></td>
		</tr>		
		</table>
		<div class="f1 clr1 fs16 lh40">'.k_res_rng_frm.'</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="4">               
		<tr>
		<td class="f1 ">'.k_rng_rt.'</td>
		<td class="f1 ">'.k_rng_typ.'</td>
		</tr>
		<tr>
		<td><input name="p6" id="p6" type="number" '.$step.' value="'.$p6.'"></td>
		<td>
		<div class="radioBlc so fl" name="p7" req="1" >
			<input type="radio" name="p7" value="1" '.$sel1.'/><label>'.k_num.'</label>
			<input type="radio" name="p7" value="2" '.$sel2.'/><label>'.k_percent.'</label>
		
		</div>	
		</td>

		</tr>		
		</table>
		';
	}
	if($type==2){
		$step='';
		if($unit_d){$step='step="0.'.str_repeat('0',$unit_d-1).'1"';}
		echo '
		<table width="100%" border="0" cellspacing="0" cellpadding="4">               
		<tr>
		<td class="f1 TC clr1 fs16">'.k_operation.'</td>
		<td class="f1 TC clr1 fs16">'.k_val.'</td>
		</tr>
		<tr>
		<td>
		<select class="f1 fs14 TC" name="p1" style="font-size:18px">';
			foreach($anT2_types as $key => $a){
				$sel='';
				if($p1==$key)$sel=" selected ";
				echo '<option value="'.$key.'" class="f1 fs14" '.$sel.'>'.$a.'</option>';
			}			
			echo '</select>
		</td>
		<td><input name="p2" id="p2" type="number" '.$step.' value="'.$p2.'"></td>
		</tr>		
		</table>
		';
	}
	?>
    </form>
	</div>
	<div class="form_fot fr">
	    <div class="bu bu_t3 fl" onclick="vitalNormal_save(<?=$type?>);"><?=k_save?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
	</div>
	</div><?
}?>
<script>
sel_sex=<?=$sel_sex?>;
sel_age=<?=$sel_age?>;
</script>

