<? include("ajax_header.php");
foreach ($_FILES as $key => $value) { foreach($value as $k => $v){}}
$imageTypes = array('image/jpg','image/jpeg','image/gif','image/png','image/svg+xml');
$files_path=$m_path.'sData/';
$files_path_s='../../sData/';	
$mothfolder=date('y-m',$now).'/';
$full_path_s=$files_path_s.$mothfolder;	
if(!file_exists($files_path_s)){mkdir($files_path_s,0777);}
if(!file_exists($full_path_s)){mkdir($full_path_s,0777);}
$err=0;
if(isset($_FILES[$key])){
	if($_FILES[$key]['error']==0){
		/***************size*****************************/
		$max_size=intval(ini_get('memory_limit'))*1024*1024;
		$fileSize = $_FILES[$key]['size'];
		if($max_size>=$fileSize){
			/***************type*****************************/
			$type = $_FILES[$key]['type'];			
			if(in_array($type,$imageTypes)){
				/***************copy*****************************/
				$fileName = getRandString(10,3);	
				$fileName_org = $_FILES[$key]['name'];
				$file_ex = getFileExt($fileName_org);
				$exTxt='';
				if($file_ex=='svg'){$exTxt.='.svg';}
    			if(move_uploaded_file($_FILES[$key]['tmp_name'],$full_path_s.$fileName.$exTxt)){
					$sql="INSERT INTO _files_i (`file`,`name`,`date`,`size`,`ex`)
					values('$fileName','$fileName_org','$now','$fileSize','$file_ex');";
					if(mysql_q($sql)){
						$file_id=last_id();
						if($file_ex=='svg'){
							$thamp= $m_path.'upi/'.$mothfolder.$fileName.$exTxt;
							$w=$h=32;
						}else{
							list($w,$h)=getimagesize("../../sData/".$mothfolder.$fileName);							$thamp=Croping($fileName,"sData/".$mothfolder,60,60,'i',$m_path.'imup/',1,'sData/resize/',$file_ex);
						}
						echo $file_id.','.$m_path.'upi/'.$mothfolder.$fileName.','.$thamp.','.$w.','.$h;
						
					}else{$err='6';}
				}else{$err='5';}
			}else{$err='4';}
		}else{$err='3';}
	}else{$err='2';}
}else{$err='1';}
if($err!=0)echo 'xxx,'.$err;
?>