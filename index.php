<?php get_header(); ?>

<body <?php body_class(); ?> style="/*display:none;*/">

<?php output_theme_errors(); ?>

<div id="resume_action_button_container" class="fixed-action-btn">
    <a href="<?php echo(get_resume_file_uri());?>" class="btn-floating btn-large waves-effect waves-light red z-depth-2">
        <i class="large material-icons">description</i>
    </a>
    <ul>
        <li>
            <a id="link_to_website" class="btn-floating waves-effect waves-light blue" target="_blank" href="<?php echo home_url(); ?>">
                <i class="material-icons">link</i>
            </a>
        </li>
        <li>
            <a class="btn-floating waves-effect waves-light orange" onclick="printJS('<?php echo(get_resume_file_uri());?>');">
                <i class="material-icons">print</i>
            </a>
        </li>
        <li>
            <a href="mailto:GalGreenfield@gmail.com" class="btn-floating waves-effect waves-light green">
                <i class="material-icons">email</i>
            </a>
        </li>
        <li>
            <a id="download_resume_link" class="btn-floating waves-effect waves-light brown" target="_blank" href="<?php echo(get_resume_file_uri());?>" download>
                <i class="material-icons">file_download</i>
            </a>
        </li>
    </ul>
</div>

<header>

    <div id="introduction_background_image"></div>
    <div id="introduction_background_image_cover"></div>
    <div id="profile_section" class="card z-depth-4">
        <div class="card-content">
            <div id="profile_items_container">
                <?php
                display_profile_picture('profile-picture z-depth-2');
                ?>

                <p id="profile_full_name"><?php echo get_user_full_name(); ?></p>
                <div id="profile_description_tags">
                    <span class="profile-description-item">
                        <i style="font-style:normal;">Σ</i>
                        Mathematician
                    </span>
                    <span class="profile-description-item"><i class="fa fa-code"></i> Programmer<br></span>
                    <span class="profile-description-item"><i class="fa fa-lightbulb-o"></i> Thinker</span>
                    <span class="profile-description-item"><i class="fa fa-magic"></i> Creator</span>
                        <!--<span class="profile-description-item"><i class="fa fa-wrench"></i>Tinkerer</span>-->
                </div>

            </div>
            <div id="short_about_container">
                <p id="short_about">
                    <?php echo get_short_about_text(); ?>
                </p>
            </div>
        </div>
        <div class="card-action">
            <div class="social_icons_section">
                <a href="mailto:galgreenfield@gmail.com">
                    <i class="fa fa-envelope"></i>
                </a>
                <a href="tel:+972-52-636-3675">
                    <i id="call_me_button" class="fa fa-phone"></i>
                </a>
                <a href="http://stackoverflow.com/users/5094787/gal-gr%C3%BCnfeld">
                    <i class="fa fa-stack-exchange"></i>
                </a>
                <a href="https://stackexchange.com/users/6594572/gal-grünfeld?tab=accounts">
                    <i class="fa fa-stack-overflow"></i>
                </a>
                <a id="TeX_StackExchange_icon" href="https://tex.stackexchange.com/users/118996/gal-gr%C3%BCnfeld">
                    <span>{ }</span>
                </a>
            </div>
        </div>

    </div>

    

</header>



<?php
//region Navigation Menu
    wp_nav_menu( array(
    'menu' => 'Pages',
    'menu_class' => '',
    'container_id' => 'menu_pages_container',
    'container_class' => ' '
) );
//endregion
?>

<div id="pages-container">
    <?php display_all_pages(); ?>
</div>

<?php get_footer(); ?>


