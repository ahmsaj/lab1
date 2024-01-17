<? include("ajax_header.php");
if($chPer[3]){
	if(isset($_POST['mod'])){
		$mod=pp($_POST['mod'],'s');	
		$mod_data=loadModulData($mod);
		$table=$mod_data[1];		
		$idEvn='';
		if($mod_data[11]){
			if(isset($_POST['rec'])){
				$x=0;
				$ids=$_POST['rec'];
				$idEvn=$ids;
				foreach($ids as $id){
					if(co_isDeletebl($mod_data,$id)){
						if(mysql_q("DELETE  from `$table` where id='$id'")){logOpr($id,3);}
					}else{
						$x++;
					}
				}
				if($x==0){echo "'ok'";}else{echo $x;}
			}
			if(isset($_POST['id'])){		
				$id=pp($_POST['id']);
				$idEvn=$id;
				if(co_isDeletebl($mod_data,$id)){
					if(mysql_q("DELETE  from `$table` where id='$id'")){echo 1;logOpr($id,3);}
				}else{
					echo 'x';
				}

			}
		}else{echo 0;}
		if($mod_data[17]){echo '<!--***-->'.checkMevents(6,$mod_data[17],$idEvn);}
	}
}else{out();}?>