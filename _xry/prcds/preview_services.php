<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['srv'])){
	$vis=pp($_POST['id']);
	$actSrv=pp($_POST['srv']);
	$sql="select * , x.id as xid , z.id as zid  from xry_m_services z , xry_x_visits_services x where z.id=x.service and x.visit_id='$vis' order by z.ord ASC";
	$res=mysql_q($sql);
	echo $rows=mysql_n($res);
	echo '^';
	?>
<style>
.xRayList >div{
	width:274px;
	margin-bottom: 10px;
	border:1px #ccc solid;
	border-radius: 2px;
	background-color: #eee;
	border-bottom: 5px #ccc solid;
	cursor: pointer;
}
.xRayList >div:hover{	
	border:1px #999 solid;
	border-bottom: 5px #999 solid;
}
.xRayList div[n]{
	width:80px;
	line-height: 30px;
	text-align: center;
	font-size: 18px;
	background-color: #e5e5e5;
}
.xRayList div[c]{
	width:194px;
	line-height: 30px;
	text-align: center;
	font-size: 14px;
	background-color: #e5e5e5;
}
.xRayList div[t]{
	padding: 10px;
	line-height: 25px;	
	font-size: 14px;
	
}
.xRayList div[s]{	
	line-height:25px;		
	font-size: 12px;
	text-align: center;
}

.xRayList >div[act]{
	border:1px #333 solid;
	border-bottom: 5px <?=$clr2?> solid;
	
	
}
.xRayList >div[act] > div[n] , .xRayList >div[act] > div[c]{
	background-color: <?=$clr2?>;
	color: #fff;
}
</style>
<?
	if($rows>0){
		echo '<div class="xRayList" actButt="act">';
		$i=0;
		while($r=mysql_f($res)){			
			$s_id=$r['xid'];
			if($actSrv==0 && $i==0){$actSrv=$s_id;echo script('xryActSrv='.$actSrv);}
			$act='';			
			if($actSrv==$s_id){$act='act';}
			$s_time=$r['ser_time']*_set_pn68gsh6dj*60;
			$s_status=$r['status'];
			$name=$r['name_'.$lg];				
			$cat=$r['cat'];
			$doc=$r['doc'];
			$cat_name=get_val_arr('xry_m_services_cat','name_'.$lg,$cat,'cat');
			$action =' onclick="x_report('.$s_id.',0)" ';
			$print_b='';
			$bgcolor='';
			$sIcon='det';
			$sClr='cbg888';
			if($s_status==0 && $rows>1){
				$cancel_b='<div class="fr ic40 icc2 ic40_del" title="'.k_cncl_serv.'" onclick="xry_caclSrv('.$s_id.',1)"></div>';
			}
			if($s_status==1){
				$sIcon='done';
				$sClr='cbg6 clrw';
				$print_b='<div class="fr ic40 icc1 ic40_print" onclick="x_report_print('.$s_id.')"></div>';
				if( $thisGrp!='nlh8spit9q'){
					if($doc!=0){$print_b='';}
				}
			}			
			//if($s_status==2){$action='';}
			if($s_status==6){$sClr='cbg77 clrw';}
			if(in_array($s_status,array(3,4))){$sClr='cbg5 clrw';}
			echo '
			<div class="fl bs_c "  '.$act.' '.$action.'>
				<div class="fl r_bord" n >'.$s_id.'</div>
				<div class="fl f1" c>'.$cat_name.'</div>
				<div class="f1 cb t_bord TC" t>'.$name.'</div>
				<div class="f1 t_bord '.$sClr.'" s >'.$ser_status_Tex[$s_status].'</div>
			</div>';
			$i++;
		}
		echo '</div>';
		
	}	
}?>