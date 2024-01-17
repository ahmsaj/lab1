<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('api_x_promotion',$id);
    if($r['r']){
        $status=$r['status'];
        $cat=$r['cat'];
        if($status<3){
            $sex=pp($_POST['sex']);
            $age_from=pp($_POST['age_from']);
            $age_to=pp($_POST['age_to']);            
            $b_date=0;      
            $area=0;
            if(isset($_POST['area'])){
                $area=pp(implode(',',$_POST['area']),'s');        
            }
            $q='';
            if($sex){
                $q.="and sex = '$sex' ";
            }
            if($area){
                $q.="and p_area in($area)";
            }
            if($cat==2){ 
                $b_date=pp($_POST['b_date'],'s');                
                $b_d=strtotime($b_date);                
                $m=date('m',$b_d);
                $d=date('d',$b_d);
                $q.=" and DAY(birth_date) = $d  and MONTH(birth_date) = $m ";                
            }
            $audience_data=[
              'sex'=>$sex,
              'area'=>$area,
              'age_from'=>$age_from,
              'age_to'=>$age_to,
              'b_date'=>$b_date,
            ];
            $audience_data_text=json_encode($audience_data);            
            if($age_from || $age_t){
                $from=0;
                $to=100;
                if($age_from){$from=$age_from;}
                if($age_to){$to=$age_to;}
                unset($ages);
                $ages=[[$from,$to]];
                $q.="
                and TIMESTAMPDIFF(YEAR, `birth_date`, CURDATE()) >= $from 
                and TIMESTAMPDIFF(YEAR, `birth_date`, CURDATE()) < ($to+1) "; 
                $ages[0][2]=getTotalCo('gnr_m_patients',"token!='' $q2 $q");
            }

            /******************************************************/  
            mysql_q("delete from  api_x_promotion_msg where promotion_id='$id'");
            $sql="select id from gnr_m_patients where token!='' $q";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                mysql_q("UPDATE api_x_promotion set audience='$audience_data_text' , status=2 , total='$rows' where id='$id'");
                while($r=mysql_f($res)){
                    $pat_id=$r['id'];
                    mysql_q("INSERT INTO api_x_promotion_msg (`promotion_id`,`patient`)values('$id','$pat_id')");
                }
            }
            echo 1;
            
            
        }
    }
}?>