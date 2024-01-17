<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	if($r['r']){
		$visStatus=$r['status'];
		$r=getRec('gnr_x_growth_indicators',$id);
		if($r['r']){
			$v_id=$r['id'];
			$age=$r['age'];						
			$weight=$r['weight'];
			$Length=$r['Length'];
			$head=$r['head'];
			$date=$r['date'];
			$doc=$r['user'];			
			list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);	
			$birthCount=birthCount($birth);
			if(($doc==$thisUser) && ($visStatus==1 || _set_whx91aq4mx)){?>
				<div class="fr ic30 ic30_del icc22 ic30Txt" giVdel><?=k_delete?></div>
				<div class="fr ic30 ic30_edit icc11 ic30Txt mg5" giVedit><?=k_edit?></div><? 
			}?>
			<div class="lh40 clr1111 f1s fs14x "><?
			echo get_p_name($pat);
			echo ' <span class="clr1 f1 fs14 "> ( '.$sex_types[$sex]. ' ) </span>
			<ff class="clr55"> '.$birthCount[0].' </ff>
			<span class="clr55 f1 fs14 clr55"> '.$birthCount[1]. '</span>';?>
			</div>			
			<div class="f1 fs12 lh20"><?=k_date?> : <ff14><?=date('Y-m-d',$date)?></ff14></div>
			<div class="f1 fs12 lh30"><?=k_ses_leader?> : <?=get_val('_users','name_'.$lg,$doc)?></div>
			<div class="f1 clr1111 fs14 lh40 uLine"><?=k_grow_indicators?></div>
			<div class="giView"><?
				$BMI=$weight/($Length/100*$Length/100);
				$HA_GIval=$HA_GIclr=$B_GIval=$B_GIclr='';
				list($W_GIval,$W_GIclr)=GI_NA(1,$sex,$age,$weight);
				list($H_GIval,$H_GIclr)=GI_NA(2,$sex,$age,$Length);
				if($head && $age<=36){list($HA_GIval,$HA_GIclr)=GI_NA(3,$sex,$age,$head);}
				if($age>=24){list($B_GIval,$B_GIclr)=GI_NA(4,$sex,$age,$BMI);}
				list($HW_GIval,$HW_GIclr)=GI_NA(5,$sex,$Length,$weight);
				echo '
				<table   border="0" cellspacing="5" cellpadding="4" class="gi_table holdH">
					<tr>
						<td class="fs12 f1" width="140">'.k_age.'</td>
						<td width="100"><ff14>'.$age.'</ff14></td>
						<td class="fs12 f1" width="100"></td>
					</tr>
					<tr>
						<td class="fs12 f1">'.k_weight.'</td>
						<td><ff14>'.$weight.'</ff14></td>
						<td><div cb style="background-color:'.$W_GIclr.'">'.$W_GIval.'</div></td>						
					</tr>
					<tr>
						<td class="fs12 f1">'.k_height.'</td>
						<td><ff14>'.$Length.'</ff14></td>
						<td><div cb style="background-color:'.$H_GIclr.'">'.$H_GIval.'</div></td>
					</tr>
					<tr>
						<td class="fs12 f1">'.k_head_circumf.'</td>
						<td><ff14>'.$head.'</ff14></td>
						<td><div cb style="background-color:'.$HA_GIclr.'">'.$HA_GIval.'</div></td>
					</tr>
					<tr>
						<td class="fs12 f1">BMI</td>
						<td><ff14>'.number_format($BMI,3).'</ff14></td>
						<td><div cb style="background-color:'.$B_GIclr.'">'.$B_GIval.'</div></td>
					</tr>
					<tr>
						<td class="fs12 f1" colspan="2">'.k_weight.'-'.k_height.'</td>
						<td><div cb style="background-color:'.$HW_GIclr.'">'.$HW_GIval.'</div></td>
					</tr>
				</table>';?>
			</div>
			<div class="ic40 ic40_save icc ic40Txt fl mg10v" vsSave><?=k_save?></div>
			
			<?
		}
	}
}?>