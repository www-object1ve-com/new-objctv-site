<?php
function registrar_menus() {
    register_nav_menus(array(
        'menu-principal' => __('Menu Principal'),
        'footer-menu' => __('Menu do Rodapé')
    ));
}
add_action('init', 'registrar_menus');

function my_acf_options_page() {
    acf_add_options_page(array(
        'page_title'    => 'Configurações do Site',
        'menu_title'    => 'Configurações',
        'menu_slug'     => 'configuracoes-do-site',
        'capability'    => 'manage_options',
        'redirect'      => false
    ));
}
add_action('acf/init', 'my_acf_options_page');
