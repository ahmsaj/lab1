<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['c'],$_POST['pars'])){
	$titles=modListToArray('czuwyi2kqx');
	$pars=pp($_POST['pars'],'s');
    $addPar=pp($_POST['addPar'],'s');
    
	$c=pp($_POST['c']);	
    $x_pats=[];
    $m=pp($_POST['m']);//form Datas Mood =2 , confirm Date 3
	if($m==1){
       $pats=get_vals('gnr_x_roles','pat'," clic='$c' and mood not in (2,3,7) and status!=4 ");
	   $x_pats=explode(',',$pats);
    }elseif($m==2){
        list($dtsDate,$p_type)=get_val('dts_x_dates','d_start,p_type',$addPar);
        $s_day=$dtsDate-($dtsDate%86400);
        $e_day=$s_day+86400;
        $pats=get_vals('dts_x_dates','patient'," clinic='$c' and status!=5 and d_start>=$s_day and d_start<'$e_day' ");        
        $x_pats=explode(',',$pats);
    }
	$max_list=100;
	$q='';
    $q2='';
	$f1=$f2=$f3=$f4=$f5='';
	
	$d=pp($_POST['d']);
	$type=pp($_POST['t']);
	$p=explode('|',$pars);	
	foreach($p as $p2){
		$p3=explode(':',$p2);
		$par=$p3[0];
		$val=addslashes($p3[1]);
		if($par=='p1' && $val){$f1=intval($val);$q.=" and id ='".intval($val)."%' ";$q2.=" and id ='".intval($val)."%' ";}
		if($par=='p2' && $val){$f2=$val;$q.=" and f_name like'%$val%' ";$q2.=" and f_name like'%$val%' ";}
		if($par=='p3' && $val){$f3=$val;$q.=" and l_name like'%$val%' ";$q2.=" and l_name like'%$val%' ";}
		if($par=='p4' && $val){$f4=$val;$q.=" and ft_name like'%$val%' ";}
		if($par=='p6' && $val){$f6=$val;$q.=" and mother_name like'%$val%' ";}
		if($par=='p5' && $val){
			$f5=$val;
			$val1=$val2=$val;
			if($val[0]==0){$val2=substr($val,1);}else{$val2='0'.$val;}			
			$q.=" and ( mobile like'$val1%' OR mobile like'$val2%' ) ";
            $q2.=" and ( mobile like'$val1%' OR mobile like'$val2%' ) ";
		}
	}	
	$pat_data='f_name:'.$f2.',l_name:'.$f3.',mobile:'.$f5.',ft_name:'.$f4.',mother_name:'.$f6;
    if($m==3){
        $dts_id=intval($addPar);
        $tempPat=get_val('dts_x_dates','patient',$dts_id);
        $dr=getRec('dts_x_patients',$tempPat);
        if($dr){
           $pat_data='f_name:'.$dr['f_name'].',l_name:'.$dr['l_name'].',mobile:'.$dr['mobile'];
        }
    }
	if($q){$q=" where id!=0 $q ";}
    if($q2){$q2=" where id!=0 $q2 ";}
    $all2=0;
	$res=mysql_q("select count(*)c from gnr_m_patients $q ");
    $r=mysql_f($res);
	$all=$r['c']; 
    if($m==2){
        $res=mysql_q("select count(*)c from dts_x_patients $q2 ");
        $r=mysql_f($res);
	    $all2=$r['c'];
    }
	
	if($q){
		$sql="select id,f_name,l_name,ft_name,mobile,mother_name,birth_date,sex,title,photo from gnr_m_patients $q order by f_name ASC , ft_name ASC , l_name ASC limit $max_list ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
        $rows2=0;
		$rowsV=$rows;
        if($m==2){//المرضى المؤقتتين
            $sql2="select * from dts_x_patients $q2 order by f_name ASC , l_name ASC limit $max_list ";
            $res2=mysql_q($sql2);
            $rows2=mysql_n($res2);
            $rowsV+=$rows2;
            $max_list=$max_list*2;
        }
		if($rows+$rows2>0){if($all+$all2>$max_list){$rowsV=$rows.' / '.number_format($all+$all2);}}
		echo '<div class="f1 fs16 clr1 lh40 uLine">
		<div class="fr ic30 ic30_add icc4 ic30Txt mg5v" newPat="'.$pat_data.'"> '.k_new_patient.'</div>
		'.k_num_res.' : <ff>'.$rowsV.'</ff></div>';
        if($m==2){
          echo '<div class="of fxg" fxg="gtc:1.2fr 1fr|gap:10px" fix="hp:70">';  
        }else{
		  echo '<div class="ofx so" fix="hp:70">';
        }		
		if($rows+$rows2>0){
            if($m==2){
                echo '<div class="fxg of" fxg="gtr:50px 1fr">
                <div class="f1 lh40 fs14 clr2 uLine">المرضى <ff14> ('.number_format($rows).')</ff14></div>
                <div class="patLV fxg ofx so" fxg="gtb:300px|gap:10px">';
            }else{
                echo '<div class="patLV fxg  ofx so" fxg="gtbf:320px|gap:10px">';
            }
            if($rows){
			     while($r=mysql_f($res)){
				$id=$r['id'];
				$f_name=$r['f_name'];
				$l_name=$r['l_name'];
				$ft_name=$r['ft_name'];
				$title=$r['title'];
				$sex=$r['sex'];
				$mother_name=$r['mother_name'];
				$birth_date=$r['birth_date'];
				$photo=$r['photo'];
				$mobile=$r['mobile'];
				if($birth_date){
				$birthCount=birthCount($birth_date);
				$bdTxt='<div class="f1 clr66 fs12 lh30">'.k_age.' : <ff14 class="clr66">'.$birthCount[0].'</ff14> <span class="clr66 f1 ">'.$birthCount[1].'</span> | <span class="f1 clr55"> ( '.hlight($f6,$mother_name).' )</span></div>';
				}
				$pn='pat_n="'.$id.'" ';
				$x_msg='';
                $pt=1;
                if($m==3){$pt=$m;}
				if(in_array($id,$x_pats)){
					$pn='';
                    if($m==1){
					    $x_msg=k_visit_booked_for_pat;
                    }elseif($m==2){
                        $x_msg='يوجد موعد للمريض بنفس اليوم';
                    }
				}
				echo '<div class="fxg" fxg="gtc:80px 1fr"  '.$pn.' s'.$sex.' pt="'.$pt.'">
					<div class="fl r_bord pd10" i>'.viewPhotos_i($photo,1,60,80,'css','nophoto'.$sex.'.png').'</div>
					<div class="fl mg10">
						<div class="fs14x f1s of lh20 clr1111">'.$titles[$title].' : '.hlight($f2,$f_name).' '.hlight($f4,$ft_name).' '.hlight($f3,$l_name).'</div>'.$bdTxt.' ';
						if($x_msg){
							echo '<div class="fl f1 clr5">'.$x_msg.'</div>';
						}else{
							echo '<div class="fl f1 ">'.k_mobile.' :<ff14> '.hlight($f5,$mobile).'</ff14>&nbsp;</div>';
						} 
						echo '<div n><ff class="fr fs14 clr111">#'.hlight($f1,$id).'</ff></div>
					</div>
				</div>';
			}
            }
            if($m==2){echo '</div>';}
            echo '</div>';
            if($m==2){
                echo '<div class="fxg of " fxg="gtr:50px 1fr">
                <div class="f1 lh40 fs14 clr2 uLine">المرضى المؤقتين <ff14> ('.number_format($rows2).')</ff14></div>
                <div class="patLV fl fxg ofx  so" fxg="gtb:220px|gap:10px">';
                if($rows2){
                    while($r2=mysql_f($res2)){
                        $id=$r2['id'];
                        $f_name=$r2['f_name'];
                        $l_name=$r2['l_name'];                                       
                        $mobile=$r2['mobile'];                    
                        $pn='pat_n="'.$id.'" ';
                        $x_msg='';
                        if(in_array($id,$x_pats)){
                            $pn='';
                            if($m==1){
                                $x_msg=k_visit_booked_for_pat;
                            }elseif($m==2){
                                $x_msg='يوجد موعد للمريض بنفس اليوم';
                            }
                        }
                        echo '<div class="fxg cbgw" '.$pn.' pt="2" fix="h:60">                        
                            <div class="fl mg10">
                                <div class="fs14x f1s of lh20 clr1111">'.hlight($f2,$f_name).'  '.hlight($f3,$l_name).'</div>
                                <div class="fl f1 ">'.k_mobile.' :<ff14> '.hlight($f5,$mobile).'</ff14>&nbsp;</div>
                                <div n><ff class="fr fs14 clr111">#'.hlight($f1,$id).'</ff></div>
                            </div>
                        </div>';
                    }
                }
                echo '</div>';
            }else{
                echo '</div>';
            }
		}else{
            echo '<div class="" >';
			echo '<div class="f1 fs16 clr5 lh40">'.k_no_results.'</div>';
            echo '</div>';
		}	
		echo '</div>';
	}else{
		echo '<div class="f1 fs16 clr1 lh50 uLine">
		<div class="fr ic30 ic30_add icc4 ic30Txt mg10v" newPat="'.$pat_data.'"> '.k_new_patient.'</div>
		'.k_num_pats.' : <ff>'.number_format($all).'</ff></div>
		<div class="f1 fs14 clr5 lh30">'.k_srch_or_add_pat.'</div>';
	}
}
?>