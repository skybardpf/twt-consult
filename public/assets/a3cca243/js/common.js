$(document).ready(function () {
	//Красивые Alert'ы
	window._alert = window.alert;
	window.alert = function(message) {
		$.pnotify({
			pnotify_title: 'Системное сообщение',
			pnotify_text: message,
			pnotify_delay: 5000
		});
	};


/* 1й вариант меню
   $('.layer1 table td, .layer3 table td').hover(function() {
        $(this).addClass('active');
    },function() {
        $(this).removeClass('active');
    });

    $('.layer2 table td').hover(function() {
        $(this).addClass('active');
    },function() {
        $(this).removeClass('active');
    });

    $('.layer1 td').click(function(event){
        event.stopPropagation();
        $(".layer2, .layer3").hide();
        var a = $(this).find('div').attr('id');
        $("." + a).show();
    });
    $('.layer2 td').click(function(event){
        event.stopPropagation();
        $(".layer3").hide();
        var a = $(this).find('div').attr('id');
        $("." + a).show();
    });
    $('.layer3 td').click(function(event){
        event.stopPropagation();
        $(".layer4").hide();
        var a = $(this).find('div').attr('id');
        $("." + a).show();
    });

    $("body").click(function(){
        $(".layer2, .layer3").hide();
    });*/

//    2й вариант меню

/*    $(".header.inner .layer1 table td:not(.default)").hover(function(event) {
        $(".header.inner .layer1 table td:not(.default)").removeClass('active');
        $(this).addClass('active');
        *//* event.stopPropagation();
         $(".layer2").hide();*//*
        *//*var a = $(this).find('div').attr('id');
         $("." + a).slideDown();*//*
        $('.layer2').slideUp(200);
        var a = $(this).find('div').attr('id');
        setTimeout(function() {
            $("." + a).slideDown(500);
        }, 10);
    },function() {
//        $(this).removeClass('active');
//        $(".layer2, .layer3").hide();
    });

    $('.header.inner .main_menu.inner').hover(function() {

    }, function() {
        $(".header.inner .layer1 table td:not(.default)").removeClass('active');
        var def = $('.layer2.default').css('display');
        if(def != 'block') {
            $(".layer2").hide();
            $('.layer2.default').slideDown();
        }

    });



    $(".header.inner .layer1 table td:not(.default)").hover(hoverMenu, function() {});

    function hoverMenu(event) {
        $(".header.inner .layer1 table td:not(.default)").removeClass('active');
        $(this).addClass('active');
        var el = this;
        setTimeout(function() {
            $('.layer2').slideUp(200);
            var a = $(el).find('div').attr('id');
            $("." + a).slideDown(500);
        }, 1);
    }

    $('.header.inner .layer2 table td:not(.default), .content_inner .layer3 div.menu_item:not(.default)').hover(function() {
        $(this).addClass('active');
    },function() {
        $(this).removeClass('active');
    });

    $('.header.inner .layer1 td, .header.inner .layer2 td, .layer3 td').click(function(event){
        event.stopPropagation();
        document.location.href=$(this).find('a').attr('href');
    });


    $('.header.main .layer1 td, .header.main .layer2 td, .header.main .layer3 td').click(function(event){
        event.stopPropagation();
        document.location.href=$(this).find('a').attr('href');
    });

    $(".header.main .layer1 table td").hover(function(event) {
        $(this).addClass('active');
//        event.stopPropagation();
//        $(".layer2, .layer3").hide();
        $('.layer2.block').slideUp(200);
        var a = $(this).find('div').attr('id');
        setTimeout(function() {
            $("." + a).addClass('block').slideDown(500);
        }, 10);
    },function() {
        $(this).removeClass('active');
    });

    $('.header.main .main_menu.inner').hover(function() {

    }, function() {
        $(".layer2, .layer3").slideUp();
    });

    $('.header.main .layer2 table td, .header.main .layer3 div.menu_item').hover(function() {
        $(this).addClass('active');
    },function() {
        $(this).removeClass('active');
    });*/

//  меню по клику

    $(".header.inner .layer1 table td:not(.default)").hover(function(event) {
        $(".header.inner .layer1 table td:not(.default)").removeClass('active');
        $(this).addClass('active');
    },function() {
	    $(this).removeClass('active');
    });

    $('.header.inner .layer2 table td:not(.default), .content_inner .layer3 div.menu_item:not(.default)').hover(function() {
        $(this).addClass('active');
    },function() {
        $(this).removeClass('active');
    });

    $('.header.inner .layer1 td, .header.inner .layer2 td, .layer3 td').click(function(event){
        event.stopPropagation();
        document.location.href=$(this).find('a').attr('href');
    });


    $('.header.main .layer1 td, .header.main .layer2 td, .header.main .layer3 td').click(function(event){
        event.stopPropagation();
        document.location.href=$(this).find('a').attr('href');
    });

    $('.header.main .layer1 table td, .header.main .layer2 table td, .header.main .layer3 div.menu_item').hover(function() {
        $(this).addClass('active');
    },function() {
        $(this).removeClass('active');
    });

//  конец меню по клику



/*
    $("body").click(function(){
        $(".layer2").hide();
    });*/

    /*$('#call_back').click(function() {
        $('#callback_form').dialog({
             title: "Закажите обратный звонок",
             width: 400,
             height: 350
        });
    });*/

	$('a.toshow').live('click', function() {
		$(this).hide().parent().find('span.input').show().parent().find('span.text').hide();
		return false;
	});

    $("#final_call_back").live('click', function(){
        var url = root_url + 'call_back';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                contact: $('#callback_contact').val(),
                time_id: $('#callback_time_id').val(),
                phone: $('#callback_phone').val()
            },
            success: function(data){
                $('#div_call_back').html(data.message);
            }
        });
        return false;
    });
    $("#call_back, #call_back1").live('click', function(){
        var url = root_url + 'call_back';
        $.ajax({
            'url': url,
            'type': 'get',
            'dataType': 'json',
            'cache': false,
            'success': function(data) {
                $('#div_call_back').html(data.message);
                $('#div_call_back').dialog({
                    modal: true,
                    position: 'center',
                    width: 400,
                    height: 'auto',
                    resizable: false,
                    dialogClass: 'call_back_dialog small_head'
                });
            },
            'error': function(jqXHR, textStatus, errorThrown) {
                // console.log(textStatus);
            }
        });

        return false;
    });

    $('.ui-widget-overlay, [data-no="1"]').live('click', function() {
        $( "#div_call_back" ).dialog( "close" );
    });

    $('#entity_req_jur_country_id').live('change', function() {
        $.ajax({
            'url': '/countries/getprice',
            'type': 'get',
            'dataType': 'html',
            'data': {id: $(this).val()},
            'cache': false,
            'success': function(data) {
                //alert("xxxxx");
                $('#cur').html(data);
                $('#div').show();
            },
            'error': function(jqXHR, textStatus, errorThrown) {
                // console.log(textStatus);
            }
        });
    });

    $('.kind_activities input[type=checkbox]').change(function(){
        var a = $(this).parents('.kind_activities');
        a.toggleClass('active');
    });

    $('.kind_activities input[type=checkbox]').each(function() {
        var a = $(this);
        if(a.attr('checked')){
            a.parents('.kind_activities').addClass('active');
        }
    });

    $('#own_kind_activities').click(function() {
        var $a = $(this);
/*        $('.kind_activities, .own_kind_activities').toggle(function() {
            if ($('.kind_activities').css('display') == 'none') {
                $a.html('Выбрать род деятельности');
            } else {
                $a.html('Свой род деятельности');
            }
        });*/
        $('.own_kind_activities.invisible').slideToggle();
    });

    $('.sources input[type=checkbox]').change(function(){
        var a = $(this).parents('.sources');
        a.toggleClass('active');
    });

    $('.sources input[type=checkbox]').each(function() {
        var a = $(this);
        if(a.attr('checked')){
            a.parents('.sources').addClass('active');
        }
    });

    $('#own_sources').click(function() {
        var $a = $(this);
/*        $('.sources, .own_sources').toggle(function() {
            if ($('.sources').css('display') == 'none') {
                $a.html('Выбрать источники ДС');
            } else {
                $a.html('Свои источники ДС');
            }
        });*/
        $('.own_sources.invisible').slideToggle();
    });

    $('#search_sample span').click(function() {
        var a = $(this).text();
        $('input[name=q]').val(a);
    });

    $('#search').click(function() {
        $('#search_form').submit();
    });

    $('.main_geografy table td a').hover(function() {
        $(this).css('text-decoration', 'none');
    }, function() {
        $(this).css('text-decoration', 'underline');
    });

    $('.layer3.inner_menu .menu_item').click(function() {
        location.href = $(this).find('a').attr('href');
    });

    var ban = $('#ban');
    /*window.onscroll = function(){
        var scroll_top = document.documentElement.scrollTop || document.body.scrollTop;
        var scroll_bot = document.documentElement.scroll;
        if(scroll >= 200){
            ban.css('top', (scroll + 'px'));
        }else {
            ban.css('top', (0 + 'px'));
        }

    }*/

    $(document).ready(checkBannerPosition);
    $(window).scroll(checkBannerPosition);

    function checkBannerPosition(){
        var scroll_top = document.documentElement.scrollTop || document.body.scrollTop;
        var doc_h = (document.body.scrollHeight > document.body.offsetHeight)?document.body.scrollHeight:document.body.offsetHeight;
        var ban_h = $("#ban").height();
        var head_h = $(".header").height()+30;
        var pos_top = scroll_top+ban_h;
        var max_pos = doc_h-530;

        if ($(".inner_menu").length){
            head_h = head_h+$(".inner_menu").height()+40+$(".breadcrumbs").height();
        }

        if (scroll_top >= head_h){
            $('#ban').addClass('fixed');
        } else {
            $('#ban').removeClass('fixed');
        }

        /*if (pos_top >= max_pos){
            $('#ban').addClass('absolute');
        } else {
            $('#ban').removeClass('absolute');
        }*/
    }

    $('#account_req_currency_id').change(function(){
        var value = $('#account_req_currency_id option:selected').text();
        $('#currency').text(value);
    });

    $('.service_cont.price table').find('tr:even td').css('background-color', '#e5e5e5');
    $('.service_cont.price table').find('tr:odd td').css('background-color', '#ffffff');

    $('.content_static table').find('tr:even td').css('background-color', '#e5e5e5');
    $('.content_static table').find('tr:odd td').css('background-color', '#ffffff');

    $('.service_cont.serv table').find('tr:even td').css('background-color', '#e5e5e5');
    $('.service_cont.serv table').find('tr:odd td').css('background-color', '#ffffff');

	$('table.striped').find('tr:not(.nostriped):even td').css('background-color', '#e5e5e5');
	$('table.striped').find('tr:not(.nostriped):odd td').css('background-color', '#ffffff');

    $('#show_form').click(function(){
        if ($('#formshow:visible').length) {
            $('#formshow').hide();
        } else {
            $('#formshow').show();
        }
    });
    
    $('#match').click(function(){
        ChangeCountries();
    });

    /*
    * Клик по Регистрации / Авторизации
    */
    var init_button = '';
    $("[data-auth='1']").live('click', function(){
        var url = $(this).data('url');
        $.ajax({
            'url': url,
            'type': 'get',
            'dataType': 'json',
            'cache': false,
            'success': function(data) {
                $('#div_call_back').html(data.message);
                var $activeTab = window.reg_errors ? 1 : 0;
                $(".withtabs").tabs({
                    active: $activeTab
                });
                $('#div_call_back').dialog({
                    modal: true,
                    position: 'center',
                    width: 288,
                    height: 'auto',
                    resizable: false,
                    dialogClass: 'auth_reg_dialog small_head'
                });

            },
            'error': function(jqXHR, textStatus, errorThrown) {
//                console.log(textStatus);
            }
        });

        return false;
    });

    $('#auth').live('click', function(){
        if (siteuser.id) {
            //window.location.href = '/cabinet/';
        } else {
            var form_id = $('.checkauth').length ? $('.checkauth').parents('form').attr('id') : null;
            checkAuth('authorize_form', form_id);
            return false;
        }
        return false;
    });

    $('#registr').live('click', function(){
        if (siteuser.id) {
            //window.location.href = '/cabinet/';
        } else {
            var form_id = $('.checkauth').length ? $('.checkauth').parents('form').attr('id') : null;
            checkAuth('registration_form', form_id);
        }

        return false;
    });
	$('.forgot_password').live('click', function() {
		$('.withtabs').hide();
		$('.remind_password').show();
		return false;
	});

    $('#remind').live('click', function(){
        mail = $('#email_remind').val();
        $('#remind_msg').html('');
        $.ajax({
            url: '/remindPass',
            type: 'POST',
            data: {mail: mail},
            async: false,
            success: function (data) {
                if(data == "sended"){
                    $('#remind_table').hide();
                    $('#remind_msg').html('Ваш пароль отправлен на Ваш e-mail');
                }
                else if(data == "not_find"){
                    $('#remind_msg').html('Такой e-mail в базе не найден');
                }
                else{
                    $('#remind_msg').html('Произошла неизвестная ошибка, попробуйте еще раз позднее');
                }
            },
            'error': function (jqXHR, textStatus, errorThrown) {
                // console.log(textStatus);
            }
        });
    });

    $('[data-remove="1"]').live('click', function(){
        var $this = $(this), href = $this.data('href'), msg = $this.data('msg');
        $('#div_call_back').html($('#dialog-confirm').html());
        $('#div_call_back').dialog({
            modal: true,
            position: 'center',
            title: msg,
            width: 400,
            height: 'auto',
            resizable: false
        });

        $('[data-yes="1"]').live('click', function() {
            window.location.href = href;
        });

    });

    function checkAuth(id, form_id) {
        var arr = $('#' + id).serialize();
        $.ajax({
            url: '/checkauth',
            type: 'POST',
            data: arr,
            dataType: 'json',
            success: function(data) {
                if (!data.link) {
                    $('#div_call_back').html(data.message);
                    var $activeTab = window.reg_errors ? 1 : 0;
                    $(".withtabs").tabs({
                        active: $activeTab
                    });
                    $('#div_call_back').dialog({
                        modal: true,
                        position: 'center',
                        width: 288,
                        height: 'auto',
                        resizable: false,
                        dialogClass: 'auth_reg_dialog small_head'
                    });
                    if (form_id && $('#' + form_id).length && data.siteuser) {
                        $('#' + form_id).append('<input type="hidden" name="' + init_button + '">').submit();
                    } else if((id == 'registration_form' || id == 'authorize_form') && data.siteuser){
                        document.location.reload();
                        return false;
                    }
                } else {
                    if (form_id && $('#' + form_id).length) {
                        var dataPost = $('#' + id).serialize();
                        dataPost = dataPost + "&" + data.siteuser;
                        $.ajax({
                            url: window.location.href,
                            type: 'POST',
                            data: dataPost,
                            dataType: 'json',
                            success: function(data) {

                            },
                            'error': function(jqXHR, textStatus, errorThrown) {
                                // console.log(textStatus);
                            }
                        });

                    }
                }
            },
            'error': function(jqXHR, textStatus, errorThrown) {
                // console.log(textStatus);
            }
        });
        return false;
    }


    $('.checkauth').live('click', function(){
        init_button = this.name;
        if (siteuser.id) {
            $('#account_req_form').submit();
        } else {
            checkAuth($('.checkauth').parents('form').attr('id'));
            return false;
        }
    });

	function number_format( str ){
		return str.replace(/(\s)+/g, '').replace(/(\d{1,3})(?=(?:\d{3})+(?:((\.\d{2})|(,\d{2}))|$))/g, '$1 ');
	}
	$('input.integer').live('keyup', function(event){
		$(this).val( number_format ( $(this).val() ) );
	});

	$('input.integer').live('focusout', function(event){
		var a =$(this).val().replace(/(\s)+/g, '').replace(/[,]+/g, ".");
		var input = $(this);
		if (a != ''){
			var b = parseFloat(a).toFixed(2);
			input.val(number_format(b.toString()));
		} else {

		}
	});

	$('#calculator_req_currency').change(function(){
		var selected_currency = $(this).find('option:selected');
		var $cur = (selected_currency.val().length) ? selected_currency.text() : '';
		$('[data-type="currency"]').text($cur);
	});
});

function ChangeCountries() {
    if ($('#match:checked').length) {
        $('select[name*=country_source] :selected').each(function(){
            $('select[name*=country_receiver] option[value=' + this.value + ']').attr('selected', 'selected');
        });
        if (!$('select[name*=country_source] :selected').length) {
            $('select[name*=country_receiver] option').removeAttr('selected');
        }
        $(".chzn-select1").trigger("liszt:updated");
    }
}

