<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $err=0;
    $msg='';
    $r=getRec('lab_x_visits_services',$id);
    if($r['r']){
        $vis=$r['visit_id'];
        $offer=$r['offer'];        
        $pat=$r['patient'];
        if(getTotalCo('lab_x_visits_services',"visit_id='$vis'")>1){
            //حذف النتائج
            mysql_q("delete from lab_x_visits_services_results where serv_id='$id' and vis='$vis'");
            mysql_q("delete from lab_x_visits_services_results_x where x_ser_id='$id' ");            
            $cs_id=get_val_c('lab_x_visits_services_result_cs','id',$id,'serv_id');
            if($cs_id){
                mysql_q("delete from lab_x_visits_services_result_cs where id='$cs_id'");
                mysql_q("delete from lab_x_visits_services_result_cs_sub where p_id='$cs_id'");                
            }
            mysql_q("delete from lab_x_visits_services where id='$id'");
            // حذف روابط الدفع - تأمين جمعية
            mysql_q("delete from gnr_x_exemption_srv where mood=2 and vis='$vis' and x_srv='$id'");//إعفاء
            mysql_q("delete from gnr_x_charities_srv where mood=2 and vis='$vis' and x_srv='$id'");//جمعية
            mysql_q("delete from gnr_x_insurance_rec where mood=2 and visit='$vis' and service_x='$id'");//تأمين
            //العروض
            if($offer){
                mysql_q("UPDATE gnr_x_offers_items SET vis=0 , srv_x_id=0 , date='' , status=0 
                where patient='$pat' and vis='$vis' and srv_x_id='$id'");
            }
            labJson($vis);
            logOpr($id,3,'n5dmy993nf');
        }else{
            $err=1;
            $msg=k_only_ana_visit;
        }
    }else{
        $err=1;
        $msg=k_no_ana_num;
    }
    echo $err.'^'.$msg;
}?>