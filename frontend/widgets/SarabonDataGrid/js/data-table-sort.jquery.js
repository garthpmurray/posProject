		jQuery.fn.dataTableExt.oSort['currency-asc'] = function(a,b) {
		    /* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
		    var x = a == "-" ? 0 : a.replace( /,/g, "" );
		    var y = b == "-" ? 0 : b.replace( /,/g, "" );
		     
		    /* Remove the currency sign */
		    x = x.substring( 1 );
		    y = y.substring( 1 );
		     
		    /* Parse and return */
		    x = parseFloat( x );
		    y = parseFloat( y );
		    return x - y;
		};
		 
		jQuery.fn.dataTableExt.oSort['currency-desc'] = function(a,b) {
		    /* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
		    var x = a == "-" ? 0 : a.replace( /,/g, "" );
		    var y = b == "-" ? 0 : b.replace( /,/g, "" );
		     
		    /* Remove the currency sign */
		    x = x.substring( 1 );
		    y = y.substring( 1 );
		     
		    /* Parse and return */
		    x = parseFloat( x );
		    y = parseFloat( y );
		    return y - x;
		};
		
		jQuery.fn.dataTableExt.oSort['percent-asc']  = function(a,b) {
		    var x = (a == "-") ? 0 : a.replace( /%/, "" );
		    var y = (b == "-") ? 0 : b.replace( /%/, "" );
		    x = parseFloat( x );
		    y = parseFloat( y );
		    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
		};
		 
		jQuery.fn.dataTableExt.oSort['percent-desc'] = function(a,b) {
		    var x = (a == "-") ? 0 : a.replace( /%/, "" );
		    var y = (b == "-") ? 0 : b.replace( /%/, "" );
		    x = parseFloat( x );
		    y = parseFloat( y );
		    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
		};

		jQuery.extend( jQuery.fn.dataTableExt.oSort, {
		    "num-html-pre": function ( a ) {
		        var x = a.replace( /<.*?>/g, "" );
		        return parseFloat( x );
		    },
		 
		    "num-html-asc": function ( a, b ) {
		        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		    },
		 
		    "num-html-desc": function ( a, b ) {
		        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		    }
		} );	

		jQuery.extend( jQuery.fn.dataTableExt.oSort, {
		    "formatted-num-pre": function ( a ) {
		        a = (a==="-") ? 0 : a.replace( /[^\d\-\.]/g, "" );
		        return parseFloat( a );
		    },
		 
		    "formatted-num-asc": function ( a, b ) {
		        return a - b;
		    },
		 
		    "formatted-num-desc": function ( a, b ) {
		        return b - a;
		    }
		} );