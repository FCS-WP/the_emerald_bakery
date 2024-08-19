<div class="wrap">
    <h1>Custom Store Map</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('custom_store_map_settings');
        do_settings_sections('custom-store-map');
        submit_button();
        ?>
    </form>
</div>
