<? include("../../__sys/prcds/ajax_header.php");
$delOpr=0;
function fixTableData($mods,$id,$t){
    global $delOpr;
    $data='';
    foreach($mods as $v){
        $table=$v[0];                            
        $column=$v[1];
        $con=$v[2];
        //echo $table.'-'.$column.'-'.$id.'<br>';
        if($con){
            $con=str_replace('[f]',$id,$con);
            list($photo_id,$dd)=get_val_con($table,'id,'.$column,$con);
            $cc='';
            /*$doc_ids=get_val($table,$column,$photo_id);
            $dd=explode(',',$doc_ids);*/
            $photo_id_arr=[];
            foreach($dd as $d){
                if($d!=$id){
                    array_push($photo_id_arr,$d);
                }
                $cc=implode(',',$photo_id_arr);
            }
            if($delOpr){
                mysql_q("UPDATE  $table SET  `$column` ='$cc'  where id='$photo_id' ");
            }
        }else{
            $photo_id=get_val_c($table,'id',$id,$column);
            if($photo_id){
                $data.= $table.'|'.$column.'|'.$photo_id; 
                if($delOpr){
                    mysql_q("UPDATE  $table SET  `$column` =0  where id='$photo_id' ");                    
                }
            }else{
                if($delOpr){
                    mysql_q("DELETE  from $t where id='$id' ");
                }
            }
        }
    }
 }
function chPhotoLink($mods,$id){
    $x=0;
    foreach($mods as $v){
        $table=$v[0];                            
        $column=$v[1];
        $con=$v[2];
        if($con){
            $con=str_replace('[f]',$id,$con);
            $x+=getTotalCo($table,$con);
        }else{
            $x+=getTotalCo($table," `$column` = '$id' ");
        }
        //if($x){echo " $table | `$column` = $id ($x)<br>";}
    }
    return $x;
}
if(isset($_POST['t'])){
    $t=pp($_POST['t']);
    $mood=1;
    $table='_files_i';
    $fileType=4;
    $docType=1;
    $fFolder='sData';
    if(in_array($t,array(11,12,13))){
        $table='_files';
        $fileType=8;
        $docType=2;
        $fFolder='sFile';
        $mood=2;
    }
    if(in_array($t,array(1,2,11,12))){
       $mods=[];
       $sql="select m.table as t , i.colum as c from _modules m, _modules_items i where i.mod_code=m.code and type=$fileType ";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows){
            while($r=mysql_f($res)){               
                $mods[]=[$r['t'],$r['c'],''];                
            }
        }
        if($mood==1){
            $mods[]=['_settings','val',"type=4 and FIND_IN_SET([f],`val`) > 0 "];
        }
        //this Project
        $mods[]=['gnr_x_patients_docs','doc',"type=$docType and FIND_IN_SET([f],`doc`) > 0 "];
        //***************************************
    }
	
    $r=pp($_POST['r']);
    $p=pp($_POST['p']);
    $d=pp($_POST['d'],'s');
    $recs=100;
    $page=0;
    if($r){$recs=$r;}
    if($p){$page=$recs*$p;}
	if($t==1){
        $total=getTotal($table);
        $sql="select * from $table order by id ASC limit $page,$recs ";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        $rowsTxt=$rows;
        $photos='';
        if($total>$rows){$rowsTxt=number_format($total).'/'.number_format($rows);}?>
        <div class="lh40 f1 fs16 clr1"><?=k_num_res?>:<ff> ( <?=$rowsTxt?> )</ff></div><?
        if($rows){
            $x=0;
            $sizes=0;
            while($r=mysql_f($res)){
                $id=$r['id'];
                $file=$r['file'];                
                $name=$r['name'];
                $date=$r['date'];
                $size=$r['size'];
                $ex=$r['ex'];
                if(chPhotoLink($mods,$id)==0){
                    $folder=date('y-m',$date).'/';
                    $w=80;
                    $h=80;                
                    $image='';
                    $dir=2;
                    $bf=str_repeat('../',$dir);		
                    $this_file=$m_path.'upi/'.$folder.$file;
                    $r_file=$bf.$fFolder.'/'.$folder.$file;                
                    if(file_exists($bf.$fFolder.'/'.$folder.$file)){
                        if($ex=='svg'){
                            $photos.= '<div class="fl Over mg5f" title="'.$name.'">
                                <img src="'.$this_file.'" id="im_'.$id.'" width="'.$w.'" height="'.$h.'" />
                            </div>';
                        }else{                            
                            $image=Croping($file,$fFolder.'/'.$folder,$w,$h,'i',$m_path.'imup/',$dir,$fFolder.'/resize/',$ex);
                            $photos.= '<div class="fl Over mg5f" title="'.$name.'">
                                <img src="'.$image.'" id="im_'.$id.'" />
                            </div>';
                        }    
                    }
                    $sizes+=$size;
                    if($delOpr){deleteImages($id);}
                    $x++;
                }
            }
        }
        echo '<div class="fl w100 fs18 clr5 lh60">['.$x.']['.getFileSize($sizes).']</div>'.$photos;
    }
    if($t==2){
        $total=getTotal($table);
        $sql="select * from $table order by id ASC limit $page,$recs";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        $rowsTxt=$rows;
        $x=0;
        $data='';
        if($total>$rows){$rowsTxt=number_format($total).'/'.number_format($rows);}
        if($rows){
            $data.='<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s g_ord holdH" type="static" >
            <tr><th width="250">'.k_file.'</th>
            <th>'.k_links.'</th>
            </tr>';
            while($r=mysql_f($res)){
                $id=$r['id'];
                $file=$r['file'];                
                $name=$r['name'];
                $date=$r['date'];
                $size=$r['size'];
                $ex=$r['ex'];
                
                $folder=date('y-m',$date).'/';                
                $dir=2;
                $bf=str_repeat('../',$dir);		
                $this_file=$m_path.'upi/'.$folder.$file;
                $r_file=$bf.$fFolder.'/'.$folder.$file;                
                if(!file_exists($bf.$fFolder.'/'.$folder.$file)){
                    $data.= '<tr>
                    <td>'.$name.'</td>
                    <td>'.fixTableData($mods,$id,$table).'</td>
                    </tr>';
                    $x++;
                }
            }
            $data.= '</table>';
        }
        ?>
        <div class="lh40 f1 fs16 clr1"><?=k_num_res?>:<ff> ( <?=$rowsTxt?> )</ff></div>
        <div class="fl w100 fs18 clr5 lh60">[<?=number_format($x)?>]</div><?
        echo $data;
    }
    if($t==3){
        $dir='../../'.$fFolder;   
        $all=0;
        $sizes=0;
        $delFileByFolder=25;
        $cdir=scandir($dir);
        foreach ($cdir as $key => $value){            
            if (!in_array($value,array(".","..",'resize'))){ 
                $subDir=$dir.'/'.$value;
                if(is_dir($subDir)){
                    $cdir2=scandir($subDir);
                    $i=0;
                    $x=0;
                    $files='';
                    foreach ($cdir2 as $key2 => $value2){
                        if (!in_array($value2,array(".",".."))){ 
                            $ph_id=get_val_c($table,'id',$value2,'file');
                            if(!$ph_id){                                
                                $files.=' | '.$value2;
                                $fullName=$subDir.'/'.$value2;
                                if($x<$delFileByFolder){
                                    if($delOpr){unlink($fullName);}
                                }
                                $sizes+=$size;
                                $x++;
                            }
                            $i++;
                        }
                    }
                    $all+=$i;
                    if($i){
                        echo '<span class="clr5">'.$value.' : ('.$i.'-'.$x.')</span>'.$files.'<br>';
                    }else{
                        rmdir($subDir);
                    }
                }
            } 
        } 
        echo '<div class="w100 fs18 clr5">['.number_format($all).']</div>';
    }
    if($t==4){
        $dir='../../'.$fFolder.'/resize';   
        $all=0;
        $sizes=0;
        $delFileByFolder=$recs;
        $cdir=scandir($dir);
        
        echo '<div class="w100 fs18 clr5 lh60">['.number_format(count($cdir)-2).'/'.number_format($delFileByFolder).']</div>';
        foreach ($cdir as $key => $value){          
            if (!in_array($value,array(".",".."))){ 
                $fullName=$dir.'/'.$value;
                if($x<$delFileByFolder){
                    if($delOpr){unlink($fullName);}                    
                   /* echo '<div class="fl Over mg5f">
                        <img src="'.$fullName.'"  height="100"/>
                    </div>';*/
                    $x++;
                }
            } 
        } 
        
    }
    
    if($t==11){
        $total=getTotal($table);
        $sql="select * from $table order by id ASC limit $page,$recs ";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        $rowsTxt=$rows;
        $photos='';
        if($total>$rows){$rowsTxt=number_format($total).'/'.number_format($rows);}?>
        <div class="lh40 f1 fs16 clr1"><?=k_num_res?>:<ff> ( <?=$rowsTxt?> )</ff></div><?
        if($rows){
            $x=0;
            $sizes=0;
            while($r=mysql_f($res)){
                $id=$r['id'];
                $file=$r['file'];                
                $name=$r['name'];
                $date=$r['date'];
                $size=$r['size'];
                $ex=$r['ex'];
                if(chPhotoLink($mods,$id)==0){
                    $folder=date('y-m',$date).'/';
                    $w=80;
                    $h=80;                
                    $image='';
                    $dir=2;
                    $bf=str_repeat('../',$dir);		
                    $this_file=$m_path.'upi/'.$folder.$file;
                    $r_file=$bf.$fFolder.'/'.$folder.$file;                
                    if(file_exists($bf.$fFolder.'/'.$folder.$file)){
                        $photos.= '<div class="fl Over mg5f bord cbg4 pd5f">'.$name.'</div>';                           
                    }
                    $sizes+=$size;
                    if($delOpr){deleteFiles($id);}
                    $x++;
                }
            }
        }
        echo '<div class="fl w100 fs18 clr5 lh60">['.$x.']['.getFileSize($sizes).']</div>'.$photos;
    }
    if($t==12){
        $total=getTotal($table);
        $sql="select * from $table order by id ASC limit $page,$recs";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        $rowsTxt=$rows;
        $x=0;
        $data='';
        if($total>$rows){$rowsTxt=number_format($total).'/'.number_format($rows);}
        if($rows){
            $data.='<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s g_ord holdH" type="static" >
            <tr><th width="250">'.k_file.'</th>
            <th>'.k_links.'</th>
            </tr>';
            while($r=mysql_f($res)){
                $id=$r['id'];
                $file=$r['file'];                
                $name=$r['name'];
                $date=$r['date'];
                $size=$r['size'];
                $ex=$r['ex'];
                
                $folder=date('y-m',$date).'/';                
                $dir=2;
                $bf=str_repeat('../',$dir);                
                $r_file=$bf.$fFolder.'/'.$folder.$file;                
                if(!file_exists($bf.$fFolder.'/'.$folder.$file)){
                    $data.= '<tr >
                    <td>'.$name.'</td>
                    <td>'.fixTableData($mods,$id,$table).'</td>
                    </tr>';
                    $x++;
                }
            }
            $data.= '</table>';
        }
        ?>
        <div class="lh40 f1 fs16 clr1"><?=k_num_res?>:<ff> ( <?=$rowsTxt?> )</ff></div>
        <div class="fl w100 fs18 clr5 lh60">[<?=number_format($x)?>]</div><?
        echo $data;
    }
    if($t==13){
        $dir='../../'.$fFolder;   
        $all=0;
        $sizes=0;
        $delFileByFolder=25;
        $cdir=scandir($dir);
        foreach ($cdir as $key => $value){            
            if (!in_array($value,array(".",".."))){ 
                $subDir=$dir.'/'.$value;
                if(is_dir($subDir)){
                    $cdir2=scandir($subDir);
                    $i=0;
                    $x=0;
                    $files='';
                    foreach ($cdir2 as $key2 => $value2){
                        if (!in_array($value2,array(".",".."))){ 
                            $ph_id=get_val_c($table,'id',$value2,'file');
                            if(!$ph_id){                                
                                $files.=' | '.$value2;
                                $fullName=$subDir.'/'.$value2;
                                if($x<$delFileByFolder){
                                    if($delOpr){unlink($fullName);}
                                }
                                $sizes+=$size;
                                $x++;
                            }
                            $i++;
                        }
                    }
                    $all+=$i;
                    if($i){
                        echo '<span class="clr5">'.$value.' : ('.$i.'-'.$x.')</span>'.$files.'<br>';
                    }else{
                        rmdir($subDir);
                    }
                }
            } 
        } 
        echo '<div class="w100 fs18 clr5">['.number_format($all).']</div>';
    }    
}?>
