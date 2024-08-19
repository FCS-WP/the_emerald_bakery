<?php
/*
Plugin Name: Custom Store Map Plugin
Description: The plugin displays a map with shops and search functionality.
Version: 1.1
Author: Zippy
*/

if (!defined('ABSPATH')) {
    exit;
}
include plugin_dir_path(__FILE__) . 'admin/countries.php';
class CustomStoreMapPlugin
{
    private $countries;
    public function __construct()
    {
        global $country_coordinates;
        add_action('init', array($this, 'create_store_taxonomies'), 0);

        add_action('admin_menu', array($this, 'create_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
        add_shortcode('custom_store_map', array($this, 'shortcode_callback'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('store-name_add_form_fields', array($this, 'add_taxonomy_fields'));
        add_action('store-name_edit_form_fields', array($this, 'edit_taxonomy_fields'));

        add_action('created_store-name', array($this, 'save_taxonomy_fields'), 10, 2);
        add_action('edited_store-name', array($this, 'save_taxonomy_fields'), 10, 2);

        register_deactivation_hook(__FILE__, array($this, 'plugin_deactivation'));

        $this->countries = $country_coordinates;
    }

    public function create_admin_menu()
    {
        add_menu_page(
            'Custom Store Map',
            'Custom Store Map',
            'manage_options',
            'custom-store-map',
            array($this, 'admin_page_callback'),
            'dashicons-location',
            100
        );
    }

    public function enqueue_admin_scripts()
    {
        wp_enqueue_script('custom-store-map-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery', 'media-upload', 'thickbox'), null, true);
        wp_enqueue_style('custom-store-map-admin', plugin_dir_url(__FILE__) . 'css/admin.css');
        wp_enqueue_style('thickbox');
    }

    public function register_scripts()
    {
        $api_key = get_option('custom_store_map_api_key', '');
        $location_country = get_option('custom_store_map_location_country', '10.8231,106.6297'); // Default to Ho Chi Minh City
        $zoom_level = get_option('custom_store_map_zoom_level', '13');

     

        wp_register_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key .'&loading=async', array(), null, true);
        wp_script_add_data('google-maps-api', 'async', true);
        wp_script_add_data('google-maps-api', 'defer', true);
        wp_register_script('custom-store-map', plugin_dir_url(__FILE__) . 'js/custom-store-map.js', array('jquery'), null, true);
        wp_localize_script('custom-store-map', 'customStoreMapSettings', array(
            'location_country' => $location_country,
            'zoom_level' => $zoom_level
        ));
        wp_register_style('custom-store-map', plugin_dir_url(__FILE__) . 'css/custom-store-map.css');
    }


    public function admin_page_callback()
    {
        include 'admin/admin-page.php';
    }

    public function shortcode_callback()
    {
        ob_start();
        include 'templates/map-template.php';

        wp_enqueue_script('google-maps-api');
        wp_enqueue_script('custom-store-map');
        wp_enqueue_style('custom-store-map');

        return ob_get_clean();
    }

    public function register_settings()
    {
        register_setting('custom_store_map_settings', 'custom_store_map_api_key');
        register_setting('custom_store_map_settings', 'custom_store_map_location_country');
        register_setting('custom_store_map_settings', 'custom_store_map_zoom_level');

        add_settings_section(
            'custom_store_map_section',
            'Store Locations',
            array($this, 'section_callback'),
            'custom-store-map'
        );
        add_settings_field(
            'api_key',
            'Google Maps API Key',
            array($this, 'api_key_callback'),
            'custom-store-map',
            'custom_store_map_section'
        );
        add_settings_field(
            'zoom_level',
            'Zoom Level',
            array($this, 'zoom_level_callback'),
            'custom-store-map',
            'custom_store_map_section'
        );

        add_settings_field(
            'location_country',
            'Location Country (lat,lng)',
            array($this, 'location_country_callback'),
            'custom-store-map',
            'custom_store_map_section'
        );
    }

    public function section_callback()
    {
        echo '<p>To display the store map on your website, use the shortcode <strong>[custom_store_map]</strong> in any page.</p>';
        echo '<h2>Add New Store Locations:</h2>';
        echo '<p>Go to <strong>Products > Stores Name > Add New Store</strong>.</p>';
        echo '<p>Enter the following information:</p>';
        echo '<ul>';
        echo '<li><strong>Store Name:</strong> Name of the store.</li>';
        echo '<li><strong>Store Address:</strong> Address of the store.</li>';
        echo '<li><strong>Store Location (lat,lng):</strong> Geographic coordinates of the store (for example: 10.762622, 106.660172).</li>';
        echo '</ul>';
        echo '<h2>Map Settings:</h2>';
    }


    public function zoom_level_callback()
    {
        $zoom_level = get_option('custom_store_map_zoom_level', '7');
?>
        <input type="number" name="custom_store_map_zoom_level" value="<?php echo esc_attr($zoom_level); ?>" min="1" max="20" />
        <p class="description">Please enter the default zoom level for the map (1-20).</p>
    <?php
    }
    public function location_country_callback()
    {
        $location_country = get_option('custom_store_map_location_country', '');
    ?>
        <select name="custom_store_map_location_country">
            <option value="">Select a country...</option>
            <?php foreach ($this->countries as $country => $coords) : ?>
                <option value="<?php echo esc_attr($coords); ?>" <?php selected($location_country, $coords); ?>>
                    <?php echo esc_html($country); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">Select the default country for the map.</p>
    <?php
    }


    public function api_key_callback()
    {
        $api_key = get_option('custom_store_map_api_key', '');
    ?>
        <input type="text" name="custom_store_map_api_key" value="<?php echo esc_attr($api_key); ?>" placeholder="Enter Google Maps API Key" />
        <p class="description">Please enter the Google Map API key.</p>
    <?php
    }

    public function create_store_taxonomies()
    {
        $labels = array(
            'name' => 'Store Names',
            'singular_name' => 'Store Name',
            'search_items' => 'Search Store Names',
            'all_items' => 'All Store Names',
            'parent_item' => 'Parent Store Name',
            'parent_item_colon' => 'Parent Store Name:',
            'edit_item' => 'Edit Store Name',
            'update_item' => 'Update Store Name',
            'add_new_item' => 'Add New Store Name',
            'new_item_name' => 'New Store Name',
            'menu_name' => 'Store Names',
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'store-name', 'with_front' => false),
            'show_in_rest' => true,
        );

        register_taxonomy('store-name', 'product', $args);
    }

    public function add_taxonomy_fields()
    {
    ?>
        <div class="form-field">
            <label for="store-address">Store Address</label>
            <input type="text" name="term_meta[store-address]" id="store-address" />
            <p class="description">Enter the address of the store.</p>
        </div>
        <div class="form-field">
            <label for="store-location">Store Location (lat,lng)</label>
            <input type="text" name="term_meta[store-location]" id="store-location" />
            <p class="description">Enter the location coordinates of the store.</p>
        </div>
        <div class="form-field">
            <label for="store-map-link">Map Link</label>
            <input type="text" name="term_meta[store-map-link]" id="store-map-link" />
            <p class="description">Enter the link to the store's map.</p>
        </div>
        <div class="form-field">
            <label for="store-icon">Store Icon</label>
            <input type="hidden" name="term_meta[store-icon]" id="store-icon" class="store-icon" value="">
            <div class="image-preview"></div>
            <button type="button" class="upload-image-button button">Upload/Select Image</button>
            <button type="button" class="remove-image-button button">Remove Image</button>
            <p class="description">Upload or select an image for the store's icon.</p>
        </div>
    <?php
    }

    public function edit_taxonomy_fields($term)
    {
        $term_id = $term->term_id;
        $term_meta = get_option("taxonomy_$term_id");
    ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="store-address">Store Address</label></th>
            <td>
                <input type="text" name="term_meta[store-address]" id="store-address" value="<?php echo esc_attr($term_meta['store-address']) ? esc_attr($term_meta['store-address']) : ''; ?>" />
                <p class="description">Enter the address of the store.</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="store-location">Store Location (lat,lng)</label></th>
            <td>
                <input type="text" name="term_meta[store-location]" id="store-location" value="<?php echo esc_attr($term_meta['store-location']) ? esc_attr($term_meta['store-location']) : ''; ?>" />
                <p class="description">Enter the location coordinates of the store.</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="store-map-link">Map Link</label></th>
            <td>
                <input type="text" name="term_meta[store-map-link]" id="store-map-link" value="<?php echo esc_attr($term_meta['store-map-link']) ? esc_attr($term_meta['store-map-link']) : ''; ?>" />
                <p class="description">Enter the link to the store's map.</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="store-icon">Store Icon</label></th>
            <td>
                <input type="hidden" name="term_meta[store-icon]" id="store-icon" class="store-icon" value="<?php echo esc_attr($term_meta['store-icon']) ? esc_attr($term_meta['store-icon']) : ''; ?>">
                <button type="button" class="upload-image-button button">Upload/Select Image</button>
                <button type="button" class="remove-image-button button">Remove Image</button>
                <div class="image-preview">
                    <?php if (!empty($term_meta['store-icon'])) : ?>
                        <img src="<?php echo esc_url($term_meta['store-icon']); ?>" style="max-width: 100px; max-height: 100px;" />
                    <?php endif; ?>
                </div>
                <p class="description">Upload or select an image for the store's icon.</p>
            </td>
        </tr>
<?php
    }


    public function save_taxonomy_fields($term_id)
    {
        if (isset($_POST['term_meta'])) {
            $term_meta = get_option("taxonomy_$term_id");
            $cat_keys = array_keys($_POST['term_meta']);
            foreach ($cat_keys as $key) {
                if (isset($_POST['term_meta'][$key])) {
                    $term_meta[$key] = $_POST['term_meta'][$key];
                }
            }
            update_option("taxonomy_$term_id", $term_meta);
        }
    }

    public function plugin_deactivation()
    {
        unregister_taxonomy('store-name');
        delete_option('custom_store_map_api_key');
        delete_option('custom_store_map_location_country');
    }
}

new CustomStoreMapPlugin();
?>