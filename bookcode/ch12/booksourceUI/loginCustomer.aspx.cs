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
	/// Summary description for loginCustomer.
	/// </summary>
	public class loginCustomer : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.TextBox txtEmail;
		protected System.Web.UI.WebControls.RequiredFieldValidator passEmail;
		protected System.Web.UI.WebControls.TextBox txtPassword;
		protected System.Web.UI.WebControls.RequiredFieldValidator passValid;
		protected System.Web.UI.WebControls.Button submitLogin;
		protected System.Web.UI.WebControls.Label loginLabel;
		protected WebReference1.loginCustomer loggedCust;
		

		public loginCustomer()		{
			Page.Init += new System.EventHandler(Page_Init);
		}

		private void Page_Load(object sender, System.EventArgs e)
			{
			if(Session["userId"]!=null)
			{
				Server.Transfer("updateCustomerInfo.aspx");
			}

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
			
			validEmail = txtEmail.Text;
			validPassword = txtPassword.Text;


			loggedCust = new WebReference1.loginCustomer();
			
			string resultId = loggedCust.validCustomer(validEmail,validPassword);
			if(resultId == "-1")
			{
				loginLabel.Text = "Invalid Login please re-enter your password and email!";
			
			
			}
			else
			{
				loginLabel.Text ="Welcome";
				Session["userId"] = int.Parse(resultId);
				Server.Transfer((string)Session["return2Page"]);
			}


		}
	}
}
