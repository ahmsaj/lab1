<?

/***DTS***/
function chDaConflicts($id, $s, $e, $clinic)
{
	$out = 0;
	$sql = "select id from dts_x_dates where (
	(d_start>$s AND d_start<$e) OR 
	(d_end>$s AND d_end<$e) OR 
	(d_start=$s AND d_end=$e)
	) 
	AND clinic='$clinic' and status NOT IN(5,7) and id!='$id' limit 1";
	$res = mysql_q($sql);
	$rows = mysql_n($res);
	if ($rows > 0) {
		$r = mysql_f($res);
		$out = 'x1-' . $r['id'];
	} else {
		$out = 1;
	}
	return $out;
}
/*function chDaDocAal($doc,$s,$e){
	$dateDay=date('w',$s);
	$short_s=$s%86400;
	$short_e=$e%86400;
	list($days,$type,$data)=get_val('gnr_m_users_times','days,type,data',$doc);	
	if(getTotalCO('gnr_x_vacations',"emp='$doc' and 
		(
			(type=2 and (s_date<=$s and e_date>$s) OR (s_date<$e and e_date>=$e))
			OR
			(type=1 and (s_date<=$s and e_date+86400>$s) OR (s_date<$e and e_date+86400>=$e))
		
		)
	"
	)){return 'x2';}
	$days_arr=explode(',',$days);	
	if(in_array($dateDay,$days_arr) && $days!=''){
		if($type==1){			
			$data_arr=explode(',',$data);
			//echo '('.$data_arr[0].'<='.$short_s .'&&'. $data_arr[1].'>='.$short_e.') || ('.$data_arr[2].'<='.$short_s .'&&'. $data_arr[3].'>='.$short_e.'))';
			if(($data_arr[0]<=$short_s && $data_arr[1]>=$short_e) || ($data_arr[2]<=$short_s && $data_arr[3]>=$short_e)){
				return 1;
			}
		}	
		if($type==2){
			$d1=explode('|',$data);
			$i=0;
			foreach($d1 as $d2){			
				if($days_arr[$i]==$dateDay){					
					$data_arr=explode(',',$d2);
					if(($data_arr[0]<=$short_s && $data_arr[1]>=$short_e) || ($data_arr[2]<=$short_s && $data_arr[3]>=$short_e)){
						return 1;
					}
				}		
				$i++;
			}
		}
	}
	
	return 'x2';
}*/
function chDaDocAal($doc, $s, $e)
{
	$dateDay = date('w', $s);
	$short_s = $s % 86400;
	$short_e = $e % 86400;
	list($days, $type, $data) = get_val('gnr_m_users_times', 'days,type,data', $doc);
	$days_arr = explode(',', $days);
	if (in_array($dateDay, $days_arr) && $days != '') {
		if ($type == 1) {
			$data_arr = explode(',', $data);
			//echo '('.$data_arr[0].'<='.$short_s .'&&'. $data_arr[1].'>='.$short_e.') || ('.$data_arr[2].'<='.$short_s .'&&'. $data_arr[3].'>='.$short_e.'))';
			if (($data_arr[0] <= $short_s && $data_arr[1] >= $short_e) || ($data_arr[2] <= $short_s && $data_arr[3] >= $short_e)) {
				return 1;
			}
		}
		if ($type == 2) {
			$d1 = explode('|', $data);
			$i = 0;
			foreach ($d1 as $d2) {
				if ($days_arr[$i] == $dateDay) {
					$data_arr = explode(',', $d2);
					if (($data_arr[0] <= $short_s && $data_arr[1] >= $short_e) || ($data_arr[2] <= $short_s && $data_arr[3] >= $short_e)) {
						return 1;
					}
				}
				$i++;
			}
		}
	}
	return 'x2-0';
}
function get_docBestDate($doc, $timeN)
{
	global $ss_day, $now;
	$id = pp($_POST['id']);
	$n = pp($_POST['n']);
	$daysPerPage = _set_zb4taa12sn;
	$s_now = $now - ($now % (60 * _set_pn68gsh6dj)) + (60 * _set_pn68gsh6dj);
	list($days, $type, $data) = get_val('gnr_m_users_times', 'days,type,data', $doc);
	if ($days == '' || !$data) {
		return 0;
	}
	$days_arr = explode(',', $days);
	$days_arr_data = array();
	$LongDateTime = 1;
	if ($type == 1) {
		$d = explode(',', $data);
		foreach ($days_arr as $i) {
			$days_arr_data[$i]['s'] = $d[0];
			$days_arr_data[$i]['e'] = $d[1];
			$days_arr_data[$i]['s2'] = $d[2];
			$days_arr_data[$i]['e2'] = $d[3];
			if ($LongDateTime) {
				if (($d[1] - $d[0]) > $timeN * 60) {
					$LongDateTime = 0;
				}
				if (($d[3] - $d[2]) > $timeN * 60) {
					$LongDateTime = 0;
				}
			}
		}
	}
	if ($type == 2) {
		$sDay = 0;
		$eDay = 0;
		$d1 = explode('|', $data);
		$i = 0;
		foreach ($d1 as $d2) {
			$d = explode(',', $d2);
			$days_arr_data[$days_arr[$i]]['s'] = $d[0];
			$days_arr_data[$days_arr[$i]]['e'] = $d[1];
			$days_arr_data[$days_arr[$i]]['s2'] = $d[2];
			$days_arr_data[$days_arr[$i]]['e2'] = $d[3];
			if ($LongDateTime) {
				if (($d[1] - $d[0]) > $timeN * 60) {
					$LongDateTime = 0;
				}
				if (($d[3] - $d[2]) > $timeN * 60) {
					$LongDateTime = 0;
				}
			}
			$i++;
		}
	}
	if ($LongDateTime) {
		return 0;
	}
	$s_now = $now - ($now % (60 * _set_pn68gsh6dj)) + (60 * _set_pn68gsh6dj);
	$lastDates = array();
	$days_length = count($days_arr);
	$sx_date = $ss_day;
	$ex_date = $ss_day + (86400 * ((intval($daysPerPage / $days_length) + 1) * 7));
	$sql = "select id,d_start,d_end from dts_x_dates where 
			((d_start>=$sx_date and d_start<=$ex_date) OR (d_end>=$sx_date and d_end<=$ex_date))  and status!=5 and id!='$id' and doctor='$doc' order by d_start ASC";
	$res = mysql_q($sql);
	$rows = mysql_n($res);
	if ($rows > 0) {
		$i = 0;
		while ($r = mysql_f($res)) {
			$lastDates[$i]['id'] = $r['id'];
			$lastDates[$i]['s'] = $r['d_start'];
			$lastDates[$i]['e'] = $r['d_end'];
			if ($lastDates[$i]['s'] < $s_now) {
				$lastDates[$i]['s'] = $s_now;
			}
			if ($lastDates[$i]['e'] < $lastDates[$i]['s']) {
				$lastDates[$i]['e'] = $lastDates[$i]['s'];
			}
			$i++;
		}
	}
	$allDays = 0;
	$thisDay = $n;
	while ($allDays < $daysPerPage) {
		if ($thisDay == 0) {
			$thisDay = $ss_day;
		} else {
			$thisDay += 86400;
		}
		$thisDayNo = date('w', $thisDay);
		if (in_array($thisDayNo, $days_arr)) {
			if (noVacation($doc, $thisDay)) {
				$blucks = '';
				$s = $days_arr_data[$thisDayNo]['s'];
				if ($s + $thisDay < $s_now && $s != 0) {
					$s = $s_now - $thisDay;
				}
				$e = $days_arr_data[$thisDayNo]['e'];
				if ($e + $thisDay < $s_now && $e != 0) {
					$s = $s_now - $thisDay;
				}
				$s2 = $days_arr_data[$thisDayNo]['s2'];
				if ($s2 + $thisDay < $s_now && $s2 != 0) {
					$s2 = $s_now - $thisDay;
				}
				$e2 = $days_arr_data[$thisDayNo]['e2'];
				if ($e2 + $thisDay < $s_now && $e2 != 0) {
					$e2 = $s_now - $thisDay;
				}
				if ($s_now < $e + $thisDay  || $s_now < $e2 + $thisDay) {
					$timePointer = $s;
					if ($s > 0) {
						/*********shift 1*****************************************/
						foreach ($lastDates as $d) {
							$short_s = $d['s'] - $thisDay;
							$short_e = $d['e'] - $thisDay;
							if ($d['s'] >= ($s + $thisDay) &&  $d['e'] <= ($e + $thisDay)) {
								if ($timePointer != $short_s) {
									if ((($short_s - $timePointer) / 60) >= $timeN) {
										return $thisDay + $timePointer;
									}
								}
								$timePointer = $short_e;
							}
						}
						if ($timePointer < $e) {
							if (($e - $timePointer) / 60 >= $timeN) {
								return $thisDay + $timePointer;
							}
							$timePointer = $e;
						}
					}
					/*********shift 2*******************/
					if ($s2) {
						//$blcWidth=($s2-$timePointer)*100/$dayLength;				
						$timePointer = $s2;
						foreach ($lastDates as $d) {
							$short_s = $d['s'] - $thisDay;
							$short_e = $d['e'] - $thisDay;
							if ($d['s'] >= ($s2 + $thisDay) &&  $d['e'] <= ($e2 + $thisDay)) {
								if ($timePointer != $short_s) {
									if (($short_s - $timePointer) / 60 >= $timeN) {
										return $thisDay + $timePointer;
									}
									$timePointer = $short_s;
								}
								$timePointer = $short_e;
							}
						}
						if ($timePointer < $e2) {
							if (($e2 - $timePointer) / 60 >= $timeN) {
								return $thisDay + $timePointer;
							}
							$timePointer = $e2;
						}
					}
				}
			}
			$allDays++;
		}
	}
}
function noVacation($emp, $day)
{
	$v = getTotalCO('gnr_x_vacations', "emp='$emp' and type=1 and 
	(s_date = $day or e_date = $day or (s_date < $day and e_date > $day ))");
	if ($v) {
		return 0;
	}
	return 1;
}
function get_p_dts_name($id, $type, $m = 0, $getToken = 0)
{
	$out = '';
	if ($type == 1) {
		list($f_name, $ft_name, $l_name, $mobile, $phone, $token) = get_val('gnr_m_patients', 'f_name,ft_name,l_name,mobile,phone,token', $id);
		$out = $f_name . ' ' . $ft_name . ' ' . $l_name;
		if ($m) {
			$out .= '<br><ff14>' . $mobile . '</ff14>';
		}
		if ($m == 2 && $phone) {
			$out .= ' - <ff14>' . $phone . '</ff14>';
		}
	} else {
		list($f_name, $l_name, $mobile, $phone) = get_val('dts_x_patients', 'f_name,l_name,mobile,phone', $id);
		$out = $f_name . ' ' . $l_name;
		if ($m) {
			$out .= '<br><ff14>' . $mobile . '</ff14>';
		}
		if ($m == 2 && $phone) {
			$out .= ' - <ff14>' . $phone . '</ff14>';
		}
	}
	if ($getToken) {
		return [$out, $token];
	}
	return $out;
}
function conformDatePay($id)
{
	mysql_q("UPDATE dts_x_dates SET status=2 where id ='$id' ");
	datesTempUp($id);
}
function dateSubStatus($rec)
{
	global $datsCanclDo, $lg;
	$out = '';
	if ($rec['status'] == 5) {
		$id = $rec['id'];
		$r = getRec('dts_x_cancel', $id, 'dts');
		if ($r['r'] > 0) {
			$reason = get_val('dts_m_cancel_reson', 'reason', $r['reason']);
			$out .= '<div class="f1 fs12 clrb lh20">' . k_canceler . ' : ' . $datsCanclDo[$r['type']] . '</div>
			<div class="f1 fs12 clrb lh20">' . k_reason . ' : ' . $reason . '</div>
			<div class="f1 fs12 clrb lh20">' . k_canceled_by . ': ' . get_val('_users', 'name_' . $lg, $r['user']) . '</div>
			<div class="f1 fs12 clrb lh20">' . k_cancel_date . ' : <ff dir="ltr" class="fs14"> ' . date('Y-m-d Ah:i', $r['date']) . '</ff></div>';
			if ($r['note']) {
				$out .= '<div class="f1 fs12 clrb lh20">' . k_notes . ' : ' . nl2br($r['note']) . '</div>';
			}
		}
	}
	return $out;
}
function drowDatBloc($sty, $width, $s = '', $e = '', $title = '', $action = '', $ba = '', $time = 0)
{
	$out = '';
	$txt = '';
	if ($ba) {
		$st = 2;
		$show = 0;
		$actTxt = 'dateNo="' . $action . '"';
		if ($ba == 'e') {
			$st = 3;
			$ba = $action;
			$actTxt2 = 'dNo="' . $ba . '"';
		} else {
			$show = 1;
			$actTxt2 = 'dateNo="' . $ba . '"';
		}

		$blcTime = ($e - $s) / 60;
		if ($time > $blcTime && $show == 0) {
			$st = 4;
			$actTxt2 = '';
		}
		if (_set_t98lpjbfc2) {
			$out .= '<div class="fl dblc dblc_basy" style="width:' . $width . '%" >
                <div class="fl dblc dblc_basy1"  tp="1" ' . $actTxt . '></div>
                <div class="fl dblc dblc_basy' . $st . '"  tp="' . $st . '" ' . $actTxt2 . '></div>
            </div>';
		} else {
			$out .= '<div class="fl dblc dblc_basy" style="width:' . $width . '%" >
                <div class="fl dblc dblc_basy1" f tp="1" ' . $actTxt . '></div>                
            </div>';
		}
	} else {
		if ($title) {
			$title = ' title="' . $title . '"';
		}
		$out .= '<div class="fl dblc ' . $sty . '" style="width:' . $width . '%" s="' . $s . '" e="' . $e . '" ' . $title . ' ' . $action . '></div>';
	}
	return $out;
}
function getDts_SE_clinic($id)
{
	global $now;
	$s1 = $s2 = $e1 = $e2 = 0;
	$day = date('w', $now);
	$sql = "select t.* from gnr_m_users_times t , _users u where FIND_IN_SET($id,`clinic`) > 0 and FIND_IN_SET($day,`days`) > 0 and t.id=u.id and u.act=1 ";
	$res = mysql_q($sql);
	$rows = mysql_n($res);
	if ($rows) {
		while ($r = mysql_f($res)) {
			$type = $r['type'];
			$days = $r['days'];
			$data = $r['data'];
			if ($type == 1) {
				$time = $data;
			}
			if ($type == 2) {
				$d = explode(',', $days);
				foreach ($d as $k => $v) {
					if ($v == $day) {
						$d2 = explode('|', $data);
						$time = $d2[$k];
					}
				}
			}
			if ($time) {
				$dr = explode(',', $time);
				if ($dr[0]) {
					if (!$s1) {
						$s1 = $dr[0];
					} else {
						$s1 = min($s1, $dr[0]);
					}
				}
				if ($dr[2]) {
					if (!$s2) {
						$s2 = $dr[2];
					} else {
						$s2 = min($s2, $dr[2]);
					}
				}

				if ($dr[1]) {
					if (!$e1) {
						$e1 = $dr[1];
					} else {
						$e1 = max($e1, $dr[1]);
					}
				}
				if ($dr[3]) {
					if (!$e2) {
						$e2 = $dr[3];
					} else {
						$e2 = max($e2, $dr[3]);
					}
				}
			}
		}
	}
	return array($s1, $e1, $s2, $e2);
}
function delDate($id, $mood)
{
	if (mysql_q("DELETE from dts_x_dates where id='$id' and status<2 ")) {
		mysql_q("DELETE from dts_x_dates_services where dts_id='$id' ");
		datesTempUp($id);
		delTempOpr($mood, $id, 9);
		return 1;
	}
}
function checkFreeTimeToday($ids)
{
	global $now, $ss_day;
	$finTime = 0;
	$out = '';
	$idsArr = explode(',', $ids);
	foreach ($idsArr as $id) {
		list($s1, $e1, $s2, $e2) = getDts_SE_clinic($id); // تحديد الشفتات
		$s = $s1;
		$e = $e1;
		if ($e2) {
			$e = $e2;
			if ($s2 <= $e1) { // الشفتات متداخلة
				$e1 = $e2; // دمج الشفة الثاني بالاول
				$s2 = $e2 = 0; // الغاء الشفت الثاني
			}
		}
		$blcBasy1 = 0;
		$blcBasy2 = 0;
		$blcDone1 = 0;
		$blcDone2 = 0;
		$timeLine = ($now % 86400) - $s;
		$nowDay = ($now % 86400);

		$sql = "select * from dts_x_dates_temp where clinic ='$id' and reserve=0 order by d_start ASC ";
		$res = mysql_q($sql);
		$rows = mysql_n($res);
		if ($rows > 0) {
			$datT_Basy1 = 0;
			$datT_Basy2 = 0;
			while ($r = mysql_f($res)) {
				$d_id = $r['id'];
				$clinic = $r['clinic'];
				$date = $r['date'];
				$status = $r['status'];
				$d_start = $r['d_start'];
				$ds = $r['d_start'] - $ss_day;
				$de = $r['d_end'] - $ss_day;
				$other = $r['other'];
				$p_name = $r['pat_name'];
				$reserve = $r['reserve'];
				$p_note = '';

				$d_t = $de - $ds;

				if (in_array($status, array(1, 2, 3, 4, 6, 8))) {
					if ($ds >= $s1 && $ds < $e1) {
						$blcBasy1 += $d_t;
						if ($ds < $nowDay) { // حساب الاشغال الحقيقي بعد الزمن الحالي            
							if ($de > $nowDay) {
								$datT_Basy1 += $de - $nowDay;
							}
						} else {
							$datT_Basy1 += $de - $ds;
						}
					}

					if ($ds >= $s2 && $ds < $e2) {
						$blcBasy2 += $d_t;
						if ($ds < $nowDay) { // حساب الاشغال الحقيقي بعد الزمن الحالي            
							if ($de > $nowDay) {
								$datT_Basy2 += $de - $nowDay;
							}
						} else {
							$datT_Basy2 += $de - $ds;
						}
					}
				}
			}
		}
		if ($s) {
			$d_val = $s - ($s % 86400);
			$s_val = $s % 86400;
			//$e_val=$s_val+($timeN*60);
			$timeH = $s % 86400; //block time start by secunds
			$startM = ($s % 86400) / 60;
			$endM = ($e % 86400) / 60;
			$timeA = $endM - $startM;
			$hourWidth = 60 * 100 / $timeA;
			$lineWidth = 100 * (($timeLine) / 60) / $timeA;
			//echo clockStr(($blcBasy1+$blcBasy2),2);                
			$datT_All = $e1 - $s1 + $e2 - $s2;
			$s11 = $s1;
			$s22 = $s2;
			$e11 = $e1;
			$e22 = $e2;
			$statPoint = $timeLine + $s1;
			if ($statPoint > $s11) {
				$s11 = $statPoint;
			}
			if ($statPoint > $e11) {
				$s11 = $e11 = 0;
			}
			if ($s22) {
				if ($statPoint > $s22) {
					$s22 = $statPoint;
				}
				if ($statPoint > $e22) {
					$s22 = $e22 = 0;
				}
			}
			$datT_AllInTime1 = $e11 - $s11;
			$datT_AllInTime2 = $e22 - $s22;
			$datT_AllInTime = $e11 - $s11 + $e22 - $s22;
			//$datT_Free=clockStr($datT_Free);
			$datT_Basy = $datT_Basy1 + $datT_Basy2;
			$finTime += $datT_AllInTime - $datT_Basy;
		}
	}
	$clr = 'clr6';
	if ($finTime < 1200) {
		$clr = 'clr5';
	}
	$txt = k_avl . ' : <ff14>' . clockStr($finTime, 2) . '</ff14>';
	if ($finTime == 0) {
		$txt = k_no_appo_today;
	}
	$out = '
        <div class="fl lh20 f1 pd10 ' . $clr . '">' . $txt . '</div>
        ';
	return $out;
}
function addDtsSrviceAuto($r)
{
	global $srvTables;
	$s_id = 0;
	if (isset($_POST['service'])) {
		$s_id = pp($_POST['service']);
	}
	$dts_id = $r['id'];
	$clinic = $r['clinic'];
	$mood = $r['type'];
	$d_start = $r['d_start'];
	$d_end = $r['d_end'];
	$m_clinic = getMClinic($clinic);
	$ser_time = ($d_end - $d_start) / 60;
	$srvTable = $srvTables[$mood];
	mysql_q("Delete from dts_x_dates_services where `dts_id`='$dts_id'");
	if ($mood) {
		if ($s_id == 0) {
			if ($mood == 4) {
				$s_id = 1;
			} else {
				$s_id = get_val_con($srvTable, 'id', "act=1 and def=1 and clinic='$m_clinic' ");
			}
		}
		if ($s_id) {
			mysql_q("INSERT INTO dts_x_dates_services (`dts_id`, `service` ,`ser_time`) values ('$dts_id','$s_id','$ser_time')");
		}
	}
}
function alertPatDts($id, $patient, $pat_type, $time, $type = 1)
{
	$title = k_appo_remind;
	if ($type == 1) {
		$body = k_app_start_at . date('A h:i', $time);
	}
	if ($type == 2) {
		$body = k_forgot_appo_tomorrow . date('A h:i', $time);
	}

	if ($type == 1) {
		mysql_q("UPDATE dts_x_dates_temp set token='' where id='$id' ");
	}
	api_notif($patient, $pat_type, 41, $id, $title, $body);
}
