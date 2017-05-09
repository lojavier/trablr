jQuery(function() {
    // setTimeout(function(){}, 1000);
	var favoriteRoutes = $('[id^=get_stop_monitoring_]').length;
    var timeoutId = null;

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
