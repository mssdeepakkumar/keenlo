<?php
// —————Add Settings to General Settings—————–
function social_settings_api_init() {
// Add the section to general settings so we can add our
// fields to it
add_settings_section('social_setting_section',
'<br>Social',
'social_setting_section_callback_function',
'general');
// Add the field with the names and function to use for our new
// settings, put it in our new section
add_settings_field('general_setting_facebook',
'Facebook Page',
'general_setting_facebook_callback_function',
'general',
'social_setting_section');
// Register our setting so that $_POST handling is done for us and
// our callback function just has to echo the <input>
register_setting('general','general_setting_facebook');
add_settings_field('general_setting_twitter',
'Twitter Account',
'general_setting_twitter_callback_function',
'general',
'social_setting_section');
register_setting('general','general_setting_twitter');
add_settings_field('general_setting_googleplus',
'Google Plus Page',
'general_setting_googleplus_callback_function',
'general',
'social_setting_section');
register_setting('general','general_setting_googleplus');
add_settings_field('general_setting_youtube',
'YouTube Page',
'general_setting_youtube_callback_function',
'general',
'social_setting_section');
register_setting('general','general_setting_youtube');
add_settings_field('general_setting_linkedin',
'LinkedIn Page',
'general_setting_linkedin_callback_function',
'general',
'social_setting_section');
register_setting('general','general_setting_linkedin');
}
add_action('admin_init', 'social_settings_api_init');


// —————-Settings section callback function———————-
function social_setting_section_callback_function() {
echo '<p></p>';
}
function general_setting_facebook_callback_function() {
echo '<input name="general_setting_facebook" id="general_setting_facebook" type="text" value="'. get_option('general_setting_facebook') .'" />';
}
function general_setting_twitter_callback_function() {
echo '<input name="general_setting_twitter" id="general_setting_twitter" type="text" value="'. get_option('general_setting_twitter') .'" />';
}
function general_setting_googleplus_callback_function() {
echo '<input name="general_setting_googleplus" id="general_setting_googleplus" type="text" value="'. get_option('general_setting_googleplus') .'" />';
}
function general_setting_youtube_callback_function() {
echo '<input name="general_setting_youtube" id="general_setting_youtube" type="text" value="'. get_option('general_setting_youtube') .'" />';
}
function general_setting_linkedin_callback_function() {
echo '<input name="general_setting_linkedin" id="general_setting_linkedin" type="text" value="'. get_option('general_setting_linkedin') .'" />';
}
?>