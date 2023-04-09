<?xml version="1.0" ?>
<!-- Chapter 8\order.xsl -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="xml" indent="yes" />
<xsl:template match="/">
	<Order>
		 <Date>
		 <xsl:value-of select="/Order/Date/Year" />/
		 <xsl:value-of select="/Order/Date/Month" />/
		 <xsl:value-of select="/Order/Date/Day" />
		 </Date>
		 <Customer>Company A</Customer>
		 <Item> 
                <xsl:apply-templates select="/Order/Item" />
			 <Quantity><xsl:value-of select="/Order/Quantity" /></Quantity>
		 </Item>
	</Order>
</xsl:template>
<xsl:template match="Item">
   <Sku>
		<xsl:choose>
		<xsl:when test=". ='50 GPM Pump'">P 25-16:3</xsl:when>
		<xsl:when test=". ='100 GPM Pump'">P 35-12:5</xsl:when>
		<!--other Sku would go here-->
		<xsl:otherwise>00</xsl:otherwise>
		</xsl:choose>
   </Sku>
	<Description>
		<xsl:value-of select="." />
	</Description>
</xsl:template>
</xsl:stylesheet>
