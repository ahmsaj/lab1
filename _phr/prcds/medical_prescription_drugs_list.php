<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['status'],$_POST['drug'],$_POST['presc'])){
	$status=pp($_POST['status'],'s');
	$drug=pp($_POST['drug']);
	$presc=pp($_POST['presc']);
	if($status=='view'){
		$obj=0;$cond='';
		if(isset($_POST['obj'])){
			$obj=pp($_POST['obj'],'s');
			if($obj){
				$cond="where code='$obj' || name like '%$obj%'";
			}
		}
		$list='';
		$sql="select * from gnr_m_medicines $cond limit 150";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			while($r=mysql_f($res)){
				//print_r($r);
				$name=$r['name'];
				$id=$r['id'];
				$list.='<div class="listOptbutt" onclick="presc_add_alter_process('.$presc.','.$id.')" >'.$name.'</div>';
			}
		}
		$click="presc_rep($presc,$drug)";
		if(!$obj){?>
			<div class="win_body">
			<div class="form_header f1 lh40 fs20">
				<input type="text" onkeyup="presc_add_alter_search(<?=$presc?>,<?=$drug?>)" placeholder="<?=k_search?>" class="ser_icons" style="margin-bottom:10px;" id="list_ser_option">    
			</div>
			<div class="form_body so" type="full" id="list_option">
				<div class="add_but w-auto" style="margin:0px; margin-bottom:10px" title="<?=k_add_rec?>" onclick="<?=$click?>"></div>
				<div id="drug_list"><?=$list?></div>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>
			</div>
			</div><?
		}else{
			echo $list;
		}
	}
	elseif($status=='process'){
		$r=getRec('gnr_x_prescription',$presc);
		if($r['r']){
			$origin_drug=0;
			if(isset($_POST['origin_drug'])){$origin_drug=pp($_POST['origin_drug']);}
			$quantity=0;
		
			echo presc_alter_view($drug,$origin_drug,$presc,'new');
		}
	}
}
?>