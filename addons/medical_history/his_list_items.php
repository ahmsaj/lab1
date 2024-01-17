<? include("../header.php");
if(isset($_POST['vis'],$_POST['r'],$_POST['sr'],$_POST['cat'])){
	$id=pp($_POST['vis']);	
	$r=pp($_POST['r']);
	$sr=pp($_POST['sr'],'s');
	$cat=pp($_POST['cat']);
	$addButt='';
	if(modPer('sd53d8g39x',1)){
		$addButt='<div class="fr ic40x ic40_add icc22 br0" addHisNIt title="إضافة عنصر جديد"></div>';
	}
	if($cat==0 && $sr==''){
		$color=get_val_con('cln_m_addons','color'," code='dd1q42qqvk' ");
		$sql="select id,name_$lg from cln_m_medical_his_cats order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		echo '<div>
			<div class="fl pd10  f1 fs14">'.k_cats.' : <ff>'.$rows.'</ff></div>'.$addButt.'
		</div>^';		
		if($rows){
			while($r=mysql_f($res)){
				$id=$r['id'];				
				$name=$r['name_'.$lg];								
				echo '<section class="bu bu_t4" hisCat="'.$id.'" style="background-color:'.$color.';" >'.$name.'</section>';
			}
		}
	}else{
		$p=25;
		$sp=$r*$p;
		$q='';
		if($cat){$q=" and cat='$cat'";}
		if($sr){$q.=" and name_$lg LIKE'%$sr%'";}		
		$all=getTotalCO('cln_m_medical_his',"act=1 $q");
		$sql="select * from cln_m_medical_his where act=1 $q order by name_$lg ASC limit $sp,$p";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$recTotTxt=$rows;
		if($r>0){$rows=min(($r+1)*$p,$all);}
		if($all>=$rows){$recTotTxt=number_format($rows).'/'.number_format($all);}
		echo '<div>
			<div class="fl pd10  f1 fs14">'.k_recs_num.' : <ff>'.$recTotTxt.'</ff></div>'.$addButt.'
		</div>^';
		if($r!=0){echo '<div class="fl w100"></div>';}
		if($rows){
			while($r=mysql_f($res)){
				$id=$r['id'];				
				$name=$r['name_'.$lg];
				$cName='';
				if($cat==0 && $sr){					
					$cName='<div class="f1 fs14 pd10 clr66 lh30">'.get_val_arr('cln_m_medical_his_cats','name_'.$lg,$r['cat'],'c').'</div>';
				}
				echo '<div ih="'.$id.'" set="0" >'.$cName.'			
					<div class="mg10 f1 fs14 " tit >'.hlight($sr,$name).'</div>
				</div>';
			}
			if($rows<$all){
				echo '<section class="ic40 icc4 ic40_det ic40Txt" loadMore>'.k_show_more.'</section>';
			}
		}
	}
}?>