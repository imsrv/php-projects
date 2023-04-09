<%  
  Function setConnection(ByVal mUID,ByVal mPWD,ByVal mDataSource)
	Dim mObjConn
    
    Set mObjConn = CreateObject("ADODB.Connection")

    mObjConn.Open mDataSource,mUID,mPWD
    
  End Function
  
  '-------------------------------------------------
  
  Sub setDisconnection(ByRef mObjCon)
    If isobject(mObjCon) Then
      mObjCon.Close
    End If
  End Sub
  
  '-------------------------------------------------
  
  SUB exeCmd(ByRef mObjConn, ByVal str, ByVal mUID,ByVal mPWD,ByVal mDataSource)
  
	IF Not isobject(mObjConn) THEN
		Set mObjConn = CreateObject("ADODB.Connection")
		mObjConn.Open mDataSource,mUID,mPWD
	END IF
  
	mObjConn.Execute (str)
	
  END SUB

  '-------------------------------------------------
  
  FUNCTION Funcexe(ByRef mObjConn, ByVal str, ByVal mUID,ByVal mPWD,ByVal mDataSource)
	Dim FuncRS
	
	IF Not isobject(mObjConn) THEN
		Set mObjConn = CreateObject("ADODB.Connection")
		mObjConn.Open mDataSource,mUID,mPWD
	END IF
  
	SET FuncRS=mObjConn.Execute (str)
	
	IF NOT FuncRS.EOF THEN
		Funcexe=FuncRS(0)
	END IF

	FuncRS.close

  END FUNCTION
%>