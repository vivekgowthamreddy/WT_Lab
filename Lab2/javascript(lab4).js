// ==========================================
// LAB 4: JavaScript Fundamentals
// ==========================================

// --- 1. Variables ---
console.log("--- 1. Variables ---");
let totalStudents = 120;
let presentStudents = 105;
const COLLEGE_NAME = "Smart Student System";

// Demonstrate reassignment using let
presentStudents = 110; 

// Attempt reassignment of const and observe behavior
try {
  COLLEGE_NAME = "New System";
} catch (error) {
  console.log("Const Reassignment Error Caught:", error.message);
}

// Log variable values in the console
console.log("Total Students:", totalStudents);
console.log("College Name:", COLLEGE_NAME);

// Display variable values in the DOM
document.getElementById("val-total").innerText = totalStudents;
document.getElementById("val-present").innerText = presentStudents;
document.getElementById("val-absent").innerText = totalStudents - presentStudents;
document.getElementById("val-courses").innerText = 4;


// --- 2. Functions ---
console.log("\n--- 2. Functions ---");

// Function declaration with parameters and return value
function calculateAbsent(total, present) {
    return total - present;
}

// Function expression
const updateDOMStats = function() {
    let absent = calculateAbsent(totalStudents, presentStudents);
    document.getElementById("val-total").innerText = totalStudents;
    document.getElementById("val-present").innerText = presentStudents;
    // Update website content dynamically using function
    document.getElementById("val-absent").innerText = absent;
    console.log("DOM updated via function Expression - Total:", totalStudents, "Present:", presentStudents);
};

// Arrow function 
const changeSystemMsg = (msg) => {
    document.getElementById("activity-log").innerText = msg;
};


// --- 3. Objects ---
console.log("\n--- 3. Objects ---");

// Create one JavaScript object with key-value pairs
const userProfile = {
    name: "Admin User",
    role: "Administrator",
    status: "Active",
    
    // --- 4. Methods ---
    // Method inside object using 'this' keyword
    updateName: function(newName) {
        this.name = newName; 
        console.log("Profile Name updated via Method to:", this.name);
    },
    
    toggleStatus: function(newStatus) {
        this.status = newStatus;
    }
};

// Access object properties using Dot and Bracket Notation
console.log("Name (Dot Notation):", userProfile.name);
console.log("Role (Bracket Notation):", userProfile["role"]);

// Update object properties dynamically
userProfile["role"] = "Super Admin";

// Display object data on the webpage
document.getElementById("display-user-name").innerText = userProfile.name;
document.getElementById("display-user-role").innerText = userProfile.role;
console.log("Updated Profile Object data:", userProfile);


// --- 5. Pop-up Boxes & 6. Events and Listeners ---
console.log("\n--- Pop-ups & Events ---");

// Event 1: Click (Use addEventListener)
document.getElementById("btn-update-profile").addEventListener("click", function() {
    
    // Pop-up 1: prompt() for user input
    let newName = prompt("Enter new Admin Name:", userProfile.name);
    
    // Decision based on user input
    if (newName && newName.trim() !== "") {
        
        // Pop-up 2: confirm() for yes/no decisions
        let isSure = confirm("Are you sure you want to change your name to " + newName + "?");
        
        if (isSure) {
            // Method triggered by user action updating object data
            userProfile.updateName(newName);
            
            // Modify DOM content based on interaction
            document.getElementById("display-user-name").innerText = userProfile.name;
            changeSystemMsg("Profile action: Admin name was successfully updated.");
            
            // Pop-up 3: alert() for notifications
            alert("Profile successfully updated!");
        } else {
            alert("Action cancelled by user.");
        }
    } else {
        alert("Name change invalid.");
    }
});

// Event 2: Mouseover (Modify Style)
const chartArea = document.getElementById("chart-area");
chartArea.addEventListener("mouseover", function() {
    // Modify style attribute
    this.style.backgroundColor = "#e0e7ff";
    this.style.border = "2px solid #4f46e5";
    this.style.cursor = "pointer";
    document.getElementById("attendance-feedback").innerText = "Hovering over system charts...";
});

// Event 3: Mouseout (Revert Style)
chartArea.addEventListener("mouseout", function() {
    this.style.backgroundColor = "";
    this.style.border = "";
    document.getElementById("attendance-feedback").innerText = "Manage daily student attendance below.";
});

// Event 4: Input Event
document.getElementById("search-input").addEventListener("input", function(e) {
    let query = e.target.value;
    document.getElementById("activity-log").innerText = "User is searching for: " + query;
});

// Reuse the same function in more than one place
document.getElementById("btn-mark-attendance").addEventListener("click", function() {
    if (presentStudents < totalStudents) {
        presentStudents++;
        // Reusing function
        updateDOMStats(); 
        changeSystemMsg("Attendance marked. One student added.");
    } else {
        alert("All students are already present.");
    }
});

document.getElementById("btn-view-reports").addEventListener("click", function() {
    // Alert user after action 
    alert("Todays Report:\nTotal: " + totalStudents + "\nPresent: " + presentStudents + "\nAbsent: " + calculateAbsent(totalStudents, presentStudents));
});
