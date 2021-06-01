<?php

/**
 * Plugin Name:       CensorText
 * Description:       Automatic filtering of obscene expressions in articles.
 * Version:           1.0
 * Author:            emvadov
 */


 define('CENSORTEXT_DIR', plugin_dir_path(__FILE__));

function censortext_filter_text($the_content) {

    static $obsceneWords = array();
    static $filtered = " *Bad Word!* ";

    if( empty($obsceneWords) ) {
        $obsceneWords = explode(',', file_get_contents(CENSORTEXT_DIR . 'obscene_words.txt'));
    }


    for($i = 0, $c = count($obsceneWords); $i < $c;  $i++) {
        $the_content = preg_replace('#' .$obsceneWords[$i].'#ui', $filtered, $the_content);
    }

    return $the_content;

}

 
function censortext_plugin_setup_menu(){
    add_menu_page( 'CensorText Plugin Page', 'CensorText', 'manage_options', 'CensorText-plugin', 'censortext_init' );
}

function censortext_init() {
    echo "<h2>CensorText Plugin</h2>";

    // TO_DO
}

add_filter('the_content', 'censortext_filter_text');

add_action('admin_menu', 'censortext_plugin_setup_menu');


?>