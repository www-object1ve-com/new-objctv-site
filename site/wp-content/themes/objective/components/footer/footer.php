<footer class="footer-component">
    <div class="footer-area">
        <?php
            $main_image_attachment_id = 11;
            $main_image_footer_url = wp_get_attachment_url($main_image_attachment_id);
            $main_image_footer_alt = get_post_meta($main_image_attachment_id, '_wp_attachment_image_alt', true);;
            
            $transparent_image_attachment_id = 22;
            $transparent_image_url = wp_get_attachment_url($transparent_image_attachment_id);
            $main_image_footer_alt = get_post_meta($transparent_image_attachment_id, '_wp_attachment_image_alt', true);;
        ?>
        <img class="main-image" src="<?= $main_image_footer_url; ?>" alt="<?= $main_image_alt; ?>" width="150" height="32">
        <div class="main-menu">
            <section class="infos">
                <p class="description"><b>Objctv.one -</b> Your best solution in Advertising, Development, and Design</p>
                <?= get_template_part('components/social-medias/social-media', 'social-media'); ?>
                <p class="street">Av. Minas Gerais 300A Cruzeiro, SP, Brazil - 12712-010</p>
                <p class="terms-conditional">Termos de uso e privacidade</p>
            </section>        
            <section class="contacts">
                <div class="contact e-mail">
                    <h2>E-mail</h2>
                    <p>contact@objctv.one</p>
                </div>
                <div class="contact">
                    <h2>Fale Conosco</h2>
                    <p>+55 12 3145-6841</p>
                </div>
                <div class="contact">
                    <h2>Envie seu Currículo</h2>
                    <p>recruting@objctv.one</p>
                </div>
            </section>
            <section class="menu">
                <h2>Menu</h2>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'menu_class' => 'footer-menu',
                        'container' => 'nav',
                    ));
                ?>
            </section>
            <section class="certifications">
                <h2>Certificações</h2>
            </section>
        </div>
        <img class="transparent-image" src="<?= $transparent_image_url; ?>" alt="<?= $transparent_image_alt; ?>" width="842" height="178">
    </div>
</footer>