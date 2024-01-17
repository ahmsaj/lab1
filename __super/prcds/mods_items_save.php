<? include("../../__sys/prcds/ajax_header.php");
//reset_ord($id);		
if($_POST['ids']){
	$ids=$_POST['ids'];	
	foreach($ids as $c_id){
		$name=$_POST['name_'.$c_id];
		$type=$_POST['type_'.$c_id];
		$defult=$_POST['defult_'.$c_id];	
		$note=$_POST['note_'.$c_id];
		$link=$_POST['link_'.$c_id];
		$act=$_POST['act_'.$c_id];
		if($type!=5 && $type!=6){
			if($link!=''){
				$ll=explode('|',$link);
				$s_id=$ll[1];
				mysql_q("UPDATE _modules_items set `link`='' where id IN('$c_id','$s_id') ");
			}
		}
		$prams=saveColPrams($type,$c_id);
		$q1='';
		if($type==10 || $type==15){$q1="colum= ' ".$_POST['col_'.$c_id]."' ,";}

		$req=0;if(isset($_POST['req_'.$c_id]))$req=1;
		$show=0;if(isset($_POST['show_'.$c_id]))$show=1;
		$act=0;if(isset($_POST['act_'.$c_id]))$act=1;
		$filter=0;if(isset($_POST['filter_'.$c_id]))$filter=$_POST['filter_'.$c_id];

		$sql="UPDATE `_modules_items` SET $q1 `title`='$name' ,`type`='$type' ,`defult`='$defult' ,`prams`='$prams' ,`requerd`='$req' ,`show`='$show' , note='$note' ,act ='$act' ,filter ='$filter'  where id='$c_id'";
		mysql_q($sql);
	}
	$mod_code=get_val('_modules','code',$c_id);
	moduleGen(1,$mod_code);
}	
