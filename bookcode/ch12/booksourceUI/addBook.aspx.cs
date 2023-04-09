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
	/// Summary description for addBook.
	/// </summary>
	public class addBook : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.TextBox txtISBN;
		protected System.Web.UI.WebControls.TextBox txtAuthor;
		protected System.Web.UI.WebControls.RequiredFieldValidator passAuthor;
		protected System.Web.UI.WebControls.TextBox txtPrice;
		protected System.Web.UI.WebControls.RequiredFieldValidator passPrice;
		protected System.Web.UI.WebControls.TextBox txtTitle;
		protected System.Web.UI.WebControls.RequiredFieldValidator passTitle;
		protected System.Web.UI.WebControls.TextBox txtDesc;
		protected System.Web.UI.WebControls.RequiredFieldValidator passDesc;
		protected System.Web.UI.WebControls.DropDownList listCat;
		protected System.Web.UI.WebControls.TextBox txtPath;
		protected System.Web.UI.WebControls.Button Button1;
		protected System.Web.UI.WebControls.Label addBookLabel;
		protected System.Web.UI.WebControls.RequiredFieldValidator passPath;
		protected System.Web.UI.WebControls.RequiredFieldValidator passISBN;
		protected System.Web.UI.HtmlControls.HtmlForm loginCustomer;
		protected DataTable Dt;
		protected DataView myView;
		protected WebReference1.getCategories Category = new WebReference1.getCategories();
		protected DataSet Ds;
		protected WebReference1.sellerAdmin addNewBook;


		public addBook()
		{
			Page.Init += new System.EventHandler(Page_Init);
		}

		private void Page_Load(object sender, System.EventArgs e)
		{
			Dt = Category.AllCat().Tables["Categories"];
			myView = new DataView(Dt);
			if (!IsPostBack) 
			{
				listCat.DataSource = myView;
				listCat.DataBind();
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
			this.Button1.Click += new System.EventHandler(this.Button1_Click);
			this.Load += new System.EventHandler(this.Page_Load);

		}
		#endregion

		private void Button1_Click(object sender, System.EventArgs e)
		{

			string addISBN;
			string addAuthor;
			double addPrice;
			string addTitle;
			string addDescription;
			int addCatId;
			string addPath;
			string resultAdd;


			addISBN = txtISBN.Text;
			addAuthor = txtAuthor.Text;
			addPrice = double.Parse(txtPrice.Text);
			addTitle = txtTitle.Text;
			addDescription = txtDesc.Text;
			addCatId =int.Parse(listCat.SelectedItem.Value);
			addPath = txtPath.Text;

			addNewBook = new WebReference1.sellerAdmin();

			resultAdd = addNewBook.addItem(addISBN,addAuthor,addPrice,addTitle,addDescription,addPath,addCatId);
			if (resultAdd == "Success")
			{
				addBookLabel.Text="Book added to database.";
				Server.Transfer("adminPage.aspx");
			}
			else
			{
				addBookLabel.Text="Error on insert." + resultAdd;
			}
		}

		
	}
}
