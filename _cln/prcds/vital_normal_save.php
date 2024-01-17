<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['r_id'])){
	$r_id=pp($_POST['r_id']);
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$sel_sex=0;
	$sel_age=0;
	$sql="select * from cln_m_vital where id='$r_id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$r_name=$r['name_'.$lg];
		$type=$r['type'];
		$age='';
		$defVal='';
		$Value='';
		$add_pars='';		
		$sex=pp($_POST['sex']);
		$l_age0=pp($_POST['age0']);
		$l_age1=pp($_POST['age1']);
		$l_age2=pp($_POST['age2']);
		//if($t==2){$type=8;}
		if($l_age1 || $l_age2){$age=$l_age0.','.$l_age1.','.$l_age2;}
		/********************************/
		if($type==1){
			$p1=pp($_POST['p1'],'f');
			$p2=pp($_POST['p2'],'f');
			$p4=pp($_POST['p4'],'f');
			$p5=pp($_POST['p5'],'f');
			$p6=pp($_POST['p6'],'f');
			$p7=pp($_POST['p7'],'f');
			$Value=$p1.','.$p2.','.$p4.','.$p5;			
			if($p6){
				$add_pars=$p6.','.$p7;
			}
		}
		if($type==2){
			$p1=pp($_POST['p1']);
			$p2=pp($_POST['p2']);
			$Value=$p1.','.$p2;
		}	
		/********************************/
		if($id){
			$sql="UPDATE  cln_m_vital_normal set `sex`='$sex', `age`='$age',  `add_pars`='$add_pars',
			`value`='$Value' where id='$id' and vital='$r_id'";
		}else{
			$sql="INSERT INTO cln_m_vital_normal (`vital`,`sex`,`age`,`add_pars`,`value`,`type`)
			values('$r_id','$sex','$age','$add_pars','$Value','$t')";
		}
		if(mysql_q($sql)){echo 1;}
	}
}