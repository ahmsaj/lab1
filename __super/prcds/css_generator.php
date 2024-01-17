<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['n'])){
	$n=pp($_POST['n']);
	$gnr_data=$del_data=$err='';
	$dirs=get_vals('_langs','dir','','arr');
	$cols=get_vals('_themes','id','','arr');
	$progs=get_vals('_programs','code','','arr');
	$all_files=(count($dirs)*count($cols)*(count($progs)+3));
	$x=0;$xx=0;?>
	<div class="f1 fs18 clr1 lh50">
	<?=k_directions_num?> : <ff class=""> ( <?=count($dirs)?> ) </ff> |
	<?=k_themes_num?> : <ff class=""> ( <?=count($cols)?> ) </ff> |
	<?=k_progs_num?> : <ff class=""> ( <?=count($progs)?> ) </ff></div><?
	/*****************************************/	
	$sysFiles=array('__sys/css/style','__sys/css/style_p','__super/css/style');
	for($i=0;$i<count($cols);$i++){
		for($j=0;$j<count($dirs);$j++){
			for($f=0;$f<count($sysFiles);$f++){
				$path=$sysFiles[$f];
				$file='../../'.$path.'_'.$cols[$i].'_'.$dirs[$j].'.css';
				$url=_ptc.'://'.$_SERVER['HTTP_HOST'].$m_path.$path.'.php?d='.$dirs[$j].'&gct='.$cols[$i];
				if($n==1){$o=generate_css($url,$file);}
				if($n==2){$o=delete_files($file);}
				if(!$o){$x++;$err.=errMsg($path.'_'.$cols[$i].'_'.$dirs[$j]);}
			}
		}
	}
	/*************Website****************************/	
	if(_set_2jaj4f43vd){
		$sysFiles=array('sys/css/style','inc/css/style');
		for($j=0;$j<count($dirs);$j++){
			for($f=0;$f<count($sysFiles);$f++){
				$path='../'.$sysFiles[$f];
				$file='../../'.$path.$dirs[$j].'.css';                
				$url=_ptc.'://'.$_SERVER['HTTP_HOST'].$m_path.$path.'.php?d='.$dirs[$j];echo '<br>';
				if($n==1){$o=generate_css($url,$file);}
				if($n==2){$o=delete_files($file);}
				if(!$o){$xx++;$err.=errMsg($path.$dirs[$j]);}
			}			
		}
	}
	/*****************************************/	
	for($k=0;$k<count($progs);$k++){
		$path='_'.$progs[$k].'/css/style';						
		for($i=0;$i<count($cols);$i++){
			for($j=0;$j<count($dirs);$j++){
				$file='../../'.$path.'_'.$cols[$i].'_'.$dirs[$j].'.css';
				$url=_ptc.'://'.$_SERVER['HTTP_HOST'].$m_path.$path.'.php?d='.$dirs[$j].'&gct='.$cols[$i];
				if($n==1){$o=generate_css($url,$file);}
				if($n==2){$o=delete_files($file);}
				if(!$o){$x++;$err.=errMsg($path.'_'.$cols[$i].'_'.$dirs[$j]);}
			}
		}
	}
	/*****************************************/
	if($n==1 && $x==0){
		mysql_q("UPDATE _settings SET val='1' where code='2fgiibephe' ");
	}
	if($n==2){
		mysql_q("UPDATE _settings SET val='0' where code='2fgiibephe' ");
	}?><br>
	<table  border="0" cellspacing="0" cellpadding="8" class="grad_s" type="static" over="0">
		<tr>
			<td class="cbg888"><ff class="fs24 clr8 lh40" ><?=$all_files?></ff></td>
			<td class="cbg666"><ff class="fs24 clr6 lh40" ><?=$all_files-$x?></ff></td>
			<td class="cbg555"><ff class="fs24 clr5 lh40" ><?=$x?></ff></td>
		</tr>
		<tr>
			<td class="cbg888"><div class="f1 fs16 clr1 pd10"><?=k_files_num?></div></td>
			<td class="cbg666"><div class="f1 fs16 clr6 pd10"><?=k_generated_num?></div></td>
			<td class="cbg555"><div class="f1 fs16 clr5 pd10"><?=k_number_of_errors?></div></td>
		</tr>
	</table><?
		
	if($err){echo '<div class="f1 fs18 clr5 lh40" >'.k_errors.' <ff> ( '.$x.' ) </ff></div>'.$err;}
}
function errMsg($s){return '<div class="f1 clr5 TL" dir="ltr">'.splitNo($s).'</div>';}
function delete_files($file){$out=0;if(file_exists($file)){if(@unlink($file)){$out=1;}}
	return $out;
}
function generate_css($url,$file){
	$out=1;
    $url=$url.'&root=2';
	$ch = curl_init();	
	curl_setopt($ch, CURLOPT_URL,$url);
	//curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER , TRUE);
	$content = curl_exec($ch);
	if(curl_exec($ch) === false){
		$res= 'Curl error: ' . curl_error($ch);
		$out=0;
	}else{
		if(!file_exists($file)){fopen($file, "w");}
		$before = array("<style>","</style>","start{}","r/ ");
		$after = array("","","","");		
		$new_content=str_replace($before,$after,$content);
		$new_content = trim(preg_replace('/\s\s+/', ' ', $new_content));
		file_put_contents($file, $new_content);		
	}
	curl_close($ch);
	return $out;
}?>