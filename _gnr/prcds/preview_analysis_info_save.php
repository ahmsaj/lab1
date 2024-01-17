<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pars'])){
	$pars=pp($_POST['pars'],'s');
	
	$pa=explode('|',$pars);
	for($i=0;$i<count($pa);$i++){
		$p=explode(':',$pa[$i]);
		if(count($p)==3){			
			$id=$p[0];
			$val=$p[1];
			$not=$p[2];			
			mysql_q("UPDATE cln_x_pro_analy_items set value='$val' , note='$not' where id='$id'");	
			$ana_id=get_val('cln_x_pro_analy_items','ana_id',$id);
		}
	}
	mysql_q("UPDATE cln_x_pro_analy set view='1' where id='$ana_id'");
}?>