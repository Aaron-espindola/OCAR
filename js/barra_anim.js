const input = document.getElementById("input-buscar");
const searchBtn = document.getElementById("button-buscar");

const expand = () => {
  searchBtn.classList.toggle("close");
  input.classList.toggle("square");
};

searchBtn.addEventListener("click", expand);

