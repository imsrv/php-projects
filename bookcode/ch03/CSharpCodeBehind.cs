// Chapter\CSharpCodeBehind.cs
namespace myCsCodeBehind
{ using System;
  using System.Web.UI.WebControls;
   public class cSharpCb : System.Web.UI.Page
  {  public System.Web.UI.WebControls.ListBox lstFlowers;
     public System.Web.UI.WebControls.Label lblMessage;
     public System.Web.UI.WebControls.Button btnSubmit;
     protected void Page_Load(object sender, EventArgs e)
     { if  (!IsPostBack)
       {   lblMessage.Text = "No Selection Yet";
      	   lstFlowers.Items.Add(new ListItem("Tulip"));
           lstFlowers.Items.Add(new ListItem("Redbud"));
           lstFlowers.Items.Add(new ListItem("Poppy"));
       }
      }  
      protected void showSelection(object obj, EventArgs e)
      {        lblMessage.Text = "You have selected " + lstFlowers.SelectedItem.Text;
      }
    }
  }
