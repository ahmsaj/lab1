<? include("../header.php");
if(isset($_POST['vis'],$_POST['id'],$_POST['itId'])){
	$id=pp($_POST['id']);
	$itId=pp($_POST['itId']);
	$vis=pp($_POST['vis']);	
	$r=getRecCon('cln_x_visits'," id='$vis' and doctor='$thisUser' ");	
	if($r['r']){
		$visStatus=$r['status'];
		if($visStatus==1 || _set_whx91aq4mx){
			$patient=$r['patient'];
			$r=getRec('cln_m_medical_his',$itId);
			if($r['r']){
				$name=$r['name_'.$lg];
				$cat=$r['cat'];
				$r_cat=getRec('cln_m_medical_his_cats',$cat);			
				$catTxt=$r_cat['name_'.$lg];
				$s_date=$r_cat['s_date'];
				$e_date=$r_cat['e_date'];
				$num=$r_cat['num'];
				$active=$r_cat['active'];
				$alert=$r_cat['alert'];
				$note=$r_cat['note'];
				$itYear=$r_cat['year'];
				if(!$id){
					$cols=array('date','med_id','cat','patient','doc');
					$vals=array($now,$itId,$cat,$patient,$thisUser);
				}else{
					$colsE=array();
				}
				if($s_date){
					$c='s_date';
					$thisVal=strtotime(pp($_POST[$c],'s'));
					if(!$id){
						array_push($cols,$c);
						array_push($vals,$thisVal);
					}else{
						array_push($colsE,"`$c`='$thisVal'");
					}
				}
				if($e_date){				
					$c='e_date';
					$thisVal=strtotime(pp($_POST[$c],'s'));
					if(!$id){
						array_push($cols,$c);
						array_push($vals,$thisVal);
					}else{
						array_push($colsE,"`$c`='$thisVal'");
					}
				}
				if($num){
					$c='num';
					$thisVal=pp($_POST[$c]);
					if(!$id){
						array_push($cols,$c);
						array_push($vals,$thisVal);
					}else{
						array_push($colsE,"`$c`='$thisVal'");
					}
				}

				$c='active';
				$thisVal=0;
				if(isset($_POST[$c])){$thisVal=1;}
				if(!$id){
					array_push($cols,$c);
					array_push($vals,$thisVal);
				}else{
					array_push($colsE,"`$c`='$thisVal'");
				}

				$c='alert';
				$thisVal=0;
				if(isset($_POST[$c])){$thisVal=1;}
				if(!$id){
					array_push($cols,$c);
					array_push($vals,$thisVal);
				}else{
					array_push($colsE,"`$c`='$thisVal'");
				}			
				if($itYear){
					$c='year';
					$thisVal=pp($_POST[$c]);
					if(!$id){
						array_push($cols,$c);
						array_push($vals,$thisVal);
					}else{
						array_push($colsE,"`$c`='$thisVal'");
					}
				}
				if($note){
					$c='note';
					$thisVal=pp($_POST[$c],'s');
					if(!$id){
						array_push($cols,$c);
						array_push($vals,$thisVal);
					}else{
						array_push($colsE,"`$c`='$thisVal'");
					}
				}
				if(!$id){
					$colsTxt=implode('`,`',$cols);
					$valsTxt=implode("','",$vals);
					$sql="INSERT INTO cln_x_medical_his (`$colsTxt`)values('$valsTxt')";
				}else{
					$colsETxt=implode(',',$colsE);
					$sql="UPDATE cln_x_medical_his SET $colsETxt where id='$id' ";
				}
				if(mysql_q($sql)){echo 1;}
			}
		}
	}
}?>