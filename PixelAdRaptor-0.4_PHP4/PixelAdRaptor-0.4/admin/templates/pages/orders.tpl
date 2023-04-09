<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Pending orders.</p>
</div>

{loop:ads}
<table style="width: 100%; text-align: left; background-color: {cycle:#fbfbfb|#ffffff};">
 <tr><td style="font-weight: bold; width: 20%;">Name</td><td>{ads.name}</td></tr>
 <tr><td style="font-weight: bold; width: 20%;">Email</td><td><a href="mailto:{ads.email}" class="link">{ads.email}</a></td></tr>
 <tr><td style="font-weight: bold; width: 20%;">Position</td><td>X - {ads.x} Y - {ads.y}</td></tr>
 <tr><td style="font-weight: bold; width: 20%;">Ad title</td><td>{ads.title}</td></tr>
 <tr><td style="font-weight: bold; width: 20%;">Ad link</td><td><a href="{ads.link}" class="link">{ads.link}</a></td></tr>
 <tr><td style="font-weight: bold; width: 20%;">Ad size</td><td>{ads.size}px</td></tr>
 <tr><td style="font-weight: bold; width: 20%;">Ad image</td><td><img src="../images/{ads.file}" alt="Ad image" /></td></tr>
 <tr><td style="font-weight: bold; width: 20%;">Ad price</td><td>${ads.price}</td></tr> 
 <tr><td style="font-weight: bold; width: 20%;">Order date</td><td>{ads.date}</td></tr>
 <tr>
   <td>
     <a href="#" class="link" onclick="if (confirm('Do you really want to delete this ad? It is not recommended!!!')) { location.href = 'index.php?page=orders&amp;act=delete&amp;id={ads.id}'; }">Delete</a>
   </td>
   <td>
     <a href="#" class="link" onclick="if (confirm('Do you really want to approve this ad?')) { location.href = 'index.php?page=orders&amp;act=approve&amp;id={ads.id}'; }">Approve</a>   
   </td>
 </tr>
</table>
{endloop:ads}
        
