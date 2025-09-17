//ideas & examples comblined: eyes following the cursor & ripples in a pond

let leaves = []; // array to store all leaf objects
let waterCurrent = 0.02; // how fast leaves move (replaces gravity)
let flowTowardMouse = true; // true = flow toward mouse, false = normal flow

//parameters - adjusted for leaves
let leafSize = 30; // Leaf size
let leafSpeed = 5; // Leaf speed  
let leafCount = 15; // Starting leaves
let fadeSpeed = 0.3; // Slower fade for leaves
let spawnRate = 0.1; // Less frequent spawning

//water ripple effect instead of mouse trail
let ripples = [];
let maxRipples = 20;

function setup() {
  createCanvas(700, 700);
  // create initial leaves using the leafCount parameter
  for (let i = 0; i < leafCount; i++) {
    addLeaf();
  }
}

function draw() {
  // Water background gradient - light blue to darker blue
  drawWaterBackground();
  
  updateRipples(); // Update and draw water ripples
  drawRipples();
  
  // Update and draw all leaves
  for (let i = 0; i < leaves.length; i++) {
    let leaf = leaves[i]; // get current leaf
    
    // Move leaf based on mouse position and flow mode
    if (flowTowardMouse) {
      moveLeafTowardMouse(leaf);
    } else {
      moveLeafNormal(leaf);
    }
    
    // Rotate leaf slightly for natural movement
    leaf.rotation += leaf.rotationSpeed;
    
    // Draw leaf with its color and rotation
    drawLeaf(leaf);
    
    leaf.alpha -= fadeSpeed;
    
    // Remove leaves that are too transparent or off-screen
    if (leaf.alpha <= 0 || leaf.y > height + leaf.size) {
      leaves.splice(i, 1); //adjust index in array
      i--;
    }
  }
  
  // Occasionally add new leaves from the top
  if (random() < spawnRate) {
    addLeaf();
  }

  // Display info
  fill(70, 170, 50, 200);
  noStroke();
  textSize(16);
  text("Press 'F' to toggle flow mode", 20, 30);
  text("Click to create ripples", 20, 50);
}

function drawWaterBackground() {
  // Create water-like gradient background
  noStroke();
  for (let y = 0; y < height; y++) {
    // Pastel gradient from light sky blue to soft lavender
    let r = map(y, 0, height, 180, 200);    // Soft pinkish-lavender at bottom
    let g = map(y, 0, height, 220, 230);    // Very light mint green
    let b = map(y, 0, height, 240, 210);    // Soft blue to lavender
    fill(r, g, b, 150); // Light transparency for water effect
    rect(0, y, width, 1);
  }
}

function moveLeafTowardMouse(leaf) {
  // Calculate direction toward mouse
  let dx = mouseX - leaf.x;
  let dy = mouseY - leaf.y;
  let distance = max(1, dist(mouseX, mouseY, leaf.x, leaf.y)); // Avoid division by zero
  
  // Normalize and scale by leaf speed
  leaf.x += (dx / distance) * leaf.speed;
  leaf.y += (dy / distance) * leaf.speed;
  
  // Add slight downward current
  leaf.y += waterCurrent;
}

function moveLeafNormal(leaf) {
  // Natural flowing movement with slight randomness
  leaf.x += leaf.speed * cos(leaf.rotation) * 0.5;
  leaf.y += leaf.speed + waterCurrent;
  leaf.x += random(-0.5, 0.5); // slight side-to-side movement
}

function drawLeaf(leaf) {
  push(); // Save current drawing state
  translate(leaf.x, leaf.y);
  rotate(leaf.rotation);
  
  // Draw leaf shape (oval with stem)
  fill(leaf.r, leaf.g, leaf.b, leaf.alpha);
  noStroke();
  
  // Leaf body
  ellipse(0, 0, leaf.size, leaf.size * 0.6);
  
  // Little stem
  stroke(50, 100, 50, leaf.alpha);
  strokeWeight(2);
  line(0, -leaf.size * 0.3, 0, -leaf.size * 0.5);
  
  // Leaf veins
  stroke(70, 120, 70, leaf.alpha * 0.7);
  strokeWeight(1);
  line(0, 0, leaf.size * 0.4, 0);
  line(0, 0, -leaf.size * 0.4, 0);
  line(0, 0, leaf.size * 0.3, -leaf.size * 0.2);
  line(0, 0, -leaf.size * 0.3, -leaf.size * 0.2);
  
  pop(); // Restore drawing state
}

function updateRipples() {
  // Update ripple sizes and remove old ones
  for (let i = ripples.length - 1; i >= 0; i--) {
    ripples[i].size += 2;
    ripples[i].alpha -= 3;
    if (ripples[i].alpha <= 0) {
      ripples.splice(i, 1);
    }
  }
}

function drawRipples() {
  // Draw all active ripples
  for (let ripple of ripples) {
    noFill();
    stroke(255, 255, 250, ripple.alpha);
    strokeWeight(1);
    ellipse(ripple.x, ripple.y, ripple.size);
  }
}

function addLeaf() {
  // Create new leaf object with natural colors
  let newLeaf = {
    x: random(width),
    y: random(-50, -10), // Start above screen
    size: random(leafSize * 0.7, leafSize * 1.3),
    speed: random(leafSpeed * 0.5, leafSpeed * 1.5),
    rotation: random(TWO_PI),
    rotationSpeed: random(-0.02, 0.02),
    // Natural leaf colors (greens and autumn tones)
    r: random(180, 20),
    g: random(200, 230),
    b: random(160, 200),
    alpha: random(200, 255)
  };
  
  leaves.push(newLeaf);
}

function mousePressed() {
  // Create ripple effect where mouse is clicked
  ripples.push({
    x: mouseX,
    y: mouseY,
    size: 10,
    alpha: 150
  });
  
  // Add a few leaves at click position
  for (let i = 0; i < 3; i++) {
    let newLeaf = {
      x: mouseX + random(-20, 20),
      y: mouseY + random(-20, 20),
      size: random(15, 25), //should've added leafSize variable here
      speed: random(1, 2),
      rotation: random(TWO_PI),
      rotationSpeed: random(-0.03, 0.03),
      r: random(190, 200),
      g: random(210, 220),
      b: random(170, 200),
      alpha: 200
    };
    leaves.push(newLeaf);
  }
}

function mouseDragged() {
  // Create ripples while dragging
  if (frameCount % 5 === 0) { // Only every 5 frames to avoid too many
    ripples.push({
      x: mouseX,
      y: mouseY,
      size: 5,
      alpha: 100
    });
  }
}

function keyPressed() {
  // Toggle flow mode with 'F' key
  if (key === 'f' || key === 'F') {
    flowTowardMouse = !flowTowardMouse;
  }
  
  // Clear all leaves with spacebar
  if (key === ' ') {
    leaves = [];
  }
  
  // Add random leaf with any other key
  if (key !== ' ' && key !== 'f' && key !== 'F') {
    addLeaf();
  }
}