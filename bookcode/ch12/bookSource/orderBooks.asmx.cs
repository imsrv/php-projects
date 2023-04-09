using System;
using System.Collections;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Web;
using System.Web.Services;
using System.Data.OleDb;

namespace bookSource
{
	/// <summary>
	/// Summary description for orderBooks.
	/// </summary>
	public class orderBooks : System.Web.Services.WebService
	{
		public orderBooks()
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
		

		protected OleDbConnection orderBooksConn = new OleDbConnection();	
		protected void init()
		{
			this.orderBooksConn.ConnectionString = @"Provider=SQLOLEDB.1;Persist Security Info=False;User ID=dotthatcom;password = 49Niners;Initial Catalog=dotthatcom;Data Source=orange.wahju.com;Use Procedure for Prepare=1;Auto Translate=True;Packet Size=4096;Workstation ID=UBID;Use Encryption for Data=False;Tag with column collation when possible=False";
			
		}


		protected string ExecuteQuery( OleDbCommand QueryObject)
		{
			this.orderBooksConn.Open();
			int queryResult = QueryObject.ExecuteNonQuery();

			if ( queryResult != 0)
			{
				this.orderBooksConn.Close();
				return "Success";
			}
			else
			{
				return "error: QueryResult= " + queryResult;
			}
		}




		[WebMethod(Description="This will input books into the database",EnableSession=false)] 
		public string orderIem(int CT_ID ,string BK_ISBN ,int BKOR_Quantity ,double BKOR_Price)
		{
				
			try
			{
				this.init();
				OleDbCommand orderIem = new OleDbCommand("OrderBook",this.orderBooksConn);
				orderIem.CommandType = CommandType.StoredProcedure;


				OleDbParameter addCT_ID =   orderIem.Parameters.Add("@CT_ID",OleDbType.Integer,4);
				addCT_ID.Value = CT_ID;

				OleDbParameter addBK_ISBN =   orderIem.Parameters.Add("@BK_ISBN",OleDbType.Char,80);
				addBK_ISBN.Value = BK_ISBN;

				OleDbParameter addBKOR_Quantity =   orderIem.Parameters.Add("@BKOR_Quantity",OleDbType.Integer,2);
				addBKOR_Quantity.Value = BKOR_Quantity;

				OleDbParameter addBKOR_Price =   orderIem.Parameters.Add("@BKOR_Price",OleDbType.Currency,8);
				addBKOR_Price.Value = BKOR_Price;
				
				
				return this.ExecuteQuery( orderIem );
			}
			catch(Exception e)
			{
				return e.ToString();
			}
		}




		
	}
}
