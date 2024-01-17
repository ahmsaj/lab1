<? include("../../__sys/prcds/ajax_header.php");
$x=getTotalCO('lab_x_visits_services'," status IN(9)");

$a1=getTotalCO('lab_x_visits_samlpes'," status IN(0,1,2)");
//$a2=getTotalCO('lab_x_visits_samlpes'," status IN(3)");

$b1=getTotalCO('lab_x_visits_services'," status IN(0,5,6)");
//$b2=getTotalCO('lab_x_visits_services'," status IN(7,8,9,10)");

//echo $x.','.$a1.','.$a2.','.$b1.','.$b2;
echo $x.','.$a1.','.$b1;
?>