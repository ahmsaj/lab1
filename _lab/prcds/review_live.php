<? include("../../__sys/prcds/ajax_header.php");
$x=getTotalCO('lab_x_visits_services'," status IN(9)");
$b1=getTotalCO('lab_x_visits_services'," status IN(0,5,6)");
$b2=getTotalCO('lab_x_visits_services'," status IN(6,7,10)");
echo $x.','.$b1.','.$b2.'^';

?>