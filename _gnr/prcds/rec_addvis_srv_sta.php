<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'],$_POST['m'])){
	$vis=pp($_POST['v']);
	$mood=pp($_POST['m']);
	if($vis && $mood){
        $r=getRec($visXTables[$mood],$vis);
        if($r['r']){
           $c=$r['clinic'];
           $pat=$r['patient'];
           $doc=$r['doctor'];
           if($mood==3){
               $doc=$r['ray_tec'];
           }
           $pay_type=$r['pay_type'];
           $sub_status=$r['sub_status'];            
        }
		if($mood==2){
			$pat=get_val($visXTables[$mood],'patient',$vis);
            list($name,$photo)=get_val_con('gnr_m_clinics','name_'.$lg.',photo',"type=2");
		}else{
            list($name,$photo,$mood)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);
		}
	}    
	$ph_src=viewImage($photo,1,30,30,'img','clinic.png');
	echo biludWiz(5,1);?>
    <script>actNVPat='<?=$pat?>'</script>
	<div class="fl of fxg" fxg="gtc:1fr 3fr|gtc:1fr 2fr:1100" fix="wp:0|hp:50">
		<div class="fl pd10 of fxg" fxg="gtr:auto auto 1fr" ><?
			$rPat=getRec('gnr_m_patients',$pat);
			if($rPat['r']){
				$photo=$rPat['photo'];
				$sex=$rPat['sex'];
				$title=$rPat['title'];
				$birth_date=$rPat['birth_date'];
				$birthCount=birthCount($birth_date);
                $emplo=$r['emplo'];
                $dts_id=$r['dts_id'];
                $empTxt='';
                if($emplo){$empTxt='<span class="clr5 f1"> ('.k_employee.')</span>';}
				$bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
				$titles=modListToArray('czuwyi2kqx');
				$patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');				
				$pName=$titles[$title].' : '.$rPat['f_name'].' '.$rPat['ft_name'].' '.$rPat['l_name'].$empTxt;
			}?>
			<div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
				<div class="fl pd5"><?=$patPhoto?></div>
				<div class="fl pd10f">
					<div class="lh20 f1 fs14 clr1111 Over" editPat="sta"><?=$pName?></div>
					<div class="lh20 f1 fs12 clr1"><?=$bdTxt?></div>
				</div>
			</div>
			<div class="fl w100 b_bord pd5v pd10">
                <div class=" lh30 f1 fs12 ">
                    <?=k_visit_num.' : <ff14 class="clr1">'.number_format($vis).'</ff14>'?>
                    <? if($dts_id){ echo ' | '.k_num_of_appointment.' : <ff14  class="clr1">'.number_format($dts_id).'</ff14>';}?>
                </div>
				<div class=" lh30 f1 fs12 "><?=k_clinic.' : '.$name?></div><?
                if($doc){
                    list($dName,$dPhoto,$sex)=get_val('_users','name_'.$lg.',photo,sex',$doc);?>
                    <div class=" lh30 f1 fs12  "><?=k_doctor.' : '.$dName?></div><?
                }
                if($mood==2 || $mood==3){
                    $doc_ord=$r['doc_ord'];
                    $visit_link=$r['visit_link'];
                    if($doc_ord){
                        if($visit_link){
                            $docAsc=get_val('_users','name_'.$lg,$doc_ord);
                        }else{
                            $docAsc=get_val('gnr_m_doc_req','name',$doc_ord);
                        }
                    }
                    $reqDoc=1;
                    if(_set_0hayrq7hy6 && $mood==2){$reqDoc=0;}
                    if(_set_qmzrxs0ivq && $mood==3){$reqDoc=0;}
                    if($docAsc){
                        $docTxt='<div class="f1 clr3 fs12" reqDoc="1" >'.k_requester_doctor.' : '.$docAsc.'</div>';	
                    }else{			
                        $docTxt='<div class="f1 lh30 clr5" reqDoc="'.$reqDoc.'" ><div class="fr i30 i30_edit"></div>'.k_doc_nt_idntf.'</div>';
                    }
                    echo $docTxt;
                }?>
            </div> 
			<div class="fl w100 ofx so mg10v" ><?
                if($mood!=6 && $mood!=4){
                    if($pay_type==0){
                        if(ex_cubon($mood)){?><div class="pay_icon icc84 ic40_offer fs16 Over" cubon>صرف كوبون</div><?}
                        if(_set_rkq2s40u5g){?><div class="pay_icon icc83 ic40_insr fs16 Over" payT="3">طلب تأمين</div><?}
                        if(_set_n5ks40i6j8){?><div class="pay_icon icc82 ic40_char fs16 Over" payT="2">طلب جمعية</div><?}
                        if(_set_hw3wi89dnk){?><div class="pay_icon icc81 ic40_exem fs16 Over" payT="1">طلب إعفاء</div><?}
                        ?>
                        <div class="hide" id="payMsgAl">
                            <div class="fxg" fxg="gtc:1fr 1fr|grs:2|gap:10px ">
                                <div class="f1 fs14 lh40 fxg hide" fxg="gcs:2" id="payMsg">طلب تأمين</div>
                                <div class="f1 clrw lh40 icc4 fs16 Over TC" ptBut1>تأكيد</div>
                                <div class="f1 clrw lh40 icc2 fs16 Over TC" ptBut2>الغاء</div>
                            </div>
                        </div><?
                    }else{?>
                        <div class="f1 fs14 lh30">نوع الطلب : <span class="f1 fs14 clr1"><?=$pay_types[$pay_type]?></span></div>
                        <div class="f1 fs14 lh30">حالة الطلب : <span class="f1 fs14 clr5"><? 
                            if($pay_type!=0){
                                list($status,$sub_status)=get_val_con('gnr_x_temp_oprs','status,sub_status',"type='$pay_type' and mood='$mood' and vis='$vis'");
                                if($pay_type==3){
                                    echo '<span class="f1 fs14 '.$payStatusArrRecClr[$sub_status].'">'.$payStatusArrRec[$sub_status].'</span>';
                                }else if($pay_type==2){
                                    echo '<span class="f1 fs14 '.$insurStatusColArr[$status].'">'.$reqStatusArr[$status].'</span>';
                                }else if($pay_type==1){
                                    echo '<span class="f1 fs14 '.$insurStatusColArr[$status].'">'.$reqStatusArr[$status].'</span>';
                                }
                            }?>
                        </div><?
                    }
                }?>
				<div class="fl ic40 ic40_ref icc1 hide" onclick="recNewVisSrvSta(<?=$vis?>,<?=$mood?>)"></div>
			</div>
		</div>		
		<div class="of cbg444 l_bord fxg " fxg="gtr:1fr auto"><?
            switch($mood){
                case 1:echo cln_selSrvsSta($vis);break;
                case 2:echo lab_selSrvsSta($vis);break;
                case 3:echo xry_selSrvsSta($vis);break;
                case 4:echo den_selSrvsSta($vis);break;
                case 5:echo bty_selSrvsSta($vis,$mood);break;
                case 6:echo bty_selSrvsSta($vis,$mood);break;
                case 7:echo osc_selSrvsSta($vis);break;
            }?>
		</div>
	</div><?
}?>