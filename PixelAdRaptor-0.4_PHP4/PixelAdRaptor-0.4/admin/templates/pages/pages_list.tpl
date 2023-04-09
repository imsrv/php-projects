<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Manage pages.</p>
</div>

<div class="wrapper">

<div style="width: 510px;">
  
    <div class="row">
      <span class="label" style="text-align: left;">Options</span>
      <span class="formw" style="font-weight: bold;">Information</span>
    </div>
    
    {loop:pages}
    <div class="row">
      <span class="label" style="width: 200px; text-align: left;">
        <input type="button" class="button" value="Edit" onclick="location.href = 'index.php?page=pages&amp;act=edit&amp;id={pages.id}';" />
        <input type="button" value="Delete" class="button" onclick="if (confirm('Do you really want to delete this page?')) { location.href = 'index.php?page=pages&amp;act=delete&amp;id={pages.id}'; }" />             
        <input type="button" value="{pages.activation}" class="button" onclick="location.href = 'index.php?page=pages&amp;act=toogle&amp;id={pages.id}';" />
      </span>
      <span class="formw" style="background-color: {pages.color}; width: 310px;">
        URL: <a href="../Static/{pages.url}" class="link">/Static/{pages.url}</a>, Created: {pages.date}
      </span>     
    </div>
    {endloop:pages}

    <div class="Vspace"></div>
  
</div>

</div>