<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
    <div class="pd10f denOprList" actButt="act"><?
        $sql="select * from den_m_services where cat='$id' and act=1 order by ord ASC";
        $res=mysql_q($sql);
        while($r=mysql_f($res)){
            $id=$r['id'];
            $name=$r['name_'.$lg];
            echo '<div no="'.$id.'" txt="'.$name.'">'.splitNo($name).'</div>';
        }?>
    </div><?
}?>