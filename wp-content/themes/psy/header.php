<?php
/*
Theme Name: Melnik-psy
Theme URI: http://melnik-psy.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта melnik-psy.com
Version: 1.0
*/
?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->

<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo psy_wp_title('','', true, 'right'); ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/fonts.css">
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/style.css">

    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/media.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery-1.11.1.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery-ui-1.12.1/jquery-ui.min.css">
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/bootstrap.min.js"></script>
	<!--<script src="js/common.js"></script>-->

	<!-- FANCYBOX -->
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/js/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/js/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
	
	<!--SWEETALERT-->
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/js/sweetalert/dist/sweetalert.css">
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/sweetalert/dist/sweetalert.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<?php wp_head(); ?>
</head>
<body>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".menu-button").click(function() {
				$(".menu ul").slideToggle();
			});
		});
	</script>

	<!-- Start header -->
	<div class="container pad-non">
		<div class="row">
			<div class="col-md-12 pad-non">
				<header>
					<!-- Start menu line -->
					<div class="menu-line">
						<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<!--<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" alt="">-->
							<img
							  src="<?php header_image(); ?>"
							  height="<?php echo get_custom_header()->height; ?>"
							  width="<?php echo get_custom_header()->width; ?>"
							  alt="logotype"
							/>
							<?php getMeta('slogan_main_page'); ?>
						</a>
						<div class="social">

							<!-- <a href="#">

								<i class="fa fa-twitter"></i>

							</a> -->

							<a class="youtube" href="<?php getMeta('vk_groups_contacts_page'); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/youtube.jpg" alt=""></a>

							<a href="<?php getMeta('fb_groups_contacts_page'); ?>"><i class="fa fa-facebook-official"></i></a>

							<a href="<?php getMeta('vk_groups_contacts_page'); ?>"><i class="fa fa-vk" aria-hidden="true"></i></a>

						</div>
						<div class="contacts-line">
							<a class="online-support" href="contacts.html">Онлайн консультация</a>

							<div class="new-block">
								<?php getMetaText('online_consultation_main_page'); ?>
							</div>

							<span class="skype"><i class="fa fa-skype"></i><?php getMeta('skype_contacts_page'); ?></span>
							<span><i class="fa fa-phone"></i><?php getMeta('phone_contacts_page'); ?></span>
						</div>
						<div class="menu">
							<button type="button" class="menu-button hidden-md hidden-lg"><!--<i class="fa fa-bars"></i>--></button>
							<?php
									if (has_nav_menu('primary')){
										wp_nav_menu( array(
											'theme_location'  => 'primary',
											'menu'            => '',
											'container'       => false,
											'container_class' => '',
											'container_id'    => '',
											'menu_class'      => '',
											'menu_id'         => '',
											'echo'            => true,
											'fallback_cb'     => 'wp_page_menu',
											'before'          => '',
											'after'           => '',
											'link_before'     => '',
											'link_after'      => '',
											'items_wrap'      => '<ul>%3$s</ul>',
											'depth'           => 1,
											'walker'          => '',
										) );
									}
								?>
						</div>
					</div>
				</header>
			</div>
		</div>
	</div>
	<!-- End menu line -->