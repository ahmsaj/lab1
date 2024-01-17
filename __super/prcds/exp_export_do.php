<? include("../../__sys/prcds/ajax_head_cFile.php");
if($thisGrp=='s'){include("../funs.php");}
if(isset($_POST['mods'],$_POST['enc_code'])){
	$mods=$_POST['mods'];
    $enc_code=pp($_POST['enc_code'],'s');	
	$modsList=get_vals('_modules','code',"1=1",'arr');
    $modsListAdd=get_vals('_modules_','code',"1=1",'arr');
	$count_mod=count($mods);
	
	$tables=[];
	$out=[];
	$ex_files=$mod_files=[];
    //$out['mods'][$cat_num]=[];
	foreach($mods as $mod){
        $cat_num=-1;
		if(in_array($mod,$modsList)){
            $cat_num=0;
        }elseif(in_array($mod,$modsListAdd)){
            $cat_num=1;
        };
		$saveTableData=0;
        if(isset($_POST['d_'.$mod])){$saveTableData=1;}
        $info=[];
        $modules_list=exp_sq('_modules_list',"mod_code='$mod'")[0];
        if(!empty($modules_list)){$out['mods'][$cat_num][$mod]['modules_list']=$modules_list;}
        if($cat_num==0){
            $modules_items=exp_sq('_modules_items',"mod_code='$mod'");
            if(!empty($modules_items)){$out['mods'][$cat_num][$mod]['modules_items']=$modules_items;}
            
            $modules_links=exp_sq('_modules_links',"mod_code='$mod'");
            if(!empty($modules_links)){$out['mods'][$cat_num][$mod]['modules_links']=$modules_links;}
            
            $modules_butts=exp_sq('_modules_butts',"mod_code='$mod'");
            if(!empty($modules_butts)){$out['mods'][$cat_num][$mod]['modules_butts']=$modules_butts;}
            
            $modules_cons=exp_sq('_modules_cons',"mod_code='$mod'");
            if(!empty($modules_cons)){$out['mods'][$cat_num][$mod]['modules_cons']=$modules_cons;}
            
            $info=getRecCon('_modules',"code='$mod'");
            if($info['r']>0){
                unset($info['id'],$info['r']);                
                foreach($info as $k=>$v){$info[$k]=addslashes($v);}
                $out['mods'][$cat_num][$mod]['info']=$info;
                $table=$info['table'];
                $tables[]=[$table,$saveTableData];
                //$tables=array_unique($tables);
            }
        }else{
            $info=getRecCon('_modules_',"code='$mod'");
            if($info['r']>0){
                unset($info['id'],$info['r']);
                foreach($info as $k=>$v){$info[$k]=addslashes($v);}
                $out['mods'][$cat_num][$mod]['info']=$info;
                array_push($mod_files,$info['file']);
                //$mod_files=array_unique($mod_files);
            }
        }
        if($info['exFile'] && $info['exFile']!=''){
            $exFile=explode(',',$info['exFile']);
            $ex_files=array_unique(array_merge($ex_files,$exFile));
        }
        if($info['lk_tables'] && $info['lk_tables']!=''){
            $mod_tables=explode(',',$info['lk_tables']);
            foreach($mod_tables as $table){
                $tables[]=[$table,$saveTableData];                
            }
            //$tables=array_unique(array_merge($tables,$mod_tables));
        }
	}
	//$tables=array_unique($tables);
	foreach($ex_files as $file){
		$file_info=getRecCon('_modules_files_pro',"code='$file'");
        if($file_info['r']){
            unset($file_info['id'],$file_info['r']);
            $fileName=$file_info['file'];
            $fileProg=$file_info['prog'];
            $folder=getModFolder($fileProg);
            $file_name=$folder.'prcds/'.$fileName.'.php';
            $file_info['data']=file_get_contents($file_name);
            $out['ex_files'][$file]=$file_info;
        }
	}
		
	foreach($mod_files as $file){
		$file_info=getRecCon('_modules_files',"code='$file'");
        if($file_info['r']){
            //sunset($file_info['id'],$file_info['r']);
            $fileName=$file_info['file'];
            $fileProg=$file_info['prog'];
            $folder=getModFolder($fileProg);
            $file_name=$folder.'mods/'.$fileName.'.php';
            $file_info['data']=file_get_contents($file_name);
            $out['mod_files'][$file]=$file_info;
        }
	}
	
	foreach($tables as $v){
        $table=$v[0];
        $saveData=$v[1];
		$out['tables'][$table]=exp_tables_copy($table,$saveData);
	}
	
	if(!empty($out)){
		$langs=get_vals('_langs','lang',"1=1",'arr');
		$out['langs']=$langs;
	}
    $c=0;
	$fin_out=json_encode($out);
	if($enc_code){$fin_out=Encode($fin_out,$enc_code);$c=1;}
    $name='exported_modules'.$count_mod.'_'.date('Ymdhis',$now).'.mwd';
	header("Content-Type: application/json; charset=UTF-8");			
	header("Content-disposition:attachment; filename= $name ");	
    print_r($c.$fin_out);
}