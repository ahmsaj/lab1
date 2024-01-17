<? include("../header.php");
if(isset($_POST['vis'],$_POST['t'],$_POST['r'],$_POST['sr'])){
	$id=pp($_POST['vis']);
	$t=pp($_POST['t']);
	$r=pp($_POST['r']);
	$sr=pp($_POST['sr'],'s');
	$p=25;
	$sp=$r*$p;
	$q='';
	if($sr){$q=" and val LIKE'%$sr%'";}
	$table=$mp_table[$t].'_tmp';
	$all=getTotalCO($table,"  doc='$thisUser' $q ");		
	$sql="select * from $table where doc='$thisUser' $q order by times DESC limit $sp , $p ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$recTotTxt=$rows;
	if($r>0){$rows=min(($r+1)*$p,$all);}
	if($all>=$rows){$recTotTxt=number_format($rows).'/'.number_format($all);}
	echo '<div class="pd10 f1 fs14">'.k_templates.'  : <ff>'.$recTotTxt.'</ff></div>^';
	if($rows){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$val=$r['val'];			
			echo '<div tn="'.$id.'" set="0" val="'.$val.'">
				<div class="mg10 f1 fs14 clr1" tit >'.hlight($sr,$val).'</div>
				<div class=" lh30 fs16 ff B b_bord pd10" >
					<div class="i30 i30_del fr" delTmp title="'.k_delete.'"></div>
					<div class="i30 i30_edit fl" editTmp title="'.k_edit.'"></div>
				</div>				
			</div>';
		}
		if($rows<$all){
			echo '<section class="ic40 icc1 ic40_det ic40Txt" loadMore>'.k_show_more.'</section>';
		}
	}
}?>