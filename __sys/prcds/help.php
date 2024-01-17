<? include("ajax_header.php");
if(isset($_POST['code'],$_POST['t'])){
	$t=pp($_POST['t']);
	$actCode=pp($_POST['code'],'s');
	$r=getRecCon('_help'," code='$actCode' and act=1 ");
	if($r['r']){
		if($t==1){
			$q='';
			if($thisGrp!='s'){
				$grptM=$_SESSION[$logTs.'grpt'];
				$grpM=$thisGrp;
				$m_codes=get_vals('_perm','m_code',"type='$grptM' and  g_code='$grpM'");
				$m_codes=str_replace(',',"','",$m_codes);			
				$mods=get_vals('_modules_list','mod_code'," code IN ('$m_codes')");
				$mods=str_replace(',',"','",$mods);
				$q=" and (`mod` IN('$mods') OR `mod`='' ) ";

			}?>
			<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div>
			<div class="win_free of" >
				<div class="fl r_bord of " fix="w:300|hp:0">				
					<div class="helpTree pd10f ofx so" actButt="act" fix="w:300|hp:0"><?
						$sql="select * from _help where act=1 $q order by ord ASC";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						while($r=mysql_f($res)){
							$code=$r['code'];
							$mod=$r['mod'];
							$title=$r['title_'.$lg];
							echo '<div c="'.$code.'">
								<div s="off"></div>
								<div t="off">'.$title.'</div>
							</div>
							<div ms="'.$code.'"></div>';
						}?>
					</div>
				</div>
				<div class="helpDet fl ofx pd10f so" fix="wp:300|hp:0" id="vidC"></div>
			</div><?
		}else{
			$out1=$out2='';		
			$mod=$r['mod'];
			$h_title=$r['title_'.$lg];
			$h_des=$r['des_'.$lg];
			if($thisGrp!='s' && $mod!=''){if(modPer($mod,0)=='0'){exit;}}
			if($t==3){
				$out2.='<div class="f1 fs18 clr1111 lh40 uLine">'.$h_title.'</div>
				<div class="fs12 lh20 ">'.$h_des.'</div>';
			}
			if($t==2){
				$rows=getTotalCO('_help_videos',"h_code='$actCode'");
			}else{
				$sql="select * from _help_videos where h_code='$actCode' order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);				
			}
			if($rows){
				$out1.='<div sTit="0" >'.k_videos.'</div>';
				if($t==3){
					$out2.='<div class="f1 fs14 clr1 lh40 " id="b_0">'.k_videos.'</div>
					<div >';
					while($r=mysql_f($res)){
						$vId=$r['id'];
						$vTitle=$r['title_'.$lg];						
						$out2.='<div class="f1 vid fs12" vid="'.$vId.'">'.$vTitle.'</div>';
					}
					$out2.='</div>';
				}
			}			
			$sql="select * from _help_details where h_code='$actCode' order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){				
				while($r=mysql_f($res)){
					$txtId=$r['id'];
					$title=$r['title_'.$lg];
					$des=$r['des_'.$lg];
					$out1.= '<div sTit="'.$txtId.'">'.$title.'</div>';
					if($t==3){												
						$out2.='<div class="f1 fs14 clr1 lh40" id="b_'.$txtId.'">'.$title.'</div>
						<div class="lh20 fs12 TJ ">'.$des.'</div>';
					}
				}
			}
			echo $out1;
			if($t==3){
				echo '^'.$out2;
			}
		}
	}
}
if(isset($_POST['code'],$_POST['v'])){
	$v=pp($_POST['v']);
	$actCode=pp($_POST['code'],'s');
	$r=getRecCon('_help'," code='$actCode' and act=1 ");
	if($r['r']){
		$mod=$r['mod'];
		if($thisGrp!='s' && $mod!=''){if(modPer($mod,0)=='0'){exit;}}
		$r=getRecCon('_help_videos',"h_code='$actCode' and id ='$v'");
		if($r['r']){
			$vid=$r['video_'.$lg];?>
			<video width="100%" height="100%" controls autoplay>
			  <source src="../videos/<?=$vid?>" type="video/mp4" id="vSrc">		  
			  Your browser does not support HTML5 video.
			</video>
			<div class="fl w100 lh50 t_bord">
				<div class="bu bu_t2 fr" onclick="closeHelpVid();"><?=k_close?></div>
			</div><?
		}
	}
}?>