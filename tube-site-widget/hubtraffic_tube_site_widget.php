<?php
/**
 * @package tube_site_widget
 * @version 0.1.1
 */
/*
Plugin Name: Instant Adult Website Widget WordPress Plugin
Plugin URI: https://plugin-demo.adultwebhost1.com/
Description: Instant Adult Tube Site With Content by integrating with Hubtraffic Resources.
Author: AdultWebHost1.com
Version: 0.1.1
Author URI: https://adultwebhost1.com
*/

// Add Shortcode
function tsw_main_shortcode( $atts ) {
	  static $already_run = false;
	   if ( $already_run !== true ) {
	wp_enqueue_script( 'tsw-js' );
	// Attributes
	$atts = shortcode_atts(
		array(
			'category' => '82',
			'300x250_ad'=> '<a href="https://www.adultwebhost1.com" alt="Adult Web Hosting"><img src="https://www.adultwebhost1.com/wp-content/uploads/2018/12/AWH_300x250.png" height="250" width="300" alt="Adult Wordpress Hosting"></a>',
			'cw' => '300',
			'ch' => '325',
			'cm' => '10',
			'max_videos' => '30',
			'modal' => 'on',
		),
		$atts
	);
	$xmlfile = simplexml_load_file(tsw_category_path($atts["category"]));
	
	 ob_start(); 
	echo '<style>img{width:100%;height:auto}.span_1_of_4{width:'. tsw_cleanData($atts["cw"]) .'px;height:'. tsw_cleanData($atts["ch"]).'px;float:left;margin:'. tsw_cleanData($atts["cm"]) .'px !important;overflow:hidden;}.tsw_duration{color:#fff;font-size:16px;position:absolute;bottom:10px;right:7px;text-shadow:2px 2px 5px black}@media only screen and (max-width:560px){.span_1_of_4{width:100%;padding:8px;min-height:400px}}.modalDialog{position:fixed;top:0px;right:0;bottom:0;left:0;max-width:100% !important;width:100% !important; height:100% !important;background:rgba(0,0,0,.8);z-index:99999;opacity:0;-webkit-transition:opacity 400ms ease-in;-moz-transition:opacity 450ms ease-in;transition:opacity 450ms ease-in;pointer-events:none}.modalDialog:target{opacity:1;pointer-events:auto}.modalDialog>div{width:580px;max-width:95%;position:relative;margin:5% auto;padding:5px 10px 13px 10px;border-radius:7px;background:#fff;background:-moz-linear-gradient(#fff,#999);background:-webkit-linear-gradient(#fff,#999);background:-o-linear-gradient(#fff,#999)}.close{background:#606061;color:#FFF !important;line-height:25px;position:absolute;right:-12px;text-align:center;top:-10px;width:24px;text-decoration:none;font-weight:700;-webkit-border-radius:12px;-moz-border-radius:12px;border-radius:12px;-moz-box-shadow:1px 1px 3px #000;-webkit-box-shadow:1px 1px 3px #000;box-shadow:1px 1px 3px #000;font-size:18px;}.close:hover{background:#00d9ff;font-size:18px;}.tsw_bonus {margin:auto;text-align:center;}.close a{color:#FFF !important}</style>';
		$i=0;
	$tsw_script_params = array( );
	foreach ($xmlfile->channel->item as $item) {
		if($i==tsw_cleanData($atts["max_videos"])){break;}
	array_push($tsw_script_params, htmlentities($item->embed));
   echo '<div class="span_1_of_4" style="font-size:18px;">';
		
		if ($atts["modal"]=='on'){
		echo "<div class='tsw_thumbnail-image' style='position:relative;'><a onclick=tsw_modal($i) href='#openModal' id='tsw_modal". $i . "'><img class='tsw_open-modal'  src='" . $item->thumb_large . "'></a>";}else{echo "<div class='tsw_thumbnail-image' style='position:relative;'><a target='_blank' href='". $item->link ."' id='tsw_modal". $i . "'><img class='tsw_open-modal'  src='" . $item->thumb_large . "'></a>";}
		
		
		
		echo '<div class="tsw_duration">' . tsw_minutes($item->duration) . ' </div></div>';
	
		if ($atts["modal"]=='on'){
		echo "<div style='font-size:18px;position:relative;'><a id='tsw_modal". $i . "' onclick=tsw_modal($i) class='tsw_open-modal' href='#openModal'>". tsw_trim_characters($item->title) ."</a></div>";}else{echo "<div style='font-size:18px;position:relative'><a target='_blank' id='tsw_modal". $i . "' class='tsw_open-modal' href='". $item->link ."'>". tsw_trim_characters($item->title) ."</a></div>";}
		
		
		
		echo '<div style="font-size:14px;position:relative;">' .tsw_trim_characters($item->keywords) . '</div>';
		
		if ($i=='6' || $i=='2' || $i=='11'){
			if ($atts["300x250_ad"] == 'none'){echo '</div>';}else {echo  '</div><div class="span_1_of_4" style="min-width="300px"><div class="tsw_bonus">'. $atts["300x250_ad"].'</div></div>';}
			
		}else {echo '</div>';}
		
		
		$i++;
}

echo '<div id="openModal" class="modalDialog" style="visibility:hidden;"><div><a href="#close" title="Close" class="close"> X </a><div class="tsw_iframe">' . $item->embed . '</div></div></div><div style="clear:both"></div>';
	
	wp_localize_script( 'tsw-js', 'tsw_scriptParams', $tsw_script_params );
		    
	   }
	   $already_run = true;
	return ob_get_clean();
}
add_shortcode( 'tsw_tube', 'tsw_main_shortcode' );


function tsw_minutes( $seconds )
{
	/// get minutes
    $minResult = floor($seconds/60);
    /// get sec
    $secResult = ($seconds/60 - $minResult)*60;
        
    return '<strong>' . $minResult . "</strong> mins <strong>" . round($secResult) . '</strong> secs';
}
function tsw_trim_characters( $text, $length = 45, $append = '&hellip;' ) {

	$length = (int) $length;
	$text = trim( strip_tags( $text ) );

	if ( strlen( $text ) > $length ) {
		$text = substr( $text, 0, $length + 1 );
		$words = preg_split( "/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY );
		preg_match( "/[\s]|&nbsp;/", $text, $lastchar, 0, $length );
		if ( empty( $lastchar ) )
			array_pop( $words );

		$text = implode( ' ', $words ) . $append;
	}

	return $text;
}

function tsw_category_path($category){
	if ($category=='82') $path= 'https://www.pornhub.com/feed/amateur.xml'; //default value
	elseif ($category=='0') {$path = 'https://www.pornhub.com/feed/anal.xml';}
		elseif ($category=='1') {$path = 'https://www.pornhub.com/feed/asian.xml';}
	elseif ($category=='2') {$path = 'https://www.pornhub.com/feed/babe.xml';}
	elseif ($category=='3') {$path = 'https://www.pornhub.com/feed/bbw.xml';}
	elseif ($category=='4') {$path = 'https://www.pornhub.com/feed/big-ass.xml';}
	elseif ($category=='5') {$path = 'https://www.pornhub.com/feed/big-dick.xml';}
	elseif ($category=='6') {$path = 'https://www.pornhub.com/feed/big-tits.xml';}
	elseif ($category=='7') {$path = 'https://www.pornhub.com/feed/bisexual.xml';}
	elseif ($category=='8') {$path = 'https://www.pornhub.com/feed/blonde.xml';}
	elseif ($category=='9') {$path = 'https://www.pornhub.com/feed/blowjob.xml';}
	elseif ($category=='10') {$path = 'https://www.pornhub.com/feed/bondage.xml';}
	elseif ($category=='11') {$path = 'https://www.pornhub.com/feed/brunette.xml';}
	elseif ($category=='12') {$path = 'https://www.pornhub.com/feed/bukkake.xml';}
	elseif ($category=='13') {$path = 'https://www.pornhub.com/feed/celebrity.xml';}
	elseif ($category=='14') {$path = 'https://www.pornhub.com/feed/college.xml';}
	elseif ($category=='15') {$path = 'https://www.pornhub.com/feed/compilation.xml';}
	elseif ($category=='16') {$path = 'https://www.pornhub.com/feed/creampie.xml';}
	elseif ($category=='17') {$path = 'https://www.pornhub.com/feed/cumshots.xml';}
	elseif ($category=='18') {$path = 'https://www.pornhub.com/feed/double-penetration.xml';}
	elseif ($category=='19') {$path = 'https://www.pornhub.com/feed/euro.xml';}
	elseif ($category=='20') {$path = 'https://www.pornhub.com/feed/exclusive.xml';}
	elseif ($category=='21') {$path = 'https://www.pornhub.com/feed/fetish.xml';}
	elseif ($category=='22') {$path = 'https://www.pornhub.com/feed/fisting.xml';}
	elseif ($category=='23') {$path = 'https://www.pornhub.com/feed/for-women.xml';}
	elseif ($category=='24') {$path = 'https://www.pornhub.com/feed/funny.xml';}
	elseif ($category=='25') {$path = 'https://www.pornhub.com/feed/gangbang.xml';}
	elseif ($category=='26') {$path = 'https://www.pornhub.com/feed/handjob.xml';}
	elseif ($category=='27') {$path = 'https://www.pornhub.com/feed/hardcore.xml';}
	elseif ($category=='28') {$path = 'https://www.pornhub.com/feed/hentai.xml';}
	elseif ($category=='29') {$path = 'https://www.pornhub.com/feed/indian.xml';}
	elseif ($category=='30') {$path = 'https://www.pornhub.com/feed/interracial.xml';}
	elseif ($category=='31') {$path = 'https://www.pornhub.com/feed/japanese.xml';}
	elseif ($category=='32') {$path = 'https://www.pornhub.com/feed/latina.xml';}
	elseif ($category=='33') {$path = 'https://www.pornhub.com/feed/lesbian.xml';}
	elseif ($category=='34') {$path = 'https://www.pornhub.com/feed/massage.xml';}
	elseif ($category=='35') {$path = 'https://www.pornhub.com/feed/masturbation.xml';}
	elseif ($category=='36') {$path = 'https://www.pornhub.com/feed/milf.xml';}
	elseif ($category=='37') {$path = 'https://www.pornhub.com/feed/orgy.xml';}
	elseif ($category=='38') {$path = 'https://www.pornhub.com/feed/outdoor.xml';}
	elseif ($category=='39') {$path = 'https://www.pornhub.com/feed/party.xml';}
	elseif ($category=='40') {$path = 'https://www.pornhub.com/feed/pornstar.xml';}
	elseif ($category=='41') {$path = 'https://www.pornhub.com/feed/pov.xml';}
	elseif ($category=='42') {$path = 'https://www.pornhub.com/feed/reality.xml';}
	elseif ($category=='43') {$path = 'https://www.pornhub.com/feed/red-head.xml';}
	elseif ($category=='44') {$path = 'https://www.pornhub.com/feed/rough-sex.xml';}
	elseif ($category=='45') {$path = 'https://www.pornhub.com/feed/shemale.xml';}
	elseif ($category=='46') {$path = 'https://www.pornhub.com/feed/small-tits.xml';}
	elseif ($category=='47') {$path = 'https://www.pornhub.com/feed/solo-male.xml';}
	elseif ($category=='48') {$path = 'https://www.pornhub.com/feed/squirt.xml';}
	elseif ($category=='49') {$path = 'https://www.pornhub.com/feed/striptease.xml';}
	elseif ($category=='50') {$path = 'https://www.pornhub.com/feed/teen.xml';}
	elseif ($category=='51') {$path = 'https://www.pornhub.com/feed/threesome.xml';}
		elseif ($category=='52') {$path = 'https://www.pornhub.com/feed/toys.xml';}
		elseif ($category=='53') {$path = 'https://www.pornhub.com/feed/uniforms.xml';}
		elseif ($category=='54') {$path = 'https://www.pornhub.com/feed/vintage.xml';}
		elseif ($category=='55') {$path = 'https://www.pornhub.com/feed/webcam.xml';}
		elseif ($category=='56') {$path = 'https://www.pornhub.com/feed/gay.xml';}
		elseif ($category=='57') {$path = 'https://www.pornhub.com/feed/asian-gay.xml';}
		elseif ($category=='58') {$path = 'https://www.pornhub.com/feed/bareback-gay.xml';}
		elseif ($category=='59') {$path = 'https://www.pornhub.com/feed/bear-gay.xml';}
		elseif ($category=='60') {$path = 'https://www.pornhub.com/feed/big-dick-gay.xml';}
		elseif ($category=='61') {$path = 'https://www.pornhub.com/feed/black-gay.xml';}
		elseif ($category=='62') {$path = 'https://www.pornhub.com/feed/blowjob-gay.xml';}
		elseif ($category=='63') {$path = 'https://www.pornhub.com/feed/college-gay.xml';}
		elseif ($category=='64') {$path = 'https://www.pornhub.com/feed/creampie-gay.xml';}
		elseif ($category=='65') {$path = 'https://www.pornhub.com/feed/daddy-gay.xml';}
		elseif ($category=='66') {$path = 'https://www.pornhub.com/feed/euro-gay.xml';}
		elseif ($category=='67') {$path = 'https://www.pornhub.com/feed/fetish-gay.xml';}
		elseif ($category=='68') {$path = 'https://www.pornhub.com/feed/group-gay.xml';}
		elseif ($category=='69') {$path = 'https://www.pornhub.com/feed/hunks-gay.xml';}
		elseif ($category=='70') {$path = 'https://www.pornhub.com/feed/interracial-gay.xml';}
		elseif ($category=='71') {$path = 'https://www.pornhub.com/feed/japanese-gay.xml';}
		elseif ($category=='72') {$path = 'https://www.pornhub.com/feed/latino-gay.xml';}
		elseif ($category=='73') {$path = 'https://www.pornhub.com/feed/massage-gay.xml';}
		elseif ($category=='74') {$path = 'https://www.pornhub.com/feed/muscle-gay.xml';}
		elseif ($category=='75') {$path = 'https://www.pornhub.com/feed/pornstar-gay.xml';}
		elseif ($category=='76') {$path = 'https://www.pornhub.com/feed/public-gay.xml';}
		elseif ($category=='77') {$path = 'https://www.pornhub.com/feed/reality-gay.xml';}
	elseif ($category=='78') {$path = 'https://www.pornhub.com/feed/solo-male-gay.xml';}
	elseif ($category=='79') {$path = 'https://www.pornhub.com/feed/straight-guys-gay.xml';}
	elseif ($category=='80') {$path = 'https://www.pornhub.com/feed/twink-gay.xml';}
	elseif ($category=='81') {$path = 'https://www.pornhub.com/feed/vintage-gay.xml';}
	
	return $path;
}
 function tsw_scripts()
{    wp_register_script(  'tsw-js', plugin_dir_url( __FILE__ ) . '/tsw_js.js', array( /* dependencies*/ ), 1.0023, true  );
    }

add_action( 'wp_enqueue_scripts', 'tsw_scripts' );
function tsw_cleanData($c) 
{    return preg_replace('/\D/', '', $c);}
