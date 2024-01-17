<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['code'])){
	$code=pp($_POST['code'],'s');
	$type=pp($_POST['type'],'s');
	//$name=pp($_POST['name'],'s');
	$icon=pp($_POST['icon'],'s');
	$act=0;if(isset($_POST['act']))$act=1;
	$sys=0;if(isset($_POST['sys']))$sys=1;
	$hide=0;if(isset($_POST['hide']))$hide=1;
	
	$ord=getMaxValOrder('_modules_list','ord'," where p_code='0'");
	//if($type==0){
	
		if($code=='0'){
			$q1=$q2='';
			foreach($lg_s as $l){
				$q1.=",`title_$l`";
				$q2.=",'".pp($_POST['title_'.$l],'s')."'";
			}
			$code=getRandString(10);			
			if(mysql_q("INSERT INTO _modules_list (`icon`,`sys`,`type`,`ord`,`hide`,`code`$q1)
			values('$icon','$sys','$type','$ord','$hide','$code'$q2)")){echo 1;}
		}else{
			$q1='';
			foreach($lg_s as $l){
				$q1.=",`title_$l` = '".pp($_POST['title_'.$l],'s')."'";
			}
			if(mysql_q("UPDATE _modules_list set `icon`='$icon' ,`sys`='$sys' ,`act`='$act' ,`hide`='$hide' $q1 where code='$code' ")){echo 1;}		
		}
	//}
}?>