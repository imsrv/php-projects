<?php include("include/header.php"); ?>
<br />

<div class="filminfobox">
<div id="filmsbgbot"></div>
<?PHP include ("include/display_full_image.txt"); ?><br />
<div id="filmsbgbot"></div>
<div class="filminfostats">
<div class="filminfostats2">
<?PHP include ("include/display_movie_details.txt"); ?><br />

<strong>Награды и номинации</strong><br /><br />
<?PHP include ("include/display_movie_awards.txt"); ?><br />

<strong>Ссылки</strong><br />
<?PHP include ("include/display_movie_links.txt"); ?></div>
</div></div>


<h1><img src="images/bullet.gif" alt="<?PHP include ("include/site_name.txt");?>" /> <?PHP include ("include/display_movie_title.txt"); ?> (<?PHP include ("include/display_movie_details_released.txt"); ?>)</h1><br /><br />

Просмотрено <?PHP include ("include/display_movie_views.txt"); ?> раз(а)<br />

<div class="filminfocontent"><h3><img src="images/articleicon.gif" alt="<? print "$site"; ?>" /> Описание</h3>
<div class="filmarticlebgr"></div>
<div class="filmarticlebg">
<?PHP include ("include/display_movie_summary.txt"); ?>

<br /><img src="images/discussicon.gif" /> <?PHP include ("include/display_movie_forum.txt"); ?></div>


<br />
<h3><img src="images/articleicon.gif" alt="<? print "$site"; ?>" /> Статьи для фильма <?PHP include ("include/display_movie_title.txt"); ?></h3><div class="filmarticlebgr"></div>
<div class="filmarticlebg">
<?PHP include ("include/display_movie_articles_only.txt"); ?></div><br /><br />

<h3><img src="images/articleicon.gif" alt="<? print "$site"; ?>" /> Обзоры для фильма <?PHP include ("include/display_movie_title.txt"); ?></h3><div class="filmarticlebgr"></div>
<div class="filmarticlebg">
<?PHP include ("include/display_movie_reviews_only.txt"); ?></div><br /><br />

<h3><img src="images/articleicon.gif" alt="<? print "$site"; ?>" /> <?PHP include ("include/display_movie_title.txt"); ?> Последние новости </h3>
<div class="filmarticlebgr"></div>
<div class="filmarticlebg">
<?PHP include ("include/custom.rss"); ?></div>

<br /><h3><img src="images/articleicon.gif" alt="<? print "$site"; ?>" /> <?PHP include ("include/display_movie_title.txt"); ?> Последние предложения</h3><div class="filmarticlebgr"></div>
<div class="filmarticlebg"><br /><br />
<?PHP include ("include/amazon.txt"); ?></div>

</div>
<?php include("include/footer.php"); ?>
 