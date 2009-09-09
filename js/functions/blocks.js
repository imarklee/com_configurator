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
		
		$('#logo-options li #logoslogan_text').parent().css('display', display);
		$('#logo-options li #logoslogan_textcolor').parent().css('display', display);
		$('#logo-options li #logoslogan_fontsize').parent().css('display', display);
		$('#logo-options li #logoslogan_fontfamily').parent().css('display', display);
		$('#logo-options li #logoslogan_top').parent().css('display', display);
		$('#logo-options li #logoslogan_left').parent().css('display', display);
		$('#logo-options li #logoslogan_stack').parent().css('display', display);
	}
	
	function ieLogo(val){
		var display;
		if(val == 'on'){ display='block'; }else{ display='none'; }
		$('#logo-options li #logologo_image_ie').parent().css('display', display);
	}
	
	function autoDimensions(val) {
		var display;
		if(val == 'on'){ display='block'; }else{ display='none'; }
		$('#logo-options li #logologo_width').parent().css('display', display);
		$('#logo-options li #logologo_height').parent().css('display', display);
	}
				
	function switcher(v){
		switch(v){
			case '0': // Linked H1 Text
			$('#logo-options li').css('display', 'none');
			$('#logo-options li.heading').css('display', 'block');
			$('#logologo_type').parent().css('display', 'block');
			$('#logo-options li #logologo_textcolor').parent().css('display', 'block');
			$('#logo-options li #logologo_fontsize').parent().css('display', 'block');
			$('#logo-options li #logologo_fontfamily').parent().css('display', 'block');
			$('#logo-options li #logodisplay_slogan0').parent().css('display', 'block');
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
			$('#logo-options li #logodisplay_slogan0').parent().css('display', 'block');
			$('#logo-options li #logologo_text').parent().css('display', 'block');
			$('#logo-options li #logologo_autodimensions1').parent().css('display', 'block');
			$('#logo-options li #logologo_top').parent().css('display', 'block');
			$('#logo-options li #logologo_left').parent().css('display', 'block');
			$('#logo-options li #logologo_stack').parent().css('display', 'block');
			break;
			case '2': // Linked Inline Image
			$('#logo-options li').css('display', 'none');
			$('#logo-options li.heading').css('display', 'block');
			$('#logologo_type').parent().css('display', 'block');
			$('#logo-options li #logologo_image').parent().css('display', 'block');
			$('#logo-options li #logodisplay_ie_logo0').parent().css('display', 'block');
			$('#logo-options li #logologo_alttext').parent().css('display', 'block');
			$('#logo-options li #logologo_linktitle').parent().css('display', 'block');
			$('#logo-options li #logodisplay_slogan0').parent().css('display', 'block');
			$('#logo-options li #logologo_autodimensions1').parent().css('display', 'block');
			$('#logo-options li #logologo_top').parent().css('display', 'block');
			$('#logo-options li #logologo_left').parent().css('display', 'block');
			$('#logo-options li #logologo_stack').parent().css('display', 'block');
			break;
			case '3': // Module Position
			$('#logo-options li').css('display', 'none');
			$('#logo-options li.heading:first').css('display', 'block');
			$('#logologo_type').parent().css('display', 'block');
			$('#logo-options li #logodisplay_slogan0').parent().css('display', 'block');
			$('#logo-options li #logologo_top').parent().css('display', 'block');
			$('#logo-options li #logologo_left').parent().css('display', 'block');
			break;
		}
		
		//
		
		if($('#logodisplay_slogan0').attr('checked') == 'checked'){ slogan('off'); }
		$('#logodisplay_slogan0').click( function(){ slogan('off'); } );
		
		if($('#logodisplay_slogan1').attr('checked')){ slogan('on'); }
		$('#logodisplay_slogan1').click( function(){ slogan('on'); } );

		if($('#logodisplay_ie_logo1').attr('checked')){ ieLogo('on'); }
		$('#logodisplay_ie_logo1').click( function(){ ieLogo('on'); } );
		
		if($('#logodisplay_ie_logo0').attr('checked')){ ieLogo('off'); }
		$('#logodisplay_ie_logo0').click( function(){ ieLogo('off'); } )
		
		if($('#logologo_autodimensions1').attr('checked')){ autoDimensions('off'); }
		$('#logologo_autodimensions1').click( function(){ autoDimensions('off'); } );
		
		if($('#logologo_autodimensions0').attr('checked')){ autoDimensions('on'); }
		$('#logologo_autodimensions0').click( function(){ autoDimensions('on'); } );
			
	}	
}
$(function(){ LogoOptions(); });

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
	blockSettingsOptions('#masterheadmasthead_chrome','#masterheadmasthead');
	blockSettingsOptions('#subheadsubhead_chrome','#subheadsubhead');
	blockSettingsOptions('#topnavtopnav_chrome','#topnavtopnav');
	blockSettingsOptions('#shelvestopshelf_chrome','#shelvestopshelf');
	blockSettingsOptions('#shelvesbottomshelf_chrome','#shelvesbottomshelf');
	blockSettingsOptions('#inlineshelvesuser1_chrome','#inlineshelvesuser1');
	blockSettingsOptions('#inlineshelvesuser2_chrome','#inlineshelvesuser2');
	blockSettingsOptions('#outer-sidebarsplitleft_chrome','#outer-sidebarsplitleft');
	blockSettingsOptions('#outer-sidebartopleft_chrome','#outer-sidebartopleft');
	blockSettingsOptions('#outer-sidebarleft_chrome','#outer-sidebarleft');
	blockSettingsOptions('#outer-sidebarbottomleft_chrome','#outer-sidebarbottomleft');
	blockSettingsOptions('#inner-sidebarsplitright_chrome','#inner-sidebarsplitright');
	blockSettingsOptions('#inner-sidebartopright_chrome','#inner-sidebartopright');
	blockSettingsOptions('#inner-sidebarright_chrome','#inner-sidebarright');
	blockSettingsOptions('#inner-sidebarbottomright_chrome','#inner-sidebarbottomright');
	blockSettingsOptions('#insetsinset1_chrome','#insetsinset1');
	blockSettingsOptions('#insetsinset2_chrome','#insetsinset2');
	blockSettingsOptions('#insetsinset3_chrome','#insetsinset3');
	blockSettingsOptions('#insetsinset4_chrome','#insetsinset4');
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
	sliderOptionsOn('#shelvesbottomshelf_slider1','#shelvesbottomshelf_slider_text');
	sliderOptionsOff('#shelvesbottomshelf_slider0','#shelvesbottomshelf_slider_text');
	sliderOptionsOn('#shelvestopshelf_slider1','#shelvestopshelf_slider_text');
	sliderOptionsOff('#shelvestopshelf_slider0','#shelvestopshelf_slider_text');
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
	if($(elid).attr('checked') || $(elid).attr('checked') == false){
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
