<? include("../../__sys/prcds/ajax_header.php");
$mood=get_val('gnr_m_clinics','type',$userSubType);
$stopAlert='';
$limitPatData='';
echo clinicOpr_icons($mood);
echo '^';
echo clinicOpr_docStatus($mood);
echo '^';
echo clinicOpr_waiting($mood);
echo '^';
if(chProUsed('dts')){echo clinicOpr_DTS($mood);}
echo '^';
echo $limitPatData;
echo $stopAlert;
echo clinicOpr_alerts($mood);?>