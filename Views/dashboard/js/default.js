
$(function() {
	var poll = function(){
		$.ajax({
	        type: "GET",
	        cache: false,
	        url: "dashboard/getUpdate",
	        datatype:'JSON',
	        success: function(data){
	        	var result =JSON.parse(data);
	        	console.log (result);
	        	if (result[0].flag == 1){
	        		
	        	 for (var i = 0; i < result.length; i++)
	     		{
	        		
		        		 var d = new Date(result[i].dt); 
		        		 
		        		 
		        		 var newElement = $('<div class="highlight" ><h4> Data Feeded : ' + d.getDate() + '-'+ (d.getMonth()+1)+ '-'+ d.getFullYear()+' Time : '+ d.toLocaleTimeString() +'</h4>' 
						     				+'<p> Readings:'+
						     				'<p>Temprature 1 : ' + result[i].T01 + '°C Level 1 : ' + result[i].L01 +' % </p>'+
						     				'<p>Temprature 2 : ' + result[i].T02 + '°C Level 2 : ' + result[i].L02 +' % </p>'
						     				+'</p></div>'	);
		        	if(i != 0){
		        		 $.notify({
		        				message: 'New readings received from Device '+ result[i].did
		        			});
		        		 }
		             	$('#'+result[i].did+'nodata').remove();
		     			$('#'+result[i].did).append(newElement);
		     			
		     			  setTimeout(function(){
		     				 newElement.removeClass('highlight');
	    		          },15000);
		     					             	
		     		};
	            
	        	};
        	}
	    });
		
	};// end of poll
	
	
	
	$.ajax({
        type: "GET",
        url: "dashboard/getDevices",
        datatype:'JSON',
        success: function(data){
            var result =JSON.parse(data);
            for (var i = 0; i < result.length; i++)
    		{
    			$('#device-data').append(
					
					'<div class="well well-sm"><h3>Device ' + (i+1) +'</h3></div>'
					+'<div id='+result[i]._id+'><p id="'+result[i]._id+'nodata">No Data Feeded</p></div>'
    					
    			);
    		}
            
        }
    });
	$.ajax({
        type: "GET",
        url: "dashboard/getReadings",
        datatype:'JSON',
        success: function(data){
            var result =JSON.parse(data);
            for (var i = 0; i < result.length; i++)
    		{
            	var d = new Date(result[i].dt); 
            	$('#'+result[i].did+'nodata').remove();
    			$('#'+result[i].did).append(
    				'<h4> Data Feeded : ' + d.getDate() + '-'+ (d.getMonth()+1)+ '-'+ d.getFullYear()+' Time : '+ d.toLocaleTimeString() +'</h4>' 
    				+'<p> Readings:'+
    				'<p>Temprature 1 : ' + result[i].T01 + '°C Level 1 : ' + result[i].L01 +' % </p>'+
    				'<p>Temprature 2 : ' + result[i].T02 + '°C Level 2 : ' + result[i].L02 +' % </p>'
    				+'</p>'	
    			);
            	
    		};
    		$( "#device-data" ).accordion({heightStyle: "content",
    			activate: function(event, ui) {
    				
    		        
    		  }
    		});// end of accordion inside ajax
        }
    });
	
	setInterval(function(){
		poll();
	},10000);

});


