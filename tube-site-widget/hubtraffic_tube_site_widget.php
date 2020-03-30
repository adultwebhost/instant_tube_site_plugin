<?php
/**
 * @package tube_site_widget
 * @version 0.2
 */
/*
Plugin Name: Instant Adult Website Widget WordPress Plugin
Plugin URI: https://plugin-demo.adultwebhost1.com/
Description: Instant Adult Tube Site With Content by integrating with Hubtraffic Resources.
Author: AdultWebHost1.com
Version: 0.2
Author URI: https://adultwebhost1.com
*/

// Add Shortcode
function tsw_main_shortcode( $atts ) {
	  static $already_run = false;
	   if ( $already_run !== true ) {
	wp_enqueue_script( 'tsw-js' );
	wp_enqueue_style( 'tsw-css' );
	// Attributes
	$atts = shortcode_atts(
		array(
			'category' => '82',
			'300x250_ad'=> '<a href="https://www.adultwebhost1.com" alt="Adult Web Hosting"><img src="https://www.adultwebhost1.com/wp-content/uploads/2018/12/AWH_300x250.png" height="250" width="300" alt="Adult Wordpress Hosting"></a>',
			'cw' => '300',
			'cm' => '10',
			'max_videos' => '30',
			'open_in_ph' => 'off',
		),
		$atts
	);
	$atts["max_videos"] = tsw_cleanData($atts["max_videos"]);
	$xmlfile = simplexml_load_file(tsw_category_path($atts["category"]));
	if ( $atts["max_videos"] > $xmlfile->channel->item->count()){$atts["max_videos"]= $xmlfile->channel->item->count();}
	$tsw_script_params = array( );
	 ob_start(); 
	echo '<style>.tsw_video_container{width:'. tsw_cleanData($atts["cw"]) .'px !important;margin:'. tsw_cleanData($atts["cm"]) .'px !important;}</style>';
		echo '<div class="tsw_container">';
	$i=0;
	foreach ($xmlfile->channel->item as $item) {
		if($i==$atts["max_videos"]){break;}
	
   echo '<div class="tsw_video_container" id="tsw_'. $i .'">';
		
		if ($atts["open_in_ph"] == 'on'){echo '<div class="tsw_thumbnail-image" style="position:relative;""><a target="_blank" href="' . $item->link . '"><img src="' . $item->thumb_large . '"></a>';}else {
			echo '<div class="tsw_thumbnail-image" style="position:relative;""><a onclick="return tsw_category_content(' . $i . ')" href="' . $item->link . '"><img src="' . $item->thumb_large . '"></a>';}
		
		
		echo '<div class="tsw_duration">' . tsw_minutes($item->duration) . ' </div></div>';
		
		if ($atts["open_in_ph"] == 'on'){echo '<div class="tsw_title"><a target="_blank" class="tsw_open-modal" href="' . $item->link . '">'. tsw_trim_characters($item->title) .'</a></div>';}else{
			echo '<div class="tsw_title"><a onclick="return tsw_category_content('. $i . ')" class="tsw_open-modal" href="' . $item->link . '">'. tsw_trim_characters($item->title) .'</a></div>';}
		
		
		echo '<div class="tsw_kw">' .tsw_trim_characters($item->keywords) . '</div>';
		
		if ($i=='6' || $i=='2' || $i=='11'){
			if ($atts["300x250_ad"] == 'none'){echo '</div>';}else {echo  '</div><div class="tsw_video_container" ><div class="tsw_bonus">'. $atts["300x250_ad"].'</div></div>';}
			
		}else {echo '</div>';}
		
		if (wp_is_mobile()){

			array_push($tsw_script_params, htmlentities($item->embed) . '<hr /><div class="tsw_video_container"><div class="tsw_bonus">'. $atts["300x250_ad"].'</div></div>');
		}else{
			array_push($tsw_script_params, htmlentities($item->embed) . '<hr /><div><div class="tsw_video_container"><div class="tsw_bonus">'. $atts["300x250_ad"].'</div></div><div class="tsw_video_container" ><div class="tsw_bonus">'. $atts["300x250_ad"].'</div></div></div>');
		}

		$i++;
}

	echo '</div>';
	    array_push($tsw_script_params, ob_get_clean());
	   }
	   $already_run = true;
	   wp_localize_script( 'tsw-js', 'tsw_scriptParams', $tsw_script_params );
	return end($tsw_script_params);
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
wp_register_style( 'tsw-css', plugin_dir_url( __FILE__ ) . '/tsw_css.css', array(), '1.0.0', 'all' );
    }

add_action( 'wp_enqueue_scripts', 'tsw_scripts' );
function tsw_cleanData($c) 
{    return preg_replace('/\D/', '', $c);}
