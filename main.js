// navabar js start

const list = document.querySelectorAll(".list");
const checkBox = document.querySelector(".checkbox1");
function makeLinkActive() {
  list.forEach((item) => {
    item.classList.remove("active");
    this.classList.add("active");
  });
}
list.forEach((item) => {
  item.addEventListener("click", makeLinkActive);
});

let body = document.body;

checkBox.addEventListener("change", () => {
  document.body.classList.toggle("dark__theme");
});

// navabar js end

//middel button
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}





function Submit(){
  const submitContainer = document.getElementById("Containerbox"); 
  submitContainer.textContent = ''; 
  submitContainer.innerHTML += 
  `<div class="submit">
       <div class="submitDiv">
          <div class="input">
             <p>Student ID:</p> 
             <input type="text" />
          </div>
          <div class="input">
             <p>Educational Year:</p> 
             <input type="text" />
          </div>
          <div class="input">
             <p>Educational semester:</p> 
             <input type="text" />
          </div>
          <div class="input">
             <p>Enrolled Course:</p> 
             <input type="text" />
          </div>
          <div class="input">
             <p>Enrolled Section:</p> 
             <input type="text" />
          </div>
          <div class="input">
             <p>Obtained grade:</p> 
             <input type="text" />
          </div>
       </div>
       <button onclick="submit()" id="submit-btn" class="custom-btn btn-11" 
       >Submit</button>
  </div>`
}
function submit(){
 alert("successfully submitted"); 
}


document.getElementById("forgot").addEventListener("click", function(){
  alert("oops! contact with register office!"); 
  
})