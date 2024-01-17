<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p'] , $_POST['c'] , $_POST['m'])){
	$mood=pp($_POST['m']);
	$pat=pp($_POST['p']);
	$cln=pp($_POST['c']);
	$doc=pp($_POST['d']);
	$vis=pp($_POST['vis']);	
	$fast=pp($_POST['fast']);
    $req=pp($_POST['req']);
	$vis_id=$vis;
	list($pat,$emplo)=get_val('gnr_m_patients','id,emplo',$pat);    
    if($vis_id){        
        if($mood!=2){
            list($cln,$pat,$doc2)=get_val($visXTables[$mood],'clinic,patient,doctor',$vis_id);
            if($mood!=4){$doc=$doc2;}
        }else{
            $cln=get_val_c('gnr_m_clinics','id',2,'type');
            $pat=get_val($visXTables[$mood],'patient',$vis_id);
        }
    }
    $cln_mood=2;
    if($mood!=2){$cln_mood=get_val('gnr_m_clinics','type',$cln);}
	if(($pat && $cln_mood==$mood)|| $mood==4){		
		if($doc && $mood!=4){		
			$doc_clin=get_val('_users','subgrp',$doc);            
            $m_clinic=getMClinic($doc_clin);
			$docArr=explode(',',$m_clinic);
			//if(!in_array($cln,$docArr) && $mood!=3){exit;}
		}
		if($mood==1){echo $vis_id=cln_selSrvs_save($vis_id,$pat,$emplo,$cln,$doc,$fast);}
		if($mood==2){echo $vis_id=lab_selSrvs_save($vis_id,$pat,$emplo,$req);}
        if($mood==3){echo $vis_id=xry_selSrvs_save($vis_id,$pat,$emplo,$cln,$doc,$fast,$req);}
        if($mood==4){echo $vis_id=den_selSrvs_save($vis_id,$pat,$doc);}
        if($mood==5 || $mood==6){echo $vis_id=bty_selSrvs_save($vis_id,$pat,$emplo,$cln,$doc,$mood);}
        if($mood==7){echo $vis_id=osc_selSrvs_save($vis_id,$pat,$emplo,$cln,$doc,$fast);}        
		if($vis_id){            
            addTempOpr($pat,4,$mood,$cln,$vis_id);
        }
		
	}else{echo '0';}
}?>