<?php
/*
Template name: Main page
Theme Name: Melnik-psy
Theme URI: http://melnik-psy.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта melnik-psy.com
Version: 1.0
*/

get_header(); 
?>

	<?php if (have_posts()): while (have_posts()): the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>
		
	<div class="container pad-non">
		<div class="row">
			<div class="col-md-12 pad-non">
				<div class="new-article new-article-main">
					<h3>Новые статьи на сайте</h3>
					<div class="small-news-block">
					<?php 
						$args = array(
							'numberposts' => 3,
							'category'    => 6,
							'orderby'     => 'date',
							'order'       => 'DESC',
							'post_type'   => 'post',
							'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
						);

						$posts = get_posts( $args );

						foreach($posts as $post){ setup_postdata($post);
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
					?>
					<div class="small-news1">
						<a href="<?php echo get_permalink($post->ID); ?>">
							<?php if(!empty($image_url)){ ?>
								<img class="article-img-mini" src="<?php echo $image_url[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true ); ?>">
							<?php }else{ ?>
								<img class="article-img-mini" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/mak.jpg" alt="">
							<?php } ?>
							
							<h5><?php echo wp_trim_words( $post->post_title, 2, '...' ); ?></h5>
							<p><?php echo wp_trim_words( $post->post_content, 10, '...' ); ?></p>
							<p class="date"><?php echo get_the_date( 'd.m.y', $post->ID ); ?></p>
						</a>
					</div>
					<?php
							
						}

						wp_reset_postdata();
					?>
					</div>
					
					<?php 
						$args_single_post = array(
							'numberposts' => 1,
							'category'    => 6,
							'orderby'     => 'date',
							'order'       => 'DESC',
							'post_type'   => 'post',
							'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
						);

						$single_posts = get_posts( $args_single_post );

						foreach($single_posts as $single_post){ setup_postdata($single_post);
						$image_url_single = wp_get_attachment_image_src( get_post_thumbnail_id($single_post->ID), 'full');
					?>
					<div class="big-news">
						<?php if(!empty($image_url_single)){ ?>
							<img class="big-photo-news" src="<?php echo $image_url_single[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($single_post->ID), '_wp_attachment_image_alt', true ); ?>">
						<?php }else{ ?>
							<img class="big-photo-news" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/narushenia-pishevogo-povedenia.jpg" alt="">
						<?php } ?>
						<h4><?php echo wp_trim_words( $single_post->post_title, 6, '...' ); ?></h4>
						<p><?php echo wp_trim_words( $single_post->post_content, 10, '...' ); ?></p>
						<a class="more new-article-more" href="<?php echo get_permalink($single_post->ID); ?>">Подробнее</a>
					</div>
					<?php
							
						}

						wp_reset_postdata();
					?>
					
					
					<div class="form">
						<p class="name-f">Имя</p><p class="e-mail-f">E-mail</p>
						<input type="text" name="name" id="name"  size="25">
						<input type="text" name="email" id="email" size="25">
						<p class="text-message">Текст сообщения</p>
						<textarea name="comment" id="comment" cols="48" rows="8"></textarea>
						<input onclick="SendForm();" id="submit" type="submit" value="Отправить">
                    </div>
					
					<h3 class="cont-header">Контакты</h3>
					<p class="сontact-information">
						<span class="adr">Адрес:</span><br>
						<?php getMeta('adress_contacts_page'); ?><br>
						<span class="ph">Телефон:</span>
						<?php getMeta('phone_contacts_page'); ?>
						<span class="sk">Скайп:</span>
						<?php getMeta('skype_contacts_page'); ?>
					</p>
					
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>