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
using System.Configuration;

namespace Chapter7_cs
{
	/// <summary>
	/// Summary description for Address.
	/// </summary>
	public class Address : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Label Label1;
		protected System.Web.UI.WebControls.DataList dlAddress;
		protected System.Web.UI.WebControls.Button cmdAddNew;
	
		public Address()
		{
			Page.Init += new System.EventHandler(Page_Init);
		}

		private void Page_Load(object sender, System.EventArgs e)
		{
			// Put user code to initialize the page here
			if (!IsPostBack)
			{
				BindData();
			}
		}

		private void BindData()
		{
			CDalAddress oDb = new CDalAddress();			
			oDb.strConnection = ConfigurationSettings.AppSettings["appStrConnection"];
		
			dlAddress.DataSource = oDb.getAll();
			dlAddress.DataBind();
			oDb = null;
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
			this.dlAddress.CancelCommand += new DataListCommandEventHandler(this.Cancel_Click);
			this.dlAddress.DeleteCommand += new DataListCommandEventHandler(this.DeleteAddress_Click);
			this.dlAddress.EditCommand += new DataListCommandEventHandler(this.EditAddress_Click);
			this.dlAddress.UpdateCommand += new DataListCommandEventHandler(this.UpdateAddress_Click);
			this.Load += new System.EventHandler(this.Page_Load);
		}
		#endregion
			
		public void addContact_Click(object s, System.EventArgs e)
		{
		// Add a blank record and set the current index to the new row.
        // display the record in edit style.
        CDalAddress oDb = new CDalAddress();
        Int32 adrsID = 0;
        
		oDb.strConnection = ConfigurationSettings.AppSettings["appStrConnection"];

        // Add a new record with some defaults.  store the New ID for the next step
        adrsID = oDb.Add("fname", "lname", "() -", "@", "http://", 0, "");

        // Use the Id above to fill the DataList in the edit mode
        dlAddress.DataSource = oDb.getByID(adrsID);
        dlAddress.EditItemIndex = 0;
        dlAddress.DataBind();
        oDb = null;
		}

		public void EditAddress_Click(object s, DataListCommandEventArgs e)
		{
			// Set the edit index to the selected row
			dlAddress.EditItemIndex = e.Item.ItemIndex;
			BindData();
		}

		public void UpdateAddress_Click(object s, DataListCommandEventArgs e)
		{
        CDalAddress oDb = new CDalAddress();
        TextBox txtAdrsID;
		TextBox txtFName;
		TextBox txtLName;
		TextBox txtPhone;
		TextBox txtEMail;
		TextBox txtWebPage;
		TextBox txtAge;
		TextBox txtComments;

        txtAdrsID = (TextBox)e.Item.FindControl("txtAdrsID");
        txtFName = (TextBox)e.Item.FindControl("txtFName");
        txtLName = (TextBox)e.Item.FindControl("txtLName");
        txtPhone = (TextBox)e.Item.FindControl("txtPhone");
        txtEMail = (TextBox)e.Item.FindControl("txtEMail");
        txtWebPage = (TextBox)e.Item.FindControl("txtWebPage");
        txtAge = (TextBox)e.Item.FindControl("txtAge");
        txtComments = (TextBox)e.Item.FindControl("txtComments");

        oDb.strConnection = ConfigurationSettings.AppSettings["appStrConnection"];

        oDb.Update(Int32.Parse(txtAdrsID.Text)
			,txtFName.Text
			,txtLName.Text
			,txtPhone.Text
			,txtEMail.Text
			,txtWebPage.Text
			,Int16.Parse(txtAge.Text)
			,txtComments.Text);

        dlAddress.EditItemIndex = -1;
        BindData();
		}

		public void DeleteAddress_Click(object s, DataListCommandEventArgs e)
		{
			CDalAddress oDb = new CDalAddress();
			TextBox txtAdrsID;

			oDb.strConnection = ConfigurationSettings.AppSettings["appStrConnection"];

			txtAdrsID = (TextBox)e.Item.FindControl("txtAdrsID");

			oDb.Delete(Int32.Parse(txtAdrsID.Text));

			// reset edit item index to nothing
			dlAddress.EditItemIndex = -1;
			BindData();
		}
		
		public void Cancel_Click(object s, DataListCommandEventArgs e)
		{
			// Clear the edit Item index
			dlAddress.EditItemIndex = -1;
			BindData();
		}
	}
}
