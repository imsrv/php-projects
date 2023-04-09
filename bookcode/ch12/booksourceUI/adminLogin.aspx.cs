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
	/// Summary description for adminLogin.
	/// </summary>
	public class adminLogin : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Button submitLogin;
		protected System.Web.UI.WebControls.Label loginLabel;
		protected System.Web.UI.WebControls.RequiredFieldValidator passUser;
		protected System.Web.UI.WebControls.TextBox txtUser;
		protected System.Web.UI.WebControls.TextBox txtUPassword;
		protected System.Web.UI.HtmlControls.HtmlForm loginUser;
		protected System.Web.UI.WebControls.RequiredFieldValidator passUValid;
	
		public adminLogin()
		{
			Page.Init += new System.EventHandler(Page_Init);
		}

		private void Page_Load(object sender, System.EventArgs e)
		{
			// Put user code to initialize the page here
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
			if((txtUser.Text=="sa")&&(txtUPassword.Text=="password"))
			{
				loginLabel.Text="Welcome Administrator!";
				Server.Transfer("adminPage.aspx");
			
			}
			else
			{
				loginLabel.Text="Not correct Admin password!";
			}
		}
	}
}
