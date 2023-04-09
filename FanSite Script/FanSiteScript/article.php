<?php include("include/header.php"); ?>
<br />

<h1><img src="images/bullet.gif" alt="<?PHP include ("include/site_name.txt");?>" /> <?PHP include ("include/display_article_title.txt"); ?> </h1><br />
Просмотрено <?PHP include ("include/display_article_views.txt"); ?> раз(а) | <A HREF=<?PHP include ("include/movie_link.txt"); ?>>Перейти к фильму</A><br />
<div class="articlecontent"><h3><img src="images/articleicon.gif" alt="<? print "$site"; ?>" /> Статья</h3>
<div class="filmarticlebgr"></div><div class="filmarticlebg">
<?PHP include ("include/display_article_content.txt"); ?></div>
<br/><strong>Оригинал: <?PHP include ("include/display_article_reference.txt"); ?></strong> | <A HREF=<?PHP include ("include/movie_link.txt"); ?>>Перейти к фильму</A>
</div>
<?php include("include/footer.php"); ?>
 