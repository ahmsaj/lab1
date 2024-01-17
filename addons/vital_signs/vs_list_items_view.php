<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	if($r['r']){
		$visStatus=$r['status'];
		$r=getRec('cln_x_vital',$id);
		if($r['r']){
			$date=$r['date'];
			$doc=$r['doc'];			
			list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);	
			$birthCount=birthCount($birth);
			if(($doc==$thisUser) && ($visStatus==1 || _set_whx91aq4mx)){?>
				<div class="fr ic30 ic30_del icc22 ic30Txt" vsVdel><?=k_delete?></div>
				<div class="fr ic30 ic30_edit icc11 ic30Txt mg5" vsVedit><?=k_edit?></div><? 
			}?>
			<div class="lh40 clr1111 f1s fs14x "><?
			echo get_p_name($pat);
			echo ' <span class="clr1 f1 fs14 "> ( '.$sex_types[$sex]. ' ) </span>
			<ff class="clr55"> '.$birthCount[0].' </ff>
			<span class="clr55 f1 fs14 clr55"> '.$birthCount[1]. '</span>';?>
			</div>			
			<div class="f1 fs12 lh20"><?=k_date?> : <ff14><?=date('Y-m-d',$date)?></ff14></div>
			<div class="f1 fs12 lh30"><?=k_ses_leader?> : <?=get_val('_users','name_'.$lg,$doc)?></div>
			<div class="f1 clr1111 fs14 lh40 uLine"><?=k_vital_signs?></div>
			<div class="vsView"><?
				$sql="select *from cln_x_vital_items where session_id ='$id'  order by id ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){						
					while($r=mysql_f($res)){
						$v_id=$r['id'];
						$vital=$r['vital'];						
						$value=$r['value'];
						$v_type=$r['v_type'];
						$norVal=$r['normal_val'];
						$norAdd=$r['add_value'];
						$vsClr='';
						if($norVal){				
							list($value,$clr,$vnTxt,$nv1,$nv2)=vsGetVal($v_type,$value,$norVal,$norAdd);
							$vsClr=$vsCol[$clr];
						}
						echo '<div class="fl">
							<div n class="'.$vsClr.'">'.$value.'</ff></div>
							<div t class="fs14">'.get_val('cln_m_vital','name_'.$lg,$vital).'</div>
						</div>';
					}
				}?>
			</div>
			<div class="ic40 ic40_save icc ic40Txt fl mg10v" vsSave><?=k_save?></div>
			
			<?
		}
	}
}?>