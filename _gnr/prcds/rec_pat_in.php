<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pars'])){
	$titles=modListToArray('czuwyi2kqx');
	$pars=pp($_POST['pars'],'s');	
	$x_pats=explode(',',$pats);
	$max_list=100;
	
	$q='';    
	$f1=$f2=$f3=$f4=$f5='';	
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
	$pat_data='f_name:'.$f2.',l_name:'.$f3.',mobile:'.$f5.',ft_name:'.$f4.',mother_name:'.$f6;
	if($q){$q=" where id!=0 $q ";}    
	$res=mysql_q("select count(*)c from gnr_m_patients $q ");
    $r=mysql_f($res);
	$all=$r['c']; 
	if($q){
		$sql="select id,f_name,l_name,ft_name,mobile,mother_name,birth_date,sex,title,photo from gnr_m_patients $q order by f_name ASC , ft_name ASC , l_name ASC limit $max_list ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
        $rowsV=$all;
		if($rows>0){if($all>$max_list){$rowsV=$rows.' / '.number_format($all);}}
		echo '<div class="f1 fs16 clr1 lh40 uLine">		
		'.k_num_res.' : <ff>'.$rowsV.'</ff></div>';
        echo '<div class="ofx so" fix="hp:70">';        		
		if($rows+$rows2>0){            
            echo '<div class="patLV fxg  ofx so" fxg="gtb:320px|gap:10px">';            
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
                    $x_msg='';                                 
                    echo '<div class="fxg" fxg="gtc:80px 1fr"  pat="'.$id.'" pat_name="'.$f_name.' '.$ft_name.' '.$l_name.'" s'.$sex.' >
                        <div class="fl r_bord pd10" i>'.viewPhotos_i($photo,1,60,80,'css','nophoto'.$sex.'.png').'</div>
                        <div class="fl mg10">
                            <div class="fs14x f1s of lh20 clr1111">'.$titles[$title].' : '.hlight($f2,$f_name).' '.hlight($f4,$ft_name).' '.hlight($f3,$l_name).'</div>'.$bdTxt.'                             
                            <div class="fl f1 ">'.k_mobile.' :<ff14> '.hlight($f5,$mobile).'</ff14>&nbsp;</div>
                            <div n><ff class="fr fs14 clr111">#'.hlight($f1,$id).'</ff></div>
                        </div>
                    </div>';
                }
            }            
            echo '</div>
            </div>';
		}else{
            echo '<div class="" >';
			echo '<div class="f1 fs16 clr5 lh40">'.k_no_results.'</div>';
            echo '</div>';
		}	
		echo '</div>';
	}else{
		echo '<div class="f1 fs16 clr1 lh50 uLine">		
		'.k_num_pats.' : <ff>'.number_format($all).'</ff></div>
		<div class="f1 fs14 clr5 lh30">'.k_srch_or_add_pat.'</div>';
	}
}
?>