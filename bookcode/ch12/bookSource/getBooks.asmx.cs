using System;
using System.Collections;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Web;
using System.Web.Services;
using System.Xml;
using System.Data.OleDb;

namespace bookSource
{
	/// <summary>
	/// Summary description for getBooks.
	/// </summary>
	public class getBooks : System.Web.Services.WebService
	{
		public getBooks()
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

		[WebMethod(Description="This will return all books in an XML String",EnableSession=false)] 
		public DataSet AllBooks()
		{
		
			string source = "Provider=SQLOLEDB.1;Persist Security Info=False;User ID=dotthatcom;password = 49Niners;Initial Catalog=dotthatcom;Data Source=orange.wahju.com;Use Procedure for Prepare=1;Auto Translate=True;Packet Size=4096;Workstation ID=UBID;Use Encryption for Data=False;Tag with column collation when possible=False";

			// shopDb string "Provider=SQLOLEDB.1;Persist Security Info=False;User ID=sa; password= password; Initial Catalog=shopDb;Data Source=MAUNALANI" ;
				
				OleDbConnection conn = new OleDbConnection ( source ) ;
			
				conn.Open ( ) ;
				OleDbCommand  cmd = new OleDbCommand ( "GetAllBooks" , conn ) ;
				cmd.CommandType = CommandType.StoredProcedure;

				OleDbDataAdapter da = new OleDbDataAdapter (cmd) ;
				DataSet ds = new DataSet ( ) ;
				da.Fill ( ds , "Books" ) ;
				conn.Close();
				
				return ds;
		}
		[WebMethod(Description="This will return all books in an XML String based on the catagory sent",EnableSession=false)] 
		public DataSet AllBooksByCat(int catId)
		{
		
			string source = "Provider=SQLOLEDB.1;Persist Security Info=False;User ID=dotthatcom;password = 49Niners;Initial Catalog=dotthatcom;Data Source=orange.wahju.com;Use Procedure for Prepare=1;Auto Translate=True;Packet Size=4096;Workstation ID=UBID;Use Encryption for Data=False;Tag with column collation when possible=False";

			// shopDb string "Provider=SQLOLEDB.1;Persist Security Info=False;User ID=sa; password= password; Initial Catalog=shopDb;Data Source=MAUNALANI" ;
			
			
			OleDbConnection conn = new OleDbConnection ( source ) ;
			
				conn.Open ( ) ;
				OleDbCommand  cmd = new OleDbCommand ( "GetAllBooksByCat" , conn ) ;
				cmd.CommandType = CommandType.StoredProcedure;
				OleDbParameter passCat = cmd.Parameters.Add("@CAT_ID",OleDbType.Integer,1); 
				passCat.Value = catId;

				OleDbDataAdapter da = new OleDbDataAdapter (cmd) ;
				DataSet ds = new DataSet ( ) ;
				da.Fill ( ds , "Books" ) ;
				conn.Close();
				
				return ds;
		}
		
		

		
	}
}
