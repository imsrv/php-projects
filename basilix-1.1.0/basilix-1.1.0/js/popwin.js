function popWin(n, u, w, h, x) {
  str = "width="+w+",height="+h+",resizable=1,status=0,scrollbars=1";
  rem = window.open(u, n, str);
  if(rem != null) {
    if(rem.opener == null)
      rem.opener = self;
  }
  if(x == 1) {
   return rem;
  }
}
