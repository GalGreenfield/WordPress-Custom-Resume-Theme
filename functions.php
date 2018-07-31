<?php

//region functions.php File Structure
/*
 * (0) Theme Setup
 *
 * (1) Enqueue Styles & Scripts
 *
 * (2) Customize Pages Menu Items' URLs
 *
 * (3) Display All Pages
 *
 * (4) Supported Resume File Extensions
 *
 * (5) Customize Customizer
 *      (5.1) Display Toolbar if Admin
 *      (5.2) Add customizer sections, settings, controls
 *
 * (6) User assets URIs
 *
 * (7) Pass Variables to JavaScript
 *
 * (8) Errors
 *
 */
//endregion


//region (0) Theme Setup
if ( ! function_exists( 'theme_setup' ) ) :

		function theme_setup()
		{
			load_theme_textdomain( 'custom_resume', get_template_directory() . '/languages' );

			register_nav_menus( array(
				'primary'    => __( 'Pages', 'custom_resume' ),
				'secondary' => __('Social Links', 'custom_resume' )
			) );

			add_theme_support( 'title-tag' );

			add_theme_support( 'post-formats', array ( 'aside', 'gallery', 'quote', 'image', 'video' ) );
		}

endif; // theme_setup
add_action( 'after_setup_theme', 'theme_setup' );
//endregion


//region (*) Directories
$js_directory_uri = get_template_directory_uri() . '/js';
$plugins_folder_uri = get_template_directory_uri() . '/plugins';
$style_folder_uri = get_template_directory_uri() . '/style';
//endregion


//region (1) Enqueue Theme Scripts And Styles
function enqueue_theme_scripts_and_styles() {

    //region (1.1) Get Resources Directories
    global $js_directory_uri;
    global $plugins_folder_uri;
    global $style_folder_uri;
    //endregion

    //region (1.2) Enqueue Scripts
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'main_script', $js_directory_uri . '/main_script.js', array('jquery'), '1.0', false );
    wp_enqueue_script( 'materialize.js', $style_folder_uri . '/materialize/js/materialize.min.js', array('jquery'), '0.100.2', false );
    wp_enqueue_script( 'print.js', $plugins_folder_uri . '/Print.js-1.0.18/dist/print.min.js', array('jquery'), false, false );
    wp_enqueue_script( 'circle_progress', $plugins_folder_uri . '/jquery-circle-progress-1.2.2/dist/circle-progress.min.js', array('jquery'), '1.2.2', false );
    wp_enqueue_script( 'circle_progress_config', $js_directory_uri . '/circle_progress_config.js', array('jquery'), false, false );
    wp_enqueue_script( 'scroll_reveal', $js_directory_uri . '/scroll_reveal.min.js', array('jquery'), '3.3.1', false, false );
    #wp_enqueue_script( 'img_to_svg', get_template_directory_uri() . '/js/img_to_svg.js', array('jquery'), '1.0', false );
    #wp_enqueue_script( 'mathjax', get_template_directory_uri() . '/plugins/MathJax/MathJax.js', array('jquery'), false, false );
    #wp_enqueue_script( 'mathjax_config', $plugins_folder_path . '/MathJax/config/default.js', array('jquery'), false, false );
    #wp_enqueue_script( 'vertical_fixed_navigation_js', $plugins_folder_uri . '/vertical-fixed-navigation/js/main_edited.js', array('jquery'), false, false);
    #wp_enqueue_script( 'modernizr', $plugins_folder_uri . '/vertical-fixed-navigation/js/modernizr.js' , array(), '3.5.0', false );
    //endregion

    //region (1.3) Enqueue Theme Styles
    wp_enqueue_style( 'main_stylesheet', get_stylesheet_uri() );
    wp_enqueue_style( 'materialize', $style_folder_uri . '/materialize/css/materialize.min.css', array(), false, 'all' );
    #wp_enqueue_style( 'vertical_fixed_navigation_css_reset', $plugins_folder_uri . '/vertical-fixed-navigation/css/reset.css', false, 'all' );
    #wp_enqueue_style( 'vertical_fixed_navigation_css', $plugins_folder_uri . '/vertical-fixed-navigation/css/style_edited.css', false, 'all' );
    wp_enqueue_style( 'timeline_style' , $style_folder_uri . '/timeline_style.css' );
    //endregion

    //region (1.4) Enqueue Theme Icons
    wp_enqueue_style( 'material_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), false, 'all' );
    wp_enqueue_style( 'font_awesome', $style_folder_uri . '/font-awesome/css/font-awesome.min.css', array(), false, 'all' );
    wp_enqueue_style( 'my_fontastic_icons', 'https://file.myfontastic.com/hpY8BQnYr5G8TUG6oJPWzL/icons.css', array(), false, 'all' );
    //endregion

    //region (1.5) Enqueue Theme Fonts
    wp_enqueue_style( 'cmu_concrete', $style_folder_uri . '/fonts/computer-modern/cmun-concrete/cmun-concrete.css', array(), false, 'all' );
    //endregion

}
if ( !is_customize_preview() ) {
    add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts_and_styles' );
}
//endregion


//region (2) Customize Pages Menu Items' URLs
function add_menu_atts( $atts, $item, $args ) {
    $url = $item->url;

    $id = str_replace(site_url(), '', $url);
    $id = str_replace('/', '', $id);
    $id = str_replace('-', '_', $id);

    $new_url = '#' . $id;

    $item->url  = $new_url;
    $atts['href'] = $new_url;

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_atts', 10, 3 );
//endregion


//region (3) Display All Pages
function display_all_pages() {

    $pages = get_pages( array( 'sort_column'=>'menu_order' ));
    foreach ($pages as $page) {

        $id = $page->post_title;
        $id = str_replace('-', '', $id);
        $id = str_replace('(', '', $id);
        $id = str_replace(')', '', $id);
        $id = strtolower(str_replace(' ', '_', $id));
        if (strpos($id, 'about') !== false) {
            $id = 'about';
        }

        $class = "page";

        $content = $page->post_content;
        $content = do_shortcode($content);

        echo ('<section ' . 'id="' . $id . '"' . 'class="' . $class . '">' . $content . '</section>');

    }
}
//endregion


//region (4) Supported File Extensions
    function get_supported_resume_file_extensions() {
        $supported_resume_file_extensions = array();
        array_push($supported_resume_file_extensions, 'pdf');
        return $supported_resume_file_extensions;
    }
    function get_supported_profile_picture_file_extensions() {
        $supported_profile_picture_file_extensions = array();
        array_push($supported_profile_picture_file_extensions, 'png');
        array_push($supported_profile_picture_file_extensions, 'jpg');
        return $supported_profile_picture_file_extensions;
    }
//endregion


//region (*) Admin-Specific Things
function hide_toolbar_if_not_admin() {
    if ( !current_user_can('administrator') || !is_admin() ) {
        show_admin_bar(false);
    }
}

do_action( 'customize_register', 'hide_toolbar_if_not_admin' );
//endregion


//region (5) Customize the Customizer
if (is_customize_preview()) {

    function theme_customize_register($wp_customize) {

    //region (5.2) Add Customizer sections, settings, controls

        //region (5.2.1) Add Resume to the Customizer
        function add_resume_file_set_to_customizer($wp_customize) {
        $wp_customize->add_section(
            'resume_section',
            array(
                'title'       => 'Resume',
                'priority'  => '1',
            )
        );
        $wp_customize->add_setting(
            'select_resume',
            array(
                'default'        => '',
            )
        );
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
    }
        add_resume_file_set_to_customizer($wp_customize);
        //endregion

        //region (5.2.2) Add Profile Picture to the Customizer
        function add_profile_picture_to_customizer($wp_customize) {
        $wp_customize->add_section(
            'profile_picture_selection',
            array(
                'title'       => 'Profile Picture',
                'priority'  => '0',
            )
        );
        $wp_customize->add_setting(
            'select_profile_picture',
            array(
                'default'        => '',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'select_profile_picture',
                array(
                    'label'      => 'Profile Picture',
                    'settings' => 'select_profile_picture',
                    'section'  => 'profile_picture_selection',
                )
            )
        );
    }
        add_profile_picture_to_customizer($wp_customize);
        //endregion

        //region (5.2.3) Add the Short About Text to the Customizer
        function add_short_about_text_to_customizer($wp_customize) {
        $wp_customize->add_section(
            'short_about' ,
            array(
                'title'      => 'Short About',
                'priority'   => 3,
            )
        );
        $wp_customize->add_setting(
            'write_short_about',
            array(
                'default'        => '',
            )
        );
        $wp_customize->add_control(
            'short_about_textarea',
            array(
                'label'    => 'Write about yourself shortly:',
                'section'  => 'short_about',
                'settings' => 'write_short_about',
                'type'     => 'textarea',
                'default' => 'Write about yourself shortly!'
            )
        );

    }
        add_short_about_text_to_customizer($wp_customize);
        //endregion

        //region (5.2.4) Add the User's Full Name to the Customizer
        function add_user_full_name_to_customizer($wp_customize) {
        $wp_customize->add_section(
            'user_full_name' ,
            array(
                'title'      => 'Your Name',
                'priority'   => 4,
            )
        );
        $wp_customize->add_setting(
            'user_full_name_set',
            array(
                'default'        => '',
            )
        );
        $wp_customize->add_control(
            'user_full_name_text',
            array(
                'label'    => "Enter your full name:",
                'section'  => 'user_full_name',
                'settings' => 'user_full_name_set',
                'type'     => 'text',
                'default' => ''
            )
        );
    }
        add_user_full_name_to_customizer($wp_customize);
        //endregion

        //region (5.3.5) Add Timeline Interface to the Customizer

        //Todo: Organize the code such that first there are the classes, then the panel is created, then the new custom section, and test everything. If it works, delete excess code.

        //region (5.3.5.1) Define Timeline Interface Custom Customizer Controllers

            class WP_Customize_Timeline_New_Item_Section extends WP_Customize_Section {

                public $type = 'new_timeline_item';

                protected function render() {
                    ?>
                    <!--Make sure that all the class names are aligned with the class names of WordPress's-->
                    <div class="row">
                    <li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="accordion-section-new-timeline-item">
                        <button type="button" class="add-new-timeline-item btn waves-effect waves-light" aria-expanded="false">
                            <?php echo esc_html( $this->title ); ?>
                            <i class="material-icons left">add</i>
                        </button>
                    </li>
                    </div>

                    <ul class="new-timeline-item-section-content">
                        <li id="customize-control-new_menu_name" class="customize-control customize-control-text" style="display: list-item;">
                            <div class="customize-control-notifications-container" style="">
                                <ul>
                                </ul>
                            </div>
                            <div class="input-field col">
                                <input id="new_timeline_item_name" type="text">
                                <label for="new_timeline_item_name">Name</label>
                            </div>
                        </li>
                        <li id="customize-control-create_new_menu" class="customize-control customize-control-new_menu" style="display: list-item;">
                            <div class="customize-control-notifications-container" style="">
                                <ul>
                                </ul>
                            </div>
                            <button  id="create_new_menu_submit_button" type="button" class="btn blue waves-effect waves-light">Add to <Timeline></Timeline></button>
                            <span class="spinner"></span>
                        </li>
                    </ul>

                    <!--
                        <div id="add_new_timeline_item_container">
                            <div class="file-field input-field">
                                <input id="new_timeline_item_name" class="validate" type="text">
                                <label for="new_timeline_item_name"><?php #echo esc_html( $this->label ); ?></label>
                            </div>
                            <a id="add_new_timeline_item" class="btn-floating waves waves-effect">
                                <i class="material-icons">add</i>
                            </a>
                        </div>
                    -->

                    <!-- Original core code for what appears after clicking on the `add menu` button-->
                    




                    <?php
                }

            }

            /*
            class Timeline_Item_New_Add_Control extends WP_Customize_Control {

                public $type = 'timeline_item_new_add_control';

                protected function render() {
                    $id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
                    $class = 'customize-control customize-control-' . $this->type;
                    ?>

                    <li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
                        <?php $this->render_content(); ?>
                    </li>

                    <?php
                }

                public function render_content() {

                    ?>

                    <!--Check why running this code doesn't work on main_script.js-->
                    <!--region Script to customize the Customizer-->

                    <!--endregion-->


                    <div id="add_new_timeline_item_container">
                        <div class="file-field input-field">
                            <input id="new_timeline_item_name" class="validate" type="text">
                            <label for="new_timeline_item_name"><?php echo esc_html( $this->label ); ?></label>
                        </div>
                        <a id="add_new_timeline_item" class="btn-floating waves waves-effect">
                            <i class="material-icons">add</i>
                        </a>
                    </div>


                    <?php

                }

            }
            */

            //endregion

            function add_timeline_interface_to_customizer($wp_customize) {

                $wp_customize->add_panel(
                    'timeline_panel',
                    array(
                        'title' => 'Timeline',
                        'priority' => 1,
                    )
                );

                $wp_customize->add_section(
                    new WP_Customize_Timeline_New_Item_Section(
                        $wp_customize,
                        'add_timeline_item_section',
                        array(
                            'panel'    => 'timeline_panel',
                            'title'    => 'New Timeline Item',
                            'priority' => 999,
                        )
                    )
                );

                $wp_customize->add_setting(
                    'add_timeline_item_setting',
                    array(
                        'default' => '',
                    )
                );

                $wp_customize->add_control(
                    'add_timeline_item_control',
                    array(
                        'label'    => "Control Test Two",
                        'section'  => 'add_timeline_item_section',
                        'settings' => 'add_timeline_item_setting',
                        'type'     => 'text',
                        'default' => ''
                    )
                );

                /*
                               $wp_customize->add_section(
                                   'section_test',
                                   array(
                                       'panel' => 'timeline_panel',
                                       'title' => 'Section Test',
                                       'priority' => 1,

                                   )
                               );

                               $wp_customize->add_setting(
                                   'setting_test',
                                   array(
                                       'default' => '',
                                   )
                               );

                                $wp_customize->add_control(
                                    'control_test',
                                    array(
                                        'label'    => "Control Test",
                                        'section'  => 'section_test',
                                        'settings' => 'setting_test',
                                        'type'     => 'text',
                                        'default' => ''
                                    )
                                );
                                */



            //region (5.3.5.1) Add A Timeline Interface Section

            /*
            $wp_customize->add_section( 'timeline_section' , array(
                //'panel' => 'timeline_panel',
                'title' => 'test',
                //'priority' => 1,
            ) );
            */

            //endregion

            //region (5.3.5.2) Add A Timeline Interface Setting

            /*
            $wp_customize->add_setting(
                'timeline_setting', array(
                    'default' => '',
                )
            );
            */
            //endregion

            //region (5.3.5.3) Timeline Interface Custom Customizer Controls



                //region (5.3.5.3.2) Add The Timeline Interface Customizer Controls to the Customizer

                /*
                $wp_customize->add_control(new Timeline_Item_New_Add_Control($wp_customize,
                    'timeline_add_item',
                    array(
                        'label'   => __('Name', 'custom_resume'), //replaces 'Name' with a translation for 'Name' based on language
                        'section' => 'timeline_section',
                        'settings'   => 'timeline_setting',
                    )
                ) );
                */





                //Create new Control if a request for it is received (such requests are sent via jQuery AJAX requests)

                //endregion
            
            //endregion

        }
        add_timeline_interface_to_customizer($wp_customize);
        //endregion

    //region (5.*) Enqueue Customizer Page Styles And Scripts

        //region (5.*.1) Enqueue Theme Styles And Scripts
        enqueue_theme_scripts_and_styles();
        //endregion

        //region(5.*.2) Enqueue Customizer-Specific Scripts & Styles

        add_filter( 'allowed_http_origins', 'add_allowed_origins' );
        function add_allowed_origins( $origins ) {
            $origins[] = admin_url();
            $origins[] = get_template_directory_uri();
            return $origins;
        }

        /**
         *
         */
        function enqueue_customizer_scripts() {

            global $js_directory_uri;
            global $plugins_folder_uri;
            global $style_folder_uri;

            //wp_enqueue_script( 'jquery_ui', $plugins_folder_uri . '/jquery-ui-1.12.1.custom/jquery-ui.min.js', array('jquery'), '1.12.1', true );
            wp_register_script( 'customize_customizer', $js_directory_uri . '/customize_customizer.js', array('jquery'), false, true );
            wp_localize_script( 'customize_customizer', 'profile_picture_uri', get_profile_picture_file_uri() );
            wp_enqueue_script( 'customize_customizer' );

            wp_enqueue_script( 'materialize_js', $style_folder_uri . '/materialize/js/materialize.min.js', array('jquery'), false, false );

            wp_register_script( 'add_new_timeline_item', $js_directory_uri . '/add_new_timeline_item.js', array('jquery'), false, true );
            wp_localize_script( 'add_new_timeline_item', 'add_new_item_php_path', get_template_directory() . '/add_new_timeline_item.php');
            //wp_localize_script( 'add_new_timeline_item', 'add_new_item_php_uri', admin_url('add_new_timeline_item.php') );
            wp_localize_script( 'add_new_timeline_item', 'add_new_item_php_uri', str_replace('/wp-admin', '', admin_url('add_new_timeline_item.php')) );

            //wp_localize_script( 'add_new_timeline_item', 'add_new_item_php_uri', 'add_new_timeline_item.php');
            //wp_localize_script( 'add_new_timeline_item', 'site_url', admin_url('') );
            wp_enqueue_script( 'add_new_timeline_item' );

            //include_once('add_new_timeline_item.php');

        }
        add_action( 'customize_controls_print_scripts', 'enqueue_customizer_scripts' );

        /*
        add_action( 'wp_ajax_test', 'prefix_ajax_add_foobar' );
        function prefix_ajax_test() {
            // Handle request then generate response using WP_Ajax_Response
            echo 'hello, this is the response from functions.php';

            // Don't forget to stop execution afterward.
            //wp_die();
        }
        prefix_ajax_test();
        */

        //require_once('add_new_timeline_item.php');



        function enqueue_customizer_styles() {

            global $js_directory_uri;
            global $plugins_folder_uri;
            global $style_folder_uri;

            //wp_enqueue_style( 'jquery_ui',  $plugins_folder_uri . '/jquery-ui-1.12.1.custom/jquery-ui.min.css', array(), false, 'all');
            wp_enqueue_style( 'customizer_style', $style_folder_uri . '/customizer_style.css', array(), false, 'all' );

        }
        add_action( 'customize_controls_print_styles', 'enqueue_customizer_styles' );

        //endregion

    }
    //endregion

    //endregion

}
add_action('customize_register', 'theme_customize_register');
//endregion


//region (6) User Assets
    function get_resume_file_uri() {
        $resume_file_uri = wp_get_attachment_url (get_theme_mod('select_resume'));
        return $resume_file_uri; // If a resume file was not uploaded, returns false
    }
    function get_default_profile_picture_file_uri() {
        $default_profile_picture_file_uri = (get_template_directory_uri() . '/style/icons/ic_account_circle_black_24px.svg'); 
        return $default_profile_picture_file_uri;
    }
    function get_profile_picture_file_uri() {
        $profile_picture_file_uri = wp_get_attachment_url(get_theme_mod('select_profile_picture'));
        return $profile_picture_file_uri; // If a profile picture file was not uploaded, returns '' (empty string).
    }
    function get_short_about_text() {
        $short_about_text = get_theme_mod('write_short_about');
        return $short_about_text;
    }
    function display_profile_picture($class) {
        $url = wp_get_attachment_url(get_theme_mod('select_profile_picture'));

        if ($url == '' || $url == false) { // $uri == '' ==> no profile picture was uploaded
            $default_profile_picture_file_url = get_template_directory_uri() . '/style/icons/ic_account_circle_black_24px.svg';
            $url = $default_profile_picture_file_url;
            $svg_content = file_get_contents($url);
            echo $svg_content;
        }
        else {
            echo '<img src="' . $url . '" class="'.$class.'">';
        }
    }
    function get_user_full_name() {
        $user_full_name = get_theme_mod('user_full_name_set');
        return $user_full_name;
    }
//endregion


//region (7) Pass Data to JavaScript
    function localize_scripts() {
        wp_localize_script('main_script', 'vars_from_php', array(
                'resume_file_uri' => get_resume_file_uri(),
                'profile_picture_file_uri' => get_profile_picture_file_uri()
            )
        );
    }
    add_action('wp_enqueue_scripts', 'localize_scripts');
//endregion


//region (8) Errors
    function output_theme_errors() {

        function output_theme_error($error_type, $error_text) {
            if ($error_type == 'resume') {
                $error_icon_type = 'insert_drive_file';
            }
            if ($error_type == 'profile_picture') {
                $error_icon_type = 'account_circle';
            }
            if ($error_type = 'short_about_text') {
                $error_icon_type = 'create';
            }
            $error = '<a class="error card horizontal" href="' . site_url() . '/wp-admin/customize.php">';
            $error .= <<<EOT
            <div class="error-icon-container">
                <i class="error-icon material-icons">$error_icon_type</i>
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <p>
                        $error_text
                    </p>
                </div>        
            </div>
        </a>
EOT;
            echo $error;
        }

        /* Check if there are errors to display */

        $errors_to_display['resume'] = array();
        $errors_to_display['profile_picture'] = array();
        $errors_to_display['short_about_text'] = array();

        $errors_to_display['resume']['no_resume_selected'] = array();
        $errors_to_display['resume']['no_resume_selected'] = false;

        $errors_to_display['resume']['file_extension_unsupported'] = array();
        $errors_to_display['resume']['file_extension_unsupported'] = false;

        $errors_to_display['profile_picture']['no_profile_picture_selected'] = array();
        $errors_to_display['profile_picture']['no_profile_picture_selected'] = false;

        $errors_to_display['short_about_text']['no_short_about_text_inserted'] = array();
        $errors_to_display['short_about_text']['no_short_about_text_inserted'] = false;

        $resume_file_uri = get_resume_file_uri();
        if ($resume_file_uri == false) { // Resume file's URI is not empty ⟹ A resume file was uploaded
            $errors_to_display['resume']['no_resume_selected'] = true;
        }

        $supported_resume_file_formats = get_supported_resume_file_extensions();
        $resume_file_extension = pathinfo($resume_file_uri, PATHINFO_EXTENSION);
        if(in_array($resume_file_extension, $supported_resume_file_formats) == false) {
            $errors_to_display['resume']['file_extension_unsupported'] = true;
        }

        $profile_picture_file_uri = get_profile_picture_file_uri();
        if($profile_picture_file_uri == false) { // Profile picture file's URI is not empty ⟹ A resume file was uploaded
            $errors_to_display['profile_picture']['no_profile_picture_selected'] = true;
        }

        $short_about_text = get_short_about_text();
        if ($short_about_text == false) { // Short about text is empty or not inserted at all
            $errors_to_display['short_about_text']['no_short_about_text_inserted'] = true;
        }

        /* Check if there are errors to display */


        /* Print errors to display in a container, and don't print anything if there aren't any errors to display */

        $errors_to_display_counters = array();
        $errors_to_display_counters['resume'] = 0;
        foreach ($errors_to_display['resume'] as $display_resume_errors) { // Check more elements of $errors_to_display later
            if ($display_resume_errors == true) {
                $errors_to_display_counters['resume'] += 1;
            }
        }
        $errors_to_display_counters['profile_picture'] = 0;
        foreach ($errors_to_display['profile_picture'] as $display_profile_picture_errors) {
            if ($display_profile_picture_errors == true) {
                $errors_to_display_counters['profile_picture'] += 1;
            }
        }
        $errors_to_display_counters['short_about_text'] = 0;
        foreach ($errors_to_display['short_about_text'] as $display_short_about_text_errors) {
            if ($display_short_about_text_errors == true) {
                $errors_to_display_counters['short_about_text'] += 1;
            }
        }

        if (
            $errors_to_display_counters['resume'] > 0 ||
            $errors_to_display_counters['profile_picture'] > 0 ||
            $errors_to_display_counters['short_about_text'] > 0
        ) { // ⟹ there are errors to display
            echo '<div id="resume_errors_container">';
            if ($errors_to_display['resume']['no_resume_selected'] == true) {
                $no_resume_selected_error_text = <<<EOT
                Hey, you didn't select a resume! <br>
                Click to select one.
EOT;
                output_theme_error('resume', $no_resume_selected_error_text);
            }
            if ($errors_to_display['resume']['file_extension_unsupported'] == true) {
                $resume_file_ext_unsupported_error_text = <<<EOT
                Sorry, your resume's file type is not supported. <br>
                Please select a resume of a different file tye.
EOT;
                output_theme_error('resume', $resume_file_ext_unsupported_error_text);
            }
            if ($errors_to_display['profile_picture']['no_profile_picture_selected'] == true) {
                $no_profile_picture_selected_error_text = <<<EOT
                Hey, you didn't select a profile picture! <br>
                Click to select one.
EOT;
                output_theme_error('profile_picture', $no_profile_picture_selected_error_text);

            }
            if ($errors_to_display['short_about_text']['no_short_about_text_inserted'] == true) {
                $no_short_about_text_inserted_error_text = <<<EOT
                Hey, you didn't write a short About text! <br>
                Click to write one.
EOT;
                output_theme_error('short_about_text', $no_short_about_text_inserted_error_text);
            }
            echo '</div>';
        }

        /* Print errors to display in a container, and don't print anything if there aren't any errors to display */

    }
//endregion