/**
 * Block Settings: Conditional Functions
 */
$('#generalthemelet').parent().css('display', 'none');
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
	
	function ieLogo(val){
		var display;
		if(val == 'on'){ display='block'; }else{ display='none'; }
		$('#logo-options li #logologo_image_ie').parent().css('display', display);
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
		if($('#logodisplay_ie_logo1').attr('checked')){ ieLogo('on'); }
		$('#logodisplay_ie_logo1').click( function(){ ieLogo('on'); } );
	
		if($('#logodisplay_ie_logo0').attr('checked')){ ieLogo('off'); }
		$('#logodisplay_ie_logo0').click( function(){ ieLogo('off'); } )
	
		if($('#logologo_autodimensions1').attr('checked')){ autoDimensions('off'); }
		$('#logologo_autodimensions1').click( function(){ autoDimensions('off'); } );
	
		if($('#logologo_autodimensions0').attr('checked')){ autoDimensions('on'); }
		$('#logologo_autodimensions0').click( function(){ autoDimensions('on'); } );
	}
			
	function switcher(v){
		
		$('#logo-options li').css('display', 'none');
		
		switch(v){
			case '0': // Linked H1 Text
			$('#logo-options li').css('display', 'none');
			$('#logo-options li.heading').css('display', 'block');
			$('#logologo_type').parent().css('display', 'block');
			$('#logo-options li #logologo_textcolor').parent().css('display', 'block');
			$('#logo-options li #logologo_fontsize').parent().css('display', 'block');
			$('#logo-options li #logologo_fontfamily').parent().css('display', 'block');
			$('#logo-options li #taglinedisplay_slogan0').parent().css('display', 'block');
			$('#logo-options li #logologo_text').parent().css('display', 'block');
			$('#logo-options li #logologo_top').parent().css('display', 'block');
			$('#logo-options li #logologo_left').parent().css('display', 'block');
			$('#logo-options li #logologo_stack').parent().css('display', 'block');
			break;
			case '1': // Linked H1 Image Replacement
			$('#logo-options li').css('display', 'none');
			$('#logo-options li.heading').css('display', 'block');
			$('#logologo_type').parent().css('display', 'block');
			$('#logo-options li #logologo_image').parent().css('display', 'block');
			$('#logo-options li #logodisplay_ie_logo0').parent().css('display', 'block');
			$('#logo-options li #logologo_linktitle').parent().css('display', 'block');
			$('#logo-options li #taglinedisplay_slogan0').parent().css('display', 'block');
			$('#logo-options li #logologo_text').parent().css('display', 'block');
			$('#logo-options li #logologo_autodimensions1').parent().css('display', 'block');
			$('#logo-options li #logologo_top').parent().css('display', 'block');
			$('#logo-options li #logologo_left').parent().css('display', 'block');
			$('#logo-options li #logologo_stack').parent().css('display', 'block');
			logoConditionals();
			break;
			case '2': // Linked Inline Image
			$('#logo-options li').css('display', 'none');
			$('#logo-options li.heading').css('display', 'block');
			$('#logologo_type').parent().css('display', 'block');
			$('#logo-options li #logologo_image').parent().css('display', 'block');
			$('#logo-options li #logodisplay_ie_logo0').parent().css('display', 'block');
			$('#logo-options li #logologo_alttext').parent().css('display', 'block');
			$('#logo-options li #logologo_linktitle').parent().css('display', 'block');
			$('#logo-options li #taglinedisplay_slogan0').parent().css('display', 'block');
			$('#logo-options li #logologo_autodimensions1').parent().css('display', 'block');
			$('#logo-options li #logologo_top').parent().css('display', 'block');
			$('#logo-options li #logologo_left').parent().css('display', 'block');
			$('#logo-options li #logologo_stack').parent().css('display', 'block');
			logoConditionals();
			break;
			case '3': // Module Position
			$('#logo-options li').css('display', 'none');
			$('#logo-options li.heading:first').css('display', 'block');
			$('#logologo_type').parent().css('display', 'block');
			$('#logo-options li #taglinedisplay_slogan0').parent().css('display', 'block');
			$('#logo-options li #logologo_top').parent().css('display', 'block');
			$('#logo-options li #logologo_left').parent().css('display', 'block');
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
	blockSettingsOptions('#topshelftopshelf_chrome','#topshelftopshelf');
	blockSettingsOptions('#bottomshelfbottomshelf_chrome','#bottomshelfbottomshelf');
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
blockDisable('#topshelftopshelf');
blockDisable('#bottomshelfbottomshelf');
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
	sliderOptionsOn('#bottomshelfbottomshelf_slider1','#bottomshelfbottomshelf_slider_text');
	sliderOptionsOff('#bottomshelfbottomshelf_slider0','#bottomshelfbottomshelf_slider_text');
	sliderOptionsOn('#topshelftopshelf_slider1','#topshelftopshelf_slider_text');
	sliderOptionsOff('#topshelftopshelf_slider0','#topshelftopshelf_slider_text');
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
