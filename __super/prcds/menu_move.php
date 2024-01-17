<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['data'])){
	$d=explode('|',$_POST['data']);
	if(count($d)==4){
		$id_from=$d[0];
		$id_to=$d[1];
		$type_from=$d[2];
		$type_to=$d[3];		
		if($type_from=='mod' || $type_from=='mod2'){
			$code=getRandString(10);			
			if($type_from=='mod'){
				$type=1;
				$table='_modules';
			}
			if($type_from=='mod2'){
				$type=2;
				$table='_modules_';
			}
			$r=getRecCon($table," code='$id_from' ");
			if($r['r']){
				$qr1=$qr2='';
				foreach($lg_s as $l){
					$qr1.=",title_$l";
					$qr2.=",'".$r['title_'.$l]."'";
				}
				$ord=getMaxValOrder('_modules_list','ord'," where p_code='$id_to'");			
				if(mysql_q("insert into _modules_list (`type`,`p_code`,`mod_code`,`ord`,`code`$qr1)
				values('$type','$id_to','$id_from','$ord','$code'$qr2)")){echo 1;}
			}
		}
		if($type_from=='menu'){
			$ord=getMaxValOrder('_modules_list','ord'," where p_code='$id_to'");
			
			if(mysql_q("UPDATE _modules_list set `p_code`='$id_to' ,`ord`='$ord' where code='$id_from' ;")){echo 1;}
			      echo "UPDATE _modules_list set `p_code`='$id_to' ,`ord`='$ord' where code='$id_from'";
		}
	}
}?>
