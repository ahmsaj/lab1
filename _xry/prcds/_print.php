<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){
	$type=pp($_GET['type']);
	$id=pp($_GET['id']);
	$thisCode=$type.'-'.$id;
	$pageSize='pp4';
	if($type==1){$titlee=k_report;}
	$style_file=styleFiles('P');?>
	<head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>
	<body dir="<?=$l_dir?>">    
    <div class="<?=$pageSize?>">
		<div class="ppin"><?
			echo printHeader(4);		
			/**************************************************/		
			if($type==1){?>
				<div class="page_inn"><?
				$q='';
				if($MO_ID!='lxgwod7v2g'){
					$q=" and doc='$thisUser' ";
				}
				$sql="select * from xry_x_pro_radiography_report where id='$id' $q ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					$r=mysql_f($res);
					$doc_ask=$r['doc_ask'];
					$report=$r['report'];
					$doc=$r['doc'];
					$date=$r['date'];
					$patient=$r['patient'];
					$service=$r['service'];

					list($vis,$clinic)=get_val('xry_x_visits_services','visit_id,clinic',$id);
					$serv_name=get_val('xry_m_services','name_'.$lg,$service);								
					$clinic_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
					if(!$doc_ask){$doc_ask=get_val('xry_x_visits','doc_ord',$vis);}
					$askDocName=get_val('gnr_m_doc_req','name',$doc_ask);
					list($docName,$sex)=get_val('_users','name_'.$lg.',sex',$doc);

					$birth=get_val('gnr_m_patients','birth_date',$patient);
					$birthCount=birthCount($birth);?>
					<table width="100%">
						<tr>
							<td width="50%" valign="top">
								<div class="f1 fs14 lh30"><?=k_patient?> : <?=get_p_name($patient);?></div><? 
								if($doc_ask){?><div class="f1 fs14 lh30"><?=k_req_by_dr?> : <?=$askDocName?></div><? }?>
								<div class="cb f1 fs14 lh30"><?=k_exmntion?> : <?=$clinic_name.' - '.$serv_name;?></div>
							</td>
							<td width="50%" valign="top">
								<div class="f1 fs14 lh30"><?=k_age?> : <ff><?=$birthCount[0]?> </ff><?=$birthCount[1]?></div>
								<div class="f1 fs14 lh30"><?=k_date?> : <ff><?=date('Y-m-d',$date);?></ff></div>
							</td>
						</tr>
					</table>
					<div class="f1 fs20 TC lh60"><?=k_radiograph_report?></div>
					<div class="lh30 printRep"><?=($report)?></div>
					<div class="lh50">&nbsp;</div>
					<div class="f1 lh20 fs16 fr"><?=$sex_txt[$sex].' : '.$docName?></div>
					<div class="lh50">&nbsp;</div>        
				<? }?>
				</div>
			   <?
			}			
			?>&nbsp;
		</div>
	</div>
    </body><?
}?>
<script>window.print();setTimeout(function(){window.close();},800);</script>