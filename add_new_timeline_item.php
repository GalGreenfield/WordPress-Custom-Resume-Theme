<?php
add_action( 'wp_ajax_test_timeline', 'prefix_ajax_add_foobar' );
function prefix_ajax_test_timeline() {
    // Handle request then generate response using WP_Ajax_Response
    echo 'hello, this is the response from add_new_timeline_item.php';

    /*
     $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'select_resume',
            array(
                'label'      => 'Select your resume file:',
                'settings' => 'select_resume',
                'section'  => 'resume_section',
                'description' => 'Supported file extensions: <br>' . implode(', ', get_supported_resume_file_extensions()),
            )
        )
    );
     */
    // Don't forget to stop execution afterward.
    //wp_die();
}
//prefix_ajax_test_timeline();


