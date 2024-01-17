<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['code'])){
	$code=pp($_POST['code'],'s');	
	echo $title=$boxOpr[$code]['n'];
	echo '^';
	//echo $code;
	switch ($code){
		case 'dash':
			$actArr=array();
			$actArr[$n]='act';
			echo '<div class="ofx so pd10" fix="hp:0">';
			$all_bal=get_sum('gnr_x_tmp_cash','amount_in-amount_out+bal_in-bal_out');		
			echo '
			<div class=" f1 fs16 clr2 lh50  cb uLine">مجموعة أرصدة الصناديق <ff> [ '.number_format($all_bal).' ] </ff></div>
			<div>';
			$sql="select u.id as uid , u.name_$lg ,x.* from _users u , gnr_x_tmp_cash x where `grp_code` IN('buvw7qvpwq','pfx33zco65') and u.id=x.casher ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$u_id=$r['uid'];
					$name=$r['name_'.$lg];
					$cash_net=$r['amount_in']-$r['amount_out']+$r['bal_in']-$r['bal_out'];
					if($cash_net){
						echo '<div class="bord fl pd10 mg5f" fix="w:240">
							<div class="ff fs24 TC B clr66 b_bord lh50">'.number_format($cash_net).'</div>
							<div class="f1 fs12 lh30 clr3 TC ">'.$name.'</div>
						</div>';
					}
				}
			}	
			echo '</div>';		
			echo '</div>';
		break;
		case 'boxs':
			$addButt='';
			if(modPer('q8uc9l7htf',0)){
				$addButt='
				<div class="fr ic30x ic30_send icc1 ic30Txt mg10v" onclick="loc(\'Boxs-Payments\')">الذهاب إلى الارشيف</div>';
			}
			echo '<div class="fxg h100" fxg="gtr:60px 1fr|gap:10">
				<div class="f1 fs16 lh50 b_bord pd10">'.$addButt.'الصناديق العاملة</div>
                <div class="h100 of">
                    <div class="h100 ofx so">';
                        $sql="select * from _users where `grp_code` IN('buvw7qvpwq','pfx33zco65')";
                        $res=mysql_q($sql);
                        $rows=mysql_n($res);
                        if($rows>0){	
                            echo '<div class="hh10"></div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
                            <tr><th>'.k_box.'</th><th>'.k_incm_fnd.'</th><th>'.k_drawings.'</th><th>'.k_balance.'</th><th width="50"></th></th></tr>';
                            while($r=mysql_f($res)){
                                $u_id=$r['id'];
                                $name=$r['name_'.$lg];
                                $in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2,5,6,7,10) and casher='$u_id'");
                                $out=get_sum('gnr_x_acc_payments','amount'," type IN(3,4,8) and casher='$u_id'");
                                $box_in=$in-$out;
                                $box_out=get_sum('gnr_x_box_take','amount'," box='$u_id'");
                                $box_bal=$box_in-$box_out;
                                if($box_in || $box_out){
                                    echo '<tr>
                                    <td class="f1 fs14">'.$name.'</td>
                                    <td><ff class="clr6">'.number_format($box_in).'</ff></td>
                                    <td><ff class="clr5">'.number_format($box_out).'</ff></td>
                                    <td><ff class="clr1">'.number_format($box_bal).'</ff></td>
                                    <td>';
                                    $paymentDate=latePay($u_id);
                                    $today=$now-($now%86400);
                                    /*
                                    if($paymentDate<$today && $box_bal>0){
                                        echo '<div class="fr ic40 icc1 ic40_time " onclick="boxPayFix('.$u_id.')" title="'.k_reckoning.'"></div>';
                                    }*/			
                                    if($box_bal>0){
                                        echo '<div class="fr ic40 icc4 ic40_price " onclick="boxPay('.$u_id.','.$box_bal.')" title="'.k_withdraw_bal.'"></div>';
                                    }
                                    echo '</td>
                                    </tr>';	
                                }
                            }
                            echo '</table>';
                        }
                        echo '
                    </div>
                </div>
            </div>';
		break;
		case 'char':
			$cBal=getCharBal();
            $addButt='';
				if(modPer('by8c7tnngq',0)){
					$addButt='
					<div class="fr ic30x ic30_send icc1 ic30Txt mg10v" onclick="loc(\'Charity-payments\')">الذهاب إلى الارشيف</div>';
				}
			echo '
			<div class="fxg h100" fxg="gtc:280px 1fr|gtr:50px 1fr">
				<div class="f1 fs16  lh50 b_bord r_bord pd10">حالة الجمعيات</div>
                <div class="f1 fs16  lh50 b_bord pd10">'.$addButt.'الجمعيات</div>
                <div class="r_bord pd10f">
                    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s " >
                        <tr>
                            <td><div class="f1 fs16 clr1 lh40"> الخدمات المقدمة :</div></td>
                            <td><ff class="fs24 clr1">'.number_format($cBal['srvs']).'</ff></td>
                        </tr>
                        <tr>
                            <td><div class="f1 fs16 clr6 lh40"> دفعات الجمعيات  :</div></td>
                            <td><ff class="fs24 clr6">'.number_format($cBal['pay']).'</ff></td>
                        </tr>

                        <tr>
                            <td><div class="f1 fs16 clr5 lh40"> الحسومات :</div></td>
                            <td><ff class="fs24 clr5">'.number_format($cBal['dis']).'</ff></td>
                        </tr>

                        <tr>
                            <td><div class="f1 fs16 clr1 lh40"> الرصيد :</div></td>
                            <td><ff class="fs24 clr1">'.number_format($cBal['bal']).'</ff></td>
                        </tr>
                    </table>
                </div>
                <div class="of h100">
                    <div class="h100 ofx so">';
                    $sql="select * from gnr_m_charities order by name_$lg ASC ";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){
                        echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
                        <tr><th>الجمعية</th>
                        <th>الخدمات</th>
                        <th>الدفعات</th>
                        <th>الحسومات</th>
                        <th>الرصيد</th>
                        <th width="100"></th>
                        </tr>';
                        while($r=mysql_f($res)){
                            $c_id=$r['id'];
                            $name=$r['name_'.$lg];
                            $chBal=getCharBal($thisUser,$c_id);
                            echo '<tr>
                            <td class="f1 fs14">'.$name.'</td>
                            <td><ff class="clr1">'.number_format($chBal['srvs']).'</ff></td>
                            <td><ff class="clr6">'.number_format($chBal['pay']).'</ff></td>
                            <td><ff class="clr5">'.number_format($chBal['dis']).'</ff></td>
                            <td><ff class="clr1">'.number_format($chBal['bal']).'</ff></td>
                            <td>							
                                <div class="fr ic40 icc4 ic40_add" onclick="boxOpr(2,1,'.$c_id.')" title="دفعة من الجمعية"></div>
                                <div class="fr ic40 icc2 ic40_price" onclick="boxOpr(2,3,'.$c_id.')" title="حسم"></div>
                            </td>
                            </tr>';	

                        }
                        echo '</table>';
                    }else{
                        echo '<div class="f1 fs14 clr5 ">لايوجد عمليات سابقة</div>';
                    }
                echo '
                </div>
			</div>';
		break;
		case 'inse':		
			$iBal=getInsrBal();
            $addButt='';
            if(modPer('gjlx9g7fx6',0)){
                $addButt='
                <div class="fr ic30x ic30_send icc1 ic30Txt mg10v" onclick="loc(\'Insurance-Payments\')">الذهاب إلى الارشيف</div>';
            }
			echo '
			<div class="fxg h100" fxg="gtc:300px 1fr|gtr:50px 1fr">
				<div class="f1 fs16 lh50 b_bord pd10 r_bord">حالة شركات التأمين</div>
                <div class="f1 fs16 lh50 b_bord pd10">'.$addButt.'شركات التأمين</div>
                <div class="r_bord pd10f">
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s " >
					<tr>
						<td><div class="f1 fs16 clr1 lh40"> الخدمات المقدمة :</div></td>
						<td><ff class="fs24 clr1">'.number_format($iBal['srvs']).'</ff></td>
					</tr>
					<tr>
						<td><div class="f1 fs16 clr6 lh40"> دفعات التأمين  :</div></td>
						<td><ff class="fs24 clr6">'.number_format($iBal['pay']).'</ff></td>
					</tr>
					
					<tr>
						<td><div class="f1 fs16 clr5 lh40"> الحسومات :</div></td>
						<td><ff class="fs24 clr5">'.number_format($iBal['dis']).'</ff></td>
					</tr>
					
					<tr>
						<td><div class="f1 fs16 clr1 lh40"> الرصيد :</div></td>
						<td><ff class="fs24 clr1">'.number_format($iBal['bal']).'</ff></td>
					</tr>
				</table>                
			     </div>
			     <div class="of h100">
                    <div class="h100 ofx so">';
                    $sql="select * from gnr_m_insurance_prov order by name_$lg ASC ";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){
                        echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
                        <tr><th>الشركة</th>
                        <th>الخدمات</th>
                        <th>الدفعات</th>
                        <th>الحسومات</th>
                        <th>الرصيد</th>
                        <th width="100"></th>
                        </tr>';
                        while($r=mysql_f($res)){
                            $c_id=$r['id'];
                            $name=$r['name_'.$lg];
                            $inBal=getInsrBal($thisUser,$c_id);
                            echo '<tr>
                            <td class="f1 fs14">'.$name.'</td>
                            <td><ff class="clr1">'.number_format($inBal['srvs']).'</ff></td>
                            <td><ff class="clr6">'.number_format($inBal['pay']).'</ff></td>
                            <td><ff class="clr5">'.number_format($inBal['dis']).'</ff></td>
                            <td><ff class="clr1">'.number_format($inBal['bal']).'</ff></td>
                            <td>							
                                <div class="fr ic40 icc4 ic40_add" onclick="boxOpr(3,1,'.$c_id.')" title="دفعة شركة التأمين"></div>
                                <div class="fr ic40 icc2 ic40_price" onclick="boxOpr(3,3,'.$c_id.')" title="حسم"></div>
                            </td>
                            </tr>';	

                        }
                        echo '</table>';
                    }else{
                        echo '<div class="f1 fs14 clr5 ">لايوجد عمليات سابقة</div>';
                    }
                    echo '
                 </div>
			</div>';
		break;
		case 'expn':
			$month=date('m');
			$year=date('Y');
			$month_s=strtotime($year.'-'.$month.'-1');
			$month_e=strtotime($year.'-'.($month+1).'-1');
			$expnToday=get_sum('gnr_x_box_expenses','amount',"m_box='$thisUser' and date>='$ss_day'");
			$expnMonth=get_sum('gnr_x_box_expenses','amount',"m_box='$thisUser' and date>='$month_s' and date<'$month_e' ");
			$expnAll=get_sum('gnr_x_box_expenses','amount',"m_box='$thisUser' ");
            $addButt='';
            if(modPer('dutuht1wyf',1)){
                $addButt='<div class="fr ic30x icc2 ic30_add ic30Txt mg10v" onclick="addExpen()">إضافة مصروف</div>
                <div class="fr ic30x ic30_send icc1 ic30Txt mg10f" onclick="loc(\'Expenses\')">الذهاب إلى الارشيف</div>';
            }
            
			echo '            
            <div class="fxg h100" fxg="gtc:280px 1fr|gtr:60px 1fr">                
                <div class="f1 fs16  lh50 uLine r_bord pd10">المجاميع </div>
                <div class="f1 fs16  lh50 uLine pd10">'.$addButt.'أخر المصاريف المدفوعة</div>
                <div class="fl of so r_bord pd10">                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s " >
                        <tr>
                            <td><div class="f1 fs16 lh40">مصاريف اليوم :</div></td>
                            <td><ff class="fs24 clr1">'.number_format($expnToday).'</ff></td>
                        </tr>
                        <tr>
                            <td><div class="f1 fs16 lh40">مصاريف الشهر :</div></td>
                            <td><ff class="fs24 clr1">'.number_format($expnMonth).'</ff></td>
                        </tr>
                        <tr>
                            <td><div class="f1 fs16 lh40">إجمالي المصاريف :</div></td>
                            <td><ff class="fs24 clr1">'.number_format($expnAll).'</ff></td>
                        </tr>
                    </table>
                </div>
                <div class=" h100 of">
                    <div class="ofx so h100">';
                    $sql="select * from gnr_x_box_expenses where m_box='$thisUser' order by date DESC limit 20";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){
                        echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
                        <tr><th>التاريخ</th>
                        <th>المصروف</th>
                        <th>المبلغ</th>
                        <th>ملاحظات</th>
                        </tr>';
                        while($r=mysql_f($res)){
                            $e_id=$r['id'];
                            $date=$r['date'];
                            $amount=$r['amount'];
                            $cat=$r['cat'];
                            $expenses=$r['expenses'];
                            $note=$r['note']; 
                            $catName=get_val_arr('gnr_m_expenses_cat','name',$cat,'cat');
                            $expName=get_val_arr('gnr_m_expenses','name',$expenses,'exp');
                            echo '<tr>
                            <td><ff14>'.date('Y-m-d',$date).'</td>
                            <td class="f1 ">'.$catName.' - '.$expName.'</td>
                            <td><ff class="clr5">'.number_format($amount).'</ff></td>
                            <td><div class="f1 TL">'.nl2br($note).'</div></td>										
                            </tr>';	

                        }
                        echo '</table>';
                    }else{
                        echo '<div class="f1 fs14 clr5 ">لايوجد عمليات سابقة</div>';
                    }
                echo '</div>
                </div>
            </div>';		
		break;
		case 'tran':
			$bal=getMBoxBal($thisUser);
            $addButt='';
			if(modPer('fjprkmzmu8',0)){
				$addButt='				
				<div class="fr ic30x ic30_add icc4 ic30Txt mg10v" onclick="boxOpr(1,2)">دفعة جديدة</div>
				<div class="fr ic30x ic30_send icc1 ic30Txt mg10f" onclick="loc(\'Payments-For-Accounting\')">الذهاب إلى الارشيف</div>';
			}
			echo '			
			<div class="fxg h100" fxg="gtc:280px 1fr|gtr:50px 1fr">
				<div class="f1 fs16  lh50 b_bord pd10 r_bord">حالة الصندوق</div>
                <div class="f1 fs16  lh50 b_bord pd10 ">'.$addButt.'أخر عمليات التحويل </div>
                <div class="r_bord pd10f">
                    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s">
                        <tr>
                            <td><div class="f1 fs16 clr6 lh40"> الداخل :</div></td>
                            <td><ff class="fs24 clr6">'.number_format($bal['in']).'</ff></td>
                        </tr>
                        <tr>
                            <td><div class="f1 fs16 clr5 lh40"> الخارج :</div></td>
                            <td><ff class="fs24 clr5">'.number_format($bal['out']).'</ff></td>
                        </tr>
                        <tr>
                            <td><div class="f1 fs16 clr1 lh40"> الرصيد :</div></td>
                            <td><ff class="fs24 clr1">'.number_format($bal['bal']).'</ff></td>
                        </tr>
                    </table>
			     </div>';
			echo '<div class="of">				
				<div class="h100 ofx so">';
				$sql="select * from gnr_x_box_oprs where pay_type=1 and type=2 order by date DESC limit 25";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
					<tr><th width="120">'.k_date.'</th>
					<th width="120">'.k_amount.'</th>
					<th>'.k_notes.'</th></tr>';
					while($r=mysql_f($res)){
						$id=$r['id'];
						$date=$r['date'];
						$amount=$r['amount'];
						$note=$r['note'];
						echo '<tr>
						<td><ff14>'.date('Y-m-d',$date).'</ff14></td>
						<td><ff class="clr6">'.number_format($amount).'</ff></td>
						<td><div class="f1 TL">'.nl2br($note).'</div></td>
						</tr>';	
						
					}
					echo '</table>';
				}else{
					echo '<div class="f1 fs14 clr5 ">لايوجد عمليات سابقة</div>';
				}
			echo '</div>
			</div>';
		break;
		case 'othr':
			$in=get_sum('gnr_x_box_oprs_other','amount',"m_box='$thisUser' and type=1");
			$out=get_sum('gnr_x_box_oprs_other','amount',"m_box='$thisUser' and type=2");
            $addButt='';
            if(modPer('dutuht1wyf',1)){
                $addButt='<div class="fr ic30x icc2 ic30_add ic30Txt mg10v" onclick="addBoxOprs()">إضافة إجراء</div>
                <div class="fr ic30x ic30_send icc1 ic30Txt mg10f" onclick="loc(\'Other-Financial-Measures\')">الذهاب إلى الارشيف</div>';
            }
			echo '
			<div class="fxg h100" fxg="gtc:280px 1fr|gtr:50px 1fr">
				<div class="f1 fs16  lh50 b_bord r_bord pd10">المجاميع </div>
                <div class="f1 fs16  lh50 b_bord pd10">'.$addButt.'أخر الإجراءات</div>
                <div class="pd10f r_bord ">
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s " >
					<tr>
						<td><div class="f1 fs16 clr6 lh40">المقبوضات :</div></td>
						<td><ff class="fs24 clr6">'.number_format($in).'</ff></td>
					</tr>
					<tr>
						<td><div class="f1 fs16 clr5 lh40">المدفوعات :</div></td>
						<td><ff class="fs24 clr5">'.number_format($out).'</ff></td>
					</tr>
					
					<tr>
						<td><div class="f1 fs16 clr1 lh40">الفرق :</div></td>
						<td><ff class="fs24 clr1">'.number_format($in-$out).'</ff></td>
					</tr>
				</table>
			</div>
			<div class="of h100">                
				<div class="h100 ofx so">';
				$sql="select * from gnr_x_box_oprs_other where m_box='$thisUser' order by date DESC limit 20";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
					<tr><th>التاريخ</th>
					<th>الإجراء</th>
					<th>مقبوض</th>
					<th>مدفوع</th>
					</tr>';
					while($r=mysql_f($res)){
						$e_id=$r['id'];
						$date=$r['date'];
						$amount=number_format($r['amount']);
						$proc=$r['proc'];
						$type=$r['type'];
						$name=get_val_arr('gnr_x_box_oprs_other_items','name',$proc,'proc');
						$in=$out='-';
						if($type==1){$in=$amount;}else{$out=$amount;}
						echo '<tr>
						<td><ff14>'.date('Y-m-d',$date).'</td>
						<td class="f1 ">'.$name.'</td>
						<td><ff class="clr6">'.$in.'</ff></td>
						<td><ff class="clr5">'.$out.'</ff></td>		
						</tr>';
					}
					echo '</table>';
				}else{
					echo '<div class="f1 fs14 clr5 pd10f">لايوجد عمليات سابقة</div>';
				}
			echo '</div>
			</div>';		
		break;
		case 'baln':			
			echo '
			<div class="fl of pd10" fix="wp:0|hp:0">
				<div class="ofx so" fix="hp:0">';				
				$q=" m_box='$thisUser' ";
				$boxC=get_sum('gnr_x_box_take','amount',$q);
				$accPay=get_sum('gnr_x_box_oprs','amount',"$q and pay_type=1");

				$char=get_sum('gnr_x_box_oprs','amount',"$q and pay_type=2 and type=1");
				$insu=get_sum('gnr_x_box_oprs','amount',"$q and pay_type=3 and type=1");

				$other1=get_sum('gnr_x_box_oprs_other','amount',"$q and type=1");
				$other2=get_sum('gnr_x_box_oprs_other','amount',"$q and type=2");

				$expn=get_sum('gnr_x_box_expenses','amount',$q);
				$boxBal=[
					[$boxC,0,'مقبوضات من الصنناديق'],
					[0,$accPay,'تسليم دفعات للمحاسبة'],
					[$char,0,'الجمعيات'],
					[$insu,0,'التأمين'],
					[$other1,$other2,'إجراءات مالية أخرى'],
					[0,$expn,'المصروفات'],
				];
				echo '
				<div class="hh10"></div><table width="600" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
				<tr>
					<th>البيان</th>
					<th>مدين</th>
					<th>دائن</th>					
				</tr>';
				$allIn=$allOut=0;
				foreach($boxBal as $b){
					$in=$b[0];
					$out=$b[1];
					$allIn+=$in;
					$allOut+=$out;						
					echo '
					<tr>
						<td class="f1 ">'.$b[2].'</td>
						<td><ff class="clr6">'.number_format($in).'</ff></td>
						<td><ff class="clr5">'.number_format($out).'</ff></td>
					</tr>';
				}
				echo '
				<tr fot>
					<td class="f1 ">المجموع</td>
					<td><ff class="clr6">'.number_format($allIn).'</ff></td>
					<td><ff class="clr5">'.number_format($allOut).'</ff></td>
				</tr>
				<tr>
					<td class="f1 ">الرصيد</td>
					<td colspan="2"><ff class="clr1 fs24" >'.number_format($allIn-$allOut).'</ff></td>

				</tr>
				</table>';
				
			echo '
			</div>';		
		break;
	}
}?>