//trying this in WEBGL - I want to experiment more with 3D! 
//combined examples: spiral & ball rotating

let angle = 0;
let spiralRadius = 200; //orbit radius
let sphereSize = 50; //default sphere size
let rotationSpeed = 0.02; // rotation speed
//controlling thne centre of the orbit
let orbitCenX = 0;
let orbitCenY = -340; 

function setup() {
  createCanvas(700, 700, WEBGL);
  noStroke();
}

function draw() {
  background(30, 30, 50); // Dark blue background
  drawFloatingParticles();

  pointLight(255, 255, 255, 0, -600, 300); // Main light - harsher y to define where the nearest star in this solar system is
  ambientLight(100, 100, 150); // shadows in art should resemble the colour behind the object as light tends to make the colour bounce onto the object
  
  planet();
}

function planet(){
  let spiralX = cos(angle) * spiralRadius + orbitCenX; // Add the offset here
  let spiralY = sin(angle) * spiralRadius + orbitCenY;
  let spiralZ = angle * 10;
  // Draw the sphere with spiral motion
  push();
  translate(spiralX, spiralY, spiralZ);
  rotateX(frameCount * 0.01); // Rotate around X axis
  rotateY(frameCount * 0.02); // Rotate around Y axis

  // Sphere with gradient color based on position
  let sphereColor = color(
    map(spiralX, -spiralRadius, spiralRadius, 100, 255),
    map(spiralY, -spiralRadius, spiralRadius, 100, 200),
    map(spiralZ, -500, 500, 150, 255)
  );
  fill(sphereColor);
  sphere(sphereSize);
  pop();
  
  // Update angle for spiral motion
  angle += rotationSpeed;
  
  // Reset angle when it gets too large to prevent overflow
  if (angle > TWO_PI * 5) {
    angle = 0;
  }
  
}

function drawFloatingParticles() {
  //floating particles = stars?
  for (let i = 0; i < 5; i++) {
    push();
    let partX = random(-400, 400); //random horizontal point spawn
    let partY = random(-400, 400); //random vertical point spawn
    let partZ = random(-400, 0); //to not be in front of the view of the planet oirbit
    let partSize = random(1, 3);
    
    translate(partX, partY, partZ);
    fill(255);
    sphere(partSize);
    pop();
  }
}

function keyPressed() { // to make parameter changes interactive
  // Speed controls
  if (keyCode === UP_ARROW) {
    rotationSpeed = min(0.1, rotationSpeed + 0.005);
  }
  if (keyCode === DOWN_ARROW) {
    rotationSpeed = max(0.005, rotationSpeed - 0.005);
  }
  
  // Size controls
  if (key === '+' || key === '=') {
    sphereSize = min(100, sphereSize + 5);
  }
  if (key === '-' || key === '_') {
    sphereSize = max(10, sphereSize - 5);
  }
  
  // Spiral radius controls
  if (keyCode === RIGHT_ARROW) {
    spiralRadius = min(300, spiralRadius + 10);
  }
  if (keyCode === LEFT_ARROW) {
    spiralRadius = max(50, spiralRadius - 10);
  }
  
  // Reset with spacebar
  if (key === ' ') {
    angle = 0;
    sphereSize = 50;
    rotationSpeed = 0.02;
    spiralRadius = 200;
  }
}