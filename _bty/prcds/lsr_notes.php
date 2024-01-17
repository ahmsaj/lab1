<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){
	$vis=pp($_POST['vis']);
	$r=getRec('bty_x_laser_visits',$vis);
	if($r['r']){
		$doctor=$r['doctor'];
		$pat=$r['patient'];
		$status=$r['status'];
		if($doctor==$thisUser){			
			$sql="select * from bty_x_laser_visits_notes where patient ='$pat' order by date DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			echo '<div class="fl ic30x mg10v icc4  ic30_add" addNote title="'.k_add.'"></div>
			<div class="fl lh50 f1 fs18 clr1 pd10">'.k_notes.' <ff> ( '.$rows.' ) </ff></div>^';
			if($rows>0){
				echo '<div class="pd10f">';
				while($r=mysql_f($res)){
					$id=$r['id'];
					$user=$r['user'];
					$date=$r['date'];
					$note=$r['note'];
					$userTxt=get_val_arr('_users','name_'.$lg,$user,'u');
					$buts='';
					if($user==$thisUser){
						$buts='<div class="fr i30 i30_edit" ne="'.$id.'"></div>
						<div class="fr i30 i30_del" nd="'.$id.'"></div>';
					}
					echo '<div class="fl w100" fix="w:600">
						<div class="fl w100">'.$buts.'
							<div class="f1 fs14 clr55 lh40">'.$userTxt.'</div>
							<div class="f1 fs10  clr1"><ff14 class="c">'.date('Y-m-d',$date).'</ff14></div>
						</div>
						<div class="fs12 lh20 uLine pd10v">'.nl2br($note).'</div>
					</div>';
				}
				echo '</div>';
			}	
		}
	}
}

?>