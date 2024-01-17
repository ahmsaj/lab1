<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'])){
	$id=pp($_POST['vis']);	
	$pat=pp($_POST['pat']);
	$act=pp($_POST['act']);
	$r=getRecCon('cln_x_visits'," id='$id' and patient='$pat'");
	if($r['r']){
		$sql="select * from cln_x_vital where patient='$pat' order by date DESC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		echo '
		<div class="fl pd10 f1 fs14 lh40">'.k_no_of_sessions.' : <ff>'.$rows.'</ff></div>
		<div class="fr ic40x icc33 ic40_add br0" addvs></div>
		^';	
		if($rows){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$date=$r['date'];
				$doc=$r['doc'];
				$docNome=get_val_arr('_users','name_'.$lg,$doc,'doc');
				$a='';
				if($act==$id){$a='act';}
				echo '<div vs="'.$id.'" set="0" '.$a.'>
					<div class="f1 pd10 lh40 fs14">'.$docNome.'</div>
					<div class="mg10 f1 fs16 clr1" tit ><ff>'.date('Y-m-d',$date).'</ff></div>
				</div>';
			}
		}
	}
}?>