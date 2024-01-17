<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'],$_POST['m'])){
	$id=pp($_POST['v']);
    $mood=pp($_POST['m']);
    $r=getRec($visXTables[$mood],$id);
    if($r['r']){
        $pat=$r['patient'];
        $clinic=$r['clinic'];
        $doctor=$r['doctor'];
        $d_start=$r['d_start'];
        $d_finish=$r['d_finish'];
        $pay_type=$r['pay_type'];
        $rate=$r['rate'];        
        $patName=get_p_name($pat);?>
        <div class="ofx so h100 pd10f">            
            <table width="100%" border="0" cellspacing="0" cellpadding="6" class="grad_s2" >
                    <tr>
                        <td class="f1 fs14 pd10" width="200"><?=k_num?>:</td>
                        <td class="f1 fs14 pd10 clr66"><ff><?=number_format($id)?></ff></td>
                    </tr><? 
                if($mood!=2){
                    $clinicName=get_val('gnr_m_clinics','name_'.$lg,$clinic);
                    $docName=get_val('_users','name_'.$lg,$doctor);?>
                    
                    <tr>
                        <td class="f1 fs14 pd10"><?=k_dr?>:</td>
                        <td class="f1 fs14 pd10 clr66"><?=$docName?></td>
                    </tr>
                    <tr>
                        <td class="f1 fs14 pd10 "><?=k_clinic?>:</td>
                        <td class="f1 fs14 pd10 clr66"><?=$clinicName?></td>
                    </tr><? 
                }?>
                <tr>
                    <td class="f1 fs14 pd10 "><?=k_date?>:</td>
                    <td class="f1 fs14 pd10 clr66">
                        <ff dir="ltr"><?=date('Y-m-d',$d_start).' <br> '.date('Ah:i',$d_start).' - '.date('Ah:i',$d_finish)?></ff>
                    </td>
                </tr>
                <tr>
                    <td class="f1 fs14 pd10 "><?=k_visit_srvcs?>:</td>
                    <td class="f1 fs14 pd10 clr66"><?
                      $srvs=get_vals($srvXTables[$mood],'service',"visit_id='$id' ");
                      echo $srvTxt=get_vals($srvTables[$mood],'name_'.$lg," id IN($srvs)",' :: ');
                    ?>
                    </td>
                </tr>
            </table>
        </div><?
    }
    
}?>