<? session_start();
$PBL='../../';
include($PBL."__sys/dbc.php");
include($PBL."__sys/f_funs.php");
include($PBL."__sys/funs.php");
include($PBL."__sys/funs_co.php");
include($PBL.'__main/funs.php');
include($PBL."__sys/define.php");

$inc_file1=$PBL.'_lab/funs.php';
$inc_file2=$PBL.'_lab/define.php';
if(file_exists($inc_file1)){include($inc_file1);}
if(file_exists($inc_file2)){include($inc_file2);}
$pat=pp($_GET['pat']);
$vis=pp($_GET['vis']);
$r=getRecCon('lab_x_visits',"id='$vis' and patient='$pat' ");
if($r['r']){
    echo $Vbal=get_visBal($vis);
}else{
    echo 'x';
}

?>


