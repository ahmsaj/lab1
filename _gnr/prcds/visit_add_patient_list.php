<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['c'],$_POST['pars'])){
	$pars=pp($_POST['pars'],'s');
	$c=pp($_POST['c']);	
	$pats=get_vals('gnr_x_roles','pat'," clic='$c' and mood not in (2,3,7) and status!=4 ");
	$x_pats=explode(',',$pats);
	$max_list=100;
	$q='';
	$f1=$f2=$f3=$f4=$f5='';
	
	$d=pp($_POST['d']);
	$type=pp($_POST['t']);
	$p=explode('|',$pars);	
	foreach($p as $p2){
		$p3=explode(':',$p2);
		$par=$p3[0];
		$val=addslashes($p3[1]);
		if($par=='p1' && $val){$f1=intval($val);$q.=" and id ='".intval($val)."%' ";}
		if($par=='p2' && $val){$f2=$val;$q.=" and f_name like'%$val%' ";}
		if($par=='p3' && $val){$f3=$val;$q.=" and l_name like'%$val%' ";}
		if($par=='p4' && $val){$f4=$val;$q.=" and ft_name like'%$val%' ";}
		if($par=='p6' && $val){$f6=$val;$q.=" and mother_name like'%$val%' ";}
		if($par=='p5' && $val){
			$f5=$val;
			$val1=$val2=$val;
			if($val[0]==0){$val2=substr($val,1);}else{$val2='0'.$val;}			
			$q.=" and ( mobile like'$val1%' OR mobile like'$val2%' ) ";
		}
	}	
	$pat_data='f_name:'.$f2.',l_name:'.$f3.',mobile:'.$f5.',ft_name:'.$f4;
	if($q){$q=" where id!=0 $q ";}
	$res=mysql_q("select count(*)c from gnr_m_patients $q ");
	$r=mysql_f($res);
	$all=$r['c']; 
	if($q){
		$sql="select id,f_name,l_name,ft_name,mobile,mother_name,birth_date from gnr_m_patients $q order by f_name ASC , ft_name ASC , l_name ASC limit $max_list ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			if($all>$max_list){
				echo '<div class="lh30 fs16 clr1 f1">'.k_num_res.'  <ff>'.$rows.' / '.number_format($all).'</ff></div>';
			}else{echo '<div class="lh30 fs16 clr1 f1">'.k_num_res.'  <ff>'.$rows.'</ff></div>';}
		}	
		echo '<section  w="220" m=27" c_ord class="plistV">
		<div np class="fl fs14 f1s lh40 TC"  c_ord onclick="newPaVis(\''.$pat_data.'\')"> '.k_new_patient.'</div>';

		if($rows>0){		
			while($r=mysql_f($res)){
				$id=$r['id'];
				$f_name=$r['f_name'];
				$l_name=$r['l_name'];
				$ft_name=$r['ft_name'];
				$mother_name=$r['mother_name'];
				$birth_date=$r['birth_date'];
				$mobile=$r['mobile'];
				$birthCount=birthCount($birth_date);
				$bdTxt=' | <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1 ">'.$birthCount[1].'</span>';
				$pn='pn="'.$id.'" ';
				$x_msg='';
				if(in_array($id,$x_pats)){
					$pn='';
					$x_msg=k_visit_booked_for_pat;
				}
				echo '<div class="fl" c_ord '.$pn.' >			
					<div class="fs14x f1s of lh20 clr1111">'.hlight($f2,$f_name).' '.hlight($f4,$ft_name).' '.hlight($f3,$l_name).$bdTxt.'</div>';
					if($x_msg){
						echo '<div class="cb f1 clr5">'.$x_msg.'</div>';
					}else{
						echo '<div class="fl">( '.hlight($f6,$mother_name).' )<ff class="fs16"> '.hlight($f5,$mobile).'</ff>&nbsp;</div>';
					}
					echo '<div n><ff class="fr fs14 clr111">#'.hlight($f1,$id).'</ff></div>					
				</div>';
			}
		}else{
			echo '<section class="f1 fs16 clr5 lh40">'.k_no_results.' </section>';
		}	
		echo '</section>';
	}else{
		echo '<div class="f1 fs18 clr1 lh40">'.k_num_pats.'  <ff>'.number_format($all).'</ff></div>';
		echo '<div class="f1 fs14 clr5 lh30">'.k_srch_or_add_pat.'</div>';
		echo '<div class="bu2 bu_t4 fl" onclick="newPaVis(\''.$pat_data.'\')"> '.k_new_patient.'</div>';
	}
}
?>