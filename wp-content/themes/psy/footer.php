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

	<!-- Start footer -->
	<div class="container pad-non">
		<div class="row">
			<div class="col-md-12 pad-non">
				<footer>
					<p class="done"><a class="m2" href="http://mkvadrat.com ">Сделано в<br>MKVADRAT</a></p>
					<p class="protected">Все права защищены<br>2017</p>
					<?php
							if (has_nav_menu('footer_menu')){
								wp_nav_menu( array(
									'theme_location'  => 'footer_menu',
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
									'items_wrap'      => '<ul class="menu-footer">%3$s</ul>',
									'depth'           => 1,
									'walker'          => '',
								) );
							}
						?>
				</footer>
			</div>
		</div>
	</div>

	<div class="footer-line2 hidden-md hidden-lg"></div>
	<!-- End footer -->

	<div class="footer-line"></div>
	<script type="text/javascript">
		//форма обратной связи
		function SendForm() {
		  var data = {
			'action': 'SendForm',
			'name' : $('#name').val(),
			'email' : $('#email').val(),
			'comment' : $('#comment').val()
		  };
		  $.ajax({
			url:'http://' + location.host + '/wp-admin/admin-ajax.php',
			data:data, // данные
			type:'POST', // тип запроса
			success:function(data){
			  swal(data.message);
			}
		  });
		};
		
		//запись на консультацию
		function appointmentConsultation() {
		  var data = {
			'action': 'appointmentConsultation',
			'name' : $('#name_consultation').val(), 
			'surname' : $('#surname_consultation').val(), 
			'email' : $('#email_consultation').val(), 
			'datepicker' : $('#datepicker').val(), 
			'comment' : $('#comment_consultation').val()
		  };
		  $.ajax({
			url:'http://' + location.host + '/wp-admin/admin-ajax.php',
			data:data, // данные
			type:'POST', // тип запроса
			success:function(data){
			  swal(data.message);
			}
		  });
		};
	</script>
	
<?php wp_footer(); ?>
</body>
</html>