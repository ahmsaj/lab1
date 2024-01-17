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
                $b_date=strtotime($_POST['b_date']);
                $m=date('m',$b_date);
                $d=date('d',$b_date);
                $q.=" and DAY(birth_date) = $d  and MONTH(birth_date) = $m; ";                
            }
            $ages=[
                [0,10,0],
                [10,20,0],
                [20,30,0],
                [30,40,0],
                [40,50,0],
                [50,60,0],
                [60,70,0],
                [70,80,0],
                [80,90,0],
                [90,100,0],        
            ];    
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
            }else{
                foreach($ages as $k=>$age){
                    $from=$age[0];
                    $to=$age[1];
                    $q2="
                    and TIMESTAMPDIFF(YEAR, `birth_date`, CURDATE()) >= $from 
                    and TIMESTAMPDIFF(YEAR, `birth_date`, CURDATE()) < $to ";
                    $ages[$k][2]=getTotalCo('gnr_m_patients',"token!='' $q2 $q");
                }
            }

            /******************************************************/
            //echo "token!='' $q";
            $total=getTotalCo('gnr_m_patients',"token!='' $q");
            $sex1=$sex2=0;        
            if($sex){
                if($sex==1){$sex1=getTotalCo('gnr_m_patients',"token!='' $q");}
                if($sex==2){$sex2=getTotalCo('gnr_m_patients',"token!='' $q");}         
            }else{
                $sex1=getTotalCo('gnr_m_patients',"token!='' and sex=1 $q");
                $sex2=getTotalCo('gnr_m_patients',"token!='' and sex=2 $q");
            }

            ?>
            <div class="f1 fs16 lh40">إجمالي الجمهور المستهدف: <ff><?=number_format($total)?></ff></div>
            <div class="f1 fs14 clr1 lh40">الجنس:</div>
            <table class="grad_s holdH " width="100%">
                <tr>
                    <td class="f1 fs12">إجمالي الجمهور ذكور: </td>
                    <td><ff><?=number_format($sex1)?></ff></td>
                </tr>
                <tr>
                    <td class="f1 fs12">إجمالي الجمهور إناث: </td>
                    <td><ff><?=number_format($sex2)?></ff></td>
                </tr>    
            </table>

            <div class="f1 fs14 clr1 lh40">العمر:</div>
            <table class="grad_s holdH " width="100%">          
                <? foreach($ages as $age){
                    echo '
                    <tr>
                    <td class="f1 fs12" dir="rtl">من '.$age[0].'  الى '.$age[1].'  </td>
                    <td><ff>'.number_format($age[2]).'</ff></td>
                    </tr>';
                }?> 
            </table>
            <?    
            if($total){echo '<div class="ic40 ic40_set ic40Txt icc1 mg20v" onclick="genrUdience()">توليد قائمة الجمهور</div>';}
        }
    }
}?>