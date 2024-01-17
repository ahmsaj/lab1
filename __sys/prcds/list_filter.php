<? include("ajax_header.php");
if(isset($_POST['id'] , $_POST['val'])){
	$id=pp($_POST['id'],'s');
	$val=pp($_POST['val'],'s');
	$cData=getColumesData($mod,1,$id,'act>=0');
	$cData[1];
	$link=$cData[$id][12];	
	$colm='';
	$colm_fil='';
	if($link){		
		$l=explode('|',$link);
		if($l[0]==2){$colm_fil=$l[2];}
		if($colm_fil){		
			$pars=explode('|',$cData[$id][5]);
			$table=$pars[0];
			$fl_id=$pars[1];
			$colm=str_replace('(L)',$lg,$pars[2]);
			if($colm){
				$sql="select * from $table where `$colm_fil`='$val'  order by `$colm` ASC limit 500";
				$res=mysql_q($sql);
				$rows=mysql_n($res);				
				echo '<select name="fil_'.$id.'" id="fil_'.$id.'" class="text_f"><option value=""></option>';	
				if($rows>0){
					while($r=mysql_f($res)){					
						$val=$r[$fl_id];
						$colmT=$r[$colm];
						echo '<option value="'.$val.'">'.$colmT.'</option>';
					}
				}
				echo '</select>';	
			}
		}
	}
}?>
	
	