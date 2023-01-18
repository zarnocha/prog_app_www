function isCheckboxChecked() {
    var status = document.getElementById("status");
    var status_label = document.getElementById("status_label");

    // Jeżeli checkbox jest włączony
    if (status.checked == true){
      status_label.textContent = "Aktywna";
    } 
    else {  // jeżeli jest on wyłączony
      status_label.textContent = "Nieaktywna";
    }
  }