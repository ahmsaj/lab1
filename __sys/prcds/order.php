<? include("ajax_header.php");
if(isset($_POST['t'] , $_POST['c'] , $_POST['d'] , $_POST['mod'])){
	$t=$_POST['t'];//table
	$c=$_POST['c'];//colume
	$d=$_POST['d'];//data
	$mod=$_POST['mod'];//module
	$ord_status=1;
	$x='';
	if($mod && $t==''){
		$mod_data=loadModulData($mod);
		$t=$mod_data[1];
		$c=$mod_data[3];
		$ord_status=$mod_data[12];
	}
	$reset=0;
	$ordrs=array();
	if($d!='' && $ord_status && $c!='id'){
		$dd=explode('|',$d);
		foreach($dd as $row){
			$ord_data=explode(':',$row);
			$id=$ord_data[0];
			$ord=$ord_data[1];
			if(in_array($ord,$ordrs)){$reset=1;}
			array_push($ordrs,$ord);			
			mysql_q("UPDATE `$t` SET $c='$ord' where id='$id' ");
		}
	}
	if($ord_status==0 || $c=='id' || $reset){$x='x';}
	if($reset && $mod){resetOrder($mod_data[1],$mod_data[3]);}
	echo $x;
}
?>