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
<!-- Start header -->

<div class="container pad-non">
<div class="row">
<div class="col-md-12 pad-non">
<!-- Start side-bar -->

<div class="side-bar">
<img src="img/portrait.png" alt="">
<p>Если у вас есть вопросы, вы можете задать их мне при помощи формы обратной связи</p>
<div class="form">
<p class="name-f">Имя</p><p class="e-mail-f">E-mail</p>
<input type="text" name="name" id="name_form"  size="25">
<input type="text" name="email" id="email_form" size="25">
<p class="text-message">Текст сообщения</p>
<textarea name="comment" id="comment_form" cols="48" rows="8"></textarea>
<input onclick="SendForm();" id="submit" type="submit" value="Отправить">
</div>
<script type="text/javascript">
function SendForm() {	
$.ajax({
url: '/php/initialization.php',
type: 'POST',
dataType: 'json',
data: {'name' : $('#name_form').val(), 'email' : $('#email_form').val(), 'comment' : $('#comment_form').val()},	
success: function(response) {
alert(response.message);
}
});
};
</script>	
<div class="new-articles-on-the-site">
<h3>Новые статьи на сайте</h3>
<div class="small-news1 small-news1-about">
<a href="feeding-behavior.html">
<h5>Пищевое поведение...</h5>
<p>На приеме молодая женщина,<br>которая пришла с жалобами<br>на чувство голода...</p>
<p class="date">23.08.16</p>
</a>
</div><br>
<div class="small-news2 small-news2-about">
<a href="article-mak.html">
<h5>Заметки о теории и истории...</h5>
<p>Пять лет назад метафорические<br>ассоцативные карты...</p>
<p class="date">14.08.16</p>
</a>
</div><br>
<div class="small-news3 small-news3-about">
<a href="article-ispaniya.html">
<h5>Зависимость...</h5>
<p>Одним из самых<br>распространенных и болезненных...</p>
<p class="date">28.07.16</p>
</a>
</div>
</div>

<a class="advertising" href="#">
<h3 class="advertising-title">Испанская группа</h3>
<p>Групповые терапевтические встречи <b>в Испании с 21 по 27 октября 2017</b></p>
</a>
</div>

<!-- End side-bar -->

<!-- Start about -->

<div class="about-content">

<div class="index-about-links">

<a href="index.html">Главная</a> /

<a class="about-content-active" href="spanish-group.html">Испанская группа (с 21.10.17 по 27.10.17)</a>

</div>

<div class="about-me spanish-group">

<h1>Испанская группа (с 21.10.17 по 27.10.17)</h1>

<img class="portrait portrait-big-cons" src="img/spanish-group.jpg" alt="portrait">
<img class="portrait-consul" src="img/portrait-small-consult.jpg" alt="">

<div class="emotional emotional-new">
<a href="benalmadena.html">
<img src="img/benalmadena.png" alt="">
<p>Бенальмадена<br>(Benalmadena)</p>
<ul>
<li>Расположенная в провинции Андалусия, на побережье Коста дель Соль. Здесь вы будете услышаны и поняты </li>
</ul>
</a>
</div>
<div class="depression depression-new">
<a href="events-program.html">
<img src="img/enroll.png" alt="">
<p>Программа<br> мероприятий</p>
<ul>
<li>8 суток при сопровождении психотерапевта, индивидуальные психотерапевтические сессии</li>
</ul>
</a>
</div>


<a class="title" href="benalmadena.html"><h4>Школа мышления</h4>

<img class="emotional-stress-img" src="img/spanish-1.jpg" alt=""></a>

<ul class="pers-cons-small-ul">
<li>Объявляет набор в группу  на  программу по психоанализу, участвовать в семинарах могут все, кто хочет развиваться.</li>

<li><strong>Временная рамка: с 12 до 20 часов  </strong></li>
<li><strong>Начало занятий — 21-22 октября 2017 года</strong></li>
<li><strong>Место – Бенальмадена, Испания</strong></li>
</ul>

<a class="go-program more-pers-cons" href="benalmadena.html">Подробнее</a>

<a class="title" href="events-program.html"><h4>Желание, власть и любовь: свобода и управление</h4>

<img class="emotional-stress-img" src="img/spanish-2.jpg" alt=""></a>

<ul class="pers-cons-small-ul">
<li>Объявляет набор в группу  на  программу по психоанализу, участвовать в семинарах могут все, кто хочет развиваться.</li>

<li><strong>Временная рамка: с 19 до 22 часов </strong></li>
<li><strong>Начало занятий — 23-25 октября 2017 года</strong></li>
<li><strong>Место – Бенальмадена, Испания</strong></li>
</ul>

<a class="go-program more-pers-cons m-p-c" href="events-program.html">Подробнее</a>





<a class="title" href="events-program.html"><h4>Влюблен по собственному желанию</h4>

<img class="emotional-stress-img" src="img/spanish-3.jpg" alt=""></a>

<ul class="pers-cons-small-ul">
<li>Объявляет набор в группу  на  программу по психоанализу, участвовать в семинарах могут все, кто хочет развиваться.</li>

<li><strong>Временная рамка: с 19 до 22 часов  </strong></li>
<li><strong>Начало занятий — 26-27 октября 2017 года</strong></li>
<li><strong>Место – Бенальмадена, Испания</strong></li>
</ul>

<a class="go-program more-pers-cons m-p-c" href="events-program.html">Подробнее</a>

<div id="form-enroll" class="form personal-consultations-form personal-consultations-form-small">

<h5>Записаться в группу</h5>

<div>
<p class="name-f">Имя</p>
<p class="surname-f">Фамилия</p>
<input type="hidden" name="check" id="check_form" value="form">
<input type="text" name="name" id="name"  size="25">

<input type="text" name="surname" id="surname"  size="25">

<p class="e-mail-f">E-mail</p>
<p class="day">Выбрать дату</p>
<!--<p class="mounths">Месяц</p>-->

<input type="text" name="email" id="email" size="25">

<input type="text" name="datepicker" id="datepicker" size="25">

<p class="text-message">Текст сообщения</p>

<textarea name="comment" id="comment" cols="48" rows="8" onfocus=" placeholder='';"></textarea>

<!--<input name="submit" type="submit" id="submit" value="Отправить">-->
<input onclick="SendApplication();" id="submit" type="submit" value="Записаться">
</div>
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

function SendApplication() {	
$.ajax({
url: '/php/initialization.php',
type: 'POST',
dataType: 'json',
data: {'check' : $('#check_form').val(), 'name' : $('#name').val(), 'surname' : $('#surname').val(), 'email' : $('#email').val(), 'datepicker' : $('#datepicker').val(), 'comment' : $('#comment').val()},	
success: function(response) {
alert(response.message);
}
});
};
</script>

<script type="text/javascript">

</script>	
<div class="depression depression-about depr-pers-cons">
<a href="psychological-appartment.html">
<img src="img/depression-about.png" alt="">
<h3>Психологический<br> квартирник</h3>
<ul>
	<li>- терапевтические группы</li>
	<li>- встреч</li>
	<li>- киноклуб</li>
</ul>
</a>
</div><br>
<a class="go-program read-my-article read-my-article-cons" href="about.html">Узнать обо мне</a>
<a class="go-program contact-with-me contact-with-me-cons" href="contacts.html">Связаться со мной</a>
</div>




<p class="done"><a class="m2" href="http://mkvadrat.com ">Сделано в<br>MKVADRAT</a></p>
<p class="protected">Все права защищены<br>2016</p>
<ul class="menu-footer">
<li>
<a href="about.html">Обо мне</a>
</li>
<li>
<a href="personal-consultations.html">Очные консультации</a>
</li>
<li>
<a href="psychological-appartment.html">Психологический квартирник</a>
</li>
<li>
<a href="spanish-group.html">Испанская группа</a>
</li>
<li>
<a href="articles.html">Статьи</a>
</li>
<li>
<a href="contacts.html">Контакты</a>
</li>
</ul>

<!-- End footer -->

<div class="footer-line2 hidden-md hidden-lg"></div>

</div>
</div>
</div>
</div>
<?php get_footer(); ?>
