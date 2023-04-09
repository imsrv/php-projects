<?php include ("inc/security.inc") ?>
<?php include ("inc/header.php"); ?>
<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Примеры кода</h1><br /><br />

<div class="boxbgr"></div>
<div class="boxbg">
Куски кода приведенные ниже могут быть расположены где угодно в Ваших шаблонах.
<br />Будьте креативны!<br /><br />


<div class="helpsection"><h1><img src="../images/admin/bullet.gif" /> Код настройки сайта</h1> <a onclick="switchMenu('5');"><img src="../images/admin/div.jpg" /></a><br /><br />
<div id="5" style="display:none;">
<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/e_mail.txt");?&gt;</div><br />
Показывает email администратора (устанавливается в настройках)
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/site_name.txt");?&gt;</div><br />
Показывает название сайта (устанавливается в настройках)
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/site_url.txt");?&gt;</div><br />
Показывает URL сайта (устанавливается в настройках)
</div><br /></div>
</div>

<div class="helpsection"><h1><img src="../images/admin/bullet.gif" /> Код поиска</h1> <a onclick="switchMenu('6');"><img src="../images/admin/div.jpg" /></a><br /><br />
<div id="6" style="display:none;">
<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/search_form.txt");?&gt;</div><br />
Покзывает форму поиска
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/search.txt");?&gt;</div><br />
Показывает результаты поиска
</div><br /></div>
</div>

<div class="helpsection"><h1><img src="../images/admin/bullet.gif" /> Код списка статей / фильмов</h1> <a onclick="switchMenu('2');"><img src="../images/admin/div.jpg" /></a><br /><br />
<div id="2" style="display:none;">
<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movies.txt");?&gt;</div><br />
Показывает список с названиями фильмов и коротким описанием
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movies_box.txt");?&gt;</div><br />
Показывает каждый фильм в своей рамке. Отображает миниатюру, название и короткое описание
</div><br />

</div>
</div>


<div class="helpsection"><h1><img src="../images/admin/bullet.gif" /> Код статистики</h1> <a onclick="switchMenu('1');"><img src="../images/admin/div.jpg" /></a><br /><br />
<div id="1" style="display:none;">
<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/count_movies.txt");?&gt;</div><br />
Отображает количество фильмов в БД
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/count_articles.txt");?&gt;</div><br />
Отображает количество обзоров/статей в БД
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/count_movies.txt");?&gt;</div><br />
Простой вариант, отображает количество фильмов в БД
</div><br /></div></div>

<div class="helpsection"><h1><img src="../images/admin/bullet.gif" /> Код шаблонов фильмов</h1> <a onclick="switchMenu('3');"><img src="../images/admin/div.jpg" /></a><br /><br />
<div id="3" style="display:none;">
<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/movie_header.txt");?&gt;</div><br />
This code can be entered between the head tags of the movie template, header information ( title, description and keywords ) are drawn from the database of the relevant movie being displayed.
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_title.txt");?&gt;</div><br />
Displays the movies title
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_full_image.txt");?&gt;</div><br />
Displays the movies image
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details.txt");?&gt;</div><br />
Отображает ВСЮ информацию о фильме
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_summary.txt");?&gt;</div><br />
Отображает только описание.
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_awards.txt");?&gt;</div><br />
Отображает только награды
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_links.txt");?&gt;</div><br />
Отображает только ссылки
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_articles.txt");?&gt;</div><br />
Отображает только статьи
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_views.txt");?&gt;</div><br />
Отображает количество просмотров
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_forum.txt");?&gt;</div><br />
Отображает ссылку на форум
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/amazon.txt");?&gt;</div><br />
Отображает относящиеся к фильму продукты с Amazon
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_articles_only.txt");?&gt;</div><br />
Отображает только статьи. <strong>Без</strong> обзоров
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_reviews_only.txt");?&gt;</div><br />
Отображает только обзоры. <strong>Без</strong> статей.
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_awards_nomination.txt");?&gt;</div><br />
Отображает только номинации фильма
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_awards_win.txt");?&gt;</div><br />
Отображает только награды фильма
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details_released.txt");?&gt;</div><br />
Отображает только дату релиза фильма
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details_running.txt");?&gt;</div><br />
Отображает только продолжительность фильма
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details_aspect.txt");?&gt;</div><br />
Отображает только пропорции фильма
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details_rating.txt");?&gt;</div><br />
Отображает только MPAA рейтинг
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details_budget.txt");?&gt;</div><br />
Отображает только бюджет фильма
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details_domestic.txt");?&gt;</div><br />
Отображает только "домашние" сборы
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details_international.txt");?&gt;</div><br />
Отображает только междунродные сборы
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_movie_details_worldwide.txt");?&gt;</div><br />
Отображает только мировые сборы
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("display_thumb_image.txt");?&gt;</div><br />
Отображает только страницу с эскизами
</div><br /></div>

</div>

<div class="helpsection"><h1><img src="../images/admin/bullet.gif" /> Код статей/обзоров</h1> <a onclick="switchMenu('4');"><img src="../images/admin/div.jpg" /></a><br /><br />
<div id="4" style="display:none;">
<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/article_header.txt");?&gt;</div><br />
Этот код может быть вставлен между тэгами head, и будет брать информацию о фильме (название, описание, ключевые слова) из БД
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_article_title.txt");?&gt;</div><br />
Отображает только название
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_article_content.txt");?&gt;</div><br />
Этот код позволит отобразить содержимое статьи
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;?PHP include ("include/display_article_reference.txt");?&gt;</div><br />
Отобразит источник статьи или имя автора
</div><br />

<div class="helpbox">
<div class="phpcode">&lt;PHP include ("include/display_article_views.txt");?&gt;</div><br />
Отобразит количество просмотров статьи
</div><br /></div>

</div></div>

<?php include ("inc/footer.php"); ?> 

