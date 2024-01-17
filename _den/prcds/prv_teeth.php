<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['t'])){	
	$vis=pp($_POST['vis']);
	$tType=pp($_POST['t']);
    $patient=get_val('den_x_visits','patient',$vis);    
    $thethCodes=get_arr('den_m_teeth','no','t_code,pos');
 
    $oprStatus=array();
    $tsfc=array();
    $tooth=array();
    $sql="SELECT * FROM den_x_opr_teeth WHERE patient = '$patient' and last_opr=1";
    $res=mysql_q($sql);
    while($r=mysql_f($res)){
        $no=$r['teeth_no'];
        $teeth_part=$r['teeth_part'];
        $opr_sub=$r['teeth_part_sub'];
        $last_opr=$r['last_opr'];        
        if($opr_sub==0){
            $oprStatus['1-'.$teeth_part.'-'.$no]=$r;
        }else{            
            $oprStatus['2-'.$teeth_part.'-'.$no.'-'.$opr_sub]=$r;            
        }
        if($last_opr){
            $tsfc[$teeth_part.'-'.$no][$opr_sub]=$r;            
        }
    }
    /**/    
    $teethDaArr=array();
    $sql="select * from den_m_set_teeth where act =1 order by ord ASC";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){			
        while($r=mysql_f($res)){
            $id=$r['id'];            
            $teethDaArr['1-'.$r['opr_type'].'-'.$id]=$r;            
            $oprDataArr[$id]['icon']=$r['icon'];
            $oprDataArr[$id]['name']=$r['name_'.$lg];
            $oprDataArr[$id]['color']=$r['color'];
            $oprDataArr[$id]['opr_type']=$r['opr_type'];
            $oprDataArr[$id]['opr_type']=$r['opr_type'];
        }
    }
    $rootDaArr=array();
    $sql="select * from den_m_set_roots where act =1 order by ord ASC";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){			
        while($r=mysql_f($res)){
            $id=$r['id'];
            $rootDaArr['2-'.$r['opr_type'].'-'.$id]=$r;
            $rootDataArr[$id]['icon']=$r['icon'];
            $rootDataArr[$id]['name']=$r['name_'.$lg];
            $rootDataArr[$id]['color']=$r['color'];
        }
    }
    /************************************/
	$s=0;
	if($s){		
		$oprDataArr=array();
		$sql="select * from den_m_set_teeth where act =1 order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){			
			while($r=mysql_f($res)){
				$id=$r['id'];
				$oprDataArr[$id]['icon']=$r['icon'];
				$oprDataArr[$id]['name']=$r['name_'.$lg];
				$oprDataArr[$id]['color']=$r['color'];
				$oprDataArr[$id]['opr_type']=$r['opr_type'];
				$oprDataArr[$id]['opr_type']=$r['opr_type'];
			}
		}
        /******/
		$rootDataArr=array();
		$sql="select * from den_m_set_roots where act =1 order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){			
			while($r=mysql_f($res)){
				$id=$r['id'];
				$rootDataArr[$id]['icon']=$r['icon'];
				$rootDataArr[$id]['name']=$r['name_'.$lg];
				$rootDataArr[$id]['color']=$r['color'];
			}
		}
		$teethStatus=array();
		$tsfc=array();
		$sql="SELECT * FROM den_x_opr_teeth WHERE patient = '$patient' and last_opr=1";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$no=$r['teeth_no'];
			$teeth_part=$r['teeth_part'];
			$opr_sub=$r['teeth_part_sub'];
			$last_opr=$r['last_opr'];
			if($last_opr){
				$tsfc[$teeth_part.'-'.$no][$opr_sub]=$r;
			}
			if($teeth_part==1){
				$teethStatus[$no]=$r;
			}else{
				$rootStatus[$no][$opr_sub]=$r;
				$rootStatus[$no]['c']=$r['opr_type'];
			}
		}
	
	}?>
    <div class="fxg h100" fxg="gtr:auto 1fr">
        <div class="ofx so h100 fxg-al-e fxg"><?
            $tun=array();
            $trno=array();
            $cavsArr=array();
            $sql="select * from den_m_teeth where type='$tType' order by no_unv";
            $res=mysql_q($sql);
            $teethDadta=[];
            while($r=mysql_f($res)){
                $no=$r['no'];
                $teethDadta[$no]=$r;
                $t_type=$r['t_type'];
                $no_unv=$r['no_unv'];
                $root_no=$r['root_no'];
                $t_code=$r['code'];		
                $tun[$no]=$no_unv;
                $trno[$no_unv]=$root_no;
                $cavities=$r['cavities'];
                $cavsArr[$no]=$cavities;
            }

            if($tType==1){$side_s=1;$side_e=4;$side_n=8;}
            if($tType==2){$side_s=5;$side_e=8;$side_n=5;}?>
            <div class=" w100 teeTab fxg b_bord t_bord cbg444" fxg="gtc:1fr 1fr|gtc:1fr:1000" dir="ltr"><?
                for($p=$side_s ;$p<=$side_e;$p++){
                    $part=$p;
                    if($p==3){$part=4;}
                    if($p==4){$part=3;}
                    if($p==7){$part=8;}
                    if($p==8){$part=7;}                    
                    echo '<div r'.$part.' class="fxg" fxg="gtc:repeat('.$side_n.',1fr)">';
                    for($i=1 ;$i<=$side_n;$i++){
                        $thethNo=$part.$i;
                        if(in_array($part,array(1,4,5,8))){$thethNo=$part.($side_n-$i+1);}
                        echo '<div>';
                        if(in_array($part,array(3,4,7,8))){
                            echo loadTeeth($thethNo).loadRoot($thethNo);
                        }else{
                            echo loadRoot($thethNo).loadTeeth($thethNo);
                        }
                        echo '</div>';                             
                    }                             
                    echo '</div>';
                }?>
            </div>
            <div class="f1 fs14 lh40 clr5 pd10" teNote>
                 لتغيير حالة الاسنان اختر الحالة ثم حدد الأسنان المستهدفة 
            </div>
        </div>
    </div><?    
}?>
