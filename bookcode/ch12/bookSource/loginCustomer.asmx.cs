using System;
using System.Collections;
using System.ComponentModel;
using System.Data;
using System.Data.OleDb;	
using System.Diagnostics;
using System.Web;
using System.Web.Services;

namespace bookSource
{
	/// <summary>
	/// Summary description for loginCustomer.
	/// </summary>
	public class loginCustomer : System.Web.Services.WebService
	{
		public loginCustomer()
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
		
		


		[WebMethod(Description="This will log a customer into the shopDb and return the customers Id",EnableSession=false)] 
		public string validCustomer(string CT_Email, string CT_Password)
		{
		
			string source = "Provider=SQLOLEDB.1;Persist Security Info=False;User ID=dotthatcom;password = 49Niners;Initial Catalog=dotthatcom;Data Source=orange.wahju.com;Use Procedure for Prepare=1;Auto Translate=True;Packet Size=4096;Workstation ID=UBID;Use Encryption for Data=False;Tag with column collation when possible=False";

			// shopDb string "Provider=SQLOLEDB.1;Persist Security Info=False;User ID=sa; password= password; Initial Catalog=shopDb;Data Source=MAUNALANI" ;
			
			
			OleDbConnection conn = new OleDbConnection ( source ) ;
			
			conn.Open ( ) ;
			OleDbCommand  cmd = new OleDbCommand ( "LoginCustomers" , conn ) ;
			cmd.CommandType = CommandType.StoredProcedure;
				
			OleDbParameter passEmail = cmd.Parameters.Add("@CT_Email",OleDbType.Char,75); 
			passEmail.Value = CT_Email;

			OleDbParameter passPassword = cmd.Parameters.Add("@CT_Password",OleDbType.Char,6); 
			passPassword.Value = CT_Password;

			
			OleDbDataAdapter da = new OleDbDataAdapter (cmd) ;
			DataSet ds = new DataSet ( ) ;
			da.Fill ( ds , "Customers" ) ;
			conn.Close();
			try
			{
	
				string resultId = ds.Tables["customers"].Rows[0][0].ToString();
				return resultId;			
			}
			catch(Exception e)
			{
				return  "-1";

			}
			
		}
		}
	
}
