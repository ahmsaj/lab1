<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
    $id=pp($_POST['id']);    
    $q='';
    $docGrp="'7htoys03le','nlh8spit9q','9k0a1zy2ww','1ceddvqi3g','66hd2fomwt','9yjlzayzp','fk590v9lvl'";
    if($id){
        $mood=get_val('gnr_m_clinics','type',$id);
        if($mood==4){
            $docGrp=" 'fk590v9lvl' ";
        }else{
            $selClnc=getAllLikedClinics($id);
            $q=" and CONCAT(',', `subgrp`, ',') REGEXP ',($selClnc),' ";
        }
    }
    echo '<div class=" w100">';
    $c_type=get_val('gnr_m_clinics','type',$id);
    $docs=array();
    $sql="select * from _users where  `grp_code` IN($docGrp)  and act=1 $q";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows>0){
        $i=0;
        while($r=mysql_f($res)){
            $docs[$i]['id']=$r['id'];
            $docs[$i]['name']=$r['name_'.$lg];
            $docs[$i]['subgrp']=$r['subgrp'];
            $docs[$i]['grp_code']=$r['grp_code'];
            $i++;
        }
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" type="static" <tr ><th></th>';
        foreach($weekMod as $d){ echo '<th class="f1 fs16" width="12%">'.$wakeeDays[$d].'</th>';}
        echo '<tr>';
        foreach($docs as $doc){
            $u=$doc['id'];
            $sql="select * from  gnr_m_users_times d where id='$u' ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            $docs_data=array();
            if($rows>0){
                $i=0;
                $r=mysql_f($res);
                $days=$r['days'];
                $type=$r['type'];
                $data=$r['data'];
                $subgrp=$doc['subgrp'];
                $docGrp=$doc['grp_code'];
                $d_days=explode(',',$days);                
                $day_no=date('w');
                $clnName='';  
                
                $docClinic='';
                $actClinic='';//لتلوين عيادة الااسنان المطابقة
                if($docGrp=='fk590v9lvl'){// طبيب اسنان
                    $docClinic='<br><span>( '.get_val_arr('gnr_m_clinics','name_'.$lg,$subgrp,'n').' )</span>';
                    if($subgrp==$id){
                        $actClinic=' style="background-color:'.$clr1.'" ';
                    }
                }
                echo '<tr oprTr="'.$doc['name'].'">
                <th '.$actClinic.' ><div class="f1">'.$doc['name'].$docClinic.'</div></th>';
                foreach($weekMod as $d){
                    $clor='';
                    if($day_no==$d){$clor=$clr44;}
                    if(in_array($d,$d_days)){
                        if($type==1){
                            $d_data=explode(',',$data);
                            $thisDay='<ff14>'.clockStr($d_data[0]).'<br>'.clockStr($d_data[1]).'</ff14>';
                        }
                        if($type==2){
                            $d_dates=explode('|',$data);
                            $i=0;                            
                            foreach($d_days as $dd){
                                if($dd==$d){
                                    $dd_dates=explode(',',$d_dates[$i]);
                                     $thisDay='<ff14>'.clockStr($dd_dates[0]).' <br> '.clockStr($dd_dates[1]).'</ff14><br>';
                                     if($dd_dates[2]){
                                        $thisDay.='------------<br><ff14>'.clockStr($dd_dates[2]).' <br> '.clockStr($dd_dates[3]).'</ff14><br>';
                                     }
                                }
                                $i++;
                            }
                        }
                    }else{
                         $thisDay='-';
                    }
                    echo '<td bgcolor="'.$clor.'">'.$thisDay.'</td>';
                }
                echo '</tr>';
            }
        }
        echo '</table>';
    }
    
    echo '</div>';
}?>