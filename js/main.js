jQuery(function() {
	var favoriteRoutes = $('[id^=get_stop_monitoring_]').length;
    var timeoutId = null;

    function get_stop_monitoring(id) {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/v1/get_stop_monitoring',
            type: 'POST',
            dataType: 'json',
            data: { line_id: $('#line_id_'+id).val(), 
                    stop_id_start: $('#stop_id_start_'+id).val(), 
                    stop_id_end: $('#stop_id_end_'+id).val()
            },
            success: function(json) {
            	alert("success");
				var data = "";
				for (var i = 0; i < json.AimedArrivalTime.length; i++) {
					var ArrivalTime = json.AimedArrivalTime[i].ArrivalTime;
					var ArrivalMinutes = json.AimedArrivalTime[i].ArrivalMinutes;
					if (ArrivalMinutes < 2)
						data = ArrivalTime + "     ETA: DUE NOW";
					else
						data = ArrivalTime + "     ETA: " + ArrivalMinutes + " minutes";
					$('#arrival_time_'+(i+1)).html(data);
				}
            	// $('#json_result').html(JSON.stringify(json));
            	for (let j = 0; j <= favoriteRoutes; j++) {
            		$('#get_stop_monitoring_'+j).attr("disabled", true);
            	}
            },
            complete: function() {
            	alert("complete");
                jQuery('#get_stop_monitoring_'+id).hide();
                jQuery('#exit_'+id).show();
                timeoutId = setTimeout(function(){get_stop_monitoring(id);}, 60000);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ERROR");
			}
        });
    }

    function exit(id) {
        clearTimeout(timeoutId);
        jQuery('#exit_'+id).hide();
        jQuery('#get_stop_monitoring_'+id).show();
        for (let j = 0; j <= favoriteRoutes; j++) {
	        $('#get_stop_monitoring_'+j).attr("disabled", false);
    	}
    }

	for (let id = 0; id <= favoriteRoutes; id++) {
    	jQuery('#exit_'+id).hide();
	    $('#exit_'+id).click( function(){exit(id);} );
	    $('#get_stop_monitoring_'+id).click( function(){get_stop_monitoring(id);} );
	}
});

function test(id) {
	alert(id);
    get_stop_monitoring(id);
}

// function getRoutes(value) {
// 	alert("getRoutes");
// 	var line_id = value.split(",")[0];
//     var direction = value.split(",")[1];

//     $.ajax({
//         url: 'http://127.0.0.1/getroutes.php',
//         type: 'GET',
//         data: 'line_id='+line_id+'&direction='+direction,
//         success: function(data) {
//         	alert("success");
//         	document.getElementById("search_start_route").innerHTML = data;
//         },
//         complete: function() {
//         	alert("complete");
//         },
//         error: function(XMLHttpRequest, textStatus, errorThrown) {
// 			alert("ERROR");
// 		}
//     });
// }

// function routeCallback(data) {
// 	alert("routeCallback");
// }

// function getRoutes(value) {
// 	alert("getRoutes");
// 	var line_id = value.split(",")[0];
//     var direction = value.split(",")[1];

//     $.ajax({
//         url: 'http://127.0.0.1/getroutes.php?callback=?',
//         type: 'POST',
//         data: { line_id : line_id,
//         		direction : direction
//     	},
//     	dataType: 'jsonp',
//     	jsonpCallback: "routeCallback",
//         success: function(data) {
//         	alert("success");
//         	document.getElementById("search_start_route").innerHTML = data;
//         },
//         complete: function() {
//         	alert("complete");
//         },
//         error: function(XMLHttpRequest, textStatus, errorThrown) {
// 			alert("ERROR");
// 		}
//     });
// }

// JQuery(function getRoutes(value) {
// 	var line_id = value.split(",")[0];
//     var direction = value.split(",")[1];
//     // if (value == "") {
//     //     document.getElementById("search_start_route").innerHTML = "";
//     //     return;
//     // } else {
//     //     if (window.XMLHttpRequest) {
//     //         // code for IE7+, Firefox, Chrome, Opera, Safari
//     //         xmlhttp = new XMLHttpRequest();
//     //     } else {
//     //         // code for IE6, IE5
//     //         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//     //     }
//     //     xmlhttp.onreadystatechange = function() {
//     //         if (this.readyState == 4 && this.status == 200) {
//     //         	alert("SUCCESS");
//     //             document.getElementById("search_start_route").innerHTML = this.responseText;
//     //             alert(this.responseText);
//     //         } else {
//     //         	alert("FAIL");
//     //         }
//     //     };
//     //     xmlhttp.open("GET","http://127.0.0.1:8080/getroutes.php?line_id="+line_id+"&direction="+direction,true);
//     //     // xmlhttp.open("GET","getroutes.php?line_id="+line_id+"&direction="+direction,true);
//     //     xmlhttp.send();   
//     // }

//     $.ajax({
//         url: 'http://127.0.0.1:8080/getroutes.php',
//         type: 'GET',
//         data: 'line_id='+line_id+'&direction='+direction,
//         success: function(data) {
//         	alert(data);
// 			// var data = "";
// 			// for (var i = 0; i < json.AimedArrivalTime.length; i++) {
// 			// 	var ArrivalTime = json.AimedArrivalTime[i].ArrivalTime;
// 			// 	var ArrivalMinutes = json.AimedArrivalTime[i].ArrivalMinutes;
// 			// 	if (ArrivalMinutes < 2)
// 			// 		data = ArrivalTime + "     ETA: DUE NOW";
// 			// 	else
// 			// 		data = ArrivalTime + "     ETA: " + ArrivalMinutes + " minutes";
// 			// 	$('#arrival_time_'+(i+1)).html(data);
// 			// }
//    //      	// $('#json_result').html(JSON.stringify(json));
//    //      	for (let j = 1; j <= favoriteRoutes; j++) {
//    //      		$('#get_stop_monitoring_'+j).attr("disabled", true);
//    //      	}
//         },
//         complete: function() {
//         	alert("complete");
//             // jQuery('#get_stop_monitoring_'+id).hide();
//             // jQuery('#exit_'+id).show();
//             // timeoutId = setTimeout(function(){get_stop_monitoring(id);}, 60000);
//         },
//         error: function(XMLHttpRequest, textStatus, errorThrown) {
// 			alert("ERROR");
// 		}
//     });
// });
