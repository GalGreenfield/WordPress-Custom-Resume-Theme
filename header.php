<?php /** @package WordPress @subpackage Default_Theme  **/
header("Access-Control-Allow-Origin: *");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="theme-color" content="#020262" />
    <title><?php bloginfo( 'name' ) . '|' . wp_title(); ?></title>
	<?php wp_head(); ?>

</head>