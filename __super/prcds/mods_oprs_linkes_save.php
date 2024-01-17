<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mod'])){
	$id=pp($_POST['id']);
    $mod=pp($_POST['mod'],'s');
    $table=pp($_POST['link_table'],'s');
    $col=pp($_POST['link_col'],'s');
    $val=pp($_POST['link_val'],'s');
    if(getTotalCo('_modules',"code='$mod'") && $table && $col){
        if($id){
            mysql_q("UPDATE _modules_links SET `mod_code`='$mod',`table`='$table',`colume`='$col',`val`='$val' where id='$id' ");
        }else{
            mysql_q("INSERT INTO _modules_links (`mod_code`,`table`,`colume`,`val`) values ('$mod','$table','$col','$val')");	
        }
        moduleGen(1,$mod);
        echo 1;
    }
}?>