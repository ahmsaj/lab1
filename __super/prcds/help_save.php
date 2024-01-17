<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'],$_POST['mod'])){	
	$t=$_POST['t'];
	$mod=$_POST['mod'];
	$modCode='';
	if($t){		
		$table=$modTable[$t];		
		$r=getRecCon($table,$mod);
		$col=$vals='';
		if($r['r']){
			$modCode=$r['code'];
			foreach($lg_s_f as $l){
				$col.=',title_'.$l;
				$vals.=",'".$r['title_'.$l]."'";
			}
			
		}
	}
	$code=getRandString(10);
	$ord=getMaxValOrder('_help','ord');
	$sql="INSERT INTO _help (`code`,`type`,`mod`,`ord`$col)values('$code','$t','$modCode','$ord'$vals)";
	if(mysql_q($sql)){echo last_id();}	
}?>