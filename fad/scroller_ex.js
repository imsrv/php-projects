//THIS JAVASCRIPT IS BEEN USED WITH PERMISSON (ACCORDING TO THE TERMS OF USE FOR www.codethat.com//
//PLEASE AGREE TO CodeThat.Com TERMS OF USE BEFORE USING THIS SCRIPT IN ANY OTHER MATTER//

// CodeThatCalendar STANDARD
// Version: 1.3.3 (21.04.2004.1)
// THE SCRIPT IS FREE FOR NON-COMMERCIAL AND COMMERCIAL USE.
// Copyright (c) 2003-2004 by CodeThat.Com
// http://www.codethat.com/

		var caldef1 = {
			firstday:0,     // First day of the week: 0 means Sunday, 1 means Monday, etc.
			dtype:'MM/dd/yyyy', // Output date format MM-month, dd-date, yyyy-year, HH-hours, mm-minutes, ss-seconds
			width:250,       // Width of the calendar table
			windoww:270,     // Width of the calendar window
			windowh:200,     // Height of the calendar window
			border_width:1,      // Border of the table
			border_color:'yellow',  // Color of the border
			dn_css:'clsDayName',     // CSS for week day names
			cd_css:'clsCurrentDay',  // CSS for current day
			wd_css:'clsWorkDay',     // CSS for work days (this month)
			we_css:'clsWeekEnd',     // CSS for weekend days (this month)
			wdom_css:'clsWorkDayOtherMonth', // CSS for work days (other month)
			weom_css:'clsWeekEndOtherMonth', // CSS for weekend days (other month)
			headerstyle: {
				type:'buttons',         // Type of the header may be: 'buttons' or 'comboboxes'
				css:'clsDayName',       // CSS for header
				imgnextm:'images/next.gif', // Image for next month button. 
				imgprevm:'images/prev.gif',    // Image for previous month button. 
				imgnexty:'images/next_year.gif', // Image for next year button. 
				imgprevy:'images/prev_year.gif'     // Image for previous year button. 
			},
			// Array with month names
			monthnames :["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			// Array with week day names
			daynames : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]

			
		};
