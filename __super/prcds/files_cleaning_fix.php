<? include("../../__sys/prcds/ajax_header.php");

if(isset($_POST['s'],$_POST['f'],$_POST['t'])){
    $s=pp($_POST['s']);
    $f=pp($_POST['f'],'s');
    $t=pp($_POST['t'],'s');
    $t='jpg';
    $type=1;
    $table='_files_i';
    $fol='sData';
    if($s && $f && $t){
        $id='';
        $types=[];
        $types['pdf']='application/pdf';
        $types['doc']='application/msword';
        $types['xls']='application/xls';
        $types['jpg']='imges/jpag';
        //if(in_array($t,array('pdf','doc','xls'))){
            $r=getRec('gnr_x_patients_docs',$s);
            if($r['r']){
                $doc=$r['doc'];
                $date=$r['date'];
                $patient=$r['patient'];
                $code=$code=getRandString(10);
                $file=$f;
                $name=get_p_name($patient);
                /*************************************/
                $docs=explode(',',$doc);
                foreach($docs as $d){
                    $f=get_val($table,'file',$d);
                    if(!$f){
                        $id=$d;
                    }
                }
                if($id){
                    $folder=date('y-m',$date);
                    $filename='../'.$fol.'/'.$folder.'/'.$f;
                    if(file_exists($filename)){
                        $size= filesize($filename);            
                        $type=$types[$t];
                        $ex=$t;
                        echo $sql="INSERT INTO $table ( id,file,name,date,size,ex)values( '$id','$file','$name','$date','$size','$ex')";
                        mysql_q($sql);
                        echo 1;
                    }
                }
            }
        //}
    }
}