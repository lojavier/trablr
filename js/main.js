jQuery(function() {
    // setTimeout(function(){}, 1000);
	var favoriteRoutes = $('[id^=get_stop_monitoring_]').length;
    var timeoutId = null;

    $("#select_line_id").change(function(){get_select_stop_id_start($(this).val());});

    function get_select_stop_id_start(line_id) {
    	// alert('test '+line_id);
    	$.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/get_select_stop_id_start',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
                    line_id: line_id
            },
            success: function(json) {
            	// alert("success");
            	var form_select_stop_id_start = " \
            		<div class='select_stop_id_start'> \
            		<input type='text' id='line_id_0' value='"+line_id+"' hidden> \
					<form class='form-horizontal' role='form'> \
						<select name='select_stop_id_start' id='select_stop_id_start' style='width:100%;height:33px;'> \
						<option value='-1'>Select Start</option> \
						<option value='2'>Start ID = ?</option> \
						</select> \
					</form> \
					</div>";
				var form_select_stop_id_end = " \
            		<div class='select_stop_id_end'> \
					<form class='form-horizontal' role='form'> \
						<select name='select_stop_id_end' id='select_stop_id_end' style='width:100%;height:33px;' disabled> \
						<option value='-1'>Select End</option> \
						</select> \
					</form> \
					</div>";
            	$('div.select_stop_id_start').replaceWith(form_select_stop_id_start);
            	$('div.select_stop_id_end').replaceWith(form_select_stop_id_end);
            	$("#select_stop_id_start").change(function(){get_select_stop_id_end($(this).val());});
				// var data = "";
				// for (var i = 0; i < json.AimedArrivalTime.length; i++) {
				// 	var ArrivalTime = json.AimedArrivalTime[i].ArrivalTime;
				// 	var ArrivalMinutes = json.AimedArrivalTime[i].ArrivalMinutes;
				// 	if (ArrivalMinutes < 2)
				// 		data = ArrivalTime + "     ETA: DUE NOW";
				// 	else
				// 		data = ArrivalTime + "     ETA: " + ArrivalMinutes + " minutes";
				// 	$('#arrival_time_'+(i+1)).html(data);
				// }
    //         	// $('#json_result').html(JSON.stringify(json));
    //         	for (let j = 0; j <= favoriteRoutes; j++) {
    //         		$('#get_stop_monitoring_'+j).attr("disabled", true);
    //         	}
            },
            complete: function() {
            	// alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ERROR: Could not get select stop id start");
			}
        });
    }

    function get_select_stop_id_end(stop_id_start) {
    	// alert('test '+line_id);
    	$.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/get_select_stop_id_start',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
            		line_id: $('#line_id_0').val(),
                    stop_id_start: stop_id_start
            },
            success: function(json) {
            	// alert("success");
            	var form_select_stop_id_end = " \
            		<div class='select_stop_id_end'> \
            		<input type='text' id='stop_id_start_0' value='"+stop_id_start+"' hidden> \
					<form class='form-horizontal' role='form'> \
						<select name='select_stop_id_end' id='select_stop_id_end' style='width:100%;height:33px;'> \
						<option value='-1'>Select End</option> \
						<option value='2'>End ID = ?</option> \
						</select> \
					</form> \
					</div>";
            	$('div.select_stop_id_end').replaceWith(form_select_stop_id_end);
            	$("#select_stop_id_end").change(function(){get_select_live_eta($(this).val());});
				// var data = "";
				// for (var i = 0; i < json.AimedArrivalTime.length; i++) {
				// 	var ArrivalTime = json.AimedArrivalTime[i].ArrivalTime;
				// 	var ArrivalMinutes = json.AimedArrivalTime[i].ArrivalMinutes;
				// 	if (ArrivalMinutes < 2)
				// 		data = ArrivalTime + "     ETA: DUE NOW";
				// 	else
				// 		data = ArrivalTime + "     ETA: " + ArrivalMinutes + " minutes";
				// 	$('#arrival_time_'+(i+1)).html(data);
				// }
    //         	// $('#json_result').html(JSON.stringify(json));
    //         	for (let j = 0; j <= favoriteRoutes; j++) {
    //         		$('#get_stop_monitoring_'+j).attr("disabled", true);
    //         	}
            },
            complete: function() {
            	// alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ERROR: Could not get select stop id start");
			}
        });
    }

    function get_select_live_eta(stop_id_end) {
    	var select_live_eta = " \
    		<div class='select_live_eta'> \
    		<input type='text' id='stop_id_end_0' value='"+stop_id_end+"' hidden> \
			</div>";
    	$('div.select_live_eta').replaceWith(select_live_eta);
    	get_stop_monitoring(0);
    }

    for (let id = 0; id <= favoriteRoutes; id++) {
        jQuery('#exit_'+id).hide();
        $('#exit_'+id).click( function(){exit(id);} );
        $('#get_stop_monitoring_'+id).click( function(){get_stop_monitoring(id); if(id>0)update_favorite_route_usage(id);} );
        $('#insert_favorite_route_'+id).click( function(){insert_favorite_route(id);} );

        if (id > 0) {
            $('#get_stop_monitoring_'+id).on("mousedown",function(){
                timer = setTimeout(function(){
                    confirmFavoriteRouteDelete(id);
                },2*1000);
            }).on("mouseup mouseleave",function(){
                clearTimeout(timer);
            });
        }
    }

    function get_stop_monitoring(id) {
    	alert("yay");
        $.ajax({
            url: 'http://127.0.0.1:8080/api/511/get_stop_monitoring',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
                    line_id: $('#line_id_'+id).val(),
                    stop_id_start: $('#stop_id_start_'+id).val(),
                    stop_id_end: $('#stop_id_end_'+id).val(),
                    favorites_id: $('#favorites_id_'+id).val()
            },
            success: function(json) {
            	// alert("success");
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
            	// alert("complete");
                jQuery('#get_stop_monitoring_'+id).hide();
                jQuery('#exit_'+id).show();
                timeoutId = setTimeout(function(){get_stop_monitoring(id);}, 60000);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ERROR: Could not get time info");
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

    function update_favorite_route_usage(id) {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/update_favorite_route_usage',
            type: 'POST',
            dataType: 'json',
            data: { favorites_id: $('#favorites_id_'+id).val()
            },
            success: function(json) {
                // alert("success");
            },
            complete: function() {
                // alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR: Could not update favorite route usage");
            }
        });
    }

    function insert_favorite_route(id) {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/insert_favorite_route',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
                    line_id: $('#line_id_'+id).val(),
                    stop_id_start: $('#stop_id_start_'+id).val(),
                    stop_id_end: $('#stop_id_end_'+id).val()
            },
            success: function(json) {
                // alert("success");
                $('#insert_favorite_route_'+id).attr("disabled", true);
            },
            complete: function() {
                // alert("complete");
                $('#insert_favorite_route_'+id).attr("disabled", true);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR: Could not insert favorite route");
                $('#insert_favorite_route_'+id).attr("disabled", true);
                // location.reload();
            }
        });
    }

    function delete_favorite_route(id) {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/delete_favorite_route',
            type: 'POST',
            dataType: 'json',
            data: { favorites_id: $('#favorites_id_'+id).val()
            },
            success: function(json) {
                // alert("success");
            },
            complete: function() {
                // alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR: Could not update favorite route usage");
            }
        });
    }

    function confirmFavoriteRouteDelete(id) {
        var choice = confirm("Do you want to delete this route?");
        if (choice == true) {
            delete_favorite_route(id);
            location.reload();
        }
    }
});
