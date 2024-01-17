<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	
	$medRecEx=0;
	$r=getRecCon('gnr_m_patients_medical_info'," patient = '$id' ");	
	if($r['r']){		
		$rec_id=$r['id'];
		$sex=$r['sex'];		
		$birthDate=$r['birth_date'];
		$father_height=$r['father_height'];
		$mother_height=$r['mother_height'];
		$tPer=13;
		if($sex==2){$tPer=-13;}
		$exp_length=($father_height+$mother_height+$tPer)/2;
		list($GIval,$GIclr)=GINA(2,$sex,(18*12),$exp_length);
		$medRecEx=1;
	}else{
		$pat_Info=get_p_name($id,3);
		$sex=$pat_Info[4];
		$birthDate=$pat_Info[5];
	}
	$mosAge=gi_getMonthAge($birthDate);
	?>
	<div class="win_body">
	<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div>
	<div class="form_header so lh40 clr1 f1 fs18"><?=$pat_Info[0]?> 
	<span class="fs16 f1 clr5"> ( <?=$sex_types[$sex]?> | <?=$pat_Info[1]?> )</span>
	<div class="fr ic40 icc1 ic40_ref fr" title="<?=k_grow_indicators?>" onclick="growthIndic(<?=$id?>)"></div>
	</div>
	<div class="form_body of" type="pd0">
		<div class="fl of r_bord" fix="w:300|hp:0">
			<div class="f1 fs18 clr1 lh50 uLine pd10"><?=k_bas_ifo?>  <?
				if($medRecEx){					
					echo '
					<div class="fr ic40 icc1 ic40_edit" onclick="editMedPatInf('.$id.','.$rec_id.')" title="'.k_info_edit.'"></div>';
				}?>
			</div>
			<div class="pd10 ofx so" fix="hp:70" >
				<?
				if($medRecEx){?>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" over="0" type="static">
					<tr><td txt><?=k_fath_height?></td><td><ff class="clr8"><?=$father_height?></ff></td></tr>
					<tr><td txt><?=k_moth_height?></td><td><ff class="clr8"><?=$mother_height?></ff></td></tr>
					<tr><td txt><?=k_height_expctd?></td><td class="cbg8 clrw pd5"><ff class="clrw fs22"><?=$exp_length?></ff></td></tr>
					<tr><td txt><?=k_grow_indic?></td><td style="background-color:<?=$GIclr?>"><ff class="clrw fs22"><?=$GIval?></ff></td></tr>
					</table><?					
				}else{
					echo '<div class="f1 fs14 clr5 lh30 " >'.k_no_med_info_added.' </div>
					<div class="bu2 bu_t3 buu fl " onclick="addMedPatInf('.$id.','.$sex.',\''.$birthDate.'\')">'.k_info_add.'</div>';
				}
				?>
			</div>
		</div>
		<div class="fl of" fix="wp:300|hp:0">
			<div class="f1 fs18 clr1 lh50 uLine pd10"><?=k_thdata?> <?
			//if($medRecEx){					
				echo '
				<div class="fr ic40 icc4 ic40_add" onclick="addGI('.$id.','.$mosAge.')" title="'.k_read_add.'"></div>';
			//}?>
			</div>
			<div class="pd10 ofx so" fix="hp:50"><?
				$sql="select * from gnr_x_growth_indicators where patient='$id' order by age DESC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){?>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" over="0" class="grad_s holdH" type="static">
					<tr>
					<th width="95"></th>
					<th><?=k_age?></th>
					<th><?=k_weight?></th>
					<th><?=k_height?></th>					
					<th><?=k_head_circumf?></th>
					<th>BMI</th>
					<th width="60" title="<?=k_click_view_chart?>" class="Over" onclick="giChart(<?=$id?>,1)"><?=k_age?><br><?=k_weight?> <span class="clr6">*</span></th>
					<th width="60" title="<?=k_click_view_chart?>" class="Over" onclick="giChart(<?=$id?>,2)"><?=k_age?><br><?=k_height?> <span class="clr6">*</span></th>					
					<th width="60" title="<?=k_click_view_chart?>" class="Over" onclick="giChart(<?=$id?>,3)"><?=k_age?><br><?=k_head?> <span class="clr6">*</span></th>
					<th width="60" title="<?=k_click_view_chart?>" class="Over" onclick="giChart(<?=$id?>,4)"><?=k_age?><br>BMI <span class="clr6">*</span></th>
					<th width="60" title="<?=k_click_view_chart?>" class="Over" onclick="giChart(<?=$id?>,5)"><?=k_weight?><br><?=k_height?> <span class="clr6">*</span></th>
					</tr><?
					while($r=mysql_f($res)){
						$gi_id=$r['id'];
						$age=$r['age'];
						$weight=$r['weight'];
						$Length=$r['Length'];
						$head=$r['head'];
						$user=$r['user'];
						$BMI=$weight/($Length/100*$Length/100);
						$HA_GIval=$HA_GIclr=$B_GIval=$B_GIclr='';
						list($W_GIval,$W_GIclr)=GINA(1,$sex,$age,$weight);
						list($H_GIval,$H_GIclr)=GINA(2,$sex,$age,$Length);
						if($head && $age<=36){list($HA_GIval,$HA_GIclr)=GINA(3,$sex,$age,$head);}
						if($age>=24){list($B_GIval,$B_GIclr)=GINA(4,$sex,$age,$BMI);}
						list($HW_GIval,$HW_GIclr)=GINA(5,$sex,$Length,$weight);

						?>
						<tr>
						<td><? if($user==$thisUser){?>
						<div class="fl ic40 icc1 ic40_edit" onclick="editGI(<?=$gi_id?>,<?=$id?>)"></div>
						<div class="fl ic40 icc2 ic40_del" onclick="delGI(<?=$gi_id?>,<?=$id?>)"></div>
						<? }?>
						</td>
						<td><ff><?=$age?></ff></td>
						<td><ff><?=$weight?></ff></td>
						<td><ff><?=$Length?></ff></td>						
						<td><ff><?=$head?></ff></td>
						<td><ff><?=number_format($BMI,5)?></ff></td>
						<td style="background-color:<?=$W_GIclr?>"><ff class="clrw fs22"><?=$W_GIval?></ff></td>
						<td style="background-color:<?=$H_GIclr?>"><ff class="clrw fs22"><?=$H_GIval?></ff></td>
						<td style="background-color:<?=$HA_GIclr?>"><ff class="clrw fs22"><?=$HA_GIval?></ff></td>
						<td style="background-color:<?=$B_GIclr?>"><ff class="clrw fs22"><?=$B_GIval?></ff></td>
						<td style="background-color:<?=$HW_GIclr?>"><ff class="clrw fs22"><?=$HW_GIval?></ff></td>
						</tr><?

					}?>
					</table><?
				}?>
			</div>
		</div>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#full_win1');"><?=k_close?></div>     
    </div>
    </div><?
}?>