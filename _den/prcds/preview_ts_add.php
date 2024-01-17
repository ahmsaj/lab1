<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['n'],$_POST['t'],$_POST['p'])){
	$n=pp($_POST['n']);
	$t=pp($_POST['t']);
	$p=pp($_POST['p']);
	$ch=getTotalCO('den_m_teeth',"no='$n'");
	if($ch && (($t==1 && $p<8) || ($t==2 && $p<13)) && $p>0 ){
		if($t==1){$tSub=$facCodes[$p];$title=k_face;}else{$tSub=$cavCodes[$p];$title=k_canal;}?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18">
			<div class="fs18 f1 clr1 lh40 fl"><?=k_sub_stat_choose?> </div>
			<div class="ic40 icc1 ic40n fr" title="<?=k_tooth?>"><?=$n?></div>
			<div class="ic40 icc2 ic40n fr uc" title="<?=$title?>"><?=$tSub?></div>
		</div>
		<div class="form_body so">
			<div class="teethSs"><? 
			if($t==1){
				$sql="select * from den_m_set_teeth where opr_type=2 and  act =1";
				$res=mysql_q($sql);				
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$name=$r['name_'.$lg];
					$photo=$r['icon'];
					$color=$r['color'];
					$ph_src=viewImage($photo,1,80,80,'img','clinic30.png');
					echo '
					<div style="border-bottom:14px '.$color.' solid" spss="'.$s_id.'">
						<div img>'.$ph_src.'</div>
						<div txt>'.$name.'</div>
					</div>';
				}
			}
			if($t==2){
				$sql="select * from den_m_set_roots where opr_type=2 and  act =1";
				$res=mysql_q($sql);				
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$name=$r['name_'.$lg];
					$photo=$r['icon'];
					$color=$r['color'];
					$ph_src=viewImage($photo,1,80,80,'img','clinic30.png');
					echo '
					<div style="border-bottom:14px '.$color.' solid" spss="'.$s_id.'">
						<div img>'.$ph_src.'</div>
						<div txt>'.$name.'</div>
					</div>';
				}
				
			}?>
			</div>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
		</div>
		</div><?
	}
}?>