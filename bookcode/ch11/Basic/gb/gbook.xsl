<?xml version="1.0"?>
<!-- blog xsl template -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<!-- have to find out why xsl:output doesn't work with IE -->
<!-- <xsl:output method="html" version="4.0" encoding="iso-8859-1" indent="yes"/> -->

<xsl:template match="/">
<xsl:for-each select="gbook/gbooky">
<table width="400">
<tr><font color="#FFFFFF" face="Arial Black"><xsl:value-of select="Name"/></font></tr>
<tr><font color="#FFFFFF" face="Arial Black"><xsl:value-of select="Chrono"/></font></tr>
<tr><font color="#FFFFFF" face="Arial Black"><xsl:value-of select="Email"/></font></tr>
<tr><font face="Arial, Helvetica, sans-serif" size="2" color="#C7B29A"><p><xsl:value-of select="Comments"/></p><p></p></font></tr>
</table>
</xsl:for-each>
</xsl:template>
</xsl:stylesheet>