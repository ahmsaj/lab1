<?/***STR***/
function getSubStorge($subType){
	global $thisGrp;
	if(in_array($thisGrp,array('tcswrreks0','fcbj8r9oq'))){ return $subType;}
	if(in_array($thisGrp,array('7htoys03le'))){$part='cln';}
	if(in_array($thisGrp,array('nlh8spit9q'))){$part='xry';}
	return get_val_con('str_m_stores','id'," part='$part' and s_part='$subType' "); 
}
function str_sub_part($id,$opr,$filed,$val){
	global $lg;
	$part='';
	if($opr=='add' || $opr=='edit'){
		if($id){
			$port=get_val('str_m_stores','part',$id);		
		}else{
			$sql="select code from _modules where act=1 order by title_$lg ASC limit 1";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){$r=mysql_f($res);$port=$r['code'];}
		}
		$out='<div id="stoSpatr" f="'.$filed.'">'.get_str_str_set($port,$filed,$val).'</div>
		<span>'.k_not_necessary_check_warehouse_storage.'</span>';
	}else{
		$port=get_val('str_m_stores','part',$id);		
		if($port=='cln'){$out=get_val('gnr_m_clinics','name_'.$lg,$val);}	
		if($port=='xry'){$out=get_val('gnr_m_clinics','name_'.$lg,$val);}	
	}
	return $out;
}
function get_str_str_set($id,$filed,$val){
	 global $lg;
	 $out='<select name="'.$filed.'" ></select>';
	 if($id=='cln'){
	  $out=make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type=1",$filed,0,$val);
	 }
	 if($id=='xry'){
	  $out=make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type=3",$filed,0,$val);
	 } 
	 return $out;

}
function str_resSpart($id){
	list($type,$s_part)=get_val('str_m_stores','type,s_part',$id);
	if($type==1){mysql_q(" UPDATE str_m_stores set s_part='' , part='' where id='$id' ");}
	if($type==2){mysql_q(" UPDATE str_m_stores set s_part='' where id='$id' ");}
}
function packing($id,$opr,$filed,$val){	
	$out='';
	$pacTotal=0;
	if($opr=='add' || $opr=='edit'){
		$text=strPacText($val);		
		$out.='<div class="f1 fs16 clr1 lh30 Over" onclick="editPac()">'.k_edit.'</div>
		<input type="hidden" name="'.$filed.'" id="ItemePakeg" value="'.$val.'" /><div id="dataPakeg">'.$text.'</div>';		
	}
	if($opr=='list' || $opr=='view'){
		$out=strPacText($val);
	}
	return $out;
}
function strPacText($val){
	global $lg;
	$text='';
	if($val){
		$d=explode('-',$val);$pac_u1=$d[0];$pac_n1=$d[1];$pac_u2=$d[2];$pac_n2=$d[3];
		if($pac_n1){
			$text.='<div class="f1 fs12 lh20">'.k_main_category.' : '.get_val('str_m_items_units','name_'.$lg,$pac_u1).' <ff class="ff fs16">( '.$pac_n1.' )</ff></div>';
		}
		$text.='<div  class="f1 fs12 lh20">'.k_subcategory.' : '.get_val('str_m_items_units','name_'.$lg,$pac_u2).' <ff class="ff fs16">( '.$pac_n2.' )</ff></div>';			
		if($pac_n1==0){$pacTotal=$pac_n2;}else{$pacTotal=$pac_n1*$pac_n2;}
		if($pac_n1){
		$text.='<div  class="f1 fs12 lh20">'.k_total_units_coating.' <ff class="ff fs16">( '.$pacTotal.' )</ff></div>';
		}		
	}
	return $text;
}
function strAddItems($id){
	$out='';	
	$status=get_val('str_x_bill','status',$id);
	if($status==0){
		$total=getTotalCO('str_x_bill_items',"ship_id='$id'");
		$out.='<div class="bu2  bu_t1 fl" onclick="shipItems('.$id.')">'.k_editing_invoice_items.' <ff> ( '.$total.' )</ff></div>';
		if($total){
		$out.='<div class="bu2  bu_t3 fl" onclick="shipItemsEnd('.$id.')">'.k_receipt_invoice.' </div>';
		}
	}else{
		$out.='<div class="bu2  bu_t1 fl" onclick="shipItemsInfo('.$id.')">'.k_show_items_invoice.'</div>';	
	}	
	return $out;
}
function strTransItems($id){
	$out='';	
	$status=get_val('str_x_transfers','status',$id);
	$total=getTotalCO('str_x_transfers_items'," trans_id='$id' group by item_id ");
	if($status==0){		
		$out.='<div class="bu2  bu_t1 fl" onclick="transItems('.$id.')">'.k_edit_items.'</div>';
		if($total){
			$out.='<div class="bu2 bu_t4 fl" onclick="transItemsEnd('.$id.',1)">'.k_send.'</div>';
		}
	}else{
		$out.='<div class="bu2  bu_t1 fl" onclick="transItemsInfo('.$id.')">'.k_show_items.'</div>';	
	}	
	return $out;
}
function strTransItems2($id){
	$out='';	
	$status=get_val('str_x_transfers','status',$id);
	if($status>0){
		$total=getTotalCO('str_x_transfers_items'," trans_id='$id'  group by item_id");
		$out.='<div class="bu2  bu_t1 fl" onclick="transItemsInfo('.$id.')">'.k_show_items.' </div>';	
		if($status==1){$out.='<div class="bu2 bu_t3 fl" onclick="transItemsEnd('.$id.',2)">'.k_receipt.'</div>';}
	}
	return $out;
}
function drowTree($ser='',$type,$f=0){
	global $lg,$userStore;
	$startText='tree^';
	if($f){$startText='';}
	$out=$startText;
	if($ser){
		$iId=get_val_con('str_m_items','id'," barcode='$ser' and barcode!='' ");
		if($iId){		
			$out="bar^".$iId;
		}else{
			$out.='<div class="lh30">&nbsp;</div><div class="shItTreeIN so">';
			if($type==2 || $type==3){
				$sql="select z.name , z.id , balance from str_m_items z, str_x_items_balance x where z.id=x.iteme and store='$userStore' and  z.name like'%$ser%' and  z.act=1 order by z.name ASC";
			}else{
				$sql="select name , id from str_m_items where name like'%$ser%' and  act=1 order by name ASC";			
			}
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$out.='<div class="f1 fs16 clr51 lh30">عدد النتائج <ff> ( '.$rows.' )</ff></div>';
				while($r=mysql_f($res)){
					$id=$r['id'];				
					$name=$r['name'];					
					$consText='';
					$balance=1;
					if($type==2 || $type==3){
						$balance=$r['balance'];
						$itBalTxt='<span>&nbsp;'.number_format($balance).' </span>&nbsp;|&nbsp;';
					}
					if($type==3){$consText=' bal="'.$balance.'" it="'.$name.'"';}	
					if($balance){
						$out.='<div i class="f1 fs14" no="'.$id.'" '.$consText.'>'.splitNo($itBalTxt.$name).'</div>';
					}
				}
			}else{$out.='<div class="f1 fs16 clr5 lh30">'.k_no_results.'</div>';}
			$out.='</div>';
		}
	}else{
		$out.='<div class="lh30"><div class="treeButt" sw="off">+</div></div><div class="shItTreeIN so">';
		$subCatsArr=array();
		$sql="select * from str_m_items_cats_sub where act=1";
		
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;
			while($r=mysql_f($res)){
				$subCatsArr[$i]['id']=$r['id'];
				$subCatsArr[$i]['cat']=$r['cat'];
				$subCatsArr[$i]['name']=$r['name_'.$lg];
				$i++;
			}
		}
		/***************/
		$ItemesArr=array();
		if($type==1){
			$sql="Select * from str_m_items where act=1 order by name ASC";
		}else{
			$sql="select z.name , z.id , x.balance , z.scat from str_m_items z, str_x_items_balance x where z.id=x.iteme and store='$userStore' and  z.act=1 order by name ASC";
		}
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;
			while($r=mysql_f($res)){
				$ItemesArr[$i]['id']=$r['id'];
				$ItemesArr[$i]['scat']=$r['scat'];
				$ItemesArr[$i]['name']=$r['name'];
				if($type==1){
					$ItemesArr[$i]['bal']=1;
				}else{
					$ItemesArr[$i]['bal']=$r['balance'];
				}
				$i++;
			}
		}
		/***************/
		$sql="Select * from str_m_items_cats where act=1 order by name_$lg ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$name=$r['name_'.$lg];
				$strSub='';
				$totSub=0;
				foreach($subCatsArr as $sub){
					if($sub['cat']==$id){
						$totSub++;
						$strItems='';
						$totItem=0;
						foreach($ItemesArr as $item){
							$itBal=1;
							if($type==2 || $type==3){$itBal=$item['bal'];}
							if($item['scat']==$sub['id'] && $itBal){
								$consText='';
								if($type==2 || $type==3){
									$itBalTxt='<span>&nbsp;'.number_format($itBal).' </span>&nbsp;|&nbsp;';
								}
								if($type==3){
									$consText=' bal="'.$itBal.'" it="'.$item['name'].'"';
								}
								$totItem++;
								$strItems.='<div i class="f1 fs14" no="'.$item['id'].'" '.$consText.'>'.splitNo($itBalTxt.$item['name']).'</div>';
							}
						}						
						if($strItems){
							$strSub.='<div s class="f1 fs14" sw="off" no="'.$sub['id'].'" ><no>'.$totItem.' | </no> '.splitNo($sub['name']).'</div>';
							$strSub.='<div class="hide" blc="cs'.$sub['id'].'">'.$strItems.'</div>';
						}
					}
				}			
				if($strSub){
					$out.='<div m class="f1 fs14" sw="off" no="'.$id.'"><no>'.$totSub.' | </no>'.splitNo($name).' </div>';
					$out.='<div class="hide" blc="c'.$id.'">'.$strSub.'</div>';
				}
			}
		}
		$out.='</div>'; 
	}
	return $out;
}
function getItemBal($id,$storge=0){
	$b=0;
	if($storge){
		$b=get_val_con('str_x_items_balance','balance',"store='$storge' and iteme='$id' ");
		if(!$b){$b=0;}
		
	}else{	
		$b=get_sum('str_x_items_balance','balance'," iteme='$id' ");
		if(!$b){$b=0;}
	}
	return $b;
}
function getItemCons($id,$s=0){
	if($s){$q=" and item_id='$id' ";}
	return get_sum('str_x_consumption_items','quantity'," strorage='$s' $q ");
}
function getItemsUnit(){
	global $lg;
	$out=array();
	$sql="select * from str_m_items_units ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$out[$id]=$name;
		}
	}
	return $out;	
}
function priceAvrage($p1,$q1,$p2,$q2){return(($p1*$q1)+($p2*$q2))/($q1+$q2);}
function fixBalansPac($q,$pac,$units,$iUnit){
	$out='';
	if($pac){
		$p=explode('-',$pac);
		if($p[0]>0){
			$u1=$p[1]*$p[3];
			if($q>$u1){
				$out.='<span class="ff B fs14">'.intval($q/$u1).'</span> '.$units[$p[0]];
				$q=$q%$u1;
			}
		}
		if($q>$p[3]){
			if($out){$out.=' / ';}
			$out.='<span class="ff B fs14">'.intval($q/$p[3]).'</span> '.$units[$p[2]];
			$q=$q%$p[3];
		}
		if($out){
			if($q){$out.=' / <span class="ff B fs14">'.$q.'</span> '.$units[$iUnit];}
		}
	}
	return $out;
}
function setNewBalShipIt($id){
	$mq=get_val('str_x_bill_items','quantity',$id);
	$co=get_sum('str_x_consumption_items','quantity'," sh_it_id='$id' and status=0 ");
	$bal=$mq-$co;
	if($bal==0){
		$q2=" , status=2 ";
		mysql_q("UPDATE str_x_transfers_items SET status=3 where sh_it_id='$id' ");
		mysql_q("UPDATE str_x_consumption_items SET status=1 where sh_it_id='$id' ");
	}	
	mysql_q("UPDATE str_x_bill_items SET qu_balans='$bal' $q2 where id='$id' ");
}
function items_bal($id){
	$out='<div class="bu2 bu_t1 fr" onclick="iteme_bal_det('.$id.',2)">'.k_the_movement.'</div>';	
	$r=getItemBal($id,0);
	if($r>0){$out.='<div class="bu2 bu_t3 fr" onclick="iteme_bal_det('.$id.',1)"><ff>'.number_format($r).'</ff></div>';}else{
		$out.='<div class="bu2 bu_t2 fr"><ff>0</ff></div>';	
	}
	
	return $out;
}
function fixBal_trns($t_id){	
	$items=get_vals('str_x_transfers_items','item_id'," trans_id='$t_id' ");
	$items_arr=explode(',',$items);
	foreach($items_arr as $t){
		fixBalIteme($t);
	}
}
function fixBalIteme($it,$store=0){
	global $now,$userStore;
	if($store==0){$store=$userStore;}
	if($store){
		$in =get_sum('str_x_transfers_items','quantity'," item_id='$it' and str_rec='$store' and status=2");
		$out=get_sum('str_x_transfers_items','quantity'," item_id='$it' and str_send='$store' and status IN(1,2) ");
		$cons=get_sum('str_x_consumption_items','quantity'," item_id='$it' and strorage='$store' and status=0 ");
		$bal=$in-$out-$cons;
		if($bal==0){mysql_q("DELETE from  str_x_items_balance where iteme='$it' and store='$store' ");}
		if(getTotalCO('str_x_items_balance'," iteme='$it' and store='$store' ")){
			mysql_q("UPDATE str_x_items_balance SET balance='$bal' , date='$now' where iteme='$it' and store='$store' ");
		}else{	
			mysql_q("INSERT INTO str_x_items_balance (store,iteme,balance,date)values('$store','$it','$bal', '$now' )");
		}
	}
}
?>