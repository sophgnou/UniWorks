var bgX = 0; 
var bgY = 0;
var portraitX = 0;
var portraitY = 0;
var standard = 8;
var canvasLength = 400;

function setup() {
  createCanvas(400, 400);
  ellipseMode(CENTER);
  rectMode(CENTER);
}

function draw() {
  background(255);
  //background art
  strokeWeight(standard);
  //coding mondrian
  line(bgX + 180, bgY, 180, canvasLength);
  strokeWeight(standard / 0.8);
  line(bgX, bgY + 150, canvasLength, 150);
  line(bgX, bgY + 240, canvasLength, 240);
  strokeWeight(standard);
  line(bgX + 310, bgY + 245, 310, 400);
  
  fill(canvasLength / 2, 10, 30);
  square(bgX - 10, bgY - 40, canvasLength - 20);
  
  fill(20, 30, canvasLength / 4);
  square(bgX + 245, bgY + 305, 125);
  
  fill(250, canvasLength / 2, 10);
  rect(bgX, bgY + 340, canvasLength * 0.225, canvasLength * 0.5);
  
  //triangles Coding Stadia II elements
  strokeWeight(standard * 0);
  fill(20, 30, 50); 
  triangle(50, 50, 350, 100, 100, 350); 
  
  fill(180, 160, 140, 100); 
  triangle(200, 100, 300, 200, 150, 300);

  fill(220, 50, 70); 
  triangle(250, 150, 320, 180, 280, 250);

  fill(255, 200, 0); 
  triangle(80, 200, 120, 220, 90, 280);
  
  strokeWeight(1);
  noFill();
  triangle(50, 50, 350, 100, 100, 350); 
  
  
  //stylised portrait
  fill(240);
  strokeWeight(standard * 0.625)
  ellipse(portraitX + 300, portraitY + 350, 210, 280);
  fill(0);
  ellipse(portraitX + 260, portraitY + 330, 40, 45);
  ellipse(portraitX + 340, portraitY + 330, 40, 45);  
  /* not to self: syntax for surves are...
  curve(x1, y1, x2, y2, x3, y3, x4, y4);
  curve(x1, y1, z1, x2, y2, z2, x3, y3, z3, x4, y4, z4);
  */
  //head & face
  strokeWeight(standard * 1.5);
  line(portraitX + 230, portraitY + 310, 280, 305);
  line(portraitX + 320, portraitY + 305, 370, 310);
  //hair
  fill(0);
  ellipse(portraitX + 300)
  
  //Coding Stadia II elements
  //Orange Circles, the thing that kind of looks like glasses in the example
  fill(240, 160, 50, 248);
  strokeWeight(standard * 0);
  circle(bgX + 230, bgY + 320, 120);
  circle(bgX + 370, bgY + 320, 120);
  strokeWeight(standard);
  line(bgX + 280, bgY + 330, 320, 330);
}
