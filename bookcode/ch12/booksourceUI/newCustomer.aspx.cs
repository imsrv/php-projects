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

namespace bookSourceUI
{
	/// <summary>
	/// Summary description for newCustomer.
	/// </summary>
	public class newCustomer : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.TextBox txtEmail;
		protected System.Web.UI.WebControls.RequiredFieldValidator passEmail;
		protected System.Web.UI.WebControls.TextBox txtPassword;
		protected System.Web.UI.WebControls.RequiredFieldValidator passValid;
		protected System.Web.UI.WebControls.Button submitLogin;
		protected System.Web.UI.WebControls.TextBox txtFName;
		protected System.Web.UI.WebControls.RequiredFieldValidator passFName;
		protected System.Web.UI.WebControls.TextBox txtLName;
		protected System.Web.UI.WebControls.RequiredFieldValidator passLName;
		protected System.Web.UI.HtmlControls.HtmlForm loginCustomer;
		protected System.Web.UI.WebControls.Label addCustLabel;
		protected WebReference1.adminCustomer addCust;
		protected WebReference1.loginCustomer goLogin;
		public newCustomer()
		{
			Page.Init += new System.EventHandler(Page_Init);
		}

		private void Page_Load(object sender, System.EventArgs e)
		{
			
		}

		private void Page_Init(object sender, EventArgs e)
		{
			//
			// CODEGEN: This call is required by the ASP.NET Web Form Designer.
			//
			InitializeComponent();
		}

		#region Web Form Designer generated code
		/// <summary>
		/// Required method for Designer support - do not modify
		/// the contents of this method with the code editor.
		/// </summary>
		private void InitializeComponent()
		{    
			this.submitLogin.Click += new System.EventHandler(this.submitLogin_Click);
			this.Load += new System.EventHandler(this.Page_Load);

		}
		#endregion

		private void submitLogin_Click(object sender, System.EventArgs e)
		{
			string validEmail;
			string validPassword;
			string validFName;
			string validLName;

			validFName = txtFName.Text;
			validLName = txtLName.Text;
			validEmail = txtEmail.Text;
			validPassword = txtPassword.Text;


			addCust = new WebReference1.adminCustomer();
			

			string resultAdd = addCust.addCust(validFName,validLName,validEmail,validPassword);
			
			if (resultAdd == "Success")
			{
				goLogin = new WebReference1.loginCustomer();
			
				string resultId = goLogin.validCustomer(validEmail,validPassword);
				
				
				if(resultId == "-1")
				{
					addCustLabel.Text = "Unexpected Error!";
					//this should not occur but if the database returns an error we can handle it here.
			
				}
				else
				{
					addCustLabel.Text ="Welcome";
					Session["userId"] = int.Parse(resultId);
					Server.Transfer("start.aspx");
				}
			}
			else
			{
				addCustLabel.Text ="Invalid Data please re-enter.";

			}
				
			
		}
	}
}
