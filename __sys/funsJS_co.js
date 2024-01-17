var mod_data = new Array(); var ord_data = new Array(); var t_ord = new Array(); var c_ord = new Array(); var m_ord = new Array(); var form_win_set = new Array(); var form_cb_set = new Array(); var form_bv_set = new Array(); var form_type_set = new Array(); var ActivOrder = 0; var act_delRec = 0; var sendingParsToForm = ''; var form_type = new Array(); var form_id = ''; var win_level_pointer = 0; var backCall = ''; var column = ''; var parent_loader = ''; var Sub = ''; var actListEvent = ''; var loader_win = '<div class="loadeText">' + k_loading + '</div>'; var BarEditedId = 0; var timerLo = ''; var timerbc = ''; var hIds = ''; var pageNo = 0; var mod = ''; var mod_sort = ''; var mod_sort_dir = ''; var fil_pars = ''; var filtimer = ''; var actSncType = 0; var actSncS = 0; var actSncE = 0; var actSncN = 0; var sncStop = 0;
var short_loader = '<div class="short_loader"></div>';

$(document).ready(function () {
	if (sezPage == 'Report-Sync') { set_sync(); }
	ser_open = 1;
	setMenu();
	if (Array.isArray(mod_data[0])) { loadModule(); }
	setOrder();
	setFilter(0);
	/***********************************************/
	$('.fil_rest').click(function () { ser_reset(0); })
	$('.filBut').click(function () {
		fil_link = $(this).attr('link');
		fil_val = $(this).attr('val');
		last_val = $('#' + fil_link).val();

		$('.filBut[link=' + fil_link + ']').each(function (index, element) {
			$(this).css('background-color', '');
			$(this).css('color', '');
		});

		if (fil_val == last_val) {
			$('#' + fil_link).val('');
		} else {
			$('#' + fil_link).val(fil_val);
			$(this).css('background-color', clr1111);
			$(this).css('color', '#fff');
		}
		loadFilter();
	})
	$('body').on('click', '[tpView]', function () { viewTpDemo($(this)); })
	$('body').on('click', '[tpView]', function () { viewTpDemo($(this)); })
	LOG();
	LOG_load();
})
var mns_ser = '';
var act_mns = 1;
function setMenu() {
	setTimeout(function () { loadMenu(); }, 500);
	setTimeout(function () { loadFav(); }, 1000);
	setTimeout(function () { loadProf(); }, 1500);
	$('#mnSrc').keyup(function () {
		clearTimeout(mns_ser); mns_ser = setTimeout(function () { loadMenu(); }, 800);
	})
	$('.thic[n]').click(function () {
		act_mns = $(this).attr('n');
		if (act_mns != 0) { $('.th_win[n=' + act_mns + '], .menuBg').show(); }
		if (act_mns == '1') { $('#mnSrc').focus(); }
		fixPage();
	})
	$('.thic[nw]').click(function () {
		act_mnn = $(this).attr('nw');
		setTimeout(function () {
			if (act_mnn == 'alertW') {
				$('[nwn="profile"]').hide();
				showNotiList();
			}
			if (act_mnn == 'profile') {
				$('[nwn="alertW"]').hide();
				showItem('#profileWin');
			}
			fixPage();
		}, 50)
	})
	$('.thic_x , .menuBg ').click(function () { closeMmenu(); })
	$('.favSet').click(function () { showFavorite(); })
	$('.favOrd').click(function () { favMenuOrder(); })
	$('.profEdit').click(function () { editProfile(); })
	$('#thic_exit').click(function () { logOutmsg(); })
	$('.thic_help').click(function () { hCode = $(this).attr('code'); openHelpWin(hCode); })
}
function closeMmenu() {
	$('.th_win, .menuBg').hide();
	if (act_mns == '1') {
		$('.sub_menu').hide();
		if ($('#mnSrc').val()) { $('#mnSrc').val(''); loadMenu(); }
	}
}
function loadMenu() {
	menSrc = $('#mnSrc').val();
	if (menSrc) { $('.th_mH').width(400); } else { $('.th_mH').width(''); }
	$('#mHList').html('<div class="menuLoader"> </div>');
	$.post(f_path + "S/sys_menu.php", { s: menSrc }, function (data) {
		d = GAD(data);
		$('.sub_menu').hide();
		$('#mHList').html(d);
		$('#mHList a[href]').click(function () { if (!ctrP) { loader_msg(1, k_loading); } });
		$('.menuList_row').on('mouseenter click', function () {
			$('.sub_menu_tab').hide();
			m_id = $(this).attr('id');
			m_num = m_id.substr(1);
			$('#tab_' + m_id).show();
			clearTimeout(menuTimer);
			clearTimeout(menuTimer2);
			m_sub = $(this).attr('m_sub');
			if (typeof m_sub !== typeof undefined && m_sub !== false) {
				$('.sub_menu').show();
				tab_h = $('#tab_' + m_id).height() + 1;
				top_plac = YMO - 35;
				if ((hhh) - (tab_h + top_plac) < 0) {
					if (tab_h > hhh) { top_plac = 0; } else { top_plac = (hhh - tab_h); }
				}
				$('#tab_' + m_id).css('margin-top', top_plac);
				fixPage();
				fixForm();

			} else {
				$('.sub_menu').hide();
			}
		})
		$('.sub_menu').mouseover(function () { $('.sub_menu').show(); })
		$('.sub_menu').mouseout(function () { $('.sub_menu').hide(); })
		fixForm();
		fixPage();
	})
}
function loadFav() {
	$('#favList').html('<div class="menuLoader"> </div>');
	$.post(f_path + "S/sys_menu_fav.php", function (data) {
		d = GAD(data);
		$('#favList').html(d);
		$('#favList a[href]').click(function () { if (!ctrP) { loader_msg(1, k_loading); } });
		$('.favHopr').click(function () {
			fMod = $(this).attr('m');
			fOpr = $(this).attr('o');
			fav_opr(fOpr, fMod);
		})
		fixForm();
		fixPage();
	})
}
var actHlpCode = 0;
function openHelpWin(code, t = 1, s = '') {
	if (t == 1) { loadWindow('#full_win1', 1, k_help, www, hhh); }
	if (t == 3) {
		$('.helpDet').html(loader_win);
		$('.helpTree [t]').attr('t', 'off');
		actHlpCode = code;
	}
	$.post(f_path + "S/sys_help.php", { code: code, t: t }, function (data) {
		d = GAD(data);
		if (t == 1) {
			$('#full_win1').html(d);
			$('.helpTree [s]').click(function () {
				s = $(this).attr('s');
				s_code = $(this).parent().attr('c');
				if (s == 'on') {
					$(this).attr('s', 'off');
					$('[ms=' + s_code + ']').slideUp(200);
				} else {
					$(this).attr('s', 'on');
					if ($('[ms=' + s_code + ']').html() == '') {
						$('[ms=' + s_code + ']').html(loader_win);
						openHelpWin(s_code, 2);
					} else {
						$('[ms=' + s_code + ']').slideDown(200);
					}
				}
			})
			$('.helpTree [t]').click(function () {
				t = $(this).attr('t');
				s_code = $(this).parent().attr('c');
				if (t == 'off') {
					openHelpWin(s_code, 3);
				}
			})
			openHelpWin(code, 3);
		} else if (t == 2) {
			$('[ms=' + code + ']').html(d);
			setHlpSubTit(code);
		} else if (t == 3) {
			dd = d.split('^');
			if (dd.length == 2) {
				$('[ms=' + code + ']').html(dd[0]);
				setHlpSubTit(code);
				$('.helpDet').html(dd[1]);
				$('[ms=' + code + ']').slideDown(200);
				$('[c=' + code + '] [s]').attr('s', 'on');
				$('[c=' + code + '] [t]').attr('t', 'on');
				$('[vid]').click(function () {
					vid = $(this).attr('vid');
					vidTitle = $(this).html();
					showHlpVid(vidTitle, vid);
				})
				if (s != '') {
					hlpTxtFocus(s);
				}
			}
		}
		fixForm();
		fixPage();
	})
}
function setHlpSubTit(code) {
	$('[ms=' + code + ']').find('div[sTit]').click(function () {
		stn = $(this).attr('sTit');
		pCode = $(this).closest('[ms]').attr('ms');
		if (pCode != actHlpCode) {
			openHelpWin(pCode, 3, stn);
		} else {
			hlpTxtFocus(stn);
		}
	})
}
function hlpTxtFocus(n) {
	blcPos = $('#b_' + n).position().top;
	desPos = $('.helpDet').scrollTop();
	m = desPos + blcPos - 40;
	$(".helpDet").animate({ scrollTop: m });
	hlpTxtFlash($('#b_' + n));
}
function hlpTxtFlash(blc, t = 3000) {
	blc.addClass('blcFl');
	setTimeout(function () { blc.removeClass('blcFl'); }, t);
}
function showHlpVid(title, v) {
	loadWindow('#m_info5', 1, title, 800, 600);
	$.post(f_path + "S/sys_help.php", { code: actHlpCode, v: v }, function (data) {
		d = GAD(data);
		$('#m_info5').html(d);
		$('#m_info5').dialog('option', 'closeOnEscape', false);
		fixForm();
		fixPage();
	})
}
function closeHelpVid() {
	$('#m_info5').dialog('option', 'closeOnEscape', true);
	win('close', '#m_info5')
}
function loadProf() {
	$('#profList').html('<div class="menuLoader"> </div>');
	$.post(f_path + "S/sys_menu_profile.php", function (data) {
		d = GAD(data);
		$('#profList').html(d);
		$('.mwEditPro').click(function () { editeProfPass(); })
		fixForm();
		fixPage();
	})
}
function editProfile() {
	loader_msg(1, k_loading);
	$.post(f_path + "S/sys_profile_edit.php", function (data) {
		loader_msg(0, '', 0);
		d = GAD(data);
		eval(d)
	})
}
function editeProfPass() {
	loadWindow('#m_info5', 1, k_edit_account, 500, 0);
	$.post(f_path + "S/sys_profile_edit_pass.php", function (data) {
		d = GAD(data);
		$('#m_info5').html(d);
		setupForm('perAcc', '');
		setTimeout(function () { $('[name=op]').val(''); }, 500);
		fixForm();
		fixPage();
	})
}
function ePPsSave() {
	err = 0;
	msg = '';
	np = $('[name=np]').val();
	rp = $('[name=rp]').val();
	if (np && rp) {
		if (np.length < 6) { err = 1; msg = k_pass_less; }
		else { if (np != rp) { err = 1; msg = k_pass_no_match; } }
	}
	if (err == 0) { sub('perAcc'); } else { nav(3, msg); }
}
function ePPsSaveCb(o) {
	if (o == 1) {
		loc(f_path + 'Logout');
	} else {
		nav(3, k_error_data);
		loader_msg(0, '', 0);
	}
}
function logOutmsg() {
	open_alert(0, 'out', k_wld_log_out, k_logout)
}
function logOutmsgDo() { loc(f_path + 'Logout'); }
function loadWindow(sel, loader, title, w, h) {
	if (loader == 1) { $(sel).html(loader_win); }
	if (title != '') { $(sel).dialog('option', 'title', title); }
	if (w != 0) { $(sel).dialog('option', 'width', w); }
	if (h != 0) { $(sel).dialog('option', 'height', h); }
	$(sel).dialog('open');
	fxObjects($(sel));
}
function loadWindowFull(page, sel, title = '', id = 0, w = 750, h = 600, loader = 1) {
	if (loader == 1) { $(sel).html(loader_win); }
	if (title != '') { $(sel).dialog('option', 'title', title); }
	$(sel).dialog('option', 'width', w);
	$(sel).dialog('option', 'height', h);
	$(sel).dialog('open');
	$.post(f_path + page + ".php", { id: id }, function (data) {
		d = GAD(data);
		$(sel).html(d);
		fixForm();
		fixPage();
		fxObjects($(sel));
	})
}/*
function reciveUpData(filed,data,folder){
	d=GAD(data);	
	$("#upout_"+filed).append(d);
	get_ides(filed,folder);
}*/
function loadGrad() {
	$('.grad_s tr').mouseover(function () {
		Tover = $(this).closest('table').attr('over');
		if (Tover != 0) {
			if (Tover == 2) {
				$(this).children('td').css('opacity', '0.7');
			} else {
				$(this).children('td').css('color', '#000');
				$(this).children('td').css('background-color', clr44);
			}
		}
		$(this).find('.pat_link').css('color', clr5);
		$(this).find(".options").show();
	})
	$('.grad_s tr').mouseout(function () {
		Tover = $(this).closest('table').attr('over');
		if (Tover != 0) {
			if (Tover == 2) {
				$(this).children('td').css('opacity', '1');
			} else {
				$(this).children('td').css('color', '#676771');
				$(this).children('td').css('background-color', '');
			}
		}
		$(this).find('.pat_link').css('color', '');
		$(this).find(".options").hide();
	})
	$('.options').mouseenter(function () {
		$(this).find(".options_cont").show();
		$(this).find(".options_cont div").show("slide", { direction: k_Xalign }, 100);
	})

	$('.options').mouseleave(function () {
		$(this).find(".options_cont div").hide("slide", { direction: k_Xalign }, 100, function () {
			$(this).find(".options_cont").hide();
		})
	})

	$('.options .options_cont').each(function (index) {
		allButt = 0;
		$(this).children('div').each(function () {
			allButt++;
		})
		h = (((allButt) * 49)) * (-1);
		$(this).css('margin-' + k_align, h);
	});
	g_switch_butt();
}/*
function get_ides(filed,folder){
	i=0;
	out='';
	$('.file_ex[filed='+filed+']').each(function(index, element){
		id=$(this).attr('f_id')
		if(i!=0)out+=',';        
		out+=id;
		i++;
    });
	$('.file_ex').mouseover(function(){		
		$(this).children('.file_ex_over').show();
    });
	$('.file_ex').mouseout(function(){
		$(this).children('.file_ex_over').hide();
    });
	$('input[name='+filed+']').val(out);
	//---delete Button+	
	$('.up_del').click(function() {
        del_id=$(this).parent().parent().attr('f_id');
		filed=$(this).parent().parent().attr('filed');
		$('.file_ex[f_id='+del_id+']').hide(500,function(){
			$('.file_ex[f_id='+del_id+']').remove();
			get_ides(filed,folder);
		})
    });
	//---view Button
	$('.up_view').click(function(){
        file=$(this).parent().parent().attr('file');
		$('.loadWin').html('<div class="winPhoto"></div>');
		$('.winPhoto').click(function(e){$('.loadWin').hide();});
		
		$('.winPhoto').width(www-40);
		$('.winPhoto').height(hhh-40);
		org_h=$(this).parent().parent().attr('org_h');
		org_w=$(this).parent().parent().attr('org_w');
		ss=getPerfitSize(org_w,org_h);
		$('.winPhoto').html('<img src="'+m_path+'up/'+folder+file+'" width="'+ss[0]+'" height="'+ss[1]+'" />');
		$('.loadWin').show();			
    });
}*/
function loader_w(msg) {
	return '<div class="loadeText">' + msg + '</div>';
}
function loader_msg(n, msg, t, time = 3.5) {
	time = time * 1000;
	$('.PageLoaderWin').height('100%');
	$('.PageLoaderWin div[c]').attr('c', 't');
	$('.PageLoaderWin div[c]').attr('c', 't' + t);
	$('.PageLoaderWin div[s]').html(msg);
	$('.PageLoaderWin').removeAttr('cls');
	if (n == 1) {
		$('.PageLoaderWin div').hide();
		$('.PageLoaderWin').show();
		$('.PageLoaderWin div').slideDown(250);
	} else {
		if (n == 2) {
			$('.PageLoaderWin div').hide();
			$('.PageLoaderWin').show();
			$('.PageLoaderWin div').slideDown(150);
		}


		if (msg == '') {
			$('.PageLoaderWin div').hide(); $('.PageLoaderWin').hide();
			$('.PageLoaderWin').hide(); $('.PageLoaderWin').hide();
		} else {
			$('.PageLoaderWin').attr('cls', 1);
			$('.PageLoaderWin').height('0%');
			setTimeout(function () {
				$('.PageLoaderWin div').slideUp(250, function () { $('.PageLoaderWin').hide(); });
			}, time);
		}
	}
}
function getPerfitSize(w, h) {
	if (www > w && hhh > h) {
		return [w, h];
	}
	if ((www / w) < (hhh / h)) {
		return ['100%', ''];
	} else {
		return ['', '100%'];
	}
}
var winTitle = '';
function co_loadForm(id, type, Filed, evn, winTitle = '') {
	if (typeof evn !== typeof undefined && evn !== false) { actListEvent = evn; } else { evn = ''; }
	winT = k_add_rec;
	//$('#opr_form'+Sub).dialog('option','title',k_add_rec);
	id2 = '';
	if (id == 'liop') {
		id2 = 'liop';
		Sub++;
		id = 0;
	} else { Sub = 0; }
	add_vals = '';
	if (type == 4) {
		dd = Filed.split('|');
		Filed = dd[0];
		add_vals = dd[1];
		type = 1;
	}
	if (type == 3) {
		fil_data = Filed.split('|');
		this_mod = fil_data[0];
		Filed = fil_data[1];
		if (id2 != 'liop') { Sub = 0; }
		backCall = fil_data[2];
		add_vals = fil_data[3];
	} else {
		this_mod = mod_data[Filed][0];
		Sub = mod_data[Filed][1];
		column = mod_data[Filed][2];
	}
	if (form_type[Sub] == undefined || type == 3) { form_type[Sub] = type; }
	form_id = id;
	if (type == 11) { form_id = 0; }
	if (type == 1 || type == 11) {
		setWin('opr_form' + Sub, k_add_rec);
		$('#opr_form' + Sub).html(loader_win);
		if (id != '0' && type == 1) {
			winT = k_edit_record;
			//$('#opr_form'+Sub).dialog('option','title',k_edit_record);
		}
		//$('#opr_form'+Sub).dialog('option','width',600);
		$('#opr_form' + Sub).dialog('open');
	}
	if (type == 2) {
		ser_reset(1);
		Open_co_filter('hide');
		if (column == 2) {
		} else {
			if (id != 0) { switchHeader('list', 'edit'); } else { switchHeader('list', 'add'); }
			$('#mwFooter').html('');
		}
		$('.centerSideIn').html(loader_win);
	}
	if (type == 3) {
		setWin('opr_form' + Sub, k_add_rec);
		$('#opr_form' + Sub).html(loader_win);
		if (id != '0') {
			winT = k_edit_record;
			//$('#opr_form'+Sub).dialog('option', 'title',k_edit_record);
		}
		$('#opr_form' + Sub).dialog('option', 'width', 600);
		$('#opr_form' + Sub).dialog('open');
	}
	if (winTitle != '') {
		winT = winTitle;
		//$('#opr_form'+Sub).dialog('option', 'title',winTitle);
		winTitle = '';
	}
	setWin('opr_form' + Sub, winT);
	//$('#opr_form'+Sub).dialog('option', 'title',winT);
	$.post(f_path + "S/sys_form_get.php", { mod: this_mod, id: id, sptf: sendingParsToForm, type: type, Sub: Sub, fil: Filed, col: column, bc: backCall, add_vals: add_vals }, function (data) {
		d = GAD(data);
		if (d == 'out') { out(); } else {
			if (form_type[Sub] == 1 || form_type[Sub] == 11 || form_type[Sub] == 3) { $('#opr_form' + Sub).html(d); }
			if (Sub == 0) {
				if (form_type[Sub] == 2) { $('.centerSideIn').html(d); switchHeader('opr', ''); }
			} else {
				win_level_pointer++;
			}
			loadFormElements('#co_form' + Sub);
			setupForm('co_form' + Sub, 'opr_form' + Sub);
			fixForm();
			fixPage();
			if (setBarcode('#opr_form' + Sub) == 0) {
				$('#co_form' + Sub + ' td input[type]').first().focus();
				//$('#co_form'+Sub+' td input[type=number]').first().focus();			
				//$('#co_form'+Sub+' input').attr('type','text');
			};
		}
	})
}
function co_ViewRec(id) {
	loadWindow('#m_info', 1, k_view_record, 600, 0);
	$.post(f_path + "S/sys_view_rec.php", { mod: mod, id: id }, function (data) {
		d = GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function switchHeader(s, t) {
	if (t == 'add') { $('#m_total').html('( <span>' + k_add_rec + '</span> )'); }
	if (t == 'edit') { $('#m_total').html(k_edit_record); }
	if (s == 'list') {
		$('.top_icons[type=opr]').hide();
		$('.top_icons[type=list]').show();
	}
	if (s == 'opr') {
		$('.top_icons[type=list]').hide();
		$('.top_icons[type=opr]').show();
	}
}
function setupForm(id, win = '', type = '') {
	form_win_set[win_level_pointer] = win;
	form_cb_set[win_level_pointer] = '';
	form_bv_set[win_level_pointer] = '';
	if ($('#' + id).attr('cb')) { form_cb_set[win_level_pointer] = $('#' + id).attr('cb'); }
	if ($('#' + id).attr('bv')) { form_bv_set[win_level_pointer] = $('#' + id).attr('bv'); }
	if ($('#' + id).attr('bv')) { form_type_set[win_level_pointer] = type; }
	var options = { beforeSubmit: _co_bs, success: _co_succ };
	$('#' + id).ajaxForm(options);
}
function _co_bs(formData, jqForm, options) {
	var queryString = $.param(formData);
	loader_msg(1, k_loading);
	return true;
}
function _co_succ(data, statusText, xhr, $form) {
	d = GAD(data);
	dd = d.split('<!--***-->');
	if (form_type_set[win_level_pointer] != 'x') {
		if (dd.length > 1) { d = dd[0]; $('#bcScript').html(dd[1]); }/////<--
	}
	if (d == 'do_x') {
		msg = k_done_successfully; loader_msg(0, msg, 1);
	} else {
		if (form_cb_set[win_level_pointer] != '') {
			if (d == 1) { msg = k_done_successfully; mt = 1; } else { msg = k_error_data; mt = 0; }
			if (form_win_set[win_level_pointer]) {
				if (form_win_set[win_level_pointer]) {
					$('#' + form_win_set[win_level_pointer]).dialog('close');
				}
			}
			msg = k_done_successfully; mt = 1;
			loader_msg(0, msg, mt);
			callThis = form_cb_set[win_level_pointer];
			if (form_bv_set[win_level_pointer] != '') {
				bv = form_bv_set[win_level_pointer];
				bv_arr = bv.split(',');
				bv_arr_b = d.split(',');
				if (bv_arr.length == bv_arr_b.length) {
					for (mm = 0; mm < bv_arr.length; mm++) {
						callThis = callThis.replace('[' + (mm + 1) + ']', bv_arr_b[mm]);
					}
				} else {
					callThis = '';
				}
				//CL(callThis)
			}
			//if(form_type_set[win_level_pointer]!='x'){
			doScript(callThis);
			//}
		} else {
			if (win_level_pointer == 0) {
				outD = d.split('^');
				if (outD.length == 2) {
					if (outD[0] == 'code') { doScript(outD[1]); }
					loader_msg(0, k_done_successfully, 1);
				} else {
					if (form_type[win_level_pointer] == 2) { switchHeader('list', ''); }
					if (form_type[win_level_pointer] == 3) {
						loader_msg(0, k_done_successfully, 1);
						$('#' + form_win_set[win_level_pointer]).dialog('close');
						$('#' + form_win_set[win_level_pointer]).html('<script>' + d + '</script>');
					} else {
						msg = '';
						if (d == 1) {
							loadModule();
							msg = k_done_successfully; mt = 1;
						} else {
							if (d == 'edit_In') {
								msg = k_done_successfully; mt = 1;
							} else {
								msg = k_error_data; mt = 0;
							}
						}
						loader_msg(0, msg, mt);
					}
					if (form_win_set[win_level_pointer]) {
						$('#' + form_win_set[win_level_pointer]).dialog('close');
					}
				}
			} else {
				msg = '';
				if (form_win_set[win_level_pointer]) {
					$('#' + form_win_set[win_level_pointer]).dialog('close');
				}
				win_level_pointer--;

				outD = d.split('^');
				if (outD.length == 2) {
					if (outD[0] == 'code') { doScript(outD[1]); }
					loader_msg(0, k_done_successfully, 1);
				} else {
					addResValToLIst(d);
				}
			}
		}
	}
}
function addResValToLIst(data) {
	dataToSend = '';
	res_data = data.split('|');
	msg = k_error_data; mt = 0;
	if (res_data[1] == 1) { msg = k_done_successfully; mt = 1; }
	if (res_data.length >= 3) {
		msg = k_done_successfully; mt = 1;
		res_id = res_data[0];
		cal_id = res_data[1];
		cal_val = res_data[2];
		if (actListEvent != '') {
			CLE_m(actListEvent, res_id.replace('cof_', ''), cal_id);
			actListEvent = '';
		}
		/******load sun after add record********************/
		sel_itm = $('#' + res_id);
		ppp_link = sel_itm.parent().attr('p_link');
		ppp_form = sel_itm.closest('form').attr('name');
		l_sub = sel_itm.closest('form').children('input[name=sub]').val();
		loadSun(ppp_link, cal_id, l_sub, '#' + ppp_form);
		/***************************************************/
		if ($('#ri_' + res_id).length) {
			dataToSend = '<input type="radio" name="' + res_id + '" value="' + cal_id + '" checked >\
				<label>'+ cal_val + '</label>';
			$('#ri_' + res_id).parent().append(dataToSend);
			$('.radioBlc_each[ri_name=' + res_id + ']').attr('ch', 'off');
			thisForm = $('#ri_' + res_id).closest('form').attr('id');
			loadFormElements('#' + thisForm);
			$('#ri_' + res_id).val(cal_id);
		} else if ($('#mlt_' + res_id).length) {
			n = $('div[chM=' + res_id + ']').attr('n');
			$('div[chM=' + res_id + ']').append('<div class="cMul" v="' + cal_id + '" ch="on" n="' + n + '" set>' + cal_val + '</div>');
			$('.cMul[n=' + n + '][v=' + cal_id + '][set]').click(function () {
				if ($(this).attr('ch') == 'on') { $(this).attr('ch', 'off'); } else { $(this).attr('ch', 'on'); }
				n = $(this).attr('n');
				$(this).removeAttr('set');
				getMultiValue(n)
			})
			getMultiValue(n);
		} else {
			dataToSend = '<option value="' + cal_id + '" selected >' + cal_val + '</option>';
			$('#' + res_id).append(dataToSend);
			res_id_x = res_id.replace('cof_', '');
			$('[s_link=' + res_id_x + ']').attr('deval', cal_id);
			loadSuns(',' + res_id.substr(4, res_id.length))
		}
	}
	loader_msg(0, msg, mt);
}
function showPhoto(id) {
	file = $('#' + id).attr('file');
	org_h = $('#' + id).attr('org_h');
	org_w = $('#' + id).attr('org_w');
	$('.loadWin').html('<div class="winPhoto"></div>');
	$('.winPhoto').click(function (e) { $('.loadWin').hide(); });
	$('.winPhoto').width(www - 40);
	$('.winPhoto').height(hhh - 40);
	ss = getPerfitSize(org_w, org_h);
	$('.winPhoto').html('<img src="' + file + '" width="' + ss[0] + '" height="' + ss[1] + '" />');
	$('.loadWin').show();
}
function ref_form() { co_loadForm(form_id, form_type, 0); }
function win(opr, sel) {
	if (opr == 'close') { $(sel).html(''); }
	if (opr == 'open') { $(sel).dialog('option', 'width', 600); loadFormElements(sel); } fixPage(); fixForm();
	$(sel).dialog(opr);
}
function co_del_rec(id) { open_alert(id, 's6', k_q_delete_rec, k_del_rec); }
function do_del_rec(id) {
	loader_msg(1, k_deleting);
	$.post(f_path + "S/sys_delRec_do.php", { id: id, mod: mod }, function (data) {
		d = GAD(data);
		dd = d.split('<!--***-->');
		if (dd.length > 1) { d = dd[0]; $('#bcScript').html(dd[1]); }
		if (d == 'x') {
			loader_msg(0, '', 0);
			nav(3, k_rc_ndt_lnk);
		} else {
			if (d == 1) { msg = k_done_successfully; mt = 1; } else { msg = k_error_data; mt = 0; }
			loader_msg(0, msg, mt);
			loadModule();
		}
	})
}
function co_del_rec_e(id) {
	$.post(f_path + "S/sys_delRec_evn.php", { id: id, mod: mod }, function (data) {
		d = GAD(data);
		if (d == '') { co_del_rec(id) } else { $('#bcScript').html(d); }
	})
}
function co_del_rec_cb(mod2, id, cb) { open_alert(mod2 + '::' + id + '::' + cb, 's66', k_q_delete_rec, k_del_rec); }
function do_del_rec_cb(id) {
	loader_msg(1, k_deleting);
	data = id.split('::');
	mod2 = data[0];
	id = data[1];
	cb = data[2];
	$.post(f_path + "S/sys_delRec_do.php", { id: id, mod: mod2 }, function (data) {
		d = GAD(data);
		if (d == 1) { msg = k_done_successfully; mt = 1; } else { msg = k_error_data; mt = 0; }
		loader_msg(0, msg, mt);
		doScript(cb);
	})
}
function co_del_sel() {
	open_alert('', 's5', k_del_selc, k_del_selc);
}
function co_del_sel_e() {
	rec = new Array();
	$('div[par=grd_chek] input').each(function () {
		r_id = $(this).val();
		rec.push(r_id);
	})
	$.post(f_path + "S/sys_delRec_evn.php", { rec: rec, mod: mod }, function (data) {
		d = GAD(data);
		if (d == '') { co_del_sel() } else { $('#bcScript').html(d); }
	})
}
function co_del_sel_do() { SH_Icon(0, 'ti_del'); $('#co_list_for').submit(); }
function delBack(b) {
	if (b != 'ok') { loader_msg(0, k_lnk_rc_ndt + ' <ff> ( ' + b + ' ) </ff>', 2); } loadModule();
}
function setOrder() {
	$('.g_ord tbody tr').each(function (index, element) { $(this).width(CSW - 20); });
	$('.g_ord tbody , .sortList').each(function (index, element) {
		var r = Math.floor((Math.random() * 10000) + 1);
		rrNO = $(this).attr('rrNO');
		if (typeof rrNO !== typeof undefined && rrNO !== false) { } else {
			$(this).attr('rrNO', r);
			$(this).sortable({
				axis: "y",
				cursor: "move",
				distance: 3,
				items: " [row_ord] ",
				placeholder: "orderPlace",
				handle: ".reSoHold",
				revert: true,
				tolerance: "pointer",
				create: function (event, ui) { creatOrderArray($(this)); },
				start: function (event, ui) { creatOrderArray($(this)); },
				beforeStop: function (event, ui) { startOrder(ui); },
				stop: function (event, ui) { sendOrderChang(); },
			});
		}
	});
}
function startOrder(u) { ActivOrder = u.item.closest('[rrNO]').attr('rrNO'); }
function creatOrderArray(u) {
	n = u.attr('rrNO');
	t_ord[n] = $('[rrNO=' + n + ']').closest('[t_ord]').attr('t_ord');
	c_ord[n] = $('[rrNO=' + n + ']').closest('[c_ord]').attr('c_ord');
	m_ord[n] = $('[rrNO=' + n + ']').closest('[mod_ord]').attr('mod_ord');
	o = 0;
	$('[rrNO=' + n + ']').find('[row_ord]').each(function (index, element) {
		o_id = $(this).attr('row_id');
		ord = $(this).attr('row_ord');
		if (typeof o_id != typeof undefined && o_id != false) {
			ord_data[n + '-' + o] = [o_id, ord];
			o++;
		}
	});
}
function sendOrderChang() {
	o = 0;
	f_ord = 0;
	ord_change = '';
	$('[rrNO=' + ActivOrder + ']').find('[row_ord]').each(function (index, element) {
		o_id = $(this).attr('row_id');
		ord = $(this).attr('row_ord');
		if (typeof o_id != typeof undefined && o_id != false) {
			if (o_id != ord_data[ActivOrder + '-' + o][0]) {
				if (f_ord != 0) ord_change += '|';
				ord_change += o_id + ':' + ord_data[ActivOrder + '-' + o][1];
				$(this).attr('row_ord', ord_data[ActivOrder + '-' + o][1])
				f_ord = 1;
			}
			o++;
		}
	});
	if (ord_change != '') { saveOrderChang(ord_change); }
}
function saveOrderChang(change) {
	modOrdSet = mod;
	if (m_ord[ActivOrder] == 'x') { modOrdSet = ''; }
	$.post(f_path + "S/sys_order.php", { t: t_ord[ActivOrder], c: c_ord[ActivOrder], d: change, mod: modOrdSet }, function (data) {
		d = GAD(data);
		if (d == 'x') { loadModule(); }
	})
}
function loadModule(m = '', l = 1) {
	if (mod != '') {
		//$('.centerSideIn').html(loader_win);
		if (l) { centerLoader(0); }
		filter = getFormFilter();
		$.post(f_path + "S/sys_grid.php", { mod: mod, p: pageNo, fil: filter, ms: mod_sort, msd: mod_sort_dir, sptl: sendingParsToForm }, function (data) {
			if (data == 'out') { out(); }
			d = data.split('<!--***-->');
			t = d[1] != 0;
			$('#m_total').html('(' + d[1] + ')'); loadFitterCostom
			$('.centerSideInHeader').html(d[2]);
			$('.centerSideIn').html(d[3]);
			centerLoader(1);
			$('#mwFooter').html(d[4]);
			fixPage();
			setOrder();
			setPaging();
			setupForm('co_list_for', '');
			loadFormElements('#co_list_for');
			setSort();
			$('.gTools').each(function () {
				no = $(this).children('div').length;
				$('.gTools').width(no * 46)
			})
		})
	}
}
function centerLoader(t) {
	if (t == 0) {
		$('.cenLoader').remove();
		$('.centerSideIn').before('<div class="cenLoader c_cont"><div>' + loader_win + '<div></div>');
		$('.centerSideIn').css('opacity', 0.3);
		$('.cenLoader').show();
	} else {
		//$('.cenLoader').hide(50);
		$('.cenLoader').remove();
		$('.centerSideIn').css('opacity', 1);
	}
}
function getFormFilter() {
	if (fil_pars != '') {
		data = '';
		fileds = fil_pars.split('|');
		for (i = 0; i < fileds.length; i++) {
			if (fileds[i] != '') {
				el = fileds[i].split(':');
				if (el[1] == 2) {
					if (el[2] == 1) {
						val = $('#fil_' + el[0]).val();
						if (val != '') { data += el[0] + ':' + val + ':|'; }
					} else {
						val1 = $('input[name=fil_' + el[0] + '_1]').val();
						val2 = $('input[name=fil_' + el[0] + '_2]').val();
						if (val1 != '' || val2 != '') { data += el[0] + ':' + val1 + ':' + val2 + '|'; }
					}
				} else {
					val = $('#fil_' + el[0]).val();
					if (val != '') { data += el[0] + ':' + val + ':|'; }
				}
			}
		}
		return data;
	}
}
function fixForm() {
	realSpace = hhh - 20;
	$(".ui-dialog-content").each(function (index, element) {
		if ($(this).dialog("isOpen")) {
			topWin = $(this).closest('div[aria-describedby]')
			attr = topWin.attr('aria-describedby');
			diaBody = $(this).height();
			$(this).height(500);
			for_win = $(this).find('.win_body,.win_body_full,.win_free');
			for_header = $(this).find('.form_header');
			for_body = $(this).find('.form_body');
			for_body_type = for_body.attr('type');
			for_foter = $(this).find('.form_fot');
			for_body.height('auto');
			$(this).dialog('option', 'height', realSpace);
			$(this).height('auto');
			winHSpace = 32;
			if (for_body_type == "pd0" || for_body_type == "full_pd0") {
				for_body.css('padding', '0px');
				//for_body.css('overflow','hidden');
				winHSpace = 12;
				//for_body_type = "full";
			}
			if (for_body_type == "full" || for_body_type == "full_pd0") {
				form_h = for_header.height();
				form_f = for_foter.height();
				if (form_f == undefined) { form_f = 0; }
				if (form_h == undefined) { form_h = 0; }
				form_data_h = for_body.height();
				$(this).dialog('option', 'height', realSpace);
				for_body.height(diaBody - form_f - form_h - winHSpace);
				win_width = parseInt($(this).dialog('option', 'width'));
				if (win_width > www - 20) { $(this).dialog('option', 'width', www - 20); }
			} else {
				if (attr.substring(0, 8) == 'full_win') {
					$(this).dialog('option', 'width', www);
					$(this).dialog('option', 'height', hhh);
					topWin.find('.ui-dialog-title').css('text-align', k_align);

					$(this).children('.win_body').height(hhh - winSpaceHeight);
					$(this).find('.win_free').height(hhh - winSpaceHeight - 10);
					for_body.css('min-height', 100);
					form_h = for_header.height();
					form_f = for_foter.height();
					if (form_f == undefined) { form_f = 0; }
					if (form_h == undefined) { form_h = 0; }
					form_data_h = for_body.height();
					for_body.height(diaBody - form_f - form_h - winHSpace);
				} else {
					if (typeof for_body[0] != typeof undefined) {
						h1 = for_body[0].scrollHeight;
						h2 = for_body.height() + 19;

						form_h = for_header.height();
						form_f = for_foter.height();
						if (form_f == undefined) { form_f = 0; }
						if (form_h == undefined) { form_h = 0; }
						h2 = diaBody - form_f - form_h - winHSpace;
						//if(h1>h2){
						for_body.height(h1);
						//}
						//alert(h2)
					}
					win_width = parseInt($(this).dialog('option', 'width'));
					if (win_width > www - 20) { $(this).dialog('option', 'width', www - 20); }
					h_win = $(this).height();
					if (h_win > realSpace - 40) { $(this).dialog('option', 'height', realSpace); h_win = $(this).height(); }

					diaBody = $(this).height();
					$(this).children('.win_body').height(h_win - winSpaceHeight);
					$(this).find('.win_free').height(hhh - winSpaceHeight - 10);
					form_h = for_header.height();
					form_f = for_foter.height();
					if (form_f == undefined) { form_f = 0; }
					if (form_h == undefined) { form_h = 0; }
					form_data_h = for_body.height();
					for_body.height(diaBody - form_f - form_h - winHSpace);
					if (for_body_type == "static") {
						for_body.css('overflow', 'hidden');
					} else {
						for_body.css('overflow-x', 'hidden');
					}
				}
			}
			if (for_body_type == "static") {
				for_body.css('overflow', 'hidden');
			} else {
				//for_body.css('overflow-x','hidden');
			}
			$(this).dialog("option", "position", { my: "center", at: "center", of: window });
			/*********Res****************/
			fixObjects(for_win);
		}
	});
	$('[actButt]').each(function () {
		actBName = $(this).attr('actButt');
		bsSet = $(this).attr('set');
		if (bsSet != 1) {
			subObj = $(this).attr('son');
			$(this).attr('set', '1');
			if (subObj) {
				sel = $(this).find(subObj);
			} else {
				sel = $(this).children('div');
			}
			sel.click(function () {
				actBName = $(this).closest('[actButt]').attr('actButt');
				subObj = $(this).closest('[actButt=' + actBName + ']').attr('son');
				if (subObj) {
					$(this).closest('[actButt=' + actBName + ']').find(subObj).removeAttr(actBName);
				} else {
					$(this).closest('[actButt=' + actBName + ']').children('div').removeAttr(actBName);
				}
				$(this).attr(actBName, '1');
			})
		}
	})
	$('[actButtE]').each(function () {
		actBName = $(this).attr('actButtE');
		bsSet = $(this).attr('set');
		if (bsSet != 1) {
			subObj = $(this).attr('son');
			$(this).attr('set', '1');
			if (subObj) {
				sel = $(this).find(subObj);
			} else {
				sel = $(this).children('div');
			}
			sel.click(function () {
				actBName = $(this).closest('[actButtE]').attr('actButtE');
				subObj = $(this).closest('[actButtE=' + actBName + ']').attr('son');
				attr = $(this).attr(actBName);
				if (typeof attr !== typeof undefined && attr !== false) {
					$(this).removeAttr(actBName);
				} else {
					if (subObj) {
						$(this).closest('[actButtE=' + actBName + ']').find(subObj).removeAttr(actBName);
					} else {
						$(this).closest('[actButtE=' + actBName + ']').children('div').removeAttr(actBName);
					}
					$(this).attr(actBName, '1');
				}
			})
		}
	})
	$('[actButtM]').each(function () {
		actBName = $(this).attr('actButtM');
		bsSet = $(this).attr('set');
		if (bsSet != 1) {
			subObj = $(this).attr('son');
			$(this).attr('set', '1');
			if (subObj) {
				sel = $(this).find(subObj);
			} else {
				sel = $(this).children('div');
			}
			sel.click(function () {
				actBName = $(this).closest('[actButtM]').attr('actButtM');
				subObj = $(this).closest('[actButtM=' + actBName + ']').attr('son');
				attr = $(this).attr(actBName);
				all = $(this).attr('all');
				if (isEx(attr)) {
					if (isEx(all)) {
						if (subObj) {
							$(this).closest('[actButtM]').find(subObj).removeAttr(actBName);
						} else {
							$(this).closest('[actButtM]').children('div').removeAttr(actBName);
						}
					} else {
						$(this).removeAttr(actBName);
					}
				} else {
					if (isEx(all)) {
						if (subObj) {
							$(this).closest('[actButtM]').find(subObj).attr(actBName, '');
						} else {
							$(this).closest('[actButtM]').children('div').attr(actBName, '');
						}
					} else {
						$(this).attr(actBName, '');
					}
				}
			})
			//$(this).removeAttr('actButtM');
		}
	})
	$('[par=chAll]').each(function () {
		$(this).click(function () {
			ch = $(this).children('div').attr('ch');
			cv = 1;
			if (ch == 'off') { cv = 0; }
			a = $(this).closest('table').find('.form_checkBox').each(function () {
				c = $(this).attr('ch_name');
				if (c != '') {
					CBC(c, cv);
				}
			})
		})
	})
	$(function () { $(':input[type=number]').on('mousewheel', function (e) { $(this).blur(); }); });
}
function fixSpaces(t, obj, full = 0) {
	out = 0;
	if (t == 'h') {
		out += parseInt(obj.css("border-top-width"));
		out += parseInt(obj.css("border-bottom-width"));
		out += parseInt(obj.css("padding-top"));
		out += parseInt(obj.css("padding-bottom"));
		out += parseInt(obj.css("margin-top"));
		out += parseInt(obj.css("margin-bottom"));
		if (full == 1) { out += parseInt(obj.height()); }
	}
	if (t == 'w') {
		out += parseInt(obj.css("border-left-width"));
		out += parseInt(obj.css("border-right-width"));
		out += parseInt(obj.css("padding-left"));
		out += parseInt(obj.css("padding-right"));
		out += parseInt(obj.css("margin-left"));
		out += parseInt(obj.css("margin-right"));
		if (full == 1) { out += parseInt(obj.width()); }
	}
	return out;
}
function fixObjects(obj) {
	obj.find('[fix]').each(function () {
		fix_p = $(this).attr('fix');
		if (typeof fix_p != typeof undefined) {
			fix_pd = fix_p.split('|');
			fixPars = fix_pd.length;
			for (f = 0; f < fixPars; f++) {
				fix_pd2 = fix_pd[f].split(':');
				fix_v = parseInt(fix_pd2[1]);
				c = fix_pd2[0].substr(0, 1);
				if (c == 'h') {
					pearntHeight = $(this).parent().height();
					fixH = 0;
					if (fix_pd2[2]) {
						fixRec = fix_pd2[2].split(',');
						for (x = 0; x < fixRec.length; x++) {
							fixRecIN = fixRec[x].split('-');
							if (pearntHeight < parseInt(fixRecIN[0])) {
								fix_pd2[0] = fixRecIN[1];
								fix_v = parseInt(fixRecIN[2]);
							}
						}
					}
					xSpac = fixSpaces('h', $(this));
					if (fix_pd2[0] == 'hp') { fixH = pearntHeight - fix_v; }
					if (fix_pd2[0] == 'hp%') { fixH = fix_v * (pearntHeight) / 100; }
					if (fix_pd2[0] == 'hw') { fixH = hhh - fix_v; }
					if (fix_pd2[0] == 'hw%') { fixH = hhh / fix_v * 100; }
					if (fix_pd2[0] == 'h') { fixH = fix_v; }
					if (fix_pd2[0] == 'hp*') {
						objC = $(this);
						xObjs = 0;
						$(this).attr('mwf', '1');
						$(this).parent().children('div').each(function () {
							if (!$(this).attr('mwf')) { xObjs += fixSpaces('h', $(this), 1); }
						})
						fixH = $(this).parent().height() - (xObjs + fix_v);
					}
					fixH = fixH - xSpac;
					fixH = parseInt(fixH);
					if (fixH > 0) { $(this).height(fixH); }
				}
				if (c == 'w') {
					pearntWidth = $(this).parent().width();
					fixW = 0;
					if (fix_pd2[2]) {
						fixRec = fix_pd2[2].split(',');
						for (x = 0; x < fixRec.length; x++) {
							fixRecIN = fixRec[x].split('-');
							if (pearntWidth < parseInt(fixRecIN[0])) {
								fix_pd2[0] = fixRecIN[1];
								fix_v = parseInt(fixRecIN[2]);
							}
						}
					}
					xSpac = fixSpaces('w', $(this));
					if (fix_pd2[0] == 'wp') { fixW = pearntWidth - fix_v; }
					if (fix_pd2[0] == 'wp%') { fixW = fix_v * (pearntWidth) / 100; }
					if (fix_pd2[0] == 'ww') { fixW = www - fix_v; }
					if (fix_pd2[0] == 'ww%') { fixW = www / fix_v * 100; }
					if (fix_pd2[0] == 'w') { fixW = fix_v; }
					if (fix_pd2[0] == 'wp*') {
						objC = $(this);
						xObjs = 0;
						$(this).attr('mwf', '1')
						$(this).parent().children('div').each(function () {
							if (!$(this).attr('mwf')) { xObjs += fixSpaces('w', $(this), 1); }
						})
						fixW = $(this).parent().height() - (xObjs + fix_v);
					}
					fixW = fixW - xSpac;
					fixW = parseInt(fixW);
					if (fixW > 0) { $(this).width(fixW); }
				}
				if (c == 'b') {
					wSpac = 0;//fixSpaces('w',$(this),0);
					hSpac = 0;//fixSpaces('h',$(this),0);
					fW = $(this).parent().width();
					fH = $(this).parent().height();
					squ = fW;
					if (fW > fH) { squ = fH; }
					//CL(squ+'-'+wSpac+'-'+hSpac);
					$(this).width(squ - (fix_v + wSpac));
					$(this).height(squ - (fix_v + hSpac));
				}
			}
		}
	})
}
function loadFormElements(form) {
	$(form + " input[type=checkbox]").each(function (index, element) {
		rand = Math.floor((Math.random() * 1000000) + 1);
		ch_val = $(this).val();
		ch_name = $(this).attr('name');
		par = $(this).attr('par');
		if (typeof par !== typeof undefined && par !== false) { par = 'par="' + par + '"'; } else { par = ''; }
		ch_ch = 'off';
		if ($(this).is(':checked')) { ch_ch = 'on'; }
		ch_input = '<div id="c_' + rand + '" ' + par + ' class="form_checkBox cur fl" ch_name="' + ch_name + '" ch_val="' + ch_val + '">\
		<div ch="'+ ch_ch + '">';
		if (ch_ch == 'on') {
			ch_input += '<input type="hidden" name="' + ch_name + '" value="' + ch_val + '" />';
		}
		ch_input += '</div></div>';
		$(this).replaceWith(ch_input);

		$('#c_' + rand).click(function () {
			checkBoxClick($(this), '');
		})
	})

	$(form + " .radioBlc").each(function (index, element) {
		rand = Math.floor((Math.random() * 100000) + 1);
		d_val = '';
		ri_name = $(this).attr('name');
		req = $(this).attr('req');
		oc = '';
		var ri_oc = $(this).attr('oc');
		if (typeof ri_oc !== typeof undefined && ri_oc !== false) {
			if (ri_oc != '') { oc = 'onclick="' + ri_oc + '"'; }
			$(this).attr('oc', '');
		}
		ri = 0;
		labels = new Array();
		$(this).find("label").each(function (index, element) {
			labels.push($(this).html());
			$(this).remove();
		})
		$(this).find("input[type=radio]").each(function (index, element) {
			label_text = $(this).children("label:gt(0)").html();
			ri_val = $(this).val();
			oc2 = oc.replace('[v]', ri_val);
			ri_name = $(this).attr('name');
			ch_ch = 'off';
			par = $(this).attr('par');
			st = $(this).attr('st');

			if (typeof st !== typeof undefined && st !== false) { st = 'st="dcv' + st + '"'; } else { st = ''; }
			if (typeof par !== typeof undefined && par !== false) { par = 'par="' + par + '"'; } else { par = ''; }

			if ($(this).is(':checked')) { ch_ch = 'on'; d_val = ri_val; }

			ri_input = '<div class="radioBlc_each fl" ri_name="' + ri_name + '" ri_val="' + ri_val + '" set="0" ch="' + ch_ch + '" ' + par + ' ' + st + ' ' + oc2 + ' >';
			ri_input += '<div class="form_radio fl" >';
			ri_input += '<div><div></div></div></div><div class="ri_labl fl">' + labels[ri] + '</div>';
			ri_input += '</div>';
			$(this).replaceWith(ri_input);
			ri++;
		})
		ri_val = '';
		if ($('#ri_' + ri_name).length == 0) {
			reqt = '';
			if (req == 1) { reqt = ' required '; }
			ri_val = '<input type="hidden" name="' + ri_name + '" id="ri_' + ri_name + '" value="' + d_val + '" ' + reqt + ' />';
		}
		$(this).append(ri_val);
	})
	$(form + ' .radioBlc_each[set=0]').each(function (index, element) {
		$(this).attr('set', '1');
		$(this).click(function () {
			ri_name_this = $(this).attr('ri_name');
			ri_val_this = $(this).attr('ri_val');
			$('#ri_' + ri_name_this).val(ri_val_this);
			req = $(this).closest('.radioBlc').attr('req');
			evn = $(this).closest('.radioBlc').attr('evn');
			reqss = 0;
			/*if(req==0){
				$('.radioBlc_each[ri_name="'+ri_name_this+'"]').each(function(index, element) {
					if($(this).attr('ri_val')==ri_val_this){
						if($(this).attr('ch')=='on'){
							$(this).attr('ch','off');
							//reqss=1;
							ri_val_this='';						
						}					
					}
				});
			}*/
			if (reqss == 0) {
				$('.radioBlc_each[ri_name="' + ri_name_this + '"]').each(function (index, element) {
					$(this).attr('ch', 'off');
				});
				$('.radioBlc_each[ri_name="' + ri_name_this + '"][ri_val="' + ri_val_this + '"]').attr('ch', 'on');
			}
			$('#ri_' + ri_name_this).val(ri_val_this);
			if (evn != '') { CLE_m(evn, ri_name_this.replace('cof_', ''), ri_val_this); }
		})
	});
	//$(form+" input[type=text] , "+form+" textarea  , "+form+" select" ).css({'font-family':'Tahoma, Geneva, sans-serif','font-size':14});	
	$(form + ' .MultiBlc div[set]').click(function () {
		if ($(this).attr('ch') == 'on') { $(this).attr('ch', 'off'); } else { $(this).attr('ch', 'on'); }
		n = $(this).attr('n');
		getMultiValue(n)
		evn = $(this).closest('.MultiBlc').attr('evn');
		filed = $(this).closest('.MultiBlc').attr('chM');
		c_val=$('#mlt_'+filed).val();
		if (evn != '') { CLE_m(evn, filed.replace('cof_', ''), c_val); }
	})
	$(form + ' .MultiBlc div[set]').removeAttr('set');
	$(form + ' [chME]').click(function () {
		co_selLongValMulti($(this).attr('chME'), 0);
	})
	$(form).find('select').each(function (index, element) {
		p_link = $(this).parent().attr('p_link');
		even = $(this).parent().attr('evn');
		if (typeof even == typeof undefined || p_link == false) {
			$(this).parent().attr('evn', '1');
			if (typeof p_link !== typeof undefined && p_link !== false && p_link != '') {
				$(this).change(function () {
					p_link = $(this).parent().attr('p_link');
					l_sub = $(this).closest('form').children('input[name=sub]').val();
					this_val = $(this).val();
					loadSun(p_link, this_val, l_sub, form);
				})
			}
		}
	});
	$(form).find('.bigselText').each(function (index, element) {
		p_link = $(this).attr('p_link');
		even = $(this).parent().attr('evn');
		if (typeof even == typeof undefined || p_link == false) {
			$(this).attr('evn', '1');
			if (typeof p_link !== typeof undefined && p_link !== false && p_link != '') {
				$(this).change(function () {
					p_link = $(this).parent().attr('p_link');
					l_sub = $(this).closest('form').children('input[name=sub]').val();
					this_val = $(this).val();
					loadSun(p_link, this_val, l_sub, form);
				})
			}
		}
	});
	SelectOpr();
	//fixForm();
}
function loadSun(l, val, l_sub, form) {
	$('div[s_link=' + l + ']').html(loader_win);
	deVal = $('div[s_link=' + l + ']').attr('deval');
	$.post(f_path + "S/sys_loadLink.php", { l: l, v: val, s: l_sub, d: deVal }, function (data) {
		d = GAD(data);
		$('div[s_link=' + l + ']').html(d);
		loadFormElements(form)
		fixForm();
	})
}
function getMultiValue(n) {
	values = '';
	$('.cMul[n=' + n + '][ch=on]').each(function (index, element) {
		values += $(this).attr('v') + ',';
	});
	values = values.substring(0, values.length - 1)
	$('input[n=' + n + ']').val(values)
}
function checkBoxClick(this_ch, v) {
	this_ch_val = this_ch.attr('ch_val');
	this_ch_name = this_ch.attr('ch_name');
	if (v == '') { this_v = this_ch.children().attr('ch'); } else { if (v == 'on') this_v = 'off'; else this_v = 'on'; }
	if (this_v == 'on') {
		this_ch.children().attr('ch', 'off');
		this_ch.children().html('');
	} else {
		this_ch.children().attr('ch', 'on');
		this_ch.children().html('<input name="' + this_ch_name + '" type="hidden" value="' + this_ch_val + '" />');
	}
}
function Open_co_filter(type) {
	if (($('.co_filter').is(':visible') || type == 'hide') && type != 'show') {
		$('.co_filter').hide();
		$('.ti_search_o').addClass('ti_search');
		$('.ti_search_o').removeClass('ti_search_o');
	} else {
		$('.co_filter').show();
		$('.ti_search').addClass('ti_search_o');
		$('.ti_search').removeClass('ti_search');
	}
	fixPage();
	loadGrad();
}
function setPaging() {
	$('.pagging div[pn]').click(function () {
		n = $(this).attr('pn');
		changeListPage(n);
	})
	$('.pagging #sPnE').click(function () {
		n = parseInt($('#sPnI').val()) - 1;
		changeListPage(n);
	})
}
function ser_reset(m) {
	page = $('.filterForm').attr('p');
	$('.filterForm input').val('');
	$('.filterForm input[type=number]').val('');
	$('.filterForm input[type=text]').val('');
	$('.filterForm input[type=hidden]').val('');
	$('.filterForm select option').removeAttr('selected');
	$('.filterForm select option:first-child').attr("selected", "selected");
	$('.filterForm .filBut').css('background-color', '');
	$('.filterForm .filBut').css('color', '');
	if (page == '') {
		if (m == 0) { loadModule(); }
	} else {
		if (m == 0) { loadFitterCostom(page); }
	}
}

function changeListPage(n) {
	page = $('.filterForm').attr('p');
	$('#mwFooter,.centerSideIn').html('');
	pageNo = n;
	if (page == '') { loadModule(); } else { loadFitterCostom(page); }
}
function setFilter(id) {
	if (id == 0) {
		$('.filterForm input[type=text]').keyup(function () { loadFilter(); });
		$('.filterForm input[type=number]').keyup(function () { loadFilter(); });
		$('.filterForm input[type=text][class=fil_Date]').change(function () { loadFilter(); });
		$('.filterForm select').change(function () {
			filPar = $(this).parent().attr('filPar');
			if (typeof filPar != typeof undefined && filPar != false) {
				filValSe = $(this).val();
				checkFilterSuns(filPar, filValSe);
			} else {
				loadFilter();
			}
		});
		date_picker_fil();
	} else {
		$('#filSun_' + id + ' select').change(function () {
			filPar = $(this).parent().attr('filPar');
			if (typeof filPar != typeof undefined && filPar != false) {
				filValSe = $(this).val();
				checkFilterSuns(filPar, filValSe);
			} else {
				loadFilter();
			}
		});
		haveSun = 0;
		filPar = $('#filSun_' + id).attr('filPar');
		if (typeof filPar != typeof undefined && filPar != false) {
			filValSe = $('#filSun_' + id).val();
			checkFilterSuns(filPar, filValSe);
			haveSun = 1;
		}
		return haveSun;
	}
}
function checkFilterSuns(sun, val) {
	$('#filSun_' + sun).html(loader_win);
	$.post(f_path + "S/sys_list_filter.php", { id: sun, val: val }, function (data) {
		d = GAD(data);
		$('#filSun_' + sun).html(d);
		if (setFilter(sun) == 0) {
			loadFilter();
		}
	})
}
function loadFilter() {
	page = $('.filterForm').attr('p');
	clearTimeout(filtimer);
	filtimer = setTimeout(function () {
		if (page == '') {
			loadModule();
		} else {
			loadFitterCostom(page);
		}
	}, 800);
}
function loadFitterCostom(page) {
	centerLoader(0);
	filter = getFormFilter();
	$.post(f_path + "X/" + page + ".php", { p: pageNo, fil: filter }, function (data) {
		if (data == 'out') { out(); }
		d = data.split('<!--***-->');
		dl = d.length;
		t = d[1] != 0;
		if (d[1] != '') { d[1] = '(' + d[1] + ')'; }
		$('#m_total').html(d[1]);
		centerLoader(1);
		if (dl == 5) {
			$('.centerSideInHeader').html(d[2]);
			$('.centerSideIn').html(d[3]);
			$('#mwFooter').html(d[4]);
		} else {
			$('.centerSideIn').html(d[2]);
			$('#mwFooter').html(d[3]);
		}
		setPaging();
		fixPage();
	})
}
function date_picker_fil() {
	$('.filterForm .fil_Date').datetimepicker({
		lang: lg,
		format: 'Y-m-d',
		formatDate: 'Y-m-d',
		defaultTime: '1:00',
		timepicker: false,
		scrollMonth: false,
		scrollInput: false,
		closeOnDateSelect: true,
	})
}
function setSort() {
	$('th[so_no]').each(function (index, element) {
		$(this).click(function () {
			sort_id = $(this).attr('so_no');
			if (sort_id == mod_sort) { if (mod_sort_dir == 1) { mod_sort_dir = 2; } else { mod_sort_dir = 1; } } else { mod_sort_dir = 1; }
			mod_sort = sort_id;
			loadModule();
		})
	});
}
function loadFormForEdit(mod, id, dir) {
	mod_data[0] = [mod, 0, 2]
	co_loadForm(id, 2, 0)
}
function loadSuns(n) {
	if (n != '') {
		nn = n.split(',');
		for (i = 1; i < nn.length; i++) {
			p_id = nn[i];
			selI = $('select[p_link=' + p_id + ']');
			selId = selI.attr('id');
			if (typeof selId != typeof undefined && selId != false) {
				this_val = selI.val();
				form = '#' + selI.closest('form').attr('name');
				l_sub = selI.closest('form').children('input[name=sub]').val();
				p_link = p_id;
				if (this_val == '') { this_val = 0; }
				loadSun(p_link, this_val, l_sub, form);
			} else {
				selI = $('#coft_' + p_id);
				this_val = $('input[p_link=' + p_id + ']').val();
				form = $('input[p_link=' + p_id + ']').closest('form').attr('name');
				p_link = p_id;
				//if(typeof p_link !== typeof undefined && p_link !== false && p_link!=''){					
				l_sub = $('input[p_link=' + p_id + ']').closest('form').children('input[name=sub]').val();
				if (this_val == '') { this_val = 0; }
				loadSun(p_link, this_val, l_sub, '#' + form);
				//}
			}
		}
	}
}
function co_selbigValSer(f) {
	clearTimeout(timerLo); timerLo = setTimeout(function () { co_selbigVal(f, 1, '') }, 800);
}
function co_selbigVal(f, opr, pars) {
	s = '';
	if (opr == 1) {
		s = $('#list_ser_option').val();
		$('#list_option').html(loader_win);
	} else {
		loadWindow('#m_info4', 1, k_sl_val_lst, www, 0);
	}
	$.post(f_path + "S/sys_list_option.php", { f: f, s: s, o: opr, pars: pars }, function (data) {
		d = GAD(data);
		if (opr == 1) {
			$('#list_option').html(d);
			fxObjects($('.win_body'));
		} else {
			$('#m_info4').html(d);
			co_selbigVal(f, 1, pars);
			$('#list_ser_option').focus();
		}
		fixForm();
	})
}
function m_lisopt_do(f, id, txt, p_link, evn) {
	$('#cof_' + f).val(id);
	$('#coft_' + f).html(txt);
	$('#m_info4').dialog('close');
	/******load sun after add record********************/
	sel_itm = $('#cof_' + f);
	ppp_link = sel_itm.attr('p_link');
	ppp_form = sel_itm.closest('form').attr('name');
	l_sub = sel_itm.closest('form').children('input[name=sub]').val();
	if (typeof ppp_link !== typeof undefined && ppp_link !== false && ppp_link != '') {
		loadSun(ppp_link, id, l_sub, '#' + ppp_form);
	}
	if (evn != '') {
		CLE_m(evn, f, id);
	}
}
function new_lisopto(f, mod, col, pars, evn, col_id) {
	val = $('#list_ser_option').val(); co_loadForm('liop', 3, mod + '|' + col_id + ',' + col + '|code^m_lisopt_do(\'' + f + '\',\'[' + col_id + ']\',\'[' + col + ']\',0,\'' + evn + '\')|' + col + ':' + val + ',' + pars);
}
function ExportModuleData() {
	filter = getFormFilter();
	loadWindow('#m_info2', 1, k_xp_dat, 600, 0);
	$.post(f_path + "S/sys_export.php", { mod: mod, fil: filter, ms: mod_sort, msd: mod_sort_dir, sptl: sendingParsToForm }, function (data) {
		d = GAD(data);
		$('#m_info2').html(d);
		fixPage();
		loadFormElements('#co_export');
		fixForm();
	})
}
function perwin(type, id) {
	loadWindow('#m_info4', 1, k_perms, 750, 0);
	$.post(f_path + "S/sys_per.php", { type: type, id: id }, function (data) {
		d = GAD(data);
		$('#m_info4').html(d);
		setupForm('per_el', 'm_info4');
		fixPage();
		loadFormElements('#per_el');
		fixForm();
		setGroCheckClick();
	})
}
function setGroCheckClick() {
	$('div[par=per_all]').click(function () {
		ch = $(this).children().attr('ch');
		no = $(this).attr('ch_val');
		form = $(this).closest('form').attr('id');
		$('#' + form).find("div[par*=per_mm]").each(function (index, element) { checkBoxClick($(this), ch); })
		$('#' + form).find("div[par*=per_sel_]").each(function (index, element) {
			id = $(this).attr('id');
			checkBoxClick($(this), ch);
			no2 = $(this).attr('ch_val');
			if (ch == 'on') { $(this).closest('tr').css('background-color', '#eee'); } else { $(this).closest('tr').css('background-color', ''); }
			$('#' + form).find("div[par=per_in_" + no2 + "]").each(function (index, element) {
				checkBoxClick($(this), ch);
				if (ch == 'on') { $(this).show(500); } else { $(this).hide(500); }
			});
		});
	})
	$('div[par=per_mm]').click(function () {
		ch = $(this).children().attr('ch');
		no = $(this).attr('ch_val');
		form = $(this).closest('form').attr('id');
		$('#' + form).find("div[par=per_sel_" + no + "]").each(function (index, element) {
			id = $(this).attr('id');
			checkBoxClick($(this), ch);
			no2 = $(this).attr('ch_val');
			if (ch == 'on') { $(this).closest('tr').css('background-color', '#eee'); } else { $(this).closest('tr').css('background-color', ''); }
			$('#' + form).find("div[par=per_in_" + no2 + "]").each(function (index, element) {
				checkBoxClick($(this), ch);
				if (ch == 'on') { $(this).show(500); } else { $(this).hide(500); }
			});
		});
	})
	$('div[par*=per_sel_]').click(function () {
		ch = $(this).children().attr('ch');
		no = $(this).attr('ch_val');
		if (ch == 'on') { $(this).closest('tr').css('background-color', '#eee'); } else { $(this).closest('tr').css('background-color', ''); }
		form = $(this).closest('form').attr('id');

		$('#' + form).find("div[par=per_in_" + no + "]").each(function (index, element) {
			id = $(this).attr('id');
			checkBoxClick($(this), ch);
			if (ch == 'on') { $(this).show(500); } else { $(this).hide(500); }
		});
	})
	hhi = hIds.split(',');
	for (i = 0; i < hhi.length; i++) {
		$("div[par=per_in_" + hhi[i] + "]").hide(500);
	}
}
function cusPer(code, type) {
	loadWindow('#m_info4', 1, k_perms, 750, 0);
	$.post(f_path + "S/sys_per.php", { code: code, type: type }, function (data) {
		d = GAD(data);
		$('#m_info4').html(d);
		setupForm('per_el', 'm_info4');
		fixPage();
		loadFormElements('#per_el');
		fixForm();
		setGroCheckClick();
	})
}
function holdTableHeader() {
	$('table.holdH').each(function (index, element) {
		hhhth = $(this).find('tr:nth-child(2) th').height();
		hhhtc = parseInt($(this).attr('cellpadding'));
		newHi = hhhth + (hhhtc * 2) + 2;
		$(this).find('tr:nth-child(2) th').css("top", newHi);
	})
}
function setBarcode(form) {
	out_r = 0;
	if ($(form).find('.barReader').length == 1) {
		out_r = 1;
		var stopOutClick = 0;
		$('.bc_text').keyup(function () { lightBC(); })
		$('.barReader[mode]').click(function () { focusBC(); })
		$('.barReader[mode]').mouseover(function () { stopOutClick = 1; })
		$('.barReader[mode]').mouseout(function () { stopOutClick = 0; })
		BarEditedId = $('.barReader[mode]').attr('no');
		$(document).mouseup(function (e) {
			var container = $(".barReader");
			if (!container.is(e.trget) && container.has(e.target).length === 0) {
				if (stopOutClick == 0) {
					$('.barReader').attr('mode', 'a');
					$('.bc_text').val('');
				}
			}
		});
		focusBC();
	}
	return out_r;
}
function focusBC() {
	$('.barReader').attr('mode', 'b');
	$('.bc_text').val('');
	$('.bc_text').focus();
}
function lightBC() {
	clearTimeout(timerbc);
	timerbc = setTimeout(function () { bc_loadData(); }, 500);
	$(".barReader").css('background-color', "#eee");
	$(".barReader").animate({ backgroundColor: "#0c0" }, 200, function () { $(".barReader").css('background-color', ""); });
}
function bc_loadData() {
	data = $('.bc_text').val();
	$('.bc_text').val('');
	d_get = data.split('#');
	d_set = barCDataSet.split(',');
	if (d_get.length > 6) {
		for (i = 0; i < d_set.length; i++) {
			if (i < 4) {
				if (d_set[i] != '0') { $('input[name=cof_' + d_set[i] + ']').val(convData(d_get[i])); }
			} else {
				if (i == 6) {
					if (d_set[6] != '0') {
						$('input[name=cof_' + d_set[6] + ']').val(d_get[5]);
						checkIdNo(d_set[6], d_get[5]);
					}
				}
				if (i == 5) {
					if (d_set[5] != '0') {
						date_data = d_get[4].split('-');
						date_legnth = date_data.length;
						year = parseInt(date_data[date_legnth - 1]);
						month = parseInt(date_data[date_legnth - 2]);
						pace1 = date_data[date_legnth - 3];
						date_data = pace1.split('');
						day = '';
						for (s = 0; s < (date_data.length); s++) { if (parseInt(date_data[s])) { day += date_data[s]; } }
						day = parseInt(day);
						this_place = pace1.replace('0' + day, '');
						this_place = this_place.replace(day, '');
						day = parseInt(day);
						if (month < 10) month = '0' + month;
						if (day < 10) day = '0' + day;
						this_date = year + '-' + month + '-' + day;
						$('input[name=cof_' + d_set[4] + ']').val(this_place);
						$('input[name=cof_' + d_set[5] + ']').val(this_date);
					}
				}
			}
		}
	} else {
		$(".barReader div").show(100);
		$('#er_sound').get(0).play();
		setTimeout(function () { $(".barReader div").hide(300); }, 800);
	}
}
function checkIdNo(col, val) {
	$.post(f_path + "S/sys_checkUQBC.php", { c: col, v: val, id: BarEditedId }, function (data) {
		d = GAD(data);
		if (parseInt(d) > 0) { DuplEntry(d); }
	})
}
function convData(inData) {
	return inData;
	newWord = '';
	ccd = new Array();
	ccd['╟'] = 'ا';
	ccd['x'] = 'أ';//xx
	ccd['x'] = 'ب';//xx
	ccd['x'] = 'ت';//xx
	ccd['x'] = 'ث';//xx
	ccd['╠'] = 'ج';
	ccd['═'] = 'ح';
	ccd['x'] = 'خ';//xx
	ccd['╧'] = 'د';
	ccd['x'] = 'ذ';//xx
	ccd['╤'] = 'ر';
	ccd['x'] = 'ز';//xx
	ccd['x'] = 'س';//xx
	ccd['╘'] = 'ش';
	ccd['╒'] = 'ص';
	ccd['x'] = 'ض';//xx
	ccd['x'] = 'ط';//xx
	ccd['x'] = 'ظ';//xx
	ccd['┌'] = 'ع';
	ccd['x'] = 'غ';//xx
	ccd['x'] = 'ف';//xx
	ccd['x'] = 'ق';//xx
	ccd['x'] = 'ك';//xx
	ccd['ط'] = 'ل';
	ccd['ع'] = 'م';
	ccd['x'] = 'ن';//xx
	ccd['ف'] = 'ه';
	ccd['x'] = 'و';//xx
	ccd['و'] = 'ي';
	ccd['x'] = 'ى';//xx
	ccd['x'] = 'ؤ';//xx
	ccd['x'] = 'ئ';//xx
	ccd['x'] = 'ء';//xx
	for (r = 0; r < inData.length; r++) { ch = ccd[inData[r]]; if (typeof ch == 'undefined') { newWord += inData[r]; } else { newWord += ch } }
	return newWord;
}
function Out() {
	lnk = '';
	if (PER_ID && PER_ID != '' && PER_ID != 'p') { lnk = '-' + PER_ID; }
	loc(f_path + 'Login' + lnk);
}
function GAD(data) {
	if (data == 'out') {
		Out();
	} else {
		d = data.split("<!--***-->");
		if (d.length > 1) {
			if (d.length == 2) {
				return d[1];
			} else {
				return data.replace(d[0] + '<!--***-->', '');
			}
		}
	}
}

function sncInfo(type) {
	sncStop = 0;
	actSncType = type;
	$('.centerSideIn').html(loader_win);
	$.post(f_path + "N/man_snc_info.php", { type: type }, function (data) {
		d = GAD(data);
		$('.centerSideIn').html(d);
		fixForm();
		fixPage();
	})
}
function sncStart() {
	snc_f = $('#snc_f').val();
	snc_o = $('#snc_o').val();
	if (snc_f != '' && snc_o != '') {
		f1 = dateToStamp(snc_f);
		f2 = dateToStamp(snc_o);
		if (f2 >= f1) {
			actSncS = actSncN = f1;
			actSncE = f2;
			sncStartDo(1);
		} else { nav(1, k_date_ord_nct); }
	} else {
		nav(1, k_date_fild);
	}
}
function sncStartDo(l) {
	if (l == 1) {
		$('.centerSideIn').html('');
		$('#snc1Bloc').hide();
		$('#snc2Bloc').show();
		$('#snc2BlocIn').html(loader_win);
		$('#ssb').show();
	}
	$.post(f_path + "N/man_snc_do.php", { t: actSncType, s: actSncS, e: actSncE, n: actSncN }, function (data) {
		d = GAD(data);
		dd = d.split('^');
		$('#snc2BlocIn').html(dd[0])
		$('.centerSideIn').prepend(dd[1]);
		fixForm();
		fixPage();
		if (dd[2] != '0' && sncStop == 0) {
			actSncN = dd[2];
			setTimeout(function () { sncStartDo(0); }, 100);
		} else {
			if (sncStop == 1) {
				po = '<div class="f1 fs16 clr5 lh40">' + k_syn_stp + ' <span onclick="resetSnc(' + actSncType + ')" class="f1 fs16 clr1 Over">' + k_back + '</span></div>';
			} else { po = dd[3]; }
			$('#ssb').hide();
			$('.centerSideIn').prepend(po);
		}
	})
}
function stopSncAction() {
	sncStop = 1;
	$('#ssb').hide();
}
function resetSnc(t) {
	$('.centerSideIn').html('');
	$('#snc2Bloc').hide();
	$('#snc1Bloc').show();
	$('#snc2BlocIn').html('');
	sncInfo(t);

}
function dateToStamp(d) {
	myDate = d.split("-");
	var newDate = myDate[0] + "," + myDate[1] + "," + myDate[2];
	dd = new Date(newDate).getTime();
	dd = (dd / 1000)
	dd = dd - (dd % 86400) + 86400;

	return dd;
}
var actParsOptions = '';
function co_selLongValFree(f, pars, opr = 0, title = '') {
	actParsOptions = pars;
	s = '';
	if (opr == 1) {
		s = $('#list_ser_option').val();
		$('#list_option').html(loader_win);
	} else {
		if (title == '') { title = k_sl_val_lst; }
		loadWindow('#m_info4', 1, title, www, hhh);
	}
	$.post(f_path + "S/sys_list_option_free.php", { f: f, s: s, o: opr, pars: pars }, function (data) {
		d = GAD(data);
		if (opr == 1) {
			$('#list_option').html(d);
			fxObjects($('.win_body'));
		} else {
			$('#m_info4').html(d);
			co_selLongValFree(f, pars, 1);
			$('#list_ser_option').focus();
		}
		fixForm();
		fixPage();

	})
}
function co_selbigValSerFree(f) {
	clearTimeout(timerLo); timerLo = setTimeout(function () { co_selLongValFree(f, actParsOptions, 1) }, 800);
}
function addToFreeList(mod, col_id, col, cb, pars) {
	m_lisopt_do
	val = $('#list_ser_option').val();
	if (pars != '') { pars = ',' + pars; }
	co_loadForm(0, 3, mod + '|' + col_id + ',' + col + '|' + cb + '|' + col + ':' + val + pars);
}
/*****************/
var actOLMfilied = '';
function co_selLongValFreeMulti(f, pars, opr, req = 1) {
	actParsOptions = pars;
	actOLMfilied = f;
	s = '';
	if (opr == 1) {
		s = $('#list_ser_option').val();
		$('#list_option').html(loader_win);
	} else {
		loadWindow('#m_info4', 1, k_sl_val_lst, 800, 0);
	}
	$.post(f_path + "S/sys_list_option_free_multi.php", { f: f, s: s, o: opr, pars: pars, req: req }, function (data) {
		d = GAD(data);
		if (opr == 1) {
			$('#list_option').html(d);
			setOLMf();
		} else {
			$('#m_info4').html(d);
			co_selLongValFreeMulti(f, pars, 1);
			$('#list_ser_option').focus();
		}
		fixForm();
	})
}
function setOLMf() {
	$('div[addOLM]').click(function () {
		id = $(this).attr('addOLM');
		txt = $(this).attr('addOLMTxt');
		addRowOLM(id, txt);
	})
	$('tr[olMr]').each(function () {
		id = $(this).attr('olMr');
		$('[addOLM=' + id + ']').hide();
	})
	setLOMorder();
}
function addRowOLM(id, txt) {
	str = '<tr olMr="' + id + '" olMrN="' + txt + '"><td width="30"><div class="mover"></div></td><td class="fs14">' + txt + '</td><td width="30"><div class="ic40x icc2 ic40_del" onclick="delOLM(\'' + id + '\')"></div></td></tr>';
	$('#selMalTab').append(str);
	$('[addOLM=' + id + ']').hide(200);
	$('[addOLM=' + id + ']').attr('sel', '1');
	if ($('.ser_icons').val() != '') {
		$('.ser_icons').val('');
		co_selbigValSerFreeMulti(actOLMfilied);
	}
	setLOMorder();
	omlTotal();
}
function delOLM(id) {
	$('[addOLM=' + id + ']').show(200);
	$('[addOLM=' + id + ']').attr('sel', '0');
	$('tr[olMr=' + id + ']').remove();
	omlTotal();
}
function setLOMorder() {
	$('#selMalTab tr').each(function (index, element) { $(this).width(CSW - 20); });
	$('#selMalTab tbody').sortable({
		axis: "y",
		cursor: "move",
		distance: 3,
		items: " > tr",
		placeholder: "orderPlace",
		revert: true,
		tolerance: "pointer"
	});
}
function omlTotal() { $('#omlT').html('( ' + $('tr[olMr]').length + ' )'); }
function saveLOM(req = 1) {
	olmData = '';
	olmName = '';
	if ($('tr[olMr]').length > 0) {
		$('tr[olMr]').each(function () {
			id = $(this).attr('olMr');
			name = $(this).attr('olMrN');
			if (olmData != '') { olmData += ','; }
			if (olmName != '') { olmName += ','; }
			olmData += id;
			olmName += name;
		})
		OLMcbDo(olmData, olmName);
		win('close', '#m_info4');
	} else {
		if (req == 1) {
			nav(2, k_onitm_sel);
		} else {
			OLMcbDo(olmData, olmName);
			win('close', '#m_info4');
		}
	}
}
function co_selbigValSerFreeMulti(f) {
	clearTimeout(timerLo); timerLo = setTimeout(function () { co_selLongValFreeMulti(f, actParsOptions, 1) }, 800);
}
function addToFreeListMulti(f, mod, col_id, col, parr) {
	val = $('#list_ser_option').val();
	adPars = '';
	if (val != '') { adPars = col + ':' + val; }
	if (parr != '') { if (adPars != '') { adPars += ','; } adPars += parr; }

	co_loadForm(0, 3, mod + '|' + col_id + ',' + col + '|addRowOLM(\'[' + col_id + ']\',\'[' + col + ']\');OLMreset()|' + adPars);
	$('#list_ser_option').val('');
}
function OLMreset() { co_selLongValFreeMulti(actOLMfilied, actParsOptions, 1); }

function CBV(f, val = '') {
	if (val) {
		this_ch = $("[ch_name='" + f + "'][ch_val=" + val + "]").children().attr('ch');
	} else {
		cHv = $("[ch_name='" + f + "']").children().attr('ch');
	}

	if (cHv == 'on') { return 1; } else { return 0; }
}
function CBC(f, v, val = '') {
	if (val) {
		this_ch = $("[ch_name='" + f + "'][ch_val=" + val + "]");
	} else {
		this_ch = $("[ch_name='" + f + "']");
	}
	this_ch_val = this_ch.attr('ch_val');
	this_ch_v = CBV(f);
	if (v != this_ch_v) {
		if (v == 0) {
			this_v = this_ch.children().attr('ch', 'off');
			this_ch.children().html('');
		} else {
			this_v = this_ch.children().attr('ch', 'on');
			this_ch.children().html('<input name="' + f + '" type="hidden" value="' + this_ch_val + '" />');
		}
	}
}
/***********************/
var actSLVM = '';
function co_selLongValMulti(f, opr) {
	actSLVM = f;
	s = '';
	elVals = $('#mlt_' + actSLVM).val();
	if (opr == 1) {
		s = $('#list_ser_option').val();
		$('#list_option').html(loader_win);
	} else {
		loadWindow('#m_info4', 1, k_sl_val_lst, 800, 0);
	}
	$.post(f_path + "S/sys_list_option_multi.php", { f: f, s: s, o: opr, v: elVals }, function (data) {
		d = GAD(data);
		if (opr == 1) {
			$('#list_option').html(d);
			setOLM();
		} else {
			$('#m_info4').html(d);
			co_selLongValMulti(f, 1);
			$('#list_ser_option').focus();
			$('[omleSer]').keyup(function () { co_selbigValSerMulti(); });
		}
		fixForm();
		fxObjects($('.win_body'));
		omlTotal();
	})
}
function co_selbigValSerMulti() {
	clearTimeout(timerLo); timerLo = setTimeout(function () { co_selLongValMulti(actSLVM, 1) }, 800);
}
function setOLM() {
	$('div[addOLM]').click(function () {
		id = $(this).attr('addOLM');
		txt = $(this).attr('addOLMTxt');
		addRowOLM(id, txt);
	})
	$('tr[olMr]').each(function () {
		id = $(this).attr('olMr');
		$('[addOLM=' + id + ']').hide();
	})
	setLOMorder();
}
function saveMLOM() {
	olmData = '';
	olmTxt = '';
	if ($('tr[olMr]').length > 0) {
		olmData = '';
		olmTxt = '';
		$('tr[olMr]').each(function () {
			id = $(this).attr('olMr');
			name = $(this).attr('olMrN');
			if (olmData != '') { olmData += ','; }
			olmData += id;
			olmTxt += '<div class="cMulSel">' + name + '</div>';
		})
	}
	$("[name='" + actSLVM + "']").val(olmData);
	$('#cMEV_' + actSLVM).html(olmTxt);
	win('close', '#m_info4');
}
/*---------selMultiArray-----*/
var smaActCB = '';
function co_selMultiArray(data, sel, cb) {
	smaActCB = cb;
	actSLVM = 'SMAname';
	loadWindow('#m_info4', 1, k_sl_val_lst, 800, 0);
	daArr = data.split(',');
	selArr = sel.split(',');
	listTxt = '';
	for (i = 0; i < daArr.length; i++) {
		v = daArr[i].split(':');
		listTxt += '<div class="listOptbutt" addOLM="' + v[0] + '" addOLMTxt="' + v[1] + '" sel="0">' + v[1] + '</div>';
	}
	d = `<div class="win_body">
        <div class="form_body of h100" type="full_pd0" >
            <div class="h100 fxg" fxg="gtc:1fr 1fr|gtr:1fr">
                <div class="of fl r_bord pd10 h100 " >
                    <div class="b_bord lh60 uLine">
                        <input type="text" smaSer  placeholder="${k_search}" class="ser_icons" style="margin-bottom:10px;" id="list_ser_option"/>
                    </div>
                    <div class="ofx so pd5" fix="hp:70" id="list_option">${listTxt}</div>
                </div>
                <div class="of pd10">
                    <div class="b_bord lh60 pd10 uLine f1 fs18 clr1"> ${k_selc_itms} <ff id="omlT">(0)</ff></div>
                    <div class="ofx so pd5" fix="hp:70" >
                        <table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s" id="selMalTab">	
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form_fot fr">
            <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info4')">${k_cancel}</div>
            <div class="fr ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="saveMLOMArr()">${k_save}</div>
        </div>        
    </div>`;
	$('#m_info4').html(d);
	$('#list_ser_option').focus();
	setOLMf();
	for (i = 0; i < selArr.length; i++) {
		s = selArr[i];
		for (i2 = 0; i2 < daArr.length; i2++) {
			v = daArr[i2].split(':');
			if (v[0] == s) { addRowOLM(v[0], v[1]); }
		}
	}

	$('[smaSer]').keyup(function () { serSMA(); });
	fixForm();
	fxObjects($('.win_body'));
	fixPage();

}
function serSMA() {
	sv = $('[smaSer]').val().toLowerCase();
	$(".listOptbutt[sel='0']").each(function (index, element) {
		txt = $(this).attr('addolmtxt').toLowerCase();
		n = txt.search(sv);
		if (n != (-1)) { $(this).show(300); } else { $(this).hide(300); }
	})
}
function saveMLOMArr() {
	olmData = '';
	olmTxt = '';
	if ($('tr[olMr]').length > 0) {
		olmData = '';
		olmTxt = '';
		$('tr[olMr]').each(function () {
			id = $(this).attr('olMr');
			name = $(this).attr('olMrN');
			if (olmData != '') { olmData += ','; }
			olmData += id;
			if (olmTxt != '') { olmTxt += ','; }
			olmTxt += name;
		})
	}
	ev = smaActCB.replace('[id]', olmData).replace('[txt]', olmTxt);
	win('close', '#m_info4');
	eval(ev);
}
/*---------selMultiArray--PHP Input---*/
var smaActF = '';
function selMAS(f, da, cb) {
	smaActF = f;
	sel = $('#mlt_' + f).val();
	co_selMultiArray(da, sel, cb);
}
function loadMASVals(id, txt) {
	$('#mlt_' + smaActF).val(id);
	outTxt = '';
	if (txt != '') {
		t = txt.split(',');
		for (i = 0; i < t.length; i++) {
			outTxt += '<div class="cMulSel">' + t[i] + '</div>';
		}
	}
	$('#mas_' + smaActF).html(outTxt);
}
/*********************favorite list******************************/
function showFavorite() {
	loadWindow('#m_info5', 1, k_favorite, 500, 200);
	$.post(f_path + "S/sys_fav_view.php", function (data) {
		d = GAD(data);
		$('#m_info5').html(d);
		loadFormElements('#favFo');
		setupForm('favFo', 'm_info5');
		showFavset();
		fixForm();
		fixPage();
	})
}
function showFavset() {
	$('div[par=modL]').click(function () {
		modlVal = $(this).attr('ch_val');
		countFav(modlVal);
	});
}
function countFav(modlVal) {
	maxFav = $('#favFo').attr('max');
	sele = $('div[par=modL] input').length;
	if (sele > maxFav) {
		nav(3, k_cant_chs_more + ' <ff>' + maxFav + '</ff>');
		CBC('mPer[]', 0, modlVal);
	}
}
/******order favorite list****************/
function favMenuOrder() {
	loadWindow('#m_info5', 1, k_ord_lst, 500, 0);
	$.post(f_path + "S/sys_fav_menu_order.php", '', function (data) {
		d = GAD(data);
		$('#m_info5').html(d);
		setFavmenuOrder();
		fixForm();
		fixPage();
	})
}
function setFavmenuOrder() {
	$('.fmOrdMod').sortable({
		axis: "y",
		cursor: "move",
		distance: 3,
		items: "div",
		placeholder: "orderPlace",
		revert: true,
		tolerance: "move"
	});
}
function ordFavMe() {
	ofmData = '';
	$('.fmOrdMod div').each(function (index, element) {
		o_id = $(this).attr('no');
		if (ofmData != '') { ofmData += ','; }
		ofmData += o_id;
	});
	$.post(f_path + "S/sys_fav_menu_order_ord.php", { d: ofmData }, function (data) {
		win('close', '#m_info5');
		loadFav();
	})
}
function fav_opr(o, m) {
	loader_msg(1, k_loading);
	$.post(f_path + "S/sys_fav_opr.php", { o: o, m: m }, function (data) {
		loader_msg(0, '', 1);
		loadFav()
	})
}
function viewTpDemo(obj) {
	id = obj.attr('tpView');
	cn = obj.attr('cn');
	lang = obj.attr('lg');
	per = obj.attr('per');
	loadWindow('#m_info5', 1, k_data, 800, hhh);
	let thisPath = f_path;
	if (lang) { thisPath = thisPath.replace('/' + lg + '/', '/' + lang + '/'); }
	$.post(thisPath + "S/sys_tp_view.php", { id: id, cn: cn, per: per }, function (data) {
		d = GAD(data);
		$('#m_info5').html(d);
		fixForm();
		fixPage();
	})
}
/*********************************************/
function addToListMulti(f, mod, col_id, col, parr) {
	val = $('#list_ser_option').val();
	adPars = '';
	if (val != '') { adPars = col + ':' + val; }
	if (parr != '') { if (adPars != '') { adPars += ','; } adPars += parr; } co_loadForm('liop', 3, mod + '|' + col_id + ',' + col + '|code^addRowOLM(\'[' + col_id + ']\',\'[' + col + ']\');reloadOLM()|');
	$('#list_ser_option').val('');

	//co_loadForm('liop',3,mod+'|'+col_id+','+col+'|code^m_lisopt_do(\''+f+'\',\'['+col_id+']\',\'['+col+']\',0,\''+evn+'\')|'+col+':'+val+','+pars);
}
function reloadOLM() { co_selLongValMulti(actSLVM, 1); }
function showSysAlert() {
	oas = $('.sysA').length;
	if (oas == 0) {
		loadWindow('#m_info5', 1, k_alerts, 600, 200);
		$.post(f_path + "S/sys_alerts.php", {}, function (data) {
			d = GAD(data);
			$('#m_info5').html(d);
			fixForm();
			fixPage();
		})
	}
}
/*********Mod AddFile************/
var ref_page = '';
var busyReq = 0;
function alert_function_m() {
	$('#alert_win').dialog('close');
	switch (alert_no) {
		case 's1': delBup(alert_data); break;
		case 's2': resBup(alert_data); break;
		case 's3': MChild(1, alert_data); break;
		case 's4': MChild(0, alert_data); break;
		case 's5': co_del_sel_do(); break;
		case 's6': do_del_rec(alert_data); break;
		case 's66': do_del_rec_cb(alert_data); break;
		case 's7': delUpImageDo(alert_data); break;
		case 's77': delUpFileDo(alert_data); break;
		case 's8': delModMenuDo(alert_data); break;
		case 's9': langMrgTotDo(alert_data); break;
		case 's10': langMrgOprDo(alert_data); break;
		case 'exp_1': exp_mod_import_do(alert_data); break;
		case 'reset_lib': sub('reset_mod'); break;
		case 'out': logOutmsgDo(); break;
		case 'resBack': prepareRestorBackupDo(alert_data); break;
		//--------------------------------
		default: alert_function(); break;
	}
	fixPage();
}
function refPage_m(s, time) {
	thisTime = time;
	clearTimeout(ref_page);
	busyReq = chReqStatus();
	if (winIsOpen() == 0 && busyReq == 0) {
		switch (s) {
			case 'sys_on': sys_online(); break;
		}

	} else { thisTime = 800; }
	ref_page = setTimeout(function () { refPage_m(s, time) }, thisTime);
}
function CLE_m(s, filed, val) {//Custom List Event	
	switch (s) {
		case 'index_type_review': index_type_review(filed, val); break;
		default: CLE(s, filed, val); break;
	}
}
/**************Sync*********/
var actSync = 0;
var actSyncType = 0;
var actItems = [];
var actItem = 0;
var AllItems = 0;
var sync = 1;
var sync_filter = 0;
var act_sync_start = 0;
var act_sync_end = 0;
var act_sync_today = 0;

function set_sync() {
	$('[sync_list]').change(function () { sync_info($(this).val()); })
	$('.centerSideInFull').on('click', '[syncStart]', function () { sync_start(); })
	$('.centerSideInFull').on('click', '[hide_pearent]', function () { $(this).parent().remove(); })
	$('.centerSideInFull').on('click', '[syncBack]', function () { syncBack(); })
	$('.centerSideInFull').on('click', '[synStop]', function () { synStop(); })
	$('.centerSideInFull').on('click', '[syncCont]', function () { syncCont(); })
}
function sync_info(type) {
	actSyncType = type;
	sync = 1;
	$('#syncData').html('');
	$('#syncData1').html('');
	$('#syncData2').html('');
	$('#notes').html('');
	$('[sync_info]').html(loader_win);
	$.post(f_path + "N/man_sync_info.php", { type: type }, function (data) {
		d = GAD(data);
		$('[sync_info]').html(d);
		fixForm();
		fixPage();
	})
	actItem = 0;
	AllItems = 0;
}
function sync_start() {
	s = $('#snc_s').val();
	e = $('#snc_e').val();
	f = $('#filter').val();
	sync_filter = f;
	$('#syncForm,[sync_list]').hide();
	$('#lastSync').remove();
	$('#syncData').html(loader_win);
	sync_do(s, e, 0, 1, 0, 0, 0);
	AllItems = 0;
}
function sync_do(start, end, today = 0, newDay = 1, item = 0, items = 0, c_item = 0) {
	act_sync_start = start;
	act_sync_end = end
	act_sync_today = today;
	if (sync) {
		$('[sync_item="i' + item + '"]').attr('status', 1);
		$.post(f_path + "N/man_sync_do.php", {
			t: actSyncType,
			s: start,
			e: end,
			d: today,
			n: newDay,
			i: item,
			it: items,
			cit: c_item,
			ait: AllItems,
			f: sync_filter
		}, function (data) {
			d = GAD(data);
			showSYncData(d);
			fixForm();
			fixPage();
			 playAlertSound('#end_item');
		})
	} else {
		synStop();
	}
}
function showSYncData(data){
	//CL(data)
	var obj = jQuery.parseJSON(data);
	status = obj['status'];
	start = obj.status.s;
	end = obj.status.e;
	today = obj.status.t;
	days = obj.status.days;
	done = obj.status.done;
	donePer = obj.status.donePer;
	newDay = obj.status.newDay;
	go_time = obj.status.go_time;
	next_time = obj.status.next_time;

	item = obj.status.item;
	subdata = obj.status.subdata;
	all_item = obj.status.all_item;
	next_item = obj.status.next_item;
	stop = obj.status.stop;
	if (newDay == 1) { actItems = obj.items; CL(obj.items);} 
	
	itemsList = obj.itemsList;

	notes = obj.notes;

	CL(obj)
	//CL(actItems);
	statusTxt = `
        <div class="f1 fs16 b_bord lh40">${k_from}: <ff dir="ltr">${start}</ff></div>
        <div class="f1 fs16 b_bord lh40">${k_to}: <ff dir="ltr">${end}</ff></div>        
        <div class="f1 fs16 b_bord lh40">${k_days}: <ff dir="ltr">${days}/${done}</ff></div>
        <div class="cbgw pd10f br5 mg10v">
            <div class="f1 fs16 TC lh40">${donePer}%</div>
            <div class="snc_prog "><div style="width:${donePer}%"></div></div>
        </div>
        <div class="f1 fs14 b_bord lh40"> ${k_comp_opers}: <ff dir="ltr">${all_item}</ff></div>
        <div class="f1 fs14 b_bord lh40"> ${k_expected_oper}: <ff dir="ltr">${next_item}</ff></div>
        <div class="f1 fs14 b_bord lh40"> ${k_time_passed}: <ff class="clr1" dir="ltr">${go_time}</ff></div>
        <div class="f1 fs14 b_bord lh40"> ${k_remain_time}: <ff class="clr5" dir="ltr">${next_time}</ff></div>
        <div class="ic40 icc2 ic40_stop ic40Txt mg10v" synStop>${k_stp}</div>
    `;
	if (stop && newDay) {
		$('#syncData').html(statusTxt);
		$('[synStop]').remove();
		$('#syncData').append('<div class="ic40 icc2 ic40_ref ic40Txt mg10v" syncBack>' + k_back + '</div>');
		$('[sync_day]').attr('status', 2);
		playAlertSound('#end');
	} else {
		$('#syncData').html(statusTxt);
		itemTxt = '';
		//CL('day:'+newDay);
		if (newDay) {
			playAlertSound('#end_day');
			itemsListTxt = '';
			$.each(obj.itemsList, function (key, data) {
				itemsListTxt += '<div class="f1" sync_item="i' + key + '" status="0">' + data + '</div>';
			})
			$('[sync_day]').attr('status', 2);
			
			if (actItems[0]) {
				$('#syncData1').prepend('<div class="ff B fs14 lh30" sync_day="' + today + '" status="1">' + today + ' (  ' + actItems.length + ' / <span t>0</span > ) <span class="clr5 hide" x>0</span ></div>');
			} else {
				$('#syncData1').prepend('<div class="ff B fs14 lh30" sync_day="' + today + '" status="1">' + today + ' <f1 class="f1 fs10">( ' + k_no_recs + '  )</f1></div>');
			}
			$('#syncData2').html(itemsListTxt);
			actItem = 0;
			sync_do(start, end, today, 0, actItems[actItem]);
		} else {
			actItem++;
			AllItems++;
			$('[sync_day="' + today + '"] span[t]').html(actItem);
			CL(actItems[actItem]);
			
			$('[sync_item="i' + item + '"]').attr('status', 2);
			itemTxt = $('[sync_item="i' + item + '"]').html();
			$('[sync_item="i' + item + '"]').append(subdata);

			if (actItems.length == actItem || actItems.length==0) {
				sync_do(start, end, today, 1, 0);
			} else {				
				sync_do(start, end, today, 0, actItems[actItem], actItems.length, actItem);
			}
		}
		$.each(obj.notes, function (key, data) {
			noteTxt = `<div class="bord pd10f br5 mg10v cbg555" note="${key}">
                <div class="fr i30 i30_x" hide_pearent></div>
                <div class="f1 b_bord lh40">${today} | ${itemTxt}</div>
                <div>${data}</div>
            </div>`;
			x = parseInt($('[sync_day="' + today + '"] span[x]').html());
			$('[sync_day="' + today + '"] span[x]').html(x + 1);
			$('[sync_day="' + today + '"] span[x]').show();
			$('#notes').append(noteTxt);
		})
	}


}
function syncBack() {
	$('#syncForm,[sync_list]').show();
	$('#syncData').html('');
	$('#notes').html('');
	sync = 1;
	sync_info(actSyncType);
}
function synStop(){
	sync = 0;
	$('[synStop]').remove();
	$('#syncData').append('<div class="ic40 icc4 ic40_ref ic40Txt mg10v" syncCont>' + k_cmplt + '</div><div class="ic40 icc2 ic40_ref ic40Txt mg10v" syncBack>' + k_back + '</div>');
}
function syncCont(){
	sync = 1;
	$('[syncCont]').remove();
	$('[syncBack]').remove();
	sync_do(act_sync_start, act_sync_end, act_sync_today, 0, actItems[actItem], actItems.length, actItem)
}
function playAlertSound(item) {
	//$(item).get(0).play();
}

function LOG() { setTimeout(function () { LOG(); LOG_load(); }, logTimer); }
function LOG_load() {
	$.post(f_path + "_", { pn: pageN }, function (data) {
		d = GAD(data);
		if (d) {
			if (typeof d == 'object') {
				obj = jQuery.parseJSON(d);
				//public alerts
				if ('alerts' in obj) { updateNotiSection(parseInt(obj.alerts)); }
			}
		} else {
			updateNotiSection(0)
		}
	});
}
function getObj(d) {
	data = jQuery.parseJSON(d)
	if (typeof data == 'object') {
		return jQuery.parseJSON(d);
	} else {
		return false;
	}
}
function updateNotiSection(alerts) {
	old_alert = $('.thic_alert div[c]').attr('c');
	if (old_alert != alerts) {
		$('.thic_alert div[c]').attr('c', alerts);
		$('.thic_alert div[c]').html(alerts);
		if (alerts) {
			playAlertSound('#noti');
		}
		if ($('#notiList').is(':visible')) {
			$('#notiList').hide();
			showNotiList();
		}
	}
}
function showNotiList() {
	if ($('#notiList').is(':visible')) {
		$('#notiList').hide();
		$('#notiList').html('');
	} else {
		$('#notiList').html('<div class="notiBlc">' + loader_win + '</div>');
		$('#notiList').show();
		$.post(f_path + "S/sys_noti_list.php", {}, function (data) {
			d = GAD(data);
			$('#notiList').html(d);
			$('.thic_alert div[c]').attr('c', '0');
			$('.thic_alert div[c]').html('0');
		})
	}
}

function showItem(sel) {
	if ($(sel).is(':visible')) {
		$(sel).hide();
	} else {
		$(sel).show();
	}
}