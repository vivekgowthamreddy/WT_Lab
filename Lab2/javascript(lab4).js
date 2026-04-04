const adminName="adminn";
let totalstudents=60;
let presentstuedents=45;

console.log("Admin Name is: "+adminName);
console.log("Total Students: "+totalstudents);
console.log("Present Students: "+presentstuedents);

// const reassignment test
try{
  adminName="newadmin";
}
catch(e){
  console.log("Const reassignment error");
}

let absentstudents=totalstudents-presentstuedents;
console.log("Absent Students: "+absentstudents);

document.getElementById("total-count").innerText=totalstudents;
document.getElementById("present").innerText=presentstuedents;
document.getElementById("absent").innerText=absentstudents;

function refreshpage(){
  document.getElementById("total-count").innerText=totalstudents;
  document.getElementById("present").innerText=presentstuedents;
  document.getElementById("absent").innerText=totalstudents-presentstuedents;
}

const attendancepercent=function(){
  return (presentstuedents/totalstudents)*100;
};


const logpercent=()=>console.log("Attendance %: "+attendancepercent());

logpercent();

function Showmessage(msg){
  alert(msg);
}

function addstudent(){
  totalstudents+=1;
  refreshpage();
  Showmessage("student added successfully");
}

function removestudent(){
  if(totalstudents>0){
    totalstudents-=1;
    if(presentstuedents>totalstudents){
      presentstuedents=totalstudents;
    }
    refreshpage();
    Showmessage("student removed successfully");
  }
  else{
    Showmessage("No students to remove");
  }
}

function markpresent(){
  if(confirm("Mark student present?")){
    if(presentstuedents<totalstudents){
      presentstuedents+=1;
      refreshpage();
      alert("marked present successfully");
    }
    else{
      alert("All students are already present");
    }
  }
}

function viewreports(){
  Showmessage(
    "Todays reports\n"+
    "Total Students: "+totalstudents+
    "\nPresent Students: "+presentstuedents+
    "\nAbsent Students: "+(totalstudents-presentstuedents)
  );
}

/* OBJECT */

let adminobject={
  name:adminName,
  role:"Admin",
  college:"rgukt"
};

console.log(adminobject);
console.log(adminobject.name);        // dot
console.log(adminobject["role"]);     // bracket

adminobject.role="System Admin";

adminobject.changerole=function(){
  this.role="Admin";
  return this.role;
};

document.querySelector(".dashboard").addEventListener("mouseover",function(){
  this.style.backgroundColor="#f1f5f9";
});

document.querySelector(".topbar-left input").addEventListener("input",function(e){
  console.log("Searching: "+e.target.value);
});

document.querySelector(".notification").addEventListener("click",function(){
  alert("Notification clicked");
});
