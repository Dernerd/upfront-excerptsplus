/* Uses UI.Dialog */
	jQuery(document).ready(function($) {
	    $.fx.speeds._default = 500;
	    $(function() {
	        $( "#quickread" ).dialog({
	        		dialogClass: "eplus-quickread",
	            autoOpen: false,
	            title: "Loading…",
	            modal: true,
	            show: "drop",
	            width:800,
	            height: 600,
	            position:["center",50],
            resizable:true

	        });

	        $( ".openquickread" ).click(function() {
	        	var self = this;
	            $("#quickread h2.qr-title" ).html($(self).attr("alt"));
	            $("#quickread .qr-content" ).html("Loading content...");
	            $("#quickread .qr-content" ).load($(self).attr("href")+" .entry-content", function(){$("#quickread .pzsp-container").empty().append("<p class='ep-pzsp-removed'>Open the full post to view slideshow</p>")});
	            $("#quickread .qr-code" ).html();
							$("#quickread .qr-meta" ).html();
							var contents = $("#quickread");
	            $(contents).dialog( "open")
	                .dialog( "option", "title", $(self).attr("alt") )
	                .dialog( "option", "buttons",
	                         {"Close": function() {$(this).dialog("close");},
	                    "Go to post": function() {$(this ).dialog( "close");window.open($(self).attr("href"),"_self");}}
	                );
	            return false;
	        });
	    });

//	        function load_qr(e) {
//	        	  var self = e;
//
//	            $("#quickread h2.qr-title" ).html($(self).attr("alt"));
//	            $("#quickread .qr-content" ).load($(self).attr("href")+" .entry-content", function(){$(".pzsp-container").empty().append("<p class='ep-pzsp-removed'>Open the full post to view slideshow</p>")});
//	            $("#quickread .qr-code" ).html();
//							$("#quickread .qr-meta" ).html();
//							var contents = $("#quickread");
//            console.log($("#quickread").innerHTML);
//            console.log(contents);
//            console.log(contents[0]);
//            var the_content = contents[0];
//            console.log(contents[0].innerHTML);
//            return contents[0].innerHTML;
//          }
//          $("a.openquickread").avgrund({
//                width: 600, // max is 640px
//                height: 800, // max is 350px THAT'S A PROBLEM!
//                showClose: true, // switch to 'true' for enabling close button
//                showCloseText: 'Close', // type your text for close button
//                closeByEscape: true, // enables closing popup by 'Esc'..
//                closeByDocument: true, // ..and by clicking document itself
//                holderClass: '', // lets you name custom class for popin holder..
//                overlayClass: '', // ..and overlay block
//                enableStackAnimation: false, // enables different type of popin's animation
//                onBlurContainer: '#whitewrap', // enables blur filter for specified block
//                openOnEvent: true, // set to 'false' to init on load
//                setEvent: 'click', // use your event like 'mouseover', 'touchmove', etc.
//                    onLoad: load_qr(this), // set custom call before popin is inited..
////                    onUnload: function (elem) { ... }, // ..and after it was closed
//                template:'how do we make it work?'
//              }
//          );


	});

// What is $(document).ready ? See: http://flowplayer.org/tools/documentation/basics.html#document_ready

// var triggers = $(".modalInput").overlay({
// 
	// // some mask tweaks suitable for modal dialogs
	// mask: {
		// color: '#ebecff',
		// loadSpeed: 200,
		// opacity: 0.9
	// },
// 
	// closeOnClick: false
// });
// 
// 
// var buttons = $("#quickread").click(function(e) {
// 	
// });
