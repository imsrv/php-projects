<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Manage pages.</p>
</div>

<div class="wrapper">

<div style="width: 510px;">

    <table style="width: 100%;"><tr style="font-weight: bold; text-align: left;"><td style="width: 25%;">Options</td><td style="width: 40%;">Subject</td><td>Creation date</td></tr></table>
    {loop:entries}
    <table style="width: 100%; text-align: left; font-size: 12px;">
     <tr>
      <td style="width: 25%;">
        <input type="button" class="button" value="Edit" onclick="location.href = 'index.php?page=blog&amp;act=edit&amp;id={entries.id}';" />
        <input type="button" value="Delete" class="button" onclick="if (confirm('Do you really want to delete this blog entry?')) { location.href = 'index.php?page=blog&amp;act=delete&amp;id={entries.id}'; }" />                  
      </td>
      <td style="width: 40%;">{entries.title}</td>
      <td>{entries.date}</td>
     </tr>
    </table>
    {endloop:entries}

    <div class="Vspace"></div>
  
</div>

</div>