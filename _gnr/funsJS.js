/***GNR***/
$(document).ready(function (e) {
	if (sezPage == 'RespNew') { recSet(); }
	if (sezPage == 'Cln-visit-evaluation' ||
		sezPage == 'Lab-visit-evaluation' ||
		sezPage == 'Xry-visit-evaluation' ||
		sezPage == 'Den-visit-evaluation' ||
		sezPage == 'Bty-visit-evaluation' ||
		sezPage == 'lsr-visit-evaluation' ||
		sezPage == 'Osc-visit-evaluation') { ratingSet(); }
	if (sezPage == 'Nurses') { nursesSet(); }

});
function setUserTime(id) {
	loadWindow('#m_info', 1, k_daily_schedule, www, 200);
	$.post(f_path + "X/gnr_user_time.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#ds');
		setupForm('ds', 'm_info');
		$('div[par=w_d]').click(function () { showSetDays(); })
		showSetDays();
		fixForm();
		fixPage();
		fxObjects($('.win_body'));
	})
}
function showSetDays() {
	$('div[par=w_d]').each(function (index, element) {
		v = $(this).attr('ch_val');
		ch = $(this).children('div').attr('ch');
		if (ch == 'on') {
			$('tr[rn=d_' + v + ']').show();
		} else {
			$('tr[rn=d_' + v + ']').hide();
		}
	});
}
function dateType(n) {
	$('.rep_header div').removeClass('act');
	$('.rep_header div[n=n' + n + ']').addClass('act');
	$('div[bn]').hide();
	$('div[bn=n' + n + ']').show();
	$('#d_type').val(n);
}
function save_Dset() {
	type = $('#d_type').val();
	err = 0;
	if (type == 1) {
		var ss1 = parseInt($('select[name=sheft_s1]').val());
		var se1 = parseInt($('select[name=sheft_e1]').val());
		var ss2 = parseInt($('select[name=sheft_s2]').val());
		var se2 = parseInt($('select[name=sheft_e2]').val());
		//alert(ss1+'|'+se1+'|'+ss2+'|'+se2+'|'+ss3+'|'+se3)
		/*if(ss1==0 || se1==0){
			$('.ds_emsg').html(k_ent_on_wrk_sh);
			$('select[name=sheft_s1]').css('border','1px #f00 solid');
			$('select[name=sheft_e1]').css('border','1px #f00 solid');			
			err=1;
		}else{*/
		if (ss1 >= se1) {
			$('.ds_emsg').html(k_ent_tim_rit_seq);
			$('select[name=sheft_s1]').css('border', '1px #f00 solid');
			$('select[name=sheft_e1]').css('border', '1px #f00 solid');
			err = 1;
		} else {
			$('select[name=sheft_s1]').css('border', '');
			$('select[name=sheft_e1]').css('border', '');
		}

		if ((ss2 != 0 || se2 != 0) && (ss2 == 0 || se2 == 0)) {
			$('.ds_emsg').html(k_enr_emp_fld);
			$('select[name=sheft_s2]').css('border', '1px #f00 solid');
			$('select[name=sheft_e2]').css('border', '1px #f00 solid');
			err = 1;
		} else {
			$('select[name=sheft_s2]').css('border', '');
			$('select[name=sheft_e2]').css('border', '');

			if ((ss2 != 0) && (se1 > ss2)) {
				$('.ds_emsg').html(k_ent_tim_rit_seq);
				$('select[name=sheft_e1]').css('border', '1px #f00 solid');
				$('select[name=sheft_s2]').css('border', '1px #f00 solid');
				err = 1;
			} else {
				$('select[name=sheft_e1]').css('border', '');
				$('select[name=sheft_s2]').css('border', '');
			}
			if (ss2 >= se2 && ss2 != 0 && se2 != 0) {
				$('.ds_emsg').html(k_ent_tim_rit_seq);
				$('select[name=sheft_s2]').css('border', '1px #f00 solid');
				$('select[name=sheft_e2]').css('border', '1px #f00 solid');
				err = 1;
			}
			//}
		}
	}
	if (type == 2) {
		$('div[par=w_d]').each(function (index, element) {
			v = $(this).attr('ch_val');
			ch = $(this).children('div').attr('ch');
			if (ch == 'on') {
				$('tr[rn=d_' + v + ']').show();
				var ss1 = parseInt($('select[name=sheft_s1_' + v + ']').val());
				var se1 = parseInt($('select[name=sheft_e1_' + v + ']').val());
				var ss2 = parseInt($('select[name=sheft_s2_' + v + ']').val());
				var se2 = parseInt($('select[name=sheft_e2_' + v + ']').val());
				//alert(ss1+'|'+se1+'|'+ss2+'|'+se2+'|'+ss3+'|'+se3)
				/*if(ss1==0 || se1==0){
					$('.ds_emsg').html(k_ent_on_wrk_sh);
					$('select[name=sheft_s1_'+v+']').css('border','1px #f00 solid');
					$('select[name=sheft_e1_'+v+']').css('border','1px #f00 solid');			
					err=1;
				}else{*/
				if (ss1 >= se1) {
					$('.ds_emsg').html(k_ent_tim_rit_seq);
					$('select[name=sheft_s1_' + v + ']').css('border', '1px #f00 solid');
					$('select[name=sheft_e1_' + v + ']').css('border', '1px #f00 solid');
					err = 1;
				} else {
					$('select[name=sheft_s1_' + v + ']').css('border', '');
					$('select[name=sheft_e1_' + v + ']').css('border', '');
				}

				if ((ss2 != 0 || se2 != 0) && (ss2 == 0 || se2 == 0)) {
					$('.ds_emsg').html(k_enr_emp_fld);
					$('select[name=sheft_s2_' + v + ']').css('border', '1px #f00 solid');
					$('select[name=sheft_e2_' + v + ']').css('border', '1px #f00 solid');
					err = 1;
				} else {
					$('select[name=sheft_s2_' + v + ']').css('border', '');
					$('select[name=sheft_e2_' + v + ']').css('border', '');

					if ((ss2 != 0) && (se1 > ss2)) {
						$('.ds_emsg').html(k_ent_tim_rit_seq);
						$('select[name=sheft_e1_' + v + ']').css('border', '1px #f00 solid');
						$('select[name=sheft_s2_' + v + ']').css('border', '1px #f00 solid');
						err = 1;
					} else {
						$('select[name=sheft_e1_' + v + ']').css('border', '');
						$('select[name=sheft_s2_' + v + ']').css('border', '');
					}
					if (ss2 >= se2 && ss2 != 0 && se2 != 0) {
						$('.ds_emsg').html(k_ent_tim_rit_seq);
						$('select[name=sheft_s2_' + v + ']').css('border', '1px #f00 solid');
						$('select[name=sheft_e2_' + v + ']').css('border', '1px #f00 solid');
						err = 1;
					}
				}
				//}
			}
		})
	}
	if (err == 0) { $('#ds').submit(); }
}
var resAct = 1;
function res_ref(l) {
	if (l == 1) {
		if (resAct == 1) {
			$('.tapL_11').html(loader_win);
			$('.tapL_12').html(loader_win);
			$('.tapL_13').html(loader_win);
			$('.tapL_14').html(loader_win);
			$('.tapL_15').html(loader_win);
		}
		if (resAct == 2) {
			$('.tapL_21').html(loader_win);
			$('.tapL_22').html(loader_win);
		}
		if (resAct == 3) {
			$('.tapL_31').html(loader_win);
			$('.tapL_32').html(loader_win);
		}
	}

	scroll_t = $('.tapL_21').scrollTop();
	$.post(f_path + "X/gnr_visit_live.php", { t: resAct }, function (data) {
		d = GAD(data);
		dd = d.split('^');
		if (resAct == 1) {
			$('.tapL_11').html(dd[0]);
			$('.tapL_12').html(dd[1]);
			$('.tapL_13').html(dd[2]);
			$('.tapL_14').html(dd[3]);
			$('.tapL_15').html(dd[4]);
		}
		if (resAct == 2) {
			$('.tapL_22').html(dd[1]);
			$('.tapL_21').html(dd[0]);
		}
		if (resAct == 3) {
			$('.tapL_31').html(dd[0]);
			$('.tapL_32').html(dd[1]);
		}
		$('.clicListInTitle').html(dd[5]);
		$('#mwFooter').html(dd[6]);
		setSwichWin();
		fixPage();
		fixForm();
		$('.tapL_21').scrollTop(scroll_t);
	})
}
function setSwichWin() {
	$('.visTab').click(function () {
		s = $(this).attr('s');
		if (s == 'off') {
			$('.visTab').attr('s', 'off');
			n = $(this).attr('n');
			$('#res_tap1 , #res_tap2 , #res_tap3').hide();
			$('#res_tap' + n).show();
			$(this).attr('s', 'on');
			resAct = n;
			res_ref(1);
		}
	})
	if (resAct == 2) {
		$('div[clinc]').click(function () {
			c = $(this).attr('clinc');
			loadWindow('#m_info', 1, k_appointments, 700, 200);
			$.post(f_path + "X/dts_clinic_list.php", { id: c }, function (data) {
				d = GAD(data);
				$('#m_info').html(d);
				fixForm();
				fixPage();
			})
		})
	}
}
function showClinic() {
	if ($('#other_clinic').is(':visible')) { $('#other_clinic').slideUp(800); } else { $('#other_clinic').slideDown(800); }
}
function loadClinic(id, type, name, way) {
	$('#m_info').html(d);
	act_clinic = id;
	act_clinic_type = type;
	firstWord = k_clinic + ' : ';
	if (type != 1) { firstWord = ''; }
	act_clinic_name = firstWord + name;
	if (way == 1) {
		loadWindow('#m_info', 1, firstWord + name, 500, 200);
		$.post(f_path + "X/gnr_visit_add_level1.php", { c: act_clinic }, function (data) {
			d = GAD(data);
			$('#m_info').html(d);
			$('#pat_no').focus();
			loadFormElements('#docs');
			setupForm('docs', '');
			fixForm();
			fixPage();
		})
	} else {
		loadClinicManualWay(id, act_clinic_name, way);
	}
}
function loadClinicManualWay(id, act_clinic_name, way) {
	loadWindow('#full_win1', 1, act_clinic_name, 0, 0);
	$.post(f_path + "X/gnr_visit_add_patient.php", { c: act_clinic }, function (data) {
		d = GAD(data);
		$('#full_win1').html(d);
		fixForm();
		fixPage();
		$('.vis_pat_list [focus]').focus();
		setVisPat();
		setVisPatDo();
	})
}
function exemption(id, c_type) {
	act_ch_Ctype = c_type;
	loadWindow('#m_info', 1, k_exemptions, 550, 0);
	$.post(f_path + "X/gnr_visit_exemption_add.php", { id: id, t: c_type }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#vexe_form');
		setupForm('vexe_form', 'm_info');
		fixForm();
		fixPage();
	})
}
function exe_ref(l, id = 0) {
	if (l == 1) { $('#exReq').html(loader_win); }
	$.post(f_path + "X/gnr_exemption_live.php", {}, function (data) {
		d = GAD(data);
		$('#exReq').html(d);
		if (id != 0) { ex_det(id); }
		fixPage();
		fixForm();
	})
}
var actExRec = 0;
function exe_det(id) {
	actExRec = id;
	$('#exDet').html(loader_win);
	$.post(f_path + "X/gnr_exemption_info.php", { id: id }, function (data) {
		d = GAD(data);
		$('#exDet').html(d);
		loadFormElements('#ex_form');
		setupForm('ex_form');
		setDisopr();
		fixForm();
		fixPage();
	})
}
function setVisPat() {
	$('input[ser_p]').keyup(function () {
		$('#visPatList').html(loader_win);
		clearTimeout(visPa_ser);
		visPa_ser = setTimeout(function () { setVisPatDo(); }, 800);
	})
}
function setVisPatDo() {
	$('#visPatList').html(loader_win);
	ser_par = '';
	$('input[ser_p]').each(function () {
		sp = $(this).attr('ser_p');
		s_val = $(this).val();
		if (ser_par != '') { ser_par += '|'; }
		ser_par += sp + ':' + s_val;
	})
	$.post(f_path + "X/gnr_visit_add_patient_list.php", { pars: ser_par, c: act_clinic }, function (data) {
		d = GAD(data);
		$('#visPatList').html(d);
		fixForm();
		fixPage();
		$('.plistV > div[pn]').click(function () {
			addThis = 1;
			req = $('#ri_doc').attr('req');
			if (req == 1) {
				if ($('#ri_doc').val() == 0) { addThis = 0; }
			}
			if (addThis) {
				pn = $(this).attr('pn');
				serNPat_do(pn, 0);
				win('close', '#full_win1');
				loadWindow('#m_info', 1, k_clin_srvcs, 600, 0);
			} else {
				nav(2, k_doc_choos);
			}
		})
	})
}
function newPaVis(d) {
	addThis = 1;
	req = $('#ri_doc').attr('req');
	if (req == 1) {
		if ($('#ri_doc').val() == 0) { addThis = 0; }
	}
	if (addThis) {
		co_loadForm(0, 3, "p7jvyhdf3|id|serNPat_do([id],0);win('close','#full_win1');win('open','#m_info');$('#m_info').html(loader_win);|" + d);
	} else {
		nav('2', k_doc_choos);
	}
}

function editPaVis(id, type, t = 1) {
	mod = 'p7jvyhdf3';
	//p7jvyhdf3
	if (t != 1) { mod = 'u18qfm9oyb'; }
	if (type == 0) {
		co_loadForm(id, 3, mod + "|id|check_card_do([id])|");
	} else if (type == 'r') {
		co_loadForm(id, 3, mod + "|id|serNPat_do(" + id + ",0)|");
	} else {
		co_loadForm(id, 3, mod + "|id|dateINfo(" + type + ")|");
	}
}
function serNPat(t) {
	p_no = $('#pat_no').val();
	if (p_no != '') { if (t == 1) { serNPat_do(p_no, 0); } else { if (p_no.length >= 7) { serNPat_do(p_no, 0); } } }
}
var selctedDoc = 0;
function serNPat_do(p_no, vis) {
	selctedDoc = 0;
	act_pat = p_no;
	$('#pat_no').val('');
	$('#nv_l1').hide();
	$('#nv_l2').html(loader_win);
	s_doc = $('#ri_doc').val();
	selctedDoc = s_doc;
	$.post(f_path + "X/gnr_visit_add_level2.php", { p: act_pat, c: act_clinic, t: act_clinic_type, doc: s_doc, vis: vis }, function (data) {
		d = GAD(data);
		dd = d.split('^');
		if (dd[0] == 0) {
			$('#nv_l1').show();
			$('#pat_no').focus();
			$('#nv_l2').html(dd[1]);
			fixForm();
			fixPage();
		} else {
			$('#m_info').dialog('option', 'width', 700);
			$('#m_info').html(dd[1]);
			$('#ssin').focus();
			loadFormElements('#n_visit');
			setupForm('n_visit', 'm_info');
			serTotalCount();
			if (act_clinic_type != 1 && act_clinic_type != 4 && act_clinic_type != 17) {
				$('#m_info').dialog('option', 'width', www);
				$('#m_info').dialog('option', 'height', hhh);
				resAnaSet(act_clinic_type);
				resAnaSet2(0);
			} else {
				sers_set();
			}
			if (act_clinic_type == 7) {
				$('.ana_list_mdc div').click(function () {
					err = 0;
					mdc = $(this).attr('mdc');
					$('#oscSrv').val(mdc);
					if ($('#docFees').length) {
						docFees = $('#docFees').val();
						if (docFees == '') { err = 1; }
					}
					if (err == 1) {
						nav(3, k_doctor_fees_det);
						$('#docFees').css('border', '1px #f00 solid');
						$('#docFees').focus();
					} else {
						sub('n_visit');
					}
				})
			}
			if (act_clinic_type == 1 || act_clinic_type == 5 || act_clinic_type == 7) {
				$('#servSelSrch').focus();
				$('#servSelSrch').keyup(function () { serServList(); })
			}
			fixForm();
			fixPage();
		}
	})
}
var actAnaCat = 0;
var cardPay = 0;
function resAnaSet(type) {
	$('.ana_list_cat div').click(function () {
		num = $(this).attr('cat_num');
		if (actAnaCat != num) {
			$(this).addClass('actCat');
			$(this).removeClass('norCat');
			$('.ana_list_cat div[cat_num=' + actAnaCat + ']').addClass('norCat');
			$('.ana_list_cat div[cat_num=' + actAnaCat + ']').removeClass('actCat');
			if (num == 0) {
				$('.ana_list_mdc div[del=0]').slideDown(400);
			} else {
				$('.ana_list_mdc div[del=0]').slideUp(400);
				$('.ana_list_mdc div[cat_mdc=' + num + '][del=0]').slideDown(400);
			}
			actAnaCat = num;
			$('#ssin').val(''); $('#ssin').focus(); serServIN('');
		}
	})
	ana_basy = 0;
	$('.ana_list_mdc div').click(function () {
		mdc = $(this).attr('mdc');
		clickanaList(mdc, type)

	})
}
function saveRecSrvs(mood) {
	subF = 1;
	if (mood == 3) {
		t = $('#srvData tr[mdc]').length;
		if (t == 0) {
			subF = 0;
			nav(2, k_must_sel_srvc);
		}
	}
	if (mood == 1) {
		$('input[qunt]').each(function () {
			v = parseInt($(this).val());
			if (v > 10) {
				$(this).css('border', '1px #f00 solid');
				$(this).focus();
				subF = 0;
				nav(3, k_ser_not_repeat);
			} else {
				$(this).css('border', '');
			}
		})
	}
	if (subF == 1) { sub('n_visit'); }
}
function clickanaList(mdc, type) {
	thisItem = $('.ana_list_mdc div[mdc=' + mdc + ']')
	name = thisItem.attr('name');
	price = thisItem.attr('price');
	del = thisItem.attr('del');
	if (del == 0) {
		$(this).attr('del', '1');
		fixPage();
		var stopAdd = 0;
		$('.list_del').each(function (index, element) { id = $(this).attr('no'); if (id == mdc) { stopAdd = 1; } });
		if (stopAdd == 0) {
			if (type == 3) {
				dd = '<tr mdc="' + mdc + '" p="' + price + '"><td class="f1">' + name + '</td><td><ff>' + price + '</ff></td><td><div class="ic40 icc2 ic40_del" no="' + mdc + '" title="' + k_delete + '"></div>\
				<input name="ser_'+ mdc + '" type="hidden" value="' + price + '"></td></tr>';
				$('#srvData').append(dd);
				resAnaSet2(mdc);
				$('#saveButt').show(300);
			}
			if (type == 2) {
				drowLabSrv(mdc, price, name);
			}
			if (type == 5) {
				dd = '<tr mdc="' + mdc + '" p="' + price + '"><td class="f1">' + name + '</td><td><ff>' + price + '</ff></td><td><div class="ic40 icc2 ic40_del" no="' + mdc + '" title="' + k_delete + '"></div>\
				<input name="ser_'+ mdc + '" type="hidden" value="' + price + '"></td></tr>';
				$('#srvData').append(dd);
				resAnaSet2(mdc);
				$('#saveButt').show(300);
			}
			if (type == 6) {
				dd = '<tr mdc="' + mdc + '" p="' + price + '"><td class="f1">' + name + '</td><td><div class="ic40 icc2 ic40_del" no="' + mdc + '" title="' + k_delete + '"></div>\
				<input name="ser_'+ mdc + '" type="hidden" value="' + price + '"></td></tr>';
				$('#srvData').append(dd);
				resAnaSet2(mdc);
				$('#saveButt').show(300);
			}
		}
		$('#ssin').val(''); $('#ssin').focus(); serServIN('');
	}

}
function resAnaSet2(id) {
	$('#saveButt').show(300);
	$('.ana_list_mdc div[mdc=' + id + ']').attr('del', '1');
	$('.ana_list_mdc div[del=1]').slideUp(300);
	//$('.ana_list_mdc div[mdc='+id+']').slideUp(400);	
	$('.ic40_del[no=' + id + ']').click(function () {
		id = $(this).attr('no');
		$(this).closest('tr').remove();
		if ($('tr[mdc][p]').length == 0) {
			showSaveButt(1);
		}
		$('.ana_list_mdc div[mdc=' + id + ']').slideDown(400);
		$('.ana_list_mdc div[mdc=' + id + ']').attr('del', '0');
		countAmountss();
	})
	$('.ana_list_mdc div[mdc=' + id + ']').slideUp(400);
	countAmountss();
}
function countAmountss() {
	pp = 0;
	cc = 0;
	$('tr[mdc][p]').each(function (index, element) {
		pp += parseInt($(this).attr('p'));
		cc++;
	});
	$('#serTotal').html(pp);
	$('#countAna').html('( ' + cc + ' ) ');
}
function selUserGroup(v) {
	$('#setGU').html(loader_win);
	f = $('#setGU').attr('f');
	$.post(f_path + "X/gnr_user_sett.php", { v: v, f: f }, function (data) {
		d = data.split('<!--***-->');
		$('#setGU').html(d);
		fixForm();
		fixPage();
		loadFormElements('#co_form0')
	})
}
function pr_card(id) {
	//$('#pc'+id).html(k_loading);
	$.post(f_path + "X/gnr_patient_card_print.php", { id: id }, function (data) {
		d = GAD(data);
		if (d > 0) {
			msg = k_done_successfully; pr_card_pay(id, d);
		} else {
			msg = k_done_successfully; pr_card_p(id);
		}
	})
}
function pr_card_p(id) {
	setTimeout(function () { loadModule('Patients'); }, 2500);
	win('close', '#m_info');
	printWindowC(1, id);
}
function pr_card_pay(id, amount) {
	open_alert(id, 16, k_crd_pd + ' <ff> ( ' + amount + ' ) </ff> ' + k_sp, k_py_crd_val);
}
function cardPayDo(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_patient_card_print_payment.php", { id: id }, function (data) {
		d = GAD(data);

		if (d == 'x') { msg = k_error_data; mt = 0; } else {
			msg = k_done_successfully; mt = 1;
			//if(d==1){
			pr_card(id);
			//}	
		}
		loader_msg(0, msg, mt);
	})
}
function d_vis_Play(id, s, mod, newDenPrv = '0') {
	if (s == 1) {
		loadWindow('#m_info', 0, k_procedure, 400, 0);
		$.post(f_path + "X/gnr_visit_role_info.php", { id: id, mod: mod }, function (data) {
			d = GAD(data);
			$('#m_info').html(d);
			fixForm();
			fixPage();
		})
	} else {
		$.post(f_path + "X/gnr_visit_role_change_status.php", { id: id, s: s, mod: mod }, function (data) {
			win('close', '#m_info');
			if (s == 2) {
				d = GAD(data);
				if (d != '') {
					if (sezPage == 'vis_lab') { samples_ref(0); openLabSWin(1, d); }
					if (sezPage == 'vis_cln') { addVisToDoc(d); }
					if (sezPage == 'vis_xry') { addVisToDoc(d); }
					if (sezPage == 'vis_bty') { addVisToDoc(d); }
					if (sezPage == 'vis_osc') { addVisToDoc(d); }
					if (sezPage == 'vis_den') {
						if (newDenPrv == '1') {
							loc(f_path + '_Preview-Den-New.' + d);
						} else {
							loc(f_path + '_Preview-Den.' + d);
						}
					}
					if (sezPage == 'Preview-Clinic') { addVisToDoc(d); }
					if (sezPage == 'Preview-Xray') { addVisToDoc(d); }
					if (sezPage == 'Preview-Osc') { addVisToDoc(d); }

					if (sezPage == 'Visits-Missed') {
						if (mod == 3) { loc(f_path + '_Preview-Xray.' + d); }
						if (mod == 1) { loc(f_path + '_Preview-Clinic.' + d); }
						if (mod == 7) { loc(f_path + '_Preview-Osc.' + d); }
					}

				} else {
					if (sezPage == 'vis_lab') { samples_ref(0); d_vis_Play(id, 1, 2); }
				}
			} else {
				if (sezPage == 'vis_lab') { samples_ref(0); if (s != 3) { d_vis_Play(id, 1, 2); } }
				if (sezPage == 'vis_cln') {
					if (mod != 1) { loadPrvSwitch(); } else { cln_vit_d_ref(1) }; if (s != 3) { d_vis_Play(id, 1, mod); }
				}
				if (sezPage == 'vis_xry') {
					if (mod != 3) { loadPrvSwitch(); } else { xry_vit_d_ref(1) }; if (s != 3) { d_vis_Play(id, 1, mod); }
				}
				if (sezPage == 'vis_den') {
					if (mod != 4) { loadPrvSwitch(); } else { den_vit_d_ref(1) }; if (s != 3) { d_vis_Play(id, 1, mod); }
				}
				if (sezPage == 'vis_bty') {
					if (mod != 5 && mod != 6) { loadPrvSwitch(); } else { bty_vit_d_ref(1) }; if (s != 3) { d_vis_Play(id, 1, mod); }
				}
				if (sezPage == 'vis_osc') {
					if (mod != 7) { loadPrvSwitch(); } else { osc_vit_d_ref(1) }; if (s != 3) { d_vis_Play(id, 1, mod); }
				}
				if (sezPage == 'Preview-Clinic') { if (s != 3) { d_vis_Play(id, 1, mod); } }
				if (sezPage == 'Preview-Xray') { if (s != 3) { d_vis_Play(id, 1, mod); } }

				if (sezPage == 'Visits-Missed') {
					if (mod == 3) { loc(f_path + '_Preview-Xray.' + d); }
					if (mod == 1) { loc(f_path + '_Preview-Clinic.' + d); }
					if (mod == 7) { loc(f_path + '_Preview-Osc.' + d); }
				}
			}
		})
	}
}
function serServIN(str) {
	if (labAnLang != '3') { str = str.toLowerCase(); }
	strSel = '';
	if (actAnaCat != 0) { strSel = '[cat_mdc=' + actAnaCat + ']'; }
	if (str == '') {
		$('.norCat[del=0]' + strSel).show();
	} else {
		$('.norCat[del=0]' + strSel).each(function (index, element) {
			s_id = $(this).attr('mdc');
			code = $(this).attr('code').toLowerCase();
			txt = $(this).attr('name')
			if (labAnLang != '3') { txt = txt.toLowerCase(); }

			n = txt.search(str);
			n2 = code.search(str);
			if (n != (-1) || n2 != (-1)) { $(this).show(); } else { $(this).hide(); }
		})
	}
}
function stopRow(t) {
	d = '<div class="win_body"><div class="form_body so">\
	<div class="fs18 f1 clr1 lh40">'+ k_ent_ps_tm + '</div>\
	<select style="font-family:arial;font-size:16px;" id="stopVal">\
	<option value="300">5 '+ k_minute + '</option>\
	<option value="600">10 '+ k_minute + '</option>\
	<option value="1200">20 '+ k_minute + '</option>\
	<option value="1800">30 '+ k_minute + '</option>\
	<option value="2700">45 '+ k_minute + '</option>\
	<option value="3600">'+ k_hour + '</option>\
	<option value="5400">'+ k_hr_hlf + '</option>\
	<option value="7200">'+ k_tw_hrs + '</option>\
	<option value="9000">'+ k_tw_hlf_hrs + '</option>\
	<option value="10800">3 '+ k_hrs + '</option>\
	<option value="14400">4 '+ k_hrs + '</option>\
	<option value="18000">5 '+ k_hrs + '</option>\
	</select>\
	</div><div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win(\'close\',\'#m_info\')">'+ k_cancel + '</div>\
    <div class="bu bu_t1 fl" onclick="stopRowDo(1,'+ t + ')">' + k_save + '</div></div>';
	loadWindow('#m_info', 1, k_pse, 400, 0);
	$('#m_info').html(d);
	fixPage();
	fixForm();
}
function stopRowDo() {
	s_val = $('#stopVal').val();
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_doc_stop_role.php", { v: s_val }, function (data) {
		d = GAD(data);
		if (d == 1) { msg = k_done_successfully; mt = 1; win('close', '#m_info'); } else { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
		if (sezPage == 'vis_lab') { samples_ref(0); }
		if (sezPage == 'vis_cln') { cln_vit_d_ref(0); }
		if (sezPage == 'vis_xry') { xry_vit_d_ref(0); }
		if (sezPage == 'vis_den') { den_vit_d_ref(0); }
		if (sezPage == 'vis_bty') { bty_vit_d_ref(0); }

	})
}
function editPat(id) {
	win('close', '#m_info');
	co_loadForm(id, 3, 'p7jvyhdf3||loadModule()|');
}
function showVisits(id) {
	loadWindow('#m_info', 1, k_pat_vis, www, hhh);
	$.post(f_path + "X/gnr_patient_archive.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function printpaVisits(id) { print4(1, id); }
function showRackAlert(n) {
	out = '';
	if (n > 0) {
		out += '<div class="alert_nav_in" onclick="loc(\'' + f_path + '_Lab-Alert\')"><div class="f1 fs14 TC">' + k_new_tests_added_to_samples + ' <ff> ( ' + n + ' )</ff></div></div>';
		if (out) { $('#alert_box').html(out); }
		if ($('#alert_box').not(':visible')) { $('#alert_box').fadeIn(500); }
	} else { $('#alert_box').fadeOut(500, function () { $('#alert_box').html(''); }); }
}
function selPaSex(id) {
	if (sezPage == 'Patients') {
		loadWindow('#m_info', 0, k_sex_choose, 300, 0);
		$('#m_info').html('<div class="f1 fs16 clr1 lh40 TC">' + k_must_sel_sex + '<div><div class="selSex fl"><div s1 class="fl"></div><div s2 class="fr"></div></div>');
		$('.selSex div[s1]').click(function () { selPaSexDo(id, 1); })
		$('.selSex div[s2]').click(function () { selPaSexDo(id, 2); })
		$('#m_info').dialog('option', 'closeOnEscape', false);
	}
}
function selPaSexDo(id, n) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_patient_sel_sex.php", { id: id, n: n }, function (data) {
		d = GAD(data);
		if (d == 1) { msg = k_done_successfully; mt = 1; pr_card(id); }
		if (d == 0) { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
		win('close', '#m_info');
		$('#m_info').dialog('option', 'closeOnEscape', true);
	})
}
function setDocCusTime(id, t) {
	loadWindow('#m_info', 1, k_srv_time_edit, 600, 200);
	$.post(f_path + "X/gnr_service_doctor_time.php", { id: id, t: t }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#cst');
		setupForm('cst', 'm_info');
		fixForm();
		fixPage();
	})
}
function setDocCusPrice(id, t) {
	loadWindow('#m_info', 1, k_srv_price_edit, 700, 600);
	$.post(f_path + "X/gnr_service_doctor_price.php", { id: id, t: t }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#cst');
		setupForm('cst', 'm_info');
		fixForm();
		fixPage();
	})
}
function stopClinic(type) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_doc_stop_clinic.php", { t: type }, function (data) {
		d = GAD(data);
		if (d == 1) { msg = k_done_successfully; mt = 1; win('close', '#m_info'); } else { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
		if (sezPage == 'vis_cln') { cln_vit_d_ref(0); }
		if (sezPage == 'vis_xry') { xry_vit_d_ref(0); }
		if (sezPage == 'vis_den') { den_vit_d_ref(0); }
		if (sezPage == 'vis_bty') { bty_vit_d_ref(0); }
	})
}
function setInsurPrice(id, type) {
	loadWindow('#m_info', 1, k_price_serv, 700, 200);
	$.post(f_path + "X/gnr_insur_price.php", { id: id, t: type }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#cst');
		setupForm('cst', 'm_info');
		fixForm();
		fixPage();
	})
}
function printSercInsurList(type, id, f) {
	if (f == 1) { url = f_path + 'Print-gnr/Insur/' + type + '-' + id; }
	if (f == 2) { url = f_path + 'Excel-gnr/Insur/' + type + '-' + id; }
	popWin(url, 800, 600);
}
function ins_ref(l = 0) {
	if (l == 1) { $('#inReq,#inReqW').html(loader_win); }
	$.post(f_path + "X/gnr_insur_live.php", {}, function (data) {
		d = GAD(data);
		dd = d.split('^');
		$('#inReq').html(dd[0]);
		$('#inReqW').html(dd[1]);
		fixPage();
		fixForm();
	})
}

var actInsur = 0;
var actNewInsur = 0;
function ins_det(id, ins = 0) {
	actInsur = ins;
	actNewInsur = id;
	$('#insDet').html(loader_win);
	$.post(f_path + "X/gnr_insur_rec_info.php", { id: id, in: ins }, function (data) {
		d = GAD(data);
		$('#insDet').html(d);
		loadFormElements('#in_rec');
		setupForm('in_rec');
		setDisopr(1);
		fixForm();
		fixPage();
	})
}
function insurNewRec(id, insur) {
	actInsur = insur;
	actNewInsur = id;
	loadWindow('#m_info', 1, k_insur_req_create, 700, 200);
	$.post(f_path + "X/gnr_insur_rec_new.php", { id: id, in: insur }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#in_rec');
		setupForm('in_rec', 'm_info');
		fixForm();
		fixPage();
	})
}
function newInsurAcc(id, pat) {
	co_loadForm(0, 3, "pqz1u7pu6k|id|ins_det(" + id + ",[id])|patient:" + pat + ":hh");
}
var actVisSrvDel = 0;
var actVisSrvMoodDel = 0;
function delSerINsur(sev, vis, mood) {
	actVisSrvDel = vis;
	actVisSrvMoodDel = mood;
	open_alert(sev, 'ins_2', k_wld_del_srv, k_srv_del);
}
function delSerINsurDo(sev) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_insur_req_del.php", { sev: sev, vis: actVisSrvDel, mood: actVisSrvMoodDel }, function (data) {
		d = GAD(data);
		if (d == 1) { msg = k_done_successfully; mt = 1; ins_det(actNewInsur, actInsur); }
		if (d == 0) { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
	})
}
function insurReqCancle(id, mood) {
	actVisSrvMoodDel = mood; open_alert(id, 'ins_3', k_insurance_req_del, k_cnl_rq);
}
function insurReqDel(id, mood) { actVisSrvMoodDel = mood; open_alert(id, 'ins_4', k_wnt_dl_vis, k_dl_vis); }
function insurReqCancleDelDo(id, type) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_insur_req_del.php", { id: id, type: type, mood: actVisSrvMoodDel }, function (data) {
		d = GAD(data);
		if (d == 1) { msg = k_done_successfully; mt = 1; win('close', '#m_info'); $('#insDet').html(''); ins_ref(1); }
		if (d == 0) { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
	})
}
function sendInsurReq() {
	sele = $('div[par=s] input').length;
	if (sele == 0) { nav(1, k_must_sel_srvc); } else { sub('in_rec'); }
}
function insurResEnter(id) {
	$('#insDet').html(loader_win);
	$.post(f_path + "X/gnr_insur_res_add.php", { id: id }, function (data) {
		d = GAD(data);
		$('#insDet').html(d);
		loadFormElements('#in_rec');
		setupForm('in_rec', '');
		setAoutoPers();
		setDisopr(1);
		fixForm();
		fixPage();
	})
}
function setAoutoPers() {
	$('table.selList [ch]').click(function () {
		s = $(this).attr('ch')
		if (s == 'on') {
			$(this).closest('tr').children('td').css({ 'opacity': '0.5' })
		} else {
			$(this).closest('tr').children('td').css({ 'opacity': '1' })
		}
	})
	$('table.selList [par=chAll]').click(function () {
		s = $(this).find('[ch]').attr('ch');
		if (s == 'off') {
			$('table.selList [ch]').closest('tr').children('td').css({ 'opacity': '0.5' })
		} else {
			$('table.selList [ch]').closest('tr').children('td').css({ 'opacity': '1' })
		}
	})
	$('table.selList [type=radio]').click(function () {
		if ($(this).val() == '2') {
			$(this).closest('tr').children('td').css('background', clr555);
		} else {
			$(this).closest('tr').children('td').css('background', '');
		}
	})

}
function insurReqSave() {
	if ($('#in_rec td [ch=on]').length > 0) {
		sub('in_rec');
	}
}
function backInsur(id, amount) {
	open_alert(id, 'ins_5', k_ret_remain_to_pat + ' <ff> ( ' + amount + ' ) </ff>  ؟', k_amount_ret);
}
function backInsurDo(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_insur_back_pay.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) { msg = k_done_successfully; mt = 1; loadModule('c08657nu7'); }
		if (d == 0) { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
	})
}
function addVisToDoc(vis) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_doctor_link.php", { vis: vis }, function (data) {
		d = GAD(data);
		if (d != 0) {
			urP = '';
			if (d == 1) { urP = '_Preview-Clinic.'; }
			if (d == 3) { urP = '_Preview-Xray.'; }
			if (d == 5) { urP = '_Preview-Beauty.'; }
			if (d == 6) { urP = '_Preview-Laser.'; }
			if (d == 7) { urP = '_Preview-Osc.'; }
			loc(f_path + urP + vis);
		} else { loader_msg(0, k_error_data, 0); }
	})
}
var actMoodDel = 0;
function delServ(id, mood) {
	actMoodDel = mood;
	open_alert(id, 'gnr_1', k_wld_del_srv, k_srv_del);
}
function delServDo(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_service_del.php", { id: id, mood: actMoodDel }, function (data) {
		d = GAD(data);
		if (d != 0) {
			urP = '';
			if (sezPage == 'RespNew') {
				recNewVisSrvSta(actNewVis, actNewVisMood);
			} else {
				viSts(actMoodDel, d);
			}

			loader_msg(0, '', 0);
		} else { loader_msg(0, k_error_data, 0); }
	})
}
function changPoint(p) {
	if (p == 0) { loadWindow('#m_info', 1, k_recep_point, 400, 200); } else { loader_msg(1, k_loading); }
	$.post(f_path + "X/gnr_change_point.php", { p: p }, function (data) {
		d = GAD(data);
		if (p == 0) {
			$('#m_info').html(d);
			fixForm();
			fixPage();
		} else {
			loader_msg(1, k_loading);
			win('close', '#m_info')
			loc('');
		}
	})
}
function newCinic(t) {
	title = k_new_appoi + ' ( ' + k_clinics + ' )';
	if (t == 1) { title = k_new_visit; }
	loadWindow('#m_info', 1, title, www, 200);
	$.post(f_path + "X/gnr_clinic_new_service.php", { t: t }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
		$('#nd_c').focus();
		$('#nd_c').keyup(function () { serClincIN($(this).val()); })
		if (t == 2) {
			$('[Ctxt]').click(function () { selDtSrvs($(this).attr('no'), 0, 0); });
		}
	})
}

function serClincIN(str) {
	str = str.toLowerCase();
	if (str == '') {
		$('[Ctxt]').show(300);
	} else {
		$('[Ctxt]').each(function (index, element) {
			txt = $(this).attr('Ctxt').toLowerCase();
			n = txt.search(str);
			if (n != (-1)) { $(this).show(300); } else { $(this).hide(300); }
		})
	}
}
function showAcc(id, type) {
	loadWindow('#m_info', 1, k_details, www, 0);
	$.post(f_path + "X/gnr_acc_visit_info_edit.php", { id: id, type: type }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		setupForm('acc_form', 'm_info');
		setAccCal();
		if (type == 4) {
			setDenVisChange();
		} else {
			setDateChange();
		}
		fixPage();
	})
}
function showDocVis(id) {
	loadWindow('#m_info4', 1, k_details, 600, 0);
	$.post(f_path + "X/gnr_visit_info_doc.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info4').html(d);
		fixPage();
	})
}
function setAccCal() {
	$('input[t=srv]').keyup(function () { calServAcc(); })
	$('input[t=srv]').change(function () { calServAcc(); })
	$('input[pay]').keyup(function () { calPayAcc(); })
	$('input[pay]').change(function () { calPayAcc(); })
}
function setDenVisChange() {
	$('[denOpr]').dblclick(function () {
		a = $(this).attr('a');
		v = $(this).attr('v');
		if (a == '1') {
			opr = $(this).attr('denOpr');
			n = $(this).attr('n');
			loadWindow('#m_info2', 1, k_visit_info_edit, 600, 600);
			$.post(f_path + "X/gnr_acc_visit_den_opr.php", { opr: opr, n: n, v: v }, function (data) {
				d = GAD(data);
				$('#m_info2').html(d);
				setupForm('acc_form_den_fix', 'm_info2');
				fixForm();
				fixPage();
			})
		}
	})
}
function setDenVisChangeSave(o, v) {
	if (o == 1) {
		showAcc(v, 4);
	} else {
		loader_msg(0, k_error_data, 0);
	}
}
function setDateChange() {
	$('[v_id]').dblclick(function () {
		v_id = $(this).attr('v_id');
		t = $(this).attr('t');
		loadWindow('#m_info2', 1, k_paym_date_edit, 600, 600);
		$.post(f_path + "X/gnr_acc_visit_date_edit.php", { id: v_id, t: t }, function (data) {
			d = GAD(data);
			$('#m_info2').html(d);
			setupForm('acc_form_date', 'm_info2');
			fixForm();
			fixPage();
		})
	});
	$('[dv_id]').dblclick(function () {
		dv_id = $(this).attr('dv_id');
		t = $(this).attr('t');
		loadWindow('#m_info2', 1, k_doc_edit, 600, 600);
		$.post(f_path + "X/gnr_acc_visit_doc_edit.php", { id: dv_id, t: t }, function (data) {
			d = GAD(data);
			$('#m_info2').html(d);
			setupForm('acc_form_doc', 'm_info2');
			fixForm();
			fixPage();
		})
	});
}
function calServAcc() {
	all_s = 0
	$('tr[set]').each(function (index, element) {
		no = $(this).attr('no');
		p1 = parseInt($('input[name=ser_' + no + '_hp').val());
		p2 = parseInt($('input[name=ser_' + no + '_dp').val());
		pp = p1 + p2;
		$('#t_' + no).html(pp);
		all_s += pp;
	});
	$('#ser_tot').html(all_s);
}
function calPayAcc() {
	all_p = 0
	$('input[pay]').each(function (index, element) {
		pay_o = $(this).attr('pay');
		am = $(this).val();
		if (am == '') { am = 0; }
		if (pay_o == 1) { all_p += parseInt(am); } else { all_p -= parseInt(am); }
	});
	$('#pay_tot').html(all_p);
}
function chechAccCal() {
	if ($('#ser_tot').html() == $('#pay_tot').html()) { sub('acc_form'); } else { $('#ser_tot,#pay_tot').css('color', '#f00'); }
}
function insur_info(id) {
	loadWindow('#m_info', 1, k_insurance_details, 600, 600);
	$.post(f_path + "X/gnr_insur_info.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function delInsur(id) {
	open_alert(id, 'ins_6', k_wld_del_insure_rec, k_del_rec);
}
function delInsurDo(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_insur_review_del.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			win('close', '#m_info');
			loadFitterCostom('gnr_insur_review');
		}
		if (d == 0) { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
	})
}
function editInsur(id) {
	loadWindow('#m_info2', 1, k_insure_edit, 600, 600);
	$.post(f_path + "X/gnr_insur_review_edit.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info2').html(d);
		loadFormElements('#insur_edit');
		setupForm('insur_edit', 'm_info2');
		fixForm();
		fixPage();
	})
}
function patInfo(id, type = 1) {
	loadWindow('#m_info', 1, k_patient_info, 600, 200);
	$.post(f_path + "X/gnr_patient_info.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixPage();
	})
}
function editPatDoc(id) {
	co_loadForm(id, 3, "87zc6kbbs5||loc('_" + sezPage + '.' + visit_id + "')|");
}
function delVisAcc(id, type, opr) {
	if (opr == 0) {
		loadWindow('#m_info2', 1, k_dl_vis, 500, 200);
		$.post(f_path + "X/gnr_acc_visit_del.php", { id: id, type: type, opr: opr }, function (data) {
			d = GAD(data);
			$('#m_info2').html(d);
			fixPage();
		})
	}
	if (opr == 1) {
		loader_msg(1, k_loading);
		$.post(f_path + "X/gnr_acc_visit_del.php", { id: id, type: type, opr: opr }, function (data) {
			d = GAD(data);
			if (d == 1) {
				msg = k_done_successfully; mt = 1;
				win('close', '#m_info');
				win('close', '#m_info2');
				win('close', '#full_win1');
				if (type == 1) { loadFitterCostom('cln_acc_visit_review'); }
				if (type == 2) { loadFitterCostom('lab_acc_visit_review'); }
				if (type == 3) { loadFitterCostom('xry_acc_visit_review'); }
				if (type == 4) { loadFitterCostom('den_acc_visit_review'); }
				if (type == 5) { loadFitterCostom('bty_acc_visit_review'); }
				if (type == 6) { loadFitterCostom('bty_lsr_acc_visit_review'); }
				if (type == 7) { loadFitterCostom('osc_acc_visit_review'); }
			}
			if (d == 0) { msg = k_error_data; mt = 0; }
			loader_msg(0, msg, mt);
		})
	}
}
function docPerf(id) {
	loadWindow('#m_info', 1, k_doc_perform, 900, 400);
	$.post(f_path + "X/gnr_doc_perf.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#doc_perf');
		setupForm('doc_perf', 'm_info');
		setMintBlc();
		setdayTypeDocProf();
		fixForm();
		fixPage();
	})
}
function setdayTypeDocProf() {
	$('.radioBlc[par=dayType] .radioBlc_each').click(function () {
		v = $(this).attr('ri_val');
		vewiwDP(v);
	})
}
function vewiwDP(v) {
	$('tr[v]').hide();
	$('tr[v' + v + ']').show();
}

var actchdId = 0;
var actchdType = 0;
function changDoc(id, t) {
	actchdId = id; actchdType = t;
	loadWindow('#m_info2', 1, k_chng_dr, 600, 400);
	$.post(f_path + "X/gnr_change_doc.php", { id: id, t: t }, function (data) {
		d = GAD(data);
		$('#m_info2').html(d);
		fixForm();
		fixPage();
	})
}
function changDoc_do() {
	nDoc = $('#chDoc').val();
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_change_doc.php", { id: actchdId, t: actchdType, doc: nDoc }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully;
			mt = 1;
			win('close', '#m_info2');
			viSts(actchdType, actchdId);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function serServList() {
	str = $('#servSelSrch').val();
	//str=str.toLowerCase();		
	//strSel='[icpc_no]';
	if (str == '') {
		$('tr[serName][no]').show();
	} else {
		$('tr[serName][no]').each(function (index, element) {
			s_id = $(this).attr('no');
			txt = $(this).attr('serName').toLowerCase();
			ch = $('[name=ser_' + s_id).length
			n = txt.search(str);
			if (n != (-1) || ch == 1) { $(this).show(100); } else { $(this).hide(100); }
		})
	}
}
function showRole() {
	loadWindow('#m_info', 1, k_role_info, www, hhh);
	$.post(f_path + "X/gnr_roles.php", {}, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function serSelPat(p_id) {
	ser_reset(1);
	$('#fil_p1').val(p_id);
	loadFitterCostom('gnr_invoice');
}
function print_inv(id, t) {
	printInvoice(t, id); ser_reset(1); loadFitterCostom('gnr_invoice');
}
/************************/
var actOffer = 0;
var actOfferMood = 0;
var actOffPrco = 0;
function saveOffSet() {
	err = 0;
	$('input[name^=p]').each(function () {
		$(this).css('border-color', '');
		v = parseInt($(this).val());
		if (v == 0 || v > 100) { err = 1; $(this).css('border-color', '#f00'); }
	})
	if ($('input[name=cob]').length == 1) {
		cob = parseInt($('input[name=cob]').val());
		if (cob != '') {
			cob_s = parseInt($('input[name=cob_s]').val());
			cob_e = parseInt($('input[name=cob_e]').val());
			if (cob_s != '' || cob_e != '') {
				if (cob != cob_e - cob_s + 1) { err = 1; }
			}
		}
	}
	if (err == 0) {
		sub('offerSet');
	} else { nav(3, k_error_data); }
}
function editOffer(id, type) {
	co_loadForm(id, 3, "v1n0krhfvd||loadModule('v1n0krhfvd')|type:" + type + ":h");
}
function setOffer(id) {
	loadWindow('#m_info', 1, k_offer_set, 500, 400);
	$.post(f_path + "X/gnr_offers_set.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#offerSet');
		setupForm('offerSet', 'm_info');
		fixForm();
		fixPage();
	})
}
function offerItemes(id) {
	actOffer = id;
	loadWindow('#m_info', 1, k_offer_srvcs, www, hhh);
	$.post(f_path + "X/gnr_offers_srv_info.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
var actOfferSet = 0;
function addSrvToOffer(id = 0) {
	actOfferSet = id;
	loadWindow('#m_info2', 1, k_offer_set, 400, 600);
	$.post(f_path + "X/gnr_offers_srv_add.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info2').html(d);
		setupForm('offer6', 'm_info2');
		setOPSet();
		fixForm();
		fixPage();
	})
}

function offerSelSrv(type) {
	if (type == 6) {
		if ($('#srvFullPrice').length) {
			n = parseInt($('[srvno]').val());
			if (n < 2) {
				nav(3, k_num_ser_less);
			} else {
				if ($('#unitPrice').length > 0) {
					nu = parseFloat($('#unitPrice').html());
					if (nu % 1 === 0) {
						sub('offer6');
					} else {
						nav(3, k_unit_must_be_num);
					}
				} else {
					sub('offer6');
				}
			}
		} else {
			nav(3, k_set_must_completed);
		}
	} else {
		offerPearc = parseInt($('#offerp').val());
		moo = $('#clnicType').val();
		subType = '';
		if ($('#offSubType').length > 0) {
			subType = $('#offSubType').val();
		}

		if (offerPearc > 0 && offerPearc <= 100 && moo != 0) {
			actOfferMood = moo;
			actOffPrc = offerPearc;
			win('close', '#m_info2');
			col = '';
			con = '';
			if (subType != '') {
				if (moo == 1 || moo == 3) { con = " clinic='" + subType + "' "; } else { con = " cat='" + subType + "' "; }
			}
			if (moo == 1) { col = '0jl3u0pf6'; }
			if (moo == 2) { col = 'eemz48ttj7'; }
			if (moo == 3) { col = 'fc22o62k3'; }
			if (moo == 4) { col = 'h11pr2lk3q'; }
			if (moo == 5 || moo == 6) { col = '7yjj6j9g8f'; }
			if (moo == 7) { col = '4py2bgnex4'; }
			co_selLongValFreeMulti(col, "offerSelSrvSave('[id]')|" + con + "|||", 0);
		} else {
			nav(3, k_percent_correct_depart_choose);
		}
	}

}
function selclicCat(t, mood, id = '') {
	if (mood == 0) {
		$('#subcT1').html('');
		$('#subcT2').html('');
		$('#subcT3').html('');
	} else {
		$('#subcT' + t).html(loader_win);
		if (t == 1) {
			$('#subcT2').html('');
			$('#subcT3').html('');
		}
		if (t == 2) {
			$('#subcT3').html('');
		}

		$.post(f_path + "X/gnr_offers_srv_sub.php", { offer: actOfferSet, id: id, mood: mood, t: t }, function (data) {
			d = GAD(data);
			$('#subcT' + t).html(d);
			if (t == 3) { setOPSet(); }
			fixForm();
			fixPage();
		})
	}
}
function setOPSet() {
	$('[srvPrice]').keyup(function () { calOffrPCal(); })
	$('[srvNo]').keyup(function () { calOffrPCal(); })
}
function calOffrPCal() {
	p = parseInt($('[srvPrice]').val());
	n = parseInt($('[srvNo]').val());
	$('#srvFullPrice').html(p * n);
	m = $('#srvFullPrice').attr('m');
	if (m == '2') {
		u = parseInt($('#srvFullPrice').attr('u'));
		$('#unitPrice').html(p / u);
	}
}
function offerSelSrvSave(srv) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_offers_srv_save.php", { id: actOffer, m: actOfferMood, p: actOffPrc, srv: srv }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1; offerItemes(actOffer);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}

function editOfferSrv(id, offer, mood, srv) {
	co_loadForm(id, 3, "fzc763yg5||offerItemes(" + actOffer + ")|mood:" + mood + ":hh,offers_id:" + offer + ":hh,service:" + srv + ":hh");
}
function delOffSrv(id) {
	open_alert(id, 'gnr_3', k_wld_del_srv, k_srv_del);
}
function delOffSrvDo(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_offers_srv_del.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1; offerItemes(actOffer);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function newPatOffer() {
	loadWindow('#m_info', 1, k_offers, www, hhh);
	$.post(f_path + "X/gnr_offers_rec.php", {}, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function viewOffer(id) {
	if (id == 0) {
		$('#offerView').html('');
	} else {
		$('#offerView').html(loader_win);
		$.post(f_path + "X/gnr_offers_rec_view.php", { id: id }, function (data) {
			d = GAD(data);
			$('#offerView').html(d);
			fixForm();
			fixPage();
		})
	}
}
function patOffer(id, name) {
	$('[patno]').attr('patno', id);
	$('[patno]').html(name);
}
function newOffer() {
	pat = $('[patno]').attr('patno');
	offer = $('#offer').val();
	if (pat != 0 && offer != 0) {
		saveOffer(pat, offer, 1);
	} else {
		nav(3, k_pat_offer_choose);
	}
}
var offerBayAction = 0;
function saveOffer(pat, offer, t) {
	offerBayAction = t;
	loadWindow('#m_info2', 1, k_confirm_pack_purchase, 600, 200);
	$.post(f_path + "X/gnr_offers_rec_save.php", { pat: pat, offer: offer }, function (data) {
		d = GAD(data);
		$('#m_info2').html(d);
		fixForm();
		fixPage();
	})
}

function saveOfferDo(pat, offer, payType = 1, bank = 0) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_offers_rec_save_do.php", { pat: pat, offer: offer, pt: payType, bank: bank }, function (data) {
		d = GAD(data);
		if (d) {
			msg = k_done_successfully; mt = 1;
			if (sezPage == 'RespNew') {
				win('close', '#m_info2');
				viewOffers(actPatOffer, d, 2);
			} else {
				if (offerBayAction == 1) {
					win('close', '#m_info');
					win('close', '#m_info2');
				}
				if (offerBayAction == 2) {
					win('close', '#m_info2');
					showOfferD(offer);
				}
			}
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function SETOfPrice() {
	$('[name=cof_kktiu9fa7n] , [name=cof_e8qbi85r43]').keyup(function () {
		type = $('[name=cof_zz00mk3xc]').val();
		p1 = parseInt($('[name=cof_kktiu9fa7n]').val());
		p2 = parseInt($('[name=cof_e8qbi85r43]').val());
		newPrice = 0;
		if (type == 2) { newPrice = p1 * p2; } else { newPrice = p1 + p2; }
		$('#ofitInput').val(newPrice);
		$('.ofitInput').html(newPrice);
	})
}
var offActMood = 0;
var offActPat = 0;
var offActVis = 0;
function patOfferWin(mood, vis, pat) {
	offActMood = mood;
	offActPat = pat;
	offActVis = vis;
	loadWindow('#m_info3', 1, k_pat_offers, www, hhh);
	$.post(f_path + "X/gnr_offers_rec_pat.php", { id: pat, vis: vis, mood: mood }, function (data) {
		d = GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
	})
}
function showOfferD(offer) {
	$('#offDet').html(loader_win);
	$.post(f_path + "X/gnr_offers_rec_pat.php", { id: offActPat, vis: offActVis, mood: offActMood, o: offer }, function (data) {
		d = GAD(data);
		$('#offDet').html(d);
		loadFormElements('#offSave');
		setupForm('offSave', 'm_info');
		fixForm();
		fixPage();
	})
}
function offTakeSrv(srv, vis, offer) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_offers_rec_take.php", { srv: srv, vis: vis }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			showOfferD(offer);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function saveOfferT2() {
	l = $('input[name="srv[]"]').length
	if (l == 0) {
		nav(3, k_onitm_sel);
	} else {
		sub('offSave');
	}
}
function linkPatOffer(pat, offer) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_offers_link_pat.php", { pat: pat, offer: offer }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			showOfferD(offer);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function cobonAddOut(o, offer) {
	if (o == 1) {
		showOfferD(offer);
	} else {
		oo = o.split('^');
		if (oo.length == 2) {
			if (oo[0] == 'x1') { loader_msg(0, ''); nav(3, k_no_coupon_with_num); }
			if (oo[0] == 'x2') { loader_msg(0, ''); nav(5, oo[1]); }
		}
	}
}
var oActMood = 0;
var oActVis = 0;
function cancelSrvOffer(id, mood, vis) {
	oActMood = mood;
	oActVis = vis;
	open_alert(id, 'offer_1', k_wld_cncl_srvc_offer, k_offer_set);
}
function cancelSrvOfferDo(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_offers_srv_cancel.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			if (sezPage == 'RespNew') {
				recNewVisSrvSta(actNewVis, actNewVisMood);
			} else {
				viSts(oActMood, oActVis);
			}
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
/********************/
function selPatient(cb) {
	loadWindow('#m_info5', 1, k_pat_choose, www, hhh);
	$.post(f_path + "X/gnr_patients_sel.php", { t: 1, cb: cb }, function (data) {
		d = GAD(data);
		$('#m_info5').html(d);
		sePatSel();
		fixForm();
		fixPage();
	})
}
function sePatSel() {
	$('input[ser_p]').keyup(function () {
		$('#PatList').html(loader_win);
		clearTimeout(visPa_ser);
		visPa_ser = setTimeout(function () { setPatDo(); }, 800);
	})
	setPatDo();
}
function setPatDo() {
	$('#PatList').html(loader_win);
	ser_par = '';
	$('input[ser_p]').each(function () {
		sp = $(this).attr('ser_p');
		s_val = $(this).val();
		if (ser_par != '') { ser_par += '|'; }
		ser_par += sp + ':' + s_val;
	})
	$.post(f_path + "X/gnr_patients_sel.php", { t: 2, pars: ser_par }, function (data) {
		d = GAD(data);
		$('#PatList').html(d);
		$('div[pNo]').each(function () {
			$(this).click(function () {
				id = $(this).attr('pNo');
				name = $(this).attr('pName');
				clickPat(id, name);
			})
		})
		fixForm();
		fixPage();
	})
}
function newPaSel(d) {
	co_loadForm(0, 3, "p7jvyhdf3|id,f_name,ft_name,l_name|clickPat([id],'[f_name] [ft_name] [l_name]');win('close','#m_info5');|");
}
function offerInfo(id) {
	loadWindow('#m_info', 1, k_offers_stats, www, hhh);
	$.post(f_path + "X/gnr_offer_info.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
/************************/
function viSts(t, id) {
	switch (t) {
		case 1: clnVisitStatus(id); break;
		case 2: labVisitStatus(id); break;
		case 3: xryVisitStatus(id); break;
		case 4: denVisitStatus(id); break;
		case 5: btyVisitStatus(id, t); break;
		case 6: btyVisitStatus(id, t); break;
		case 7: oscVisitStatus(id); break;
	}
}
/*****************************/
function loadPrvSwitch() {
	loadWindow('#m_info', 1, k_visits, 880, 0);
	$.post(f_path + "X/gnr_preview_visit_switch.php", { vis: visit_id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
var accpatDocS = '0';
var accpatS = '0';
function accStat(id, t = 1) {
	accpatS = id;
	loadWindow('#m_info3', 1, k_account_stats, www, hhh);
	$.post(f_path + "X/gnr_patient_acc.php", { id: id, doc: accpatDocS, t: t }, function (data) {
		d = GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
	})
}
function accChDoc(doc) {
	accpatDocS = doc;
	accStat(accpatS);
}
function mergePats() {
	ids = '';
	seln = $('[ch=on]').length;
	if (seln < 2) {
		nav(2, k_sel_two_pats_to_merge);
	} else {
		$('[ch=on]').each(function () {
			no = $(this).children('input').val();
			if (ids != '') { ids += ','; }
			ids += no;
		});
		mergeinfo(ids);
	}
}
function mergeinfo(ids) {
	loadWindow('#m_info', 1, k_pats_merge, www, hhh);
	$.post(f_path + "X/gnr_patient_merge_info.php", { ids: ids }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#mpats')
		fixForm();
		fixPage();
	})
}
var actMPats = 0
function mergeAlert(pats) {
	actMPats = pats;
	mPat = $('#mPat').val();
	if (mPat == 0) {
		nav(2, k_primary_pat_choose);
	} else {
		open_alert(mPat, 'gnr_4', k_merge_pats_with_pat + ' <ff>( ' + mPat + ' )</ff> <div class="f1 fs16 clr5">' + k_opr_cant_undo_note + '</div>', k_pats_merge);
	}
}
function mergeDo(pat) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_patient_merge_save.php", { id: pat, pats: actMPats }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			win('close', '#m_info');
			loadFitterCostom('gnr_patient_merge');
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
/**********************************/
var madType = 0; var actPresCat = 0; var mad_list_ser3 = 0; var ser_preTimer = ''; var ser_madTimer = ''; var pre_timer = 0;
var actPresTpe = 0;
var actSelPres = 0;
function prescrs(t, act_pre) {
	actPresTpe = t;
	loadWindow('#m_info', 1, k_prescriptions, www, hhh);
	$.post(f_path + "X/gnr_presc.php", { v_id: visit_id, p_id: patient_id, t, t, act_pre: act_pre }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		$('[add_pares]').click(function () { addPrescr(0, actPresTpe); })
		$('[pOprEdit]').click(function () { addPrescr(actSelPres, actPresTpe); })
		$('[pOprDel]').click(function () { delPrescr(actSelPres); })
		$('.allPrescs > div').click(function () { showPrescr($(this).attr('pre')); })
		if (act_pre != 0) {
			showPrescr(act_pre);
			loadWindow('#m_info', 0, k_prescriptions, www, hhh);
		}
		fixForm();
		fixPage();
	})
}

function showPrescr(id) {
	actSelPres = id;
	$('#preOpr').hide();
	$('#preDtl').html(loader_win);
	$.post(f_path + "X/gnr_presc_show.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 0) {
			win('close', '#m_info');
		} else {
			dd = d.split('^');
			if (dd[0] == 1) { $('#preOpr').show(300); }
			$('#preDtl').html(dd[1]);
			fixForm();
			fixPage();
		}
	})
}
function addPrescr(id, t) {
	actSelPres = id;
	loadWindow('#m_info2', 1, k_precpiction, www, hhh);
	$('#m_info2').dialog("option", "closeOnEscape", false);
	$.post(f_path + "X/gnr_presc_info.php", { v_id: visit_id, id: id, t: t }, function (data) {
		d = GAD(data);
		$('#m_info2').html(d);
		$('[prescList] div').click(function () { actPresCat = $(this).attr('cn'); listPrescr_items(); })
		$('#ser_prescr').keyup(function () { listPrescr_items(); })
		$('[preComp]').click(function () { prescrComp(); })
		listPrescr_items();
		fixForm();
		fixPage();
	})
}
var ptu = 0;
function prescrComp() {

	$('[preCompSec]').hide();
	txt = $('[preCompSec] span').html();
	$('[preCompEdit] textarea').val(txt);
	$('[preCompEdit]').show();
	//actSelPres
	//co_selLongValFree('nijer61yc2',"alert('[id]')||||",0);
	//co_selLongValFree('nijer61yc2',"prescrCompSave([id])|doc="+ptu+"||doc:"+ptu+":hh|",0);
}
function prescrCompSave() {
	loader_msg(1, k_loading);
	txt = $('[preCompEdit] textarea').val();
	$('[preCompEdit]').hide();
	$.post(f_path + "X/gnr_presc_comp_save.php", { id: actSelPres, comp: txt }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			//addPrescr(actSelPres,actPresTpe);
			txt = $('[preCompSec] span').html(txt);
			$('[preCompSec]').show();
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function delPrescr(id) { open_alert(id, 'gnr_5', k_wld_del_presc, k_persc_del) }
function delPrescrDo(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_presc_del.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			prescrs(actPresTpe, 0);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function listPrescr_items() {
	serTxt = $('#ser_prescr').val();
	$('#mdcList').html(loader_win);
	$.post(f_path + "X/gnr_presc_list.php", { ser: serTxt, cat: actPresCat, pre: actSelPres }, function (data) {
		d = GAD(data);
		dd = d.split('^');
		$('#mdc_tot').html(dd[0]);
		$('#mdcList').html(dd[1]);
		$('[mdcList] div').click(function () { addMdc($(this).attr('mn')); })
		fixPage();
	})
}
function addMdc(id) {
	$.post(f_path + "X/gnr_presc_mdc_add.php", { pre: actSelPres, mdc: id }, function (data) {
		d = GAD(data);
		dd = d.split('^');
		if (dd[0] == 1) {
			$('#mdcTot').html(dd[2]);
			$('#mdcTable > tbody').append(dd[1]);
			$('div[mn=' + id + ']').hide(300);
		}
		fixForm();
		fixPage();
	})
}
function endPres() {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_presc_end.php", { id: actSelPres }, function (data) {
		win('close', '#m_info2');
		prescrs(actPresTpe, actSelPres);
		loader_msg(0, '', 1);
	})
}
function endPresc(status) {
	if (status == 0) { actThisPresc(); }
	win('close', '#m_info2');
	prescrs(actPresTpe, actSelPres);
	$('#m_info2').dialog("option", "closeOnEscape", true);
}
function actThisPresc() {
	loader_msg(1, k_loading);
	trLrn = $('#mdcTable tr[mdc]').length;
	$.post(f_path + "X/gnr_presc_act.php", { id: actSelPres }, function (data) {
		d = GAD(data);
		if (d == 1) {
			if (trLrn == 0) { actSelPres = 0; }
			endPresc(1);
			msg = k_done_successfully; mt = 1;
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function delMdc(m_id) {
	$.post(f_path + "X/gnr_presc_mdc_del.php", { id: m_id }, function (data) {
		$('tr[mdc=' + m_id + ']').hide();
		d = GAD(data);
		if (d != 0) {
			$('div[mn=' + d + ']').show(300);
			$('tr[mdc=' + m_id + ']').remove();
		} else {
			$('trmmdc=' + m_id + ']').show();
		}
	})
}
function editMdc(m_id) {
	selected_madc = m_id;
	loadWindow('#m_info3', 1, k_dosage_selection, www, hhh);
	$.post(f_path + "X/gnr_presc_mdc_edit.php", { id: m_id }, function (data) {
		d = GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
	})
}

function loadPreTamp() {
	loadWindow('#m_info3', 1, k_use_prescription_form, 450, 0);
	$.post(f_path + "X/gnr_presc_temp_set.php", function (data) {
		d = GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
		tempButts();
	})
}
function tempButts() {
	$('.tamplist div').click(function () {
		t_id = $(this).attr('t_id');
		$.post(f_path + "X/gnr_presc_temp_apply.php", { id: actSelPres, temp: t_id }, function (data) {
			win('close', '#m_info3');
			loader_msg(0, k_done_successfully, 1);
			//showPrescr(actSelPres);
			addPrescr(actSelPres, actPresTpe);
		})
	})
}
function savePreTamp() {
	loadWindow('#m_info3', 1, k_save_the_prescription_form, 600, 0);
	$.post(f_path + "X/gnr_presc_temp.php", function (data) {
		d = GAD(data);
		$('#m_info3').html(d);
		fixPage();
		fixForm();
	})
}
function saveTamp() {
	t_name = $('#pre_tamp').val();
	if (t_name != '') {
		loader_msg(1, k_saving);
		$.post(f_path + "X/gnr_presc_temp_save.php", { id: actSelPres, tamp: t_name }, function (data) {
			win('close', '#m_info3');
			loader_msg(0, k_done_successfully, 1);
		})
	} else {
		$('#pre_tamp').css('border-color', clr5);
	}
}

function addMadic() {
	val = $('#ser_prescr').val();
	co_loadForm(0, 3, "38tgwuqvh|id,name|addPrescr_in([id],'[name]')|name:" + val);
}
function alertDefWay(id) { open_alert(id, 8, k_sav_def_med_du_yn, k_sav_d_htu) }
function saveDefWay(id) { save_way(2, id); }
function save_way(type, id) {
	dd = $('[aw1]').find('div[act]').attr('mw_id');
	nu = $('[aw2]').find('div[act]').attr('mw_id');
	du = $('[aw3]').find('div[act]').attr('mw_id');
	ds = $('[aw4]').find('div[act]').attr('mw_id');
	if (typeof dd === "undefined") { dd = 0; }
	if (typeof nu === "undefined") { nu = 0; }
	if (typeof du === "undefined") { du = 0; }
	if (typeof ds === "undefined") { ds = 0; }
	loader_msg(1, k_saving);
	$.post(f_path + "X/gnr_presc_mdc_set.php", { type: type, id: id, dd: dd, nu: nu, du: du, ds: ds }, function (data) {
		loader_msg(0, k_done_successfully, 1);
		if (type == 1) {
			win('close', '#m_info3');
			addPrescr(actSelPres, actPresTpe);
		}
	})
}
function addWay(n, id, type) {
	if (n == 1) { co_loadForm(0, 3, "f0p4ukhef3|type|editMdc(" + id + ")|type:" + type + ":h"); }
	if (n == 2) { co_loadForm(0, 3, "unrcedqkiw||editMdc(" + id + ")|"); }
	if (n == 3) { co_loadForm(0, 3, "dljevd1mta||editMdc(" + id + ")|"); }
	if (n == 4) { co_loadForm(0, 3, "opq6mby80||editMdc(" + id + ")|"); }
}
function printPrescr(t, id = 0) {
	if (id == 0) {
		id = actSelPres;
	}
	if (t == 1) {
		printWindow(1, id);
	} else {
		print5(1, id);
	}
}
function showOffer(id) {
	loadWindow('#m_info', 1, k_offer_info, 800, 0);
	$.post(f_path + "X/gnr_offers_sell_info.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixPage();
		fixForm();
	})
}
function delSellOffer(id) {
	open_alert(id, 'offer_2', k_wld_del_offer, k_offer_del);
}
function delSellOfferDo(id) {
	loader_msg(1, k_loading);
	win('close', '#m_info');
	$.post(f_path + "X/gnr_offers_sell_del.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			loadModule('kxejashhch');
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
var actPatAcc = 0;
function patNewPay(id) {
	actPatAcc = id;
	loadWindow('#m_info4', 1, k_new_paym, 600, 0);
	$.post(f_path + "X/gnr_patient_pay.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info4').html(d);
		loadFormElements('#patPaySave');
		setupForm('patPaySave', 'm_info4');
		fixPage();
		fixForm();
	})
}
function savePatPay() {
	pPayment = parseInt($('#ppay').val());
	if (pPayment > 0) {
		sub('patPaySave');
	} else {
		nav(3, k_err_ent_val)
	}
}
function printPayment(id) {
	printTicket(44, id);
}
var pd_pat = 0;
function patDocs(pat, opr) {
	if (pat == 0) {
		selPatient('patDocs([id],1)');
	} else {
		pd_pat = pat;
		var ser_data = {};
		if (opr == 1) {
			loadWindow('#full_win2', 1, k_pat_docs, 0, 0);
		} else {
			$('#pd_data').html(loader_win);
			$('[pdSer] select').each(function () {
				v = $(this).val();
				n = $(this).attr('name');
				if (v != '') { ser_data[n] = v; }
			});
			$('[pdSer] input').each(function () {
				v = $(this).val();
				n = $(this).attr('name');
				if (v != '') { ser_data[n] = v; }
			});
		}
		$.post(f_path + "X/gnr_patient_docs.php", { id: pat, opr: opr, ser: ser_data }, function (data) {
			d = GAD(data);
			if (opr == 1) {
				$('#full_win2').html(d);
				$('[addImage]').click(function () { addPatDoc(0, 1); });
				$('[addDoce]').click(function () { addPatDoc(0, 2); });
				patDocs(pat, 2);
				pd_srcSet();
				fxObjects($('.win_body'));
			} else {
				$('#pd_data').html(d);
			}
			fixForm();
			fixPage();
		})
	}
}

var pd_ser_timer = '';
function pd_srcSet() {
	$('[pdSer] select').change(function () { patDocs(pd_pat, 2); });
	$('[pdSer] input.Date').change(function () { patDocs(pd_pat, 2); });
	$('[pdSer] input').keyup(function () { pd_serTimer(); });
}
function pd_serTimer() {
	clearTimeout(pd_ser_timer);
	pd_ser_timer = setTimeout(function () { patDocs(pd_pat, 2); }, 800);
}
function addPatDoc(id, t) {
	loadWindow('#m_info4', 1, k_new_doc, 600, 0);
	$.post(f_path + "X/gnr_patient_docs_add.php", { pat: pd_pat, id: id, t: t }, function (data) {
		d = GAD(data);
		$('#m_info4').html(d);
		loadFormElements('#patDoc');
		setupForm('patDoc', 'm_info4');
		fixPage();
		fixForm();
	})
}
function delPatDoc(id) {
	open_alert(id, 'gnr_6', k_wld_del_file, k_file_del);
}
function delPatDocDo(id) {
	loader_msg(1, k_loading);
	win('close', '#m_info');
	$.post(f_path + "X/gnr_patient_docs_del.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			if (sezPage == 'Resp') {
				patDocs(pd_pat, 1);
			} else {
				patDocsN(pd_pat, 2);
			}

		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
var pt_visT = 1;
var pt_prtT = '11111';
function pat_hl_rec(opr, pat, patName = '') {
	if (opr == 1) {
		loadWindow('#full_win4', 1, patName, 0, 0);
	} else {
		$('#pr_data').html(loader_win);
		getPatsChPR(pat);
	}
	$.post(f_path + "X/gnr_patient_rec.php", { id: pat, opr: opr, ptvis: pt_visT, ptprt: pt_prtT }, function (data) {
		d = GAD(data);
		if (opr == 1) {
			$('#full_win4').html(d);
			$('#op1 div').click(function () {
				attr = $(this).attr('act');
				if (typeof attr !== typeof undefined && attr !== false) {
					pt_visT = 0;
				} else {
					pt_visT = $(this).attr('no');
				}
				getPatsChPR();
				setTimeout(function () { pat_hl_rec(2, pat); }, 200);
			})
			$('#op2 > div').click(function () {
				getPatsChPR();
				setTimeout(function () { pat_hl_rec(2, pat); }, 200);
			})
			pat_hl_rec(2, pat);
		} else {
			$('#pr_data').html(d);
		}
		fixForm();
		fixPage();
	})
}
function getPatsChPR() {
	pt_prtT = '';
	$('#op2 > div').each(function () {
		attr = $(this).attr('act');
		if (typeof attr !== typeof undefined && attr !== false) {
			pt_prtT += '1';
		} else {
			pt_prtT += '0';
		}
	})
	//pt_prtT='10000';//---------------------------------
}
function prlChartFL(pat, sItme) {
	loadWindow('#m_info4', 1, k_anlys_comp_history, www, hhh);
	$.post(f_path + "X/gnr_patient_rec_lab_item.php", { sItme: sItme, pat: pat }, function (data) {
		d = GAD(data);
		$('#m_info4').html(d);
		fixForm();
		fixPage();
	})
}
function prlChart(id) {
	loadWindowFull("X/gnr_patient_rec_lab_item", '#m_info4', k_anlys_comp_history, id, www);
}
function swLi(c) {
	bu = $('.pr_bHead div[no=' + c + ']');
	st = bu.attr('x');

	if (st == 1) {
		bu.attr('x', '2');
		$('.pr_bbody[bn=' + c + ']').slideDown(400);
		$('.MMBo[n=' + c + ']').hide();

	} else {
		bu.attr('x', '1');
		$('.pr_bbody[bn=' + c + ']').slideUp(400);
		$('.MMBo[n=' + c + ']').show();
	}
}
var prActVital = 0;
var prvData1 = new Array();
var prvData2 = new Array();
var prvDataCat = new Array();
function pat_hl_vital(opr, id) {
	if (opr == 1) {
		loadWindow('#m_info4', 1, k_vital_signs, www, hhh);
		prActVital = id;
	} else {
		$('#pr_vital').html(loader_win);
		//getPatsChPR(pat);		
	}
	$.post(f_path + "X/gnr_patient_rec_vital.php", { id: id, opr: opr, pat: prActVital }, function (data) {
		d = GAD(data);
		if (opr == 1) {
			$('#m_info4').html(d);
			$('#op3 div').click(function () {
				pt_visT = $(this).attr('no');
				setTimeout(function () { pat_hl_vital(2, pt_visT); }, 200);
			})
			pat_hl_vital(2, 0);
		} else {
			$('#pr_vital').html(d);
		}
		fixForm();
		fixPage();
	})
}
function growthIndic(id) {
	loadWindowFull('X/gnr_growth', '#full_win1', k_grow_indicators, id, www, hhh);
}
function addMedPatInf(id, sex, bd) {
	co_loadForm(0, 3, "g48spjd8jl|id|growthIndic(" + id + ")|patient:" + id + ":hh,birth_date:" + bd + ",sex:" + sex);
}
function editMedPatInf(id, rec_id) {
	co_loadForm(rec_id, 3, "g48spjd8jl|id|growthIndic(" + id + ")|patient:" + id + ":hh");
}
function addGI(pat, age) {
	co_loadForm(0, 3, "i8c4v5x05|id|growthIndic(" + pat + ")|patient:" + pat + ":hh,age:" + age);
}
function editGI(id, pat) {
	co_loadForm(id, 3, "i8c4v5x05|id|growthIndic(" + pat + ")|patient:" + pat + ":hh");
}
var GIActPat = 0;
function delGI(id, pat) {
	GIActPat = pat;
	open_alert(id, 'gnr_7', k_wld_del_indicator, k_indicator_del);
}
function delGIDo(id, pat) {
	loader_msg(1, k_loading);
	win('close', '#m_info');
	$.post(f_path + "X/gnr_growth_del.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			growthIndic(GIActPat);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function giChart(pat, type) {
	loadWindow('#m_info3', 1, k_grow_indicator_chart, www, hhh);
	$.post(f_path + "X/gnr_growth_chart.php", { type: type, pat: pat }, function (data) {
		d = GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
	})
}
function delVis(id, type) { actVisDelType = type; open_alert(id, 10, k_wnt_dl_vis, k_dl_vis); }
function delVisDo(id) {
	loader_msg(1, k_deleting);
	$.post(f_path + "X/gnr_visit_del.php", { id: id, t: actVisDelType }, function (data) {
		d = GAD(data);
		if (d == 1) { msg = k_done_successfully; mt = 1; win('close', '#m_info'); } else { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
		if (sezPage == 'exe') { exe_ref(1); }
		if (sezPage == 'Resp') { res_ref(1); }
		if (sezPage == 'chr') { chr_ref(1); }
		if (sezPage == 'RespNew') { recLiveRef(1); closeRecWin(); }
	})
}
function patPayDir() { selPatient('accStat([id])'); }
/***********Vacations***************/
var actVtype = 1;
function selVaca() {
	co_selLongValFree('lnvj8elum4', "addVaca(0,[id])||||", 0);
}
function addVaca(id, emp) {
	loadWindow('#m_info', 1, k_vacations, 600, 300);
	$.post(f_path + "X/gnr_vaca.php", { id: id, emp: emp }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		loadFormElements('#vaca');
		setupForm('vaca', '');
		vacaSet();
		fixForm();
		fixPage();
	})
}
function vacaSet() {
	$('#vType').change(function () {
		vt = $(this).val();
		changVacaType(vt);
	})
	$('#s_date').change(function () {
		$('#e_date').val($(this).val());
	})
}
function changVacaType(vt) {
	$('tr[vt]').hide();
	$('tr[vt' + vt + ']').show();
	actVtype = vt;
}
function saveVac() {
	err = 0;
	if (actVtype == 1) {
		vac_s_date = Date.parse($('#s_date').val());
		vac_e_date = Date.parse($('#e_date').val());
		if (vac_e_date < vac_s_date) {
			err = 1;
			errMsg = k_end_date_less_than_start;
		}
	}
	if (actVtype == 2) {
		vac_s_time = $('#s_time').val();
		vac_e_time = $('#e_time').val();
		if (vac_s_time == '' || vac_e_time == '') {
			err = 1;
			errMsg = k_must_fill_time;
		} else {
			vts = timeToIntger(vac_s_time);
			vte = timeToIntger(vac_e_time);
			if (vte < vts) {
				err = 1;
				errMsg = k_end_time_less_than_start;
			} else {
				if ((vte - 900) < vts) {
					err = 1;
					errMsg = k_start_end_diff_hour;
				}
			}
		}
	}
	if (err == 1) {
		nav(4, errMsg);
	} else {
		sub('vaca');
	}
}

function cbVaca(opr, v) {
	if (opr == 2) {
		win('close', '#m_info');
		loadModule('fph3840jvz');
	}
	if (opr == 1) {
		open_alert(0, 'gnr_8', k_appoint_coflict_with_vac + '<br> ' + k_nums + ' <ff>( ' + v + ' )</ff><br>' + k_continueq + '</ff>', k_alert);
	}
}
function vacaSub(id) {
	$('#opr').val('2');
	sub('vaca');
}
function conflctDates() { loadWindowFull('X/gnr_vaca_conflct', '#m_info3', k_conflict_appoints, 0, www); }
function wr_send() {
	$('#w_rep_data').html(loader_win);
	data = get_form_vals('#wr_input');
	$.post(f_path + "X/gnr_waiting_report.php", data, function (data) {
		d = GAD(data);
		$('#w_rep_data').html(d);
		fixForm();
		fixPage();
	})
}
function su_send() {
	$('#su_rep_data').html(loader_win);
	data = get_form_vals('#su_input');
	$.post(f_path + "X/gnr_usage_report.php", data, function (data) {
		d = GAD(data);
		$('#su_rep_data').html(d);
		fixForm();
		fixPage();
	})
}
function loadHVid(v) {
	if (v) {
		vid = '<video width="100%" height="100%" controls autoplay><source src="../videos/' + v + '" type="video/mp4" id="vSrc">Your browser does not support HTML5 video.</video>';
		$('#vidC').html(vid);
	}
}
function chr_ref(l, id = 0) {
	if (l == 1) { $('#chReq').html(loader_win); }
	$.post(f_path + "X/gnr_charity_live.php", {}, function (data) {
		d = GAD(data);
		$('#chReq').html(d)
		if (id != 0) { chr_det(id); }
		fixPage();
		fixForm();
	})
}

var actChRec = 0;
function chr_det(id) {
	actChRec = id;
	$('#chDet').html(loader_win);
	$.post(f_path + "X/gnr_charity_info.php", { id: id }, function (data) {
		d = GAD(data);
		$('#chDet').html(d);
		loadFormElements('#ch_form');
		setupForm('ch_form');
		setDisopr();
		fixForm();
		fixPage();
	})
}
function setDisopr(r = 50) {
	$('input[dis]').keyup(function () { DisChange(); });
	$('input[dis]').change(function () { DisChange(); });
	$('.disTable td').click(function () {
		no = $(this).attr('no');
		$('[disInp]').val('');
		calDisPer(no, 0, r);
	})
	$('[disInp]').focus(function () { $(this).val(''); })
	$('[disInp]').keyup(function () {
		di = $(this).val();
		if (di) {
			no = parseInt(di);
			if (no > 100) { no = 100; }
			calDisPer(no, 1, r);
		}
	})
}
function DisChange() {
	tots = 0;
	diss = 0;
	$('input[dis]').each(function (index, element) {
		no = $(this).attr('no');
		v = parseInt($(this).val());
		p = parseInt($(this).attr('price'));
		if (v > p) { v = p; $(this).val(p); }
		tot = p - v;
		$('td[tot=' + no + ']').html(tot);
		tots += tot;
		diss += v;
	});
	$('#dis_total').html(diss);
	$('#net_total').html(tots);
}
function calDisPer(no, inp = 0, disRo = 50) {
	//var disRo=1;	
	$('.disTable td').removeAttr('act');
	if (inp == 0) {
		$('.disTable td[no=' + no + ']').attr('act', '');
	}
	$('input[dis]').each(function (index, element) {
		v = parseInt($(this).val());
		p = parseInt($(this).attr('price'));
		new_v = p / 100 * parseInt(no);
		$(this).val(new_v - (new_v % disRo));
	});
	DisChange()
}
function showChar(id) {
	$('#charInfo').html(loader_win);
	$.post(f_path + "X/gnr_charity_det.php", { id: id }, function (data) {
		d = GAD(data);
		$('#charInfo').html(d);
		fixForm();
		fixPage();
	})
}
/*****************************************/
var act_ch_Ctype = 0;
var act_ch_Ptype = 0;

function chgPayType(p_type, id, type) {
	act_ch_Ctype = type;
	act_ch_Ptype = p_type;
	if (p_type == 1) { msg1 = k_create_exe_request; msg2 = k_req_exmp; }
	if (p_type == 2) { msg1 = k_wnt_act_chr; msg2 = k_chr_rq; }
	if (p_type == 3) { msg1 = k_create_ins_request; msg2 = k_ins_request; }
	open_alert(id, 'gnr_pay', msg1, msg2);
}
function chgPayT(p_type, id, type) {
	act_ch_Ctype = type;
	act_ch_Ptype = p_type;
	if (p_type == 1) { msg1 = k_create_exe_request; }
	if (p_type == 2) { msg1 = k_wnt_act_chr;; }
	if (p_type == 3) { msg1 = k_create_ins_request; }

	$('[payT]').hide(500);
	$('#payMsg').html(msg1);
	$('#payMsgAl').show(500);

}
function changeVisType(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_payment_type_change.php", { id: id, type: act_ch_Ptype, cType: act_ch_Ctype }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1; win('close', '#m_info');
		} else if (d == 2) {
			printReceipt(id, act_ch_Ctype);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
		if (sezPage == 'Patients-Balance') { loadFitterCostom('gnr_patient_bal'); }
		if (sezPage == 'Resp') { res_ref(1); }
		if (sezPage == 'RespNew') { recLiveRef(1); closeRecWin(); }
	})
}
function payTypeReqCancle(t, id) {
	act_ch_Ptype = t;
	open_alert(id, 'gnr_2', k_wld_cancel_req, k_cnl_rq);
}
function payTypeReqCancleDo(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_payment_type_del.php", { id: id, type: act_ch_Ptype }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully;
			mt = 1;
			if (act_ch_Ptype == 2) {
				chr_ref(1);
				$('#chDet').html('');
			}
			if (act_ch_Ptype == 1) {
				exe_ref(1);
				$('#exDet').html('');
			}
		} else {
			msg = k_error_data;
			mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
/****************Rec***********************/
var busyRec = 0;
var resActTab = 1;
var recRefP = '';
var ana_basy = 0;
/**/
var actRecOpr = 1;
var actClanType = '0';
var actNVClinic = '0';
var actNVPat = '0';
var actNVDoc = '0';
var actNReqOrd = '0';
var patEvent = 0;
var actNewVis = 0;
var actNewVisMood = 0;
var actDocPay = 0;
var recOprTitleArr = ['', k_new_visit, k_new_appoi];
var actConfDtsMood = 0;
var actPHISel = 0;
var activeCat = 0;
function recSet(l) {
	recLiveRef(1);
	$('.recTabs [v]').click(function () { resActTab = 1; closeRecWin(); infoBarChange(resActTab); recLiveRef(1); })
	$('.recTabs [d]').click(function () { resActTab = 2; closeRecWin(); infoBarChange(resActTab); recLiveRef(1); })
	$('.addRecOpr [v]').click(function () { actRecOpr = 1; recNewVisit(); })
	$('.addRecOpr [d]').click(function () { actRecOpr = 2; recNewVisit(); })
	$('[closeWin]').click(function () { closeRecWin(); })
	$('#m_info2').on('click', '[visList]', function () {
		v = $(this).attr('visList');
		m = $(this).attr('mood');
		pat_vis_his_in(v, m);
	})
	$('#m_info2').on('click', '[moodList]', function () {
		m = $(this).attr('mood');
		if (m == actPHISel) {
			actPHISel = 0;
		} else {
			actPHISel = m;
		}
		showHVists(actPHISel);
	})
	$('.recOprWin').on('keyup', '#dDsrc', function () { srcInDate(); })
	$('.recMaCont').on('click', '[blcNew]', function () {
		actRecOpr = 1;
		mood = $(this).attr('blcT');
		vis = $(this).attr('blcNew');
		recNewVisSrvSta(vis, mood);
	})
	$('.recMaCont').on('click', '[blcSta]', function () {
		actRecOpr = 1;
		mood = $(this).attr('blcT');
		vis = $(this).attr('blcSta');
		recNewVisSrvSta(vis, mood);
	})
	$('.recMaCont').on('click', '[blcPay]', function () {
		actRecOpr = 1;
		mood = $(this).attr('blcT');
		vis = $(this).attr('blcPay');
		showRecAlert(vis, mood);
	})
	$('.recMaCont,.rwBody').on('click', '[blcLOrd]', function () {
		actRecOpr = 1;
		req = $(this).attr('blcLOrd');
		pat = $(this).attr('pat');
		loadLabOrd(req, pat);
	})
	$('.recMaCont,.rwBody').on('click', '[blcXOrd]', function () {
		actRecOpr = 1;
		req = $(this).attr('blcXOrd');
		pat = $(this).attr('pat');
		cln = $(this).attr('cln');
		convertXryOrd(req, pat, cln);
	})
	$('.recMaCont').on('click', '[blcDate]', function () {
		actRecOpr = 1;
		id = $(this).attr('blcDate');
		s = $(this).attr('s');
		if (s == 0) { recNewDtsDoc(id); }
		if (s == 1) { recNewDtsPat(id); }
		if (s == 2) { dateInfoN(id); }
	})

	$('.recOprWin').on('click', '[srvDelIn]', function () {
		srv = $(this).attr('srvDelIn');
		mood = $(this).attr('mood');
		delServ(srv, mood);
	})
	$('.recOprWin').on('click', '.srvEmrg', function () {
		s = $(this).attr('s');
		if (s == '0') {
			$(this).attr('s', '1');
			$('#srvFast').val('1');
		} else {
			$(this).attr('s', '0');
			$('#srvFast').val('0');
		}
	})
	$('.recOprWin').on('keyup', '#srvSrch', function () {
		str = $(this).val();
		if (str == '') {
			$('tr[serName][no]').show();
		} else {
			$('tr[serName][no]').each(function (index, element) {
				s_id = $(this).attr('no');
				txt = $(this).attr('serName').toLowerCase();
				ch = $('[name=srv_' + s_id).length
				n = txt.search(str);
				if (n != (-1) || ch == 1) { $(this).show(100); } else { $(this).hide(100); }
			})
		}
	})
	$('[recPos]').click(function () { chngRecPos(); })
	$('.recMaCont').on('click', '[recPos]', function () { actRecOpr = 1; chngRecPos(); })
	$('.recOprWin').on('click', '[recPos]', function () { chngRecPos($(this).attr('recPos')); })
	$('.recOprWin').on('click', '[visPayBut]', function () {
		v = $(this).attr('vis');
		m = $(this).attr('mood');
		err = 0;
		if (m == 2 || m == 3) {
			reqdoc = $('[reqdoc]').attr('reqdoc')
			if (reqdoc == '0') { err = 1; }
		}
		if (err == 0) {
			closeRecWin();
			printReceipt(v, m);
		} else {
			nav(3, k_select_req_doc);
		}
	})
	$('.recOprWin').on('click', '[visPayFixBut]', function () {
		v = $(this).attr('vis');
		m = $(this).attr('mood');
		fixVisPay(v, m);
	})
	$('.recOprWin').on('click', '[viAlrtBut]', function () {
		v = $(this).attr('vis');
		m = $(this).attr('mood');
		a = $(this).attr('amount');
		showRecAlertDo(v, m, a);
	})
	$('.alertSec').on('click', '[recAlr][mood][s]', function () {
		recAlr = $(this).attr('recAlr');
		s = $(this).attr('s');
		c = $(this).attr('c');
		showRecAlert(recAlr, s, c);
	})
	$('.recOprWin').on('click', '[dts]', function () { dateInfoN($(this).attr('dts')); })
	$('.recMaCont').on('click', '[dts]', function () { dateInfoN($(this).attr('dts')); })
	$('.alertSec').on('click', '[dts]', function () { dateInfoN($(this).attr('dts')); })

	$('.recOprWin').on('click', '[payT]', function () {
		type = $(this).attr('payT');
		chgPayT(type, actNewVis, actNewVisMood);
	})
	$('.recOprWin').on('click', '[foNo]', function () {
		n = $(this).attr('foNo');
		cancelSrvOffer(n, actNewVisMood, actNewVis);
	})
	$('.recOprWin').on('click', '[ptBut1]', function () { changeVisType(actNewVis); })
	$('.recOprWin').on('click', '[ptBut2]', function () {
		$('[payT]').show(500);
		$('#payMsgAl').hide(500);
	})

	//$('.recOprWin').on('click','.payBut',function(){printRecInvice(actNewVis,actNewVisMood);})
	$('.recOprWin').on('click', '[visDel]', function () { delVis(actNewVis, actNewVisMood); })
	$('.recOprWin').on('click', '[cancelDel]', function () {
		v = $(this).attr('cancelDel');
		m = $(this).attr('mood');
		cancelVisInfo(v, m);
	})
	$('.recOprWin').on('click', '[visPayCancle]', function () {
		v = $(this).attr('vis');
		m = $(this).attr('mood');
		v_back_do(v, m);
	})
	$('.recOprWin').on('click', '[visEdit]', function () { recNewVisSrv(actNewVis, actNewVisMood); })
	$('.recOprWin').on('click', '[labVisEdit]', function () { v = $(this).attr('labVisEdit'); reOpenLabVis(v); })
	$('.recOprWin').on('click', '[visEditDen]', function () { recNewVisDoc(actNewVis, actNewVisMood); })
	$('.recOprWin').on('click', '[visPrint]', function () {
		v = $(this).attr('visPrint');
		m = $(this).attr('mood');
		printTicket(m, v);
	})
	$('.recOprWin').on('click', '[visTik]', function () {
		v = $(this).attr('visTik');
		m = $(this).attr('mood');
		newRoels(v, m);
	})
	$('.recOprWin').on('click', '[visTik2]', function () {
		v = $(this).attr('visTik2');
		m = $(this).attr('mood');
		roelAct(v, m);
	})
	$('.recOprWin').on('click', '[skipDoc]', function () {
		actNVDoc = 0;
		recNewVisSrv(actNewVis, actNewVisMood);
	})

	$('.recOprWin').on('click', '[cubon]', function () { cubon_info(actNewVis, actNewVisMood); })
	$('[ticketIn]').keypress(function (event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == '13') { loadVisTicket(); }
	});
	$('.recOprWin').on('click', '[patVishis]', function () { pat_vis_his($(this).attr('patVishis')); })
	/********LAB**********/
	$('.recOprWin').on('click', '[cat_num]', function () {
		cat_id = $(this).attr('cat_num');
		activeCat = cat_id;
		if (cat_id == 0) {
			$('[cat_mdc][del=0]').show();
		} else {
			$('[cat_mdc]').hide();
			$('[cat_mdc=' + cat_id + '][del=0]').show();
		}
	})
	$('.recOprWin').on('click', '[mdc]', function () { if (actClanType == 2) { loadLabSrvs($(this)) }; })
	$('.recOprWin').on('click', '[delSelAna]', function () {
		aId = $(this).closest('[anaSel]').attr('anaSel');
		$(this).closest('[anaSel]').hide(400, function () {
			$(this).remove();
			$('[mdc=' + aId + ']').attr('del', '0');
			$('[mdc=' + aId + ']').slideDown(400);
			countSrvAmount();
		});
	})
	$('.recOprWin').on('keyup', '#srvLabSrch', function () { srvLabSrch(); })
	$('.recOprWin').on('click', '[saveLabSrv]', function () { saveLabSrvs(); })
	$('.recOprWin').on('click', '[labTpmLoad]', function () { load_ls_tempN(); })
	$('.recOprWin').on('click', '[labTpmSave]', function () { l_save_tempN(); })
	$('.recOprWin').on('click', '[lt_close]', function () {
		$('.winLabTmp').slideUp(200, function () { $('.winLabTmp').html(''); });
	})
	$('.recOprWin').on('click', '[lt_save]', function () { save_ltameN(); })
	$('.recOprWin').on('click', '[tmpId]', function () { if (actClanType == 2) { loadLabtempN($(this).attr('tmpId')); } })
	$('.recOprWin').on('click', '[reqDoc]', function () { showReqDocs(); })
	$('.recOprWin').on('click', '[editPat]', function () { editPatN($(this).attr('editPat')); })
	$('.recOprWin').on('click', '[visInfo]', function () { loadVisTicket($(this).attr('visInfo')); })
	$('.recOprWin').on('click', '[printLabSrv]', function () { printAnaOrder($(this).attr('printLabSrv')); })
	$('.recOprWin').on('click', '[printXrySrv]', function () { printXryOrder($(this).attr('printXrySrv')); })
	/****XRY*********/
	$('.recOprWin').on('click', '[tmpId]', function () { if (actClanType == 3) { loadXrytempN($(this).attr('tmpId')); } })
	$('.recOprWin').on('click', '[mdc]', function () { if (actClanType == 3) { loadXrySrvs($(this)) }; })
	$('.recOprWin').on('click', '[saveXrySrv]', function () { saveXrySrvs($(this).attr('saveXrySrv')); })
	/****BTY*********/
	$('.recOprWin').on('click', '[tmpId]', function () { if (actClanType == 5 || actClanType == 6) { loadXrytempN($(this).attr('tmpId')); } })
	$('.recOprWin').on('click', '[mdc]', function () { if (actClanType == 5 || actClanType == 6) { loadBtySrvs($(this)) }; })
	$('.recOprWin').on('click', '[saveBtySrv]', function () { saveBtySrvs($(this).attr('saveBtySrv')); })
	$('.recOprWin').on('keyup', 'input[multi]', function () { countSrvAmount(); })
	$('.recOprWin').on('click', 'input[multi]', function () { countSrvAmount(); })
	/****OSC********/
	$('.recOprWin').on('click', '[oscSrv]', function () {
		srv = $(this).attr('oscSrv');
		t = $(this).attr('t');
		fee = $('#fee').val();
		saveOscSrvs(srv, t, fee);
	})
	/****DEN********/
	$('.recOprWin').on('click', '[denAct]', function () {
		closeRecWin();
		printTicket2(4, actNewVis, $(this).attr('denAct'));
	})
	$('.recOprWin').on('click', '[patAcc]', function () { accStatN($(this).attr('patAcc')); })
	$('.recOprWin').on('click', '[stt]', function () { accStatN($(this).attr('stt')); })
	$('.recOprWin').on('click', '[teethTime]', function () {
		tTime = $(this).attr('teethTime');
		saveDenSrvs(tTime);
	})
	/****DTS********/
	$('.recOprWin').on('click', '[dtsDoNo]', function () { recNewDtsDocDats($(this).attr('dtsDoNo')); })
	$('.recOprWin').on('mouseover', '.dblc_2', function () {
		$(this).attr('title', k_not_enough_time);
	})
	$('.recOprWin').on('mouseover', '.dblc_1', function () {
		if ($(this).attr('t') != '1') {
			t = $(this).attr('title');
			$(this).attr('title', k_ava_time + '<br><ff14>' + t + '</ff14>');
			$(this).attr('t', '1');
		}
	})
	$('.recOprWin').on('mouseover', '[dateNo]', function () {
		if (!$(this).attr('t')) {
			tp = $(this).attr('tp');
			dId = $(this).attr('dateNo');
			$(this).attr('title', loader_win);
			loadDateInfo(dId, tp, $(this));
		}
	})
	$('.recOprWin').on('click', '[dateNo]', function () {
		dId = $(this).attr('dateNo');
		dateInfoN(dId);
	})
	$('.recOprWin').on('click', '.dblc_1', function () {
		str = $(this).attr('s')
		end = $(this).attr('e')
		recNewDtsDocDatsIN(str, end);
	})
	$('.recOprWin').on('click', '[dtspaybut]', function () { $('#n_d_d').submit(); })
	$('.recOprWin').on('click', '[dtsDel]', function () { dtsDel(actSelDate); })
	$('.recOprWin').on('click', '[dtsBack]', function () { recNewDtsDoc(actSelDate, actSelDoc); })
	$('.recOprWin').on('click', '[loadDaSc]', function () { recNewDtsDocDats(actSelDoc, actDtsDay); })
	$('.recOprWin').on('click', '[dtsBackSrv]', function () { recNewVisSrv(0, 0, actSelDate); })
	$('.recOprWin').on('click', '[dtsBackTime]', function () { recNewDtsDoc(actSelDate, $(this).attr('dtsBackTime')); })
	$('.recOprWin').on('click', '[dtsChange]', function () { dateAsReviewSave(actSelDate); })
	$('.recOprWin').on('click', '[dtsDone]', function () { dateEnd(actSelDate); })
	$('.recOprWin').on('click', '[dtsCancel]', function () { dtsCancelN(actSelDate); })
	$('.recOprWin').on('click', '[dtsCancelDo]', function () { sub('CanD'); })
	$('.recOprWin').on('click', '[dtsConf]', function () {
		m = $(this).attr('dtsConf');
		pt = $(this).attr('patT');
		if (pt == 1) {
			confirmDateN(actSelDate, m);
		} else {
			actPatMood = 1;
			actConfDtsMood = m;
			recNewDtsPat(actSelDate, 2);
		}
	})
	$('.recOprWin').on('click', '[dtsCfIn]', function () {
		m = $(this).attr('dtsCfIn');
		pt = $(this).attr('pt');
		dId = $(this).attr('dId');
		if (pt == 1) {
			confirmDateN(dId, m);
		} else {
			actPatMood = 1;
			actConfDtsMood = m;
			recNewDtsPat(dId, 2);
		}
	})
	$('.recOprWin').on('click', '.dblc_basy3', function () {
		m_date = $(this).attr('dNo');
		reserveDate(m_date);
	})
	$('.recOprWin').on('mouseover', '.dblc_basy4', function () {
		$(this).attr('title', k_not_enough_time);
	})
	$('.recOprWin').on('click', '[editDatPat]', function () {
		let pat = $(this).attr('editDatPat');
		editDatPatN(pat);
	})

	$('.recMaCont').on('click', '[dtsClinc]', function () {
		clId = $(this).attr('dtsClinc');
		viewClinsDates(clId);
	})
	$('.recOprWin').on('click', '.clnLis [c]', function () {
		clId = $(this).attr('c');
		viewClinsDatesIn(clId);
	})
	$('.recOprWin').on('keyup', '#dDsrc', function () {
		srcInDate();
	})
	$('.recOprWin').on('click', '[dtsPrint]', function () { closeRecWin(); printDate(actSelDate); })
	/****REC OPR********/
	$('.recOprs').on('click', '[t]', function () { recAction($(this).attr('t')); })
	$('.recOprWin').on('click', '.clnLis [cc]', function () {
		clId = $(this).attr('cc');
		recOpr_timeIn(clId);
	})
	$('.recOprWin').on('keyup', '#recOprsrc', function () { srcRecOpr(); })
	$('.recOprWin').on('click', '[pat]', function () {
		patId = $(this).attr('pat');
		patName = $(this).attr('pat_name');
		closeRecWin();
		patSelect(patId, patName);
	})
	$('.recOprWin').on('click', '[printPay]', function () {
		prPay = $(this).attr('printPay');
		printPayment(prPay);
	})
	$('.recOprWin').on('click', '[swViewPC]', function () { swViewPC(); })
	$('.recOprWin').on('change', '[patAccDoc]', function () { swViewPC($(this).val()); })
	$('.recOprWin').on('click', '[printPatAcc]', function () { printPatAcc(); })
	$('.recOprWin').on('click', '[printInvice]', function () { printInvice(); })
	$('.recOprWin').on('click', '[newPatPay]', function () { newPatPay(); })
	$('.recOprWin').on('click', '[savePatPay]', function () { savePatPayN(); })
	$('.recOprWin').on('click', '[backPatAcc]', function () { accStatN(actPatAcc, 1); })
	$('.recOprWin').on('click', '[charPayChang]', function () {
		charVis = $(this).attr('charPayChang');
		chgPayType(2, charVis, 4)
	})
	$('.recOprWin').on('click', '[offerPat]', function () { patUse(2); })
	$('.recOprWin').on('click', '[oId]', function () { viewOffersIn($(this).attr('oId'), 1); })
	$('.recOprWin').on('click', '[oId2]', function () { viewOffersIn($(this).attr('oId2'), 2); })
	$('.recOprWin').on('click', '[buyOffer]', function () { newOfferN(); })
	$('.recOprWin').on('click', '[printOffer]', function () { print4(3, $(this).attr('printOffer')); })
	$('.recOprWin').on('click', '[saveOfferPay]', function () { saveOfferDo(actPatOffer, actOfferSel); })
	$('.recOprWin').on('click', '[visPayCard]', function () {
		pt = $(this).attr('visPayCard');
		m = $(this).attr('mood');
		par = $(this).attr('par');
		a = 0;
		err = 0;
		msg = '';
		if (pt == 1) {
			if (m == 2 || m == 3) {
				reqdoc = $('[reqdoc]').attr('reqdoc')
				if (reqdoc == '0') { err = 1; }
			}
			if (err) { nav(3, k_select_req_doc); }
		}
		if (err == 0) {
			if (m == 4) { a = parseInt($('#den_pay').val()); }
			if (pt == 4) {
				a = parseInt($('#dPay').val());
				a_max = parseInt($('#dPay').attr('max'));
				if (a == 0) { msg = k_am_must_specified; }
				if (a > a_max) { msg = k_am_not_exceed_val; }
				if (msg) {
					err = 1;
					nav(3, msg);
					$('#dPay').css('border', '1px #f00 solid');
					$('#dPay').focus();
				}
				dd = $('[name=dd]').val();
				ds = $('[name=ds]').val();
				de = $('[name=de]').val();
				doc = $('[name=doc]').val();
				par = par + ',' + dd + ',' + ds + ',' + de + ',' + doc;
			}
			if (pt == 5) {
				savePatPayN(2);
			}
			if (pt == 6) { par = par + ',' + actOfferSel; }
			if (err == 0 && pt != 5) { cardPayment(pt, m, par, a); }
		}
	})

	$('.recOprWin').on('click', '[visPayMtn]', function () {
		pt = $(this).attr('visPayMtn');
		m = $(this).attr('mood');
		par = $(this).attr('par');
		pay = $(this).attr('pay');
		a = 0;
		err = 0;
		msg = '';
		if (pt == 1) {
			if (m == 2 || m == 3) {
				reqdoc = $('[reqdoc]').attr('reqdoc')
				if (reqdoc == '0') { err = 1; }
			}
			if (err) { nav(3, k_select_req_doc); }
		}
		if (err == 0) {
			mtnPayWin(par, m, pay);
		}
	})
	$('.recOprWin').on('click', '[ba]', function () { selBank($(this).attr('ba')); })
	$('.recOprWin').on('click', '[payDo]', function () { cardPayDo(); })
	$('.recOprWin').on('click', '[payPart]', function () { cardPayPart(); })
	$('.recOprWin').on('click', '[payback]', function () { cardPayBack($(this).attr('payback')); })
	$('.recOprWin').on('click', '[saveCPpay]', function () {
		max_pay = parseInt($('[cp_amount]').attr('cp_amount'));
		cur_pay = parseInt($('[cp_amount]').val());
		if (cur_pay > max_pay) {
			nav(3, k_am_entered_greater);
		} else if (cur_pay == 0) {
			nav(3, k_pay_must_specified);
		} else {
			sub('saveCP');
		}
	})
}
function infoBarChange(t) {
	if (t == 1) {
		$('[bi=2]').slideUp(500);
		$('[bi=1]').slideDown(500);
	} else {
		$('[bi=1]').slideUp(500);
		$('[bi=2]').slideDown(500);
	}
}
function recAction(t) {
	switch (t) {
		case 'acount': patUse(1); break;
		case 'docs': patUse(4); break;
		case 'offer': viewOffers(); break;
		case 'role': recOpr_time(2); break;
		case 'time': recOpr_time(1); break;
		case 'dates': viewClinsDates(); break;
		case 'visits': patUse(3); break;
		case 'lab': rec_requestList(1); break;
		case 'xry': rec_requestList(2); break;
	}
}
/*****Lab**********/
function srvLabSrch() {
	type = $('.ana_list_catN').attr('type');
	str = $('#srvLabSrch').val();
	if (labAnLang != '3') { str = str.toLowerCase(); }
	strSel = '';
	if (actAnaCat != 0) { strSel = '[cat_mdc=' + actAnaCat + ']'; }
	if (str == '') {
		$('[mdc][del=0]' + strSel).show();
	} else {
		$('[mdc][del=0]' + strSel).each(function (index, element) {
			s_id = $(this).attr('mdc');
			code = $(this).attr('code').toLowerCase();
			txt = $(this).attr('name')
			if (labAnLang != '3') { txt = txt.toLowerCase(); }
			n = txt.search(str);
			n2 = code.search(str);
			if (n != (-1) || n2 != (-1)) { $(this).show(); } else { $(this).hide(); }
		})
	}
	if (type == 5 && activeCat != 0) {
		$('[cat_mdc]').each(function (index, element) {
			if ($(this).attr('cat_mdc') != activeCat) {
				$(this).hide();
			}
		})
	}
}
function countSrvAmount() {
	pp = 0;
	cc = 0;
	$('[anaSel][pr]').each(function (index, element) {
		pr = parseInt($(this).attr('pr'));
		qu = parseInt($(this).find('[multi]').val());
		if (!qu) { qu = 1; }
		if (!pr) { pr = 0; }
		pp += pr * qu;
		cc++;
	});
	$('#countAna').html('( ' + cc + ' ) ');
	$('[rvtot]').html(pp);

}
function saveLabSrvs() {
	srvs = ''
	$('#anaSelected [anaSel]').each(function () {
		srv = $(this).attr('anaSel');
		fast = $(this).find('[name=f_' + srv + ']').val();
		if (fast == 'on') { fast = 1; } else { fast = 0; }
		srvs += srv + ':' + fast + ',';
	})
	if (srvs == '') {
		nav(3, k_ontst_sel)
	} else {
		srvs = srvs.slice(0, -1)
		$.post(f_path + "X/gnr_rec_addvis_srv_save.php", { vis: actNewVis, m: 2, c: 0, p: actNVPat, srvs: srvs, req: actNReqOrd }, function (data) {
			d = GAD(data);
			if (d) {
				recNewVisSrvSta(d, 2);
			}
		})
	}
}
function loadLabtempN(ids) {
	$('#anaSelected').html('<div>' + loader_win + '</div>');
	$('[mdc]').attr('del', '0');
	idsArr = ids.split(',');
	for (i = 0; i < idsArr.length; i++) {
		$('[mdc=' + idsArr[i] + ']').slideUp(400);
	}
	$.post(f_path + "X/lab_visit_add_srv.php", { pat: actNVPat, id: ids }, function (data) {
		d = GAD(data);
		$('#anaSelected').html(d);
		$('#srvLabSrch').val('');
		srvLabSrch();
		$('#srvLabSrch').focus();
		$('.winLabTmp').slideUp(200, function () { $('.winLabTmp').html(''); });
		ana_basy = 0;
		countSrvAmount();
		loadFormElements('#anaSelected');
		fixPage();
	})
}
function loadLabSrvs(sel) {
	if (ana_basy == 0) {
		ana_basy = 1;
		mdc = sel.attr('mdc');
		sel.attr('del', '1');
		butt_m = loader_win;
		$('#anaSelected').append('<div m="' + mdc + '">' + butt_m + '</div>');
		sel.slideUp(400, function () {
			$.post(f_path + "X/lab_visit_add_srv.php", { pat: actNVPat, id: mdc }, function (data) {
				d = GAD(data);
				$('[m=' + mdc + ']').remove();
				$('#anaSelected').append(d);
				$('#srvLabSrch').val('');
				//srvLabSrch();
				$('#srvLabSrch').focus();
				ana_basy = 0;
				loadFormElements('#anaSelected');
				countSrvAmount();
				fixPage();
			})
		});
	}
}
function showReqDocs() {
	co_selLongValFree('st4gcq4ail', "linkReqDocToVis(" + actNewVis + ",[id])||||", 0);
}
function linkReqDocToVis(vis, id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_link_reqdoc.php", { id: id, vis: actNewVis, m: actClanType }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully;
			mt = 1;
			recNewVisSrvSta(actNewVis, actClanType);
		} else {
			msg = k_error_data;
			mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function loadLabOrd(id, pat) {
	actNVPat = pat;
	actNReqOrd = id;
	actClanType = 2;
	actNewVis = 0;
	actNVClinic = '';
	actNVDoc = '';
	actNewVisMood = 2;
	recNewVisSrv(0, 2);
}
/****XRY**************/
function loadXrytempN(ids) {
	$('#anaSelected').html('<div>' + loader_win + '</div>');
	$('[mdc]').attr('del', '0');
	idsArr = ids.split(',');
	for (i = 0; i < idsArr.length; i++) {
		$('[mdc=' + idsArr[i] + ']').slideUp(400);
	}
	$.post(f_path + "X/xry_visit_add_srv.php", { pat: actNVPat, id: ids, doc: actNVDoc }, function (data) {
		d = GAD(data);
		$('#anaSelected').html(d);
		$('#srvLabSrch').val('');
		srvLabSrch();
		$('#srvLabSrch').focus();
		$('.winLabTmp').slideUp(200, function () { $('.winLabTmp').html(''); });
		ana_basy = 0;
		countSrvAmount();
		loadFormElements('#anaSelected');
		fixPage();
	})
}
function loadXrySrvs(sel) {
	if (ana_basy == 0) {
		ana_basy = 1;
		mdc = sel.attr('mdc');
		sel.attr('del', '1');
		butt_m = loader_win;
		$('#anaSelected').append('<div m="' + mdc + '">' + butt_m + '</div>');
		sel.slideUp(400, function () {
			$.post(f_path + "X/xry_visit_add_srv.php", { pat: actNVPat, id: mdc, doc: actNVDoc }, function (data) {
				d = GAD(data);
				$('[m=' + mdc + ']').remove();
				$('#anaSelected').append(d);
				$('#srvLabSrch').val('');
				srvLabSrch();
				$('#srvLabSrch').focus();
				ana_basy = 0;
				countSrvAmount();
				loadFormElements('#anaSelected');
				fixPage();
			})
		});
	}
}
function saveXrySrvs(t) {
	srvs = '';
	fast = $('.srvEmrg').attr('s');
	$('#anaSelected [anaSel]').each(function () {
		srv = $(this).attr('anaSel');
		srvs += srv + ',';
	})
	if (srvs == '') {
		nav(3, k_must_sel_srvc)
	} else {
		action = 'gnr_rec_addvis_srv_save';
		if (t == 2) { action = 'dts_rec_add_srv_save'; }
		srvs = srvs.slice(0, -1)
		$.post(f_path + "X/" + action + ".php", { vis: actNewVis, m: 3, c: actNVClinic, p: actNVPat, srvs: srvs, fast: fast, d: actNVDoc, req: actNReqOrd }, function (data) {
			d = GAD(data);
			if (d) {
				if (t == 2) {
					recNewDtsDoc(d);
				} else {
					recNewVisSrvSta(d, 3);
				}
			}
		})
	}
}
function convertXryOrd(id, pat, cln) {
	actNVPat = pat;
	actNReqOrd = id;
	actClanType = 3;
	actNewVis = 0;
	actNVClinic = cln;
	actNVDoc = '';
	recNewVisSrv();
}
/****BTY**************/
function loadBtytempN(ids) {
	$('#anaSelected').html('<div>' + loader_win + '</div>');
	$('[mdc]').attr('del', '0');
	idsArr = ids.split(',');
	for (i = 0; i < idsArr.length; i++) {
		$('[mdc=' + idsArr[i] + ']').slideUp(400);
	}
	$.post(f_path + "X/bty_visit_add_srv.php", { pat: actNVPat, id: ids, doc: actNVDoc, mood: actClanType }, function (data) {
		d = GAD(data);
		$('#anaSelected').html(d);
		$('#srvLabSrch').val('');
		srvLabSrch();
		$('#srvLabSrch').focus();
		$('.winLabTmp').slideUp(200, function () { $('.winLabTmp').html(''); });
		ana_basy = 0;
		countSrvAmount();
		loadFormElements('#anaSelected');
		fixForm();
		fixPage();
	})
}
function loadBtySrvs(sel) {
	if (ana_basy == 0) {
		ana_basy = 1;
		mdc = sel.attr('mdc');
		sel.attr('del', '1');
		butt_m = loader_win;
		$('#anaSelected').append('<div m="' + mdc + '">' + butt_m + '</div>');
		sel.slideUp(400, function () {
			$.post(f_path + "X/bty_visit_add_srv.php", { pat: actNVPat, id: mdc, doc: actNVDoc, mood: actClanType }, function (data) {
				d = GAD(data);
				$('[m=' + mdc + ']').remove();
				$('#anaSelected').append(d);
				$('#srvLabSrch').val('');
				srvLabSrch();
				$('#srvLabSrch').focus();
				ana_basy = 0;
				countSrvAmount();
				loadFormElements('#anaSelected');
				fixPage();
			})
		});
	}
}
function saveBtySrvs(t) {
	srvs = '';
	fast = $('.srvEmrg').attr('s');
	srvs = ''
	$('#anaSelected [anaSel]').each(function () {
		srv = $(this).attr('anaSel');
		mul = $(this).find('[name=m_' + srv + ']').val();
		if (!mul) { mul = 1; }
		srvs += srv + ':' + mul + ',';
	})
	if (srvs == '') {
		nav(3, k_must_sel_srvc);
	} else {
		action = 'gnr_rec_addvis_srv_save';
		if (t == 2) { action = 'dts_rec_add_srv_save'; }
		srvs = srvs.slice(0, -1)
		$.post(f_path + "X/" + action + ".php", { vis: actNewVis, m: actClanType, c: actNVClinic, p: actNVPat, srvs: srvs, fast: fast, d: actNVDoc }, function (data) {
			d = GAD(data);
			if (d) {
				if (t == 2) {
					recNewDtsDoc(d);
				} else {
					recNewVisSrvSta(d, actClanType);
				}
			}
		})
	}
}
/****OSC**************/
function saveOscSrvs(srv, t, fee) {
	srvs = '';
	actClanType = 7;
	fast = $('.srvEmrg').attr('s');
	action = 'gnr_rec_addvis_srv_save';
	if (t == 2) { action = 'dts_rec_add_srv_save'; }
	$.post(f_path + "X/" + action + ".php", { vis: actNewVis, m: actClanType, c: actNVClinic, p: actNVPat, srvs: srv, fast: fast, d: actNVDoc, fee: fee }, function (data) {
		d = GAD(data);
		if (d) {
			if (t == 2) {
				recNewDtsDoc(d);
			} else {
				recNewVisSrvSta(d, actClanType);
			}
		}
	})
}
/****DEN**************/
function saveDenVisit() {
	$.post(f_path + "X/gnr_rec_addvis_srv_save.php", { vis: actNewVis, m: actClanType, c: actNVClinic, p: actNVPat, srvs: '', d: actNVDoc }, function (data) {
		d = GAD(data);
		if (d) {
			recNewVisSrvSta(d, actClanType);
		}
	})
}
function saveDenSrvs(t) {
	actClanType = 4;
	$.post(f_path + "X/dts_rec_add_srv_save.php", { vis: actNewVis, m: actClanType, c: actNVClinic, p: actNVPat, teethTime: t, d: actNVDoc, dts: actSelDate }, function (data) {
		d = GAD(data);
		if (d) {
			recNewDtsDoc(d);
		}
	})
}
/******************************/
/***/
function closeRecWin() { $('.recOprWin').hide(); }
function showRecAlert(id, s, c = '') {
	//if(s!=0){
	openRecWin(k_execute_not, 1, 0, '#f0d19f');
	if (c) {
		loadVisTicket(c);
	} else {
		$.post(f_path + "X/gnr_rec_alerts.php", { id: id, s: s }, function (data) {
			d = GAD(data);
			$('.rwBody').html(d);
			fixObjects($('.rwBody'));
			fixForm();
			fixPage();
		})
	}
	//}
}
function showRecAlertDo(vis, mood, amount) {
	loader_msg(1, k_loading);
	doc = 0;
	if (mood == 4) {
		amount = $('#den_pay').val();
		doc = $('#docs').val();
	}
	$.post(f_path + "X/gnr_rec_alerts_do.php", { v: vis, m: mood, a: amount, doc: doc }, function (data) {
		d = GAD(data);
		if (d) {
			closeRecWin();
			msg = k_done_successfully; mt = 1;
			if (mood == 4) {
				accStatN(d);
			} else {
				printReceipt(vis, mood);
			}
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function editPatN(sec) {
	pat = actNVPat;
	if (sec == 'doc') { action = 'recNewVisDoc(' + actNewVis + ',' + actClanType + ')'; }
	if (sec == 'srv') { action = 'recNewVisSrv(' + actNewVis + ',' + actClanType + ')'; }
	if (sec == 'sta') { action = 'recNewVisSrvSta(' + actNewVis + ',' + actClanType + ')'; }
	if (sec == 'dts') { action = 'dateInfoN(' + actSelDate + ')'; }
	if (sec == 'ticket') {
		lnk = $('[editPat=ticket]').attr('lnk');
		pat = $('[editPat=ticket]').attr('pt');
		action = 'loadVisTicket("' + lnk + '")';
	}
	co_loadForm(pat, 3, 'p7jvyhdf3||' + action + '|');

}
function editDatPatN(pat) {
	action = 'dateInfoN(' + actSelDate + ')';
	co_loadForm(pat, 3, 'u18qfm9oyb||' + action + '|');
}
function recLiveRef(l) {
	thisTime = 4000;
	clearTimeout(recRefP);
	busyReq = chReqStatus();
	if (winIsOpen() == 0 && busyReq == 0) {
		if (l == 1) { $('.recMaTitle').html('<div class="lh40 uLine">' + loader_win + '</div>'); }
		if (l == 1) { $('.recMaCont').html(' '); }
		$.post(f_path + "X/gnr_rec_live.php", { t: resActTab }, function (data) {
			d = GAD(data);
			dd = d.split('^');
			if (dd.length == 6) {
				if (dd[0] == resActTab) {
					$('.recMaTitle').html(dd[1]);
					$('.recMaCont').html(dd[2]);
					$('.alertSec').html(dd[3]);
					$('[patsN]').html(dd[4])
					$('[boxInc]').html(dd[5]);
					fixObjects($('.alertSec'));
				}
			}
			fixPage();
			fixForm();
		})
	} else { thisTime = 800; }
	recRefP = setTimeout(function () { recLiveRef(0); }, thisTime);
}
function openRecWin(title = '', l = 1, full = 1, bgClr = '') {
	f = 'wp:0:1100-wp-0|hp:0';
	sw = $('.ticketIn').width();
	if (full != 1) { f = 'wp:' + sw + ':1100-wp-0|hp:0'; }

	$('.recOprWin').attr('fix', f);
	fixPage();
	$('.recOprWin').show();
	bgCC = '';
	if (bgClr) {
		if (bgClr == '1') {
			bgCC = '#bdd99b';
		} else if (bgClr == '2') {
			bgCC = '#f99daa';
		} else {
			bgCC = bgClr;
		}
	}
	$('.recOprWin [h]').css('background-color', bgCC);

	$('.rwTitle').html(title);

	if (l == 1) { $('.rwBody').html(loader_win); }
}
function recWinTitle(title = '') {
	$('.rwTitle').html(title);
}
function chngRecPos(p = 0) {
	if (p) {
		loader_msg(1, k_loading);
		locName = $('[recPos=' + p + ']').html();
		$('[locAct]').html(locName);
	} else {
		openRecWin(k_site_sel, 1, 0);
	}
	$.post(f_path + "X/gnr_rec_change_posation.php", { p: p }, function (data) {
		d = GAD(data);
		if (p) {
			loader_msg(0, '', 1);
			closeRecWin();
			recLiveRef(1);
		} else {
			$('.rwBody').html(d);
			fixObjects($('.rwBody'));
			fixForm();
			fixPage();
		}
	})
}
function recNewVisit() {
	actNewVis = 0;
	actNVPat = 0;
	actNReqOrd = 0;
	actNVDoc = 0;
	actSelDate = 0;
	openRecWin(recOprTitleArr[actRecOpr] + ' :  ' + k_tclinic, 1, 1, actRecOpr);
	$.post(f_path + "X/gnr_rec_addvis_clinic.php", { t: actRecOpr }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
		$('[srcClin]').focus();
		$('[srcClin]').keyup(function () { serClnIN(); });
		actClanType = '0';
		$('.recClcType > div').click(function () {
			actClanType = $(this).attr('t');
			serClnIN();
		})
		$('.cliBlc > div[c]').click(function () {
			actNVClinic = $(this).attr('c');
			actClanType = $(this).attr('tv');
			if (actRecOpr == 1) {
				recNewVisPat(actNVClinic);
			} else {
				recNewVisSrv(0, actClanType);
			}
		})
	})
}
function serClnIN() {
	str = $('[srcClin]').val();
	str = str.toLowerCase();
	$('[Ctxt]').each(function (index, element) {
		txt = $(this).attr('Ctxt').toLowerCase();
		ct = $(this).attr('t');
		n = txt.search(str);
		if (n != (-1) && (ct == actClanType || actClanType == '0')) { $(this).show(300); } else { $(this).hide(300); }
	})
}
function recNewVisPat(clc) {
	patEvent = 1;
	openRecWin(' ' + k_patient + ' : ' + k_new_visit, 1, 1, actRecOpr);
	$.post(f_path + "X/gnr_rec_addvis_pat.php", { t: actRecOpr, c: clc }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		setPatForm();
		veiwPatList(1, actAddDTSPar);
		fixPage();
		fixForm();
	})
}
function setPatForm(type = 1) {
	$('.visPatL [focus]').focus();
	$('input[ser_p]').keyup(function () {
		$('#visPatL').html(loader_win);
		clearTimeout(visPa_ser);
		visPa_ser = setTimeout(function () {
			if (type == 1) { veiwPatList(actPatMood, actAddDTSPar); }
			else if (type == 2) { patListView(); }
		}, 800);
	})
}
var actPatMood = 0;
var actAddDTSPar = '';
function veiwPatList(m = 0, addPar = '') {
	actAddDTSPar = addPar;
	if (m) { actPatMood = m; }
	if ((actClanType == 4 || actClanType == 7) && m != 3) { patEvent = 1; }
	$('[patList]').html(loader_win);
	ser_par = '';
	$('input[ser_p]').each(function () {
		sp = $(this).attr('ser_p');
		s_val = $(this).val();
		if (ser_par != '') { ser_par += '|'; }
		ser_par += sp + ':' + s_val;
	})

	$.post(f_path + "X/gnr_rec_pat_list.php", { pars: ser_par, c: actNVClinic, m: actPatMood, addPar: addPar }, function (data) {
		d = GAD(data);
		$('[patList]').html(d);
		$('[newpat]').click(function () {
			d = $(this).attr('newpat');
			if (patEvent == 1) { newVAction = 'recNewVisDoc();' }
			if (patEvent == 2) { newVAction = 'recNewVisSrv();' }
			if (patEvent == 3) { newVAction = 'addPatToDtsN(actSelDate,[id],actConfDtsMood);' }
			if (actPatMood == 1 || actPatMood == 3) {
				actRecOpr = 1;
				co_loadForm(0, 3, "p7jvyhdf3|id|actNVPat=[id];" + newVAction + "|" + d);
			} else {
				vals = '';
				co_loadForm(0, 3, "u18qfm9oyb|id|saveDaPaN(actSelDate,[id],2)|");
			}
		});
		$('.patLV > div[pat_n]').click(function () {
			pn = $(this).attr('pat_n');
			actNVPat = pn;
			if (actPatMood == 1) {
				if (patEvent == 1) { actNVPat = pn; recNewVisDoc(); }
				if (patEvent == 2) { actNVPat = pn; recNewVisSrv(); }
			} else {
				pt = $(this).attr('pt');
				saveDaPaN(actSelDate, pn, pt);
			}
		})
		fixForm();
		fixPage();
	})
}
function recNewVisDoc(vis = 0, mood = 0) {
	if (mood != 0) { actClanType = mood; }
	patEvent = 1;
	openRecWin(k_doctor + ' : ' + k_new_visit, 1, 1, actRecOpr);
	$.post(f_path + "X/gnr_rec_addvis_doc.php", { v: vis, m: actClanType, c: actNVClinic, p: actNVPat }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		setPatForm(1);
		$('.reDocList [done]').click(function () {
			actNVDoc = $(this).attr('doc');
			if (actClanType == 4) {
				saveDenVisit();
			} else {
				recNewVisSrv();
			}
		});
		$('[clinS]').click(function () {
			n = $(this).attr('n');
			dateSc(actNVClinic, n);
		});
		fixPage();
		fixForm();
	})
}
function recNewVisSrv(vis = 0, mood = 0, dts_id = 0) {
	if (mood != 0) { actClanType = mood; }
	openRecWin(recOprTitleArr[actRecOpr] + ' :  ' + k_services, 1, 1, actRecOpr);
	$.post(f_path + "X/gnr_rec_addvis_srv.php", { v: vis, m: actClanType, c: actNVClinic, p: actNVPat, d: actNVDoc, reqOrd: actNReqOrd, t: actRecOpr, dts: dts_id }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		loadFormElements('#srvsForm');
		setupForm('srvsForm', '');
		fixForm();
		fixPage();
		if (actClanType == 1 || actClanType == 7) {
			$('#srvSrch').focus();
			setPriceCal();
		} else {
			$('#srvLabSrch').focus();

		}
		$('[oNo]').click(function () {
			n = $(this).attr('oNo');
			addPatToOffer(n);
		})
		$('[saveSrv]').click(function () {
			sub('srvsForm');
		})
		loadFormElements('#anaSelected');
		countSrvAmount();
		if (mood != 2) {
			priceCal();
		}
	})
}
function recNewVisSrvSta(vis = 0, mood = 0) {
	if (vis == 0) { vis = actNewVis; }
	actNReqOrd = 0;
	actNewVis = vis;
	actNewVisMood = mood;
	actRecOpr = 1;
	if (mood) { actClanType = mood; }
	openRecWin(k_visit_status + ' : ' + k_new_visit, 1, 1, actRecOpr);
	$.post(f_path + "X/gnr_rec_addvis_srv_sta.php", { v: vis, m: mood }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixForm();
		fixPage();

	})
}
function setPriceCal() {
	$('input[multi]').keyup(function () { priceCal(); })
	$('input[multi]').click(function () { priceCal(); })
	$('div[par=ceckSrv]').click(function () { priceCal(); });
	priceCal();
}
function priceCal() {
	saveB = 0;
	total = 0;
	$('div[par=ceckSrv]').each(function (index, element) {
		ch = $(this).children('div').attr('ch');
		if (ch == 'on') {
			saveB = 1;
			price = parseInt($(this).closest('tr').attr('p'));
			multi = parseInt($(this).closest('tr').attr('m'));
			if (multi) {
				m = parseInt($(this).closest('tr').find('input[multi]').val());
				total += price * m;
			} else {
				total += price;
			}
		}
	});
	$('ff[rvTot]').html(total);
	if (saveB == 1) {
		$('[saveSrv]').show(200);
	} else {
		$('[saveSrv]').hide(200);
	}
}
function addPatToOffer(offer) {
	open_alert(offer, 'gnr_rec1', k_link_pat_entity + '<br>' + k_action_note, k_connect_pat_offer);
}
function addPatToOfferDo(offer) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_offers_link_pat.php", { pat: actNVPat, offer: offer }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			recNewVisSrv();
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function printRecInvice(id, mood) {
	if (mood == 2) {
		am = parseInt($('#l_pay').val());
		Max = parseInt($('#l_pay').attr('max'));
		if (am > Max) {
			nav(1, k_mnt_gr_val);
		} else {
			closeRecWin();
			printTicket2(mood, id, am);
		}
	} else {
		closeRecWin();
		printTicket(mood, id);
	}
}
function cubon_info(id, mood) {
	loadWindow('#m_info', 1, k_coupno_exchng, 500, 0);
	$.post(f_path + "X/gnr_rec_addvis_cubon.php", { vis: id, mood: mood }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		setupForm('cumboSave', 'm_info');
		loadFormElements('#cumboSave')
		fixPage();
	})
}
function saveCubon(o) {
	if (o == '1') {
		recNewVisSrvSta(actNewVis, actNewVisMood);
	} else {
		oo = o.split('^');
		if (oo.length == 2) {
			if (oo[0] == 'x1') { loader_msg(0, ''); nav(3, k_no_coupon_with_num); }
			if (oo[0] == 'x2') { loader_msg(0, ''); nav(5, oo[1]); }
		}
	}
}
var actVisReOpen = 0;
function reopenVis(id, type) {
	actVisReOpen = type;
	open_alert(id, 'gnr_rv', k_reopen_visit, k_reopen_visit);
}
function reopenVisDo(vis) {
	$.post(f_path + "X/gnr_visit_open.php", { vis: vis, t: actVisReOpen }, function (data) {
		if (actVisReOpen == 1) {
			loadFitterCostom('cln_acc_visit_review');
		}
		win('close', '#m_info4');
	})
}
function printReceipt(id, type) {
	if (type == 2) {
		if ($('[bankLabPay]').length) {
			am = $('[bankLabPay]').attr('bankLabPay');
			Max = am;
		} else {
			am = parseInt($('#l_pay').val());
			Max = parseInt($('#l_pay').attr('max'));
			x = parseInt($('#l_pay').attr('x'));
			if (x == 1) { am += '-x'; }
		}
		if (am > Max) {
			nav(1, k_mnt_gr_val);
		} else {
			win('close', '#m_info');
			printTicket2(type, id, am);
		}
	} else {
		win('close', '#m_info');
		printTicket(type, id);
	}
}
function loadVisTicket(str = '') {
	if (str == '') {
		s = $('[ticketIn]').val();
		$('.loaderT').show();
	} else {
		s = str
		openRecWin(k_card_info, 1, 0);
	}
	$.post(f_path + "X/gnr_rec_ticket.php", { str: s }, function (data) {
		d = GAD(data);
		dd = d.split('^');
		$('.loaderT').hide();
		if (dd[0] == '2') {
			dateInfoN(dd[1]);
			$('[ticketIn]').val('');
		} else if (dd[0] == '1') {
			nav(3, dd[1]);
			closeRecWin();
		} else {
			$('[ticketIn]').val('');
			if (str == '') {
				openRecWin(k_card_info, 1, 0);
			}
			$('.rwBody').html(dd[1]);
			fixObjects($('.rwBody'));
			fixForm();
			fixPage();
		}
	})
}
function newRoels(vis, t) {
	aact_roType = t;
	open_alert(vis, 11, k_crt_nw_rl, k_nw_rol);
}
function newRoels_do(id) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_new_role.php", { id: id, t: aact_roType }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			if (sezPage == 'RespNew') {
				loadVisTicket(aact_roType + '-' + id);
			} else {
				win('close', '#m_info');
			}
			printTicket(aact_roType, id);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
		if (sezPage != 'RespNew') {
			res_ref(1)
		}
	})
}
var moodPayAct = 0;
function changePay(vis, pay, type, mood) {
	moodPayAct = mood;
	if (type == 1) { q = k_wnt_cnl_srv; }
	if (type == 2) { q = k_pa_py_df + '  <ff>( ' + pay + ' )</ff> ?'; }
	if (type == 3) { q = k_df_pa_rt + '  <ff>( ' + pay + ' )</ff> ?'; }
	if (type == 4) { q = k_cn_srv_rnt + '  <ff>( ' + pay + ' )</ff> ?'; }
	open_alert(vis, 19, q, k_swt_srvs);
}
function changePayDo(id) {
	$.post(f_path + "X/gnr_visit_payment_fix.php", { vis: id, mood: moodPayAct }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1; win('close', '#m_info');
			printTicket(moodPayAct, id);
		} else { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
		res_ref(1)
	})
}
function fixVisPay(vis, mood) {
	a = 0;
	if (mood == 2) {
		a = parseInt($('#l_pay').val());
		x = $('#l_pay').attr('x');
		if (x == '1') { a = a * (-1); }
	}
	$.post(f_path + "X/gnr_visit_payment_fix.php", { vis: vis, mood: mood, a: a }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			closeRecWin();
			recLiveRef(1);
			loadVisTicket(mood + '-' + vis);
			printTicket(mood, vis);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function roelAct(vis, mood) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_role_active.php", { id: vis, t: mood }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			if (sezPage == 'RespNew') {
				loadVisTicket(mood + '-' + vis);
			} else {
				win('close', '#m_info');
			}
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
		if (sezPage != 'RespNew') { res_ref(1); }
	})
}
function cancelVis(id, t) {
	loadWindow('#m_info2', 1, k_services, 600, 0);
	$.post(f_path + "X/gnr_visit_new_del.php", { id: id, t: t }, function (data) {
		d = GAD(data);
		$('#m_info2').html(d);
		fixForm();
		fixPage();
	})
}
function v_back_do(id, t) {
	loader_msg(1, k_loading);
	$.post(f_path + "X/gnr_visit_new_del_do.php", { id: id, t: t }, function (data) {
		d = GAD(data);
		if (d == 1) {
			msg = k_done_successfully; mt = 1;
			if (sezPage == 'RespNew') {
				loadVisTicket(t + '-' + id);
			} else {
				win('close', '#m_info');
				win('close', '#m_info2');
			}
		} else { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
		if (sezPage != 'RespNew') { res_ref(1); }
	})
}
function cancelVisInfo(v, m) {
	openRecWin(k_cancel_visit, 1, 0, 1, 1, actRecOpr);
	$.post(f_path + "X/gnr_rec_ticket_cancel.php", { v: v, m: m }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
/***********recOpr*******************/
var actRecOpr = 0;
var patUseAct = 0;
var actPatAcc = 0;
var actTypeAcc = 0;
var actPatOffer = 0;
var actOfferSel = 0;
function recOpr_time(t) {
	actRecOpr = t;
	openRecWin(k_schdl_wrk, 0);
	$.post(f_path + "X/gnr_rec_opr_time.php", { t: t }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		recOpr_timeIn(0);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
function recOpr_timeIn(id) {
	$('[datCLis]').html(loader_win);
	if (actRecOpr == 1) { p = 'gnr_rec_opr_time_in'; } else { p = 'gnr_rec_opr_rols_in'; }
	$.post(f_path + "X/" + p + ".php", { id: id }, function (data) {
		$('#recOprsrc').val('');
		d = GAD(data);
		$('[datCLis]').html(d);
		$('#recOprsrc').focus();
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
function srcRecOpr() {
	str = $('#recOprsrc').val();
	if (str == '') {
		$('tr[oprTr]').show();
	} else {
		$('tr[oprTr]').each(function (index, element) {
			txt = $(this).attr('oprTr').toLowerCase();
			n = txt.search(str);
			if (n != (-1)) { $(this).show(100); } else { $(this).hide(100); }
		})
	}
}
function patUse(t) {
	patUseAct = t;
	switch (t) {
		case 1: title = k_account_stats; break;
		case 2: title = k_offers; break;
		case 3: title = k_patients_visits; break;
		case 4: title = k_pat_doc; break;
		case 5: title = k_tests_reqs; break;
		case 6: title = k_xray_orders; break;
	}
	openRecWin(k_sr_pa + '( ' + title + ' )', 1, 2);
	$.post(f_path + "X/gnr_rec_pat.php", { t: t }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		setPatForm(2);
		fixForm();
		fixPage();
	})
}
function patListView() {
	$('[patList]').html(loader_win);
	ser_par = '';
	$('input[ser_p]').each(function () {
		sp = $(this).attr('ser_p');
		s_val = $(this).val();
		if (ser_par != '') { ser_par += '|'; }
		ser_par += sp + ':' + s_val;
	})
	$.post(f_path + "X/gnr_rec_pat_in.php", { pars: ser_par }, function (data) {
		d = GAD(data);
		$('[patList]').html(d);
		fixForm();
		fixPage();
	})
}
function patSelect(id, name) {
	switch (patUseAct) {
		case 1: accStatN(id); break;
		case 2: viewOffers(id); break;
		case 3: pat_vis_his(id); break;
		case 4: patDocsN(id); break;
	}
}
function accStatN(id, t = 1, doc = '') {
	actPatAcc = id;
	actTypeAcc = t;
	openRecWin(k_account_stats, 1, 1);
	$.post(f_path + "X/gnr_rec_pat_acc.php", { id: id, t: t, doc: doc }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
function swViewPC(doc = '') {
	t = 1;
	if (actTypeAcc == 1 && doc == '') { t = 2; }
	accStatN(actPatAcc, t, doc);
}
function printPatAcc() { print4(4, actPatAcc); }
function printInvice() { printDenInv(actPatAcc); }
function newPatPay() {
	openRecWin(k_pay_on_account, 1, 2);
	$.post(f_path + "X/gnr_rec_pat_pay.php", { id: actPatAcc }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		//loadFormElements('#patPaySave');			
		//setupForm('patPaySave','');
		$('#payTypeSel').change(function () {
			v = $(this).val();
			if (v == 2) { $('#payCar5').hide(); } else { $('#payCar5').show(); }
		})
		fixForm();
		fixPage();

	})
}
function viewOffers(pat = '', offer = '', t = '') {
	actPatOffer = pat;
	openRecWin('العروض', 1, 1);
	$.post(f_path + "X/gnr_rec_offers.php", { id: pat }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		if (offer) { viewOffersIn(offer, t); }
		fixForm();
		fixPage();
	})
}
var actPatOfferType = 0;
function viewOffersIn(id, t) {
	pat = 0;
	pat = actPatOffer;
	actPatOfferType = t;
	actOfferSel = id;
	$('#offerView').html(loader_win);
	$.post(f_path + "X/gnr_rec_offers_in.php", { id: id, pat: pat, t: t }, function (data) {
		d = GAD(data);
		$('#offerView').html(d);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
/**********************************/
var actReqType = 0;
var req_ser_timer = '';
function rec_requestList(type) {
	actReqType = type;
	title = k_tests_reqs;
	if (type == 2) { title = k_xray_orders; }
	openRecWin(title, 1, 1);
	$.post(f_path + "X/gnr_rec_requests.php", { type: type }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		$('[reqFilter] input').keyup(function () { loadReqData_lis(); })
		$('[ser_p=all]').change(function () { loadReqData(); })
		loadReqData();
		fixForm();
		fixPage();
	})
}
function loadReqData_lis() {
	clearTimeout(req_ser_timer);
	req_ser_timer = setTimeout(function () { loadReqData(); }, 800);
}
function loadReqData() {
	$('#reqsListView').html(loader_win);
	ser_par = '';
	$('input[ser_p],select[ser_p]').each(function () {
		sp = $(this).attr('ser_p');
		s_val = $(this).val();
		if (ser_par != '') { ser_par += '|'; }
		ser_par += sp + ':' + s_val;
	})
	$.post(f_path + "X/gnr_rec_requests_in.php", { t: actReqType, pars: ser_par }, function (data) {
		d = GAD(data);
		$('#reqsListView').html(d);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}

function newOfferN() {
	offerBayAction = 1;
	$('#offerView').html(loader_win);
	$.post(f_path + "X/gnr_rec_offers_save.php", { pat: actPatOffer, offer: actOfferSel }, function (data) {
		d = GAD(data);
		$('#offerView').html(d);
		fixForm();
		fixPage();
	})
}
var cp_t = 0;//type
var cp_m = 0;//mood
var cp_p = 0;//parameters
var cp_b = 0;//bank
var cp_a = 0;//amount
var cp_c = 0;//custom Pay
function cardPayment(t, m = '', p = '', c = 0) {
	cp_t = t;
	if (m) { cp_m = m; }
	if (p) { cp_p = p; }
	cp_c = c;
	openRecWin(k_card_pay, 1, 2);
	$.post(f_path + "X/gnr_rec_card_pay.php", { t: t, mood: m, par: p, c: c }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
		setupForm('saveCP', '');
		fixForm();
		fixPage();
	})
}
function cardPayment_save(d) {
	if (cp_t == 6) {
		saveOfferDo(actPatOffer, actOfferSel, 2, d);
	} else {
		//loader_msg(1,k_loading);
		//$.post(f_path+"X/gnr_rec_card_pay_do.php",{id:cp_b,t:cp_t,mood:cp_m,par:cp_p,a:cp_a,c:cp_c},function(data){		*/
		dd = d.split('^');
		if (dd[0] == '1') {
			msg = k_done_successfully; mt = 1;
			closeRecWin();

			switch (cp_t) {
				case '1':
					//if(dd[1]!='0'){
					//  if(cp_a || cp_m==2){
					recNewVisSrvSta(cp_p, cp_m);
					//}else{
					//  printReceipt(cp_p,0);
					//}
					break;
				case '2':
					if (cp_m == 4) {
						accStatN(dd[1]);
					} else {
						showRecAlert(cp_p, cp_m);
					}
					break;
				case '3': loadVisTicket(cp_m + '-' + cp_p); break;
				case '4': payDateDataSave(); break;
				case 5: accStatN(actPatAcc); break;
				case '6': viewOffers(actPatOffer, actOfferSel, 2); break;
			}
			cp_a = 0;
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);

		//})
	}
}
function selBank(id, a = 0) {
	cp_b = id;
	$('#bankD').html(loader_win);
	$.post(f_path + "X/gnr_rec_card_pay_in.php", { id: id, t: cp_t, mood: cp_m, par: cp_p, a: a, c: cp_c }, function (data) {
		d = GAD(data);
		$('#bankD').html(d);
		$('[pds]').show(200);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
function cardPayDo() {
	if (cp_t == 6) {
		saveOfferDo(actPatOffer, actOfferSel, 2, cp_b);
	} else {
		loader_msg(1, k_loading);
		$.post(f_path + "X/gnr_rec_card_pay_do.php", { id: cp_b, t: cp_t, mood: cp_m, par: cp_p, a: cp_a, c: cp_c }, function (data) {
			d = GAD(data);
			if (d == 1) {
				msg = k_done_successfully; mt = 1;
				closeRecWin();
				switch (cp_t) {
					case '1':
						if (cp_a || cp_m == 2) {
							recNewVisSrvSta(cp_p, cp_m);
						} else {
							printReceipt(cp_p, cp_m);
						}
						break;
					case '2': showRecAlert(cp_p, cp_m); break;
					case '3': loadVisTicket(cp_m + '-' + cp_p); break;
					case '4': payDateDataSave(); break;
					case 5: accStatN(actPatAcc); break;
					case '6': viewOffers(actPatOffer, actOfferSel, 2); break;
				}
				cp_a = 0;
			} else {
				msg = k_error_data; mt = 0;
			}
			loader_msg(0, msg, mt);
		})
	}
}
function cardPayBack(t) {
	closeRecWin();
	switch (t) {
		case '1': recNewVisSrvSta(cp_p, cp_m); break;
		case '2': showRecAlert(cp_p, cp_m); break;
		case '3': loadVisTicket(cp_m + '-' + cp_p); break;
		case '4': recNewDtsDoc(cp_p); break;
		case 5: accStatN(actPatAcc); break;
		case '6': viewOffers(actPatOffer, actOfferSel, 1); break;
	}
	cp_a = 0;
	cp_p = 0;
	cp_m = 0;
}
function cardPayPart() {
	a = parseInt($('#prtPay').val());
	if (a) {
		cp_a = a;
		selBank(cp_b, cp_a);
		$('#prtPay').val('0');
	} else {
		nav(3, k_part_amount_specifed);
	}
}
function payDateDataSave() {
	loader_msg(1, k_loading);
	pars = cp_p.split(',');
	$.post(f_path + "X/dts_new_date_in_save.php", { id: pars[0], dd: pars[1], ds: pars[2], de: pars[3], doc: pars[4] }, function (data) {
		d = GAD(data);
		if (d) {
			msg = k_done_successfully; mt = 1;
			checkDateStatusN(d, pars[0], 0);
		} else { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
		if (sezPage != 'RespNew') { res_ref(1); }
	})
}
function savePatPayN(t = 1) {
	pPayment = parseInt($('#ppay').val());
	payTypeSel = $('#payTypeSel').val();
	payDoc = $('#payDoc').val();
	paySel = $('#ppay').val();
	if (pPayment > 0 && payDoc != 0) {
		if (t == 1) {
			$.post(f_path + "X/gnr_patient_pay_save.php", { id: actPatAcc, type: payTypeSel, pay: paySel, doc: payDoc }, function (data) {
				d = GAD(data);
				if (d) {
					msg = k_done_successfully; mt = 1;
					accStatN(actPatAcc);
				} else { msg = k_error_data; mt = 0; }
				loader_msg(0, msg, mt);
				if (sezPage != 'RespNew') { res_ref(1); }
			})
		} else {
			par = actPatAcc + ',' + payTypeSel + ',' + payDoc;
			cardPayment(5, 0, par, pPayment);
		}
	} else {
		nav(3, k_enter_req_data)
	}
}
function patDocsN(pat, opr = 1) {
	pd_pat = pat;
	var ser_data = {};
	if (opr == 1) {
		openRecWin(k_pat_docs, 1, 2);
	} else {
		$('#pd_data').html(loader_win);
		$('[pdSer] select').each(function () {
			v = $(this).val();
			n = $(this).attr('name');
			if (v != '') { ser_data[n] = v; }
		});
		$('[pdSer] input').each(function () {
			v = $(this).val();
			n = $(this).attr('name');
			if (v != '') { ser_data[n] = v; }
		});
	}
	$.post(f_path + "X/gnr_patient_docsN.php", { id: pat, opr: opr, ser: ser_data }, function (data) {
		d = GAD(data);
		if (opr == 1) {
			$('.rwBody').html(d);
			$('[addImage]').click(function () { addPatDoc(0, 1); });
			$('[addDoce]').click(function () { addPatDoc(0, 2); });
			patDocsN(pat, 2);
			pd_srcSetN();
		} else {
			dd = d.split('^');
			$('#docTotal').html(dd[0])
			$('#pd_data').html(dd[1]);
		}
		fixForm();
		fixPage();
	})
}
function pd_srcSetN() {
	$('[pdSer] select').change(function () { patDocsN(pd_pat, 2); });
	$('[pdSer] input.Date').change(function () { patDocsN(pd_pat, 2); });
	$('[pdSer] input').keyup(function () { pd_serTimerN(); });
}
function pd_serTimerN() {
	clearTimeout(pd_ser_timer);
	pd_ser_timer = setTimeout(function () { patDocsN(pd_pat, 2); }, 800);
}
/************************************/
var actRteVis = 0;
var actRteMood = 0;
function ratingSet() {
	$('#full_win1').on('click', '[eveList]', function () {
		v = $(this).attr('eveList');
		m = $(this).attr('mood');
		rateVisInfo(v, m);
	})
	$('body').on('click', '[saveRate]', function () { rateVisSave(); })

}
function rateVis(id, mood) {
	actRteVis = id;
	actRteMood = mood;
	loadWindow('#full_win1', 1, k_eva_visit, 0, 0);
	$.post(f_path + "X/gnr_rate.php", { id: id, mood: mood }, function (data) {
		d = GAD(data);
		$('#full_win1').html(d);
		//fixObjects($('.win_free'));
		rateVisInfo(id, mood);
		fxObjects($('.win_free'));
		fixForm();
		fixPage();
	})
}
function rateVisInfo(id, mood) {
	actRteVis = id;
	actRteMood = mood;
	reat = 0;
	rateVal = 0;
	$('#rateInfo').html(loader_win);
	$.post(f_path + "X/gnr_rate_info.php", { id: id, mood: mood }, function (data) {
		d = GAD(data);
		$('#rateInfo').html(d);
		fxObjects($('.win_free'));
		setStarsRate();
		$('[sendRev]').click(function () {
			if (reat == 0) {
				nav(3, k_enter_evaluation);
			} else {
				txt = $('[revTxt]').val();
			}
		})
		fixForm();
		fixPage();
	})
}
var actReat = 0;
function setStarsRate() {
	reat = 0;
	$('.revStars > div[v]').mouseenter(function () {
		v = parseInt($(this).attr('v'));
		showActStars(v);
		$('.revStars [n]').html(v + '.0');
	})
	$('.revStars > div[v]').mouseout(function () { showActStars(reat); })
	$('.revStars > div[v]').click(function () {
		reat = parseInt($(this).attr('v'));
		actReat = reat;
		showActStars(reat);
	})
}

function showActStars(v) {
	starCol = '#dddf0f';
	$('.revStars > div[v]').css('background-color', '');
	if (v) {
		rateVal = v;
		for (i = 1; i <= v; i++) {
			$('.revStars > div[v="' + i + '"]').css('background-color', starCol);
		}
	}
	$('.revStars [n]').html(v + '.0');
}
function rateVisSave() {
	note = $('#rateNote').val();
	if (rateVal) {
		loader_msg(1, k_loading);
		$.post(f_path + "X/gnr_rate_info_save.php", { id: actRteVis, mood: actRteMood, r: rateVal, note: note }, function (data) {
			d = GAD(data);
			if (d) {
				msg = k_done_successfully; mt = 1;
				rateVis(actRteVis, actRteMood);
				loadModule();
			} else {
				msg = k_error_data; mt = 0;
			}
			loader_msg(0, msg, mt);
		})
	} else {
		nav(3, k_eva_before_saving);
	}
}
/*******/
function pat_vis_his(id) {
	loadWindow('#m_info2', 1, k_patient_info, www, 200);
	$.post(f_path + "X/gnr_pat_visits_info.php", { id: id }, function (data) {
		d = GAD(data);
		$('#m_info2').html(d);
		fxObjects($('.win_body'));
		fixForm();
		fixPage();
	})
}
function pat_vis_his_in(v, m) {
	$('#svhInfo').html(loader_win);
	$.post(f_path + "X/gnr_pat_visits_info_in.php", { v: v, m: m }, function (data) {
		d = GAD(data);
		$('#svhInfo').html(d);
		fixForm();
		fixPage();
	})
}
function showHVists(m) {
	if (m) {
		$('[visList]').each(function () {
			if ($(this).attr('mood') == m) {
				$(this).show(200);
			} else {
				$(this).hide(200);
			}
		})
	} else {
		$('[visList]').show(200);
	}
}
function printAnaOrder(id) {//رسالة طباعة طلب التحليل
	open_alert(id, 'lab_printOrd', k_req_printed_will_deleted, k_print_ana_request);
}
function printAnaOrderDo(id) {//طباعة طلب التحليل
	loader_msg(1, k_loading);
	act_ana_detales = id;
	$.post(f_path + "X/lab_rec_print_ord.php", { id: id }, function (data) {
		d = GAD(data);
		if (d) {
			msg = k_done_successfully; mt = 1;
			printAnalysis2();
			closeRecWin();
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function printXryOrder(id) {//رسالة طباعة طلب التحليل
	open_alert(id, 'xry_printOrd', k_xray_will_printed, k_print_xray_req);
}
function printXryOrderDo(id) {//طباعة طلب الأشعة
	loader_msg(1, k_loading);
	act_xry_detales = id;
	$.post(f_path + "X/xry_rec_print_ord.php", { id: id }, function (data) {
		d = GAD(data);
		if (d) {
			msg = k_done_successfully; mt = 1;
			printWindow(3, act_xry_detales);
			closeRecWin();
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function reOpenLabVis(id) {
	open_alert(id, 'lab_reOpen', k_open_for_edit, k_open_lab_visit);
}
function reOpenLabVisDo(id) {
	actNewVis = id;
	actNewVisMood = 2;
	loader_msg(1, k_loading);
	act_ana_detales = id;
	$.post(f_path + "X/lab_rec_reopne_visit.php", { id: id }, function (data) {
		d = GAD(data);
		if (d) {
			actNVClinic = d;
			msg = k_done_successfully; mt = 1;
			recNewVisSrv(actNewVis, actNewVisMood);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
function viewActTimeSec(n) {
	if (n == 4) { n = 2; }
	$('[rTab]').hide(200);
	$('[rTab=' + n + ']').show(200);
}
function epay_send() {
	$('#epay_rep_data').html(loader_win);
	data = get_form_vals('#wr_input');
	$('[sendEpData]').hide();
	$.post(f_path + "X/gnr_report_epay.php", data, function (data) {
		d = GAD(data);
		$('#epay_rep_data').html(d);
		$('[sendEpData]').show(200);
		fixForm();
		fixPage();
	})
}
function rate_report_send() {
	$('#epay_rep_data').html(loader_win);
	data = get_form_vals('#wr_input');
	$('[sendEpData]').hide();
	$.post(f_path + "X/gnr_rate_report.php", data, function (data) {
		d = GAD(data);
		$('#epay_rep_data').html(d);
		$('[sendEpData]').show(200);
		fixForm();
		fixPage();
	})
}

function prvClnoprCount(t) {
	$.post(f_path + "X/gnr_preview_counter.php", { p_id: patient_id, t: t }, function (data) {
		d = GAD(data);
		n = parseInt(d);
		st = 'off';
		oprTot = '';
		if (n > 0) { st = 'on'; oprTot = ' (' + n + ')'; }
		$('[oli=' + t + '] [act]').attr('act', st);
		$('[oli=' + t + '] [n]').html(oprTot);
	})
}
/***************/
function AnalysisN(id, anType) {
	actAnType = anType;
	if (sezPage == 'Preview-Clinic') { inWin(k_lab_tests, '', 2); }
	if (sezPage == 'denPrvNew') { openLasWin(k_lab_tests); }

	if (anType == 1) { $('#bwtto').remove(); }
	$.post(f_path + "X/gnr_prv_analysis.php", { id: id, p_id: patient_id, v_id: visit_id }, function (data) {
		d = GAD(data);
		if (sezPage == 'Preview-Clinic') { inWin('', d, 2); }
		if (sezPage == 'denPrvNew') { $('#iwB').html(d); }
		ana_ls();
		fixPage();
		if (id != 0) { loadAna(id); }
	})
}

function loadAna(a_id) {
	$('[anaDet]').html(loader_win);
	act_ana_detales = a_id;
	$.post(f_path + "X/gnr_preview_analysis_info.php", { id: a_id }, function (data) {
		d = GAD(data);
		$('.ana_ls').css('background-color', '');
		$('.ana_ls[a_id=' + a_id + ']').css('background-color', '#aaa');
		$('[anaDet]').html(d);
		fixPage()
	})
}
function save_anaVal() {
	pars = '';
	$('.ana_values').each(function (index, element) {
		a_id = $(this).attr('id');
		values_v = $('.ana_values_v' + a_id).val();
		values_n = $('.ana_values_n' + a_id).val();

		if (index != 0) pars += '|';
		pars += a_id + ':' + values_v + ':' + values_n;
	});
	loader_msg(1, k_saving);
	$.post(f_path + "X/gnr_preview_analysis_info_save.php", { pars: pars }, function (data) {
		loader_msg(0, k_done_successfully, 1);
		win('close', '#m_info');
		//getTopStatus('x',1);
		prvClnoprCount('ana');
	})
}
function ana_ls() {
	$('[a_id]').click(function () {
		a_id = $(this).attr('a_id');
		loadAna(a_id)
	})
}
/****/
function m_xphotoN(n) {
	act_xph_detales = 0;
	if (sezPage == 'Preview-Clinic') { inWin(k_radio_graphies, '', 2); }
	if (sezPage == 'denPrvNew') { openLasWin(k_radio_graphies); }
	$.post(f_path + "X/gnr_preview_radiology.php", { p_id: patient_id, v_id: visit_id }, function (data) {
		d = GAD(data);
		if (sezPage == 'Preview-Clinic') { inWin('', d, 2); }
		if (sezPage == 'denPrvNew') { $('#iwB').html(d); }
		xph_ls();
		if (n > 0) { slexp_d(n); }
		fixPage();

	})
}
function slexp_d(a_id) {
	$('#part_detail').html(loader_win);
	$.post(f_path + "X/gnr_preview_radiology_info.php", { id: a_id }, function (data) {
		d = GAD(data);
		$('#part_detail').html(d);
		//$('.xph_ls').css('border-bottom','');
		//$('.xph_ls[a_id='+a_id+']').css('border-bottom','3px #f00 solid');		
		act_xph_detales = a_id;
		fixPage();
	})
}
function delXph(id) {
	open_alert(id, 44, k_dl_ph_rq, k_dl_rq);
}
function cancel_xph(id) {
	loader_msg(1, k_deleting);
	$.post(f_path + "X/gnr_preview_radiology_del.php", { id: id }, function (data) {
		d = GAD(data);
		if (d == 1) {
			win('close', '#m_info2');
			msg = k_done_successfully; mt = 1;
			m_xphotoN(0);
			getTopStatus('x', 1);
		} else {
			msg = k_error_data; mt = 0;
		}
		loader_msg(0, msg, mt);
	})
}
/******Nurses********/
var actNues = 0;
var actNuesMood = 0;
var actNuesVis = 0;
var actReat = 0;

function rateNurs(mood, vis) {
	actNuesMood = mood;
	actNuesVis = vis;
	loadWindow('#full_win1', 1, k_nurse_ass, 890, 800);
	$.post(f_path + "X/gnr_nurs_list.php", { mood: mood, vis: vis }, function (data) {
		d = GAD(data);
		actReat = 0;
		$('#full_win1').html(d);
		$('[nursSer]').focus();
		$('[saveNRate]').click(function () { saveNursRate(); })
		$('[cancelNRate]').click(function () { saveNursRate(0); })
		$('[nursNo]').click(function () {
			no = $(this).attr('nursNo');
			name = $(this).attr('nursName');
			selectNurs(no, name)
		})
		$('[nursNo]').click(function () {
			no = $(this).attr('nursNo');
			name = $(this).attr('nursName');
			selectNurs(no, name);
		})
		$('[nursSer]').keyup(function () {
			str = $(this).val();
			if (str == '') {
				$('[nursName]').show();
			} else {
				$('[nursName]').each(function (index, element) {
					txt = $(this).attr('nursName').toLowerCase();
					n = txt.search(str);
					if (n != (-1)) { $(this).show(100); } else { $(this).hide(100); }
				})
			}
		});
		fixForm();
		fixPage();
	})
}
function selectNurs(no, name) {
	actNues = no;
	$('.form_header').html('');
	$('[saveNRate]').show();
	$('[nursNo]').hide();
	$('[nursNo=' + no + ']').show();
	$('[nursNo=' + no + ']').removeClass('Over2');
	$('.revStars').show();
	$('#m_info').dialog({ width: 300, height: 400 });
	setStarsRate();
	actReat = 0;
	fixForm();
	fixPage();
}
function saveNursRate(rate = 1) {
	if (rate) {
		if (actReat != 0) {
			loader_msg(1, k_saving);
			$.post(f_path + "X/gnr_nurs_save.php", { mood: actNuesMood, vis: actNuesVis, nurs: actNues, rate: actReat }, function (data) {
				d = GAD(data);
				if (d == 1) {
					win('close', '#full_win1');
					if (actNuesMood == 1) { $('[finish]').attr('s'); prvEnd(s); }
					if (actNuesMood == 4) { prvDEnd(); }
					loader_msg(0, '', 0);
				} else {
					loader_msg(0, k_error_data, 0);
				}
			})
		} else {
			loader_msg(1, k_saving);
			loader_msg(0, k_path_should_eva, 0);
			rateVal = 0;
		}
	} else {
		win('close', '#full_win1');
		if (actNuesMood == 1) { $('[finish]').attr('s'); prvEnd(s, 0); }
		if (actNuesMood == 4) { prvDEnd(0); }
	}
}
/*********Nurses Report****************/
var actNursInfo = 0;
function nursesSet() {
	$('.centerSideIn').on('click', '[nurs_no]', function () { nursInfo($(this).attr('nurs_no')); })
	$('body').on('click', '[nursOprs] div', function () { nursInfo(actNursInfo, $(this).attr('on')); })

}
function nursInfo(id, opr = 0) {
	actNursInfo = id;
	if (opr == 0) {
		loadWindow('#full_win1', 1, k_nurse_ass, www, hhh);
	} else {
		$('#nursInfoData').html(loader_win);
	}
	$.post(f_path + "X/gnr_nurs_info.php", { id: id, opr: opr }, function (data) {
		d = GAD(data);
		if (opr == 0) {
			$('#full_win1').html(d);
			nursInfo(id, 1);
			fxObjects($('.win_free'));
		} else {
			$('#nursInfoData').html(d);
		}
		fixForm();
		fixPage();

	})
}
var mtnVis = 0;
var mtnMood = 0;
var MTN_trans_id = 0;
function mtnPayWin(vis, mood, pay) {
	mtnVis = vis;
	mtnMood = mood;
	//loadWindow('#m_info',1,'',500,200);	
	openRecWin('MTN كاش', 1, 2);
	$.post(f_path + "X/gnr_mtn.php", { v: vis, m: mood, pay: pay }, function (data) {
		d = GAD(data);
		$('.rwBody').html(d);
		fixForm();
		fixPage();
		//fxObjects($('.win_body'));
	})
}
function createMTNPay() {
	mobile = $('#mp_moble').val();
	amount = parseInt($('#mp_amount').val());
	max_amount = parseInt($('#mp_amount').attr('max'));
	$('#payErr').html('');
	if (amount > max_amount) {
		nav(3, k_am_not_exceed + max_amount, 0);
	} else {
		$('#payData').hide();
		$('#payDataLoader').show();
		$('#payErr').html('');
		$.post(f_path + "X/gnr_mtn_create.php", { v: mtnVis, m: mtnMood, pay: amount, mobile: mobile }, function (data, status) {
			d = GAD(data);
			var obj = jQuery.parseJSON(d);
			$('#payDataLoader').hide();
			if (obj.err > 0) {
				$('#payErr').html(obj.msg);
				$('#payData').show();
			} else {
				$('#payDataOPT').show();
				MTN_trans_id = obj.trans_id;
			}
			fixForm();
			fixPage();
		})
	}
}
function sendMTNotp() {
	otp = $('#mp_OTP').val();
	$('#payDataOPT').hide();
	$('#payDataLoader').show();
	$('#payErr').html('');
	//loader_msg(1,'جاري التأكيد');
	if (otp) {
		$.post(f_path + "X/gnr_mtn_opt.php", { otp: otp, trans_id: MTN_trans_id }, function (data, status) {
			d = GAD(data);
			var obj = jQuery.parseJSON(d);
			$('#payDataLoader').hide();
			if (obj.err > 0) {
				$('#payErr').html(obj.msg);
				$('#payDataOPT').show();
				msg = obj.msg; mt = 0;
			} else {
				msg = k_done_successfully; mt = 1;
				recNewVisSrvSta(mtnVis, mtnMood);
			}
			loader_msg(0, msg, mt);
			fixForm();
			fixPage();
		})
	} else {
		nav(3, k_enter_code_first, 0);
	}
}
/*************Data*************/
$(document).ready(function () {
	$('.table_list div').click(function () { loadData($(this).html()); })
})
function loadData(table, p = 0) {
	$('#tableData').html(loader_win);
	$.post(f_path + "X/gnr_data.php", { table: table, p: p }, function (data) {
		d = GAD(data);
		$('#tableData').html(d);
	})
}


