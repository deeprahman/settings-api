<?php
/*
Plugin Name: Settings API example
Plugin URI: http://example.com/
Description: A complete and practical example of use of the Settings API
Author: DEEP Rahman
Author URI: http://wrox.com
 */

// Add a menu for our option page
add_action('admin_menu', 'boj_myplugin_add_page');
function boj_myplugin_add_page()
{
 add_options_page('My Plugin',
  'My Plugin',
  'manage_options',
  'boj_myplugin',
  'boj_myplugin_option_page');

}

// draw the options page
function boj_myplugin_option_page()
{
 ?>
    <div class="wrap">
    <?php //screen_icon()?>
    <h2>My Plugin</h2>
    <form action="options.php" method="post">

    <?php
//Takes care hidden fields, security checks and form redirection after submission
 settings_fields('boj_myplugin_options');
 //Outputs all sections and form fields that has been previously defined
 do_settings_sections('boj_myplugin');
 ?>
    <input type="submit" value="Save Changes" name="Submit">
    </form>
     </div>
    <?php
}

// Register and define settings
add_action('admin_init', 'boj_myplugin_admin_init');
function boj_myplugin_admin_init()
{
 register_setting(
  'boj_myplugin_options',
  'boj_myplugin_options',
  'boj_myplugin_validate_option'
 );

 add_settings_section(
  'boj_myplugin_main',
  'My Plugin Settings',
  'boj_myplugin_section_text',
  'boj_myplugin'
 );
 add_settings_field(
  'boj_myplugin_text_string',
  'Enter text here',
  'boj_myplugin_setting_input',
  'boj_myplugin',
  'boj_myplugin_main'
 );
}

// Explaination about this section
function boj_myplugin_section_text()
{
 echo '<p>Enter your settings here</p>';
}

// Display and fill the form field
function boj_myplugin_setting_input()
{
 // get option 'text_string' value from the database
 $option      = get_option('boj_myplugin_options');
 $text_string = $option['text_string'];
 // echo the field
 $boj_text_echo = <<<EOL
    <input id="text_string" name="boj_myplugin_options[text_string]" type="text" value="{$text_string}">
EOL;

 echo $boj_text_echo;
}

function boj_myplugin_validate_option($input)
{
 $valid['text_string'] = preg_replace(
  '/[^a-zA-Z]/',
  '',
  $input['text_string']
 );
 return $valid;
}