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
	/// Summary description for adminCustomer.
	/// </summary>
	public class adminCustomer : System.Web.Services.WebService
	{
		public adminCustomer()
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

		
		protected OleDbConnection customerAdminConn = new OleDbConnection();	
		protected void init()
		{
			this.customerAdminConn.ConnectionString = @"Provider=SQLOLEDB.1;Persist Security Info=False;User ID=dotthatcom;password = 49Niners;Initial Catalog=dotthatcom;Data Source=orange.wahju.com;Use Procedure for Prepare=1;Auto Translate=True;Packet Size=4096;Workstation ID=UBID;Use Encryption for Data=False;Tag with column collation when possible=False";
			
			// shopDb local string @"Provider=SQLOLEDB.1;Persist Security Info=False;User ID=sa; password= password; Initial Catalog=shopDb;Data Source=MAUNALANI";
			
		}

		protected string ExecuteQuery( OleDbCommand QueryObject)
		{
			this.customerAdminConn.Open();
			int queryResult = QueryObject.ExecuteNonQuery();

			if ( queryResult != 0)
			{
				this.customerAdminConn.Close();
				return "Success" ;
			}
			else
			{
				return "error: QueryResult= " + queryResult;
			}
		}
		

		[ WebMethod(Description="Adds a new Customer to the customer table",EnableSession=false)]
		public string addCust(string CT_FirstName,string CT_LastName, string CT_Email,string CT_Password)
		{
			
			try
			{
				this.init();
				OleDbCommand addCust = new OleDbCommand("AdminAddCustomer",this.customerAdminConn);
				addCust.CommandType = CommandType.StoredProcedure;


				OleDbParameter addCT_FirstName =   addCust.Parameters.Add("@CT_FirstName",OleDbType.Char,20);
				addCT_FirstName.Value = CT_FirstName;

				OleDbParameter addCT_LastName =   addCust.Parameters.Add("@CT_LastName",OleDbType.Char,50);
				addCT_LastName.Value = CT_LastName;

				OleDbParameter addCT_Email =   addCust.Parameters.Add("@CT_Email",OleDbType.Char,75);
				addCT_Email.Value = CT_Email;

				OleDbParameter addCT_Password =   addCust.Parameters.Add("@CT_Password",OleDbType.Char,6);
				addCT_Password.Value = CT_Password;


				
				
				return this.ExecuteQuery( addCust );
			}
			catch(Exception e)
			{
				return e.ToString();
			}
		}



		[ WebMethod(Description="Removes a  customer from the customer table",EnableSession=false)]
		public string removeCust(int CT_ID)
		{
			try
			{
				this.init();
				OleDbCommand removeCust = new OleDbCommand("AdminDeleteCustomer",this.customerAdminConn);
				removeCust.CommandType = CommandType.StoredProcedure;

				OleDbParameter removeCT_ID =   removeCust.Parameters.Add("@CT_ID",OleDbType.Integer,4);
				removeCT_ID.Value = CT_ID;
				
				return this.ExecuteQuery( removeCust );
			
			}
			catch(Exception e)
			{
				return e.ToString();
				
			}
		}
		
		
		[ WebMethod(Description="Updates a  customer in the customer table",EnableSession=false)]
		public string updateCust(int CT_ID,string CT_FirstName,string CT_LastName, string CT_Email,string CT_Password)
		{
			try
			{
				
				this.init();
				OleDbCommand updateCust = new OleDbCommand("AdminUpdateCustomer",this.customerAdminConn);
				updateCust.CommandType = CommandType.StoredProcedure;


				OleDbParameter updateCT_ID =   updateCust.Parameters.Add("@CT_ID",OleDbType.Integer,4);
				updateCT_ID.Value = CT_ID;


				OleDbParameter updateCT_FirstName =   updateCust.Parameters.Add("@CT_FirstName",OleDbType.Char,20);
				updateCT_FirstName.Value = CT_FirstName;

				OleDbParameter updateCT_LastName =   updateCust.Parameters.Add("@CT_LastName",OleDbType.Char,50);
				updateCT_LastName.Value = CT_LastName;

				OleDbParameter updateCT_Email =   updateCust.Parameters.Add("@CT_Email",OleDbType.Char,75);
				updateCT_Email.Value = CT_Email;

				OleDbParameter updateCT_Password =   updateCust.Parameters.Add("@CT_Password",OleDbType.Char,6);
				updateCT_Password.Value = CT_Password;


								
				return this.ExecuteQuery( updateCust);

			}
			catch(Exception e)
			{
				return e.ToString();
				
			}
		}








	}
}
