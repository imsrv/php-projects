<?xml version="1.0" ?>
<!-- Chapter 8\XSLT1.xsl -->
<xsl:stylesheet version="1.0" 
       xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
  <h4>Accounts</h4>
  <table border="1" cellpadding="5">
    <thead><th>Acct Number</th><th>Name</th>
    <th>Balance</th><th>State</th></thead>

    <xsl:for-each select="Bank/Account[State='OH']" >
      <tr align="center">
	<td><xsl:value-of select="@AccountNo"/></td>
	<td><xsl:value-of select="Name"/></td>
	<td><xsl:value-of select="State"/></td>
	<td><xsl:value-of select="Balance"/></td>
     </tr>
   </xsl:for-each>
  </table>
 </xsl:template>
</xsl:stylesheet>
