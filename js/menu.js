// Opcional: Agregar un identificador único a cada botón
document.querySelectorAll('.btn_menu').forEach((btn, index) => {
    btn.setAttribute('data-index', index);
});

// Mostrar texto específico cuando se hace hover sobre el botón
document.querySelectorAll('.btn_menu').forEach(btn => {
    btn.addEventListener('mouseenter', () => {
        const texto = btn.querySelector('.btn_texto').innerText;
        console.log(texto); // Puedes quitar esta línea si no necesitas la consola
    });
});