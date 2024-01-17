<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if( isset($_POST['id'])){	
	$v_id=pp($_POST['id']);    
	$c_type=get_val('gnr_m_clinics','type',$userSubType);
    $table=$visXTables[$c_type];
    if($c_type==3){
        $r=getRecCon($table,"id='$v_id' and  `ray_tec`='$thisUser'");
    }else{
        $r=getRecCon($table,"id='$v_id' and  `doctor`='$thisUser'");
    }
    
    if($r['r']){
        $patient=$r['patient'];
        $d_check=$r['d_check'];
        $d_finish=$r['d_finish'];
        $status=$r['status'];
        $dts_id=$r['dts_id'];        
        $srvs=get_vals($srvXTables[$c_type],'service',"visit_id='$v_id'");
        $services=get_vals($srvTables[$c_type],'name_'.$lg," id IN ($srvs)"," :: ");
        ?>
        <div class="form_body so" type="pd0">
            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="infoTable" type="static" over="0">               
                <tr>			
                    <td txt width="150">رقم الزيارة:</td>
                    <td><ff><?=$v_id?></ff></td>                    
                </tr>
                <tr>			
                    <td txt>المريض:</td>
                    <td txt><?=get_p_name($patient)?></td>
                </tr>
                <tr>
                    <td txt>التاريخ:</td>
                    <td><ff><?=date('Y-m-d',$d_check)?></ff></td>
                </tr>
                <tr>
                    <td txt>الحالة:</td>
                    <td txt style="color:<?=$stats_arr_col[$status]?>"><?=$stats_arr[$status]?></td>
                </tr>
                <tr>
                    <td txt>الخدمات:</td>
                    <td txt><?=$services?></td>
                </tr>
            </table>
        </div>
        <div class="form_fot fr"><?            
            if($c_type==1 && $status==2 && ($d_finish+3600)>$now){                
                echo '<div class="fl bu bu_t3" onclick="reopenVis('.$v_id.','.$c_type.')" >'.k_reopen_visit.'</div>';
            }?>
            <div class="bu bu_t2 fr" onclick="<?=$wlp?>win('close','#m_info4');"><?=k_close?></div>		
            <?  $loc=$f_path.$prvPages[$c_type].'.'.$v_id;			?>
            <div class="bu bu_t1 fl" onclick="loc('<?=$loc?>');"><?=k_prev_edit?></div>
        </div><?
    }
}?>
</div>