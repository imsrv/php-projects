; <?php die('access denied'); ?>

; if you want to display if you office is open either by text
; or image, use=TEXT for text or use=IMAGE for image.
use=IMAGE

; if your server isn't on the same time zone as your office then
; you will need to adjust this it is in decimal hours.
; ie: 8.5 for 8 hours 30 mins ahead or -8 for 8 hours behind
time_offset=0

[hours_open]
; open & closed should be in 24 hour time without the colon
; ie: 7pm should be 1900 or 9.30am should be 0930
open=1105
close=1700

[days_open]
; include the days that you are open
; english days are mon,tue,wed,thu,fri,sat,sun
days=mon,tue,wed,thu,fri

[holidays]
; separate months will have public holidays
; ie dec=25,26 ( Christmas and Boxing Day ) are days that you would be closed.
jan=1,26
feb=
mar=8
apr=25
may=6
jun=
jul=
aug=
sep=
oct=
nov=
dec=25,26

[images]
; what images that you use for being open and closed.
open="./open.gif"
close="./closed.gif"

[text]
; what text should be displayed if opened or closed.
open="office open"
close="office closed"

