<? include("../../__sys/prcds/ajax_header.php");
include("../__sys/mods/protected.php");
if(isset($_GET['type'] , $_GET['id'])){
	$type=pp($_GET['type'],'s');
	$id=pp($_GET['id']);
	$id2=pp($_GET['id2']);
	$thisCode=$type.'-'.$id;
	$pageSize='print_page4';
	if($type=='Insur'){$titlee=k_oper_report;}
	$style_file=styleFiles('P');?>
	<head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>
	<body dir="<?=$l_dir?>">    
    <div class="<?=$pageSize?>">
		<? if($type=='Insur'){
			if(_set_14jk4yqz3w){
				$image=getImages(_set_14jk4yqz3w);
				$file=$image[0]['file'];
				$folder=$image[0]['folder'];
				list($w,$h)=getimagesize("sData/".$folder.$file);
				$fullfile=$m_path.'upi/'.$folder.$file;
				$logo= '<img width="100%" src="'.$fullfile.'"/>';
			}
			echo '<div class="print_pageIn">';
			echo '<div class=" fr w100">'.$logo.'</div>';
			
			$custumPrices=array();
			$sql="select * from gnr_m_insurance_prices where type='$id' and insur='$id2' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			while($r=mysql_f($res)){
				$service=$r['service'];
				$price=$r['price'];
				$custumPrices[$service]=$price;
			}
			if($id==1){				
				$sql="select * from cln_m_services where act=1 order by clinic ASC , name_$lg ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					echo '<div class="f1 fs16 lh40">'.k_clin_srvcs_to_insure_comps.' ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$id2).' )</div>';
					echo '<div class="f1 fs16 lh40">'.k_items_num.' : <ff> ( '.$rows.' )</ff></div>';
					echo '<table width="100%" border="0" class="grad_print" cellspacing="0" cellpadding="4">
					<tr><th>#</th><th>'.k_tclinic.'</th><th>'.k_service.'</th><th>'.k_price.'</th></tr>';
					$i=1;
					while($r=mysql_f($res)){
						
						$s_id=$r['id'];
						$clinic=$r['clinic'];
						$name=$r['name_'.$lg];
						$hos_part=$r['hos_part'];
						$doc_part=$r['doc_part'];						
						$price=$hos_part+$doc_part;
						$f_price=$price/((100-_set_1foqr1nql3)/100);
						$f_price=roundNo($f_price,500);
						if($custumPrices[$s_id]){
							$f_price=$custumPrices[$s_id];						
						}
						
						echo '
						<tr>
						<td><ff>'.$i.'</ff></td>
						<td class="f1 ">'.get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c').'</td>
						<td class="f1 ">'.$name.$star.'</td>
						<td><ff>'.number_format($f_price).'</ff></td>
						</tr>';
						$i++;
					}
					echo '</table>';
				}
				
			}
			if($id==2){
				$sql="select * from lab_m_services where act=1 order by cat ASC , short_name ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					echo '<div class="f1 fs16 lh40">'.k_tests_prices_to_insure_comps.' ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$id2).' )</div>';
					echo '<div class="f1 fs16 lh40">'.k_items_num.': <ff> ( '.$rows.' )</ff></div>';
					echo '<table width="100%" border="0" class="grad_print" cellspacing="0" cellpadding="4">
					<tr><th>#</th><th>'.k_cat.'</th><th>'.k_service.'</th><th>'.k_price.'</th></tr>';
					$i=1;
					while($r=mysql_f($res)){
						$star='';
						$s_id=$r['id'];
						$cat=$r['cat'];
						$name=$r['short_name'];
						$unit=$r['unit'];						
						$price=$unit*_set_x6kmh3k9mh;
						$f_price=$price+($price*_set_1foqr1nql3/100);
						if($custumPrices[$s_id]){
							$f_price=$custumPrices[$s_id];
							$star='*';
						}
						echo '
						<tr>
						<td><ff>'.$i.'</ff></td>
						<td class="f1 ">'.get_val_arr('lab_m_services_cats','name_'.$lg,$cat,'cat').'</td>
						<td><ff>'.$name.$star.'</ff></td>
						<td><ff>'.number_format($f_price).'</ff></td>
						</tr>';
						$i++;
					}
					echo '</table>';
				}
				
			}
            if($id==3){				
				$sql="select m.name_$lg as srv , x.price as price , clinic from xry_m_services m  , gnr_m_insurance_prices x 
                where m.act=1 
                and x.insur=$id
                and x.type=3
                and x.service=m.id
                order by clinic ASC , name_$lg ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					echo '<div class="f1 fs16 lh40">'.k_clin_srvcs_to_insure_comps.' ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$id2).' )</div>';
					echo '<div class="f1 fs16 lh40">'.k_items_num.' : <ff> ( '.$rows.' )</ff></div>';
					echo '<table width="100%" border="0" class="grad_print" cellspacing="0" cellpadding="4">
					<tr><th>#</th><th>'.k_tclinic.'</th><th>'.k_service.'</th><th>'.k_price.'</th></tr>';
					$i=1;
                    $pers='';
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$clinic=$r['clinic'];
						$name=$r['srv'];
                        $price=$r['price'];					
						
						echo '
						<tr>
						<td><ff>'.$i.'</ff></td>
						<td class="f1 ">'.get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c').'</td>
						<td class="f1 ">'.$name.$star.'</td>
						<td><ff>'.number_format($price).'</ff></td>
						</tr>';
						$i++;
					}
					echo '</table>';
				}			
			}
			if($id==4){				
				$sql="select * from den_m_services where act=1 order by cat ASC , name_$lg ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					echo '<div class="f1 fs16 lh40">'.k_dent_prices_to_insur_comps.' ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$id2).' )</div>';
					echo '<div class="f1 fs16 lh40">'.k_items_num.': <ff> ( '.$rows.' )</ff></div>';
					echo '<table width="100%" border="0" class="grad_print" cellspacing="0" cellpadding="4">
					<tr><th>#</th><th>'.k_cat.'</th><th>'.k_service.'</th><th>'.k_price.'</th></tr>';
					$i=1;
					while($r=mysql_f($res)){
						$star='';
						$s_id=$r['id'];
						$cat=$r['cat'];
						$name=$r['name_'.$lg];
						$hos_part=$r['hos_part'];
						$doc_part=$r['doc_part'];						
						$price=$hos_part+$doc_part;
						$f_price=$price+($price*_set_1foqr1nql3/100);
						if($custumPrices[$s_id]){
							$f_price=$custumPrices[$s_id];
							$star='*';
						}						
						echo '
						<tr>
						<td><ff>'.$i.'</ff></td>
						<td class="f1 ">'.get_val_arr('den_m_services_cat','name_'.$lg,$cat,'serCat').'</td>
						<td class="f1 ">'.$name.$star.'</td>
						<td><ff>'.number_format($f_price).'</ff></td>
						</tr>';
						$i++;
					}
					echo '</table>';
				}
				
			}			
			echo '</div>';
		
		}
		?>
	</div>
    </body><?
}?>
<script>window.print();setTimeout(function(){window.close();},500);</script>