<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	
	if($t==1){?>
		<div class="win_body">
		<div class="form_header f1 fs18 lh40 clr1 "><?=k_sel_warehouse_trans_to?></div>
			<div class="form_body so" type=""><?			
				$sql="select * from str_m_stores where id!= '$userSubType' and act =1  order by id ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$id=$r['id'];
						$name=$r['name_'.$lg];
						echo '<div class="bu bu_t1 w-auto" onclick="newTrans(2,'.$id.')">'.$name.'</div>';
					}
				}else{
					echo '<div class="f1 fs16 clr5 lh40">'.k_no_defined_stores.'</div>';
				}?>

			</div>
			 <div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div> 

			</div>
		</div><? 
	}else{		
		$sql="INSERT INTO str_x_transfers (str_send,user_send,str_rec,date)values('$userSubType','$thisUser','$id','$now')";
		if(mysql_q($sql)){echo last_id();}		
	}
}?>