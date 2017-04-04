<?php
/*
Theme Name: Melnik-psy
Theme URI: http://melnik-psy.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта melnik-psy.com
Version: 1.0
*/

get_header(); 
?>

    <div class="container pad-non">
		<div class="row">
			<div class="col-md-12 pad-non">
				<!-- Start about -->

				<div class="contacts">

					<div class="about-content">

						<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>

						<div class="page-404">
							<p class="error-404">Ошибка 404</p>

							<p class="page-not-found">Страница не найдена</p>

							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>