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
            	for (let j = 1; j <= favoriteRoutes; j++) {
            		$('#get_stop_monitoring_'+j).attr("disabled", true);
            	}
            },
            complete: function() {
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
        for (let j = 1; j <= favoriteRoutes; j++) {
	        $('#get_stop_monitoring_'+j).attr("disabled", false);
    	}
    }

	for (let id = 1; id <= favoriteRoutes; id++) {
    	jQuery('#exit_'+id).hide();
	    $('#exit_'+id).click( function(){exit(id);} );
	    $('#get_stop_monitoring_'+id).click( function(){get_stop_monitoring(id);} );
	}
});
