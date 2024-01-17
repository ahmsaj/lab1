<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$mood=1;
	$id=pp($_POST['id']);
	if(getTotalCO('cln_x_visits'," id='$id' and doctor='$thisUser' ")==1){
		list($clinic,$dts_id)=get_val('cln_x_visits','clinic,dts_id',$id);
		if(mysql_q("UPDATE cln_x_visits set doctor=0 , d_check=0 , report='' , note='' ,  work=0 where id='$id'")){
			$q='';
			$selDocArr=explode(',',_set_anonjaukgo);
			$thisClinicCode=$clinicCode[1];
			if(!in_array($thisClinicCode,$selDocArr)){$q=" , doctor=0 ";}
			if(mysql_q("UPDATE gnr_x_roles set status=3 $q where vis='$id' and mood='$mood' ")){
				mysql_q("UPDATE dts_x_dates set status=2 where vis_link='$id' and type='$mood' ");
                $dts_id=get_val_con('dts_x_dates','id',"vis_link='$id' and type='$mood' ");
                datesTempUp($dts_id);
				mysql_q("UPDATE cln_x_visits_services set doc=0 where visit_id='$id'");
                mysql_q("UPDATE cln_x_visits_services set status=1 where visit_id='$id' and status=4");
                mysql_q("DELETE from cln_x_visits_services where visit_id='$id' and status IN(2,5)");
                mysql_q("UPDATE cln_x_visits_services set doc=0 where visit_id='$id'");
				mysql_q("DELETE from gnr_x_visits_timer where visit_id='$id' and mood='$mood'");
				//mysql_q("DELETE from cln_x_pro_analy_items where ana_id IN ( select id from cln_x_pro_analy where v_id='$id' )");
				mysql_q("DELETE from cln_x_pro_analy where v_id='$id' ");
				mysql_q("DELETE from xry_x_pro_radiography_items where xph_id IN ( select id from xry_x_pro_radiography where v_id='$id' )");
				mysql_q("DELETE from xry_x_pro_radiography where v_id='$id' ");
				mysql_q("DELETE from cln_x_pro_referral where v_id='$id' ");		
				//mysql_q("DELETE from cln_x_prv_complaints where visit='$id' ");
				//mysql_q("DELETE from cln_x_prv_diagnosis where visit='$id' ");				
				mysql_q("DELETE from cln_x_pro_x_operations where v_id='$id' ");
				echo 1;				
			}
		}
	}	
}?>