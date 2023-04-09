using System;
using System.Data;
using System.Data.SqlClient;
using System.Data.SqlTypes;
using System.Data.OleDb;

namespace Chapter7_cs
{
	///	<summary>
	///	Summary	description	for	CDalAddress.
	///	</summary>
	public class CDalAddress
	{
		string strConStr;
		string strError;
		SqlConnection oConn;
		// OleDbConnection oConn;
		
		public string strConnection
		{
			get
			{ 
				return strConStr;
			}
			set
			{
				strConStr = value;
				try
				{
					this.oConn = new SqlConnection(value);
					// oConn = new OleDbConnection(value);
				}
				catch (Exception e)
				{
					throw e;
				}
			}
		}
		public SqlDataReader getAll()
		{
			string strSQL =	"EXEC usp_tblAddress_sel";
			SqlCommand oCmd	= new SqlCommand(strSQL, oConn);
			// OleDbCommand	oCmd = new OleDbCommand(strSQL,	oConn);
			oCmd.CommandType = CommandType.Text;

			try
			{
				if (oConn.State	== ConnectionState.Closed)
				{
					oConn.Open();
				}
				return oCmd.ExecuteReader();
			}
			catch (Exception e)
			{
				throw e;
			}
		}

		public SqlDataReader getByID(Int32 AdrsID)
		{
			string strSQL = strSQL = "EXEC usp_tblAddress_sel_ByID " + AdrsID.ToString();
			SqlCommand oCmd = new SqlCommand(strSQL, oConn);
			oCmd.CommandType = CommandType.Text;

			try
			{
				if (oConn.State == ConnectionState.Closed)
				{
					oConn.Open();
				}
				return oCmd.ExecuteReader();
			}
			catch (Exception e)
			{
				throw e;
			}
		}

		public Int32 Add(string FName,
			string LName,
			string Phone,
			string EMail,
			string WebPage,
			Int16 Age,
			string Comments)
		{
			SqlCommand oCmd; 
			SqlParameter oParam;  
			string strSQL;  
			Int32 AdrsID;  

			strSQL = "usp_tblAddress_ins";

			oCmd = new SqlCommand(strSQL, oConn);
			oCmd.CommandType = CommandType.StoredProcedure;

			oParam = oCmd.Parameters.Add("@AdrsID", SqlDbType.Int, 4);
			oParam.Direction = ParameterDirection.Output;

			oCmd.Parameters.Add("@FName", SqlDbType.VarChar, 50).Value = FName;
			oCmd.Parameters.Add("@LName", SqlDbType.VarChar, 50).Value = LName;
			oCmd.Parameters.Add("@Phone", SqlDbType.VarChar, 15).Value = Phone;
			oCmd.Parameters.Add("@EMail", SqlDbType.VarChar, 255).Value = EMail;
			oCmd.Parameters.Add("@WebPage", SqlDbType.VarChar, 255).Value = WebPage;
			oCmd.Parameters.Add("@Age", SqlDbType.TinyInt, 2).Value = Age;
			oCmd.Parameters.Add("@Comments", SqlDbType.VarChar, 2000).Value = Comments;

			try
			{
				if (oConn.State == ConnectionState.Closed)
				{
					oConn.Open();
				}
				oCmd.ExecuteNonQuery();
				AdrsID = (Int32)oCmd.Parameters["@AdrsID"].Value;
				return AdrsID;
			}
			catch (Exception oErr)
			{
				throw oErr;
			}
		}
		public void Update(Int32 AdrsID,
						string FName,
						string LName,
						string Phone,
						string EMail,
						string WebPage,
						Int16 Age,
						string Comments)
		{
         SqlConnection oConn;
         SqlCommand oCmd;
         SqlParameter oParam;
         string strSQL;

        strSQL = "usp_tblAddress_upd";

        oConn = new SqlConnection(strConStr);
        oCmd = new SqlCommand(strSQL, oConn);
        oCmd.CommandType = CommandType.StoredProcedure;
        oCmd.Parameters.Add("@AdrsID", SqlDbType.Int, 4).Value = AdrsID;
        oCmd.Parameters.Add("@FName", SqlDbType.VarChar, 50).Value = FName;
        oCmd.Parameters.Add("@LName", SqlDbType.VarChar, 50).Value = LName;
        oCmd.Parameters.Add("@Phone", SqlDbType.VarChar, 15).Value = Phone;
        oCmd.Parameters.Add("@EMail", SqlDbType.VarChar, 255).Value = EMail;
        oCmd.Parameters.Add("@WebPage", SqlDbType.VarChar, 255).Value = WebPage;
        oCmd.Parameters.Add("@Age", SqlDbType.TinyInt, 2).Value = Age;
        oCmd.Parameters.Add("@Comments", SqlDbType.VarChar, 2000).Value = Comments;

			try
			{
				if (oConn.State == ConnectionState.Closed)
				{
					oConn.Open();
				}
				oCmd.ExecuteNonQuery();
			}
			catch (Exception oErr)
			{
				throw oErr;
			}
		}

		public void Delete(Int32 AdrsID)
		{
			string strSQL = "EXEC usp_tblAddress_del " + AdrsID;
			SqlCommand oCmd = new SqlCommand(strSQL, oConn);
			oCmd.CommandType = CommandType.Text;

			try
			{
				if (oConn.State == ConnectionState.Closed)
				{
					oConn.Open();
				}
				oCmd.ExecuteNonQuery();
			}
			catch (Exception oErr)
			{
				throw oErr;
			}
		}

	}
}
