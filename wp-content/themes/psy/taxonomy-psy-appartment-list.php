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
			<!-- Start side-bar -->
			<div class="psychological-appartment">

				<div class="side-bar">
					<?php
						$term = get_category(6);
						$cat_id = $term->term_taxonomy_id;
						$cat_data = get_option("category_$cat_id");
					?>
					
					<?php echo stripcslashes( $cat_data['text_for_categories_articles_page'] ); ?>
					
					<div class="form">
							<p class="name-f">Имя</p><p class="e-mail-f">E-mail</p>
							<input type="text" name="name" id="name"  size="25">
							<input type="text" name="email" id="email" size="25">
							<p class="text-message">Текст сообщения</p>
							<textarea name="comment" id="comment" cols="48" rows="8"></textarea>
							<input onclick="SendForm();" id="submit" type="submit" value="Отправить">
					</div>

					<div class="new-articles-on-the-site">
						<h3>Новые статьи на сайте</h3>
						<?php 
							$args_input = array(
								'numberposts' => 3,
								'category'    => 6,
								'orderby'     => 'date',
								'order'       => 'DESC',
								'post_type'   => 'post',
								'suppress_filters' => true, 
							);

							$articles_line = get_posts( $args_input );

							foreach($articles_line as $post){ setup_postdata($post);
						?>
						<div class="small-news1 small-news1-about">
							<a href="<?php echo get_permalink($post->ID); ?>">
								<h5><?php echo wp_trim_words( $post->post_title, 2, '...' ); ?></h5>
								<p><?php echo wp_trim_words( $post->post_content, 13, '...' ); ?></p>
								<p class="date"><?php echo get_the_date( 'd.m.y', $post->ID ); ?></p>
							</a>
						</div>
						<?php
									
							}

							wp_reset_postdata();
						?>
					</div>
					
					<?php
					$term_id = 9;
					
					$term_link = get_term_link($term_id, 'spanish-group-list');
					?>
					
					<a class="advertising" href="<?php echo $term_link; ?>">
					<h3 class="advertising-title">Испанская группа</h3>
					<p>Групповые терапевтические встречи <b>в Испании с 21 по 27 октября 2017</b></p>
					</a>
				</div>
				<!-- End side-bar -->

				<!-- Start about -->
				<div class="about-content">

					<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>

					<div class="about-me">
						<?php
							$category = get_category(8);
							$category_id = $category->term_taxonomy_id;
							$category_data = get_option("category_$category_id");
						?>
						
						<h3><?php echo stripcslashes( $category_data['title_for_categories_psy_appartment_list_page'] ); ?></h3>
						
						<?php echo stripcslashes( $category_data['text_for_categories_psy_appartment_list_page'] ); ?>

						<!-- End slider -->
						<?php 
							$args_list = array(
								'numberposts' => -1,
								'orderby'     => 'date',
								'order'       => 'DESC',
								'post_type'   => 'psy-appartment',
							);

							$articles = get_posts( $args_list );

							foreach($articles as $post){ setup_postdata($post);
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
						?>
						
						<div class="cinema-сlub sand">
							<a class="title" href="<?php echo get_permalink($post->ID); ?>">
							
							<?php if(!empty($image_url)){ ?>
								<img class="slid-object" src="<?php echo $image_url[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true ); ?>">
							<?php }else{ ?>
								<img class="slid-object" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/art.png">
							<?php } ?>

							<h4><?php echo $post->post_title; ?></h4></a>
							<p><?php echo wp_trim_words( $post->post_content, 40, '' ); ?></p>
							<a class="go-program more-group" href="<?php echo get_permalink($post->ID); ?>">Подробнее</a>
						</div>
						
						<?php } ?>
						
						<?php echo wpautop(stripcslashes( $category_data['text_for_categories_psy_appartment_list_footer_page'] ), $br = false); ?><br>

						<a class="go-program contact-with-me contact-with-me-article" href="<?php echo get_permalink('108'); ?>">Узнать обо мне</a>
						<a class="go-program read-my-article read-my-articles" href="<?php echo get_permalink('12'); ?>">Связаться со мной</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
