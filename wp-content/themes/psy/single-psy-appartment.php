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
				<div class="psychological-appartment-in">
					<div class="side-bar">
						<?php
							$term = get_category(6);
							$cat_id = $term->term_taxonomy_id;
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
					</div>
					<!-- End side-bar -->

					<!-- Start about -->
					<div class="about-content">
					
						<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
						
						<div class="about-me about-me-appart-in">
							<?php $image_url = get_the_post_thumbnail( get_the_ID(), 'full'); ?>
							
							<?php if(!empty($image_url)){ ?>
								<h1 class="meet meet-appart-in"><?php echo $image_url; ?><?php the_title(); ?></h1>
							<?php }else{ ?>
								<h1 class="meet meet-appart-in"><img class="slid-object" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/art.png"><?php the_title(); ?></h1>
							<?php } ?>
							
							<?php the_content(); ?>

							<div class="topics-appartment topics-appartment-appart-in">
								<h3>Темы квартирника</h3>
								<?php 
									$args_link = array(
										'numberposts' => -1,
										'orderby'     => 'date',
										'order'       => 'DESC',
										'post_type'   => 'psy-appartment',
									);

									$links = get_posts( $args_link );

									foreach($links as $link){ setup_postdata($link);
										$image_link = get_the_post_thumbnail( $link->ID, 'full'); 
																			
										if($link->ID != get_the_ID()){ ?>
										
											<?php if(!empty($image_link)){ ?>
												<a href="<?php echo get_permalink($link->ID); ?>">
													<h6 class="first-them">
														<?php echo $image_link; ?>
														<?php echo $link->post_title; ?>
													</h6>
												</a>
											<?php }else{ ?>
												<a href="<?php echo get_permalink($link->ID); ?>">
													<h6 class="first-them">
														<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/art.png">
														<?php echo $link->post_title; ?>
													</h6>
												</a>
											<?php } ?>

								<?php
										}
									}
								?>
							</div>
							<?php
								$category = get_category(8);
								$category_id = $category->term_taxonomy_id;
								$category_data = get_option("category_$category_id");
							?>
							
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