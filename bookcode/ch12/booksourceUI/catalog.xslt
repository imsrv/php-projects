<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html"/>
	<!-- expected data format:
			<Books>
				<isbn>1928994296</isbn> 
				<imgSrc>isawin.gif</imgSrc> 
				<author>Thomas W. Shinder</author> 
				<price>49.55</price> 
				<title>Configuring ISA Server 2000</title> 
				<description>The complete guide to implementing ISA Server in the Enterprise</description> 
			</Books>
			<Summary>
				<RecordCount>17</RecordCount> 
				<FirstItemIndex>1</FirstItemIndex> 
				<LastItemIndex>6</LastItemIndex> 
			</Summary>

	-->
	<xsl:template match="/" >
		<style>
			<xsl:comment>
				.prevNextText
				{
					font-family: verdana, arial, sans-serif;
					font-size: 8pt;
				}
			</xsl:comment>
		</style>
		<xsl:variable name="first" select="//FirstItemIndex"/>
		<xsl:variable name="last" select="//LastItemIndex"/>
		<xsl:variable name="count" select="//RecordCount"/>
		
		<div id="CatalogDisplay">
			<span class="prevNextText">	
				<a href="#">
					<xsl:choose>
						<xsl:when test="$first = 0">
							<xsl:attribute name="style">color:gray;cursor:default;text-decoration:none;</xsl:attribute>
							<xsl:attribute name="onclick">return false</xsl:attribute>
						</xsl:when>
						<xsl:otherwise>
							<xsl:attribute name="style">color:blue;</xsl:attribute>
							<xsl:attribute name="onclick">postData(<xsl:value-of select="$first"/>,<xsl:value-of select="$last"/>,'previous',<xsl:value-of select="$count"/>);return false</xsl:attribute>
							<xsl:attribute name="title">view previous<xsl:value-of select="$first - $last" /></xsl:attribute>
						</xsl:otherwise>
					</xsl:choose>	
					previous</a>
				&#160;|&#160;<xsl:value-of select="$first" /> - <xsl:value-of select="$last" /> of <xsl:value-of select="$count" />&#160;|&#160;
				<a href="#">
					<xsl:attribute name="title">view next<xsl:value-of select="$first - $last" /></xsl:attribute>
					<xsl:choose>
						<xsl:when test="$last = $count">
							<xsl:attribute name="style">color:silver;cursor:arrow;text-decoration:none;</xsl:attribute>
							<xsl:attribute name="onclick">return false</xsl:attribute>
						</xsl:when>
						<xsl:otherwise>
							<xsl:attribute name="style">color:blue;</xsl:attribute>
							<xsl:attribute name="onclick">postData(<xsl:value-of select="$first"/>,<xsl:value-of select="$last"/>,'next',<xsl:value-of select="$count"/>);return false</xsl:attribute>
						</xsl:otherwise>					
					</xsl:choose>	
					next
				</a>
			</span>
			
			<br /><br />	
			
			<table border="0" cellpadding="1" cellspacing="1">
				<xsl:for-each select="//Books">
					<tr>
						<td valign="top">
							<input type="button" value="Add" title="add to shopping cart">
								<xsl:attribute name="name">btn<xsl:value-of select="position()"/></xsl:attribute>
								<xsl:attribute name="id">btn<xsl:value-of select="position()"/></xsl:attribute>
								<xsl:attribute name="onclick">addItem2Cart('<xsl:value-of select="isbn"/>')</xsl:attribute>				
							</input>
						</td>
						<td valign="top">
							<img border="0" align="left" width="80px" height="100px">
								<xsl:attribute name="src">Images/<xsl:value-of select="imgSrc" /></xsl:attribute>
								<xsl:attribute name="alt"><xsl:value-of select="title" /></xsl:attribute>
							</img>
						</td>
						<td valign="top">
							<h4 style="color:blue;">
								<xsl:value-of select="title" />
							</h4>
							<xsl:value-of select="description" />
						</td>
					</tr>
					<tr>
						<td colspan="3"><br /><hr /><br /></td>
					</tr>
				</xsl:for-each>
				
			</table>	
			
		</div>
		
		<!-- Repeat   < previous  and next > controls at the bottom of the page -->
			<span class="prevNextText">	
				<a href="#">
					<xsl:choose>
						<xsl:when test="$first = 0">
							<xsl:attribute name="style">color:gray;cursor:default;text-decoration:none;</xsl:attribute>
							<xsl:attribute name="onclick">return false</xsl:attribute>
						</xsl:when>
						<xsl:otherwise>
							<xsl:attribute name="style">color:blue;</xsl:attribute>
							<xsl:attribute name="onclick">postData(<xsl:value-of select="$first"/>,<xsl:value-of select="$last"/>,'previous',<xsl:value-of select="$count"/>);return false</xsl:attribute>
							<xsl:attribute name="title">view previous<xsl:value-of select="$first - $last" /></xsl:attribute>
						</xsl:otherwise>
					</xsl:choose>	
					previous</a>
				&#160;|&#160;<xsl:value-of select="$first" /> - <xsl:value-of select="$last" /> of <xsl:value-of select="$count" />&#160;|&#160;
				<a href="#">
					<xsl:attribute name="title">view next<xsl:value-of select="$first - $last" /></xsl:attribute>
					<xsl:choose>
						<xsl:when test="$last = $count">
							<xsl:attribute name="style">color:silver;cursor:arrow;text-decoration:none;</xsl:attribute>
							<xsl:attribute name="onclick">return false</xsl:attribute>
						</xsl:when>
						<xsl:otherwise>
							<xsl:attribute name="style">color:blue;</xsl:attribute>
							<xsl:attribute name="onclick">postData(<xsl:value-of select="$first"/>,<xsl:value-of select="$last"/>,'next',<xsl:value-of select="$count"/>);return false</xsl:attribute>
						</xsl:otherwise>					
					</xsl:choose>	
					next
				</a>
			</span>
			<input type="hidden" name="initialize">
				<xsl:attribute name="value"><xsl:text>postData(</xsl:text><xsl:value-of select="$first"/><xsl:text>,</xsl:text><xsl:value-of select="$last"/><xsl:text>,'previous',</xsl:text><xsl:value-of select="$count"/><xsl:text>)</xsl:text></xsl:attribute>
			</input>
				
					
			
	</xsl:template>

</xsl:stylesheet>

  