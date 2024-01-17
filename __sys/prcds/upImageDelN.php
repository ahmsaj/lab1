<? include("ajax_header.php");
if(isset($_POST['id'],$_POST['code'])){
	$id=pp($_POST['id']);
    $code=pp($_POST['code']);
    $upPer=0;
    $code=pp($_POST['code'],'s');    
    $out=[];
    if(array_key_exists($code,$uploadImagesFileds)){
        $upPer=1;
    }else if(substr($code,0,3)=='tp_'){
        $upPer=1;
    }elseif($PER_ID=='i8qpui34ew'){
        $admin=get_val_c('_settings','admin',$code,'code');
        if($admin || $thisGrp=='s'){$upPer=1;}
    }elseif($upPer==0 && $PER_ID=='pse5arvl6n'){
        $widId=get_val_c('gnr_m_widgets_set_items','id',$code,'code');
        if($widId || $thisGrp=='s'){$upPer=1;} 
    }else{
        list($mod,$prams)=get_val_c('_modules_items','mod_code,prams',$code,'code');
        if($mod){
            $p=modPer($mod);
            if($p[1]||$p[2]){$upPer=1;}
        }
    }
    if($upPer){echo deleteImages($id);}
}?>