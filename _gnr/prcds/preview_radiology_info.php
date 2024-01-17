<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	list($v_status,$visit_id,$x_clinic,$diagnosis)=get_val('xry_x_visits_requested','status,visit_id,x_clinic,diagnosis',$id);    
	$x_clinic_name=get_val('gnr_m_clinics','name_'.$lg,$x_clinic);
	if($v_status!=4){
		if(getTotalCO('xry_x_visits_requested_items',"r_id='$id' and status!=4")==0){
			if(mysql_q("UPDATE xry_x_visits_requested set status=4 where id='$id' ")){$v_status=4;}
		}
	}?>
    <div class="h100 ofx fxg" fxg="gtr:1fr 51px">
        <div class="ofx so pd10 "><?
            $sql="select * from xry_x_visits_requested_items where r_id='$id' ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){?>            
                <div class="f1 fs14 lh40 clr1"><?=k_status?>: <?=$an_requst[$v_status]?></div>
                <div class="f1 fs14 lh40 clr1"><?=k_diagnoses?> : <?=$diagnosis?></div> 
                <table border="0" width="100%" cellspacing="0" cellpadding="4" class="grad_s" type="static">
                <tr><th><?=k_photo?></th><th><?=k_status?></th><th><?=k_notes?></th></tr><?
                while($r=mysql_f($res)){
                    $x_id=$r['id'];
                    $status=$r['status'];
                    $action=$r['action'];
                    $xphoto=$r['xphoto'];
                    $act=$r['act'];
                    $service_id=$r['service_id'];
                    $mad_name=get_val('xry_m_services','name_'.$lg,$xphoto);
                    $msg='';
                    $msg2='';
                    if($status>1){
                        $msg2='<div class="fr ic30 icc33 ic30_info ic30Txt mg10" onclick="veiwPxResult('.$x_id.')">عرض الصورة</div>';
                    }
                    if($status==0 && $action==2){
                        $msg2='<div class="fr ic30 icc1 ic30_edit ic30Txt mg10" onclick="veiwPxResult('.$x_id.')">رفع الصورة</div>';
                    }
                    if($act==0){
                        $msg='<div class="clr5 f1">'.k_not_available_in_xray.'</div>';
                    }?>
                    <tr class="ana_values" id="<?=$x_id?>">    
                        <td class="f1 fs14"><?=splitNo($mad_name).$msg?></td>
                        <td><div class="f1" style="color:<?=$an_requst_in_col[$status]?>"><?=$an_requst_in[$status]?></div></td>
                        <td class="f1"><?=$msg2?></td>
                    </tr><?
                }?>		
                </table><?
            }?>
        </div>
        <div class="cbg444 t_bord lh50 pd10f"><?
            if($v_status==0){
                echo '<div class="ic30 icc22 ic30_del  ic30Txt fl" onclick="delXph('.$id.')">'.k_delete.'</div>';
                echo '<div class="ic30 icc11 ic30_edit ic30Txt mg10 fl" onclick="new_xphoto('.$id.','.$x_clinic.',2,\''.$x_clinic_name.'\')"> '.k_edit.'</div>';
                echo '<div class="ic30 icc33 ic30_send ic30Txt fr" onclick="xrySendpxN('.$id.')">'.k_send_img.'</div>';
            }                
            if($v_status>2){
                if(getTotalCO('lab_x_visits_requested_items'," r_id='$id' and action=1 and status>1")){
                    echo '<div class="fr ic30 icc4 ic30_info ic30Txt" onclick="veiwAnaResult('.$id.',1)">'.k_view_all_results.'</div>';
                }
            }
            if($v_status>0){
                if(getTotalCO('lab_x_visits_requested_items'," r_id='$id' and action=2")>0){
                   // echo '<div class="ic40 icc1 ic40_print fr" title="'.k_print_ex_img.'" onclick="printWindow(3,'.$id.')"></div>';
                }
            }
            /*if($v_status>0){
                if(getTotalCO('lab_x_visits_requested_items'," r_id='$id' and action=2")>0){
                    echo '<div class="ic40 icc1 ic40_print fr" title="طباعة التحاليل الخارجية" onclick="printWindow(2,'.$id.')"></div>';
                }
            }*/?>                
        </div>
    </div><?
        	
}?>