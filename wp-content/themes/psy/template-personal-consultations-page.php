<?php
/*
Template name: Personal consultations
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
				<div class="personal-consultations">
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

						<div class="about-me">

							<?php the_title('<h3>', '</h3>'); ?>

							<?php the_content(); ?>

							<div class="form personal-consultations-form personal-consultations-form-small">

								<h5>Записаться на консультацию</h5>

								<div>
									<p class="name-f">Имя</p>
									<p class="surname-f">Фамилия</p>

									<input type="text" name="name" id="name_consultation" class="name" size="25">

									<input type="text" name="surname" id="surname_consultation" class="surname" size="25">

									<p class="e-mail-f">E-mail</p>
									<p class="day">Выбрать дату</p>

									<input type="text" name="email" id="email_consultation" class="email" size="25">

									<input type="text" name="datepicker" id="datepicker" size="25">

									<p class="text-message">Текст сообщения</p>

									<textarea name="comment" id="comment_consultation" class="comment" cols="48" rows="8" onfocus=" placeholder='';"></textarea>

									<input onclick="appointmentConsultation();" id="submit" type="submit" value="Отправить">
								</div>
								<script type="text/javascript">
									//локализация календаря
									$.datepicker.regional['ru'] = {
										closeText: 'Закрыть',
										prevText: '&#x3c;Пред',
										nextText: 'След&#x3e;',
										currentText: 'Сегодня',
										monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
										monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'],
										dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
										dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
										dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
										dateFormat: 'dd.mm.yy',
										firstDay: 1,
										isRTL: false
									};
									
									$.datepicker.setDefaults($.datepicker.regional['ru']);
									
									//1 календарь
									$('#datepicker').datepicker();
							</script>
							</div>

							<?php the_field('bottom_block_consultations-page'); ?><br>
							
							<a class="go-program contact-with-me contact-with-me-article" href="<?php echo get_permalink('108'); ?>">Узнать обо мне</a>
							<a class="go-program read-my-article read-my-articles" href="<?php echo get_permalink('12'); ?>">Связаться со мной</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php get_footer(); ?>