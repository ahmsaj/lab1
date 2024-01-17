<? include("ajax_head_cFile.php");
$upPer=0;
$code=pp($_POST['code'],'s');
$__types=$_defImgTyp;
$__multi=$_img_multi;
$__width=$_img_width;
$__height=$_img_height;
$out=[];
if(array_key_exists($code,$uploadImagesFileds)){
    $upPer=1;
    $types=$uploadImagesFileds[$code][0];
    $multi=$uploadImagesFileds[$code][1];
    $width=intval($uploadImagesFileds[$code][2]);
    $height=intval($uploadImagesFileds[$code][3]);
}else if(substr($code,0,3)=='tp_'){
    $upPer=1;
}else{
    list($mod,$prams)=get_val_c('_modules_items','mod_code,prams',$code,'code');
    if($mod){
        $p=modPer($mod);
        if($p[1]||$p[2]){
            $upPer=1;
            $pramsArr=explode('|',$prams);
            $types=$pramsArr[0];
            $multi=$pramsArr[1];
            $width=intval($pramsArr[2]);
            $height=intval($pramsArr[3]); 
        }
    }
}

if($upPer==0 && $PER_ID=='i8qpui34ew'){
    $admin=get_val_c('_settings','admin',$code,'code');
    if($admin || $thisGrp=='s'){$upPer=1;}
}

if($upPer==0 && $PER_ID=='pse5arvl6n'){
    $widId=get_val_c('gnr_m_widgets_set_items','id',$code,'code');
    if($widId || $thisGrp=='s'){$upPer=1;}    
}

if($upPer){
    if($types){$__types=explode(',',$types);}
    if($multi!=''){$__multi=$_img_multi;}
    if($width){$__width=$width;}
    if($height){$__height=$height;}
    /***********************************/    
    foreach ($_FILES as $key => $value){foreach($value as $k => $v){}}    
    $files_path=$m_path.'sData/';
    $files_path_s='../../sData/';	
    $mothfolder=date('y-m',$now).'/';
    $full_path_s=$files_path_s.$mothfolder;	
    if(!file_exists($files_path_s)){mkdir($files_path_s,0777);}
    if(!file_exists($full_path_s)){mkdir($full_path_s,0777);}
    /********************************************************/
    $out['status']=1;
    if(isset($_FILES[$key])){
        if($_FILES[$key]['error'][0]==0){
            /***************size*****************************/
            $max_size=intval(ini_get('memory_limit'))*1024*1024;
            $fileSize = $_FILES[$key]['size'][0];
            $fileName_org = $_FILES[$key]['name'][0];
            $type = $_FILES[$key]['type'][0];
            $tempFile = $_FILES[$key]['tmp_name'][0];
            
            list($tw,$th)=getimagesize($tempFile);
            if($max_size>=$fileSize){//check File Size
                /***************type************************************/
                $file_ex = getFileExt($fileName_org);
                if(in_array($type,$__imgRTypes[$file_ex]) && $file_ex!=''){//check File Type
                    /***************copy*****************************/
                    $fileName = getRandString(10,3);              
                    $exTxt='';
                    if($file_ex=='svg'){$exTxt.='.svg';}
                    $newFilePath=$full_path_s.$fileName.$exTxt;
                    if(move_uploaded_file($tempFile,$newFilePath)){
                        if($file_ex!='svg'){
                            if($tw>$__width || $th > $__height){
                                $newFilePath=$full_path_s.$fileName.$exTxt;
                                $img=resizeImage($fileName,"sData/".$mothfolder,$__width,$__height,'','',0,'sData/'.$mothfolder.'/',$file_ex);                                
                                if($img){//replace with small image 
                                    @unlink($newFilePath);
                                    rename($full_path_s.$__width.$__height.$fileName.$exTxt,$newFilePath);
                                }
                            } 
                        }
                        $sql="INSERT INTO _files_i (`file`,`name`,`date`,`size`,`ex`)
                        values('$fileName','$fileName_org','$now','$fileSize','$file_ex');";
                        if(mysql_q($sql)){
                            $file_id=last_id();
                            if($file_ex=='svg'){
                                $thamp= $m_path.'upi/'.$mothfolder.$fileName.$exTxt;
                                $w=$h=32;
                            }else{
                                list($w,$h)=getimagesize("../../sData/".$mothfolder.$fileName);						
                                $thamp=Croping($fileName,"sData/".$mothfolder,50,50,'i',$m_path.'imup/',1,'sData/resize/',$file_ex);
                            }
                            $out['no']=$file_id;
                            $out['themp']=$thamp;
                            $out['file']=$m_path.'upi/'.$mothfolder.$fileName;
                            if($file_ex=='svg'){
                                $out['file'].=$exTxt;
                            }
                            $out['org_file']=$fileName_org;
                            $out['width']=$w;
                            $out['height']=$h;
                            $out['size']=$fileSize;
                        }else{$errNo='6';$errMsg=k_fl_nrgt_db;}
                    }else{$errNo='5';$errMsg=k_fl_ncpd;}
                }else{$errNo='4';$errMsg=k_fl_nrq_typ;}
            }else{$errNo='3';$errMsg=k_fl_lrg_sz;}
        }else{$errNo='2';$errMsg=k_err_ld;}
    }else{$errNo='1';$errMsg=k_nfile_snt;}
    if($errNo){
        $out['status']=0;
        $out['errNo']=$errNo;
        $out['errMsg']=$errMsg;
    }
    echo json_encode($out,JSON_UNESCAPED_UNICODE);
}?>