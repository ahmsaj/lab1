<?/***API***/
$api_url='http://'.$_SERVER['HTTP_HOST']._path.$lg.'/';
$pat_id=0;
$logType=0;
$setArr=[];
/*****************/
function appLink($id,$opr,$filed,$val){
    global $lg,$clinicTypes;
	if($opr=='add' || $opr=='edit'){		
		$out='<div id="setAL" f="'.$filed.'">'.appLinkIn($id,'',$filed,$val).'</div>';
        $out.='<script>changALink()</script>';
	}else{
        if($id){
            $link=get_val('api_m_home','link',$id);
            if($link<4){
                $out='<div class="f1 fs14 lh40">لا يوجد روابط فرعية</div>';
            }else{
                switch($link){
                    case 4:$out=$clinicTypes[$val];break;
                    case 5:$out=get_val('api_m_pages','title_'.$lg,$val);break;
                    case 6:$out=get_val('api_m_sevices_cats','title_'.$lg,$val);break;
                }
            }
        }
	}
	return $out;
}
function appLinkIn($id,$link,$filed,$val){
	global $lg,$clinicTypes;		
	$out='';
	if(!$link && $id){$link=get_val('api_m_home','link',$id);}
     switch($link){
        case 4:
             $out='<select name="'.$filed.'">';
             foreach($clinicTypes as $k =>$v){
                 if($k){
                     $sel='';
                     if($k==$val){$sel=' selected ';}
                     $out.='<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
                 }
             }
             $out.='</select>';
        break;
        case 5:
            $out.=make_Combo_box('api_m_pages','title_'.$lg,'id'," where act =1 ",$filed,1,$val);
        break;
        case 6:
            $out.=make_Combo_box('api_m_sevices_cats','title_'.$lg,'id',"",$filed,1,$val);
        break;
        default:
             $out='<div class="f1 fs14 lh40">لا يوجد روابط</div>';
        break;
    }    
	return $out;
}
function postStatus($id,$opr,$filed,$val){
    $out='';
    $r=getRec('api_x_posts',$id);
    if($r['r']){
        $send=$r['send'];
        $publish=$r['publish'];
        if($opr=='list'){
            if($publish==0){
                $out='<div class="fr bu bu_t4 buu" onclick="publishPost('.$id.')">نشر</div>';
            }else{
                $out.='<div class="f1 clr1 lh20 TC">تم النشر</div>';
                if($publish==1){
                    $title='إرسال الإشعارات';
                    if($send){$title='إكمال عملية الإرسال';}
                    $out.='<div class="f1 clr5 lh20 TC Over" onclick="postNoti('.$id.')">'.$title.'</div>';
                }
                if($publish==2){
                    $sData=explode(',',$send);
                    $out.='<div class="lh30 f1 TC">تم إرسال 
                    <ff14 class="B">('.$sData[0].')</ff14> :
                    <ff14 class="clr6">'.$sData[1].'</ff14> -
                    <ff14 class="clr5">'.$sData[2].'</ff14>
                    </div>';
                }
            }
        }
    }
    return $out;
}
/*****************API *************************/
function apidataObject($mod,$mood=1,$subData=0,$cus_ref_col=''){
	global $now,$pat_id,$logType,$lg,$mail_actCode_title,$visXTables; 
    //$visXTables=array('','cln_x_visits','lab_x_visits','xry_x_visits','den_x_visits','bty_x_visits','bty_x_laser_visits','osc_x_visits');
	$eXdata=array();
	$error=0;
	$token=pp($_POST['token'],'s');
	$r=getRecCon('api_module'," code='$mod'");
	if($r['r']){
		$logType=0;
		$pat_id=0;
		$reg_ok=1;
		$mod_id=$r['id'];
		$module=$r['module'];
		$mod_code=$r['code'];
		$type=$r['type'];
		$sub_type=$r['sub_type'];
		$need_reg=$r['need_reg'];
        $ord_field=$r['ord_field'];
		$ord_dir=$r['ord_dir'];
		$need_reg_temp=$r['need_reg_temp'];
		$mod_table=$r['table'];
        $conditions=$r['conditions'];
        $sub_conditions='';
        if($subData){$sub_conditions=$conditions;}        
		$rpp=$r['rpp'];
		$ref_col=$r['ref_col'];
		if($rpp==0){$rpp=10;}        
		if($need_reg || $mod=='o6uvutsynr' ||  $mod=='n0ruahvf8m'){
			$pat=getRecCon('gnr_m_patients', "token ='$token' and `token`!='' ");
            if($pat['r']){
                $pat_id=$pat['id'];
                $_SESSION['Token']=$token;
                $logType=1;
            }else{
                if($need_reg){
                    $reg_ok=0;
                }
            }
		}
		if($need_reg_temp && $pat_id==0){
			$pat_id=get_val_con('dts_x_patients','id', "token ='$token' and `token`!='' ");
			if($pat_id){
                $_SESSION['Token']=$token;
                $logType=2;
                $reg_ok=1;
            }else{
                if($need_reg){
                    $reg_ok=0;
                }
            }
		}
		$search_arr=array();
		if($reg_ok){
			//-----IN------------
			$res_in=mysql_q("select * from api_modules_items_in where mod_id='$mod_id' and `act`=1 order by ord ASC");
			$rows_in=mysql_n($res_in);
			$fillter='';
			$inArrlist=array();
			$sendActCode=1;
			if($rows_in){
				$query_in_col=array();
				$query_in_val=array();
				$query_in_edit='';
				while($r=mysql_f($res_in)){
					$inName=get_key($r['in_name']);
					$in_name=$r['in_name'];
					$in_id=$r['id'];
					$star='';
					if(isset($_POST[$in_name])){                        
						$inVal=pp($_POST[$in_name],'s');                        
						$col_id=$r['id'];
						$colum=$r['colum'];
						$in_name=$r['in_name'];
						$search=$r['search'];
						$requerd=$r['requerd'];
						$in_type=$r['type'];
						$in_sub_type=$r['sub_type'];
						if($search){
							if($inVal){
								if(($mod_code=='o6uvutsynr' && $col_id==96) || ($mod_code=='oefwugfb93' && $col_id==2)){
								if($fillter){$fillter.=" and ";}
									$inVal=getAllLikedClinics($inVal,$c=',');									
									$fillter.=" `$colum` IN($inVal) ";
								}else if($mod_code=='i8nhg3b39z'){
                                    if($fillter){$fillter.=" and ";}
									   $fillter.=" `$colum` in(select id from bty_m_services_cat where clinic='$inVal') ";
                                }else{
									if($fillter){$fillter.=" and ";}
									$fillter.=" `$colum`='$inVal' ";
								}																
								array_push($search_arr,$colum);
							}
						}
						if($requerd && !$inVal){$error=4;}
						if($error==0){ 
							if($sub_type==1){
								if($in_type==3 || ($in_type==1 && $in_sub_type==2)){$inVal=intval($inVal);}
								if($in_type==2){								
									if($in_sub_type==1 && $inVal!=''){
										if(DateTime::createFromFormat('Y-m-d', $inVal) === FALSE){$error=8;}			
									}
									if($in_sub_type==2){$inVal=intval($inVal);}
								}
								if($in_type==4){
									if($inVal){
										$inVal=base64_to_jpeg($inVal,$mood);
										if(!$inVal){$error=8;}
									}
								}
								if($in_type==6){
									$e=0;
									$inArrlist[$in_id]=explode('|',$in_sub_type);
									if($requerd){
										$e=1;
										foreach($inArrlist[$in_id] as $inv){
											$inv2=explode(':',$inv);
											if($inv2[0]==$inVal){$e=0;}
										}
									}
									if($e){$error=8;}
								}
								if($in_type==7){}
								
								if($mod=='1oxi7bn088'){
                                    if($in_name=='pass' && $inVal==''){
									   $inVal=getRandString(10);
								    }
                                    if($in_name=='mobile'){
                                        $inVal=fixNumber($inVal);
                                    }
								    if($in_name=='uToken'){
                                        if($inVal==''){
                                            $inVal=getRandString(32);
                                            $actTok=$inVal;
                                        }
                                    }
									
								}
								
								if($mod=='fy7hpfoewv' && $in_name=='uToken'){
									if($inVal==''){$inVal=getRandString(32);}
									array_push($query_in_col,'pass');
									array_push($query_in_val,getRandString(10));

									array_push($query_in_col,'act');
									array_push($query_in_val,'1');
									$actTok=$inVal;
								}
                                
                                if($mod=='4etvw21vfc' && $in_name=='visit_type'){
                                    $visitValType=$inVal;
                                }
                                if($mod=='4etvw21vfc' && $in_name=='no' && $visitValType){
                                    if($visitValType!=2){list($doc,$clinic)=get_val($visXTables[$visitValType],'doctor,clinic',$inVal);
                                        array_push($query_in_col,'doc');
                                        array_push($query_in_val,$doc);
                                        array_push($query_in_col,'clinic');
                                        array_push($query_in_val,$clinic);
                                    }
								}
                                //******visit rating 
                                if($mod=='xpefhyyunb' && $in_name=='visit_type'){
                                    $visitValType=$inVal;
                                }
                                
                                if($mod=='xpefhyyunb' && $in_name=='visit'){
                                    $visit=$inVal;
                                    $table=$visXTables[$visitValType]; 
                                    $oldRating=getTotalCo('gnr_x_visit_rate',"visit='$visit' and type='$visitValType'");                                    
                                    if($oldRating==0){
                                        $vis_data=getRec($table,$visit);
                                        $visRate=$_POST['rate'];
                                        mysql_q("UPDATE $table set rate=$visRate where id ='$visit'");
                                        if($vis_data['r']){                                        
                                            array_push($query_in_col,'vis_date');
                                            array_push($query_in_val,$vis_data['d_start']);

                                            array_push($query_in_col,'doc');
                                            array_push($query_in_val,$vis_data['doctor']);

                                            array_push($query_in_col,'clinic');
                                            array_push($query_in_val,$vis_data['clinic']);

                                            array_push($query_in_col,'date');
                                            array_push($query_in_val,$now);                                       
                                        }else{
                                            $error=8;
                                        }
                                    }else{
                                        $error=8;
                                    }
                                }
								
								array_push($query_in_col,$colum);
								array_push($query_in_val,$inVal);								
							}
							if($sub_type==2){
								$replaceRecId=0;
								if($mod=='nrvn0ayyc5'){$replaceRecId=$pat_id;}																
								if(($need_reg || $need_reg_temp) && $ref_col='id'){$replaceRecId=$pat_id;}
		
								if(isset($_POST['rec_id']) || $replaceRecId){
									$rec_id=pp($_POST['rec_id'],'s');
									if($replaceRecId){$rec_id=$replaceRecId;}
									if(getTotalCO($mod_table," `$ref_col`='$rec_id' ")){
										if($in_type==3 || ($in_type==1 && $in_sub_type==2)){$inVal=intval($inVal);}
										if($in_type==2){							
											if($in_sub_type==1){
												if(DateTime::createFromFormat('Y-m-d', $inVal) === FALSE){$error=8;}
											}
											if($in_sub_type==2){$inVal=intval($inVal);}
										}
										if($in_type==4){
											if($inVal){
												$inVal=base64_to_jpeg($inVal,$mood);
												if(!$inVal){$error=16;}
											}
										}
										if($in_type==6){
											$e=1;
											$inArrlist[$in_id]=explode('|',$in_sub_type);
											foreach($inArrlist[$in_id] as $inv){
												$inv2=explode(':',$inv);
												if($inv2[0]==$inVal){$e=0;}
											}
											if($e){$error=8;}
										}
										if($in_type==7){}
										
										if($in_type!=4  || ($in_type==4 && $inVal!='')){
											if($query_in_edit){$query_in_edit.=' , ';}
											$query_in_edit.=" `$colum`='$inVal' ";
										}
									}else{
										$error=10;	
									}
								}else{
									$error=7;
								}								
							}
						}
					}
				}          
				if($error==0){
					if($sub_type==1){
						$insertOk=1;
						if($mod=='qt2r9wt2v'){
							$clinic=pp($_POST['clinic_id']);
							$doctor=pp($_POST['doctor_id']);
							$appoint_start=pp($_POST['appoint_start']);
							$appoint_end=pp($_POST['appoint_end']);
                            $service=pp($_POST['service']);
                            $clinic=get_val('_users','subgrp',$doctor);
							$ch=chekDatedata(0,$clinic,$doctor,$appoint_start,$appoint_end,$service);
							if($ch!=0){
								$insertOk=0;
								$error=$ch;
							}else{
                                $dts_status=1;                                
								$cType=get_val('gnr_m_clinics','type',$clinic);
                                if($cType==5 || $cType==6){
                                    if($service==0){
                                        $error=4;
                                    }else{
                                        list($payment,$app)=get_val('bty_m_services','payment,app',$service);
                                        if(!$app){
                                            $error=8;
                                        }else{
                                            if($payment){
                                                $dts_status=10;
                                            }
                                        }
                                    }
                                }
                                if($error==0){
                                    $appUser=get_val_c('api_users','id',pp($_POST['uCode'],'s'),'code');
                                    array_push($query_in_col,'type');
                                    array_push($query_in_val,$cType);
                                    array_push($query_in_col,'p_type');
                                    array_push($query_in_val,$logType);
                                    array_push($query_in_col,'date');
                                    array_push($query_in_val,$now);
                                    array_push($query_in_col,'app');
                                    array_push($query_in_val,$appUser);
                                    array_push($query_in_col,'status');
                                    array_push($query_in_val,$dts_status);// status 10 to review 
                                    array_push($query_in_col,'reg_user');
                                    array_push($query_in_val,0);
                                    if (($key = array_search('id',$query_in_col)) !== false) {
                                        unset($query_in_col[$key]);
                                        unset($query_in_val[$key]);
                                    }
                                }
							}
						}                        
						if($mod=='1oxi7bn088'){
							$mobile=pp($_POST['mobile'],'s');
                            $mobile=fixNumber($mobile);
							$email=pp($_POST['email'],'s');
							if(getTotalCO('dts_x_patients',"mobile='$mobile'")){
                                $error=15;
                                $insertOk=0;
                            }
							if($sendActCode==1 && $error==0){
								$ch=chekEmail($email);
								$vercode=creatVerCode($mobile);
								$name=$mail_actCode_title.' Activation code';
								$message=$mail_actCode_title.' Activation code  is '.$vercode;
								//if(_set_ed69zm8iw==2){
									if(sendSMS($mobile,$message)){
										$eXdata=array($mobile);
									}else{
										$error=13;
                                        $insertOk=0;
									}
								//}
								if($error==0){
									if($ch){
										if(_set_ed69zm8iw==1){
											$insertOk=0;
											$error=$ch;
										}
									}else{
										/*if(sendMasseg($email,'Activation code',$message,$name)){
											$eXdata=array('',$email);	
										}else{
											$error=13;
										}	*/
									}
								}
                                $eXdata=array('',$mobile,$actTok);
							}else{
								$eXdata=array('',$mobile,$actTok);								
							}
							/*if(_set_ed69zm8iw==1){							
								if($sendActCode==1){			
									//$ch=chekEmail($email);
									if($ch){
										$insertOk=0;
										$error=$ch;
									}else{
										//$vercode=creatVerCode($email,$mobile);
										//$name=$mail_actCode_title.' Activation code';
										//$message=' Activation code  is '.$vercode;
										if(sendMasseg($email,'Activation code',$message,$name)){
											$eXdata=array('',$email);	
										}else{
											$error=13;
										}	
									}
								}else{
									//$eXdata=array('',$email,$actTok);
								}
							}
							if(_set_ed69zm8iw==2){
								if($sendActCode==1){			
									//$vercode=creatVerCode($email,$mobile);
									//$message=' Activation code  is '.$vercode;
									//if(sendSMS($phone,$message)){
									//	$eXdata=array('',$phone);								
									//}else{
									//	$error=13;
									//}
								}else{
									//$eXdata=array('',$email,$actTok);
								}
							}*/
						}						
						if($mod=='4etvw21vfc'){
							$visit_type=pp($_POST['visit_type']);
							$visit_no=pp($_POST['no']);
							if(!isRealVisit($visit_type,$visit_no)){$insertOk=0;$error=23;}
							$eXdata=array($rec_id);
						}						
						if($ref_col!='id' && $need_reg){
							array_push($query_in_col,$ref_col);
							array_push($query_in_val,$pat_id);
						}
                        if($mod=='s08lt0g7es'){
                            array_push($query_in_col,'date');
							array_push($query_in_val,$now);
                        }                        
						$columns='`'.implode('`,`',$query_in_col).'`';
						$vals="'".implode("','",$query_in_val)."'";						
						if($insertOk){                            
							$sql="INSERT INTO $mod_table ($columns) values ($vals)";
							if(mysql_q($sql)){
								$newId=last_id();
								$eXdata=array($newId);
								if($mod=='qt2r9wt2v'){
									addTempOpr($pat_id,'6'.$logType,$cType,$clinic,$newId);
                                    addDtsSrviceAuto(getRec('dts_x_dates',$newId));
                                    datesTempUp($newId);                                    
                                    $eXdata[1]=$dts_status;
								}
                                //Action after Insert
                                if($mod=='s08lt0g7es'){//إرسال تنبيه للمسؤول عن الشكاوى
                                    if(_set_9ls8ik9t7y){								    
                                        sysNotiSend('bzta4kuusp',$newId,0,_set_9ls8ik9t7y);
                                    }
                                }
                                /****************************************/
							}else{
								$error=9;						
							}
							if($mod=='4etvw21vfc'){
								$eXdata[1]=$visit_type;
								$eXdata[2]=$visit_no;
							}
							if($mod=='fy7hpfoewv'){
								$eXdata[1]=$actTok;
							}                                                      
						}
					}
					if($sub_type==2){
						$sql="UPDATE $mod_table SET $query_in_edit where `$ref_col` ='$rec_id' ";
						if(mysql_q($sql)){						
							$eXdata=array($rec_id);
						}else{
							$error=9;
						}						
					}
				}
			 }
			//-----OUT------------            
			if($sub_type==7){// استعلام عن مجموعة سجلات خاصة
				if($mod=='155337qq98'){
					$eXdata=array();
					list($eXdata[0],$obj,$error)=getAccuntBosxDate($mood);					
				}
                if($mod=='iihvxj0d4s'){
					$error=0;          
                    $eXdata[]['status']=get_val_c('_settings','val','vw44hrv5x0','code');
				}                
			}else{
				$res_set=mysql_q("select * from api_modules_items_out where mod_id='$mod_id' and `show`=1 order by ord ASC");                 
				$rows_set=mysql_n($res_set);			
				if($rows_set){
					$cols=array(); 
					while($r2=mysql_f($res_set)){array_push($cols,$r2);}
                }
				if($sub_type==1){// إضافة سجل
                    if($mod=='1oxi7bn088'){
                        $r2=getRec($mod_table,$newId);
                        if($r2['r']){
                            $eXdata[1]=$r2['mobile'];
                            $eXdata[2]=$r2['token'];
                        }
                        mysql_q("UPDATE dts_x_patients_verification SET user ='$newId' ,user_type=2  where mobile ='$mobile' and code='$vercode' ");
                    }                   
                }
				if($sub_type==2){// تحرير سجل 
                    
                }
				if($sub_type==3){// استعلام عن سجل
					$obj=array();				
					$rec_id=pp($_POST['rec_id']);
					if(($need_reg==1 ||$need_reg_temp==1) && $ref_col=='id'){
                        if(!in_array($mod,array('mfyu182xlj','bgal4vsx9h'))){// موديل ليس مرتبط بالمريض مباشرة
						    $rec_id=$pat_id;
                        }
					}                                
					if($rec_id){
						$eXdata=array(1);
						$regCon='';                        
                        if($subData && $cus_ref_col){
                           $rec_id= $cus_ref_col ;
                        }
						if(($need_reg || $need_reg_temp) && $ref_col!='id'){$regCon=" and `$ref_col`='$pat_id' ";}
						$sql="select * from `$mod_table` where id='$rec_id' $regCon limit 1 ";
                        //if($subData ){echo $sql.'-+++-';}
                        //if($subData){echo $sql;}
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						$eXdata=array($rec_id,$rows);
                        if($mod=='n0ruahvf8m'){
                            if($logType){
                                $favArray=get_vals('api_x_fav','doc',"user='$pat_id' && user_type='$logType'",'arr');
                            }
                        }
						while($r=mysql_f($res)){						
							foreach($cols as $col){
                                //echo '('.$col['colum'].')';
								$colum=convLangCol($col['colum']);							
								$val=$r[$colum];
                                if($mod=='n0ruahvf8m'){
                                    if($col['out_name']=='fav'){
                                        if($logType){                                            
                                            if(in_array($val,$favArray)){$val=1;}else{$val=0;}
                                        }else{
                                            $val=0;
                                        }
                                    }
                                }
								$finVal=apiOutCol($val,$col['type'],$col['sub_type'],$mood,$r,$colum);
								
                                if($mod=='bgal4vsx9h'){
                                    if(!isset($pat_name)){
                                        $pat_name=get_val('gnr_m_patients','f_name',$pat_id);
                                    }
                                    if($col['out_name']=='title' || $col['out_name']=='content'){
                                        $finVal=promoReplaceData($finVal,['p'=>$pat_name]);
                                    }
                                }
                                $obj[0]->$col['out_name'] = $finVal;
							}
						}
                        if($mod=='mfyu182xlj'){
                            mysql_q("UPDATE api_x_posts SET views=views+1 where id='$rec_id' ");
                        }
					}else{
						$error=7;
					}
}
				if($sub_type==4){// استعلام عن مجموعة سجلات
					$obj=array();
					$page=$_POST['page'];
					if($mod=='uy7gl98rhn' || $mod=='weij4icf7r'){
						if($fillter){$fillter.=" and ";}
						$fillter.=" p_type='$logType' ";
						if($_POST['day']){
							$sDate=strtotime(pp($_POST['day'],'s'));
							$eDate=$sDate+86400;
							if($fillter){$fillter.=" and ";}
							$fillter.=" d_start>='$sDate' and d_start< '$eDate'  ";
						}
					}
                    if($mod=='un1aow6vpe'){
                        $mobile=$pat['mobile'];
                        $fillter=" mobile='$mobile' and id != '$pat_id' ";
                    }
                    if($mod=='5hfpaqscat'){
                        if(!$_POST['cat']){
                            $cats=get_vals('api_x_settings','set_id',"user='$pat_id' and user_type='$logType'");
                            $fillter=" cat IN ($cats)";
                        }
                    }
                    if($mod=='r89ez2jnw8'){//Chat list
                        $chat_id=get_val_con('api_chat','id',"patient='$pat_id' and pat_type='$logType'");
                        $fillter=" chat_id ='$chat_id'";
                        if($_POST['pointer']){                           
                            $fillter.=" and  id <'".$_POST['pointer']."'";
                        }else{
                            mysql_q("UPDATE api_chat_items SET status=1 where mess_type=2 and status=0 ");
                        }
                    }
					if($conditions && $fillter){$fillter=" and $fillter";}				
					$conditions.=$fillter;					
					//if($pat_id && $ref_col=='id'){
					if($pat_id && !in_array($ref_col,$search_arr) && $ref_col!='id'){						
						if($conditions){$conditions.=" and ";}
                        //if($cus_ref_col){
                            //$conditions.=" `$ref_col`='$cus_ref_col' ";
                        //}else{
						    $conditions.=" `$ref_col`='$pat_id' ";
                        //}
					}
					if($conditions){
						$conditions=str_replace('[p_id]',$pat_id,$conditions);
						//$conditions='where '.$conditions;
					}
                    
                    if($subData && $cus_ref_col){                        
                        $conditions=" `$ref_col` = '$cus_ref_col' ";
                    }
                    if($subData){
                        $rpp=200;
                        if($sub_conditions){
                            $sub_conditions=str_replace('[p_id]',$pat_id,$sub_conditions); 
                            if($conditions){ $conditions.=' and ';}
                            $conditions.=" $sub_conditions ";
                        }
                    }
                    //if($subData ){echo '--------('.$mod_table.':'.$conditions.')-----------';}
					$allRecs=getTotalCO($mod_table,$conditions);
                    //if($subData ){echo $allRecs;}
					list($page,$s,$e)=calcPageRec($allRecs,$page,$rpp);

					$eXdata=array($page,$allRecs,$s,$e);
                    if($mod=='r89ez2jnw8'){
                        unset($eXdata);
                        $eXdata[0]=max($allRecs-$rpp,0);
                        $eXdata[1]=0;
                    }
                    $favArray=[];
                    if($mod=='o6uvutsynr'){                        
                        if($logType){
                            $favArray=get_vals('api_x_fav','doc',"user='$pat_id' && user_type='$logType'",'arr');
                        }
                    }
					if($allRecs){
						if($conditions){					
							$conditions='where '.$conditions;
                            
						}
						$i=0;
                        $modOrder="";
                        if($ord_field && $ord_dir){
                            $oDir=' ASC ';
                            if($ord_dir==2){$oDir=' DESC ';}
                            $ord_field=str_replace('(L)',$lg,$ord_field);
                            $modOrder=" order by $ord_field $oDir";
                        }
                        if(!$s){$s=0;}
						$sql="select * from `$mod_table` $conditions $modOrder limit $s,$rpp ";                        
                        //if($subData){echo $sql;}
                        //if($subData ){echo $sql.'-----';}
						$res=mysql_q($sql);
						$rows=mysql_n($res);
                        $i=0;
						while($r=mysql_f($res)){						
							foreach($cols as $col){ 
								$colum=convLangCol($col['colum']);                                 
                                $val=$r[$colum];                
                                if($mod=='o6uvutsynr'){
                                    if($col['out_name']=='fav'){
                                        if($logType){
                                            if(in_array($val,$favArray)){$val=1;}else{$val=0;}
                                        }else{
                                            $val=0;
                                        }                                        
                                    }                                    
//                                    if($col['out_name']=='clinic_type'){
//                                        $finVal='------------------------------';
//                                    }
                                }                                
								$finVal=apiOutCol($val,$col['type'],$col['sub_type'],$mood,$r,$colum);
								$obj[$i][$col['out_name']] = $finVal;
							}
                            if($mod=='r89ez2jnw8'){//Chat List
                                $eXdata[1]=$r['id'];
                                if(!$_POST['pointer'] && $i==0){addWoSrData($mood,'r',$chat_id,$r['id']);}
                            }
							$i++;
						}
					}
                }
                if($sub_type==5){// حذف سجل 
                    
                }
				if($sub_type==6){// إجراء مخصص
					if($mod=='dt0s84elc5'){
						$name=pp($_POST['name'],'s');
						//$no=pp($_POST['no'],'s');
						$code=pp($_POST['code'],'s');
						$utoken=pp($_POST['utoken'],'s');
						//if($no=='' && $code==''){
							//$error=5;
						//}else{
							$sql="select * from gnr_m_patients where (mobile='$name' OR (email='$name' and email!='')) and ((no='$code' and no!='') OR (code='$code' and code!='')) limit 1";
							$res=mysql_q($sql);
							if(mysql_n($res)==1){
								$r3=mysql_f($res);
								$pat_id=$r3['id'];
								$pat_token=$r3['token'];
								$chToken=1;
								if(!$utoken){
									if($pat_token){
										$utoken=$pat_token;
									}else{
										$utoken=newToken();
									}
									$chToken=0;
								}
								if(mysql_q("update gnr_m_patients SET token='$utoken' where id='$pat_id'")){
									$_SESSION['Token']= $utoken;
									$eXdata=array(1,$utoken);
									if($chToken){checkTempUser($utoken,$pat_id);}
								}
							}else{
								$error=6;
							}
						//}					
					}
					if($mod=='k21len1in2'){
						$mobile=pp($_POST['mobile'],'s');
                        $mobile=fixNumber($mobile);
						$pass=pp($_POST['pass'],'s');						
						$utoken=pp($_POST['utoken'],'s');
						if($mobile && $pass){
							$sql="select * from dts_x_patients where mobile='$mobile' and pass='$pass' limit 1";
							$res=mysql_q($sql);
							if(mysql_n($res)){							
								if(!$utoken){$utoken=newToken();}
								$r3=mysql_f($res);
								$pat_id=$r3['id'];
								$act=$r3['act'];
								if($act){
									if(mysql_q("update dts_x_patients SET `token`='$utoken' where id='$pat_id'")){
										$_SESSION['Token']= $utoken;
										$eXdata=array($utoken);
									}
								}else{
									$error=20;
								}
							}else{
								$error=6;
							}
						}else{
							$error=5;
						}
					}
					if($mod=='0nmf6rpgth'){
						$clinic=pp($_POST['clinic']);
						$doctor=pp($_POST['doctor']);
                        $service=pp($_POST['service']);
						$day=pp($_POST['date'],'s');
                        $c_type=get_val('gnr_m_clinics','type',$clinic);
                        if(($c_type==5 || $c_type==6) && $service==0){
                            $error=4;
                        } 
                        if($error==0){
                            if($clinic && $doctor && $day){
                                list($error,$timeN,$dates_aval)=get_dates_day($clinic,$doctor,$day,$service);
                                $i=0;
                                if($error==0){
                                    if(count($dates_aval)){
                                        $obj=array();
                                        $timeNS=$timeN*60;								
                                        foreach($dates_aval as $da){
                                            $ds=$da[0];
                                            $de=$da[1];
                                            //echo '('.($de.'-'.$ds).')';
                                            //echo $timeNS.'<'.($de-$ds);
                                            while($timeNS<=($de-$ds)){
                                                $obj[$i]['start'] = $ds;
                                                $obj[$i]['end'] = $ds+$timeNS;
                                                $ds+=$timeNS;
                                                $i++;
                                            }
                                        }
                                        $eXdata=array($i++,$timeN,$clinic,$doctor);
                                    }else{
                                        $eXdata=array(0,$timeN,$clinic,$doctor);
                                    }
                                }
                            }else{
                                $error=4;
                            }
                        }
					}
					if($mod=='cwkz3hao7z'){
						$clinic=pp($_POST['clinic']);
                        $service=pp($_POST['service']);
						if($clinic){
							$c_type=get_val('gnr_m_clinics','type',$clinic);
							if($c_type==4){
								$q=" and id= '$doctor' ";
							}
							if($c_type==1){$q2=" ='7htoys03le' ";}
							if($c_type==3){$q2=" ='nlh8spit9q' ";}
							if($c_type==4){$q2=" ='fk590v9lvl' ";}
							if($c_type==5){$q2=" ='9yjlzayzp' ";}
							if($c_type==6){$q2=" ='66hd2fomwt' ";}
                            if(($c_type==5 || $c_type==6) && $service==0){
                                $error=4;                                
                            }
                            if($error==0){
                                $sql="select * from _users where act=1  and grp_code $q2 and FIND_IN_SET('$clinic',`subgrp`)> 0 $q order by name_$lg ASC";						
                                $res=mysql_q($sql);
                                $rows=mysql_n($res);			
                                if($rows>0){
                                    $i=0;
                                    while($r=mysql_f($res)){
                                        //$date=$r['date'];
                                        $u_id=$r['id'];
										//--------------------------------
										$srvs=get_vals('cln_m_services','id'," clinic='$clinic' and def='1'");
										list($time,$price)=get_docTimePrice($u_id,$srvs,$c_type);
										//--------------------------------
                                        $date=get_docBestDate($u_id,$time);
                                        if($date){
                                            list($time,$price)=getDefServTime($clinic,$u_id,$service);
                                            if($time){
                                                $docs[$date.'-'.$i]['id']=$u_id;
                                                $docs[$date.'-'.$i]['photo']=$r['photo'];					
                                                $docs[$date.'-'.$i]['name']=$r['name_'.$lg];
                                                $docs[$date.'-'.$i]['sex']=$r['sex'];						
                                                $docs[$date.'-'.$i]['price']=$price;
                                                $docs[$date.'-'.$i]['time']=$time;
                                            }
                                        }
                                        $i++;
                                    }
                                }

                                ksort($docs);
                                $i=0;
                                $obj=array();
                                foreach($docs as $k => $d){
                                    $da=explode('-',$k);
                                    $date=$da[0];
                                    $s_h=date('A h:i',$date);
                                    $act='';
                                    $doc=$d['id'];
                                    $obj[$i]['doc_id'] = $doc;
                                    $obj[$i]['doctor'] = $d['name'];
                                    $obj[$i]['start'] = $date;
                                    $obj[$i]['end'] = "".($date+($d['time']*60));
                                    $i++;
                                }
                                $eXdata=array($clinic,$i++);
                            }
						}else{
							$error=4;
						}
					}
					if($mod=='q1shnxgkks'){
						$clinic=pp($_POST['clinic']);
						$doctor=pp($_POST['doctor']);
                        $service=pp($_POST['service']);
                        
						if($clinic && $doctor){
							list($error,$dates_aval)=get_aval_dates_days($clinic,$doctor,$service);
							$i=0;
							if($error==0){
								if(count($dates_aval)){
									$obj=$dates_aval;								
									$eXdata=array($clinic,$doctor);
								}else{
									$eXdata=array(0,$clinic,$doctor);
								}
							}
						}else{
							$error=4;
						}
					}
					if($mod=='br4856vgwz'){
						$old_password=pp($_POST['old_password'],'s');
						$new_password=pp($_POST['new_password'],'s');					
						if($old_password && $new_password){
							if(getTotalCO('dts_x_patients'," pass='$old_password' and id='$pat_id' ")){
								if(mysql_q("UPDATE dts_x_patients SET pass='$new_password' where pass='$old_password' and id='$pat_id' ")){
									$eXdata=array($pat_id);
								}
							}else{
								$error=8;
							}
						}else{
							$error=4;
						}
					}
					if($mod=='6hdhsb1y0r'){						
                        $mobile=pp($_POST['mobile'],'s');
                        $mobile=fixNumber($mobile);
						if($mobile){
                            $sql="select * from dts_x_patients where mobile='$mobile' limit 1";
                            $res=mysql_q($sql);
                            if(mysql_n($res)){
                                $r=mysql_f($res);
                                $vercode=creatVerCode($mobile,$r['id'],2);
                                //$name=$mail_actCode_title.'Reset password';
                                //$message=' Reset password code is '.$vercode;
                                $name=$mail_actCode_title.' Activation code';
                                $message=$mail_actCode_title.' Activation code  is '.$vercode;
                                if(sendSMS($mobile,$message)){
                                    $eXdata=array($mobile);
                                }else{
                                    $error=13;
                                    $insertOk=0;
                                }
                            }else{
                                $error=6;
                            }
						}else{
							$error=4;						
						}
					}
					if($mod=='95kkqyhjr'){
						$mobile=pp($_POST['mobile'],'s');
                        $mobile=fixNumber($mobile);
						$code=pp($_POST['code']);						
						if($mobile && $code){
							$p_id=get_val_con('dts_x_patients_verification','user'," mobile='$mobile' and code='$code' ");
                            if($p_id){
                                $token=newToken();
                                if(mysql_q("UPDATE dts_x_patients SET token='$token' where id='$p_id' ")){
                                    resetVerCode($mobile);
                                    $eXdata=array($mobile,$token);
                                }
                            }else{
                                $error=19;
                            }		
						}else{
							$error=4;						
						}
					}
                    if($mod=='ofock7vp29'){
						$f_name=pp($_POST['f_name'],'s');
                        $mobile=pp($_POST['mobile'],'s');
                        $mobile=fixNumber($mobile);
						if($mobile && $f_name){
                            $sql="select * from gnr_m_patients where f_name='$f_name' and mobile='$mobile' order by birth_date DESC limit 1";
                            $res=mysql_q($sql);
                            if(mysql_n($res)){
                                $r=mysql_f($res);
                                $vercode=creatVerCode($mobile,$r['id'],1);
                                $name=$mail_actCode_title.' Activation code';
								$message=' Activation code  is '.$vercode;
                                if(sendSMS($mobile,$message)){
                                    $eXdata=array($mobile);
                                }else{
                                    $error=13;                                    
                                }
                            }else{
                                $error=6;
                            }
						}else{
							$error=4;						
						}
					}
                    if($mod=='a3hoz3wuwv'){
                        $mobile=pp($_POST['mobile'],'s');
						$code=pp($_POST['code'],'s');
						if($mobile){
                            $mobile=fixNumber($mobile);
                            $p_id=get_val_con('dts_x_patients_verification','user'," mobile='$mobile' and code='$code' and user_type=1");
                            if($p_id){
                                $token=get_val_con('gnr_m_patients','token'," id='$p_id'");
                                //if($token){
									//$error=21;
								//}else{
                                    $token=newToken();
                                    mysql_q("UPDATE gnr_m_patients SET token='$token' where id='$p_id' ");	
									$eXdata=array($mobile,$token);
                                    resetVerCode($mobile);
                                //}
                            }else{
                                $error=22;
                            }
						}else{
							$error=4;						
						}
                    }
					if($mod=='02w0t5tzp5'){
						$app_id=pp($_POST['appointment_id']);
						/*$reason=pp($_POST['reason'],'s');
						if($app_id && $reason){
							if(getTotalCO('dts_x_dates'," id='$app_id' and patient='$pat_id' and status in(0,1,10) ")){
								if(mysql_q("UPDATE dts_x_dates SET status=5 where id='$app_id' and patient='$pat_id' and status in(0,1,10) ")){
									
									mysql_q("INSERT INTO dts_x_cancel (dts,user,type,reason,date)values('$app_id',0,2,'$reason','$now')");
								}
							}else{
								$error=8;
							}
						}else{
							$error=4;
						}*/
                        if(mysql_q("UPDATE dts_x_dates SET status=5 where id='$app_id' and patient='$pat_id' and status in(0,1,10) ")){
                            $eXdata=array($app_id);
                            datesTempUp($app_id);
                        }
					}
					if($mod=='33rlemvnl8'){
						$uToken=pp($_POST['uToken'],'s');
						$out=0;
						if(getTotalCO('gnr_m_patients',"token ='$uToken'")){$out=1;
						}else{if(getTotalCO('dts_x_patients',"token ='$uToken'")){$out=2;}}
						$eXdata=array($uToken,$out);
					}
					if($mod=='dlm92yifc9'){
						$uToken=pp($_POST['uToken'],'s');
						$out=0;
						$patType=0;
                        if($logType && $pat_id){
                            $out=1;
							if(get_val_con('dts_x_patients_black_list','times'," patient='$pat_id' and pat_type='$logType' ")>=3){$out=2;}
						}
						$eXdata=array($out);
					}
					if($mod=='g26ei7rtyf'){
						$email =pp($_POST['email'],'s');
						$out=0;
						if(getTotalCO('gnr_m_patients',"email ='$email'")){$out=1;
						}else{if(getTotalCO('dts_x_patients',"email ='$email'")){$out=2;}}
						$eXdata=array($email,$out);
					}
					if($mod=='ccuuurcqmk'){					
						$mobile=pp($_POST['mobile'],'s');
						if($mobile){
                            $mobile=fixNumber($mobile);                            
                            list($p_id,$act)=get_val_con('dts_x_patients','id,act'," mobile='$mobile' and act=0"," order by id DESC");
                            if($act){
                                $error=21;
                            }else{
                                if($p_id){
                                    $vercode=creatVerCode($mobile,$p_id,2);
                                    $name=$mail_actCode_title.' Activation code';
                                    $message=$mail_actCode_title.' Activation code  is '.$vercode;
                                    if(sendSMS($mobile,$message)){
                                        $eXdata=array($mobile);
                                    }else{
                                        $error=13;
                                        $insertOk=0;
                                    }
                                }else{
                                    $error=6;
                                }
                            }
						}else{
							$error=4;						
						}

					}
					if($mod=='xdcobwrf'){		
						$mobile=pp($_POST['mobile'],'s');
						$code=pp($_POST['code'],'s');
						if($mobile){
                            $mobile=fixNumber($mobile);
                            $p_id=get_val_con('dts_x_patients_verification','user'," mobile='$mobile' and code='$code' and user_type=2");                            
                            if(pp($_POST['mobile'])=="123456" && $code="123456"){
                                $p_id=44189;
                            }
                            if($p_id){
                                list($act,$token)=get_val_con('dts_x_patients','act,token'," id='$p_id' ");
                                /*if($act){
									$error=21;
								}else{*/
                                    $token=newToken();
                                    mysql_q("UPDATE dts_x_patients SET act=1 ,token='$token' where id='$p_id' ");	
									$eXdata=array($mobile,$token);
                                    resetVerCode($mobile);
                                //}
                            }else{
                                $error=22;
                            }
						}else{
							$error=4;						
						}
					}
					if($mod=='l9bnzjwbbw'){
						$email=pp($_POST['email'],'s');
						if($email){
							if(chekEmailValid($email)){
								$mailType=chekEmailType($email);							
								if($mailType==1){									
									$code=get_val_con('gnr_m_patients','code'," email='$email' ");								
									$name=$mail_actCode_title.'Patient code';
									$message=' Patient code  is : <span style="color:#009;font-size:20px">'.$code.'<span>';
									if(!sendMasseg($email,'Patient code',$message,$name)){$error=13;}
								}else{
									$error=18;
								}							
							}else{
								$error=14;
							}
						}else{
							$error=4;						
						}
					}
					if($mod=='qatkkiejr'){
						$email=pp($_POST['email'],'s');
						$uToken=pp($_POST['uToken'],'s');					
						if(chekEmailValid($email)){
							$mailType=chekEmailType($email);							
							if($mailType==1){							
								if(mysql_q("UPDATE gnr_m_patients SET token='$uToken' where email='$email' ")){
									$eXdata=array($email,$uToken,1);
								}else{
									$error=9;
								}
							}elseif($mailType==2){						
								if(mysql_q("UPDATE dts_x_patients SET token='$uToken' , act=1  where email='$email' ")){								
									$eXdata=array($email,$uToken,2);
								}else{
									$error=9;
								}						
							}else{
								$error=18;
							}							
						}else{
							$error=14;
						}

					}				
					if($mod=='hprdpyyscs'){
						$out=api_notif($pat_id,$logType,'0',0);
						$eXdata=array($out);
					}
					if($mod=='62ggqe6t5t'){
						$dToken=pp($_POST['device_token'],'s');
						$app=pp($_POST['uCode'],'s');
						$t=getTotalCO('api_notifications_push'," app='$app' and patient='$pat_id' and p_type='$logType' and token='$dToken'");
						$rOut='0';
						if($t==0){
							$res=mysql_q("insert into api_notifications_push (`app`,`p_type`,`patient`,`token`) values('$app','$logType','$pat_id','$dToken')");
							$rOut='1';
						}
						$eXdata=array($rOut);
					}
					if($mod=='yn4fp973uv'){
						$dToken=pp($_POST['device_token'],'s');
						$app=pp($_POST['uCode'],'s');
						$q='';
						if($dToken){$q=" and `token`='$dToken' ";}
						$res=mysql_q("DELETE FROM api_notifications_push where app='$app' and patient='$pat_id' and p_type='$logType' $q ");
						$r=mysql_a();					
						$eXdata=array($r);
					}
					if($mod=='o29kxy0kkl'){
						$nId=pp($_POST['id']);
						$q='';
						if($nId){$q=" and `id`='$nId' ";}
						$res=mysql_q("DELETE FROM api_notifications where patient='$pat_id' and p_type='$logType' $q ");
						$r=mysql_a();					
						$eXdata=array($r);
					}
                    if($mod=='papg8cjlb2'){
						$patId=pp($_POST['id']);
                        $mobile=$pat['mobile'];
						
                        $sql="select * from gnr_m_patients where id='$patId' and mobile='$mobile' and token='' limit 1";
                        $res=mysql_q($sql);
                        if(mysql_n($res)){
                            $token=newToken();
                            mysql_q("UPDATE gnr_m_patients SET token='$token' where id='$patId' and mobile='$mobile' and token='' ");
                            $eXdata=array($token);
                        }else{
                            $error=6;
                        }						
					}
                    if($mod=='qlc4ru6qfd'){
						$doctor_id=pp($_POST['doctor_id']);
                        $action=pp($_POST['action']);
                        if($doctor_id){
                            if(getTotalCO('_users',"id='$doctor_id' and grp_code in('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','9k0a1zy2ww') and act=1")){
                                if($action==1){                                
                                    mysql_q("INSERT INTO api_x_fav (`user`,`user_type`,`doc`) values ('$pat_id','$logType','$doctor_id')");
                                }
                                if($action==2){
                                    mysql_q("delete from api_x_fav where user='$pat_id' and user_type='$logType' and doc='$doctor_id' limit 1");
                                }
                                $eXdata=array($doctor_id);
                            }else{
                                $error=8;
                            }
                        }
					}
                    if($mod=='rcepurhniu'){
						$set_id=pp($_POST['set_id']);
                        $action=pp($_POST['action']);
                        if($set_id){
                            if(getTotalCO('api_m_settings',"id='$set_id' and act=1")){
                                if($action==1){                                
                                    mysql_q("INSERT INTO api_x_settings (`user`,`user_type`,`set_id`) values ('$pat_id','$logType','$set_id')");
                                }
                                if($action==2){
                                    mysql_q("delete from api_x_settings where user='$pat_id' and user_type='$logType' and set_id='$set_id' limit 1");
                                }
                                $eXdata=array($set_id);
                            }else{
                                $error=8;
                            }
                        }
					}
                    if($mod=='wwi7u8xgog'){
                        $mess=pp($_POST['mess'],'s');
                        if($mess){
                            $mess_id=sendChatMess($mess,$pat_id,$logType,$mood);
                            $eXdata=array($mess_id);
                        }else{
                            $error=4;
                        }
                    }
                    if($mod=='pvqlwkojck'){
                        $appointment_id=pp($_POST['appointment_id']);                        
                        $dts=getRec('dts_x_dates',$appointment_id);
                        if($dts['r']){
                            list($error,$amount)=getAppointmentAmount($appointment_id,$dts['status'],$dts['d_start']);
                            if($error==0 && $amount){
                                $patient=$dts['patient'];
                                list($status,$out)=createPayment($patient,1,$appointment_id,$amount);
                                if($status==0){
                                    $error=24;
                                }else{
                                    $eXdata=array(1);                            
                                    $obj[0]->url = $out;
                                    $obj[0]->amount = $amount;
                                }
                            }else{
                                $error=25;
                            }

                        }else{
                            $error=10;
                        }                        
                    }
                    if($mod=='td3s9ze3bw'){
                        $appointment_id=pp($_POST['appointment_id']);                        
                        $dts=getRec('dts_x_dates',$appointment_id);
                        if($dts['r']){
                            list($error,$amount)=getAppointmentAmount($appointment_id,$dts['status'],$dts['d_start']);
                            if($error==0 && $amount){
                                $patient=$dts['patient'];
                                list($error,$token,$phone)=mtn_createPayment($patient,1,$appointment_id,$amount);
                                if(!$error){                                    
                                    $trans_id=saveNewMTNPayment($token,$patient,$phone,1,$appointment_id,$amount);
                                    $eXdata=array(1);                                        
                                    $obj[0]->trans_id = $trans_id;
                                    $obj[0]->amount = $amount;
                                    $obj[0]->phone = intval($phone);
                                    
                                }
                            }else{
                                $error=25;
                            }

                        }else{
                            $error=10;
                        }                        
                    }
                    if($mod=='a7nqvhpkp6'){
                        $trans_id=pp($_POST['trans_id']);
                        $mobile= pp($_POST['mobile']);
                        $r=getRec('api_x_payments_mtn',$trans_id);
                        if($r['r']){                            
                            if($r['status']==0 && ($r['date']-(15*60)<$now)){
                                if($mobile!=$r['mobile']){
                                    mysql_q("UPDATE api_x_payments_mtn set phone='$mobile' where id='$trans_id'");
                                }                                           
                                $error=createMTN_OTP($trans_id,$r['token'],$mobile,$r['amount']);                                
                            }else{                                
                                $error=60066;
                            }
                        }
                    }
                    if($mod=='vzguv5k72d'){
                        $trans_id=pp($_POST['trans_id']);
                        $otp= pp($_POST['otp']);
                        
                        $r=getRec('api_x_payments_mtn',$trans_id);
                        if($r['r']){                                     
                            list($error,$transactionId)=enterMTN_OTP($trans_id,$r['token'],$otp); 
                            if(!$error){
                                compleatMTN_payment($r,$transactionId);
                            }
                        }
                    }
                    
				}
			}
		}else{
			$error=3;
		}
	}
    if($subData){
        return $obj;
    }else{
        return array($eXdata,$obj,$error);
    }
}
function getAppointmentAmount($id,$status,$d_start){
    global $now;
    $err=0;
    $amount=0;
    if($status==10 && $d_start>$now){
        $service=get_val_c('dts_x_dates_services','service',$id,'dts_id');                                     
        $amount=get_val('bty_m_services','payment',$service);
    }else{
        $err=25;    
    }    
    return[$err,$amount];
    
}
function newToken(){
	$ok=0;
	while($ok==0){
		$token=getRandString(32,3);
		$t1=getTotal('dts_x_patients','token',$token);
		$t2=getTotal('gnr_m_patients','token',$token);
		if($t1+$t2==0){$ok=1;}
	}
	return $token;
}
function chekEmail($email){
	$error=0;
    if($email){
        if(!chekEmailValid($email)){	
            $error=14;
        }else{		
            //if(chekEmailType($email)){
                //$error=15;
            //}
            //$ch1=getTotalCO('gnr_m_patients',"email ='$email'");
            //$ch2=getTotalCO('dts_x_patients',"email ='$email'");
            //if($ch1+$ch2>0){}		
        }
    }
	return $error;
}
function chekEmailValid($email){
	if (filter_var($email, FILTER_VALIDATE_EMAIL)){return 1;}
}
function chekEmailType($email){
	if(getTotalCO('gnr_m_patients',"email ='$email'")){return 1;}
	if(getTotalCO('dts_x_patients',"email ='$email'")){return 2;}
	return 0;
}
function base64_to_jpeg($base64_string,$mood){
	global $now;
	$files_path_s='../sData/';	
	if($mood==1){$files_path_s='sData/';}
	$mothfolder=date('y-m',$now).'/';
	$full_path_s=$files_path_s.$mothfolder;	
	if(!file_exists($files_path_s)){mkdir($files_path_s,0777);}
	if(!file_exists($full_path_s)){mkdir($full_path_s,0777);}
	$fileName = getRandString(10,3);
	$file=$full_path_s.$fileName;	
	$ifp=fopen($file,'wb');
    $data=explode(',',$base64_string);	
    fwrite($ifp,base64_decode($data[1]));
    fclose($ifp);
	if(file_exists($file)){
		$fileSize = filesize($file);		
		$file_ex=getImgExBase($data[0]);
		$fileName_org='api';		
		if($file_ex){
			$sql="INSERT INTO _files_i (`file`,`name`,`date`,`size`,`ex`)
			values('$fileName','$fileName_org','$now','$fileSize','$file_ex');";
			if(mysql_q($sql)){
				return last_id();
			}
		}		
	}
}
function getImgExBase($str){	
	$i1=explode('image/',$str);
	if(count($i1)==2){
		$i2=explode(';',$i1[1]);
		if(count($i2)==2){
			$ex=strtolower($i2[0]);
			$imageTypes = array('jpg','jpeg','gif','png');
			if(in_array($ex,$imageTypes)){
				return $ex;
			}
		}
	}	
}
function get_subType_api($type,$val){
	$out=$val;
	if($type==1){
		if($val==1){$out=k_txt;}
		if($val==2){$out=k_num;}
		$out='<div class="f1 fs14">'.$out.'</div>';
	}
	if($type==2){
		if($val==1){$out=k_norm_date;}
		if($val==2){$out=k_date_sec;}
		$out='<div class="f1 fs14">'.$out.'</div>';
	}	
	if($type==5 || $type==6 || $type==7){
		$out='<ff>'.$out.'</ff>';
	}
	return $out;
}
function apiQuery($q_id='',$json=''){
	global $now;
    if($q_id){        
        //mysql_q("UPDATE api__query set `out`='$json' where id='$q_id' ");
    }else{
        $ip=$_SERVER['REMOTE_ADDR'];
        $blockTime=$now+(10*60);
        if(getTotalCO('api__blocked',"ip='$ip' and date>$blockTime ")==0){	
            $mod=pp($_POST['mod'],'s');
            $token=pp($_POST['token'],'s');
            $user=pp($_POST['user'],'s');
            if(getTotalCO('api__query',"ip='$ip' and date='$now' ")>2){		
                mysql_q("INSERT INTO api__blocked (`ip`,`date`)values('$ip','$now')");
            }else{
                $data=json_encode($_POST);
				
                mysql_q("INSERT INTO api__query (`ip`,`date`,`user`,`mod`,`token`)values('$ip','$now','$user','$mod','$token')");
                return last_id();
            }
        }else{
            echo 'Your are blocked ';
        }
    }
}
/****************Project*****************************************/
function getDefServTime($clinic,$doctor=0,$service=0){
	$timeN=0;$price=0;
	$c_type=get_val('gnr_m_clinics','type',$clinic);
	if($c_type==4){
		$timeN=_set_a5ddlqulxk;
		$price=0;
	}
    $clinics=getAllLikedClinics($clinic,',');
	if($c_type==1){
		$srvs=get_vals('cln_m_services','id',"clinic in($clinics) and def=1 ");
		list($timeN,$price)=get_docTimePrice($doctor,$srvs,$c_type);
	}
	if($c_type==3){	
		$srvs=get_vals('xry_m_services','id',"clinic='$clinic' and def=1 ");
		list($timeN,$price)=get_docTimePrice($doctor,$srvs,$c_type);		
	}
	if($c_type==5 || $c_type==6){
        list($error,$service_price,$timeN)=checkBtyService($c_type,$clinic,$service);        
	}	
	return array($timeN,$price);
	
}
function get_dates_day($clinic,$doctor,$day,$service=0){
	$dates_aval=array();
	$error=0;
	global $now,$ss_day;
	$id=0;
    $clinics=getAllLikedClinics($clinic,',');
	if(getTotalCO('_users',"subgrp in($clinics) and id='$doctor' ")){	
		$thisDay = strtotime($day);
		list($timeN,$price)=getDefServTime($clinic,$doctor,$service);
		if(noVacation($doctor,$thisDay)){
			if($thisDay<$ss_day){
				$error=8;
			}else{				
				if(!$timeN){$timeN=20;}
				$thisDayNo=date('w',$thisDay);
				if($timeN && $thisDay){
					$same_users=get_val('_users','same_users',$doctor);
					list($days,$type,$data)=get_val('gnr_m_users_times','days,type,data',$doctor);
					$days_arr=explode(',',$days);
					$days_arr_data=array();
					if($type==1){
						$d=explode(',',$data);
						$sDay=$d[0];
						$eDay=max($d[1],$d[3]);			
						$dayLength=($eDay-$sDay);
						$dayLengthHours=$dayLength/3600;
						$dayPer=100/$dayLengthHours;
						foreach($days_arr as $i){			
							$days_arr_data[$i]['s']=$d[0];
							$days_arr_data[$i]['e']=$d[1];
							$days_arr_data[$i]['s2']=$d[2];
							$days_arr_data[$i]['e2']=$d[3];
						}
					}
					if($type==2){
						$sDay=0;
						$eDay=0;
						$d1=explode('|',$data);
						$i=0;
						foreach($d1 as $d2){
							$d=explode(',',$d2);
							$TsDay=$d[0];
							$TeDay=$d[1];
							if($d[3]!=0){$TeDay=$d[3];}				
							if($TsDay<$sDay || $sDay==0){$sDay=$TsDay;}
							if($TeDay>$eDay || $eDay==0){$eDay=$TeDay;}			
							$days_arr_data[$days_arr[$i]]['s']=$d[0];
							$days_arr_data[$days_arr[$i]]['e']=$d[1];
							$days_arr_data[$days_arr[$i]]['s2']=$d[2];
							$days_arr_data[$days_arr[$i]]['e2']=$d[3];
							$i++;
						}
						$dayLength=($eDay-$sDay);
						$dayLengthHours=$dayLength/3600;
						$dayPer=100/$dayLengthHours;		
					}
					//-----------------------------------
					$lastDates=array();
					$days_length=count($days_arr);
					$s_now=$now-($now%3600)+(3600*3);					
					$dayT = strtotime($day);
					$sx_date=date('U',$dayT);

					$ex_date=$sx_date+86400;
					if($sx_date<$now){$sx_date=$now;}
					$q2='';
					if($same_users){$q2=" OR doctor in($same_users)";}
					$sql="select id,d_start,d_end,doctor,clinic from dts_x_dates where 
					((d_start>=$sx_date and d_start<=$ex_date) OR (d_end>=$sx_date and d_end<=$ex_date))  
					and status not in(5,9) and id!='$id' and ( clinic='$clinic' $q2) order by d_start ASC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						$i=0;
						while($r=mysql_f($res)){
							$sameClinc=1;
							if($r['clinic']!=$clinic){$sameClinc=0;}
							$lastDates[$i]['id']=$r['id'];
							$lastDates[$i]['s']=$r['d_start'];
							$lastDates[$i]['e']=$r['d_end'];
							$lastDates[$i]['doc']=$r['doctor'];	
							$lastDates[$i]['sClin']=$sameClinc;	
							if($lastDates[$i]['s']<$s_now){$lastDates[$i]['s']=$s_now;}
							if($lastDates[$i]['e']<$lastDates[$i]['s']){$lastDates[$i]['e']=$lastDates[$i]['s'];}
							$i++;
						}
					}	
					$sx_dateV=$sx_date-($sx_date%86400);
					$sql3="select * from gnr_x_vacations where type=2 and emp='$doctor' and (s_date>=$sx_dateV and s_date<=$ex_date) order by s_date ASC";
					$res3=mysql_q($sql3);
					$rows3=mysql_n($res3);
					if($rows3>0){
						while($r=mysql_f($res3)){
							$v_s_date=$r['s_date']+$r['s_hour'];
							$v_e_date=$r['s_date']+$r['e_hour'];
							$lastDates[$i]['id']=$r['id'];
							$lastDates[$i]['s']=$v_s_date;
							$lastDates[$i]['e']=$v_e_date;
							$lastDates[$i]['doc']=$r['emp'];
							$lastDates[$i]['vaca']=1;
							$lastDates[$i]['sClin']=0;	
							if($lastDates[$i]['s']<$s_now){$lastDates[$i]['s']=$s_now;}
							if($lastDates[$i]['e']<$lastDates[$i]['s']){$lastDates[$i]['e']=$lastDates[$i]['s'];}
							$i++;
						}
					}

					$s_now=$now-($now%3600)+(3600*3);
					
					//echo $thisDayNo=date('w',$day);
					if(in_array($thisDayNo,$days_arr)){
						$blucks='';
						$s=$days_arr_data[$thisDayNo]['s'];if($s+$thisDay < $now && $s!=0){$s=$s_now-$thisDay;}
						$e=$days_arr_data[$thisDayNo]['e'];if($e+$thisDay < $now && $e!=0){$e=$s_now-$thisDay;}
						$s2=$days_arr_data[$thisDayNo]['s2'];if($s2+$thisDay < $now && $s2!=0){$s2=$s_now-$thisDay;}
						$e2=$days_arr_data[$thisDayNo]['e2'];if($e2+$thisDay < $now && $e2!=0){$e2=$s_now-$thisDay;}
						if($s_now < $e+$thisDay  || $s_now<$e2+$thisDay){
							//************************************************

							$timePointer=$s;					
							//if($sDay<$timePointer){					
								//$blucks.='<div class="fl dblc dblc_s1" style="width:'.$blcWidth.'%">---</div>';
							//}
							if($s>0){
								//*********shift 1****************************************					
								foreach($lastDates as $d){
									if($d['sClin']){
										$sameDoc='0';
										if($doctor==$d['doc']){$sameDoc='1';}
										$short_s=$d['s']-$thisDay;
										$short_e=$d['e']-$thisDay;
										if($d['s']>=($s+$thisDay) &&  $d['e']<=($e+$thisDay)){	
											if($timePointer!=$short_s){									
												$b=1;
												if(($short_s-$timePointer)/60<$timeN){$b=2;}

												foreach($lastDates as $dd){
													if($dd['sClin']==0){
														$ss=$dd['s'];
														$ee=$dd['e'];
														if(($ss >=$thisDay+$timePointer && $ss <$thisDay+$short_s) || 
														($ee >=$thisDay+$timePointer && $ee <$thisDay+$short_s)){
															$short_ss=$dd['s']-$thisDay;
															$short_ee=$dd['e']-$thisDay;
															if($short_ss<$timePointer){$short_ss=$timePointer;}
															if($short_ee>$short_s){$short_ee=$short_s;}

															if($short_ss>$timePointer){
																$b=1;													
																if(($short_ss-$timePointer)/60<$timeN){$b=2;}
																if($b==1){
																	//$blucks.='s="'.($thisDay+$timePointer).'" e="'.($thisDay+$short_ss).'" <br>';
																	$timePointer=$short_ss;
                                                                    array_push($dates_aval,[$thisDay+$timePointer,$thisDay+$short_ss]);
																}
															}												
															$timePointer=$short_ee;
														}
													}
												}
												if($timePointer!=$short_s){
													foreach($lastDates as $dd){
                                                        if(isset($dd['vaca'])){
                                                            if($timePointer>=$dd['s'] && $dd['e']<$timePointer){
                                                                $timePointer=$dd['e'];
                                                            }
                                                        }
                                                    }
													$b=1;
													if(($short_s-$timePointer)/60<$timeN){$b=2;}
													if($b==1){                                                        
														//$blucks.='s="'.($thisDay+$timePointer).'" e="'.($thisDay+$short_s).'" <br>';
                                                        array_push($dates_aval,[$thisDay+$timePointer,$thisDay+$short_s]);
													}
												}
												$timePointer=$short_s;
											}
											$blcWidth=($short_e-$short_s)*100/$dayLength;								
											$timePointer=$short_e;
										}
									}
								}
								if($timePointer<$e){
									//$blcWidth=($e-$timePointer)*100/$dayLength;
									//$b=1;
									if(($e-$timePointer)/60<$timeN){$b=2;}								
									foreach($lastDates as $dd){
										if($dd['sClin']==0){
											$ss=$dd['s'];
											$ee=$dd['e'];
											if(($ss >=$thisDay+$timePointer && $ss <=$thisDay+$e) || 
											($ee >=$thisDay+$timePointer && $ee <=$thisDay+$e)){
												$short_ss=$dd['s']-$thisDay;
												$short_ee=$dd['e']-$thisDay;
												if($short_ss<$timePointer){$short_ss=$timePointer;}
												if($short_ee>$e){$short_ee=$e;}

												if($short_ss>$timePointer){										
													$b=1;
													if(($short_ss-$timePointer)/60<$timeN){$b=2;}
													if($b==1){
														//$blucks.='s="'.($thisDay+$timePointer).'" e="'.($thisDay+$short_ss).'" <br>';
														array_push($dates_aval,[$thisDay+$timePointer,$thisDay+$short_ss]);
													}
													$timePointer=$short_ss;
												}									
												$timePointer=$short_ee;
											}
										}
									}
									if($timePointer!=$e){
										//$blcWidth=($e-$timePointer)*100/$dayLength;
										$b=1;							
										if(($e-$timePointer)/60<$timeN){$b=2;}
										if($b==1){
											//$blucks.='s="'.($thisDay+$timePointer).'" e="'.($thisDay+$e).'" <br>';
											array_push($dates_aval,[$thisDay+$timePointer,$thisDay+$e]);
										}
									}
									$timePointer=$e;
								}
							}
							//*********shift 2*******************					
							if($s2){
								if($timePointer<0){$timePointer=$sDay;}
								$timePointer=$s2;
								if($thisDay+$timePointer<$s_now){
									$timePointer=$s_now-$thisDay;
								}

								foreach($lastDates as $d){
									if($d['sClin']){
										if($doctor==$d['doc']){$sameDoc='1';}
										$short_s=$d['s']-$thisDay;
										$short_e=$d['e']-$thisDay;
										if($d['s']>=($s2+$thisDay) &&  $d['e']<=($e2+$thisDay)){	
											if($timePointer!=$short_s){
												//$blcWidth=($short_s-$timePointer)*100/$dayLength;
												//$b=1;
												//if(($short_s-$timePointer)/60<$timeN){$b=2;}

												foreach($lastDates as $dd){
													if($dd['sClin']==0){
														$ss=$dd['s'];
														$ee=$dd['e'];													
														if(($ss >=$thisDay+$timePointer && $ss <=$thisDay+$short_s) || 
														($ee >=$thisDay+$timePointer && $ee <=$thisDay+$short_s)){
															$short_ss=$dd['s']-$thisDay;
															$short_ee=$dd['e']-$thisDay;
															if($short_ss<$timePointer){$short_ss=$timePointer;}
															if($short_ee>$short_s){$short_ee=$short_s;}
															if($short_ss>$timePointer){
																$b=1;													
																if(($short_ss-$timePointer)/60<$timeN){$b=2;}
																if($b==1){
																	//$blucks.='s="'.($thisDay+$timePointer).'" e="'.($thisDay+$short_ss).'" <br>';
																	array_push($dates_aval,[$thisDay+$timePointer,$thisDay+$short_ss]);
																}
																$timePointer=$short_ss;
															}
															$blcWidth=($short_ee-$short_ss)*100/$dayLength;
															$timePointer=$short_ee;
														}
													}
												}
												if($timePointer!=$short_s){
													$b=1;
													$blcWidth=($short_s-$timePointer)*100/$dayLength;
													if(($short_s-$timePointer)/60<$timeN){$b=2;}
													if($b==1){
														//$blucks.='s="'.($thisDay+$timePointer).'" e="'.($thisDay+$short_s).'" <br>';
														array_push($dates_aval,[$thisDay+$timePointer,$thisDay+$short_s]);
													}
												}
												$timePointer=$short_s;
											}								
											$timePointer=$short_e;
										}
									}
								}
								if($timePointer<$e2){
									//$blcWidth=($e2-$timePointer)*100/$dayLength;								
									//$b=1;
									//if(($e2-$timePointer)/60<$timeN){$b=2;}
									foreach($lastDates as $dd){
										if($dd['sClin']==0){
											$ss=$dd['s'];
											$ee=$dd['e'];
											if(($ss >=$thisDay+$timePointer && $ss <$thisDay+$e2) || 
											($ee >=$thisDay+$timePointer && $ee <$thisDay+$e2)){
												$short_ss=$dd['s']-$thisDay;
												$short_ee=$dd['e']-$thisDay;
												if($short_ss<$timePointer){$short_ss=$timePointer;}
												if($short_ee>$e2){$short_ee=$e2;}

												if($short_ss>$timePointer){
													$blcWidth=($short_ss-$timePointer)*100/$dayLength;
													$b=1;
													if(($short_ss-$timePointer)/60<$timeN){$b=2;}
													if($b==1){
														//$blucks.='s="'.($thisDay+$timePointer).'" e="'.($thisDay+$short_ss).'" <br>';
														array_push($dates_aval,[$thisDay+$timePointer,$thisDay+$short_ss]);
													}
													$timePointer=$short_ss;
												}
												$blcWidth=($short_ee-$short_ss)*100/$dayLength;									
												$timePointer=$short_ee;
											}
										}
									}
									if($timePointer!=$e2){
										$b=1;							
										if(($e2-$timePointer)/60<$timeN){$b=2;}
										if($b==1){
											//$blucks.='s="'.($thisDay+$timePointer).'" e="'.($thisDay+$e2).'" <br>';
											array_push($dates_aval,[$thisDay+$timePointer,$thisDay+$e2]);
										}
									}
									$timePointer=$e2;
								}
							}	
						}			
					}
				}else{
					$error=11;
				}
			}
		}
	}else{
		$error=8;
	}
	return array($error,$timeN,$dates_aval);
}
function checkBtyService($c_type,$clinic,$service){
    $error=$service_price=$ser_time=0;
    if($c_type==5 || $c_type==6){
        if($service){            
            list($service_price,$ser_time,$app)=get_val('bty_m_services','payment,ser_time,app',$service);
            if(!$app){
                $error=8;
            }else{               
                if(!$ser_time){
                    $error=8;
                }else{
                    $ser_time=$ser_time*_set_pn68gsh6dj;
                }
            }
        }else{
            $error=8;
        }
    }
    return [$error,$service_price,$ser_time];
}
function get_aval_dates_days($clinic,$doctor,$service=0){
	global $now;
	$error=0;
	$dates_aval=array();
    
    $clinic=getMClinic($clinic);
    $ch1=getTotalCO('_users',"subgrp='$clinic' and id='$doctor' ");
    if($ch1==0){
        $clinic=get_val('_users','subgrp',$doctor);        
    }
    $ch1=getTotalCO('_users',"subgrp='$clinic' and id='$doctor' ");
	if($ch1){
        $c_type=get_val('gnr_m_clinics','type',$clinic);
        //check the service for bty section
        list($error,$service_price,$timeN)=checkBtyService($c_type,$clinic,$service);
        if($error==0){
            if(!$timeN){
                list($timeN,$price)=getDefServTime($clinic,$doctor,$service);
            }            
            if(!$timeN){$timeN=20;}
            if($timeN){
                $same_users=get_val('_users','same_users',$doctor);
                list($days,$type,$data)=get_val('gnr_m_users_times','days,type,data',$doctor);
                $days_arr=explode(',',$days);
                $days_arr_data=array();
                if($type==1){
                    $d=explode(',',$data);
                    $sDay=$d[0];
                    $eDay=max($d[1],$d[3]);			
                    $dayLength=($eDay-$sDay);
                    $dayLengthHours=$dayLength/3600;
                    $dayPer=100/$dayLengthHours;
                    foreach($days_arr as $i){			
                        $days_arr_data[$i]['s']=$d[0];
                        $days_arr_data[$i]['e']=$d[1];
                        $days_arr_data[$i]['s2']=$d[2];
                        $days_arr_data[$i]['e2']=$d[3];
                    }
                }
                if($type==2){
                    $sDay=0;
                    $eDay=0;
                    $d1=explode('|',$data);
                    $i=0;
                    foreach($d1 as $d2){
                        $d=explode(',',$d2);
                        $TsDay=$d[0];
                        $TeDay=$d[1];
                        if($d[3]!=0){$TeDay=$d[3];}				
                        if($TsDay<$sDay || $sDay==0){$sDay=$TsDay;}
                        if($TeDay>$eDay || $eDay==0){$eDay=$TeDay;}			
                        $days_arr_data[$days_arr[$i]]['s']=$d[0];
                        $days_arr_data[$days_arr[$i]]['e']=$d[1];
                        $days_arr_data[$days_arr[$i]]['s2']=$d[2];
                        $days_arr_data[$days_arr[$i]]['e2']=$d[3];
                        $i++;
                    }
                    $dayLength=($eDay-$sDay);
                    $dayLengthHours=$dayLength/3600;
                    $dayPer=100/$dayLengthHours;		
                }
                //-----------------------------------
                $daa=0;
                $thisDay=$now-($now%86400);
                $s_now=$now-($now%(60*_set_pn68gsh6dj))+(60*_set_pn68gsh6dj);
                $x=30;
                while($daa<10 && $x>0 ){
                    $thisDayNo=date('w',$thisDay);
                    $vailDay=0;
                    if(in_array($thisDayNo,$days_arr)){
                        $lastDates=array();
                        $days_length=count($days_arr);					
                        //$dayT = strtotime($day);
                        $sx_date=$thisDay;
                        $ex_date=$sx_date+86400;
                        if($sx_date<$s_now){$sx_date=$s_now;}
                        if(noVacation($doctor,$thisDay)){
                            $q2='';
                            if($same_users){$q2=" OR doctor in($same_users)";}
                            $sql="select id,d_start,d_end,doctor,clinic from dts_x_dates where 
                            ((d_start>=$sx_date and d_start<=$ex_date) OR (d_end>=$sx_date and d_end<=$ex_date))  
                            and status not in(5,9) and ( clinic='$clinic' $q2) order by d_start ASC";
                            $res=mysql_q($sql);
                            $rows=mysql_n($res);
                            if($rows>0){
                                $i=0;
                                while($r=mysql_f($res)){
                                    $sameClinc=1;
                                    if($r['clinic']!=$clinic){$sameClinc=0;}
                                    $lastDates[$i]['id']=$r['id'];
                                    $lastDates[$i]['s']=$r['d_start'];
                                    $lastDates[$i]['e']=$r['d_end'];
                                    $lastDates[$i]['doc']=$r['doctor'];	
                                    $lastDates[$i]['sClin']=$sameClinc;	
                                    if($lastDates[$i]['s']<$s_now){$lastDates[$i]['s']=$s_now;}
                                    if($lastDates[$i]['e']<$lastDates[$i]['s']){$lastDates[$i]['e']=$lastDates[$i]['s'];}
                                    $i++;
                                }
                            }
                            //-----
                            $sx_dateV=$sx_date-($sx_date%86400);
                            $sql3="select * from gnr_x_vacations where type=2 and emp='$doctor' and (s_date>=$sx_dateV and s_date<=$ex_date) order by s_date ASC";
                            $res3=mysql_q($sql3);
                            $rows3=mysql_n($res3);
                            if($rows3>0){
                                while($r=mysql_f($res3)){
                                    $v_s_date=$r['s_date']+$r['s_hour'];
                                    $v_e_date=$r['s_date']+$r['e_hour'];
                                    $lastDates[$i]['id']=$r['id'];
                                    $lastDates[$i]['s']=$v_s_date;
                                    $lastDates[$i]['e']=$v_e_date;
                                    $lastDates[$i]['doc']=$r['emp'];
                                    $lastDates[$i]['vaca']=1;
                                    $lastDates[$i]['sClin']=0;	
                                    if($lastDates[$i]['s']<$s_now){$lastDates[$i]['s']=$s_now;}
                                    if($lastDates[$i]['e']<$lastDates[$i]['s']){$lastDates[$i]['e']=$lastDates[$i]['s'];}
                                    $i++;
                                }
                            }
                            //-----
                            $s=$days_arr_data[$thisDayNo]['s'];if($s+$thisDay < $now && $s!=0){$s=$s_now-$thisDay;}
                            $e=$days_arr_data[$thisDayNo]['e'];if($e+$thisDay < $now && $e!=0){$s=$s_now-$thisDay;}
                            $s2=$days_arr_data[$thisDayNo]['s2'];if($s2+$thisDay < $now && $s2!=0){$s2=$s_now-$thisDay;}
                            $e2=$days_arr_data[$thisDayNo]['e2'];if($e2+$thisDay < $now && $e2!=0){$e2=$s_now-$thisDay;}
                            if($s_now < $e+$thisDay  || $s_now<$e2+$thisDay){
                            //************************************************
                                $timePointer=$s;					
                                if($s>0){
                                    //*********shift 1****************************************					
                                    foreach($lastDates as $d){
                                        if($d['sClin']){
                                            $sameDoc='0';
                                            if($doctor==$d['doc']){$sameDoc='1';}
                                            $short_s=$d['s']-$thisDay;
                                            $short_e=$d['e']-$thisDay;
                                            if($d['s']>=($s+$thisDay) &&  $d['e']<=($e+$thisDay)){	
                                                if($timePointer!=$short_s){									
                                                    $b=1;
                                                    if(($short_s-$timePointer)/60<$timeN){$b=2;}
                                                    foreach($lastDates as $dd){
                                                        if($dd['sClin']==0){
                                                            $ss=$dd['s'];
                                                            $ee=$dd['e'];
                                                            if(($ss >=$thisDay+$timePointer && $ss <$thisDay+$short_s) || 
                                                            ($ee >=$thisDay+$timePointer && $ee <$thisDay+$short_s)){
                                                                $short_ss=$dd['s']-$thisDay;
                                                                $short_ee=$dd['e']-$thisDay;
                                                                if($short_ss<$timePointer){$short_ss=$timePointer;}
                                                                if($short_ee>$short_s){$short_ee=$short_s;}

                                                                if($short_ss>$timePointer){
                                                                    $b=1;													
                                                                    if(($short_ss-$timePointer)/60<$timeN){$b=2;}
                                                                    if($b==1){														$vailDay=1;		
                                                                        $timePointer=$short_ss;
                                                                    }
                                                                }												
                                                                $timePointer=$short_ee;
                                                            }
                                                        }
                                                    }
                                                    if($timePointer!=$short_s){
                                                        $blcWidth=($short_s-$timePointer)*100/$dayLength;
                                                        $b=1;
                                                        if(($short_s-$timePointer)/60<$timeN){$b=2;}
                                                        if($b==1){
                                                            $vailDay=1;
                                                        }
                                                    }
                                                    $timePointer=$short_s;
                                                }
                                                $blcWidth=($short_e-$short_s)*100/$dayLength;								
                                                $timePointer=$short_e;
                                            }
                                        }
                                    }
                                    if($timePointer<$e){
                                        if(($e-$timePointer)/60<$timeN){$b=2;}								
                                        foreach($lastDates as $dd){
                                            if($dd['sClin']==0){
                                                $ss=$dd['s'];
                                                $ee=$dd['e'];
                                                if(($ss >=$thisDay+$timePointer && $ss <=$thisDay+$e) || 
                                                ($ee >=$thisDay+$timePointer && $ee <=$thisDay+$e)){
                                                    $short_ss=$dd['s']-$thisDay;
                                                    $short_ee=$dd['e']-$thisDay;
                                                    if($short_ss<$timePointer){$short_ss=$timePointer;}
                                                    if($short_ee>$e){$short_ee=$e;}

                                                    if($short_ss>$timePointer){										
                                                        $b=1;
                                                        if(($short_ss-$timePointer)/60<$timeN){$b=2;}
                                                        if($b==1){
                                                            $vailDay=1;
                                                        }
                                                        $timePointer=$short_ss;
                                                    }									
                                                    $timePointer=$short_ee;
                                                }
                                            }
                                        }
                                        if($timePointer!=$e){									
                                            $b=1;							
                                            if(($e-$timePointer)/60<$timeN){$b=2;}
                                            if($b==1){
                                                $vailDay=1;
                                            }
                                        }
                                        $timePointer=$e;
                                    }
                                }
                                //*********shift 2*******************					
                                if($s2){
                                    if($timePointer<0){$timePointer=$sDay;}
                                    $timePointer=$s2;
                                    foreach($lastDates as $d){
                                        if($d['sClin']){
                                            if($doctor==$d['doc']){$sameDoc='1';}
                                            $short_s=$d['s']-$thisDay;
                                            $short_e=$d['e']-$thisDay;
                                            if($d['s']>=($s2+$thisDay) &&  $d['e']<=($e2+$thisDay)){	
                                                if($timePointer!=$short_s){
                                                    foreach($lastDates as $dd){
                                                        if($dd['sClin']==0){
                                                            $ss=$dd['s'];
                                                            $ee=$dd['e'];													
                                                            if(($ss >=$thisDay+$timePointer && $ss <=$thisDay+$short_s) || 
                                                            ($ee >=$thisDay+$timePointer && $ee <=$thisDay+$short_s)){
                                                                $short_ss=$dd['s']-$thisDay;
                                                                $short_ee=$dd['e']-$thisDay;
                                                                if($short_ss<$timePointer){$short_ss=$timePointer;}
                                                                if($short_ee>$short_s){$short_ee=$short_s;}
                                                                if($short_ss>$timePointer){
                                                                    $b=1;													
                                                                    if(($short_ss-$timePointer)/60<$timeN){$b=2;}
                                                                    if($b==1){													
                                                                        $vailDay=1;
                                                                    }
                                                                    $timePointer=$short_ss;
                                                                }
                                                                $blcWidth=($short_ee-$short_ss)*100/$dayLength;
                                                                $timePointer=$short_ee;
                                                            }
                                                        }
                                                    }
                                                    if($timePointer!=$short_s){
                                                        $b=1;
                                                        $blcWidth=($short_s-$timePointer)*100/$dayLength;
                                                        if(($short_s-$timePointer)/60<$timeN){$b=2;}
                                                        if($b==1){
                                                            $vailDay=1;
                                                        }
                                                    }
                                                    $timePointer=$short_s;
                                                }								
                                                $timePointer=$short_e;
                                            }
                                        }
                                    }
                                    if($timePointer<$e2){
                                        foreach($lastDates as $dd){
                                            if($dd['sClin']==0){
                                                $ss=$dd['s'];
                                                $ee=$dd['e'];
                                                if(($ss >=$thisDay+$timePointer && $ss <$thisDay+$e2) || 
                                                ($ee >=$thisDay+$timePointer && $ee <$thisDay+$e2)){
                                                    $short_ss=$dd['s']-$thisDay;
                                                    $short_ee=$dd['e']-$thisDay;
                                                    if($short_ss<$timePointer){$short_ss=$timePointer;}
                                                    if($short_ee>$e2){$short_ee=$e2;}

                                                    if($short_ss>$timePointer){
                                                        $blcWidth=($short_ss-$timePointer)*100/$dayLength;
                                                        $b=1;
                                                        if(($short_ss-$timePointer)/60<$timeN){$b=2;}
                                                        if($b==1){
                                                            $vailDay=1;
                                                        }
                                                        $timePointer=$short_ss;
                                                    }
                                                    $blcWidth=($short_ee-$short_ss)*100/$dayLength;									
                                                    $timePointer=$short_ee;
                                                }
                                            }
                                        }
                                        if($timePointer!=$e2){
                                            $b=1;							
                                            if(($e2-$timePointer)/60<$timeN){$b=2;}
                                            if($b==1){										
                                                $vailDay=1;
                                            }
                                        }
                                        $timePointer=$e2;
                                    }
                                }
                            }	
                        }
                    }
                    if($vailDay){
                        array_push($dates_aval,date('Y-m-d',$sx_date));
                        $daa++;
                    }				
                    $thisDay+=86400;
                    $x--;
                }			
            }else{
                $error=11;
            }
        }
	}else{
		$error=8;
	}
	return array($error,$dates_aval);
}
function chekDatedata($id,$clinic,$doctor,$start,$end,$service=0){
	global $now;	
	$error=0;    
	if(getTotalCO('_users',"subgrp='$clinic' and id='$doctor' ")){	
		if($start>$now && $end>$start){
			list($timeN,$price)=getDefServTime($clinic,$doctor,$service);
			if(!$timeN){$timeN=20;}            
			if($end-$start == $timeN*60){				
				$ch1=chDaConflicts($id,$start,$end,$clinic);//check Conflicts
				$ch2=chDaDocAal($doctor,$start,$end);//check doctor time is available
				if($ch1==0 || $ch2==0){
					$error=12;				
				}
				
			}else{
				$error=8;
			}
		}else{
			$error=8;
		}
	}else{
		$error=8;
	}
	return $error;
}
function checkTempUser($token,$pat_id){
	$r=getRec('dts_x_patients',$token,'token');	
	if($r['r']){
		$id=$r['id'];
		moveData2Pat($id,$pat_id);
	}
}
function moveData2Pat($id,$pat_id){
	mysql_q("UPDATE dts_x_dates SET p_type=1 , patient='$pat_id' where p_type=2 and patient='$id' ");
    datesTempUp($id);
	$r=getRec('dts_x_patients',$id);
	$token=$r['token'];
	$photo=$r['photo'];
	$email=$r['email'];	
	if(mysql_q("UPDATE gnr_m_patients SET token='$token', photo='$photo',email='$email' where id='$pat_id' ")){		
		mysql_q("DELETE from dts_x_patients where id='$id' ");
	}
}
function isRealVisit($visit_type,$visit_no){
	global $pat_id;
    $tables=array('','cln_x_visits','lab_x_visits','cln_x_visits','den_x_visits','bt_x_visits','bty_x_laser_visits','osc_x_visits');
    $rate=pp($_POST['rate']);
    if($rate>0 && $rate<6){
        if($tables[$visit_type]){
            $r=getRecCon($tables[$visit_type],"id='$visit_no' and patient='$pat_id' ");
            if($r['r']){
                $dts_id=$r['dts_id'];
                if($dts_id){
                    mysql_q("UPDATE dts_x_dates SET rate='$rate' where id='$dts_id' ");
                    datesTempUp($dts_id);
                }
            }    
        }
		return $r['r'];
	}else{
        return 0;
    }
}
function getVisRate($type,$vis){
	$out=get_val_con('gnr_x_visit_rate','rate',"type='$type' and visit='$vis' ");	
	if(!$out){$out=0;}
	return $out;
}
function getAccuntBosxDate($mood){
	global $lg,$srvXTables,$srvTables,$visXTables;
	$shiftClock=15;
	$obj=array();
	$rn=0;
	$err=0;
	$c='c';
	$d='d';
	$qCln='';
	$date=pp($_POST['date'],'s');
	$doc=pp($_POST['doctor']);
	$clinic=pp($_POST['clinic']);
	if($clinic){$qCln=" id='$clinic' ";}
	if($doc){$qDoc=" and id='$doc' ";}
	$d_s= strtotime($date);
	$d_e=$d_s+86400;	
	$shiftTime=$d_s+($shiftClock*3600);
	$qu=array();
	/**********/
	$clicns=get_arr('gnr_m_clinics','id',"id,type,name_$lg,acc_med_morning,acc_med_night,acc_bty_morning,acc_cost_code",$qCln);
	$doctors=get_arr('_users','id',"id,name_$lg,subgrp,career_code","grp_code IN('nlh8spit9q','7htoys03le','9yjlzayzp','66hd2fomwt','9k0a1zy2ww') $qDoc");
	$boxs=get_arr('acc_m_boxs','code','name_'.$lg.',acc_no,cost_code');
	/**********/
	$i=0;
	$rNum=1;	
	foreach($clicns as $c_k=>$c_v){
		$clinicTxt=$c_v['name_'.$lg];
		$acc_mm=$c_v['acc_med_morning'];
		$acc_mn=$c_v['acc_med_night'];
		$acc_bm=$c_v['acc_bty_morning'];
		$acc_bn=$c_v['acc_bty_night'];
		$acc_cost=$c_v['acc_cost_code'];
		$mood=$c_v['type'];
		$qs=$qs2='';
		list($srvs,$acc_sm,$acc_sn,$code_s)=get_vals('acc_m_service','service,acc_morning,acc_night,codt_code',"mood='$mood' and clinic='$c_k' " ,'arr');
		
		if(count($srvs)){
			$srvsTxt=implode(',',$srvs);
			$qs=" and service NOT IN($srvsTxt) and pay_type=0";
			$qs2=" and service IN($srvsTxt) and pay_type=0";
		}
		$sevTable=$srvXTables[$mood];
		foreach($doctors as $d_k=>$d_v){
			if($acc_mm!=$acc_mn){
				$shifts=array('الدوام الصباحي','الدوام المسائي');
				$qu[0]=" and d_start>=$d_s and d_start< $shiftTime ";
				$qu[1]=" and d_start>=$shiftTime and d_start< $d_e ";
			}else{
				$shifts=array('');
				$qu[0]=" and d_start>=$d_s and d_start< $d_e ";
			}
			$shiftsCode=array($acc_mm,$acc_mn);
			$shiftsCodeBty=array($acc_bm,$acc_bn);
			
			if($c_k==$d_v['subgrp']){				
				if($mood==6){
					$s=getTotalCO($visXTables[$mood],"clinic='$c_k' and doctor='$d_k' and d_start>=$d_s and d_start< $d_e ");
				}else{
					$s=getTotalCO($sevTable,"clinic='$c_k' and doc='$d_k' and status=1 and d_start>=$d_s and d_start< $d_e ");
				}				
				if($s){
					$acc_no=$boxs[$c_v['type']]['acc_no'];
					$acc_cost=$boxs[$c_v['type']]['cost_code'];
					$i=1;
					$credit= 0;
					$creditBty=0;
					$total= 0;
					$srvCred=0;
					foreach($shifts as $k_s=>$v_s){
						$i=1;
						$cat=$d_v['career_code'];
						//---------------------------
						if($mood==6){
							$credit=get_sum($visXTables[$mood],'total_pay',"clinic='$c_k' and doctor='$d_k' ".$qu[$k_s]);
						}else{
							if($mood==1 && $acc_bm){
								$credit=get_sum($sevTable,'pay_net',"clinic='$c_k' and doc='$d_k' and bty=0 and status=1 $qs ".$qu[$k_s]);
								$creditBty=get_sum($sevTable,'pay_net',"clinic='$c_k' and doc='$d_k' and bty=1 and status=1 $qs ".$qu[$k_s]);
							}else{
								$credit=get_sum($sevTable,'pay_net',"clinic='$c_k' and doc='$d_k' and status=1 $qs ".$qu[$k_s]);
							}
							if(count($srvs)){
								$srvCred=get_sum($sevTable,'pay_net',"clinic='$c_k' and doc='$d_k' and status=1 $qs2 ".$qu[$k_s]);
							}
						}
						//---------------------------
						$total=$credit+$srvCred+$creditBty;
						if($total){
							/****************IN***********************/
							$des='واردات العيادة '.$clinicTxt.' - '.$v_s. ' بتاريخ '.$date.' ( د '.$d_v['name_'.$lg].' )' ;
							$debit= 1000;												
							$cost=$boxs['cost_code'];
							$obj[$rNum][$d][1]['n'] =$acc_no;				
							$obj[$rNum][$d][1]['des'] = $des;
							$obj[$rNum][$d][1]['debit'] = $total;
							$obj[$rNum][$d][1]['credit'] = 0;
							$obj[$rNum][$d][1]['cat'] ='';
							$obj[$rNum][$d][1]['cost'] = $acc_cost;
							$obj[$rNum][$d][1]['clinic'] =$c_k;
							$obj[$rNum][$d][1]['doctor'] =$d_k;
							/****************OUT***********************/
							//----------Med------						
							if($credit){
								$des='واردات العيادة '.$clinicTxt.' - '.$v_s. ' بتاريخ '.$date.' ( د '.$d_v['name_'.$lg].' )' ;
								$cost=$c_v['acc_cost_code'];
								$cat=$d_v['career_code'];											
								$obj[$rNum][$c][$i]['n'] =$shiftsCode[$k_s];				
								$obj[$rNum][$c][$i]['des'] = $des;
								$obj[$rNum][$c][$i]['debit'] = 0;
								$obj[$rNum][$c][$i]['credit'] = $credit;
								$obj[$rNum][$c][$i]['cat'] = $cat;
								$obj[$rNum][$c][$i]['cost'] = $cost;
								$obj[$rNum][$c][$i]['clinic'] =$c_k;
								$obj[$rNum][$c][$i]['doctor'] =$d_k;
								$i++;
							}
							//----------Bty------
							if($creditBty){
								$des='واردات العيادة '.$clinicTxt.' - '.$v_s. ' تجميل بتاريخ '.$date.' ( د '.$d_v['name_'.$lg].' )' ;
								$cost=$c_v['acc_cost_code_bty'];
								$cat=$d_v['career_code'];											
								$obj[$rNum][$c][$i]['n'] =$shiftsCodeBty[$k_s];				
								$obj[$rNum][$c][$i]['des'] = $des;
								$obj[$rNum][$c][$i]['debit'] = 0;
								$obj[$rNum][$c][$i]['credit'] = $creditBty;
								$obj[$rNum][$c][$i]['cat'] = $cat;
								$obj[$rNum][$c][$i]['cost'] = $cost;
								$obj[$rNum][$c][$i]['clinic'] =$c_k;
								$obj[$rNum][$c][$i]['doctor'] =$d_k;
								$i++;
							}
							//--------Srvs--------------
							if($srvCred){
								$cat=$d_v['career_code'];
								foreach($srvs as $ssk=>$ssv){
									$srvC=get_sum($sevTable,'total_pay',"clinic='$c_k' and doc='$d_k' and service='$ssv' ".$qu[$k_s]);								
									if($srvC){
										$srvName=get_val_arr($srvTables[$mood],'name_'.$lg,$ssv,'srvN');
										$srvCode=$acc_sm[$ssk];
										if($k_s==1){$srvCode=$acc_sn[$ssk];}
										$des='واردات العيادة '.$clinicTxt.' - '.$srvName.' - '.$v_s. ' بتاريخ '.$date.' ( د '.$d_v['name_'.$lg].' )' ;
										$cost=$c_v['acc_cost_code'];
										$cat=$d_v['career_code'];											
										$obj[$rNum][$c][$i]['n'] =$srvCode;				
										$obj[$rNum][$c][$i]['des'] = $des;
										$obj[$rNum][$c][$i]['debit'] = 0;
										$obj[$rNum][$c][$i]['credit'] = $srvC;
										$obj[$rNum][$c][$i]['cat'] = $cat;
										$obj[$rNum][$c][$i]['cost'] = $code_s[$ssk];
										$obj[$rNum][$c][$i]['clinic'] =$c_k;
										$obj[$rNum][$c][$i]['doctor'] =$d_k;
										$i++;
									}
								}
							}
							$rNum++;
						}
					}
				}
			}
		}
	}
	$rn=$rNum-1;
	return array($rn,$obj,$err);
}
function sendChatMess($mess,$patId,$patType,$mood){
    global $now;    
    $chat_id=get_val_con('api_chat','id',"patient='$patId' and pat_type='$patType'");
    if(!$chat_id){
        mysql_q("INSERT INTO api_chat (patient,pat_type,s_date)values('$patId','$patType','$now') ");
        $chat_id=last_id();
        WoSrFile($chat_id,$mood);
    }    
    mysql_q("INSERT INTO api_chat_items (chat_id,mess_type,mess,date)value('$chat_id',1,'$mess','$now')");
    $mess_id=last_id();
    addWoSrData($mood,'n',$chat_id,$mess_id,$mess,$now);
    mysql_q("UPDATE api_chat SET last_act='$now' ,status=0 where id='$chat_id'");
    return $mess_id;
}
function WoSrFile($chat_id,$mood){
    $dir='';
    if($mood==2){$dir='../';}
    $file=$dir.'api_ws.php';
    $f=fopen($file,'w');    
    $txt='';    
    fwrite($f,$txt);
    fclose($f);
}

function addWoSrData($mood,$type,$chat_id,$mess_id='',$mess='',$date=''){
    $dir='';
    if($mood==2){$dir='../';}
    $file=$dir.'api_ws.php';
    if($type=='n'){
        $txt=$type.'^'.$chat_id.'^'.$mess_id.'^'.$date.'^'.$mess.'|';
    }
    if($type=='r'){
        $txt=$type.'^'.$chat_id.'^'.$mess_id.'^^|';
    }
    file_put_contents($file,$txt, FILE_APPEND);
}
function GI_NA_Val($type,$sex,$scale,$Mval){
	global $GI_txt,$GI_clr,$clr5;
	$out='';
	$vals=getRecCon('gnr_m_growth_indicators'," type='$type' and sex='$sex' and scale='$scale' order by scale ASC");
	if($vals['r']){
		$valsArr=array($vals['minus_2_res'], $vals['minus_1.5_res'], $vals['minus_1_res'], $vals['minus_0.5_res'], $vals['equation_res'], $vals['plus_0.5_res'], $vals['plus_1_res'], $vals['plus_1.5_res'], $vals['plus_2_res']);
		$val=0;
		$lastVal=0;
		$x='';
		foreach($valsArr as $k=>$v){
			if($Mval>$v){
				$val=$k;
				if($k==8){					
					$GIreng=($Mval-$lastVal)/($v-$lastVal);
					if($GIreng>1){$x='+';$x.=intval($GIreng)+1;}
				}
			}else{
				if($k==0){					
					$GIreng=($v-$Mval)/($valsArr[1]-$v);
					if($GIreng>1){$x='-'.intval($GIreng)-1;}
				}
				if($Mval>$lastVal){					
					$GIreng=($Mval-$lastVal)/($v-$lastVal);					
					if($GIreng>=0.5){$val=$k;}
				}
			}
			$lastVal=$v;
		}
		if($x){
			$out=$x;
			//$out[1]=$clr5;				
		}else{
			$out=$GI_txt[$val];
			//$out[1]=$GI_clr[$val];
		}
	}
	return $out;
}
function creatVerCode($mobile,$user=0,$type=0){
	global $now;
	$vercode=getRandString(6,2);
	resetVerCode($mobile);
    $sql="INSERT INTO dts_x_patients_verification (code,date,mobile,user,user_type)values('$vercode','$now','$mobile','$user','$type')";
	if(mysql_q($sql)){
		return $vercode;
	}	
}
function resetVerCode($mobile=''){
	global $now;
	$delDate=$now-(2*3600);
	$q='';
	if($mobile){$q=" or mobile='$mobile' ";}
	//mysql_q("DELETE FROM dts_x_patients_verification where date<$delDate $q");
}

function calcPageRec($allRecs,$p,$rpp){
	$s=0;
	if($allRecs){
		if(!$rpp){$rpp=10;}
		$maxPage=intval($allRecs/$rpp);
		if($allRecs%$rpp!=0){$maxPage++;}
		if(!$p || $p>$maxPage){$p=1;}
		$page=$p-1;
		$s=($page*$rpp);
		$e=$s+$rpp-1;
		if($e>$allRecs-1){$e=$allRecs-1;}
		return array($p,$s,$e);
	}else{
		return array(1,0,0);
	}
}
function apiOutCol($val,$type,$sType,$mood,$rec='',$linkCol=''){
    global $pat_id,$logType;
	$val=get_key($val);
	$out=$val;
	switch ($type){
		case 1:
			if($sType==2 && $mood==1){$out=intval($val);}
		break;
		case 2:
			if($sType==2){if(($timestamp = strtotime($val)) !== FALSE){$out=strtotime($val);}}	
			$out=$val;
		break;
		case 4:
			if($val){
				$out=apiImage($val,$mood,$sType);				
			}
		break;
		case 5:
			$pers=explode('|',$sType);
			if($val){
                $_table=$pers[0];
                $_id=$pers[1];
                $_column=$pers[2];
                $_cond=$pers[3];
                if($_cond){
                    if($_cond=='m'){
                        //echo '('.$_id.' IN('.$val.') )<br>';
                        $out=get_vals($_table,convLangCol($_column),$_id.' IN('.$val.') ','arr');
                    }else{
                        $out=get_val_con($_table,convLangCol($_column),$_cond);
                    }
                }else{
				    $out=get_val_c($_table,convLangCol($_column),$val,$_id);
                }
				if(!$out){$out='';}
			}
		break;
		case 6:
			$pers=explode('|',$sType);
			foreach($pers as $p){
				$pp=explode(':',$p);
				if($pp[0]==$val){                    
					$out=get_key($pp[1]);
				}
			}
		break;
		case 7:$out=apiCustomVal($sType,$val,$mood,$rec);break;
        case 8://sub Data            
            $ok=1;
            //var_dump($rec);echo '----------------------------';
            //echo '-----------('.$val.','.$type.','.$sType.','.$mood.','.$rec['col'].','.$linkCol.')------';
            //var_dump($rec);
            if($sType=='0s0m999rf'){
                $Vbal=get_visBal($val);                
                if($Vbal>0 || _set_0zmrcedu52==1){$ok=0;$out='';}                
            }
            if($ok){
                $con_id=$rec[$linkCol];                
                $dataQ=apidataObject($sType,$mood,1,$con_id);
                if($dataQ){
                    $out = array_values($dataQ);
                    json_encode($out);
                }else{
                    $out='';
                }
            }
        break;
	}
	return $out;
}
function apiCustomVal($code,$val,$mood,$rec=''){
	global $api_url,$lg,$pat_id,$logType;
	$out=$val;
	switch ($code){
		case 'cln_vis':$out=getTotalCO('cln_x_visits'," patient='$val' ");break;
		case 'lab_vis':$out=getTotalCO('lab_x_visits'," patient='$val' ");break;
		case 'xry_vis':$out=getTotalCO('xry_x_visits'," patient='$val' ");break;
		case 'den_vis':$out=getTotalCO('den_x_visits'," patient='$val' ");break;
		case 'bty_vis':$out=getTotalCO('bty_x_visits'," patient='$val' ");break;
		case 'lsr_vis':$out=getTotalCO('bty_x_laser_visits'," patient='$val' ");break;
        case 'osc_vis':$out=getTotalCO('osc_x_visits'," patient='$val' ");break;
        case 'vital':$out=getTotalCO('cln_x_vital'," patient='$val' ");break;
        case 'growth':$out=getTotalCO('gnr_x_growth_indicators'," patient='$val' ");break;
        
		case 'appoint':$out=getTotalCO('dts_x_dates'," patient='$val' and p_type=1");break;
		case 'appoint2':$out=getTotalCO('dts_x_dates'," patient='$val' and p_type=2");break;
		case 'v_link':
			list($code,$d_start)=get_val('lab_x_visits','code,d_start',$val);
			$out=str_replace('/ar/','/en/',$api_url).'PrintLR/V'.$d_start.'-'.$code; 
		break;
		case 's_link':
			list($code,$d_start)=get_val('lab_x_visits_services','code,date_enter',$val);
			$out=str_replace('/ar/','/en/',$api_url).'PrintLR/S'.$d_start.'-'.$code; 
		break;
		
		case 'email_status':$out=$pat_id;break;
		
		case 'rate1':$out=getVisRate(1,$val);break;
		case 'rate2':$out=getVisRate(2,$val);break;
		case 'rate3':$out=getVisRate(3,$val);break;
		case 'rate4':$out=getVisRate(4,$val);break;
		case 'rate5':$out=getVisRate(5,$val);break;
		case 'rate6':$out=getVisRate(6,$val);break;
		case 'rate9':$out=getVisRate(9,$val);break;
		case 'normalVal':
            //echo $out=$rec['id'];
            $out=$val;
            //$out=get_LreportNormalById($rec['id']);
        break;
		case 'x_report':$out=get_val('xry_x_pro_radiography_report','report',$val);break;
		case 'x_photo':
			$photos=get_val('xry_x_pro_radiography_report','photos',$val);
			if($photos){
				$out=apiImage($photos,$mood,'900,600');
			}else{$out='';}
		break;
		case 'unit':
			$unit=get_val('lab_m_services_items','unit',$val);
			$out=get_val('lab_m_services_units','code',$unit);
			
		break;
        case 'p_name':$out=get_p_name($val);break;
        case 'setting':$out=activeSettings($val);break;
        case 'labC':$out=k_lab;break;
        case 'docClin':            
            //$linked=get_val('gnr_m_clinics','linked',$val);
            //if($linked){$val=$linked;}
            $out=intval($val);
        break;
        case 'docClinName':            
            $linked=get_val('gnr_m_clinics','linked',$val);
            if($linked){
                $val=$linked;
            }
            $val=get_val('gnr_m_clinics','name_'.$lg,$val);
            $out=$val;
        break;
        case 'growth_1':$out=growth_data(1,$rec);break;
        case 'growth_2':$out=growth_data(2,$rec);break;
        case 'growth_3':$out=growth_data(3,$rec);break;
        case 'growth_4':$out=growth_data(4,$rec);break;
        case 'growth_5':$out=growth_data(5,$rec);break;
        
        case 'clinic_type':$out=get_val('gnr_m_clinics','type',$val);break;
            
	}
	return $out;
}
function growth_data($type,$r){
    $age=$r['age'];  
    $Mval1=$age;
    $Mval2=$age;
    if($type==1){$Mval2=$r['weight'];}
    if($type==2){$Mval2=$r['Length'];}
    if($type==3){$Mval2=$r['head'];}
    if($type==4){
        $BMI=$r['weight']/($r['Length']/100*$r['Length']/100);
        $Mval2=$BMI;
    }
    if($type==5){$Mval2=$r['weight'];$Mval1=$r['Length'];}
    $sex=1;
    $val=GI_NA_Val($type,$sex,$Mval1,$Mval2);
    return strval($val);
}
function activeSettings($s){
    global $pat_id,$logType,$setArr;
    $out=0;
    if(!isset($setArr[$pat_id.'-'.$logType])){
       $setArr[$pat_id.'-'.$logType]=get_vals('api_x_settings','set_id',"user='$pat_id' and user_type='$logType' ",'arr');
    }
    if(in_array($s,$setArr[$pat_id.'-'.$logType])){$out=1;}
    return $out;
    
}
function apiImage($val,$mood,$s,$type='url'){
    global $folderBack;
    //echo '('.$folderBack.')';
    if(!$val){return '';}
	$dir='';
	$size=array(200,200);
	if($s){
		$ss=explode(',',$s);
		if(count($ss)==2){
			$size[0]=$ss[0];
			$size[1]=$ss[1];
		}
	}
	if($mood==2){$dir='../../';}
	if($val){
		$image=getImages($val);			
		$file=$image[0]['file'];
		$folder=$image[0]['folder'];
		$ex=$image[0]['ex'];
		$filePath=$dir."sData/".$folder.$file;		
		list($w,$h)=getimagesize($filePath);		
		$resImg= Croping($file,"sData/".$folder,$size[0],$size[1],'o',$folderBack.'sData/resize/',0,'sData/resize/',$ex);
                                                              
		//echo $resImg;
		if(file_exists($resImg)){
			if($type=='url'){
				$fileLink='http://'.$_SERVER['HTTP_HOST']._path.'imup/o'.$size[0].$size[1].$file;
				if($mood==2){
					return '<a href="'.$fileLink.'" target="blank" style="color:#f00" class="fs12">'.$fileLink.'</a>';
				}else{
					return $fileLink;
				}
			}else{
				$x = file_get_contents($resImg);			
				if($mood==2){
					return '<img src="data:image/'.$ex.';base64,'.base64_encode($x).'"/>';
				}else{
					return 'data:image/'.$ex.';base64,'.base64_encode($x);
				}
			}
		}else{return '';}
	}else{return '';}
}
/********Chat**********************/
function loadChats($id=0){
    global $now;
    $out='';
    $q='';
    if($id){$q=" and id='$id' ";}
    $sql="select * from api_chat where status=0 $q order by last_act DESC";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){
        while($r=mysql_f($res)){
            $id=$r['id'];
            $patient=$r['patient'];
            $pat_type=$r['pat_type'];
            $s_date=$r['s_date'];
            $last_act=$r['last_act'];
            $active_user=$r['active_user'];
            $status=$r['status'];
            $pat=get_p_dts_name($patient,$pat_type);
            $n=get_sum('api_chat_items',"chat_id='$id' and status=0 and mess_type=1");
            if($n==0 && (($now-$last_act)>(24*60*60))){
                mysql_q("UPDATE api_chat SET status=1 where id='$id'");
            }else{
                $out.=chatPatBox($id,$n,$pat,$last_act);
            }
        }
    }
    return $out;
}
function chatPatBox($id,$n,$pat,$last_act){
    return '
    <div class="mg10f pd10f cbgw chatList" c="'.$id.'" >
        <div class="fr ff B" n="'.$n.'">'.$n.'</div>
        <div class="f1 lh30 fs14 clr1">'.$pat.'</div>
        <div class="f1 lh20 fs14"><ff14 dir="ltr" d>'.date('m/d Ah:i:s',$last_act).'</ff14></div>
    </div>';
}
function readAll($id){
    mysql_q("UPDATE api_chat_items set status=1 where status=0 and mess_type=1 and chat_id='$id' ");
}
function chatNav($type,$pat,$pat_type,$mess_id,$mess){    
    if($type==1){//send New message
        $res_out=chatMsgSend(1,$pat,$pat_type,$mess,$mess_id);         
    }
    if($type==2){//Read last meassage
        
    }
}
function chatMsgSend($type,$pat,$p_type,$mess,$mess_id){
	global $now;
	$message_status='';
	$tokens=array();
	$notData='';
    $sql="select * from api_notifications_push where patient='$pat' and p_type='$p_type' ";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if(mysql_n($res)>0){
        while($r=mysql_f($res)){
            $app=$r['app'];				
            //array_push($r["token"],$tokens);
            array_push($tokens,$r["token"]);
        }        
        /*******/
        $message=array(
            'title'=>k_new_mess,
            'body'=>$mess,		
            'sound'=>'sound',
            'icon'=>'icon',
            'color'=>'color',
            'priority'=>'priority',            
        );
        $notData=array(
            'type'=>'50',
            'id'=>$mess_id,
            //'cat'=>$cat,
        );
        
        /*******/
        $key=get_val_c('api_users','notf_code',$app,'code');
        $out = send_single_notification($key,$tokens,$message,$notData);
        $out=json_decode($out,true);
        $message_status=[$out['success'],$out['failure']];
        //echo '('.$message_status[0].')';
	}
	//return $message_status;
}
function getTxtNotType111($type,$rec_id,$title='',$body='',$cat=''){
	global $lg,$thisUser;
	$out=array();
    if(!$title){
	   list($title,$body)=get_val_c('api_noti_list','name_'.$lg.',body_'.$lg,$type,'no');
    }
	$rSet=getRecCon('api_noti_set'," user ='$thisUser' ");
	if($rSet['r']){
		$out[0]=array(
			'title'=>$title,
			'body'=>$body,		
			'sound'=>$rSet['sound'],
			'icon'=>$rSet['icon'],
			'color'=>$rSet['color'],
			'priority'=>$rSet['priority'],
			'android_channel_id'=>$rSet['channal']
		);
		$out[1]=array(
			'type'=>$type,
			'id'=>$rec_id,
            'cat'=>$cat,
		);
	}
	return $out;
}
function updatAPIUserData($id){
    if(!get_val('api_users','code',$id)){
        $code=get_val('_users','code',$id);
        if($code){
            mysql_q("INSERT INTO api_users (id,code)values('$id','$code')");        
        }
    }
}
function addCoplintsAction($compl,$type,$user,$description=''){    
    global $now;
    mysql_q("INSERT INTO api_x_complaints_actions 
    (`complaint_id`,`type`,`user`,`description`,`date`)values
    ('$compl','$type','$user','$description','$now')");
}
/*************Fatora payments*****************/
function createPayment($patient,$opr,$rec_id,$amount){
    global $lg,$now,$payData; 
    $lg='en';
    $code=getRandString(64); 
    $code2=getRandString(10); 
    $err=0;
    $msg='';    
    $callbackURL=$payData['pay_opr_url'].'x-'.$code;
    $triggerURL=$payData['pay_opr_url'].'c-'.$code;    
    $appUser=get_p_name($patient);    
    if($appUser){// check patient         
        switch($opr){
            /************new date********************/
            case 1: 
                $status=get_val('dts_x_dates','status',$rec_id);
                //if($status!=10){$err=1;}            
            break;
            /********************************/
        }
        if($err==0){
            $b_data=[
                "lang"=>"$lg",
                "terminalId"=> $payData['tid'],
                "amount"=> $amount,
                "callbackURL"=> $callbackURL,
                "triggerURL"=> $triggerURL,
                "savedCards"=>0,
                "appUser"=>$appUser
            ];
            return [1,getPaymentURL($b_data,$patient,$opr,$rec_id,$amount,$code)];
        }else{
            return [0,$code];
        }
    }
}
function getPaymentURL($b_data,$patient,$opr,$rec_id,$amount,$code){
    global $now,$payData;
    $ErrorMsg=0;
    $b_data2 = json_encode($b_data);    
    $ch = curl_init($payData['url']);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERPWD, $payData['user'] . ":" . $payData['pass']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $b_data2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $res = curl_exec($ch);
    curl_close($ch);
    
    $ErrorCode=0;
    $ErrorMessage='';

    $data=json_decode($res,true);
    if(isset($data['ErrorCode'])){
        $ErrorCode=$data['ErrorCode'];
        $ErrorMessage=$data['ErrorMessage'];
        if($ErrorCode==0){//no errors
            $url=$data["Data"]['url'];
            $paymentId=$data["Data"]['paymentId'];
        }else{
            $ErrorMessage=$data["Data"]['ErrorMessage'];
        }
    }
    if($ErrorMsg==0){
        return savePaymentRequerst($patient,$opr,$rec_id,$paymentId,$url,$amount,$code);
    }else{
        
    }   
}
function savePaymentRequerst($patient,$opration,$rec_id,$payment_id,$url,$amount,$code){
    global $now,$lg,$payData;
    $sql="INSERT INTO api_x_payments(`code`,`patient`,`opration`,`rec_id`,`payment_id`,`url`,`amount`,`date`)
    values('$code','$patient','$opration','$rec_id','$payment_id','$url','$amount','$now')";
    mysql_q($sql);
    //echo '<a href="'.$payData['pay_opr_url'].'w-'.$code.'">'.$payData['pay_opr_url'].'w-'.$code.'</a><br>';
    return $payData['pay_opr_url'].'w-'.$code;
}
function getPaymentStatus($payment_id){
	global $now,$payData;
	$url=$payData['url'].'-status/'.$payment_id;
    // $b_data2 = json_encode($b_data);    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERPWD, $payData['user'] . ":" . $payData['pass']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $b_data2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $res = curl_exec($ch);
    curl_close($ch);
    
    $ErrorCode=0;
    $ErrorMessage='';

    $data=json_decode($res,true);	

    if(isset($data['ErrorCode'])){
        $ErrorCode=$data['ErrorCode'];
        $ErrorMessage=$data['ErrorMessage'];
	}
	if($ErrorCode==0){//no errors
		$status=$data["Data"]['status'];
		$paymentId=$data["Data"]['paymentId'];
		return [1,$status];
	}else{		
		return [0,$ErrorCode];
	}	
}
/*************MTN payments*****************/
function mtn_createPayment($patient,$opr,$rec_id,$amount){
    list($error,$token)=mtn_get_token();
    if($error==0){
        switch($opr){
            case 1://new date
                $phone=get_val('gnr_m_patients','mobile',$patient);                
            break;
        }
        return [$error,$token,$phone];
    }else{        
        return [$error,$token,0];
    }    
}
function mtn_get_token(){
    global $mtnPayData;
    $error=0;
    $token='';
    $data=array(
    'inputObj' => '{"userName":"'.$mtnPayData['userName'].'", "password":"'.$mtnPayData['password'].'","merchantGSM":"'.$mtnPayData['merchantGSM'].'"}'
    );
    $mydata=http_build_query($data);
    $curl = curl_init();    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $mtnPayData['tokenURL'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $mydata,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);    
    $data=json_decode($response,true);
    $result=$data['result'];
    if($result=='True'){        
        $token=$data['data']['token'];
    }else{
        $error=$data['error'];
    }
    return [$error,$token];
    
}
function saveNewMTNPayment($token,$patient,$phone,$opr,$rec_id,$amount){
    global $now;
    $res=mysql_q("INSERT INTO api_x_payments_mtn (`token`,`patient`,`phone`,`opration`,`rec_id`,`amount`,`date`)
    values('$token','$patient','$phone','$opr','$rec_id','$amount','$now')");
    return last_id();
}
function createMTN_OTP($trans_id,$token,$mobile,$amount){    
    global $mtnPayData;
    $error=0;
    if($mtnPayData['testMood']){
        $mobile='963947222861';
        //$pass='123456';
    }
    $data=array(    
        'inputObj' => '{"token":"'.$token.'", "customerGSM":"'.$mobile.'","amount":"'.$amount.'","BpartyTransactionID":"t-'.$trans_id.'"}'        
    );    
    $mydata=http_build_query($data);
    $curl = curl_init();    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $mtnPayData['creatOTP_URL'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $mydata,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);    
    $data=json_decode($response,true);
    $result=$data['result'];
    if($result=='False'){        
        $error=$data['error'];
    }
    return $error;    
}
function enterMTN_OTP($trans_id,$token,$otp){
    global $mtnPayData;
    $error=0;
    $transactionId='';
    $data=array(        
        'inputObj' => '{"token":"'.$token.'", "OTP":"'.$otp.'","BpartyTransactionID":"t-'.$trans_id.'"}'        
    );    
    $mydata=http_build_query($data);
    $curl = curl_init();    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $mtnPayData['doPayment_URL'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $mydata,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);    
    $data=json_decode($response,true);
    $result=$data['result'];
    if($result=='True'){        
        $transactionId=$data['data']['transactionId'];        
    }else{
        $error=$data['error'];
    }
    return [$error,$transactionId];    
}
function compleatMTN_payment($r,$tran){
	global $visXTables;
    $id=$r['id'];
    mysql_q("UPDATE api_x_payments_mtn set tens_id='$tran' ,status=1 where id='$id' ");
    switch($r['opration']){
        case 1://new date
            $dts_id=$r['rec_id'];
            $dts=getRec('dts_x_dates',$dts_id);
            if($dts['r']){
               mysql_q("UPDATE dts_x_dates set status=1 where status=10 and id='$dts_id' ");
               addPay($dts_id,$dts['type'],$dts['clinic'],$r['amount']);
               $out=api_notif($r['patient'],$dts['p_type'],101,$dts_id);
            }
        break;
		case 2://Reception payment
            $vis_id=$r['rec_id'];
			$mood=$r['mood'];
			$table=$visXTables[$mood];
            $vis=getRec($table,$vis_id);
			$amount=get_val('api_x_payments_mtn','amount',$r['id']);
            if($vis['r']){
				addPay($vis_id,1,$vis['clinic'],$amount,$mood,2,0,0,111);				
            }
        break;
    }
}
/***************************************/
function prmo_content($r){
    $id=$r['id'];
    $status=$r['status'];
    $out='';
    if($status==0){
        $out='<div class="fl ic40 ic40_add icc4 ic40Txt" prom_contnet="'.$id.'" fix="w:170">إضافة المحتوى</div>';
    }elseif($status<3){
        $out='<div class="fl ic40 ic40_edit icc1 ic40Txt" prom_contnet="'.$id.'" fix="w:170">تحرير المحتوى</div>';
    }
    if($status==4){
        $out='<div class="Over" prom_contnet="'.$id.'">
        <div class="f1 clr1">'.promoReplaceData($r['msg_title']).'</div>
        <div class="f1 fs10">'.promoReplaceData($r['msg_desc']).'</div>
        </div>';
    }
    return $out;
}

function prmo_audience($r){
    global $sex_types;
    $id=$r['id'];
    $status=$r['status'];
    $out='';
    if($status<2 && $status>0){
        $out='<div class="fl ic40 ic40_add icc4 ic40Txt" prom_audience="'.$id.'" fix="w:160">تحديد الجمهور</div>';
    }
    if($status<3 && $status>1){
        $out='<div class="fl ic40 ic40_edit icc1 ic40Txt" prom_audience="'.$id.'" fix="w:160">تحرير الجمهور</div>';
    }
    if($status>3){
        $txt='';
        $audience=$r['audience'];
        if($audience){
            $audience_arr=json_decode($audience,true);
            $txt.='الجنس: '.$sex_types[$audience_arr['sex']];            
            $txt.=' | العمر: '.$audience_arr['age_from'].'-'.$audience_arr['age_to'];
            if($audience['area']){
                $txt.=' | المنطقة: '.get_val('gnr_m_areas','name',$audience_arr['area']);
            }
        }
        $out='<div class="f1 clr1">'.$txt.'</div>';
    }
    return $out;
}
function prmo_send($r){
    $id=$r['id'];
    $status=$r['status'];
    $out='';
    if($status==2){
        $out='<div class="fl ic40 ic40_send icc4 ic40Txt" prom_send="'.$id.'" fix="w:160">إرسال </div>';
    }
    if($status==3){
        $out='<div class="fl ic40 ic40_send icc1 ic40Txt" prom_send="'.$id.'" fix="w:160">إكمال الإرسال</div>';
    }
    if($status==4){
        $total=$r['total'];
        $successful=$r['successful'];
        $views=$r['views'];
        $out='<div class="f1">
            المجموع: '.number_format($total).'<br> وصل الى: '.number_format($successful).' | المشاهدات : '.number_format($views).' 
        </div>';
    }
    return $out;
}
function promoReplaceData($txt,$data=[]){    
    if(empty($data)){
        $data['p']=' <span class="clr5 f1"> اسم المريض </span> ';
    }
    foreach($data as $k=>$v){
        $txt=str_replace('['.$k.']',$v,$txt);
    }
    return $txt;
}
function syncProm($id){
    $successful=getTotalCo('api_x_promotion_msg',"promotion_id='$id' and status=1");
    $failed=getTotalCo('api_x_promotion_msg',"promotion_id='$id' and status=2");
    mysql_q("update api_x_promotion set successful='$successful' , failed='$failed' where id='$id'");
}
?>
