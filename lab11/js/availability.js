function isProductAvailable() {
    var availability = document.getElementById("availability");
    var availability_text = document.getElementById("availability_text");

    // Jeżeli checkbox jest włączony
    if (availability.checked == true){
      availability_text.textContent = "Tak";
    } 
    else {  // jeżeli jest on wyłączony
      availability_text.textContent = "Nie";
    }
  }