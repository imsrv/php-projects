<?

class Hook
{
    function head()
    {
?>
<div id='logo'>
    <a href="index.php" <?=Page::target()?> title='SiteBar Homepage'>
        <?=Skin::img('logo')?>
    </a>
</div>
<?
    }

    function foot($version)
    {
?>
<div id='powered'>
    <div id='by'>
        Powered by <strong><a href='http://www.sitebar.org/' <?=Page::target()?>>SiteBar</a></strong> ver. <?=$version?>
    </div>
<?=Hook::sponsor()?>
    <div id='design'>
        Skin designed by <a href='http://www.alexisisaac.net/' <?=Page::target()?>>Alexis Isaac</a>
    </div>
</div>
<?
    }

    function sponsor()
    {
?>
    <div class='sponsor'>
        <a href="http://sourceforge.net/" <?=Page::target()?>>
            <img src="http://sourceforge.net/sflogo.php?group_id=76467&amp;type=2"
                 alt="SourceForge.net Logo">
        </a>
    </div>
<?
    }
}
?>
