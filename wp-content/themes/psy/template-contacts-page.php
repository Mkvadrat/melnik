<?php
/*
Template name: Contacts page
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
						
						<div class="about-me about-me-contacts">

							<h3 class="cont-header cont-header-contacts">Контактная информация</h3>
							<p class="сontact-information сontact-information-contacts">
								<span class="adr">E-mail:</span><br>
								<?php getMeta('email_contacts_page'); ?><br>
								<span class="ph">Телефон:</span>
								<?php getMeta('phone_contacts_page'); ?>
								<span class="sk">Скайп:</span>
								<?php getMeta('skype_contacts_page'); ?>
								<span class="in-the-map">На карте:</span>
							</p>
							
							<!-- start map -->
							<div class="map-iandex">
								<?php if(!empty(get_field('email_contacts_page'))){?>
									<div id="maps" style="width:100%; height:385px"></div>
									<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&load=package.full" type="text/javascript"> </script>
											<script type="text/javascript">
													var myMap;
													ymaps.ready(init);
													function init()
													{
															ymaps.geocode('<?php the_field('adress_contacts_page'); ?>', {
																	results: 1
															}).then
															(
																	function (res)
																	{
																			var firstGeoObject = res.geoObjects.get(0),
																					myMap = new ymaps.Map
																					("maps",
																							{
																									center: firstGeoObject.geometry.getCoordinates(),
																									zoom: 15,
															controls: ["zoomControl", "fullscreenControl"]
																							}
																					);
																			var myPlacemark = new ymaps.Placemark
																			(
																					firstGeoObject.geometry.getCoordinates(),
																					{
																							iconContent: ''
																					},
																					{
																							preset: 'twirl#blueStretchyIcon'
																					}
																			);
																			myMap.geoObjects.add(myPlacemark);
																			myMap.controls.add('typeSelector');
																			myMap.behaviors.disable('scrollZoom');
																	},
																	function (err)
																	{
																			alert(err.message);
																	}
															);
													}
									</script>
								<?php } ?>
							</div>
							
							<div class="form personal-consultations-form form-in-contacts">
								<p class="name-f">Имя</p><p class="e-mail-f">E-mail</p>
								<input type="text" name="name" id="name"  size="25">
								<input type="text" name="email" id="email" size="25">
								<p class="text-message">Текст сообщения</p>
								<textarea name="comment" id="comment" cols="48" rows="8"></textarea>
								<input onclick="SendForm();" id="submit" type="submit" value="Отправить">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
