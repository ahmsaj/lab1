<? include("ajax_header.php"); 
foreach ($_FILES as $key => $value) { foreach($value as $k => $v){}}//echo '('.$_FILES[$key]['type'].')';
$fTypes = array('application/pdf','application/msword','application/vnd.ms-excel','text/plain','application/octet-stream','application/postscript','application/psd','application/in','image/jpg','image/jpeg','image/gif','image/png','image/svg+xml','application/x-zip-compressed');
$files_path=$m_path.'sFile/';
$files_path_s='../../sFile/';	
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
			if(in_array($type,$fTypes)){
				/***************copy*****************************/
				$fileName = getRandString(10,3);
				$code = getRandString(10,3);
				$fileName_org = $_FILES[$key]['name'];
				$file_ex = getFileExt($fileName_org);
    			if(move_uploaded_file($_FILES[$key]['tmp_name'],$full_path_s.$fileName)){
					$sql="INSERT INTO _files (`file`,`name`,`date`,`size`,`ex`,`code`,`type`)
					values('$fileName','$fileName_org','$now','$fileSize','$file_ex','$code','$type');";
					if(mysql_q($sql)){
						$file_id=last_id();
    					echo $file_id.','.$fileName_org.','.$file_ex;
					}else{$err='6';}
				}else{$err='5';}
			}else{$err='4';}
		}else{$err='3';}
	}else{$err='2';}
}else{$err='1';}
if($err!=0){echo 'xxx,'.$err;}
?>