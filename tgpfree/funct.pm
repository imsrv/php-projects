sub header {
$head = MIME::Base64::decode("PGh0bWw+PGhlYWQ+PHRpdGxlPlRHUERldmlsIEZyZWUgVEdQIFNjcmlwdDwvdGl0bGU+PG1ldGEg aHR0cC1lcXVpdj0iQ29udGVudC1UeXBlIiBjb250ZW50PSJ0ZXh0L2h0bWw7IGNoYXJzZXQ9aXNv LTg4NTktMSI+PC9oZWFkPjxib2R5IGJnY29sb3I9IiNGRkZGRkYiIHRleHQ9IiMwMDAwMDAiPjxk aXYgYWxpZ249ImNlbnRlciI+PHA+PGZvbnQgZmFjZT0iVmVyZGFuYSI+PGI+PGZvbnQgY29sb3I9 IiNGRjAwMDAiPlNvcnJ5LCB0aGlzIGZlYXR1cmUgaXMgbm90IGF2YWlsYWJsZSBpbiB0aGUgZnJl ZSB2ZXJzaW9uITwvZm9udD48L2I+PC9mb250PjwvcD48cD4mbmJzcDs8L3A+PHA+PGI+PGZvbnQg ZmFjZT0iVmVyZGFuYSIgY29sb3I9IiMwMDAwMDAiPlRoZSBmdWxsIHZlcnNpb24gY29udGFpbnMg dGhpcyBmZWF0dXJlIHBsdXMgbWFueSBtb3JlLjwvZm9udD48L2I+PC9wPjxwPiZuYnNwOzwvcD48 cD48Zm9udCBjb2xvcj0iIzAwMDAwMCI+PGI+PGZvbnQgZmFjZT0iVmVyZGFuYSI+VmlzaXQgPC9m b250PjwvYj48L2ZvbnQ+PC9wPjxwPjxmb250IGNvbG9yPSIjMDAwMDAwIj48Yj48Zm9udCBmYWNl PSJWZXJkYW5hIj48YSBocmVmPSJodHRwOi8vd3d3LnRncGRldmlsLmNvbSI+aHR0cDovL3d3dy50 Z3BkZXZpbC5jb208L2E+PC9mb250PjwvYj48L2ZvbnQ+PC9wPjxwPjxmb250IGNvbG9yPSIjMDAw MDAwIj48Yj48Zm9udCBmYWNlPSJWZXJkYW5hIj5mb3IgcHJpY2luZyBpbmZvcm1hdGlvbiBvciBl bWFpbDwvZm9udD48L2I+PC9mb250PjwvcD48cD48Zm9udCBjb2xvcj0iIzAwMDAwMCI+PGI+PGZv bnQgZmFjZT0iVmVyZGFuYSI+PGEgaHJlZj0ibWFpbHRvOnN1cHBvcnRAdGdwZGV2aWwuY29tIj5z dXBwb3J0QHRncGRldmlsLmNvbTwvYT48L2ZvbnQ+PC9iPjwvZm9udD48L3A+PC9kaXY+PC9ib2R5 PjwvaHRtbD4K");
}

sub gloc {
if ($tgp1 eq "yes") {
	$location = MIME::Base64::decode("aHR0cDovL3d3dy50Z3BiYXNlLmNvbS9kYXRhL3BhaWQvZ2FsbGVyaWVzLnBs");
	} else {
	$location = MIME::Base64::decode("aHR0cDovL3d3dy50Z3BiYXNlLmNvbS9kYXRhL2ZyZWUvZ2FsbGVyaWVzLnBs");
	}
}

sub bling {
	$bling = MIME::Base64::decode("PGh0bWw+PGhlYWQ+PHRpdGxlPkJMSU5HIEJMSU5HPC90aXRsZT48bWV0YSBodHRwLWVxdWl2PSJD b250ZW50LVR5cGUiIGNvbnRlbnQ9InRleHQvaHRtbDsgY2hhcnNldD1pc28tODg1OS0xIj48L2hl YWQ+PGJvZHkgYmdjb2xvcj0iI0ZGRkZGRiIgdGV4dD0iIzAwMDAwMCI+PGRpdiBhbGlnbj0iY2Vu dGVyIj48cD48Zm9udCBmYWNlPSJWZXJkYW5hIj5Pa2F5LCB5b3VyIFRHUCBpcyBub3cgdXAgYW5k IHJ1bm5pbmcuIFdoYXQgbm93PzwvZm9udD48L3A+PHA+PGZvbnQgZmFjZT0iVmVyZGFuYSI+T2J2 aW91c2x5LCB5b3UgYXJlIHRyeWluZyB0byBtYWtlIHNvbWUgbW9uZXkuPC9mb250PjwvcD48cD48 Zm9udCBmYWNlPSJWZXJkYW5hIj5IZXJlIGFyZSBzb21lIHNwb25zb3JzIHRoYXQgd2lsbCBoZWxw IHlvdSByYWtlIGluIHRoZSBtb25leS48L2ZvbnQ+PC9wPjxwPjxmb250IGZhY2U9IlZlcmRhbmEi PjxhIGhyZWY9Imh0dHA6Ly93d3cuZnJlZWV6aW5lYnVja3MuY29tL3BzLnBocD9zPWZlYiZ1PWZy ZWFreSI+PGI+RnJlZUV6aW5lQnVja3M8L2I+PC9hPjxicj5BbnlvbmUgY2FuIGNvbnZlcnQgd2l0 aCB0aGVzZSBndXlzLiBUaGV5IHBheSAgZm9yIGV2ZXJ5IGVtYWlsIHNpZ251cCB5b3Ugc2VuZCB0 aGVtLiBEb2Vzbid0IHNvdW5kIGxpa2UgbXVjaD8gU2VuZCAxMDAgZXZlcnkgZGF5Ljxicj5Db252 ZXJzaW9uIHJhdGlvcyBvbiBUR1AgdHJhZmZpYyBpcyBhcyBnb29kIGFzIDE6MTUuPC9mb250Pjwv cD48cD48Zm9udCBmYWNlPSJWZXJkYW5hIj48YSBocmVmPSJodHRwOi8vd3d3LnNvdWxjYXNoLmNv bS9pbmRleC5odG0/c2M5ZnJlYWt5Ij48Yj5Tb3VsQ2FzaDwvYj48L2E+PGJyPkFuIGluY3JlZGli bGUgYWZmaWxpYXRlIHByb2dyYW0uIDUwJSByZXZlbnVlIHNoYXJpbmcgKyA1MCUgb2YgcmViaWxs cy4gQnVpbGQgdXAgeW91ciByZWN1cnJpbmcgcmV2ZW51ZSB0aGUgZWFzeSB3YXkgd2l0aCB0aGVz ZSBndXlzLjxicj5Ub25zIG9mIHVuaXF1ZSwgaGlnaCBjb252ZXJ0aW5nIHNpdGVzLiBJZiB5b3Ug Y2FuJ3QgY29udmVydCB3aXRoIHRoZXNlIGd1eXMsIHlvdSdyZSBkb2luZyBzb21ldGhpbmcgd3Jv bmcuPC9mb250PjwvcD48QlI+");
}

1;
