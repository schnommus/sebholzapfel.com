// -CONSTANTS-
var SINE_SIZE_X = 50; // Size in characters
var SINE_SIZE_Y = 20; 
var SINE_SCALE = 0.1; // Horizontal sine scale, larger value == more compressed wave
var SINE_SPEED = 0.1; // Animation speed, larger is faster


var delta = 0.0; // Global animation offset delta

function getLine() { //Creates string for the top and bottom of sine frame
	var str = "";
	for( var i = 0; i != SINE_SIZE_X+2; ++i ) str += Math.floor(Math.random()*2);
	str += "<br/>";
	return str
}

function drawSine() {
	
	SINE_SIZE_X = Math.floor(window.innerWidth/12);
	SINE_SIZE_Y = Math.floor(window.innerHeight/22);
	
	var sineString = ""; // Stores the whole ASCII-render before being sent to display
	
	sineString += getLine();
	
	for( var i = 0; i != SINE_SIZE_Y; ++i ) {
		sineString += Math.floor(Math.random()*2);
		for( var k = delta, j = 0.0; j != SINE_SIZE_X; ++j ) {
			if( Math.floor((Math.sin(k)+1)*(SINE_SIZE_Y/2)) == i ) {
				sineString += Math.floor(Math.random()*2);
			} else {
				sineString += "&nbsp;";
			}
			k += SINE_SCALE;
		}
		sineString += Math.floor(Math.random()*2) + "<br/>";
	}
	
	sineString += getLine();
	
	document.getElementById("swave").innerHTML = sineString;
	
	document.getElementById("deltadiv").innerHTML = "Delta: " + Math.floor(Math.sin(delta)*(SINE_SIZE_Y/2)).toString();
	
	delta += SINE_SPEED;
	
	setTimeout( "drawSine()", 25 );
}