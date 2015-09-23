
$(function() {

	$.ajax({
        type: "GET",
        url: "dashboard/getDevices",
        datatype:'json',
        async:true,
        success: function(data){
            var result =data;            
           
            addDevice(result);
            addReadings(result);
            
    		$( "#device-data" ).accordion({heightStyle: "content",});// end of accordion inside ajax
            
        }
    });
	
	
	setInterval(function(){
		poll();
	},10000);
	var poll = function(){
		$.ajax({
	        type: "GET",
	        cache: false,
	        url: "dashboard/getUpdate",
	        datatype:'json',
	        success: function(data){
	        	var result =data;
	        	console.log (result);
	        	if (result['flag'] == 1){
	        		addReadings(result)
	        	};
        	}
	    });
		
	};// end of poll
	

	var addReadings = function(data){
		var result = data 
	       for (var i = 0; i < result['readings'].length; i++)
   			{
	    	var d = new Date(result['readings'][i].dt);
           	$('#'+result['readings'][i].did+'nodata').remove();
           	var html 
           	if (typeof result['flag'] !== 'undefined') {	    		   
	   		    	html = '<div class="highlight">';	
	   		    	$.notify({message: 'New readings received from Device '+ result['readings'][i].did});	     			  
		   		}
           	else{
		   			html = '<div>'
		   		}
           	
           	html = html + '<h4> Data Feeded : ' + d.getDate() + '-'+ (d.getMonth()+1)+ '-'+ d.getFullYear()+' Time : '+ d.toLocaleTimeString() +'</h4>' 
   				+'<p> Readings:'+
   				'<p>Temprature 1 : ' + result['readings'][i].T01 + '°C Level 1 : ' + result['readings'][i].L01 +' % </p>'+
   				'<p>Temprature 2 : ' + result['readings'][i].T02 + '°C Level 2 : ' + result['readings'][i].L02 +' % </p>'
   				+'</p>'+
   				'</div>'
   				
   			$('#'+result['readings'][i].did).append(html);
          		
       		
   		};
	};// end of add readings
	
	
	
	
	
	
	var addDevice = function(data){
		var result = data 
		 for (var i = 0; i < result['device'].length; i++)
 		{
 			$('#device-data').append(
					
					'<div class="well well-sm"><h3>Device ' + (i+1) +'</h3></div>'
					+'<div id='+result['device'][i]._id+'><p id="'+result['device'][i]._id+'nodata">No Data Feeded</p></div>'
 					
 			);
 		}
	};// end of add readings
	
	
});


