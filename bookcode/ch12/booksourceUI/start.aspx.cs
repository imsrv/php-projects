using System;
using System.Collections;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Web;
using System.Web.SessionState;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.HtmlControls;
using System.Xml;
using System.Xml.Xsl;

namespace bookSourceUI
{
	/// <summary>
	/// Summary description for WebForm2.
	/// </summary>
	public class StartPageUI : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Xml				catalog;
		protected System.Web.UI.WebControls.Xml				cart;
		protected System.Web.UI.WebControls.DropDownList	CategoryList;
		protected System.Web.UI.WebControls.TextBox			addItem;
		protected System.Web.UI.WebControls.TextBox			removeItem;
		protected System.Web.UI.WebControls.TextBox			direction;
		protected System.Web.UI.WebControls.TextBox			firstRecord;
		protected System.Web.UI.WebControls.TextBox			lastRecord;
		protected System.Web.UI.WebControls.TextBox			recordCount;
		protected System.Web.UI.WebControls.TextBox			categoryState;
		protected System.Web.UI.WebControls.TextBox			Ready4Checkout;
		protected System.Web.UI.WebControls.Label			lblFeedBack;
		
		protected bookCatalog		BookList;
		protected xmlShoppingCart	BookCart;
		protected XmlDocument		catalogContent;
		protected XslTransform		catalogDisplay;	
		protected DataSet			dsBookList;
		protected DataSet			dsCategoryUI;
		protected DataTable			dtCategoryUI;
		protected DataView			dvCategoryUI;
		protected int				defaultRange = 5;		
		protected int				customerID;
				
		protected WebReference1.getCategories categoryListData = new WebReference1.getCategories();		
	
		public StartPageUI()
		{
			Page.Init += new System.EventHandler(Page_Init);
		}

		private void Page_Load(object sender, System.EventArgs e)
		{
			//Load Categories from Database and bind to List control
			dtCategoryUI = categoryListData.AllCat().Tables["Categories"];
			dvCategoryUI = new DataView(dtCategoryUI);
			if(!IsPostBack)
			{
				CategoryList.DataSource = dvCategoryUI;
				CategoryList.DataBind();
			}
			
			showCatalog();		//initialize catalog
			showCart();			//initialize cart   

			if( addItem.Text != null && addItem.Text !="" )
			{
				//add item isbn to cart
				XmlDocument newBook = new XmlDocument();
				newBook.LoadXml( BookList.catalogItemDetails( (string)addItem.Text ).GetXml() );
				BookCart.addItem2Cart(newBook);
				//update Session variable that holds cart state
				Session["myShoppingCart"] = BookCart.getCartDescription().OuterXml;
				//rewrite cart to page
				showCart();
			}

			if( removeItem.Text != null && removeItem.Text != "" )
			{
				//remove item isbn from cart
				BookCart.removeItemFromCart( removeItem.Text );
				//update Session variable that holds cart state
				Session["myShoppingCart"] = BookCart.getCartDescription().OuterXml;
				//rewrite cart to page
				showCart();

			}

			if( Ready4Checkout.Text == "true")
			{
				//(1) check if customer is logged in, if not send to login
				//int customerID = 2;// (int)Session["userId"];
				if( (Session["userId"] == null) )
				{	//user is not logged in. 
					//store return page
					Session["return2page"] = "start.aspx";
					Server.Transfer("loginCustomer.aspx");
                }
				else
				{
					int	customerID = (int)Session["userId"];
					
				}
				int quantity =1;
				//(2) process order
				WebReference1.orderBooks order = new WebReference1.orderBooks();
				
					XmlDocument myOrder = BookCart.getCartDescription();
					string feedback  = "<table border='1' cellspacing='0' bordercolor='silver' width='300px' bgcolor='#ffffff' style='margin:3px'>" ;
						   feedback += "<tr><td colspan=2 bgcolor='silver'>Thank you for your order. The following items are being shipped to you:</td></tr>";
					//Order and remove items from cart
					while (myOrder.SelectNodes("//Books").Count > 0){
						string isbn = myOrder.GetElementsByTagName("Books").Item(0).SelectSingleNode("//isbn").InnerText;
						double price = double.Parse( myOrder.GetElementsByTagName("Books").Item(0).SelectSingleNode("//price").InnerText );
						string title = myOrder.GetElementsByTagName("Books").Item(0).SelectSingleNode("//title").InnerText;
						order.orderIem(customerID,isbn, quantity, price );
						feedback += "<tr><td style='font-size:8pt'>" + title +"</td><td>" + price.ToString() + "</td></tr>";
						myOrder.FirstChild.RemoveChild( myOrder.SelectNodes("//Books").Item(0) );
					}	
					feedback += "</table>";
					lblFeedBack.Text = feedback;
					Ready4Checkout.Text = "false";
					
					//BookCart.clearCart(); // empty virtual cart
					Session["myShoppingCart"] = BookCart.getCartDescription().OuterXml; // update server variable to prevent refilling of cart
			}
			
		}

		private void Page_Init(object sender, EventArgs e)
		{
			//
			// CODEGEN: This call is required by the ASP.NET Web Form Designer.
			//
			InitializeComponent();
		}

		public void showCart()
		{
			XmlDocument cartContent;	
			XslTransform cartDisplay;

			BookCart = new xmlShoppingCart();
			string xmlCart = (string)Session["myShoppingCart"];
			BookCart.initCart(xmlCart);
			
			cartContent = new XmlDocument();
			try
			{	
				cartContent = BookCart.getCartDescription();
			}
			catch(Exception error)
			{
				Response.Write("an Error occured\n" + error.ToString());
				Response.End();
			}

			cartDisplay = new XslTransform();
			try
			{	//Load XSLT display data
				cartDisplay.Load( Server.MapPath("cart.xslt") );
			}
			catch(Exception error)
			{
				Response.Write("an Error occured\n" + error.ToString());
				Response.End();
			}

			//update asp:Xml component properties so that the transform is applied in the page
			cart.Document = cartContent;
			cart.Transform = cartDisplay;
		}

		public void showCatalog()
		{
			BookList = new bookCatalog();
			dsBookList = (DataSet)Application["AllBooks"];
			BookList.initCatalog( dsBookList );
			XmlDocument catalogContent;
			XslTransform catalogDisplay;
			

			catalogContent = new XmlDocument();	
			try
			{	
				string xstrBooklist;
				if(!IsPostBack)
				{
					//	on first load, load first 5 books ordered by title
					xstrBooklist = BookList.catalogRange(0,5).GetXml();
					}
				else
				{
					if( categoryState.Text == "Go" )
					{	
						//user has selected a category and clicked on go
						int catId = int.Parse(CategoryList.SelectedItem.Value);
						xstrBooklist = BookList.catalogByCategory( catId ).GetXml();
					}
					else
					{
						string prevNext  = direction.Text;	 // "previous" or "next"
						int totalRecords = int.Parse(recordCount.Text); // number of records from previous load
						int prevFirst	 = int.Parse(firstRecord.Text); // first record # from previous load
						int prevLast	 = int.Parse(lastRecord.Text);	// last record # from previous load
						int range		 = prevLast - prevFirst;

						switch(prevNext)
						{	
							case "previous":
							{
								if(prevFirst <= range)
								{
									xstrBooklist = BookList.catalogRange(0,range).GetXml();
								}
								else
								{
									if( range != defaultRange ) range = defaultRange;
									xstrBooklist = BookList.catalogRange((prevFirst-range-1), range).GetXml();
								}
							}break;
							case "next":
							{
								if( (prevLast + range) >= totalRecords)
								{
									int nextRange = totalRecords-prevLast-1;
									xstrBooklist = BookList.catalogRange(prevLast+1, nextRange).GetXml();
								}
								else
								{
									if( range != defaultRange ) range = defaultRange;
									xstrBooklist = BookList.catalogRange(prevLast+1, range).GetXml();
								}
							}break;							
							default: xstrBooklist = BookList.catalogRange(0,5).GetXml();
							break;
						}

					}
				}
				catalogContent.LoadXml( xstrBooklist );
			}
			catch(Exception error)
			{
				Response.Write("an Error occured\n" + error.ToString());
				Response.End();
			}
					
			catalogDisplay = new XslTransform();
			try
			{	//Load XSLT display data
				catalogDisplay.Load( Server.MapPath("catalog.xslt") );
			}
			catch(Exception error)
			{
				Response.Write("an Error occured\n" + error.ToString());
				Response.End();
			}

			//update asp:Xml component properties so that the transform is applied in the page
			catalog.Document = catalogContent;
			catalog.Transform = catalogDisplay;
					
			
		}

		public class xmlShoppingCart
		{
			protected XmlDocument myCart;
			public void initCart( string dataSource )
			{
				myCart = new XmlDocument();
				if( dataSource != null )
				{
					myCart.LoadXml(dataSource);
				}
				else
				{
					myCart.LoadXml( "<shopcart-items></shopcart-items>" );
				}
			}

			public string addItem2Cart( XmlDocument book )
			{
				try
				{
					//Import the last book node from doc2 into the original document.
					XmlNode newBook = myCart.ImportNode(book.DocumentElement.FirstChild, true);
					myCart.DocumentElement.AppendChild(newBook); 
					return "Success";
				}
				catch(Exception e)
				{
					return e.ToString();
				}
			}

			public string removeItemFromCart( string isbn )
			{
				XmlNode curnode = myCart.SelectSingleNode("//Books[isbn='" + isbn + "']");
				try
				{
					myCart.DocumentElement.RemoveChild( curnode );
					return "Success";
				}
				catch(Exception e)
				{
					return e.ToString();
				}
			}

			public void clearCart()
			{
				XmlElement root = myCart.DocumentElement;
				root.RemoveAll();
			}

			public XmlDocument getCartDescription()
			{
				return myCart;
			}

			public string getCartDescriptionString()
			{
				return myCart.OuterXml;
			}

		}

		public class bookCatalog
		{
			protected WebReference1.getBooks DataSource;
			protected DataSet dsAllBooks;
			protected DataTable dtSummary;
			
			public void initCatalog(DataSet ds )
			{
				dsAllBooks = ds;
				int recordCount = dsAllBooks.Tables[0].Rows.Count;
				try
				{
					dsAllBooks.Tables.Add( createSummaryTable(0, recordCount-1, recordCount) );
				}
				catch(Exception e)
				{
					string temp = e.ToString();
					//this fails when attempting to add the table twice
				}
			}

			public DataTable createSummaryTable(int startPos, int range, int RecordCount)
			{
				DataTable dtSummary = new DataTable("Summary");
				DataRow drSummary;
				dtSummary.Columns.Add(new DataColumn("RecordCount", typeof(int)));
				dtSummary.Columns.Add(new DataColumn("FirstItemIndex", typeof(int)));
				dtSummary.Columns.Add(new DataColumn("LastItemIndex", typeof(int)));

				drSummary = dtSummary.NewRow();
				drSummary["RecordCount"]    = RecordCount;
				drSummary["FirstItemIndex"] = startPos;
				drSummary["LastItemIndex"]  = startPos + range;
				dtSummary.Rows.Add( drSummary );

				return dtSummary;
			}

			public DataSet catalog()
			{
				return dsAllBooks;
			}

			public DataSet catalogItemDetails( string book_isbn )
			{
				return catalogRangeByCategory( -1, -1, -1, book_isbn);
			}

			public DataSet catalogRange(int startPos, int range)
			{
				return catalogRangeByCategory( startPos, range, -1, null);
			}

			public DataSet catalogByCategory( int catId)
			{
				return catalogRangeByCategory( -1, -1, catId, null);
			}

			protected DataSet catalogRangeByCategory(int startPos, int range, int catId, string book_isbn)
			{
				DataSet				dsBookRange;
				DataTable			dtBooks;
				DataTable			dtTemp;
				string				strExpr;
				string				strSort;
				DataRow[]			foundRows;
				int					endPos;
				int					RecordCount;
				DataViewRowState recState;

				dtTemp = dsAllBooks.Tables["Books"];
				dtBooks	= dtTemp.Clone();//create Empty Books Table

				if( catId == -1)
				{
					strExpr = "";
				}
				else
				{
					strExpr = "id='" + catId + "'";
				}
				
				if( book_isbn != null)
				{
					//return a single item
					strExpr = "isbn='" + book_isbn + "'";
				}

				strSort ="title";
				recState = DataViewRowState.CurrentRows;
				foundRows = dtTemp.Select(strExpr, strSort, recState);
				
				RecordCount = foundRows.Length;

				if( (startPos == -1) && (range == -1))
				{
					startPos = 0;
					range = RecordCount;
				}

				if( (startPos + range) > RecordCount)
				{
					endPos = RecordCount;
				}
				else
				{
					endPos = startPos + range;
				}

				for(int i = startPos; i < endPos; i ++)
				{
					dtBooks.ImportRow( (DataRow)foundRows[i] );
				}
				
				dsBookRange = new DataSet();
				dsBookRange.Tables.Add(	dtBooks );

				// add a summary table to the dataset
				dsBookRange.Tables.Add(  createSummaryTable( startPos, range, RecordCount)  ); 
				return dsBookRange;
			}
		}

		#region Web Form Designer generated code
		/// <summary>
		/// Required method for Designer support - do not modify
		/// the contents of this method with the code editor.
		/// </summary>
		private void InitializeComponent()
		{    
			this.Load += new System.EventHandler(this.Page_Load);

		}
		#endregion

		
	}
}
