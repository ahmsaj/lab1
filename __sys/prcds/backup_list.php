<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id'],'s');
	$dir = $folderBack.'.backup/';
	$files = scandir($dir);
	echo '<div actButt="act_s1">';
	foreach($files as $f){	
		if($f!='.' && $f!='..'){
			if(is_dir($dir.$f)){
				if(file_exists($dir.$f.'/_info.php')){
					include($dir.$f.'/_info.php');
					$info=json_decode($BU_info,true);
					$act='';
					if($id == $info['id']){ $act='act_s1';}
					echo '<div '.$act.' class="cbgw bord pd10f mg5b Over2 br5" onclick="loadSavedBackup(\''.$info['id'].'\')">
						<div class="lh30 fs16 clr1 f1">'.$info['name'].'</div>
						<div class="f1 clr11">'.$backupStatus[$info['status']].'</div>
					</div>';
					//<div class="f1">عدد السجلات: '.number_format($info['rows']).' - الحجم:'.getFileSize($info['size'],2).'</div>
				}
			}
		}	
	}
	echo '</div>';
}?>

