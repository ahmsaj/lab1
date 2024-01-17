<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['table'])){
	$table=$_POST['table'];
	echo columeList($table);
    echo '^';
    echo columeList($table.'','');
}?>