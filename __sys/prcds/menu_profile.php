<? include("../../__sys/prcds/ajax_header.php");
$r=getRec('_users',$thisUser);
if($r['r']){
	$name=$r['name_'.$lg];
	$photo=$r['photo'];
	$sex=$r['sex'];
	$lang=$r['lang'];
	$theme=$r['theme'];
	$bio=$r['bio_'.$lg];
	$grpTxt=get_val_c('_groups','name_'.$lg,$thisGrp,'code');
	
	?>
	<div class="fx mp_title mg10t">
		<div class="fl pd10 r_bord" ><?=viewPhotos_i($photo,1,40,50,'css','nophoto'.$sex.'.png')?></div>
		<div class="">
			<div class="f1 fs16 lh30 clrw pd10"><?=$name?> </div>
			<div class="f1 fs12 clr9 lh30 pd10"><?=$grpTxt?></div>
		</div>
	</div>
	
	<div >
		<?
		echo '<div class="f1 fs16 lh40">'.k_main_lang.' : <ff class="uc">'.$lang.'</ff></div>';
		$r=getRec('_themes',$theme);
		if($r['r']){		
			echo '<div class="fl mg10v">
				<div class="fl f1 fs16 lh30">'.k_theme.' : </div>
				<div class="fl pd10 lh30">
					<div class="fl ic30x br0" style="background-color:'.$r['c1111'].'"></div>
					<div class="fl ic30x br0" style="background-color:'.$r['c1'].'"></div>
					<div class="fl ic30x br0" style="background-color:'.$r['c11'].'"></div>
					<div class="fl ic30x br0" style="background-color:'.$r['c111'].'"></div>			
					<div class="fl ic30x br0" style="background-color:'.$r['c44'].'"></div>
				</div>
			</div>
			';
		}
		?>&nbsp;
		<div class="mwEditPro"><div class="fl" ico ></div><?=k_edit_account?></div><?
		if($bio){
			echo '<div class="cb f1 fs16 lh40">BIO : </div>';
			echo '<div class="cb fs14 TJ lh20">'.nl2br($bio).' </div>';
		}
		?>
	</div>
	<?
}?>