<script LANGUAGE="JavaScript">
        <!--
        function showDate() {
        // Define days of the week.
        var weekday = new Array(7);
        weekday[1] = 'Pazar';
        weekday[2] = 'Pazartesi';
        weekday[3] = 'Sal�';
        weekday[4] = '�ar�amba';
        weekday[5] = 'Per�embe';
        weekday[6] = 'Cuma';
        weekday[7] = 'Cumartesi';
        // Define months of the year.
        var month = new Array(12);
        month[1] = 'Ocak';
        month[2] = '�ubat';
        month[3] = 'Mart';
        month[4] = 'Nisan';
        month[5] = 'May�s';
        month[6] = 'Haziran';
        month[7] = 'Temmuz';
        month[8] = 'A�ustos';
        month[9] = 'Eyl�l';
        month[10] = 'Ekim';
        month[11] = 'Kas�m';
        month[12] = 'Aral�k';
        // Get the date right now.
        var today = new Date();
yr_st = " 19";
yr = today.getYear();
if ( yr > 99 ) 
{
yr_st =" ";
if ( yr < 2000 ) yr += 1900; 
}
return today.getDate() + ' ' + month[today.getMonth()+1] + '  ' +weekday[today.getDay()+1]+'  ' +yr_st+ yr;
        }
        // -->
        </script>