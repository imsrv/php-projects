{*
+----------------------------------------------------------------------
| Template: glossary.tpl
| 
| This template is used to display the Glossary, which lists all
| glossary terms in the database.
+----------------------------------------------------------------------
*}
{include file="header.tpl" action="Glossary"}

<h2>
	Glossary
</h2>

<br />
<img src="{$image_dir}/glossary.gif" align="middle" alt="" /> 

{if $num_glossary_terms }
	Terms in glossary: <strong>{$num_glossary_terms}</strong>.
{else}
	There are no terms in the glossary.
{/if}

<br /><br />

{foreach item=glossary_term from=$glossary_terms}
	<strong>{$glossary_term.term}</strong>
	<br />
	<span class="lore_small_font">
		{$glossary_term.definition}
	</span>
	<br />
	<img src="{$image_dir}/arrow.gif" alt=""> <a class="lore_small_link" href="{$lore_system.scripts.search}?query={$glossary_term.term}">Show related articles</a>
	<div>&nbsp;</div>
{/foreach}

{include file="footer.tpl"}
