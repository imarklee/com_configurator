/**
 * Configurator.Blocks.js, related to the block conditionals
 * @TODO very much work in progress this file
 */

Configurator.Blocks = {};

/**
 * Block Settings: Conditional Functions
 */
function LogoOptions(){
	switcher($('#logologo_type > option:selected').val());
	
	$('#logologo_type').change(function(){
		var logoType = $(this).val();
		switcher(logoType);
	});
	
	function slogan(val) {
		var display;
		if(val == 'on'){ display='block'; }else{ display='none'; }
		
		$('#logo-options li #taglineslogan_text').parent().css('display', display);
		$('#logo-options li #taglineslogan_textcolor').parent().css('display', display);
		$('#logo-options li #taglineslogan_fontsize').parent().css('display', display);
		$('#logo-options li #taglineslogan_fontfamily').parent().css('display', display);
		$('#logo-options li #taglineslogan_top').parent().css('display', display);
		$('#logo-options li #taglineslogan_left').parent().css('display', display);
		$('#logo-options li #taglineslogan_stack').parent().css('display', display);
	}
	
	function ielogo(val){
		var display;
		if(val == 'on'){ display='block'; }else{ display='none'; }
		$('#logo-options li #logologo_ielogo_image').parent().css('display', display);
	}

    function pathwayText(val){
    	var display;
    	if(val == '1'){ display='block'; }else{ display='none'; }
    	$('#main-options li #mainpathway_text').parent().css('display', display);
    }
	
	function autoDimensions(val) {
		var display;
		if(val == 'on'){ display='block'; }else{ display='none'; }
		$('#logo-options li #logologo_width').parent().css('display', display);
		$('#logo-options li #logologo_height').parent().css('display', display);
	}

	if($('#taglinedisplay_slogan0').attr('checked') == 'checked'){ slogan('off'); }
	$('#taglinedisplay_slogan0').click( function(){ slogan('off'); } );

	if($('#taglinedisplay_slogan1').attr('checked')){ slogan('on'); }
	$('#taglinedisplay_slogan1').click( function(){ slogan('on'); } );

	function logoConditionals(){
		if($('#logologo_ielogo1').attr('checked')){ ielogo('on'); }
		$('#logologo_ielogo1').click( function(){ ielogo('on'); } );
	
		if($('#logologo_ielogo0').attr('checked')){ ielogo('off'); }
		$('#logologo_ielogo0').click( function(){ ielogo('off'); } )
			
		if($('#logologo_autodimensions1').attr('checked')){ autoDimensions('off'); }
		$('#logologo_autodimensions1').click( function(){ autoDimensions('off'); } );
	
		if($('#logologo_autodimensions0').attr('checked')){ autoDimensions('on'); }
		$('#logologo_autodimensions0').click( function(){ autoDimensions('on'); } );
	}
	
	$('#logo-options li #logologo_block').parent().css('display', 'block');
	$('#logo-options li #logologowrap_height').parent().css('display', 'block');
				
	function switcher(v){
		
		$('#logo-panel li').css('display', 'none');
		
		switch(v){
			case '0': // Text Based
			$('#logo-panel li').css('display', 'none');
			$('#logo-panel li.heading').css('display', 'block');
			$('#logo-panel li #logologo_block').parent().css('display', 'block');
			$('#logo-panel li #logologo_type').parent().css('display', 'block');
			$('#logo-panel li #logologowrap_height').parent().css('display', 'block');
			$('#logo-panel li #logologo0_text').parent().css('display', 'block');
			$('#logo-panel li #logologo0_fontfamily').parent().css('display', 'block');
			$('#logo-panel li #logologo0_textsize').parent().css('display', 'block');
			$('#logo-panel li #logologo0_textcolor').parent().css('display', 'block');
			$('#logo-panel li #logologo0_linktitle').parent().css('display', 'block');
			$('#logo-panel li #logologo0_top').parent().css('display', 'block');
			$('#logo-panel li #logologo0_left').parent().css('display', 'block');
			$('#logo-panel li #logologo0_stack').parent().css('display', 'block');
			break;
			case '1': // Image Replacement
			$('#logo-panel li').css('display', 'none');
			$('#logo-panel li.heading').css('display', 'block');
			$('#logo-panel li #logologo_block').parent().css('display', 'block');
			$('#logo-panel li #logologo_type').parent().css('display', 'block');
			$('#logo-panel li #logologowrap_height').parent().css('display', 'block');
			$('#logo-panel li #logologo_image').parent().css('display', 'block');
			$('#logo-panel li #logologo_autodimensions0').parent().css('display', 'block');
			$('#logo-panel li #logologo_width').parent().css('display', 'block');
			$('#logo-panel li #logologo_height').parent().css('display', 'block');
			$('#logo-panel li #logologo_ielogo0').parent().css('display', 'block');
			$('#logo-panel li #logologo_ielogo_image').parent().css('display', 'block');
			$('#logo-panel li #logologo1_text').parent().css('display', 'block');
			$('#logo-panel li #logologo1_linktitle').parent().css('display', 'block');
			$('#logo-panel li #logologo1_top').parent().css('display', 'block');
			$('#logo-panel li #logologo1_left').parent().css('display', 'block');
			$('#logo-panel li #logologo1_stack').parent().css('display', 'block');
			logoConditionals();
			break;
			case '2': //  Inline Image
			$('#logo-panel li').css('display', 'none');
			$('#logo-panel li.heading').css('display', 'block');
			$('#logo-panel li #logologo_block').parent().css('display', 'block');
			$('#logo-panel li #logologo_type').parent().css('display', 'block');
			$('#logo-panel li #logologowrap_height').parent().css('display', 'block');
			$('#logo-panel li #logologo_image').parent().css('display', 'block');
			$('#logo-panel li #logologo_autodimensions0').parent().css('display', 'block');
			$('#logo-panel li #logologo_width').parent().css('display', 'block');
			$('#logo-panel li #logologo_height').parent().css('display', 'block');
			$('#logo-panel li #logologo_ielogo0').parent().css('display', 'block');
			$('#logo-panel li #logologo_ielogo_image').parent().css('display', 'block');
			$('#logo-panel li #logologo2_alttext').parent().css('display', 'block');
			$('#logo-panel li #logologo2_linktitle').parent().css('display', 'block');
			$('#logo-panel li #logologo2_top').parent().css('display', 'block');
			$('#logo-panel li #logologo2_left').parent().css('display', 'block');
			$('#logo-panel li #logologo2_stack').parent().css('display', 'block');
			logoConditionals();
			break;
			case '3': // Module Position
			$('#logo-panel li').css('display', 'none');
			$('#logo-panel li.heading:first').css('display', 'block');
			$('#logo-panel li #logologo_block').parent().css('display', 'block');
			$('#logo-panel li #logologo_type').parent().css('display', 'block');
			$('#logo-panel li #logologowrap_height').parent().css('display', 'block');
			break;
		}			
	}	
}
$(function(){ LogoOptions(); });

function backgroundsEnable(){
	
	function be(val, suff){
		var display;
		if(val == 'on'){ display='block'; }else{ display='none'; }
		$(suff+'_bg_image').parent().css('display', display);
		$(suff+'_bg_repeat').parent().css('display', display);
		$(suff+'_bg_position').parent().css('display', display);
		$(suff+'_bg_attachment').parent().css('display', display);
	}

	if($('#htmlbackgroundsuse_html_bg_image1').attr('checked')){ be('on', '#htmlbackgroundshtml'); }
	$('#htmlbackgroundsuse_html_bg_image1').click( function(){ be('on', '#htmlbackgroundshtml'); } );
	
	if($('#htmlbackgroundsuse_html_bg_image0').attr('checked')){ be('off', '#htmlbackgroundshtml'); }
	$('#htmlbackgroundsuse_html_bg_image0').click( function(){ be('off', '#htmlbackgroundshtml'); } );

	if($('#bodybackgroundsuse_body_bg_image1').attr('checked')){ be('on', '#bodybackgroundsbody'); }
	$('#bodybackgroundsuse_body_bg_image1').click( function(){ be('on', '#bodybackgroundsbody'); } );
	
	if($('#bodybackgroundsuse_body_bg_image0').attr('checked')){ be('off', '#bodybackgroundsbody'); }
	$('#bodybackgroundsuse_body_bg_image0').click( function(){ be('off', '#bodybackgroundsbody'); } );
	
}
$(function(){ backgroundsEnable(); });

function blockSettingsOptions(elid, hideid){
	
	$(elid).change(function(){
		var option = $(this).val();
		switcher(option);
	});
	
	switcher($(elid+' > option:selected').val());
	
	function switcher(v){
		switch(v){
			case 'grid':
				$(hideid+'_gridsplit').parent().css('display', 'block');
				$(hideid+'_equalize1').parent().css('display', 'block');
				$(hideid+'_module_inner').parent().css('display', 'block');
				$(hideid+'_modfx').parent().css('display', 'block');
			break;
			case 'basic':
				$(hideid+'_gridsplit').parent().css('display', 'none');
				$(hideid+'_equalize1').parent().css('display', 'none');
				$(hideid+'_module_inner').parent().css('display', 'block');
				$(hideid+'_modfx').parent().css('display', 'block');
			break;
			case 'tabs':
				$(hideid+'_gridsplit').parent().css('display', 'none');
				$(hideid+'_equalize1').parent().css('display', 'none');
				$(hideid+'_module_inner').parent().css('display', 'none');
				$(hideid+'_modfx').parent().css('display', 'block');
			break;
			case 'accordion':
				$(hideid+'_gridsplit').parent().css('display', 'none');
				$(hideid+'_equalize1').parent().css('display', 'none');
				$(hideid+'_module_inner').parent().css('display', 'none');
				$(hideid+'_modfx').parent().css('display', 'block');
			break;
			default:
				$(hideid+'_gridsplit').parent().css('display', 'none');
				$(hideid+'_equalize1').parent().css('display', 'none');
				$(hideid+'_module_inner').parent().css('display', 'none');
				$(hideid+'_modfx').parent().css('display', 'none');
		}
	}
}
$(function(){ 
	blockSettingsOptions('#toolbartoolbar_chrome','#toolbartoolbar');
	blockSettingsOptions('#mastheadmasthead_chrome','#mastheadmasthead');
	blockSettingsOptions('#subheadsubhead_chrome','#subheadsubhead');
	blockSettingsOptions('#topnavtopnav_chrome','#topnavtopnav');
	blockSettingsOptions('#topshelf1topshelf1_chrome','#topshelf1topshelf1');
	blockSettingsOptions('#topshelf2topshelf2_chrome','#topshelf2topshelf2');
	blockSettingsOptions('#topshelf3topshelf3_chrome','#topshelf3topshelf3');
	blockSettingsOptions('#bottomshelf1bottomshelf1_chrome','#bottomshelf1bottomshelf1');
	blockSettingsOptions('#bottomshelf2bottomshelf2_chrome','#bottomshelf2bottomshelf2');
	blockSettingsOptions('#bottomshelf3bottomshelf3_chrome','#bottomshelf3bottomshelf3');
	blockSettingsOptions('#user1user1_chrome','#user1user1');
	blockSettingsOptions('#user2user2_chrome','#user2user2');
	blockSettingsOptions('#outer1outer1_chrome','#outer1outer1');
	blockSettingsOptions('#outer2outer2_chrome','#outer2outer2');
	blockSettingsOptions('#outer3outer3_chrome','#outer3outer3');
	blockSettingsOptions('#outer4outer4_chrome','#outer4outer4');
	blockSettingsOptions('#outer5outer5_chrome','#outer5outer5');
	blockSettingsOptions('#inner1inner1_chrome','#inner1inner1');
	blockSettingsOptions('#inner2inner2_chrome','#inner2inner2');
	blockSettingsOptions('#inner3inner3_chrome','#inner3inner3');
	blockSettingsOptions('#inner4inner4_chrome','#inner4inner4');
	blockSettingsOptions('#inner5inner5_chrome','#inner5inner5');
	blockSettingsOptions('#inset1inset1_chrome','#inset1inset1');
	blockSettingsOptions('#inset2inset2_chrome','#inset2inset2');
	blockSettingsOptions('#inset3inset3_chrome','#inset3inset3');
	blockSettingsOptions('#inset4inset4_chrome','#inset4inset4');
	blockSettingsOptions('#footerfooter_chrome','#footerfooter');
});

function blockDisable(elid){

	function show(act1, act2){
		act1.parent().parent().removeClass('disabled');
		act1.parent().prevAll('li').children().removeAttr('disabled');
		act1.parent().prevAll('li').fadeTo('fast', 1);
		act1.removeAttr('disabled');
		act2.removeAttr('disabled');
	}
	function hide(act1, act2){
		act1.parent().parent().addClass('disabled');
		act1.parent().prevAll('li').children().attr('disabled',true);
		act1.parent().prevAll('li').fadeTo('fast', 0.4);
		act1.removeAttr('disabled');
		act2.removeAttr('disabled');
	}
	
	if($(elid+'_show0').attr('checked')){ show($(elid+'_show0'), $(elid+'_show1')); }
	$(elid+'_show0').click(function(){ show($(elid+'_show0'), $(elid+'_show1')); });
	
	if($(elid+'_show1').attr('checked')){ hide($(elid+'_show0'), $(elid+'_show1')); }
	$(elid+'_show1').click(function(){ hide($(elid+'_show0'), $(elid+'_show1')); });

}

blockDisable('#toolbartoolbar');
blockDisable('#mastheadmasthead');
blockDisable('#subheadsubhead');
blockDisable('#topnavtopnav');
blockDisable('#topshelf1topshelf1');
blockDisable('#topshelf2topshelf2');
blockDisable('#topshelf3topshelf3');
blockDisable('#bottomshelf1bottomshelf1');
blockDisable('#bottomshelf2bottomshelf2');
blockDisable('#bottomshelf3bottomshelf3');
blockDisable('#user1user1');
blockDisable('#user2user2');
blockDisable('#footerfooter');

function footerOptions(elid, hideid){
	
	$(elid).change(function(){
		var option = $(this).val();
		switcher(option);
	});
	
	switcher($(elid+' > option:selected').val());
	
	function switcher(v){
		switch(v){
			case '0':
				$(hideid).parent().css('display', 'none');
				$('#footerfooter_gridsplit').parent().css('display', 'none');
				$('#footerfooter_copyright').parent().css('display', 'block');
				$('#footerfooter_credits').parent().css('display', 'block');
				$('#footerfooter_textcolor').parent().css('display', 'block');
				$('#footerfooter_linkscolor').parent().css('display', 'block');
				$('#footerfooter_swish1').parent().css('display', 'block');
				$('#footerfooter_morphlink1').parent().css('display', 'block');
				$('#footerfooter_xhtml1').parent().css('display', 'block');
				$('#footerfooter_css1').parent().css('display', 'block');
				$('#footerfooter_rss1').parent().css('display', 'block');
			break;
			case '1':
				$(hideid).parent().css('display', 'block');
				blockSettingsOptions('#footerfooter_chrome','#footerfooter');
				$('#footerfooter_copyright').parent().css('display', 'none');
				$('#footerfooter_credits').parent().css('display', 'none');
				$('#footerfooter_textcolor').parent().css('display', 'none');
				$('#footerfooter_linkscolor').parent().css('display', 'none');
				$('#footerfooter_swish1').parent().css('display', 'none');
				$('#footerfooter_morphlink1').parent().css('display', 'none');
				$('#footerfooter_xhtml1').parent().css('display', 'none');
				$('#footerfooter_css1').parent().css('display', 'none');
				$('#footerfooter_rss1').parent().css('display', 'none');
			break;
		}
	}
}

footerOptions('#footerfooter_type', '#footerfooter_chrome');

function sliderOptionsOn(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'block');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'block');
	});
}
function sliderOptionsOff(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'none');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'none');
	});
}

$(function(){
	sliderOptionsOn('#toolbartoolbar_slider1','#toolbartoolbar_slider_text');
	sliderOptionsOff('#toolbartoolbar_slider0','#toolbartoolbar_slider_text');
	sliderOptionsOn('#bottomshelf1bottomshelf1_slider1','#bottomshelf1bottomshelf1_slider_text');
	sliderOptionsOff('#bottomshelf1bottomshelf1_slider0','#bottomshelf1bottomshelf1_slider_text');
	sliderOptionsOn('#bottomshelf2bottomshelf2_slider1','#bottomshelf2bottomshelf2_slider_text');
	sliderOptionsOff('#bottomshelf2bottomshelf2_slider0','#bottomshelf2bottomshelf2_slider_text');
	sliderOptionsOn('#bottomshelf3bottomshelf3_slider1','#bottomshelf3bottomshelf3_slider_text');
	sliderOptionsOff('#bottomshelf3bottomshelf3_slider0','#bottomshelf3bottomshelf3_slider_text');
	sliderOptionsOn('#topshelf1topshelf1_slider1','#topshelf1topshelf1_slider_text');
	sliderOptionsOff('#topshelf1topshelf1_slider0','#topshelf1topshelf1_slider_text');
	sliderOptionsOn('#topshelf2topshelf2_slider1','#topshelf2topshelf2_slider_text');
	sliderOptionsOff('#topshelf2topshelf2_slider0','#topshelf2topshelf2_slider_text');
	sliderOptionsOn('#topshelf3topshelf3_slider1','#topshelf3topshelf3_slider_text');
	sliderOptionsOff('#topshelf3topshelf3_slider0','#topshelf3topshelf3_slider_text');
	sliderOptionsOn('#progressiverounded_corners1', '#progressiverounded_amount');
	sliderOptionsOff('#progressiverounded_corners0', '#progressiverounded_amount');
});

function menuOptionsOn(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'block');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'block');
	});
}
function menuOptionsOff(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'none');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'none');
	});
}

$(function(){
	menuOptionsOn('#menutopnav_supersubs1','#menutopnav_minwidth, #menutopnav_maxwidth');
	menuOptionsOff('#menutopnav_supersubs0','#menutopnav_minwidth,  #menutopnav_maxwidth');
});


function globalWrapOn(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'block');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'block');
	});
}
function globalWrapOff(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'none');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'none');
	});
}

$(function(){
	globalWrapOn('#generalglobal_wrap1','#generalglobal_wrap_start, #generalglobal_wrap_end');
	globalWrapOff('#generalglobal_wrap0','#generalglobal_wrap_start,  #generalglobal_wrap_end');
});

function cacheOn(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'block');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'block');
	});
}
function cacheOff(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'none');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'none');
	});
}

$(function(){
	cacheOn('#performancecache1','#performancecachetime');
	cacheOff('#performancecache0','#performancecachetime');
});

function minifyOn(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'block');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'block');
	});
}
function minifyOff(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'none');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'none');
	});
}

$(function(){
	minifyOn('#performancepack_css1','#performanceminify_css1');
	minifyOn('#performancepack_js1','#performanceminify_js1');
	minifyOff('#performancepack_css0','#performanceminify_css1');
	minifyOff('#performancepack_js0','#performanceminify_js1');
});


function iphoneOn(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'block');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'block');
	});
}
function iphoneOff(elid, hideid){
	if($(elid).attr('checked')){
		$(hideid).parent().css('display', 'none');
	}
	$(elid).click(function(){
		$(hideid).parent().css('display', 'none');
	});
}

$(function(){
    iphoneOn('#iphoneiphone_mode1','#iphoneiphone_header, #iphoneiphone_webclip');
    iphoneOff('#iphoneiphone_mode0','#iphoneiphone_header,  #iphoneiphone_webclip');
    iphoneOn('#iphoneiphone_viewport1','#iphoneiphone_scalable-lbl, #iphoneiphone_width, #iphoneiphone_height, #iphoneiphone_scale');
    iphoneOff('#iphoneiphone_viewport0','#iphoneiphone_scalable-lbl, #iphoneiphone_width, #iphoneiphone_height, #iphoneiphone_scale');
});


function textarea(action, ta_el){
	var display;
	if(action == 'on'){ 
		if($(ta_el+'_show1').attr('checked')){ $(ta_el).parent().css('display', 'block'); }
		$(ta_el+'_show1').click(function(){ $(ta_el).parent().css('display', 'block'); });
	}else{ 
		if($(ta_el+'_show0').attr('checked')){ $(ta_el).parent().css('display', 'none'); }
		$(ta_el+'_show0').click(function(){ $(ta_el).parent().css('display', 'none'); });
	}
}
textarea('on', '#footerfooter_copyright');
textarea('off', '#footerfooter_copyright');
textarea('on', '#footerfooter_credits');
textarea('off', '#footerfooter_credits');
textarea('on', '#mainpathway_text');
textarea('off', '#mainpathway_text');

function captionsCondOff(elid){
	function hide(){
		$(elid).parent().nextAll('li').css('display','none');
	}
	if($(elid).attr('checked')){ hide(); }
	$(elid).click(function(){ hide(); });
}
function captionsCondOn(elid){
	function hideSub(){
		$('#captifycaptions_speedover,#captifycaptions_speedout,#captifycaptions_delay').parent().css('display', 'none');
	}
	function showSub(){
		$('#captifycaptions_speedover,#captifycaptions_speedout,#captifycaptions_delay').parent().css('display', 'block');
	}
	function show(){
		$(elid).parent().nextAll('li').css('display','block');
		if($('#captifycaptions_animationalways-on').attr('checked')){
			hideSub();
		}
		$('#captifycaptions_animationalways-on').click(function(){ hideSub(); });
		
		if($('#captifycaptions_animationslide').attr('checked')){
			showSub();
		}
		$('#captifycaptions_animationslide').click(function(){ showSub(); });
	}
	if($(elid).attr('checked')){ show(); }
	$(elid).click(function(){ show(); });
}
captionsCondOff('#captifycaptions_enabled0', '#captify-options');
captionsCondOn('#captifycaptions_enabled1', '#captify-options');

function lightboxCondOff(elid){
	function hide(){
		$(elid).parent().nextAll('li').css('display','none');
	}
	if($(elid).attr('checked')){ hide(); }
	$(elid).click(function(){ hide(); });
}
function lightboxCondOn(elid){
	function hideSub(){
		$('#lightboxlightbox_speedover,#lightboxlightbox_speedout,#lightboxlightbox_delay').parent().css('display', 'none');
	}
	function showSub(){
		$('#lightboxlightbox_speedover,#lightboxlightbox_speedout,#lightboxlightbox_delay').parent().css('display', 'block');
	}
	function show(){
		$(elid).parent().nextAll('li').css('display','block');
		if($('#lightboxlightbox_animationalways-on').attr('checked')){
			hideSub();
		}
		$('#lightboxlightbox_animationalways-on').click(function(){ hideSub(); });
		
		if($('#lightboxlightbox_animationslide').attr('checked')){
			showSub();
		}
		$('#lightboxlightbox_animationslide').click(function(){ showSub(); });
	}
	if($(elid).attr('checked')){ show(); }
	$(elid).click(function(){ show(); });
}
lightboxCondOff('#lightboxlightbox_enabled0', '#lightbox-options');
lightboxCondOn('#lightboxlightbox_enabled1', '#lightbox-options');

function preloaderCondOff(elid){
	function hide(){
		$(elid).parent().nextAll('li').css('display','none');
	}
	if($(elid).attr('checked')){ hide(); }
	$(elid).click(function(){ hide(); });
}
function preloaderCondOn(elid){
	function hideSub(){
		$('#preloaderpreloader_speedover,#preloaderpreloader_speedout,#preloaderpreloader_delay').parent().css('display', 'none');
	}
	function showSub(){
		$('#preloaderpreloader_speedover,#preloaderpreloader_speedout,#preloaderpreloader_delay').parent().css('display', 'block');
	}
	function show(){
		$(elid).parent().nextAll('li').css('display','block');
		if($('#preloaderpreloader_animationalways-on').attr('checked')){
			hideSub();
		}
		$('#preloaderpreloader_animationalways-on').click(function(){ hideSub(); });
		
		if($('#preloaderpreloader_animationslide').attr('checked')){
			showSub();
		}
		$('#preloaderpreloader_animationslide').click(function(){ showSub(); });
	}
	if($(elid).attr('checked')){ show(); }
	$(elid).click(function(){ show(); });
}
preloaderCondOff('#preloaderpreloader_enabled0', '#preloader-options');
preloaderCondOn('#preloaderpreloader_enabled1', '#preloader-options');