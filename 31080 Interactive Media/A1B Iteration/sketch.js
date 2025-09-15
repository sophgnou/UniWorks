//Here I am coombining the iteration example ideas of Simple Iteration: Seven Circles & Color-Bar Gradient

let circles= []; //array to make randomised circles and to store them here

function setup() {
  createCanvas(480, 640, WEBGL);
  
  rectMode(CENTER);
  ellipseMode(CENTER);
  noStroke();
}

function draw() {
  background(220);
  gradient(); //gradient background
  
  drawnCircles();
  
  polaroid(); //polaroid frame
}

function drawnCircles() {
  //to 2d drawing since I included WEBGL in this code
  push();
  resetMatrix();
  translate(-width/2, -height/2); // Align with top-left corner
  
  for (let i = 0; i < circles.length; i++) {
    let c = circles[i]; // c + dot syntax is to call back to the newCircle object created to draw from the random values assigned
    fill(c.r, c.g, c.b, c.alpha);
    circle(c.x, c.y, c.radius * 2);
    
    c.y += c.speedY;
    if (c.y > height + c.radius) c.y = -c.radius; // Reset if off-screen
  }
  pop(); // back to WEBGL mode
}

function addRandomCircle() {
  // Generate random properties for a new circle & object creation to make the circle data
  let newCircle = {
    x: random(width),
    y: random(height),
    radius: random(10, 60),
    r: random(200, 255),
    g: random(200, 255),
    b: random(200, 255),
    alpha: random(50, 180), // Translucency
    speedY: random(-0.5, 0.5) // Vertical drift
  };
  
  //array management push() adds new circle to end of array, shift() removes oldest circles if the array exceeds 50 items
  //dot notation to call back to the property in the newCircle object
  circles.push(newCircle); 
  // Limit to 50 circles 
  if (circles.length > 50) circles.shift(); 
}

function gradient() {
  let topColor = color(32, 51, 92);    // Indigo?? Dark Blue??
  let bottomColor = color(155, 183, 209); // Light blue??
  
  // Switch to 2D drawing temporarily
  push();
  resetMatrix();
  translate(-width/50, -height/2); // Account for WEBGL center origin, trial and error of what values to put for the division to make sure it covers the background/canvas
  
  // Draw gradient in for loop
  for (let y = 0; y < height; y++) {
    let interp = map(y, 0, height, 0, 1);
    let blendedColor = lerpColor(topColor, bottomColor, interp);
    fill(blendedColor);
    rect(0, y, width, 1); // thin rectangles are drawn
  }
  pop(); // Restore WEBGL state
}
  
function polaroid() {
  //original code was taken and learned from p5js references beginContour()
  
  noStroke();
  // Start drawing the shape.
  beginShape();

  // Exterior vertices, clockwise winding.
  vertex(-240, -320);
  vertex(240, -320);
  vertex(240, 320);
  vertex(-240, 320);

  // Interior vertices, counter-clockwise winding.
  beginContour();
  vertex(-200, -280);
  vertex(-200, 180);
  vertex(190, 180);
  vertex(190, -280);
  endContour();

  // Stop drawing the shape.
  endShape(CLOSE);
}

//button functions
function mousePressed() { //mouse click
  addRandomCircle();
}
function keyPressed() { //any key press
  addRandomCircle();
}
