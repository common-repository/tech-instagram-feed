<?php $tech_instagram = array();

$tech_instagram = array(
    'tech_insta_access_token' => '2019533071.3a81a9f.ba1f418e5da34abc869527cf13f1a5fa',
    'tech_insta_user_id' => '',
    'tech_feed_width' => '100',
	'tech_feed_width_unit' => '%',
    'tech_feed_height' => '100',
    'tech_feed_height_unit' => '%',
    'tech_feed_background_color' => '#fff',
	'tech_feed_sortby' => 'nosort',
	'tech_feed_number_feeds' => '20',
	'tech_feed_column' => '4',
	'tech_feed_padding' => '5',
	'tech_feed_padding_unit' => 'px',
	'tech_feed_header_information' =>'no',
    'tech_media_resolution' => 'StandardResolution',
	'tech_load_more_button_text' => 'Load More',
	'tech_load_more_button' => 1
    );

$tech_default_settings  = wp_parse_args(get_option('tech_settings'),$tech_instagram);
update_option('tech_settings',$tech_default_settings);
?>