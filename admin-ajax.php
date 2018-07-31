<?php

add_action('wp_ajax_my_action', 'my_action');
add_action('wp_ajax_nopriv_my_action', 'my_action');

function my_action() {

    /*
    $response = array(
            'what'=>'foobar',
        'action'=>'update_something',
        'id'=>'1',
        'data'=>'<p><strong>Hello world!</strong></p>'
    );
    $xmlResponse = new WP_Ajax_Response($response);
    $xmlResponse->send();
    */
    echo 'test';

    wp_die(); // this is required to terminate immediately and return a proper response
    // Handle request then generate response using WP_Ajax_Response

    // Don't forget to stop execution afterward.
    //wp_die();
}