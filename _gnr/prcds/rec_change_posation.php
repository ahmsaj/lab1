<? include("../../__sys/prcds/ajax_header.php");
if(_set_tauv8g02){
	if(isset($_POST['p'])){
		$p_id=pp($_POST['p']);
		if(!$p_id){
            $sql="select * from gnr_m_resp_points ";
            $res=mysql_q($sql);
            echo '<div class=" ofx so w100 h100 " >';
            echo '<div class=" mg10f" fix="w:250">';
            while($r=mysql_f($res)){
                $id=$r['id'];
                $name=$r['name_'.$lg];
                $clr='icc33';
                if($id==$_SESSION['po_id']){
                    $clr='icc22';                    
                }
                echo '<div class="ic40x mg10v '.$clr.' ic40_loc ic40Txt" recPos="'.$id.'">'.$name.'</div>';
            }
            echo '</div>';
		}else{
            list($id,$clinics,$name)=get_val('gnr_m_resp_points','id,clinics,name_'.$lg,$p_id);			
			$_SESSION['po_id']=$id;
			$_SESSION['po_clns']=$clinics;
            $_SESSION['pos_name']=$name;
		}
	}
}?>