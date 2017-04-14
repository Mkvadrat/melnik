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
				<div class="articles">
					<div class="side-bar">
						<?php
							$term = get_queried_object();
							$cat_id = $term->term_id;
							$cat_data = get_option("category_$cat_id");
						?>
						
						<?php echo wpautop(stripcslashes( $cat_data['text_for_categories_articles_page'] ), $br = false); ?>
						
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
							<h3><?php echo $cat_data['title_for_categories_articles_page']; ?></h3>
							
							<?php 
								$current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
								$args = array(
									'category'    => 6,
									'orderby'     => 'date',
									'order'       => 'DESC',
									'post_type'   => 'post',
									'suppress_filters' => true, 
									'posts_per_page' => $GLOBALS['wp_query']->query_vars['posts_per_page'],
									'paged'       => $current_page
								);

								$posts = get_posts( $args );

								foreach($posts as $post){ setup_postdata($post);
								$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
							?>
							<div class="small-news1 article-on-psychology">
								<a href="<?php echo get_permalink($post->ID); ?>">
									<?php if(!empty($image_url)){ ?>
										<img class="article-img-mini" src="<?php echo $image_url[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true ); ?>">
									<?php }else{ ?>
										<img class="article-img-mini" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/dipresiya.jpg" alt="">
									<?php } ?>
									
									<h5><?php echo $post->post_title; ?></h5>
									<p><?php echo wp_trim_words( $post->post_content, 15, '...' ); ?></p>
									<p class="date"><?php echo get_the_date( 'd.m.y', $post->ID ); ?></p>
								</a>
							</div>
							<?php
									
								}

								wp_reset_postdata();

								$defaults = array(
									'type' 		   => 'array',
									'prev_next'    => true,
									'show_all'     => false, 
									'end_size'     => 1,    
									'mid_size'     => 1,
								);
								
								$pagination = pg_links($defaults);
							?>
							
							<?php if($pagination){ ?>
								<div class="pagination">
									<ul>
									<?php foreach ($pagination as $pag){ ?>
										<li><?php echo $pag; ?></li>
									<?php } ?>
									</ul>
								</div>
							<?php } ?>
							
							<?php echo wpautop(stripcslashes( $cat_data['text_for_categories_articles_footer_page'] ), $br = false); ?>
							
							<a class="go-program contact-with-me contact-with-me-article" href="<?php echo get_permalink('108'); ?>">Узнать обо мне</a>
							<a class="go-program read-my-article read-my-articles" href="<?php echo get_permalink('12'); ?>">Связаться со мной</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
<?php get_footer(); ?>