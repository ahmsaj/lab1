<? include("ajax_header.php");
if(isset($_POST['type']) && ( isset($_POST['id']) || isset($_POST['code'])) ){
	if(isset($_POST['code'])){
		$code=pp($_POST['code'],'s');
		$type=pp($_POST['type']);
		if($type==1){$table='_modules';}
		if($type==2){$table='_modules_';}		
		$modCode=get_val_con('_modules_list','code',"mod_code='$code' and type='$type'");
		mysql_q("DELETE FROM _perm where type=1 and m_code='$modCode' ");		
		$sql="select * from _groups ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$data_arr=array();
		if($rows>0){
			echo 1;
			$type=1;
			while($r=mysql_f($res)){
				$m_code=$r['code'];			
				$m_type=$r['type'];			
				if(isset($_POST['per_'.$m_code])){
					$p0=0;if(isset($_POST['per_'.$m_code.'_0'])){$p0=1;}
					$p1=0;if(isset($_POST['per_'.$m_code.'_1'])){$p1=1;}
					$p2=0;if(isset($_POST['per_'.$m_code.'_2'])){$p2=1;}
					$p3=0;if(isset($_POST['per_'.$m_code.'_3'])){$p3=1;}
					$p4=0;if(isset($_POST['per_'.$m_code.'_4'])){$p4=1;}
					if($p0+$p1+$p2+$p3+$p4>0){	
						mysql_q("INSERT INTO _perm (`type`,`g_code`,`m_code`,`p0`,`p1`,`p2`,`p3`,`p4`)
						values ('$type','$m_code','$modCode','$p0','$p1','$p2','$p3','$p4')");
					}				
				}
			}
		}
	}else{
		if($thisGrp!='0'){$q=" and sys=0 ";}
		$id=pp($_POST['id'],'s');
		$type=pp($_POST['type']);
		mysql_q("DELETE FROM _perm where type='$type' and g_code='$id' ");
		$sql="select * from _modules_list where act=1 $q order by ord ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$data_arr=array();
		if($rows>0){
			echo 1;
			while($r=mysql_f($res)){
				$m_code=$r['code'];			
				$m_type=$r['type'];			
				if(isset($_POST['per_'.$m_code])){
					$p0=0;if(isset($_POST['per_'.$m_code.'_0'])){$p0=1;}
					$p1=0;if(isset($_POST['per_'.$m_code.'_1'])){$p1=1;}
					$p2=0;if(isset($_POST['per_'.$m_code.'_2'])){$p2=1;}
					$p3=0;if(isset($_POST['per_'.$m_code.'_3'])){$p3=1;}
					$p4=0;if(isset($_POST['per_'.$m_code.'_4'])){$p4=1;}
					if($p0+$p1+$p2+$p3+$p4>0){				
						mysql_q("INSERT INTO _perm (`type`,`g_code`,`m_code`,`p0`,`p1`,`p2`,`p3`,`p4`)
						values ('$type','$id','$m_code','$p0','$p1','$p2','$p3','$p4')");
					}				
				}
			}
		}
		/********************/
		fixFavList($id);
	}
}?>

