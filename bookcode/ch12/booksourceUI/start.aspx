<%@ Page language="c#" Codebehind="start.aspx.cs" AutoEventWireup="false" Inherits="bookSourceUI.StartPageUI" %>
<%@ OutputCache Duration="1" VaryByParam="none" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<meta content="Microsoft Visual Studio 7.0" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript (ECMAScript)" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<script language="javascript">
		function resetCartMessengers(){
			formstart.addItem.value = "";	 // prevents unintended addition of items to cart
			formstart.removeItem.value = ""; // prevents unintended removal of items from cart
			formstart.Ready4Checkout.value = "false";
		}
		
		function fillData(first,last,direction, recordcount){
			resetCartMessengers();
			formstart.firstRecord.value = first;
			formstart.lastRecord.value = last ;
			formstart.direction.value = direction;
			formstart.recordCount.value = recordcount;
		}
		
		function postData(first,last,direction, recordcount){
			fillData(first,last,direction, recordcount);
			formstart.submit();
		}
		
		function addItem2Cart(item){
			formstart.removeItem.value = ""; // prevents unintended removal of items from cart
			formstart.addItem.value = item;
			formstart.submit();
		}
		
		function removeItemFromCart(item){
			formstart.addItem.value = "";	 // prevents unintended addition of items to cart
			formstart.removeItem.value = item;
			formstart.submit();
		}
		
		function initializePagevariables(){
			if( formstart.firstRecord.value.length == 0){
				eval(formstart.initialize.value);
			}
		}
		
		function checkOut(){
			resetCartMessengers()
			formstart.Ready4Checkout.value = "true";
			formstart.submit();
		}
		
	</script>
	</HEAD>
	<body onload="initializePagevariables()">
		<!-- #Include file="header.htm" -->
		<form id="formstart" method="post" runat="server">
			<div style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; WIDTH: 800px; COLOR: white; PADDING-TOP: 3px; BACKGROUND-COLOR: dimgray" align="left">
				View Books by Category
				<asp:dropdownlist id="CategoryList" runat="server" DataValueField="CAT_ID" DataTextField="CAT_Name"></asp:dropdownlist>
				<input type="button" id="btnGo" value="Go !" onclick="formstart.categoryState.value='Go';formstart.submit();">
			</div>
			<table width="800">
				<tr>
					<td>
						<asp:xml id="catalog" runat="server"></asp:xml>
					</td>
					<td valign="top" align="middle" bgcolor="cornsilk">
						<asp:xml id="cart" runat="server"></asp:xml>
						<br>
						<asp:Label id="lblFeedBack" runat="server"></asp:Label>
					</td>
				</tr>
			</table>
			<div style="VISIBILITY: hidden">
				<asp:textbox id="addItem" runat="server" AutoPostBack="True"></asp:textbox>
				<asp:TextBox id="removeItem" runat="server" AutoPostBack="True"></asp:TextBox>
				<asp:textbox id="firstRecord" runat="server" AutoPostBack="True"></asp:textbox>
				<asp:textbox id="lastRecord" runat="server" AutoPostBack="True"></asp:textbox>
				<asp:textbox id="direction" runat="server" AutoPostBack="True"></asp:textbox>
				<asp:textbox id="recordCount" runat="server" AutoPostBack="True"></asp:textbox>
				<asp:TextBox id="categoryState" runat="server" AutoPostBack="True"></asp:TextBox>
				<asp:TextBox id="Ready4Checkout" runat="server" AutoPostBack="True"></asp:TextBox>
			</div>
		</form>
	</body>
</HTML>
