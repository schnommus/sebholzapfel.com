// 3D ASCII JS ENGINE (C) Seb Holzapfel 2012
// Currently showing a cube, but could potentially show anything


// Class to store 3D points
function Point3d(xv, yv, zv) {
	this.x = xv;
	this.y = yv;
	this.z = zv;
}

// The main shape definition
function CreateCube() {
	var cube = new Array(18);
	cube[0] = new Point3d( -5, -5, -5 );
	cube[1] = new Point3d( -5, -5, 5 );
	cube[2] = new Point3d( -5, -5, -5 );
	cube[3] = new Point3d( 5, -5, -5 );
	cube[4] = new Point3d( 5, -5, 5 );
	cube[5] = new Point3d( 5, -5, -5 );
	cube[6] = new Point3d( 5, 5, -5 );
	cube[7] = new Point3d( 5, 5, 5 );
	cube[8] = new Point3d( 5, 5, -5 );
	cube[9] = new Point3d( -5, 5, -5 );
	cube[10] = new Point3d( -5, 5, 5 );
	cube[11] = new Point3d( -5, 5, -5 );
	cube[12] = new Point3d( -5, -5, -5 );
	cube[13] = new Point3d( -5, -5, 5 );
	cube[14] = new Point3d( 5, -5, 5 );
	cube[15] = new Point3d( 5, 5, 5 );
	cube[16] = new Point3d( -5, 5, 5 );
	cube[17] = new Point3d( -5, -5, 5 );
	return cube;
}

// Create an empty shape of length n
function CreateShape(n) {
	var shape = new Array(n);
	for( var i = 0; i != n; ++i ) {
		shape[i] = new Point3d(0, 0, 0);
	}
	return shape;
}


// Plot sizes + attributes
var SIZE_X = 150;
var SIZE_Y = 40;
var V_DIST = 40;
var Z_OFF = 20;

// Creates a 2D plotting space
function CreatePlot() {
	plot = new Array(SIZE_X);
	for( var i = 0; i != SIZE_X; ++i ) {
		plot[i] = new Array(SIZE_Y);
	}
	return plot;
}

// Prints the 2D plotting space to the screen
function PrintPlot(plot) {
	var s = "";
	
	for ( var i = 0; i != SIZE_Y; ++i ) {
		for( var j = 0; j != SIZE_X; ++j ) {
			if(plot[i][j] == 0) {
				s += "&nbsp;";
				 
			} else {
				s += plot[i][j];
			}
		}
		s += "</br>";
	}
	
	document.getElementById("cubediv").innerHTML = s;
}

// Clears the 2D plotting space
function ClearPlot(plot){
	for ( var i = 0; i != SIZE_Y; ++i ) {
		for( var j = 0; j != SIZE_X; ++j ) {
			plot[i][j] = 0;
		}
	}
}

// Draws a shape using 3D transformation
function Plot(plot, shape, offset) {
	var opx=0, opy=0;
	
	// First loop plots lines, second plots verticies numbers
	
	for( var i = 0; i != shape.length; ++i ) {
		var px = Math.floor((shape[i].x + offset.x) / (shape[i].z+Z_OFF)*V_DIST) + SIZE_Y/2;
		var py = Math.floor((shape[i].y + offset.y) / (shape[i].z+Z_OFF)*V_DIST) + SIZE_X/2;
		
			
		if(i > 0) {
		  var x0 = px, y0 = py, x1 = opx, y1 = opy;
		  
		  // JS implementation of Bresenham's line algorithm
		  var dx = Math.abs(x1-x0);
		  var dy = Math.abs(y1-y0);
		  var sx = (x0 < x1) ? 1 : -1;
		  var sy = (y0 < y1) ? 1 : -1;
		  var err = dx-dy;
  
		  while(true) {
			  if( !(x0 < 0 || x0 > SIZE_Y || y0 < 0 || y0 > SIZE_X ) )
				  plot[x0][y0] = '-';
			  if ((x0==x1) && (y0==y1)) break;
			  var e2 = 2*err;
			  if (e2>-dy){
				  err -= dy;
				  x0  += sx;
			  }
			  if (e2 < dx){
				  err += dx;
				  y0  += sy;
			  }
		   }
		}
		
		opx = px;
		opy = py;
	}
	
	for( var i = 0; i != shape.length; ++i ) {
		var px = Math.floor((shape[i].x + offset.x) / (shape[i].z+Z_OFF)*V_DIST) + SIZE_Y/2;
		var py = Math.floor((shape[i].y + offset.y) / (shape[i].z+Z_OFF)*V_DIST) + SIZE_X/2;
		
		if( !(px < 0 || px > SIZE_Y || py < 0 || py > SIZE_X ) )
			plot[px][py] = i+1;
	}
}

var delta = 0;
var plot;
var cube;

// Perform an angular matrix transform (aint that fun to say :D ), angles in radians.
function AngularTransform( result, original, heading, pitch, bank ) {
	
	for( var i = 0; i != result.length; ++i ) {
		// Yes, this is the simplest possible way of doing it ;) -- besides maybe a massive lookup table
		result[i].x = (Math.cos(heading)*Math.cos(bank)+Math.sin(heading)*Math.sin(pitch)*Math.sin(bank))*original[i].x +
					  (-Math.cos(heading)*Math.sin(bank)+Math.sin(heading)*Math.sin(pitch)*Math.cos(bank))*original[i].y +
					  (Math.sin(heading)*Math.cos(pitch))*original[i].z;
					  
		result[i].y = (Math.sin(bank)*Math.cos(pitch))*original[i].x +
					  (Math.cos(bank)*Math.cos(pitch))*original[i].y +
					  (-Math.sin(pitch))*original[i].z;
					  
		result[i].z = (-Math.sin(heading)*Math.cos(bank)+Math.cos(heading)*Math.sin(pitch)*Math.sin(bank))*original[i].x +
					  (Math.sin(bank)*Math.sin(heading)+Math.cos(heading)*Math.sin(pitch)*Math.cos(bank))*original[i].y +
					  (Math.cos(heading)*Math.cos(pitch))*original[i].z;
	}
	return result;
}

document.onmousemove = getMouseXY;

var mouseX=0, mouseY=0;

function getMouseXY(ev) {
	mouseX = ev.clientX;
	mouseY = ev.clientY;
}

function loop() {
	setTimeout(loop, 40);
	
	tCube = AngularTransform( CreateShape(18), cube, delta, 0, delta );
	
	ClearPlot(plot);
	Plot(plot, tCube, new Point3d( 0, 0, 0));
	
	PrintPlot(plot);
	delta += 0.1;
}

function run() {
	plot = CreatePlot(); // Create 2D plotting space
	cube = CreateCube(); // Create cube
	loop();
}