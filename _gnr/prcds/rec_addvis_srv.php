<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p'],$_POST['c'],$_POST['v'],$_POST['p'],$_POST['d'])){
	$pat=pp($_POST['p']);
	$c=pp($_POST['c']);//clinic
	$doc=pp($_POST['d']);
	$vis=pp($_POST['v']);
    $reqOrd=pp($_POST['reqOrd']);
	$mood=pp($_POST['m']);
    $t=pp($_POST['t']);
    $dts_id=pp($_POST['dts']);
    if($dts_id){
        $r=getRec('dts_x_dates',$dts_id);
        if($r['r']){
            $t=2;
            //$vis=$dts_id;
            $mood=$r['type'];
            $doc=$r['doctor'];
            $c=$r['clinic'];
        }
    }
    $wizTab=4;
    if($t==2){$wizTab=2;}
	if($vis && $mood){
		if($mood==2){
			$pat=get_val($visXTables[$mood],'patient',$vis);            
		}else{            
			list($c,$pat,$doc)=get_val($visXTables[$mood],'clinic,patient,doctor',$vis);            
		}
        if($mood==3){$doc=get_val($visXTables[$mood],'ray_tec',$vis);}
	}
    if($mood==2){        
        list($cnlicName,$photo)=get_val_con('gnr_m_clinics','name_'.$lg.',photo'," type=2 ");
    }else{        
        list($cnlicName,$photo,$mood)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);        
    }
	echo biludWiz($wizTab,$t);?>	
	<div class="fl of fxg" fxg="gtc:1fr 3fr|gtc:1fr 2fr:1100" fix="wp:0|hp:50">
		<div class="fl pd10 of fxg" fxg="gtr:auto auto 1fr" ><?
			$r=getRec('gnr_m_patients',$pat);
			if($r['r']){
				$photo=$r['photo'];
				$sex=$r['sex'];
				$title=$r['title'];
				$birth_date=$r['birth_date'];
				$birthCount=birthCount($birth_date);
                $emplo=$r['emplo'];
                $empTxt='';
                if($emplo){$empTxt='<span class="clr5 f1"> ('.k_employee.')</span>';}
				$bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
				$titles=modListToArray('czuwyi2kqx');
				$patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');
				$pName=$titles[$title].' : '.$r['f_name'].' '.$r['ft_name'].' '.$r['l_name'].$empTxt;?>

                <div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
                    <div class="fl pd5"><?=$patPhoto?></div>
                    <div class="fl pd10f">
                        <div class="lh20 f1 fs14 clr1111 Over" editPat="srv"><?=$pName?></div>
                        <div class="lh20 f1 fs12 clr1"><?=$bdTxt?></div>
                    </div>
                </div><?
            }?>
			<div class="fl w100 b_bord pd5v">				
				<div class=" lh30 f1 fs12 "><?=k_clinic.' : '.$cnlicName?></div><?
                if($doc){
                    list($dName,$dPhoto,$sex)=get_val('_users','name_'.$lg.',photo,sex',$doc);?>
                    <div class=" lh30 f1 fs12  "><?=k_doctor.' : '.$dName?></div><?
                }?>
            </div><?
			if(_set_9iaut3jze && $t==1){
                $offersAv=offersList($mood,$pat);
                if($offersAv){?>                
                    <div class="fl ofx so w100 mg10v ">
                        <div class="f1 fs14 clr6 clr6 w100 ">العروض المتاحة</div>
                        <div class="fl w100 ofx so cbg666 pd10 mg10v bord br5"><?=$offersAv?></div>
                    </div><?
                }
            }?>            
		</div>
		<div class="of cbg444 l_bord fxg " fxg="gtr:60px 1fr 65px"><?
			if($mood==1){echo cln_selSrvs($vis,$c,$doc,$pat,$t,$dts_id);}
			if($mood==2){echo lab_selSrvs($vis,$pat,$reqOrd);}
            if($mood==3){echo xry_selSrvs($vis,$c,$doc,$pat,$reqOrd,$t,$dts_id);}
			if($mood==4){echo selSrvs_den($vis,$c,$doc,$pat,$dts_id);}
            if($mood==5 || $mood==6){echo bty_selSrvs($vis,$c,$doc,$pat,$mood,$t,$dts_id);}
            if($mood==7){echo osc_selSrvs($vis,$c,$doc,$pat,$t,$dts_id);}?>
		</div>
	</div>
	<?
}?>