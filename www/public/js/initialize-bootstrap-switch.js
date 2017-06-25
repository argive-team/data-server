$(document).ready(function() {
    $('#environment').bootstrapSwitch({size : 'small', onText: 'Live', offText: 'Test'});
    var stopchange = false;
    $('#environment').on('switchChange.bootstrapSwitch', function (e, state) {
        var obj = $(this);
        
        var environment = "production";
        if (!$('#environment').is(':checked')) {
        	environment = "development";
        }
        
        if(stopchange === false){
            $.ajax({
                url: "/application/index/change-env",
                type: "POST",
                quietMillis: 100,
                data: { 
                    environment: environment,
                },
                success: function(result) {
                    if(result['done'] == true) {
                        // Variable set per page as needed
                        if ((typeof reloadPageOnEnvChange != 'undefined') && (reloadPageOnEnvChange == true)) {
                        	alert('Environment changed successfully. This page will reload.');
                        	location.reload();
                        } else {
                        	alert('Environment changed successfully.');
                        }
                    } else {
                        alert('Error:'+result['message']);
                        if(stopchange === false){
                            stopchange = true;
                            obj.bootstrapSwitch('toggleState');
                            stopchange = false;
                        }
                    }
                },
                error: function(result) {
                    alert('Error! Unable to change environment.');
                    if(stopchange === false){
                        stopchange = true;
                        obj.bootstrapSwitch('toggleState');
                        stopchange = false;
                    }
                }
            });
        }
    }); 
});

