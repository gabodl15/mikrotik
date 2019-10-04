    <?php
    define('HOME_PATH', 'http://localhost/ISP/');
    $menu =     '<!-- START PAGE SIDEBAR -->';
    $menu .=    '<div class="page-sidebar">';
    $menu .=    '<!-- START X-NAVIGATION -->';
    $menu .=    '<ul class="x-navigation">';
    $menu .=    '<li class="xn-logo">';
    $menu .=    '<a href="'.HOME_PATH.'inicio.php">INTERNAUTAS</a>';
    $menu .=    '<a href="'.HOME_PATH.'#" class="x-navigation-control"></a>';
    $menu .=    '</li>';
    $menu .=    '<li class="xn-profile">';
    $menu .=    '<div class="profile">';
    $menu .=    '<div class="profile-data">';
    $menu .=    '<div class="profile-data-name"></div>';
    $menu .=    '<div class="profile-data-title"></div>';
    $menu .=    '</div>';
    $menu .=    '</div>';
    $menu .=    '</li>';
    $menu .=    '<li class="active">';
    $menu .=    '<a href="'.HOME_PATH.'inicio.php"><span class="fa fa-desktop"></span> <span class="xn-text">Inicio</span></a>';
    $menu .=    '</li>';
    $menu .=    '<li class="xn-openable">';
    $menu .=    '<a href="'.HOME_PATH.'#"><span class="fa fa-files-o"></span> <span class="xn-text">Generales</span></a>';
    $menu .=    '<ul>';
    $menu .=    '<li><a href="'.HOME_PATH.'libreta_virtual.php"><span class="fa fa-users"></span> Libreta virtual</a></li>';
    $menu .=    '<li><a href="'.HOME_PATH.'documentos.php"><span class="fa fa-file"></span> Documentos</a></li>';
    $menu .=    '<li><a href="'.HOME_PATH.'anexos.php"><span class="fa fa-file"></span> Anexos</a></li>';
    $menu .=    '</ul>';
    if ($solo_NOC) {
    $menu .=    '</li>';
    $menu .=    '<li class="xn-openable active">';
    $menu .=    '<a href="'.HOME_PATH.'#"><span class="fa fa-sitemap"></span> <span class="xn-text">Gesti&oacute;n Mikrotiks</span></a>';

    $menu .=       '<ul>';
    $menu .=            '<li class="xn-openable">';
    $menu .=            '<a href="'.HOME_PATH.'#">Clientes</a>';
    $menu .=                '<ul>';
    $menu .=                    '<li class="xn-openable">';
    $menu .=                    '<a href="'.HOME_PATH.'clients/secret.php">Clientes Secret PPP</a>';
    $menu .=                    '</li>';
    $menu .=                    '<li class="xn-openable">';
//    $menu .=                    '<a href="'.HOME_PATH.'reportes/usuarios_userman.php">Clientes PPPoE</a>';
    $menu .=                    '<a href="'.HOME_PATH.'clients/PPPoE.php">Clientes Activos PPPoE</a>';
    $menu .=                    '</li>';
    $menu .=                    '<li class="xn-openable">';
    $menu .=                    '<a href="'.HOME_PATH.'crear/crear_usuario_pppoe.php">Crear Cliente PPPoE</a>';
    $menu .=                    '</li>';
    $menu .=                    '<li class="xn-openable">';
    $menu .=                    '<a href="'.HOME_PATH.'editar/editar_usuario_PPP.php">Editar Usuarios PPP</a>';
    $menu .=                    '</li>';
    $menu .=                    '<li class="xn-openable">';
    $menu .=                '</ul>';
    $menu .=            '</li>';
    $menu .=        '</ul>';
    $menu .=        '<ul>';
    $menu .=            '<li class="xn-openable">';
    $menu .=            '<a href="'.HOME_PATH.'#">Reportes</a>';
    $menu .=                '<ul>';
    $menu .=                    '<li class="xn-openable">';
    $menu .=                    '<a href="'.HOME_PATH.'report.php">Crear reporte</a>';
    $menu .=                    '</li>';
    $menu .=                    '<li class="xn-openable">';
    $menu .=                    '<a href="#">Ver reportes</a>';
    $menu .=                    '</li>';
    $menu .=                '</ul>';
    $menu .=            '</li>';
    $menu .=        '</ul>';
    $menu .=     '</li>';
    } else {
    }
    $menu .=    '</ul>';
    $menu .=    '<!-- END X-NAVIGATION -->';
    $menu .=    '</div>';
    $menu .=    '<!-- END PAGE SIDEBAR -->';

    $salir = HOME_PATH."action/logout.php";
    ?>
