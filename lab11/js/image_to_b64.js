function readFile() {
  
    if (!this.files || !this.files[0]) return;
      
    const FR = new FileReader();
      
    FR.addEventListener("load", function(evt) {
        document.querySelector("#img").src         = evt.target.result;
        document.querySelector("#img").style.height = '150px';
        document.querySelector("#img").style.width = '150px';
        document.querySelector("#img").setAttribute("width", '150px');
        document.querySelector("#img").setAttribute("height", '150px');
      document.querySelector("#b64").textContent = evt.target.result;
      document.querySelector("#b64").value = evt.target.result;
    }); 
      
    FR.readAsDataURL(this.files[0]);
    
  }

  
  document.querySelector("#input_picture").addEventListener("change", readFile)