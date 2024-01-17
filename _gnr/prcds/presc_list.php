<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['ser'],$_POST['cat'],$_POST['pre'])){
	$pre=pp($_POST['pre']);
	$ser=pp($_POST['ser'],'s');
	$cat=pp($_POST['cat']);
	$q='';
	if($cat){$q=" AND cat='$cat' ";}
	if($ser){$q.="AND name like '%$ser%' ";}	
	$selectedMdcArr=get_vals('gnr_x_prescription_itemes','mad_id',"presc_id='$pre'",'arr');
	
	$allRows=getTotalCO('gnr_m_medicines'," name!='' $q ");
	$sql=" SELECT id,name FROM  gnr_m_medicines where name!='' $q order by name ASC limit 200";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$rowsTxt=$rows;
	if($allRows>$rows){$rowsTxt=number_format($allRows).'/'.$rows;}
	echo '( '.$rowsTxt.' )^';
	if($rows>0){
		echo '<div class="listStyle pd5" mdcList>';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name'];
			$h='';
			if(in_array($id,$selectedMdcArr)){$h='hide';}
			echo '<div mn="'.$id.'" class="'.$h.'">'.splitNo(hlight($ser,$name)).'</div>';
		}
		echo'</div>';	
	}else{
		echo '<div class="f1 fs16 clr5 lh30 TC">'.k_no_results.'</div>';
	}
	
}?>