const sidebar = document.getElementById("sidebar");
const openBtn = document.getElementById("openSidebar");
const closeBtn = document.getElementById("closeSidebar");
const footer = document.querySelector('.footer');
const herotxt = document.querySelector(".hero");

openBtn.addEventListener("click", () => {
  sidebar.classList.add("active");
  openBtn.style.display = "none"; //Oculta el botón hamburguesa
  footer.classList.add('shifted');
  herotxt.classList.add('shifted');
});

closeBtn.addEventListener("click", () => {
  sidebar.classList.remove("active");
  openBtn.style.display = "block"; //volver a mostrar el boton burguer
  footer.classList.remove('shifted');
  herotxt.classList.remove('shifted');

});
