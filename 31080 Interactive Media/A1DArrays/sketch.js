let particles = []; // array to store all particle objects
let gravity = 0.05; // how fast particles fall
//animated walk scycle - taking from the reverse feature idea
let reverseMode = false; // false = normal, true = reverse
//parameters
let partSize = 20; // Particle size
let partSpeed = 5; // Particle speed  
let partCount = 20; // Starting particles
let fadeSpeed = 0.7; // How fast they fade
let spawnRate = 0.2; // How often new particles appear
//polyline
let mouseTrail = [];
let maxTrailLength = 100; //max number of mouse positions

function setup() {
  createCanvas(500, 500);
  // create initial particles useing the partCount parameter
  for (let i = 0; i < partCount; i++) {
    addParticle();
  }
}

function draw() {
  background(0, 30); // semi-transparent for trail effect
  
  updateMouseTrail();// Update and store mouse position for trail
  drawMouseTrail(); // Draw the polyline trail
  
  // Update and draw all particles
  for (let i = 0; i < particles.length; i++) {
    let p = particles[i]; // get current particle
    
    // Move particle based on current mode
    if (reverseMode) {
      p.y -= p.speed; // Move UP (reverse)
      p.speed += gravity; // Still accelerate
    } else {
      p.y += p.speed; // Move DOWN (normal)
      p.speed += gravity;
    }
    
    //colour & transparency of moving particles
    fill(p.r, p.g, p.b, p.alpha);
    noStroke();
    ellipse(p.x, p.y, p.size);
    
    p.alpha -= fadeSpeed; //parameter for speeding fade
    
    // Remove conditions for both modes
    if (p.alpha <= 0 || //if transparent
        (!reverseMode && p.y > height + p.size) || // Off bottom (normal)
        (reverseMode && p.y < -p.size)) { // Off top (reverse)
      particles.splice(i, 1);
      i--; //adjust index due to array length change
    }
  }
  
  if (random() < spawnRate) { //parameter for spwan rate randomly
    addParticle(); 
  }

  fill(255);
  noStroke();
  textSize(16);
  text("Press 'R' to toggle reverse mode", 20, 30);
  text("Current: " + (reverseMode ? "↑" : "↓"), 20, 50);
}


//storing nouse positions
function updateMouseTrail() {
  // Only store positions when mouse is moving and on canvas
  //pmouseX/Y are previous frame positions
  if (mouseX !== pmouseX || mouseY !== pmouseY) {
    //only store on canvas
    if (mouseX > 0 && mouseX < width && mouseY > 0 && mouseY < height) { // add current position to end of array
      mouseTrail.push({x: mouseX, y: mouseY});
      
      // Keep only the last 100 positions - removes oldest in the array
      if (mouseTrail.length > maxTrailLength) {
        mouseTrail.shift(); // Remove oldest position
      }
    }
  }
}

function drawMouseTrail() { // polyline trail drawn
  if (mouseTrail.length > 1) { //Only draw if we have at least 2 points - drawing lines
    noFill();
    stroke(255, 150);
    strokeWeight(2);
    
    beginShape(); //smoth connected line through all mouse points
    for (let i = 0; i < mouseTrail.length; i++) { //vertex() connects points with straight lines
      vertex(mouseTrail[i].x, mouseTrail[i].y);
    }
    endShape();
    
    // Draw points along the trial
    fill(255, 200);
    noStroke();
    for (let i = 0; i < mouseTrail.length; i += 5) { // Every 5th point
      ellipse(mouseTrail[i].x, mouseTrail[i].y, 4);
    }
  }
}

function addParticle() {
  // Create new particle object with random properties
  let newParticle = {
    x: random(width), //random horizontal position
    y: reverseMode ? random(height, height + 100) : random(-100, 0), // Start based on mode
    size: random(partSize * 0.5, partSize * 1.5),
    speed: random(partSpeed * 0.5, partSpeed * 1.5),
    r: random(100, 255),
    g: random(100, 255),
    b: random(100, 255),
    alpha: random(150, 255) // transparency
  };
  
  particles.push(newParticle); // add to array
}

function mousePressed() {
  // Add burst of particles where mouse is clicked
  for (let i = 0; i < 15; i++) {
    let burstParticle = {
      x: mouseX + random(-30, 30),
      y: mouseY + random(-30, 30),
      size: random(partSize * 0.3, partSize * 0.8), //size paremeters
      speed: reverseMode ? random(0, partSpeed) : random(-partSpeed, 0), // Direction based on mode
      r: random(200, 255),
      g: random(50, 150),
      b: random(50, 150),
      alpha: random(180, 255)
    };
    particles.push(burstParticle);
  }
}

function mouseDragged() {
  // Adds smaller particles while dragging too
  if (random() < 0.3) {
    let dragParticle = {
      x: mouseX + random(-10, 10),
      y: mouseY + random(-10, 10),
      size: random(partSize * 0.2, partSize * 0.5),
      speed: reverseMode ? random(0, partSpeed * 0.5) : random(-partSpeed * 0.5, 0),
      r: random(150, 255),
      g: random(100, 200),
      b: random(100, 200),
      alpha: random(100, 200)
    };
    particles.push(dragParticle);
  }
}

function keyPressed() {
  // Toggle reverse mode with 'R' key
  if (key === 'r' || key === 'R') {
    reverseMode = !reverseMode; // Flip the mode
  }
  
  // Clear all particles with spacebar
  if (key === ' ') {
    particles = [];
    background(0);
  }
  
  // Add random particle with any other key
  if (key !== ' ' && key !== 'r' && key !== 'R') {
    addParticle();
  }
}