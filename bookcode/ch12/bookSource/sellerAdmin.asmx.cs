using System;
using System.Collections;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Web;
using System.Web.Services;
using System.Data.OleDb;
using System.Xml;	

namespace bookSource
{
	/// <summary>
	/// Summary description for Service2.
	/// </summary>
	public class sellerAdmin : System.Web.Services.WebService
	{
		public sellerAdmin()
		{
			//CODEGEN: This call is required by the ASP.NET Web Services Designer
			InitializeComponent();
		}

		#region Component Designer generated code
		/// <summary>
		/// Required method for Designer support - do not modify
		/// the contents of this method with the code editor.
		/// </summary>
		private void InitializeComponent()
		{
		}
		#endregion

		/// <summary>
		/// Clean up any resources being used.
		/// </summary>
		protected override void Dispose( bool disposing )
		{
		}

		
		
		protected OleDbConnection sellerAdminConn = new OleDbConnection();	
		protected void init()
		{
			this.sellerAdminConn.ConnectionString = @"Provider=SQLOLEDB.1;Persist Security Info=False;User ID=dotthatcom;password = 49Niners;Initial Catalog=dotthatcom;Data Source=orange.wahju.com;Use Procedure for Prepare=1;Auto Translate=True;Packet Size=4096;Workstation ID=UBID;Use Encryption for Data=False;Tag with column collation when possible=False";

		//shopDb string "Provider=SQLOLEDB.1;Persist Security Info=False;User ID=sa; password= password; Initial Catalog=shopDb;Data Source=MAUNALANI";
			
		}

		protected string ExecuteQuery( OleDbCommand QueryObject)
		{
			this.sellerAdminConn.Open();
			int queryResult = QueryObject.ExecuteNonQuery();

			if ( queryResult != 0)
			{
				this.sellerAdminConn.Close();
				return "Success";
			}
			else
			{
				return "error: QueryResult= " + queryResult;
			}
		}
		

		[ WebMethod(Description="Adds a new book to the books table",EnableSession=false)]
		public string addItem(string ISBN,string author,double price, string title,string description,string imagePath, int CAT_ID)
		{
			
			try
			{
				this.init();
				OleDbCommand addItem = new OleDbCommand("AdminAddBook",this.sellerAdminConn);
				addItem.CommandType = CommandType.StoredProcedure;


				OleDbParameter addISBN =   addItem.Parameters.Add("@BK_ISBN",OleDbType.Char,15);
				addISBN.Value = ISBN;

				OleDbParameter addAuthor =   addItem.Parameters.Add("@BK_Author",OleDbType.Char,80);
				addAuthor.Value = author;

				OleDbParameter addPrice =   addItem.Parameters.Add("@BK_Price",OleDbType.Currency,8);
				addPrice.Value = price;

				OleDbParameter addTitle =   addItem.Parameters.Add("@BK_Title",OleDbType.Char,75);
				addTitle.Value = title;


				OleDbParameter addDescription =   addItem.Parameters.Add("@BK_Description",OleDbType.Char,255);
				addDescription.Value = description;

				OleDbParameter addImage =   addItem.Parameters.Add("@BK_ImagePath",OleDbType.Char,50);
				addImage.Value = imagePath;


				OleDbParameter addCatId =   addItem.Parameters.Add("@CAT_ID",OleDbType.Integer,4);
				addCatId.Value = CAT_ID;
				
				return this.ExecuteQuery( addItem );
			}
			catch(Exception e)
			{
				return e.ToString();
			}
		}



		[ WebMethod(Description="Removes a  book from the book table",EnableSession=false)]
		public string removeItem(string ISBN)
		{
			try
			{
				this.init();
				OleDbCommand removeItem = new OleDbCommand("AdminRemoveBook",this.sellerAdminConn);
				removeItem.CommandType = CommandType.StoredProcedure;

				OleDbParameter removeISBN =   removeItem.Parameters.Add("@BK_ISBN",OleDbType.Char,15);
				removeISBN.Value = ISBN;
				
				return this.ExecuteQuery( removeItem );
			
			}
			catch(Exception e)
			{
				return e.ToString();
				
			}
		}
		
		
		[ WebMethod(Description="Updates a  book in the book table",EnableSession=false)]
		public string updateItem(string ISBN,string author,double price, string title,string description,string imagePath, int CAT_ID)
		{
			try
			{
				
				this.init();
				OleDbCommand updateItem = new OleDbCommand("AdminUpdateBook",this.sellerAdminConn);
				updateItem.CommandType = CommandType.StoredProcedure;


				OleDbParameter updateISBN =   updateItem.Parameters.Add("@BK_ISBN",OleDbType.Char,15);
				updateISBN.Value = ISBN;

				OleDbParameter updateAuthor =   updateItem.Parameters.Add("@BK_Author",OleDbType.Char,90);
				updateAuthor.Value = author;

				OleDbParameter updatePrice =   updateItem.Parameters.Add("@BK_Price",OleDbType.Currency,8);
				updatePrice.Value = price;

				OleDbParameter updateTitle =   updateItem.Parameters.Add("@BK_Title",OleDbType.Char,150);
				updateTitle.Value = title;


				OleDbParameter updateDescription =   updateItem.Parameters.Add("@BK_Description",OleDbType.Char,255);
				updateDescription.Value = description;

				OleDbParameter updateImage =   updateItem.Parameters.Add("@BK_ImagePath",OleDbType.Char,50);
				updateImage.Value = imagePath;


				OleDbParameter updateCatId =   updateItem.Parameters.Add("@CAT_ID",OleDbType.Integer,2);
				updateCatId.Value = CAT_ID;
				
				return this.ExecuteQuery( updateItem );

			}
			catch(Exception e)
			{
				return e.ToString();
				
			}
		}

		

		[ WebMethod(Description="Adds a new category to the category table",EnableSession=false)]
		public string addCat(string CAT_Name)
		{
			try
			{
				
				this.init();
				OleDbCommand addCat = new OleDbCommand("AdminAddCat",this.sellerAdminConn);
				addCat.CommandType = CommandType.StoredProcedure;


				OleDbParameter addCAT_Name =   addCat.Parameters.Add("@CAT_Name",OleDbType.Char,20);
				addCAT_Name.Value = CAT_Name;


				return this.ExecuteQuery( addCat );

			}
			catch(Exception e)
			{
				return e.ToString();
				
			}
		}


		
		[ WebMethod(Description="Updates a  category from the category table",EnableSession=false)]
		public string updateCat(int CAT_ID, string CAT_Name)
		{
			try
			{
				
				this.init();
				OleDbCommand updateCat = new OleDbCommand("AdminUpdateCat",this.sellerAdminConn);
				updateCat.CommandType = CommandType.StoredProcedure;


				OleDbParameter updateCAT_ID =   updateCat.Parameters.Add("@CAT_ID",OleDbType.Integer,4);
				updateCAT_ID.Value = CAT_ID;


				OleDbParameter updateCAT_Name =   updateCat.Parameters.Add("@CAT_Name",OleDbType.Char,20);
				updateCAT_Name.Value = CAT_Name;


				return this.ExecuteQuery( updateCat );

			}
			catch(Exception e)
			{
				return e.ToString();
				
			}
		}

		[ WebMethod(Description="Removes a  category from the category table",EnableSession=false)]
		public string removeCat(int CAT_ID)
		{
			try
			{
				
				this.init();
				OleDbCommand removeCat = new OleDbCommand("AdminDeleteCat",this.sellerAdminConn);
				removeCat.CommandType = CommandType.StoredProcedure;


				OleDbParameter removeCAT_Name =   removeCat.Parameters.Add("@CAT_ID",OleDbType.Integer , 4);
				removeCAT_Name.Value = CAT_ID;


				return this.ExecuteQuery( removeCat );

			}
			catch(Exception e)
			{
				return e.ToString();
				
			}
		}



	}
}
