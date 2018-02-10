$(document).ready(function() {
	var atempsArray = [];
	var atArray = [];
	var asessionArray = [];
	var acurrTemp = '';

	var dataRef = new Firebase('https://doam-9822d.firebaseio.com/');
	dataRef.on('value', function(snapshot) {
		var t = snapshot.val();
		var count = 0;

		for (var key in t) {
		  if (t.hasOwnProperty(key)) {		    
		    var dt = [];	    
		    dt[0] = count;
		    dt[1] = parseFloat(t[key]);
		    atempsArray = [];
		    atempsArray.push(dt);
		    atArray = [];
		    atArray.push(dt[1]);
		    count++;
		  }
		}
		asessionArray.push(atempsArray[0])
		//console.log(tempsArray)
		$.plot($("#achart1"), [ asessionArray ]);
		acurrTemp = atempsArray[0][1].toString();
		$('#atempMsg').show();
		$("#acurrTemp").text(acurrTemp);
	});			
});