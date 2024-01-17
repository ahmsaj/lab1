<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $q='';
    if($id){$q="and clic='$id' "; }
    $sql="select * from gnr_x_roles where  status !=4 $q order by vis ASC";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){	
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" type="static" >
        <tr>
            <th>'.k_clinic.'</th>
            <th width="120">'.k_num.'</th>
            <th>'.k_patient.'</th>
            <th>'.k_tim.'</th>
            <th>'.k_status.'</th>
        </tr>';
        while($r=mysql_f($res)){
            $v_id=$r['id'];
            $vis=$r['vis'];
            $doctor=$r['doctor'];
            $patient=$r['pat'];
            $clinic=$r['clic'];
            $mood=$r['mood'];
            $no=$r['no'];
            $date=$r['date'];
            $type=$r['type'];				
            $v_status=$r['status'];
            $fast=$r['fast'];
            $pat_name=$r['pat_name'];
            $clinicTxt=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c1');
            $clinicC=get_val_arr('gnr_m_clinics','code',$clinic,'c2');							
            $statusCol=$status;										
            $textCode=$clinicC.'-'.$no;
            if($fast && $status==0){$statusCol='9'.$fast;}
            if($fast==2){$textCode=clockStr($no);}
            $patView=$pat_name;
            if($mood<8){
                $patView='<div class="f1 clr5 Over" visInfo="'.$mood.'-'.$vis.'">'.$pat_name.'</div>';
            }
            echo '				
            <tr oprTr="'.$pat_name.'" style="background-color:'.$rola_opr_clr[$v_status].'">
            <td class="f1 ">'.$clinicTxt.'</td>
            <td><div " class="bord pd10 pd5v br5 fs18 B ff mg5f cbgw">'.$textCode.'</div></td>
            <td class="f1 ">'.$patView.'</td>
            <td><ff14>'.date('A h:i',$date).'</ff></td>
            <td><span class="f1 fs12" >'.$rola_opr_txt[$v_status].'</td>
            </tr>';
        }
        echo '</table>';            
    }else{echo '<div class="f1 fs14 clr5 lh40">'.k_npat_wait.'</div>';}
        
}?>