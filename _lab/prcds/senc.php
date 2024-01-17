<? include("../../__sys/prcds/ajax_header_x.php");
//mysql_q("INSERT INTO lab_x_senc(date)values('$now')");
include($folderBack."_lab/funs.php");
if(_set_wr54mldf53){
    if(isset($_POST['t'])){	
        $t=pp($_POST['t']);
        if($t){
            $_SESSION['str']=$now;
            $startTime=$now;
        }else{
            $startTime=$_SESSION['str'];
        }
        $time=$now-$startTime;
        $recs=0;  
        $data='';
    }
    /**********************************/
    $dir='../../../Results';    
    $cdir=scandir($dir);
    $maxFiles=7;
    $sss=0;
    foreach ($cdir as $key => $value){
        if (!in_array($value,array(".",".."))){
            if($sss<$maxFiles){ 
                $sss++;
                $file=$dir.'/'.$value;             
                $fData=file_get_contents($file);                
                $json=json_decode($fData,true); 
                echo $vis=$json['visit_id'];
                $r=getRec('lab_x_visits',$vis);
                if($r['r']){
                    $pat=$r['patient'];
                    list($sex,$age)=getPatInfoL($pat);
                    $data.='<br>------> V:'.$vis.'=> ';
                    $srvs=$json['services'];
                    $itemsArr=[];
                    $itemsData=[];
                    foreach($srvs as $s){                        
                        $srev_id=$s['Service'];
                        $data.='S:'.$srev_id.' | ';
                        $items=$s['items'];
                        $itemsData[$srev_id]=$s['items'];
                        foreach($items as $i){
                            $itemId=$i['id'];
                            $itemRes=$i['Result'];
                            $itemsArr[$itemId]=$itemRes;                        
                        }
                    }
                    $sql="select * , z.id as z_id ,x.id as x_id from lab_x_visits_services x , lab_m_services z where x.service=z.id and visit_id ='$vis' order by x.id ASC";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows>0){
                        $qu='';
                        while($r=mysql_f($res)){
                            $srv_id=$r['z_id'];
                            $x_id=$r['x_id'];
                            $vis_id=$r['visit_id'];
                            $name=$r['short_name'];
                            $report_de=$r['report_de'];
                            $type=$r['type'];
                            $sample=$r['sample'];
                            $srv_status=$r['status'];
                            $patient=$r['patient'];
                            $patient=$r['patient'];
                            //$srv=$r['service'];
                            //echo '('.$srv_status.')';

                            /*if(isset($_POST['note_'.$x_id])){
                                $note=pp($_POST['note_'.$x_id],'s');			
                                mysql_q("UPDATE lab_x_visits_services set note='$note' where id='$x_id'");
                            }*/			

                            //if(editebalAna($srv_status)){						
                                if($type==1 || $type==4){					
                                    $sql2="select * from lab_m_services_items  where serv='$srv_id' and type=2 and act=1 order by ord ASC";
                                    $res2=mysql_q($sql2);
                                    $rows2=mysql_n($res2);
                                    if($rows2>0){
                                        $completed=1;
                                        $entered=0;
                                        while($r2=mysql_f($res2)){
                                            $status=0;
                                            $addVals='';			
                                            $s_id=$r2['id'];
                                            $unit=$r2['unit'];
                                            $hide=$r2['hide'];
                                            $r_type=$r2['report_type'];
                                            //if(isset($_POST['lrp_'.$s_id.'_'.$vis_id])){//---------------
                                            //    $value=pp($_POST['lrp_'.$s_id.'_'.$vis_id],'s');//----------
                                            if($itemsArr[$s_id]!=''){
                                                $value=pp($itemsArr[$s_id],'s');
                                                //if($s_id==510){echo '['.$value.']';}
                                                if($value!=''){$status=1;}else{$completed=0;}								
                                                list($nValId,$nVal,$addVals)= get_LreportNormalVal($r_type,$s_id,$vis_id,$sex,$age,$sample,1);
                                                if($value!=''){
                                                    $entered++;
                                                    if(getTotalCO('lab_x_visits_services_results'," serv_id='$x_id' and serv_val_id='$s_id' ")==0){
                                                        $sql3="INSERT INTO lab_x_visits_services_results 
                                                        (`serv_id`, `serv_val_id`, `serv_type`, `value`, `add_value`, `normal_val`, `user`, `status`, `patient` ,`vis` ,`serv_id_m`,`normal_val_id`,`unit`,`hide`,`date`) VALUES 
                                                        ('$x_id','$s_id', '$r_type', '$value', '$addVals', '$nVal', '$thisUser', '$status', '$patient' ,'$vis_id' ,'$srv_id','$nValId','$unit','$hide','$now' )";
                                                    }else{
                                                        $sql3="UPDATE lab_x_visits_services_results SET 
                                                        `serv_type`='$r_type' , 
                                                        `value`='$value',
                                                        `add_value`='$addVals',
                                                        `normal_val`='$nVal',
                                                        `user`='$thisUser',
                                                        `status`='$status'
                                                        WHERE serv_id='$x_id' and serv_val_id='$s_id'";
                                                    }
                                                    mysql_q($sql3);
                                                }
                                            }
                                        }
                                        if($entered){
                                            if($completed==1){
                                                $vs_status=8;
                                                if(_set_tv48bnhybm){$vs_status=7;}
                                            }else{
                                                $vs_status=6;
                                            }
                                            if($srv_status==9){$vs_status=10;}
                                            mysql_q("UPDATE lab_x_visits_services set status='$vs_status' , report_wr='$thisUser' , date_enter='$now' where id='$x_id'");
                                            mysql_q("UPDATE lab_x_visits_services_results_x set status=1  where srv='$x_id'");
                                        }
                                    }
                                }

                                if($type==2){
                                    $items=$itemsData[$x_id][0];
                                    ////var_dump($items);
                                    $res_type=$items['status'];                                                                         
                                    $s_type=$colonies=$level=$bact=$wbc=$rbc=$note='';

                                    $s_type=pp($items['sample']);
                                    $colonies=pp($items['colonies']);
                                    $level=pp($items['level']);
                                    $bact=pp($items['bacteria']);
                                    $wbc=pp($items['wbc'],'s');
                                    $rbc=pp($items['rbc'],'s');
                                    $note=pp($items['notes'],'s');			

                                    if(getTotalCO('lab_x_visits_services_result_cs'," serv_id='$x_id' ")==0){
                                        $sql="INSERT INTO lab_x_visits_services_result_cs 
                                        (`serv_id`,`val`,`ana_type`, `sample_type`, `colonies`, `level`, `bacteria`, `wbc`, `rbc`,`note`,`user`,`status`) VALUES 
                                        ('$x_id','$res_type','$type', '$s_type', '$colonies', '$level','$bact','$wbc','$rbc','$note','$thisUser','1')";
                                    }else{				
                                         $sql="UPDATE lab_x_visits_services_result_cs SET val='$res_type' , `sample_type`='$s_type',`colonies`='$colonies', 
                                         `level`='$level', `bacteria`='$bact', `wbc`='$wbc', `rbc`='$rbc',`note`='$note' WHERE serv_id='$x_id' ";
                                    }
                                    $res44=mysql_q($sql);
                                    $s_id=last_id();
                                    mysql_q("DELETE from lab_x_visits_services_result_cs_sub where p_id='$x_id' ");						$subSev_id=get_val_c('lab_x_visits_services_result_cs','id',$x_id,'serv_id');
                                    if($res44){
                                        $sql2="select * from lab_m_test_antibiotics where act=1 order by ord ASC";
                                        $res2=mysql_q($sql2);
                                        $rows2=mysql_n($res2);
                                        if($rows2>0){
                                            $antiBio=[];
                                            $results=$items['results'];
                                            foreach($results as $k=>$v){
                                                foreach($v as $k2=>$v2){
                                                    $antiBio[$k2]=$v2;
                                                }
                                            }

                                            while($r2=mysql_f($res2)){
                                                $n_id=$r2['id'];
                                                $n_name=$r2['name'];
                                                $trad_name=$r2['trad_name'];
                                                $min_val=$r2['min_val'];
                                                $max_val=$r2['max_val'];
                                                if(isset($antiBio[$n_id])){
                                                //if(isset($_POST['anti_'.$n_id])){
                                                    $intiVal=pp($antiBio[$n_id],'f');
                                                    if($intiVal){
                                                        $code='I';							
                                                        if($intiVal<=$min_val){$code="R";}
                                                        if($intiVal>=$max_val){$code="S";}
                                                        mysql_q("INSERT INTO lab_x_visits_services_result_cs_sub (`p_id`,`antibiotics`,`min_val`,`max_val`,`val`,`code`)	values('$x_id','$n_id','$min_val','$max_val','$intiVal','$code')");
                                                    }
                                                }
                                            }				
                                        }
                                    }
                                    $vs_status=7;
                                    if($srv_status==9){$vs_status=10;}
                                    mysql_q("UPDATE lab_x_visits_services set status='$vs_status' , report_wr='$thisUser' , date_enter='$now' where id='$x_id'");
                                    mysql_q("UPDATE lab_x_visits_services_results_x set status=1 where srv='$x_id'");                                    
                                }

                                if($type==5 && $id_type==1 ){		
                                    $sql2="select * from lab_m_test_mutations where act=1 order by name ASC";
                                    $res2=mysql_q($sql2);
                                    $rows2=mysql_n($res2);
                                    if($rows2>0){
                                        $val='';
                                        while($r2=mysql_f($res2)){
                                            $n_id=$r2['id'];				
                                            if(isset($_POST['mut_c_'.$n_id])){
                                                $v1=pp($_POST['mut_'.$n_id]);
                                                $v2=pp($_POST['mut2_'.$n_id]);
                                                if($v1==0){$v2=0;}
                                                if($val){$val.='|';}
                                                $val.=$n_id.':'.$v1.':'.$v2;
                                            }
                                        }
                                    }
                                    if(getTotalCO('lab_x_visits_services_results'," serv_id='$x_id' and serv_val_id='0' ")==0){
                                        //$sql3="INSERT INTO lab_x_visits_services_results 
                                        //(`serv_id`, `serv_val_id`, `serv_type`, `value`, `add_value`, `normal_val`, `user`, `status`) VALUES 
                                        //('$x_id',0, '', '$val', '', '','$thisUser','1')";

                                        $sql3="INSERT INTO lab_x_visits_services_results 
                                        (`serv_id`, `serv_val_id`, `serv_type`, `value`, `add_value`, `normal_val`, `user`, `status`, `patient` ,`vis`,`date`) VALUES 
                                        ('$x_id',0, '', '$val', '', '', '$thisUser', '1', '$patient' ,'$vis_id','$now')";
                                    }else{
                                        $sql3="UPDATE lab_x_visits_services_results SET `value`='$val' ,
                                        `patient`='$patient' ,`vis`='$vis_id',`user`='$thisUser' WHERE serv_id='$x_id' and serv_val_id='0'";
                                    }
                                    $res3=mysql_q($sql3);
                                    if($res3){
                                        $vs_status=7;
                                        if($srv_status==9){$vs_status=10;}
                                        mysql_q("UPDATE lab_x_visits_services set status='$vs_status' , report_wr='$thisUser' , date_enter='$now' where id='$x_id'");
                                        mysql_q("UPDATE lab_x_visits_services_results_x set status=1 where srv='$x_id'");
                                    }
                                }

                            //}
                        }
                        mysql_q("INSERT INTO lab_x_senc (`date`,`vis`,`data`)values('$now','$vis','$fData')");
                        @unlink($file);
                        
                    }else{
                        @unlink($file);
                    }
                    $recs++;
                }else{
                    @unlink($file);
                }
            }
        } 
    } 

    /**********************************/
    if($t){
        if($data){
            $data='<div class="f1 fs10 lh20 ">'.date('A h:i:s').' : '.$data.'</div>';
        }
        echo date('Y-m-d A m:i:s',$startTime).'^',dateToTimeS2($time).'^'.$recs.'^'.$data;
    }
}
?>

