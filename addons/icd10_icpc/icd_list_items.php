<? include("../header.php");
if(isset($_POST['vis'],$_POST['t'],$_POST['r'],$_POST['sr'],$_POST['cat'])){
	$id=pp($_POST['vis']);
	$t=pp($_POST['t']);
	$r=pp($_POST['r']);
	$sr=pp($_POST['sr'],'s');
	$cat=pp($_POST['cat']);
	$p=25;
	$sp=$r*$p;
	$q=array();
	if($cat){
		array_push($q,"cat='$cat'");
	}else{
		// $cats=get_val('gnr_m_clinics',$icd_table_f[$t],$userSubType);
		// if($cats){array_push($q,"cat IN($cats)");}
	}
	if($sr){array_push($q," (name_$lg LIKE'%$sr%' OR code LIKE'%$sr%')");}
	$table=$icd_table[$t];
	$qq=implode(' AND ',$q);
	$all=getTotalCO($table,"$qq");
	if($qq){ $qq=" where $qq ";}
	$visItems=get_vals($icd_table_x[$t],'opr_id'," visit='$id' ",'arr');
	$sql="select * from $table $qq order by id ASC limit $sp , $p ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$recTotTxt=$rows;
	if($r>0){$rows=min(($r+1)*$p,$all);}
	if($all>=$rows){$recTotTxt=number_format($rows).'/'.number_format($all);}
	echo '<div class="pd10 f1 fs14">'.k_recs_num.' : <ff>'.$recTotTxt.'</ff></div>^';
	if($r!=0){echo '<div></div>';}
	if($rows){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$code=$r['code'];
			$name=$r['name_'.$lg];
			$cla='';
			if(in_array($id,$visItems)){$cla='class="hide" ';}
			echo '<div ic="'.$id.'" set="0" val="'.$name.'" code="'.$code.'" '.$cla.'>
				<div class="mg10 ff fs16 B clr5 lh30">'.hlight($sr,$code).'</div>
				<div class="mg10 f1 fs14 clr1" tit >'.hlight($sr,$name).'</div>
			</div>';
		}
		if($rows<$all){
			echo '<section class="ic40 icc1 ic40_det ic40Txt" loadMore>'.k_show_more.'</section>';
		}
	}
}?>