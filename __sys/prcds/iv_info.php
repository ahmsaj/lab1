<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['code'])){
	$code=pp($_POST['code'],'s');
    $out=[];
    $out['status']=0;
    $bf=$folderBack;
    $w=182;
    $h=380;
    $r=getRecCon('_files_i'," file='$code' ");
    if($r['r']){
        $file=$r['file'];
        $date=$r['date'];
        $ex=$r['ex'];
        $out['status']=1;
        $out['file']=$r['file'];
        $out['name']=$r['name'];
        $out['date']=date('Y-m-d Ah:i',$date);
        $out['size']=getFileSize($r['size']);
        $out['ex']=$r['ex'];
        $folder=date('y-m',$date).'/';	
        $this_file=$m_path.'upi/'.$folder.$file;
        $r_file=$bf."sData/".$folder.$file;	
        list($out['w'],$out['h'])=getimagesize($r_file);
        $mainSrc=$bf.'sData/'.$folder.$file;
        $resizeSrc=$bf.'sData/resize/i'.$w.$h.$file;
        $out['src']="sData/".$folder.$file;
        if(file_exists($mainSrc)){
            $image=resizeImage($file,"sData/".$folder,$w,$h,'i',$m_path.'imup/',0,'sData/resize/',$ex);                   
            $out['img']=$image;
        }        
    }
    echo json_encode($out,JSON_UNESCAPED_UNICODE);
}?>