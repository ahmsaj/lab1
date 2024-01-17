<?/***LAB***/
$sex_types=array(k_no_sel,k_male,k_female);
$age_types=array(k_year,k_month,k_day);
$anT2_types=array(k_greater_than,k_less_than,k_greater_equals,k_less_equals,k_equ,k_not_equals);
//$anT2_typesCode=array('&#0062;','&#0060;','&#8805;','&#8804;','&#0061;','&#8800;');
$anT2_typesCode=array('More than','Up to','More than','Less than','&#0061;','&#8800;');
$anT3_types=array(k_negative,k_positive);
$anT3_typesC=array('Negative','Positive');
$anT5_types=array(k_no_sel,k_not_norm,k_norm);
$anT5_types_id=array('0','x','n');
$anT5_types_col=array('',$clr5,$clr6);
$lab_vis_s=array(k_not_complete,k_new,k_received,k_canceled,k_samples_taken,k_test_completed);
$lab_vis_sClr=array('#cccccc',$clr1,$clr11,$clr5,'#9b2394',$clr6);
$aQtypes=array(
	array('1',k_equation,'nti1'),
	array('2',k_link_form_percentage,'nti2'),
	array('3',k_link_plot_chart,'nti3'),
);
$lab_res_CS_level=array('','Mild','Moderate','Severe');
$lab_res_CS_types=array('',k_sample_fine,k_sample_contaminated,k_detailed_result);
$lab_res_fmf_types=array('Negative','Positive');
$lab_res_fmf_Stypes=array('','Homozygous','Heterozygous');
$Q_sin=array('','+','x','-','÷',')','(','√');
$Q_sinR=array('','+','*','-','/',')','(','sqrt');
$CHL='0ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$lrStatus=array('','تم ترقيم العبوة
',k_sample_received_since,k_entered_lab_since,k_report_partially_entered,'',k_canceled_sample);
$anStatus=array(k_num_tube_entered,k_complete,k_request_service_for_payment,k_canceled,k_request_cancellation,k_Results_not_entered,k_incomplete_report_entered,k_complete_report,k_report_accepted,k_report_rejected,k_corrected);
$anStatsTxt_Col=array('','','#fff498','','#ffbbbb','');
$anStatsTxt=array(k_num_tube_entered,k_tube_information_taken,k_sample_done,k_request_service_for_payment,k_cncled,k_request_cancellation,k_sample_selected,k_incomplete_rep,k_full_rep_entered,k_report_accepted,k_report_rejected,k_dlivrd);

$anStatsTxt2=array(k_num_tube_entered,k_tube_information_taken,k_sample_done);
$anStatus_col=array('#000','#090','#e17d12','#ff0c0c','#ff0c0c','#9b2394','#1269e1','#0c0','#4cba3a','#ff0c0c','#1269e1');
$DV_types=array('',k_normal_rate,k_general_note);
$lab_out_status=array(k_sent,k_report_enterd);
$an_requst=array(k_new,k_request_sent,k_request_received,k_resultd_entered,k_results_reviewed);
$an_requst_col=array('','#f8f293',$clr666,'#93f8d3','#c9f5b4');
$an_requst_in=array(k_new,k_request_received,k_resultd_entered,k_results_reviewed);
$an_requst_in_col=array('#999','#65bced','#8fd14f','#7b9660');

$samp_opr_txt=array(k_in_wait,k_reqrid_serv,k_wrkng,k_skpd,k_finished);
$lab_srv_status=array(k_the_sample_not,
'',
k_awt_payament,
k_was_canceled,
k_request_cancellation,
k_analysis_linked,'');
?>