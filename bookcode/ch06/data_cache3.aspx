<SCRIPT language="VB" runat=server>

Private Shared OnRemove as CacheItemRemovedCallback = Nothing

Public Sub RemovedCallback(key as string, value as object, reason as CacheItemRemovedReason)
    'At this point, place any code needing to be executed upon an item's removal
    'As an example, we will now recache the object after making a change.
    value=value & " *recached due to reason code " & reason & "*<br>"
    cache.insert(key, value, nothing, datetime.maxvalue, timespan.fromseconds(10))
End Sub 'RemovedCallback

Sub Page_Load(source As Object, e As EventArgs)
    onRemove = New CacheItemRemovedCallback(AddressOf Me.RemovedCallback)

    dim MyValue as string
    MyValue=cache("MyKey")
    if MyValue <> nothing then  
       output.text=MyValue & "<P>This data retrieved from cache"
       'Now we'll remove the item from cache, just to trigger the event
       Cache.Remove("MyKey")
    else
       Dim StringArray() As string ={"Amy", "Bob", "Chris", "Damien", "Eli", "Franklin", "Gerald"}
       dim DependentString() as string ={server.mappath("test.txt"), server.mappath("test2.txt")}
       dim MyString as string

       for each MyString in StringArray
          output.Text=output.Text & MyString & "<br>"
       next
       
       cache.insert("MyKey", output.text, nothing, datetime.maxvalue, timespan.fromseconds(10), CacheItemPriority.Low, CacheItemPriorityDecay.Fast, onRemove)

    end if
End Sub
</SCRIPT>


<HTML>
<HEAD>
</HEAD>
<BODY>
    <P><asp:label id="output" runat="server"/>
</BODY>
</HTML>
