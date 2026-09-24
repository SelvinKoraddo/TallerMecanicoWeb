const sidebar = document.getElementById("sidebar");
const mainContent = document.getElementById("ContenidoPrincipal");
const heroImg = document.querySelector(".hero-img"); //selecciona la imagen
const openBtn = document.getElementById("openSidebar");
const closeBtn = document.getElementById("closeSidebar");
const footer = document.querySelector('.footer');
const herotxt = document.querySelector(".hero-text"); //selecciona la imagen

openBtn.addEventListener("click", () => {
  sidebar.classList.add("active");
  mainContent.classList.add("shifted");
  heroImg.classList.add("shifted"); //agrega clase a la imagen
  openBtn.style.display = "none"; //Oculta el botón hamburguesa
  footer.classList.add('shifted');
  herotxt.classList.add('shifted');
});

closeBtn.addEventListener("click", () => {
  sidebar.classList.remove("active");
  mainContent.classList.remove("shifted");
  heroImg.classList.remove("shifted"); //la quita al cerrar
  openBtn.style.display = "block"; //volver a mostrar el boton burguer
  footer.classList.remove('shifted');
  herotxt.classList.remove('shifted');

});
