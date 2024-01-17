<? include("../../__sys/prcds/ajax_header.php"); 
if(isset($_POST['id'],$_POST['p'])){
	$id=pp($_POST['id']);
	$data=$_POST['p'];
	$cob=$cob_s=$cob_e=$cobReng='';
	$err=0;
	$r=getRec('gnr_m_offers',$id);
	if($r['r']){
		$type=$r['type'];
		if($type>2){
			$clinics='';
			$vals=implode(',',$data);			
			foreach($data as $k => $d){
				$p=pp($d);
				if($p){
					if($clinics){$clinics.=',';}
					$clinics.=($k+1);
				}			
			}
			if($type==5){
				$cob=pp($_POST['cob']);				
				if($cob){
					$cob_s=pp($_POST['cob_s']);
					$cob_e=pp($_POST['cob_e']);
					if($cob_s || $cob_e){
						if($cob_e-$cob_s+1==$cob){
							$cobReng=$cob_s.','.$cob_e ;						
						}else{
							$err=1;
						}
					}
				}
			}
			$vals=$vals.'|'.$cob.'|'.$cobReng;
			if($clinics && $err==0){
				$sql="UPDATE gnr_m_offers SET sett='$vals' , clinics='$clinics' where id='$id' and type>2";
				mysql_q($sql);
			}
		}
	}	
}?>