<?php
/*
Theme Name: Melnik-psy
Theme URI: http://melnik-psy.com/
Author: M2
Author URI: http://mkvadrat.com/
Description: Тема для сайта melnik-psy.com
Version: 1.0
*/

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
****************************************************************************НАСТРОЙКИ ТЕМЫ*****************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Регистрируем название сайта
function psy_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'psy' ), max( $paged, $page ) );
	}

	if ( is_404() ) {
        $title = '404';
    }

	return $title;
}
add_filter( 'wp_title', 'psy_wp_title', 10, 2 );

//Регистрируем меню
if(function_exists('register_nav_menus')){
	register_nav_menus(
		array(
		  'primary'      => 'Главное меню',
		  'footer_menu'  => 'Меню в подвале сайта',
		)
	);
}

//Изображение в шапке сайта
$args = array(
  'width'         => 50,
  'height'        => 63,
  'default-image' => get_template_directory_uri() . '/img/logo.png',
  'uploads'       => true,
);
add_theme_support( 'custom-header', $args );

//Добавление в тему миниатюры записи и страницы
if ( function_exists( 'add_theme_support' ) ) {
     add_theme_support( 'post-thumbnails' );
}

//Удаляем пунткы меню
function remove_menu_items() {
    remove_menu_page('edit-comments.php'); // Удаляем пункт "Комментарии"
}
add_action( 'admin_menu', 'remove_menu_items' );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*********************************************************************РАБОТА С METAПОЛЯМИ*******************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Проверка на пустоту
function ifMeta($meta_key){
	global $wpdb;

	$value = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 1" , $meta_key) );

	if(!empty($value)){
		return true;
	}else{
		return false;
	}
}

//Вывод данных из произвольных полей для всех страниц сайта
function getMeta($meta_key){
	global $wpdb;
	$value = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 1" , $meta_key) );
	echo $value;
}

//Вывод данных из произвольных полей для всех страниц сайта с тегами <p>
function getMetaText($meta_key){
	global $wpdb;
	$value = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 1" , $meta_key) );
	echo wpautop(stripcslashes( $value ), $br = false); 
}

//Вывод картинок из произвольных полей для всех страниц сайта
function getMetaImg($meta_key){
	global $wpdb;
		$value = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s ORDER BY meta_id DESC LIMIT 1" , $meta_key));
	if(!empty($value)){
		$image = $wpdb->get_var( $wpdb->prepare("SELECT guid FROM $wpdb->postmeta JOIN $wpdb->posts ON %s = ID AND meta_key = %d ORDER BY meta_id DESC LIMIT 1", $value, $meta_key));
	}
	echo $image;
}

//Вывод id категории
function getCurrentCatID(){
	global $wp_query;
	if(is_category()){
		$cat_ID = get_query_var('cat');
	}
	return $cat_ID;
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
************************************************************ПЕРЕИМЕНОВАВАНИЕ ЗАПИСЕЙ В СТАТЬИ**************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
function change_post_menu_label() {
    global $menu, $submenu;
    $menu[5][0] = 'Статьи';
    $submenu['edit.php'][5][0] = 'Статьи';
    $submenu['edit.php'][10][0] = 'Добавить статью';
    $submenu['edit.php'][16][0] = 'Метки для статей';
    echo '';
}
add_action( 'admin_menu', 'change_post_menu_label' );
function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Статьи';
    $labels->singular_name = 'Статьи';
    $labels->add_new = 'Добавить статью';
    $labels->add_new_item = 'Добавить статью';
    $labels->edit_item = 'Редактировать статью';
    $labels->new_item = 'Добавить статью';
    $labels->view_item = 'Посмотреть статью';
    $labels->search_items = 'Найти статью';
    $labels->not_found = 'Не найдено';
    $labels->not_found_in_trash = 'Корзина пуста';
}
add_action( 'init', 'change_post_object_label' );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
********************************************************************ФОРМЫ ОБРАТНОЙ СВЯЗИ*******************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Форма обратной связи для главной страницы
function SendForm(){

	$form_adress = get_option('admin_email');
	
	$site_url = $_SERVER['SERVER_NAME'];

	$alert = array(
		'status' => 0,
		'message' => ''
	);

	if (isset($_POST['name'])) {$name = $_POST['name']; if ($name == '') {unset($name);}}
	if (isset($_POST['email'])) {$email = $_POST['email']; if ($email == '' || !is_email($email)) {unset($email);}}
	if (isset($_POST['comment'])) {$comment = $_POST['comment']; if ($comment == '') {unset($comment);}}

	if (isset($name) && isset($email) && isset($comment)){

		$address = $form_adress;

		$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
		$headers .= "From: $site_url\r\n";
		$headers .= "Bcc: birthday-archive@example.com\r\n";
		
		//$mes = "Имя: $name \nEmail: $email \nСообщение: $comment";
		
		$mes = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>ZURBemails</title>
		<style>
		img {
		max-width: 100%;
		}
		.collapse {
		margin:0;
		padding:0;
		}
		body {
		-webkit-font-smoothing:antialiased;
		-webkit-text-size-adjust:none;
		width: 100%!important;
		height: 100%;
		}

		a { color: #2BA6CB;}

		.btn {
		text-decoration:none;
		color: #FFF;
		background-color: #666;
		padding:10px 16px;
		font-weight:bold;
		margin-right:10px;
		text-align:center;
		cursor:pointer;
		display: inline-block;
		}

		p.callout {
		padding:15px;
		background-color:#ECF8FF;
		margin-bottom: 15px;
		}
		.callout a {
		font-weight:bold;
		color: #2BA6CB;
		}

		table.social {
		background-color: #ebebeb;

		}
		.social .soc-btn {
		padding: 3px 7px;
		font-size:12px;
		margin-bottom:10px;
		text-decoration:none;
		color: #FFF;font-weight:bold;
		display:block;
		text-align:center;
		}
		a.fb { background-color: #3B5998!important; }
		a.tw { background-color: #1daced!important; }
		a.gp { background-color: #DB4A39!important; }
		a.ms { background-color: #000!important; }

		.sidebar .soc-btn {
		display:block;
		width:100%;
		}

		table.head-wrap { width: 100%;}

		.header.container table td.logo { padding: 15px; }
		.header.container table td.label { padding: 15px; padding-left:0px;}

		table.body-wrap { width: 100%;}

		table.footer-wrap { width: 100%;	clear:both!important;
		}
		.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
		.footer-wrap .container td.content p {
		font-size:10px;
		font-weight: bold;

		}

		h1,h2,h3,h4,h5,h6 {
		font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
		}
		h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

		h1 { font-weight:200; font-size: 44px;}
		h2 { font-weight:200; font-size: 37px;}
		h3 { font-weight:500; font-size: 27px;}
		h4 { font-weight:500; font-size: 23px;}
		h5 { font-weight:900; font-size: 17px;}
		h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#ffffff;}

		.collapse { margin:0!important;}

		p, ul {
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif;
		margin-bottom: 10px;
		font-weight: normal;
		font-size:14px;
		line-height:1.6;
		}
		p.lead { font-size:17px; }
		p.last { margin-bottom:0px;}

		ul li {
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif;
		margin-left:5px;
		list-style-position: inside;
		}

		ul.sidebar {
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif;
		background:#ebebeb;
		display:block;
		list-style-type: none;
		}
		ul.sidebar li { display: block; margin:0;}
		ul.sidebar li a {
		text-decoration:none;
		color: #666;
		padding:10px 16px;
		margin-right:10px;
		cursor:pointer;
		border-bottom: 1px solid #777777;
		border-top: 1px solid #FFFFFF;
		display:block;
		margin:0;
		}
		ul.sidebar li a.last { border-bottom-width:0px;}
		ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}

		.container {
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif;
		display:block!important;
		max-width:600px!important;
		margin:0 auto!important;
		clear:both!important;
		}

		.content {
		padding:15px;
		max-width:600px;
		margin:0 auto;
		display:block;
		}

		.content table { width: 100%; }

		.column {
		width: 300px;
		float:left;
		}
		.column tr td { padding: 15px; }
		.column-wrap {
		padding:0!important;
		margin:0 auto;
		max-width:600px!important;
		}
		.column table { width:100%;}
		.social .column {
		width: 280px;
		min-width: 279px;
		float:left;
		}


		.clear { display: block; clear: both; }

		@media only screen and (max-width: 600px) {

		a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

		div[class="column"] { width: auto!important; float:none!important;}

		table.social div[class="column"] {
		width:auto!important;
		}

		}
		</style>

		</head>

		<body bgcolor="#FFFFFF">

		<!-- HEADER -->
		<table class="head-wrap" bgcolor="#003576">
		<tr>
		<td></td>
		<td class="header container" >

		<div class="content">
		<table>
		<tr>

		<td align="left"><h6 class="collapse" style="font-weight: 900; font-size: 14px; text-transform: uppercase; color: #ffffff;">Наталья Мельник психологические услуги</td>
		<td align="right"><h6 class="collapse" style="font-weight: 900; font-size: 14px; text-transform: uppercase; color: #ffffff;">Обратная связь</h6></td>
		</tr>
		</table>
		</div>

		</td>
		<td></td>
		</tr>
		</table>

		<table class="body-wrap">
		<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

		<div class="content">
		<table>
		<tr>
		<td>
		<!--<h3>Тема сообщения</h3>-->

		<p>'.$comment.'</p>
		<!-- Callout Panel -->
		<!-- social & contact -->
		<table class="social" width="100%">
		<tr>
		<td>
		<table align="left" class="column">
		<tr>
		<td>

		<h5 class="">Контактная информация:</h5>
		<br/>
		<p>Имя: <strong>'.$name.'</strong></p>
		<p>Email: <strong><a href="emailto: '.$email.'">'.$email.'</a></strong></p>
		</td>
		</tr>
		</table>

		<span class="clear"></span>

		</td>
		</tr>
		</table>

		</td>
		</tr>
		</table>
		</div>

		</td>
		<td></td>
		</tr>
		</table>

		<table class="footer-wrap">
		<tr>
		<td></td>
		<td class="container"></td>
		<td></td>
		</tr>
		</table>

		</body>
		</html>';

		$send = mail($address, $email, $mes, $headers);

		if ($send == 'true'){
			$alert = array(
				'status' => 1,
				'message' => 'Ваше сообщение отправлено'
			);
		}else{
			$alert = array(
				'status' => 1,
				'message' => 'Ошибка, сообщение не отправлено!'
			);
		}
	}

	if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['comment'])){
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$email = $_POST['email'];

		if(!is_email($email)) {
			$alert = array(
				'status' => 1,
				'message' => 'Email введен не верно, проверте внимательно поле!'
			);
		}

		if ($name == '' || $email == '' || $comment == '') {
			unset($name);
			unset($email);
			unset($comment);
			$alert = array(
				'status' => 1,
				'message' => 'Ошибка, сообщение не отправлено! Заполните все поля!'
			);
		}
	}

	echo wp_send_json($alert);

	wp_die();
}
add_action('wp_ajax_SendForm', 'SendForm');
add_action('wp_ajax_nopriv_SendForm', 'SendForm');

//Форма обратной связи для главной страницы
function appointmentConsultation(){

	$form_adress = get_option('admin_email');
	
	$site_url = $_SERVER['SERVER_NAME'];

	$alert = array(
		'status' => 0,
		'message' => ''
	);

	if (isset($_POST['name'])) {$name = $_POST['name']; if ($name == '') {unset($name);}}
	if (isset($_POST['surname'])) {$surname = $_POST['surname']; if ($surname == '') {unset($surname);}}
	if (isset($_POST['email'])) {$email = $_POST['email']; if ($email == '') {unset($email);}}
	if (isset($_POST['datepicker'])) {$datepicker = $_POST['datepicker']; if ($datepicker == '') {unset($datepicker);}}
	if (isset($_POST['comment'])) {$comment = $_POST['comment']; if ($comment == '') {unset($comment);}}

	if (isset($name) && isset($email) && isset($datepicker) && isset($comment) && isset($surname)){

		$address = $form_adress;

		$headers  = "Content-type: text/html; charset=UTF-8 \r\n";
		$headers .= "From: $site_url\r\n";
		$headers .= "Bcc: birthday-archive@example.com\r\n";
		
		//$mes = "Имя: $name \nEmail: $email \nСообщение: $comment";
		
		$mes = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>ZURBemails</title>
		<style>
		img {
		max-width: 100%;
		}
		.collapse {
		margin:0;
		padding:0;
		}
		body {
		-webkit-font-smoothing:antialiased;
		-webkit-text-size-adjust:none;
		width: 100%!important;
		height: 100%;
		}

		a { color: #2BA6CB;}

		.btn {
		text-decoration:none;
		color: #FFF;
		background-color: #666;
		padding:10px 16px;
		font-weight:bold;
		margin-right:10px;
		text-align:center;
		cursor:pointer;
		display: inline-block;
		}

		p.callout {
		padding:15px;
		background-color:#ECF8FF;
		margin-bottom: 15px;
		}
		.callout a {
		font-weight:bold;
		color: #2BA6CB;
		}

		table.social {
		background-color: #ebebeb;

		}
		.social .soc-btn {
		padding: 3px 7px;
		font-size:12px;
		margin-bottom:10px;
		text-decoration:none;
		color: #FFF;font-weight:bold;
		display:block;
		text-align:center;
		}
		a.fb { background-color: #3B5998!important; }
		a.tw { background-color: #1daced!important; }
		a.gp { background-color: #DB4A39!important; }
		a.ms { background-color: #000!important; }

		.sidebar .soc-btn {
		display:block;
		width:100%;
		}

		table.head-wrap { width: 100%;}

		.header.container table td.logo { padding: 15px; }
		.header.container table td.label { padding: 15px; padding-left:0px;}

		table.body-wrap { width: 100%;}

		table.footer-wrap { width: 100%;	clear:both!important;
		}
		.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
		.footer-wrap .container td.content p {
		font-size:10px;
		font-weight: bold;

		}

		h1,h2,h3,h4,h5,h6 {
		font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
		}
		h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

		h1 { font-weight:200; font-size: 44px;}
		h2 { font-weight:200; font-size: 37px;}
		h3 { font-weight:500; font-size: 27px;}
		h4 { font-weight:500; font-size: 23px;}
		h5 { font-weight:900; font-size: 17px;}
		h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#ffffff;}

		.collapse { margin:0!important;}

		p, ul {
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif;
		margin-bottom: 10px;
		font-weight: normal;
		font-size:14px;
		line-height:1.6;
		}
		p.lead { font-size:17px; }
		p.last { margin-bottom:0px;}

		ul li {
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif;
		margin-left:5px;
		list-style-position: inside;
		}

		ul.sidebar {
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif;
		background:#ebebeb;
		display:block;
		list-style-type: none;
		}
		ul.sidebar li { display: block; margin:0;}
		ul.sidebar li a {
		text-decoration:none;
		color: #666;
		padding:10px 16px;
		margin-right:10px;
		cursor:pointer;
		border-bottom: 1px solid #777777;
		border-top: 1px solid #FFFFFF;
		display:block;
		margin:0;
		}
		ul.sidebar li a.last { border-bottom-width:0px;}
		ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}

		.container {
		font-family: Helvetica, Arial, "Lucida Grande", sans-serif;
		display:block!important;
		max-width:600px!important;
		margin:0 auto!important;
		clear:both!important;
		}

		.content {
		padding:15px;
		max-width:600px;
		margin:0 auto;
		display:block;
		}

		.content table { width: 100%; }

		.column {
		width: 300px;
		float:left;
		}
		.column tr td { padding: 15px; }
		.column-wrap {
		padding:0!important;
		margin:0 auto;
		max-width:600px!important;
		}
		.column table { width:100%;}
		.social .column {
		width: 280px;
		min-width: 279px;
		float:left;
		}


		.clear { display: block; clear: both; }

		@media only screen and (max-width: 600px) {

		a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

		div[class="column"] { width: auto!important; float:none!important;}

		table.social div[class="column"] {
		width:auto!important;
		}

		}
		</style>

		</head>

		<body bgcolor="#FFFFFF">

		<!-- HEADER -->
		<table class="head-wrap" bgcolor="#003576">
		<tr>
		<td></td>
		<td class="header container" >

		<div class="content">
		<table>
		<tr>

		<td align="left"><h6 class="collapse" style="font-weight: 900; font-size: 14px; text-transform: uppercase; color: #ffffff;">Наталья Мельник психологические услуги</td>
		<td align="right"><h6 class="collapse" style="font-weight: 900; font-size: 14px; text-transform: uppercase; color: #ffffff;">Обратная связь</h6></td>
		</tr>
		</table>
		</div>

		</td>
		<td></td>
		</tr>
		</table>

		<table class="body-wrap">
		<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

		<div class="content">
		<table>
		<tr>
		<td>
		<!--<h3>Тема сообщения</h3>-->

		<p>'.$comment.'</p>
    <p>Дата записи на консультацию: '.$datepicker.'</p>
		<!-- Callout Panel -->
		<!-- social & contact -->
		<table class="social" width="100%">
		<tr>
		<td>
		<table align="left" class="column">
		<tr>
		<td>

		<h5 class="">Контактная информация:</h5>
		<br/>
		<p>Имя: <strong>'.$name.'</strong></p>
		<p>Email: <strong><a href="emailto: '.$email.'">'.$email.'</a></strong></p>
		</td>
		</tr>
		</table>

		<span class="clear"></span>

		</td>
		</tr>
		</table>

		</td>
		</tr>
		</table>
		</div>

		</td>
		<td></td>
		</tr>
		</table>

		<table class="footer-wrap">
		<tr>
		<td></td>
		<td class="container"></td>
		<td></td>
		</tr>
		</table>

		</body>
		</html>';

		$send = mail($address, $email, $mes, $headers);

		if ($send == 'true'){
			$alert = array(
				'status' => 1,
				'message' => 'Ваше сообщение отправлено'
			);
		}else{
			$alert = array(
				'status' => 1,
				'message' => 'Ошибка, сообщение не отправлено!'
			);
		}
	}

	if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['datepicker']) && isset($_POST['comment'])){
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$email = $_POST['email'];
		$datepicker = $_POST['datepicker'];
		$comment = $_POST['comment'];

		if(!is_email($email)) {
			$alert = array(
				'status' => 1,
				'message' => 'Email введен не верно, проверте внимательно поле!'
			);
		}

		if ($name == '' || $surname == '' || $datepicker == '' || $email == '' || $comment == '') {
			unset($name);
			unset($surname);
			unset($email);
			unset($datepicker);
			unset($comment);
			$alert = array(
				'status' => 1,
				'message' => 'Ошибка, сообщение не отправлено! Заполните все поля!'
			);
		}
	}

	echo wp_send_json($alert);

	wp_die();
}
add_action('wp_ajax_appointmentConsultation', 'appointmentConsultation');
add_action('wp_ajax_nopriv_appointmentConsultation', 'appointmentConsultation');

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
********************************************************************ХЛЕБНЫЕ КРОШКИ*************************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/

function dimox_breadcrumbs() {

  /* === ОПЦИИ === */
  $text['home'] = 'Главная'; // текст ссылки "Главная"
  $text['category'] = '%s'; // текст для страницы рубрики
  $text['search'] = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
  $text['tag'] = 'Записи с тегом "%s"'; // текст для страницы тега
  $text['author'] = 'Статьи автора %s'; // текст для страницы автора
  $text['404'] = 'Ошибка 404'; // текст для страницы 404
  $text['page'] = 'Страница %s'; // текст 'Страница N'
  $text['cpage'] = 'Страница комментариев %s'; // текст 'Страница комментариев N'

  $wrap_before = '<div class="index-about-links">'; // открывающий тег обертки
  $wrap_after = '</div>'; // закрывающий тег обертки
  $sep = '/'; // разделитель между "крошками"
  $sep_before = ''; // тег перед разделителем
  $sep_after = ''; // тег после разделителя
  $show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
  $show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
  $show_current = 1; // 1 - показывать название текущей страницы, 0 - не показывать
  $before = '<a class="about-content-active">'; // тег перед текущей "крошкой"
  $after = '</a>'; // тег после текущей "крошки"
  /* === КОНЕЦ ОПЦИЙ === */

  global $post;
  $home_url = home_url('/');
  $link_before = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
  $link_after = '</span>';
  $link_attr = ' itemprop="item"';
  $link_in_before = '<span itemprop="name">';
  $link_in_after = '</span>';
  $link = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
  $frontpage_id = get_option('page_on_front');
  $parent_id = ($post) ? $post->post_parent : '';
  $sep = ' ' . $sep_before . $sep . $sep_after . ' ';
  $home_link = $link_before . '<a href="' . $home_url . '"' . $link_attr . ' class="home">' . $link_in_before . $text['home'] . $link_in_after . '</a>' . $link_after;

  if (is_home() || is_front_page()) {

    if ($show_on_home) echo $wrap_before . $home_link . $wrap_after;

  } else {

    echo $wrap_before;
    if ($show_home_link) echo $home_link;

    if ( is_category() ) {
      $cat = get_category(get_query_var('cat'), false);
      if ($cat->parent != 0) {
        $cats = get_category_parents($cat->parent, TRUE, $sep);
        $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        if ($show_home_link) echo $sep;
        echo $cats;
      }
      if ( get_query_var('paged') ) {
        $cat = $cat->cat_ID;
        echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
      }

    } elseif ( is_search() ) {
      if (have_posts()) {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['search'], get_search_query()) . $after;
      } else {
        if ($show_home_link) echo $sep;
        echo $before . sprintf($text['search'], get_search_query()) . $after;
      }

    } elseif ( is_day() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $sep;
      echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
      if ($show_current) echo $sep . $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
      if ($show_current) echo $sep . $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      //Категории
      if ($show_home_link) echo $sep;
      if ( get_post_type() != 'post' ) {
		if( get_post_type() == 'psy-appartment' ){
			$post_type = get_post_type_object(get_post_type());
			$slug = get_terms( 'psy-appartment-list','OBJECT');
			printf($link, $home_url . $slug[0]->slug . '/', $post_type->labels->singular_name);
			if ($show_current) echo $sep . $before . get_the_title() . $after;
		}else if(get_post_type() == 'spanish-group'){
			$post_type = get_post_type_object(get_post_type());
			$slug = get_terms( 'spanish-group-list','OBJECT');
			printf($link, $home_url . $slug[0]->slug . '/', $post_type->labels->singular_name);
			if ($show_current) echo $sep . $before . get_the_title() . $after;
		}else{
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			printf($link, $home_url . $slug['slug'] . '/', $post_type->labels->singular_name);
			if ($show_current) echo $sep . $before . get_the_title() . $after;
		}
		
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $sep);
        if (!$show_current || get_query_var('cpage')) $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        echo $cats;
        if ( get_query_var('cpage') ) {
          echo $sep . sprintf($link, get_permalink(), get_the_title()) . $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
        } else {
          if ($show_current) echo $before . get_the_title() . $after;
        }
      }

    // custom post type
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      if ( get_query_var('paged') ) {
        echo $sep . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . $post_type->label . $after;
      }

    } elseif ( is_attachment() ) {
      if ($show_home_link) echo $sep;
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $sep);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_page() && $parent_id ) {
      if ($show_home_link) echo $sep;
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $sep;
        }
      }
      if ($show_current) echo $sep . $before . get_the_title() . $after;
    } elseif ( is_tag() ) {
      if ( get_query_var('paged') ) {
        $tag_id = get_queried_object_id();
        $tag = get_tag($tag_id);
        echo $sep . sprintf($link, get_tag_link($tag_id), $tag->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
      }

    } elseif ( is_author() ) {
      global $author;
      $author = get_userdata($author);
      if ( get_query_var('paged') ) {
        if ($show_home_link) echo $sep;
        echo sprintf($link, get_author_posts_url($author->ID), $author->display_name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
      }

    } elseif ( is_404() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . $text['404'] . $after;

    } elseif ( has_post_format() && !is_singular() ) {
      if ($show_home_link) echo $sep;
      echo get_post_format_string( get_post_format() );
    }

    echo $wrap_after;

  }
} 

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
******************************************************ДОПОЛНИТЕЛЬНЫЕ ПОЛЯ ДЛЯ ТАКСОНОМИИ "СТАТЬИ"**********************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Инициализация полей для таксономии "Статьи"
function articles_custom_fields(){
    add_action('category_edit_form_fields', 'articles_custom_fields_form');
    add_action('edited_category', 'articles_custom_fields_save');
}
add_action('admin_init', 'articles_custom_fields', 1);

//HTML код для вывода в админке таксономии
function articles_custom_fields_form($tag){
    $t_id = $tag->term_id;
    $cat_meta = get_option("category_$t_id");
?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="extra1"><?php _e('Заголовок рубрики'); ?></label></th>
    <td>
        <input type="text" name="articles_meta[title_for_categories_articles_page]" id="articles_meta[title_for_categories_articles_page]" size="25" value="<?php echo $cat_meta['title_for_categories_articles_page'] ? $cat_meta['title_for_categories_articles_page'] : ''; ?>">
    <br />
        <span class="description"><?php _e('Заголовок для страницы рубрики "Статьи"'); ?></span>
    </td>
    </tr>
   	<tr class="form-field">
    <th scope="row" valign="top"><label for="extra2"><?php _e('Текст рубрики'); ?></label></th>
    <td>
		<?php wp_editor( stripcslashes($cat_meta['text_for_categories_articles_page']), 'wpeditor', array('textarea_name' => 'articles_meta[text_for_categories_articles_page]', 'textarea_rows' => 10, 'editor_css' => '<style>.wp-core-ui{width:95%;} </style>',) ); ?>
    <br />
        <span class="description"><?php _e('Текст для страницы рубрики "Статьи"'); ?></span>
    </td>
    </tr>
	<tr class="form-field">
    <th scope="row" valign="top"><label for="extra3"><?php _e('Текст в футере рубрики'); ?></label></th>
    <td>
		<?php wp_editor( stripcslashes($cat_meta['text_for_categories_articles_footer_page']), 'wpeditor_footer', array('textarea_name' => 'articles_meta[text_for_categories_articles_footer_page]', 'textarea_rows' => 10, 'editor_css' => '<style>.wp-core-ui{width:95%;} </style>',) ); ?>
    <br />
        <span class="description"><?php _e('Текст для страницы в футере рубрики "Статьи"'); ?></span>
    </td>
    </tr>
<?php
}

//Функция сохранения данных для дополнительных полей таксономии
function articles_custom_fields_save($term_id){
    if (isset($_POST['articles_meta'])) {
        $t_id = $term_id;
        $cat_meta = get_option("category_$t_id");
        $cat_keys = array_keys($_POST['articles_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['articles_meta'][$key])) {
                $cat_meta[$key] = $_POST['articles_meta'][$key];
            }
        }
        //save the option array
        update_option("category_$t_id", $cat_meta);
    }
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
****************************************************************ПАГИНАЦИЯ ДЛЯ РАЗДЕЛА СТАТЬИ***************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
function kriesi_pagination($pages = '', $range = 2, $show_all = true){  
	$showitems = ($range * 2)+1;  
	global $paged;
	if(empty($paged)) $paged = 1;
	
	if($pages == ''){
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages){
			$pages = 1;
		}
	}   

	if(1 != $pages){
		echo "<div class='pagination'>";
		echo "<ul>"; 

			for ($i=1; $i <= $pages; $i++){
				//В начало
				if($i == 1){
					echo "<li><a href='".get_pagenum_link($i)."' class='prev-pag'>В начало</a></li>";
				}
				
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ) && $show_all != true){
					echo ($paged == $i)? "<li><a class='current'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
				}
				
				//Сокращение пагинации
				if($show_all == true){
					if( $i % 2 == 0 ){
						echo ($paged == $i)? "<li><a class='current'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
					}
					
				}
				
				//В конец
				$next = (int)$pages;
	
				if($i == $next){
					echo "<li><a href='".get_pagenum_link($i)."' class='next-pag'>В конец</a></li>";
				}
			}

		echo "</ul>";
		echo "</div>";
	}
}

//Переработанная пагинация для стилей
function pg_links( $args = '' ) {
    global $wp_query, $wp_rewrite;
 
    // Setting up default values based on the current URL.
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $url_parts    = explode( '?', $pagenum_link );
 
    // Get max pages and current page out of the current query, if available.
    $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
 
    // Append the format placeholder to the base URL.
    $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
 
    // URL base depends on permalink settings.
    $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
 
    $defaults = array(
        'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format' => $format, // ?page=%#% : %#% is replaced by the page number
        'total' => $total,
        'current' => $current,
        'show_all' => false,
        'prev_next' => true,
        'end_size' => 1,
        'mid_size' => 2,
        'type' => 'plain',
        'add_args' => array(), // array of query args to add
        'add_fragment' => '',
        'before_page_number' => '',
        'after_page_number' => ''
    );
 
    $args = wp_parse_args( $args, $defaults );
 
    if ( ! is_array( $args['add_args'] ) ) {
        $args['add_args'] = array();
    }
 
    // Merge additional query vars found in the original URL into 'add_args' array.
    if ( isset( $url_parts[1] ) ) {
        // Find the format argument.
        $format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
        $format_query = isset( $format[1] ) ? $format[1] : '';
        wp_parse_str( $format_query, $format_args );
 
        // Find the query args of the requested URL.
        wp_parse_str( $url_parts[1], $url_query_args );
 
        // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
        foreach ( $format_args as $format_arg => $format_arg_value ) {
            unset( $url_query_args[ $format_arg ] );
        }
 
        $args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
    }
 
    // Who knows what else people pass in $args
    $total = (int) $args['total'];
    if ( $total < 2 ) {
        return;
    }
    $current  = (int) $args['current'];
    $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
    if ( $end_size < 1 ) {
        $end_size = 1;
    }
    $mid_size = (int) $args['mid_size'];
    if ( $mid_size < 0 ) {
        $mid_size = 2;
    }
    $add_args = $args['add_args'];
    $r = '';
    $page_links = array();
    $dots = false;
 
    for ( $n = 1; $n <= $total; $n++ ) :
		if ( $args['prev_next'] ){
			if($n == 1){
				$page_links[] = "<a href='".get_pagenum_link($n)."' class='prev-pag'>В начало</a>";
			}
		}
		
        if ( $n == $current ){
            $page_links[] = "<a class='page-numbers current'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
            $dots = true;
        }else{
            if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ){
                $link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
                $link = str_replace( '%#%', $n, $link );
                if ( $add_args )
					$link = add_query_arg( $add_args, $link );
					$link .= $args['add_fragment'];
 
                /** This filter is documented in wp-includes/general-template.php */
                $page_links[] = "<a class='page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
                $dots = true;
			}elseif ( $dots && ! $args['show_all'] ){
                $page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
                $dots = false;
			}
        }
		
		if ( $args['prev_next'] ){
			$next = (int)$total;

			if($n == $next){
				$page_links[] = "<a href='".get_pagenum_link($n)."' class='next-pag'>В конец</a>";
			}
		}
    endfor;

       
    switch ( $args['type'] ) {
        case 'array' :
            return $page_links;
 
        case 'list' :
            $r .= "<ul class='page-numbers'>\n\t<li>";
            $r .= join("</li>\n\t<li>", $page_links);
            $r .= "</li>\n</ul>\n";
            break;
 
        default :
            $r = join("\n", $page_links);
            break;
    }
    return $r;
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*******************************************************РАЗДЕЛ "ПСИХОЛОГИЧЕСКИЙ КВАРТИРНИК" В АДМИНКЕ*******************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Вывод в админке раздела Психологический квартирник
function register_post_type_psy_appartment() {
	 $labels = array(
	 'name' => 'Психологический квартирник',
	 'singular_name' => 'Психологический квартирник',
	 'add_new' => 'Добавить статью',
	 'add_new_item' => 'Добавить новый статью',
	 'edit_item' => 'Редактировать статью',
	 'new_item' => 'Новый статья',
	 'all_items' => 'Все статьи',
	 'view_item' => 'Просмотр статьи на сайте',
	 'search_items' => 'Искать статью',
	 'not_found' => 'Статьи не найдены.',
	 'not_found_in_trash' => 'В корзине нет статей.',
	 'menu_name' => 'Психологический квартирник'
	 );
		 $args = array(
		 'labels' => $labels,
		 'public' => true,
		 'exclude_from_search' => false,
		 'show_ui' => true,
		 'has_archive' => true,
		 'menu_icon' => 'dashicons-building',
		 'menu_position' => 20,
		 'supports' => array( 'title', 'editor', 'thumbnail'),
		 );
	 register_post_type('psy-appartment', $args);
}
add_action( 'init', 'register_post_type_psy_appartment' );


function true_post_type_psy_appartment( $psy_appartment ) {
	 global $post, $post_ID;

	 $psy_appartment['psy-appartment'] = array(
		 0 => '',
		 1 => sprintf( 'Статьи обновлены. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
		 2 => 'Статья обновлёна.',
		 3 => 'Статья удалёна.',
		 4 => 'Статья обновлена.',
		 5 => isset($_GET['revision']) ? sprintf( 'Статья восстановлена из редакции: %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		 6 => sprintf( 'Статья опубликована на сайте. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
		 7 => 'Статья сохранена.',
		 8 => sprintf( 'Отправлен на проверку. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		 9 => sprintf( 'Запланирован на публикацию: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Просмотр</a>', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		 10 => sprintf( 'Черновик обновлён. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	 );

	 return $psy_appartment;
}
add_filter( 'post_updated_messages', 'true_post_type_psy_appartment' );

//Категории для пользовательских записей "Психологический квартирник"
function create_taxonomies_psy_appartment_list()
{
    register_taxonomy('psy-appartment-list',array('psy-appartment'),array(
        'hierarchical' => true,
        'label' => 'Рубрики',
        'singular_name' => 'Рубрика',
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'psy-appartment-list' )
    ));
}
add_action( 'init', 'create_taxonomies_psy_appartment_list', 0 );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
************************************ДОПОЛНИТЕЛЬНЫЕ ПОЛЯ ДЛЯ ТАКСОНОМИИ "ПСИХОЛОГИЧЕСКИЙ КВАРТИРНИК"********************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Инициализация полей для таксономии "Психологический квартирник"
function psy_appartment_custom_fields(){
    add_action('psy-appartment-list_edit_form_fields', 'psy_appartment_custom_fields_form');
    add_action('edited_psy-appartment-list', 'psy_appartment_custom_fields_save');
}
add_action('admin_init', 'psy_appartment_custom_fields', 1);

//HTML код для вывода в админке таксономии
function psy_appartment_custom_fields_form($tag){
    $t_id = $tag->term_id;
    $cat_meta = get_option("category_$t_id");
?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="extra1"><?php _e('Заголовок рубрики'); ?></label></th>
    <td>
        <input type="text" name="articles_meta[title_for_categories_psy_appartment_list_page]" id="articles_meta[title_for_categories_psy_appartment_list_page]" size="25" value="<?php echo $cat_meta['title_for_categories_psy_appartment_list_page'] ? $cat_meta['title_for_categories_psy_appartment_list_page'] : ''; ?>">
    <br />
        <span class="description"><?php _e('Заголовок для страницы рубрики "Статьи"'); ?></span>
    </td>
    </tr>
   	<tr class="form-field">
    <th scope="row" valign="top"><label for="extra2"><?php _e('Текст рубрики'); ?></label></th>
    <td>
		<?php wp_editor( stripcslashes($cat_meta['text_for_categories_psy_appartment_list_page']), 'wpeditor', array('textarea_name' => 'articles_meta[text_for_categories_psy_appartment_list_page]', 'textarea_rows' => 10, 'editor_css' => '<style>.wp-core-ui{width:95%;} </style>',) ); ?>
    <br />
        <span class="description"><?php _e('Текст для страницы рубрики "Статьи"'); ?></span>
    </td>
    </tr>
	<tr class="form-field">
    <th scope="row" valign="top"><label for="extra3"><?php _e('Текст в футере рубрики'); ?></label></th>
    <td>
		<?php wp_editor( stripcslashes($cat_meta['text_for_categories_psy_appartment_list_footer_page']), 'wpeditor_footer', array('textarea_name' => 'articles_meta[text_for_categories_psy_appartment_list_footer_page]', 'textarea_rows' => 10, 'editor_css' => '<style>.wp-core-ui{width:95%;} </style>',) ); ?>
    <br />
        <span class="description"><?php _e('Текст для страницы в футере рубрики "Статьи"'); ?></span>
    </td>
    </tr>
<?php
}

//Функция сохранения данных для дополнительных полей таксономии
function psy_appartment_custom_fields_save($term_id){
    if (isset($_POST['articles_meta'])) {
        $t_id = $term_id;
        $cat_meta = get_option("category_$t_id");
        $cat_keys = array_keys($_POST['articles_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['articles_meta'][$key])) {
                $cat_meta[$key] = $_POST['articles_meta'][$key];
            }
        }
        //save the option array
        update_option("category_$t_id", $cat_meta);
    }
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*****************************************************************REMOVE CATEGORY_TYPE SLUG*****************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Удаление psy-appartment-list из url таксономии
function true_remove_slug_from_category_psy_appartment_list( $url, $term, $taxonomy ){

	$taxonomia_name = 'psy-appartment-list';
	$taxonomia_slug = 'psy-appartment-list';

	if ( strpos($url, $taxonomia_slug) === FALSE || $taxonomy != $taxonomia_name ) return $url;

	$url = str_replace('/' . $taxonomia_slug, '', $url);

	return $url;
}
add_filter( 'term_link', 'true_remove_slug_from_category_psy_appartment_list', 10, 3 );

//Перенаправление url в случае удаления psy-appartment-list
function parse_request_url_category_psy_appartment_list( $query ){

	$taxonomia_name = 'psy-appartment-list';

	if( $query['attachment'] ) :
		$condition = true;
		$main_url = $query['attachment'];
	else:
		$condition = false;
		$main_url = $query['name'];
	endif;

	$termin = get_term_by('slug', $main_url, $taxonomia_name);

	if ( isset( $main_url ) && $termin && !is_wp_error( $termin )):

		if( $condition ) {
			unset( $query['attachment'] );
			$parent = $termin->parent;
			while( $parent ) {
				$parent_term = get_term( $parent, $taxonomia_name);
				$main_url = $parent_term->slug . '/' . $main_url;
				$parent = $parent_term->parent;
			}
		} else {
			unset($query['name']);
		}

		switch( $taxonomia_name ):
			case 'category':{
				$query['category_name'] = $main_url;
				break;
			}
			case 'post_tag':{
				$query['tag'] = $main_url;
				break;
			}
			default:{
				$query[$taxonomia_name] = $main_url;
				break;
			}
		endswitch;

	endif;

	return $query;

}
add_filter('request', 'parse_request_url_category_psy_appartment_list', 1, 1 );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
***********************************************************РАЗДЕЛ "ИСПАНСКАЯ ГРУППА" В АДМИНКЕ*************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Вывод в админке раздела Испанская группа
function register_post_type_spanish_group() {
	 $labels = array(
	 'name' => 'Испанская группа',
	 'singular_name' => 'Испанская группа',
	 'add_new' => 'Добавить статью',
	 'add_new_item' => 'Добавить новый статью',
	 'edit_item' => 'Редактировать статью',
	 'new_item' => 'Новый статья',
	 'all_items' => 'Все статьи',
	 'view_item' => 'Просмотр статьи на сайте',
	 'search_items' => 'Искать статью',
	 'not_found' => 'Статьи не найдены.',
	 'not_found_in_trash' => 'В корзине нет статей.',
	 'menu_name' => 'Испанская группа'
	 );
		 $args = array(
		 'labels' => $labels,
		 'public' => true,
		 'exclude_from_search' => false,
		 'show_ui' => true,
		 'has_archive' => true,
		 'menu_icon' => 'dashicons-welcome-learn-more',
		 'menu_position' => 20,
		 'supports' => array( 'title', 'editor', 'thumbnail'),
		 );
	 register_post_type('spanish-group', $args);
}
add_action( 'init', 'register_post_type_spanish_group' );


function true_post_type_spanish_group( $spanish_group ) {
	 global $post, $post_ID;

	 $spanish_group['spanish-group'] = array(
		 0 => '',
		 1 => sprintf( 'Статьи обновлены. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
		 2 => 'Статья обновлёна.',
		 3 => 'Статья удалёна.',
		 4 => 'Статья обновлена.',
		 5 => isset($_GET['revision']) ? sprintf( 'Статья восстановлена из редакции: %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		 6 => sprintf( 'Статья опубликована на сайте. <a href="%s">Просмотр</a>', esc_url( get_permalink($post_ID) ) ),
		 7 => 'Статья сохранена.',
		 8 => sprintf( 'Отправлен на проверку. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		 9 => sprintf( 'Запланирован на публикацию: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Просмотр</a>', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		 10 => sprintf( 'Черновик обновлён. <a target="_blank" href="%s">Просмотр</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	 );

	 return $spanish_group;
}
add_filter( 'post_updated_messages', 'true_post_type_spanish_group' );

//Категории для пользовательских записей "Испанская группа"
function create_taxonomies_spanish_group_list()
{
    register_taxonomy('spanish-group-list',array('spanish-group'),array(
        'hierarchical' => true,
        'label' => 'Рубрики',
        'singular_name' => 'Рубрика',
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'spanish-group-list' )
    ));
}
add_action( 'init', 'create_taxonomies_spanish_group_list', 0 );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
**********************************************ДОПОЛНИТЕЛЬНЫЕ ПОЛЯ ДЛЯ ТАКСОНОМИИ "ИСПАНСКАЯ ГРУППА"********************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Инициализация полей для таксономии "Испанская группа"
function spanish_group_list_custom_fields(){
    add_action('spanish-group-list_edit_form_fields', 'spanish_group_list_custom_fields_form');
    add_action('edited_spanish-group-list', 'spanish_group_list_custom_fields_save');
}
add_action('admin_init', 'spanish_group_list_custom_fields', 1);

//HTML код для вывода в админке таксономии
function spanish_group_list_custom_fields_form($tag){
    $t_id = $tag->term_id;
    $cat_meta = get_option("category_$t_id");
?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="extra1"><?php _e('Заголовок рубрики'); ?></label></th>
    <td>
        <input type="text" name="articles_meta[title_for_categories_spanish_group_list_page]" id="articles_meta[title_for_categories_spanish_group_list_page]" size="25" value="<?php echo $cat_meta['title_for_categories_spanish_group_list_page'] ? $cat_meta['title_for_categories_spanish_group_list_page'] : ''; ?>">
    <br />
        <span class="description"><?php _e('Заголовок для страницы рубрики "Статьи"'); ?></span>
    </td>
    </tr>
   	<tr class="form-field">
    <th scope="row" valign="top"><label for="extra2"><?php _e('Текст рубрики'); ?></label></th>
    <td>
		<?php wp_editor( stripcslashes($cat_meta['text_for_categories_spanish_group_list_page']), 'wpeditor', array('textarea_name' => 'articles_meta[text_for_categories_spanish_group_list_page]', 'textarea_rows' => 10, 'editor_css' => '<style>.wp-core-ui{width:95%;} </style>',) ); ?>
    <br />
        <span class="description"><?php _e('Текст для страницы рубрики "Статьи"'); ?></span>
    </td>
    </tr>
	<tr class="form-field">
    <th scope="row" valign="top"><label for="extra3"><?php _e('Текст в футере рубрики'); ?></label></th>
    <td>
		<?php wp_editor( stripcslashes($cat_meta['text_for_categories_spanish_group_list_footer_page']), 'wpeditor_footer', array('textarea_name' => 'articles_meta[text_for_categories_spanish_group_list_footer_page]', 'textarea_rows' => 10, 'editor_css' => '<style>.wp-core-ui{width:95%;} </style>',) ); ?>
    <br />
        <span class="description"><?php _e('Текст для страницы в футере рубрики "Статьи"'); ?></span>
    </td>
    </tr>
<?php
}

//Функция сохранения данных для дополнительных полей таксономии
function spanish_group_list_custom_fields_save($term_id){
    if (isset($_POST['articles_meta'])) {
        $t_id = $term_id;
        $cat_meta = get_option("category_$t_id");
        $cat_keys = array_keys($_POST['articles_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['articles_meta'][$key])) {
                $cat_meta[$key] = $_POST['articles_meta'][$key];
            }
        }
        //save the option array
        update_option("category_$t_id", $cat_meta);
    }
}

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*****************************************************************REMOVE CATEGORY_TYPE SLUG*****************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Удаление spanish-group-list из url таксономии
function true_remove_slug_from_category_spanish_group_list( $url, $term, $taxonomy ){

	$taxonomia_name = 'spanish-group-list';
	$taxonomia_slug = 'spanish-group-list';

	if ( strpos($url, $taxonomia_slug) === FALSE || $taxonomy != $taxonomia_name ) return $url;

	$url = str_replace('/' . $taxonomia_slug, '', $url);

	return $url;
}
add_filter( 'term_link', 'true_remove_slug_from_category_spanish_group_list', 10, 3 );

//Перенаправление url в случае удаления spanish-group-list
function parse_request_url_category_spanish_group_list( $query ){

	$taxonomia_name = 'spanish-group-list';

	if( $query['attachment'] ) :
		$condition = true;
		$main_url = $query['attachment'];
	else:
		$condition = false;
		$main_url = $query['name'];
	endif;

	$termin = get_term_by('slug', $main_url, $taxonomia_name);

	if ( isset( $main_url ) && $termin && !is_wp_error( $termin )):

		if( $condition ) {
			unset( $query['attachment'] );
			$parent = $termin->parent;
			while( $parent ) {
				$parent_term = get_term( $parent, $taxonomia_name);
				$main_url = $parent_term->slug . '/' . $main_url;
				$parent = $parent_term->parent;
			}
		} else {
			unset($query['name']);
		}

		switch( $taxonomia_name ):
			case 'category':{
				$query['category_name'] = $main_url;
				break;
			}
			case 'post_tag':{
				$query['tag'] = $main_url;
				break;
			}
			default:{
				$query[$taxonomia_name] = $main_url;
				break;
			}
		endswitch;

	endif;

	return $query;

}
add_filter('request', 'parse_request_url_category_spanish_group_list', 1, 1 );

/**********************************************************************************************************************************************************
***********************************************************************************************************************************************************
*****************************************************************REMOVE POST_TYPE SLUG*********************************************************************
***********************************************************************************************************************************************************
***********************************************************************************************************************************************************/
//Удаление psy-appartment из url таксономии
function remove_slug_from_post( $post_link, $post, $leavename ) {
	if ( 'psy-appartment' != $post->post_type && 'spanish-group' != $post->post_type || 'publish' != $post->post_status ) {
		return $post_link;
	}
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
	return $post_link;
}
add_filter( 'post_type_link', 'remove_slug_from_post', 10, 3 );

function parse_request_url_post( $query ) {
	if ( ! $query->is_main_query() )
		return;

	if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
		return;
	}

	if ( ! empty( $query->query['name'] ) ) {
		$query->set( 'post_type', array( 'post', 'psy-appartment', 'spanish-group', 'page' ) );
	}
}
add_action( 'pre_get_posts', 'parse_request_url_post' );