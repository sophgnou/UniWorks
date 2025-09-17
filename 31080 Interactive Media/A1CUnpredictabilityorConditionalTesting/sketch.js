var uiPosDefault = 10;
let resetBtn; //to store button
let isDrawing = false;
let currentPath = [];
let allPaths = [];
//let currentColor; //was going to add colour picker button 

function setup(){
  createCanvas(500,500);
  resetButton(); 
  currentColor = color(0);
}

function draw(){
  background(255);
  
  // Draw all saved paths as connected lines (keeping it on the canvas)
  for (let i = 0; i < allPaths.length; i++) {
    drawPath(allPaths[i]);
  }
  // Draw current path while dragging
  if (isDrawing && currentPath.length > 0) {
    drawPath(currentPath);
  }
  
  //UI
  colorNav();
  /*palette1();
  palette2();
  palette3();*/
  
}

//user drawing with mouse functions
function drawPath(path) {
  noFill();
  stroke(0);
  strokeWeight(4);
  // Draw lines between consecutive points
  for (let i = 1; i < path.length; i++) {
    line(
      path[i-1].x, path[i-1].y, // Previous point
      path[i].x, path[i].y       // Current point
    );
  }
}

function mousePressed() {
  if (mouseY > height/4.5) { 
    isDrawing = true;
    currentPath = [];
    currentPath.push({x: mouseX, y: mouseY});
  }
}

function mouseDragged() {
  /*if (isDrawing) {
    currentPath.push({x: mouseX, y: mouseY});
  } //drawing normal lines */
  if (isDrawing) {
    // Add current mouse position
    currentPath.push({x: mouseX, y: mouseY});
    
    // Add mirror point (opposite side of canvas)
    let mirrorX = width - mouseX;
    let mirrorY = height - mouseY;
    currentPath.push({x: mirrorX, y: mirrorY});
  }
}

function mouseReleased() {
  if (isDrawing) {
    allPaths.push(currentPath);
    isDrawing = false;
  }
}

//Nav bar
function colorNav(){
  fill(200);
  stroke(170);
  rect(uiPosDefault*0,uiPosDefault*0,width,height/4.5);
}

//reset button to clear canvas
function resetButton(){ //button style reference code source: https://editor.p5js.org/elinsterz/sketches/NvK3RRihj
  let hue = color(200,200,210);
  resetBtn = createButton('reset'); //creates button
  resetBtn.position(uiPosDefault,uiPosDefault);
  resetBtn.size(width*0.18,height*0.18);
  resetBtn.style('font-size', '25px');
  resetBtn.style('font-family', '"monospace, Courier New, Courier"');
  resetBtn.style('background-color', hue);  
  resetBtn.mousePressed(resetCanvas);
}

function resetCanvas(){ //resetting the canvas
  background(255);
  allPaths = [];
  console.log('reset'); //to test if the button was working when i havent coded the drawing interaction yet
}

/* was going to add a colour picker

function palette1(){
  fill(200, 50, 90);
  noStroke();
  rect(uiPosDefault*12,uiPosDefault,width*0.18,height*0.18);
  if (mousePressed){
    stroke(90, 200, 50);
    console.log("1"); 
  }
}

function palette2(){
  fill(90, 200, 50);
  noStroke();
  rect(uiPosDefault*23,uiPosDefault,width*0.18,height*0.18);
}

function palette3(){
  fill(50, 90, 200);
  noStroke();
  rect(uiPosDefault*34,uiPosDefault,width*0.18,height*0.18);
}

*/

/* was going to add a colour picker

function palette1(){
  fill(200, 50, 90);
  noStroke();
  rect(uiPosDefault*12,uiPosDefault,width*0.18,height*0.18);
  if (mousePressed){
    stroke(90, 200, 50);
    console.log("1"); 
  }
}

function palette2(){
  fill(90, 200, 50);
  noStroke();
  rect(uiPosDefault*23,uiPosDefault,width*0.18,height*0.18);
}

function palette3(){
  fill(50, 90, 200);
  noStroke();
  rect(uiPosDefault*34,uiPosDefault,width*0.18,height*0.18);
}

*/