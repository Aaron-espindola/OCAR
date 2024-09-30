function toggleReparacion() {
    var reparado = document.getElementById("reparado").value;
    var reparacionDiv = document.getElementById("reparacion");
    if (reparado === "si") {
      reparacionDiv.classList.remove("hidden");
    } else {
      reparacionDiv.classList.add("hidden");
    }
  }

  function toggleCompra() {
    var comprado = document.getElementById("comprado").value;
    var origenDiv = document.getElementById("origen");
    var origen = document.getElementById("origen_r").value;
    var compraDiv = document.getElementById("compra");
    if (comprado === "si") {
      origenDiv.classList.remove("hidden");
      if(origen === "taller"){
        compraDiv.classList.remove("hidden");
      }
    } else {
      compraDiv.classList.add("hidden");
      origenDiv.classList.add("hidden");
    }
  }