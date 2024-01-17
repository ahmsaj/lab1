<? include("ajax_header.php");
if($chPer[3]){
	if(isset($_POST['mod'])){
		$mod=pp($_POST['mod'],'s');	
		$mod_data=loadModulData($mod);
		$table=$mod_data[1];		
		if($mod_data[11]){
			if(isset($_POST['rec'])){
				$ids=pp($_POST['rec'],'s');
				echo checkMevents(5,$mod_data[17],$ids);			
			}
			if(isset($_POST['id'])){		
				$id=pp($_POST['id']);
				echo checkMevents(5,$mod_data[17],$id);			
			}
		}
	}
}else{out();}?>