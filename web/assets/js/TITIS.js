/**
 * @Author Eduardo Fonte
 */


(function ($, AdminLTE) {
    "use strict";
    /**
     * Lista de todos los skins disponibles
     *
     * @type Array
     */
    var skins = [
        "skin-blue",
        "skin-black",
        "skin-red",
        "skin-yellow",
        "skin-purple",
        "skin-green",
        "skin-blue-light",
        "skin-black-light",
        "skin-red-light",
        "skin-yellow-light",
        "skin-purple-light",
        "skin-green-light"
    ];
    var skin_guardada = cargar_configuracion('skin');
    if (skin_guardada && $.inArray(skin_guardada, skins)) {
        cambiar_skin(skin_guardada);
    }
    var sidebar = $(".control-sidebar");
    if (cargar_configuracion('sidebar_skin_clara')) {
        sidebar.removeClass("control-sidebar-dark");
        sidebar.addClass("control-sidebar-light");
    } else if (cargar_configuracion('sidebar_skin_oscura')) {
        sidebar.addClass("control-sidebar-dark");
    }

    $("[data-skin]").on('click', function (e) {
        e.preventDefault();
        cambiar_skin($(this).data('skin'));
    });

    $("[data-layout]").on('click', function () {
        cambiar_layout($(this).data('layout'));
    });

    $("[data-controlsidebar]").on('click', function () {
        cambiar_layout($(this).data('controlsidebar'));
        var slide = !AdminLTE.options.controlSidebarOptions.slide;
        AdminLTE.options.controlSidebarOptions.slide = slide;
        if (!slide)
            $('.control-sidebar').removeClass('control-sidebar-open');
    });

    $("[data-sidebarskin='toggle']").on('click', function () {
        if (sidebar.hasClass("control-sidebar-dark")) {
            sidebar.removeClass("control-sidebar-dark");
            sidebar.addClass("control-sidebar-light");
            borrar_configuracion("sidebar_skin_oscura");
            guardar_configuracion("sidebar_skin_clara");
        } else {
            sidebar.removeClass("control-sidebar-light");
            sidebar.addClass("control-sidebar-dark");
            borrar_configuracion("sidebar_skin_clara");
            guardar_configuracion("sidebar_skin_oscura");
        }
    });

    $("[data-enable='expandOnHover']").on('click', function () {
        $(this).attr('disabled', true);
        AdminLTE.pushMenu.expandOnHover();
        if (!$('body').hasClass('sidebar-collapse'))
            $("[data-layout='sidebar-collapse']").click();
    });

    // Reset options
    if ($('body').hasClass('fixed')) {
        $("[data-layout='fixed']").attr('checked', 'checked');
    }
    if ($('body').hasClass('layout-boxed')) {
        $("[data-layout='layout-boxed']").attr('checked', 'checked');
    }
    if ($('body').hasClass('sidebar-collapse')) {
        $("[data-layout='sidebar-collapse']").attr('checked', 'checked');
    }

    /**
     * Reemplaza la skin vieja por la nueva
     * @param String cls La nueva clase de la skin
     * @returns Boolean false para evitar la acción por defecto del enlace
     */
    function cambiar_skin(cls) {
        $.each(skins, function (i) {
            $("body").removeClass(skins[i]);
        });

        $("body").addClass(cls);
        guardar_configuracion('skin', cls);
        return false;
    }

    /**
     * Activa el diseño de las clases
     *
     * @param String cls La clase layout a activar
     * @returns void
     */
    function cambiar_layout(cls) {
        $("body").toggleClass(cls);
        AdminLTE.layout.fixSidebar();
        //Fix the problem with right sidebar and layout boxed
        if (cls === "layout-boxed")
            AdminLTE.controlSidebar._fix($(".control-sidebar-bg"));
        if ($('body').hasClass('fixed') && cls === 'fixed') {
            AdminLTE.pushMenu.expandOnHover();
            AdminLTE.layout.activate();
        }
        AdminLTE.controlSidebar._fix($(".control-sidebar-bg"));
        AdminLTE.controlSidebar._fix($(".control-sidebar"));
    }

    /**
     * Guarda una nueva configuración en el navegador
     *
     * @param String nombre Nombre de la configuración
     * @param String val Valor de la configuración
     * @returns void
     */
    function guardar_configuracion(nombre, val) {
        if (typeof (Storage) !== "undefined") {
            localStorage.setItem(nombre, val);
        } else {
            window.alert('Por favor, use un navegador moderno para poder ver la página correctamente.');
        }
    }

    /**
     * Carga una configuración guardada en el navegador
     *
     * @param String nombre Nombre de la configuración
     * @returns String El valor de la configuración | null
     */
    function cargar_configuracion(nombre) {
        if (typeof (Storage) !== "undefined") {
            return localStorage.getItem(nombre);
        } else {
            window.alert('Por favor, use un navegador moderno para poder ver la página correctamente.');
        }
    }

    /**
     * Borra una configuración del navegador
     *
     * @param String nombre Nombre de la configuración
     * @param String val Valor de la configuración
     * @returns void
     */
    function borrar_configuracion(nombre, val) {
        if (typeof (Storage) !== "undefined") {
            localStorage.removeItem(nombre)
        } else {
            window.alert('Por favor, use un navegador moderno para poder ver la página correctamente.');
        }
    }

    // Esto activa la función de JQuery para poder tener elementos movibles
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    });
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

})(jQuery, $.AdminLTE);

$(function () {
    // Activa el menú
    $(document).ready(function () {
        $('.sidebar-menu li a').click(function (e) {
            $('.sidebar-menu li').removeClass('active');
            localStorage.setItem('id_menu_activo', $(this).parent().prop('id'));
        });
        var $id_menu_activo = localStorage.getItem('id_menu_activo');
        localStorage.removeItem('id_menu_activo'); // Borra el item al cerrar el navegador

        if ($id_menu_activo) {
            var $menu_activo = document.getElementById($id_menu_activo);
            $menu_activo.setAttribute('class', 'active');
            /*if (!$menu_activo.hasClass('active')) {
             $menu_activo.addClass('active');
             }*/
        }
    });
});

/*
 function notificaciones() {
 var getUrl = window.location;
 var feedback = $.ajax({
 type: "GET",
 url: getUrl.protocol + "//" + getUrl.host + "/api/notificaciones?id_usuario=" + id_usuario,
 async: false,
 dataType: "json",
 success: function (data) {
 var datos = data.datos;
 var numero_notificaciones = Object.keys(datos).length;
 var texto_header_notificaciones = $("#header_notificaciones").text();
 $("#header_notificaciones").text(texto_header_notificaciones.replace('%d', numero_notificaciones));
 $('#numero_notificaciones').remove()
 $('#icono_notificaciones').append('<span id="numero_notificaciones" class="label label-warning">' + numero_notificaciones + '</span>');
 }
 }).complete(function () {
 setTimeout(function () {
 notificaciones();
 }, 100000);
 }).responseText;
 // $('div.feedback-box-complete').html('complete feedback');
 }
 
 $(function () {
 notificaciones();
 });
 */
