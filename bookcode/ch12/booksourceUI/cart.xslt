<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" />
	<!--
		assumption - cart format will be the following:
		<shopcart-items userID="int">
			<book>
			*	<isbn/>
			*	<title/>
				<description/>
			*	<price/>
				<categoryName/>
				<categoryID/>
			*	<quantity/>
			</book>
		</shopcart-items>
		
	-->
	<xsl:template match="//shopcart-items[Books]">
		<style>
			<xsl:comment>
				th
				{
					text-decoration:underline;
					background-color:red;
					font-family:verdana,arial,sans-serif;
					color:white;
				}
				.header
				{
					background-color:red;
				}
		</xsl:comment>
		</style>
		<div id="CartDisplay" align="center" style="height:100%;background-color:cornsilk; padding:1em">
			<table border="1" bordercolor="silver" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table width="300px" border="0" cellpadding="3px" cellspacing="0">
							<tr>
								<td class="header">&#160;</td>
								<th>Title</th>
								<td class="header">&#160;</td>
								<td class="header">&#160;</td>
								<th>Price</th>
							</tr>
							<xsl:for-each select="//Books">
								<xsl:sort select="title" />
								<tr>
									<xsl:attribute name="bgcolor">
										<!-- alternate background color in the cart table -->
										<xsl:choose>
											<xsl:when test="position()mod 2 > 0 ">
												<xsl:text>white</xsl:text>
											</xsl:when>
											<xsl:otherwise>
												<xsl:text>#dcdcdc</xsl:text>
											</xsl:otherwise>
										</xsl:choose>
									</xsl:attribute>
									<td align="center">
										<input type="button" value="Remove">
											<xsl:attribute name="id">item<xsl:value-of select="position()" /></xsl:attribute>
											<xsl:attribute name="name">item<xsl:value-of select="position()" /></xsl:attribute>
											<xsl:attribute name="onclick">removeItemFromCart('<xsl:value-of select="isbn" />')</xsl:attribute>
										</input>
									</td>
									<td colspan="3" align="left" style="font-family:verdana,arial,sans-serif;font-size:8pt">
										<xsl:value-of select="title" />
									</td>
									<td align="right">
							$<xsl:value-of select="price" />
						</td>
								</tr>
							</xsl:for-each>
							<tr>
								<td colspan="2" bgcolor="#dcdcdc">&#160;</td>
								<td colspan="2" bgcolor="#dcdcdc">sub-total</td>
								<td align="right" bgcolor="#ffffff">
							$<xsl:value-of select="sum(//price)" />
						</td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#dcdcdc">&#160;</td>
								<td colspan="2" bgcolor="#dcdcdc">tax 8%</td>
								<td align="right" bgcolor="#ffffff">
							$<xsl:value-of select="format-number( sum(//price) * .08 , '#,##0.00')" />
						</td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#dcdcdc">&#160;</td>
								<td colspan="2" bgcolor="#dcdcdc">shipping</td>
								<td align="right" bgcolor="#ffffff" style="text-decoration:underline">
									<xsl:text>$6.95</xsl:text>
								</td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#dcdcdc">&#160;</td>
								<td colspan="2" bgcolor="#dcdcdc">total</td>
								<td align="right" bgcolor="#ffffff">
							$<xsl:value-of select="format-number( sum(//price) * 1.08 + 6.95, '#,##0.00') " />
						</td>
							</tr>
							<tr>
								<td colspan="4" bgcolor="#dcdcdc">&#160;</td>
								<td bgcolor="#ffffff">
									<input type="button" value="checkout" onclick="checkOut()" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</xsl:template>
</xsl:stylesheet>
