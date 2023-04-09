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
	/// Summary description for adminPage.
	/// </summary>
	public class adminPage : System.Web.UI.Page
	{
		protected DataTable Dt;
		protected DataView myView;
		protected WebReference1.getBooks Books = new WebReference1.getBooks();
		protected WebReference1.sellerAdmin removeBook = new WebReference1.sellerAdmin();
		protected DataSet Ds;
		protected System.Web.UI.WebControls.Label errorLabel;
		protected System.Web.UI.WebControls.HyperLink addBookLink;
		protected System.Web.UI.WebControls.DataGrid changeBooks;
	
		public adminPage()
		{
			Page.Init += new System.EventHandler(Page_Init);
		}

		private void Page_Load(object sender, System.EventArgs e)
		{
			Dt = Books.AllBooks().Tables["Books"];
			myView = new DataView(Dt);
			myView.Sort = "isbn";
			if (!IsPostBack) 
			{
				changeBooks.DataSource = myView;
				changeBooks.DataBind();
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
			this.changeBooks.PageIndexChanged += new System.Web.UI.WebControls.DataGridPageChangedEventHandler(this.changeBooks_PageIndexChanged);
			this.changeBooks.CancelCommand += new System.Web.UI.WebControls.DataGridCommandEventHandler(this.changeBooks_CancelCommand);
			this.changeBooks.EditCommand += new System.Web.UI.WebControls.DataGridCommandEventHandler(this.changeBooks_EditCommand);
			this.changeBooks.UpdateCommand += new System.Web.UI.WebControls.DataGridCommandEventHandler(this.changeBooks_UpdateCommand);
			this.changeBooks.DeleteCommand += new System.Web.UI.WebControls.DataGridCommandEventHandler(this.changeBooks_DeleteCommand);
			this.Load += new System.EventHandler(this.Page_Load);

		}
		#endregion

		private void changeBooks_CancelCommand(object source, System.Web.UI.WebControls.DataGridCommandEventArgs e)
		{
			changeBooks.EditItemIndex = -1;
			changeBooks.DataSource = myView;
			changeBooks.DataBind();
		}

		private void changeBooks_DeleteCommand(object source, System.Web.UI.WebControls.DataGridCommandEventArgs e)
		{

			string upISBN = e.Item.Cells[2].Text;


			myView.RowFilter = "isbn='"+upISBN+"'";
			if (myView.Count > 0) 
			{
				
				myView.Delete(0);
			}
			myView.RowFilter = "";

			changeBooks.EditItemIndex = -1;
			changeBooks.DataSource = myView;
			changeBooks.DataBind();


			//now delete from the database

			string results = removeBook.removeItem(upISBN);
			if (results == "Success")
			{
				errorLabel.Text = "Book Deleted from database!";
			}
			else
			{
				errorLabel.Text = results;
			
			}
		}

		

		private void changeBooks_UpdateCommand(object source, System.Web.UI.WebControls.DataGridCommandEventArgs e)
		{
			
			string upISBN = e.Item.Cells[2].Text;
			string upAuthor = ((TextBox)e.Item.Cells[3].Controls[0]).Text;
			double upPrice = double.Parse(((TextBox)e.Item.Cells[4].Controls[0]).Text);
			string upTitle = ((TextBox)e.Item.Cells[5].Controls[0]).Text;
			string upDescription = ((TextBox)e.Item.Cells[6].Controls[0]).Text;
			int upCatId = int.Parse(e.Item.Cells[7].Text);	
			string upImage = ((TextBox)e.Item.Cells[8].Controls[0]).Text;
			
			myView.RowFilter = "isbn='"+upISBN+"'";
			if (myView.Count > 0) 
			{
				
				myView.Delete(0);
			}
			myView.RowFilter = "";

			
			DataRow dr = Dt.NewRow();
			dr["isbn"] = upISBN;
			dr["author"] = upAuthor;
			dr["price"] = upPrice;
			dr["title"] = upTitle;
			dr["description"] = upDescription;
			dr["id"] = upCatId;
			dr["imgSrc"] = upImage;


			Dt.Rows.Add(dr);

			changeBooks.EditItemIndex = -1;
			changeBooks.DataSource = myView;
			changeBooks.DataBind();

			// Now update the database with the new data
			
			WebReference1.sellerAdmin newData = new WebReference1.sellerAdmin();

			string results;
			results = newData.updateItem(upISBN,upAuthor,upPrice,upTitle,upDescription,upImage,upCatId);

			if (results == "Success")
			{
				errorLabel.Text = "Book Updated to database!";
			}
			else
			{
				errorLabel.Text = results;
			
			}




		}

		private void changeBooks_EditCommand(object source, System.Web.UI.WebControls.DataGridCommandEventArgs e)
		{
			changeBooks.EditItemIndex = (int)e.Item.ItemIndex;
			changeBooks.DataSource = myView;
			changeBooks.DataBind();
		}

		private void changeBooks_PageIndexChanged(object source, System.Web.UI.WebControls.DataGridPageChangedEventArgs e)
		{
			changeBooks.CurrentPageIndex = e.NewPageIndex;
			changeBooks.DataSource = myView;
			changeBooks.DataBind();
		}

	

		
	}
}
