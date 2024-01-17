<? include("../../__sys/prcds/ajax_header.php");
$s=$now-($now%86400);
$e=$s+86400;
$a1=getTotalCO('lab_x_visits_services',"delv_date > $s and delv_date < $e");
$a2=getTotalCO('lab_x_visits_services',"status=8 and delv_date > $s and delv_date < $e");
echo $a1.','.$a2;?>