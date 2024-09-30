
$(document).ready(function(){
    $(".form-wrapper .next-button").click(function(e){ // Cambio de selector
        e.preventDefault(); // Evita el comportamiento predeterminado del botón (enviar formulario)
        var button = $(this);
        var currentSection = button.closest(".section");
        var nextSection = currentSection.next(".section");
        var form = $("#form_a"); // Captura el formulario correctamente
    
        // Verifica la validez de la sección actual antes de avanzar
        if (validateSection(currentSection)) {
            currentSection.removeClass("is-active");
            nextSection.addClass("is-active");
        // Envía el formulario actual
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                // Éxito: la inserción en la base de datos fue exitosa
                var currentSection = button.parents(".section");
                var nextSection = currentSection.next(".section");
        
                // Oculta el formulario actual y muestra el siguiente con una transición
                currentSection.animate({ opacity: 0 }, 500, function() {
                    currentSection.removeClass("is-active");
                    nextSection.addClass("is-active").animate({ opacity: 1 }, 500);
                });
        
                // Actualiza el estado de las secciones en el encabezado
                var currentSectionIndex = currentSection.index();
                $('.steps li').eq(currentSectionIndex).removeClass("is-active");
                $('.steps li').eq(currentSectionIndex + 1).addClass("is-active");
                
                // Si es el último formulario, oculta el botón "Next"
                if(nextSection.index() === $('.form-wrapper .section').length - 1) {
                    button.hide();
                }
            
            },
            error: function(error) {
                // Maneja los errores si es necesario
            }
        });
}
else {
    alert("Por favor, complete todos los campos obligatorios.");
}
});


function validateSection(section) {
    var isValid = true;
    section.find('input[required]').each(function(){
        if ($.trim($(this).val()) === '') {
            isValid = false;
            $(this).addClass('error');
        } else {
            $(this).removeClass('error');
        }
    });
    return isValid;
}
});

