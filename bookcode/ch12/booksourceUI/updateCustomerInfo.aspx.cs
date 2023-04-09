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
	/// Summary description for WebForm1.
	/// </summary>
	public class WebForm1 : System.Web.UI.Page
	{
	
		public WebForm1()
		{
			Page.Init += new System.EventHandler(Page_Init);
		}

		protected DataTable Dt;
		protected DataView myView;
		protected WebReference1.getCustomer Customers = new WebReference1.getCustomer();
		protected DataSet Ds;
		protected System.Web.UI.HtmlControls.HtmlForm Form1;
		protected System.Web.UI.WebControls.DataGrid custGrid;
		
		
	
		


		protected	void Page_Load(Object sender, EventArgs e) 
		{
			
			if(Session["userId"]==null)
			{
				Session["return2Page"]="updateCustomerInfo.aspx";
				Server.Transfer("loginCustomer.aspx");
			}
			else
			{
					Dt = Customers.AllCustById((int)Session["userId"]).Tables["Customers"];
					myView = new DataView(Dt);
					myView.Sort = "CT_ID";
					
					if (!IsPostBack) 
					{
						custGrid.DataSource = myView;
						custGrid.DataBind();
					}
			}
		}

		public void custGrid_Edit(Object sender, DataGridCommandEventArgs e) 
		{
			custGrid.EditItemIndex = (int)e.Item.ItemIndex;
			custGrid.DataSource = myView;
			custGrid.DataBind();
		}

		public void custGrid_Cancel(Object sender, DataGridCommandEventArgs e) 
		{
			custGrid.EditItemIndex = -1;
			custGrid.DataSource = myView;
			custGrid.DataBind();
		}

		public void custGrid_Update(Object sender, DataGridCommandEventArgs e) 
		{
			
			int upId = int.Parse(e.Item.Cells[1].Text);
			string upFName = ((TextBox)e.Item.Cells[2].Controls[0]).Text;
			string upLName = ((TextBox)e.Item.Cells[3].Controls[0]).Text;
			string upEmail = ((TextBox)e.Item.Cells[4].Controls[0]).Text;
			string upPassword = ((TextBox)e.Item.Cells[5].Controls[0]).Text;
					
			
			myView.RowFilter = "CT_ID='"+upId+"'";
			if (myView.Count > 0) 
			{
				
				myView.Delete(0);
			}
			myView.RowFilter = "";

			
			DataRow dr = Dt.NewRow();
			dr[0] = upId;
			dr[1] = upFName;
			dr[2] = upLName;
			dr[3] = upEmail;
			dr[4] = upPassword;


			Dt.Rows.Add(dr);

			custGrid.EditItemIndex = -1;
			custGrid.DataSource = myView;
			custGrid.DataBind();


			// Now update the database with the new data
			
			WebReference1.adminCustomer newData = new WebReference1.adminCustomer();

			newData.updateCust(upId,upFName,upLName,upEmail,upPassword);

			

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
			this.Load += new System.EventHandler(this.Page_Load);

		}
		#endregion

		
			
		
	}
}
