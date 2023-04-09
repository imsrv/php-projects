<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Manage contact messages.</p>
</div>

<table style="width: 80%; text-align: left;">
  <tr style="font-size: 12px; font-weight: bold; color: #435e82;">
    <td>Name</td>
    <td>Subject</td>
    <td>Date</td>
    <td></td>
    <td></td>
    <td>Replied?</td>
  </tr>
  {loop:contacts}
  <tr style="background-color: {contacts.wasread}">
    <td>{contacts.name}</td>
    <td>{contacts.subject}</td>
    <td>{contacts.date}</td>
    <td><a href="index.php?page=contacts&amp;act=read&amp;id={contacts.id}" class="link">Read</a></td>
    <td><a href="index.php?page=contacts&amp;act=delete&amp;id={contacts.id}" class="link" onclick="return confirm('Do you really want to delete this message?');">Delete</a></td>
    <td style="font-weight: bold">{contacts.wasreplied}</td>
  </tr>
  {endloop:contacts}
</table>