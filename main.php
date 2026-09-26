<?php
/**
 * Plugin Name: WooCommerce Chemicals Store Manager
 * Description: ระบบจัดการร้านเคมีภัณฑ์สำหรับ WooCommerce
 * Author: Jirakit Pawnsakungrungrot
 * Author URI: https://www.linkedin.com/in/sunny-jirakit
 * Plugin URI: https://github.com/sunny420x/woocommerce-chemicals-store
 * GitHub Plugin URI: https://github.com/sunny420x/woocommerce-chemicals-store
 * Primary Branch: master
 * Version: 1.0.0
 * License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action( 'admin_menu', 'chemicals_store_add_admin_menu' );
function chemicals_store_add_admin_menu() {
    add_menu_page(
        'Chemical Store Manager', 
        'Chemical Store Manager', 
        'manage_options', 
        'chemicals_store', 
        'chemicals_store_display_admin_page', 
        'dashicons-truck', 
        20 
    );
}

add_action( 'admin_init', 'chemicals_store_register_settings' );
function chemicals_store_register_settings() {
    register_setting( 'chemicals_store_options', 'acid_product_ids' );
    register_setting( 'chemicals_store_options', 'basic_product_ids' );
    register_setting( 'chemicals_store_options', 'oxidizer_product_ids' );
    register_setting( 'chemicals_store_options', 'reducing_agent_product_ids' );
}

function chemicals_store_display_admin_page() {
    ?>
    <style>
        .leftside {
            width: 350px;
            background: #f8f8f8;
            height: max-content;
        }
        .leftside h1 {
            background: #009FE3;
            color: #fff;
            font-size: 16px;
            padding: 10px 20px;
            margin: 0;
        }
        .leftside a {
            padding: 10px 20px;
            font-size: 14px;
            background: #f8f8f8;
            color: #000;
            transition: .2s ease-in-out;
            display: block;
            width: 100%;
            text-decoration: none;
        }
        .leftside a.active {
            background: #fff;
        }
        .leftside a:hover {
            background: #fff;
            cursor: pointer;
        }
        .container {
            width: 1200px;
            background: #fff;
        }
        .container h1 {
            background: #555;
            color: #fff;
            font-size: 16px;
            padding: 10px 20px;
            margin: 0;
        }
        .white-label-zone {
            width: calc(100% + 20px);
            height: auto;
            background: #fff;
            display: flex;
            margin: 0 0 0 -20px;
        }
        .white-label-zone {
            h1 {
                padding: 0 20px;
            }
            p {
                padding: 0 20px;
            }
        }
    </style>
    <div class="white-label-zone no-print">
        <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'plugin-logo.jpg' ); ?>" " alt="Plugin Logo" style="width: 125px; height: auto; float: left; margin: 40px 10px 40px 20px; border-radius: 20px;">
        <div style="padding: 20px 0;">
            <h1>WordPress Chemical Store Manager</h1>
            <p>ระบบจัดการร้านเคมีภัณฑ์สำหรับ WordPress</p>
            <p>
            <strong>Github Repository:</strong> <a href="https://github.com/sunny420x/woocommerce-chemicals-store" target="_blank">https://github.com/sunny420x/woocommerce-chemicals-store</a><br>
            <!-- <strong>Documentation:</strong> <a href="https://github.com/sunny420x/woocommerce-chemicals-store/wiki" target="_blank">https://github.com/sunny420x/woocommerce-chemicals-store/wiki</a><br> -->
            <strong>Support:</strong> <a href="https://github.com/sunny420x/woocommerce-chemicals-store/issues" target="_blank">https://github.com/sunny420x/woocommerce-chemicals-store/issues</a><br>
            <strong>Developer:</strong> <a href="https://sunny420x.com" target="_blank">https://sunny420x.com</a>
            </p>
        </div>
    </div>
    <div class="wrap">
        <div style="display: flex;">
            <div class="leftside">
                <h1>WordPress Chemical Store Manager</h1>
                <a href="admin.php?page=chemicals_store&option=settings" <?php if(isset($_GET['option']) && $_GET['option'] == "settings") { echo "class='active'"; } ?>>⚙️ ตั้งค่าระบบ</a>
            </div>
            <div class="container">                
                <?php if(isset($_GET['option']) && $_GET['option'] == "settings") { ?>
                <h1>WordPress Chemical Store Manager Settings</h1>
                <div style="padding: 0 25px 25px 25px;">
                    <form method="post" action="options.php">
                        <?php settings_fields( 'chemicals_store_options' ); ?>

                        <h2> IDs ของสินค้าที่อยู่ในประเภท กรด (Acid):</h2>
                        <input type="text" name="acid_product_ids" value="<?php echo esc_attr(get_option('acid_product_ids', '')); ?>" style="width: 100%;"/>
                        <br>
                        <div style="height: 400px; overflow: auto;">
                            <?php
                            $args = array(
                                'status'  => 'publish',
                                'limit'   => -1, // -1 pulls all items
                                'orderby' => 'name',
                                'order'   => 'ASC',
                            );

                            $all_products = wc_get_products($args);

                            $acid_product_ids = explode(",", get_option('acid_product_ids', ''));

                            foreach ($all_products as $product) {
                                ?>
                                
                                <?php
                                if ($product->get_type() == 'variable') {
                                    $variations = $product->get_available_variations();
                                    
                                    foreach ($variations as $variation) {
                                        $variation_id = $variation['variation_id'];
                                        $is_checked = false;
    
                                        if (!empty($acid_product_ids) && in_array($variation_id, $acid_product_ids)) {
                                            $is_checked = true;
                                        }
            
                                        $attribute_labels = [];
                                        foreach ($variation['attributes'] as $key => $value) {
                                            $attr_name = str_replace('attribute_', '', $key);
                                            $attr_name = wc_attribute_label($attr_name); 
                                            $attribute_labels[] = $attr_name . ': ' . ucfirst($value);
                                        }
                                        $attributes_text = implode(', ', $attribute_labels);
                                        ?>
                                        <p>
                                            <input 
                                                type="checkbox" 
                                                name="acid_products[<?php echo esc_attr($variation_id); ?>]" 
                                                value="<?php echo esc_attr($variation_id); ?>" 
                                                <?php checked($is_checked, true); ?> 
                                                onchange="initProduct('acid');"
                                            />
                                            <?php echo esc_html($product->get_title()) . ' (' . esc_html(urldecode($attributes_text)) . ')'; ?>
                                        </p>
                                        <?php
                                    }
                                } else {
                                    $is_checked = false;
                                    if (!empty($acid_product_ids) && in_array($product->get_id(), $acid_product_ids)) {
                                        $is_checked = true;
                                    }
                                ?>
                                    <p><input type="checkbox" name="acid_products[<?=$product->get_id()?>]" value="<?=$product->get_id()?>" <?php if($is_checked) { echo "checked"; } ?> onchange="initProduct('acid');" /><?php echo esc_html($product->get_title()); ?></p>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>

                        <h2> IDs ของสินค้าที่อยู่ในประเภท เบส (Base):</h2>
                        <input type="text" name="basic_product_ids" value="<?php echo esc_attr(get_option('basic_product_ids', '')); ?>" style="width: 100%;"/>
                        <br>
                        <div style="height: 400px; overflow: auto;">
                            <?php
                            $args = array(
                                'status'  => 'publish',
                                'limit'   => -1, // -1 pulls all items
                                'orderby' => 'name',
                                'order'   => 'ASC',
                            );

                            $all_products = wc_get_products($args);

                            $basic_product_ids = explode(",", get_option('basic_product_ids', ''));

                            foreach ($all_products as $product) {
                                ?>
                                
                                <?php
                                if ($product->get_type() == 'variable') {
                                    $variations = $product->get_available_variations();
                                    
                                    foreach ($variations as $variation) {
                                        $variation_id = $variation['variation_id'];
                                        $is_checked = false;
    
                                        if (!empty($basic_product_ids) && in_array($variation_id, $basic_product_ids)) {
                                            $is_checked = true;
                                        }
            
                                        $attribute_labels = [];
                                        foreach ($variation['attributes'] as $key => $value) {
                                            $attr_name = str_replace('attribute_', '', $key);
                                            $attr_name = wc_attribute_label($attr_name); 
                                            $attribute_labels[] = $attr_name . ': ' . ucfirst($value);
                                        }
                                        $attributes_text = implode(', ', $attribute_labels);
                                        ?>
                                        <p>
                                            <input 
                                                type="checkbox" 
                                                name="basic_products[<?php echo esc_attr($variation_id); ?>]" 
                                                value="<?php echo esc_attr($variation_id); ?>" 
                                                <?php checked($is_checked, true); ?> 
                                                onchange="initProduct('basic');"
                                            />
                                            <?php echo esc_html($product->get_title()) . ' (' . esc_html(urldecode($attributes_text)) . ')'; ?>
                                        </p>
                                        <?php
                                    }
                                } else {
                                    $is_checked = false;
                                    if (!empty($basic_product_ids) && in_array($product->get_id(), $basic_product_ids)) {
                                        $is_checked = true;
                                    }
                                ?>
                                    <p><input type="checkbox" name="basic_products[<?=$product->get_id()?>]" value="<?=$product->get_id()?>" <?php if($is_checked) { echo "checked"; } ?> onchange="initProduct('basic');" /><?php echo esc_html($product->get_title()); ?></p>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>

                        <h2> IDs ของสินค้าที่อยู่ในประเภท ตัวทำออกซิไดซ์ (Oxidizer):</h2>
                        <input type="text" name="oxidizer_product_ids" value="<?php echo esc_attr(get_option('oxidizer_product_ids', '')); ?>" style="width: 100%;"/>
                        <br>
                        <div style="height: 400px; overflow: auto;">
                            <?php
                            $args = array(
                                'status'  => 'publish',
                                'limit'   => -1, // -1 pulls all items
                                'orderby' => 'name',
                                'order'   => 'ASC',
                            );

                            $all_products = wc_get_products($args);

                            $oxidizer_product_ids = explode(",", get_option('oxidizer_product_ids', ''));

                            foreach ($all_products as $product) {
                                ?>
                                
                                <?php
                                if ($product->get_type() == 'variable') {
                                    $variations = $product->get_available_variations();
                                    
                                    foreach ($variations as $variation) {
                                        $variation_id = $variation['variation_id'];
                                        $is_checked = false;
    
                                        if (!empty($oxidizer_product_ids) && in_array($variation_id, $oxidizer_product_ids)) {
                                            $is_checked = true;
                                        }
            
                                        $attribute_labels = [];
                                        foreach ($variation['attributes'] as $key => $value) {
                                            $attr_name = str_replace('attribute_', '', $key);
                                            $attr_name = wc_attribute_label($attr_name); 
                                            $attribute_labels[] = $attr_name . ': ' . ucfirst($value);
                                        }
                                        $attributes_text = implode(', ', $attribute_labels);
                                        ?>
                                        <p>
                                            <input 
                                                type="checkbox" 
                                                name="oxidizer_products[<?php echo esc_attr($variation_id); ?>]" 
                                                value="<?php echo esc_attr($variation_id); ?>" 
                                                <?php checked($is_checked, true); ?> 
                                                onchange="initProduct('oxidizer');"
                                            />
                                            <?php echo esc_html($product->get_title()) . ' (' . esc_html(urldecode($attributes_text)) . ')'; ?>
                                        </p>
                                        <?php
                                    }
                                } else {
                                    $is_checked = false;
                                    if (!empty($oxidizer_product_ids) && in_array($product->get_id(), $oxidizer_product_ids)) {
                                        $is_checked = true;
                                    }
                                ?>
                                    <p><input type="checkbox" name="oxidizer_products[<?=$product->get_id()?>]" value="<?=$product->get_id()?>" <?php if($is_checked) { echo "checked"; } ?> onchange="initProduct('oxidizer');" /><?php echo esc_html($product->get_title()); ?></p>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                        
                        <h2> IDs ของสินค้าที่อยู่ในประเภท รีดิวซิงเอเจนต์ (Reducing Agent):</h2>
                        <input type="text" name="reducing_agent_product_ids" value="<?php echo esc_attr(get_option('reducing_agent_product_ids', '')); ?>" style="width: 100%;"/>
                        <br>
                        <div style="height: 400px; overflow: auto;">
                            <?php
                            $args = array(
                                'status'  => 'publish',
                                'limit'   => -1, // -1 pulls all items
                                'orderby' => 'name',
                                'order'   => 'ASC',
                            );

                            $all_products = wc_get_products($args);

                            $reducing_agent_product_ids = explode(",", get_option('reducing_agent_product_ids', ''));

                            foreach ($all_products as $product) {
                                ?>
                                
                                <?php
                                if ($product->get_type() == 'variable') {
                                    $variations = $product->get_available_variations();
                                    
                                    foreach ($variations as $variation) {
                                        $variation_id = $variation['variation_id'];
                                        $is_checked = false;
    
                                        if (!empty($reducing_agent_product_ids) && in_array($variation_id, $reducing_agent_product_ids)) {
                                            $is_checked = true;
                                        }
            
                                        $attribute_labels = [];
                                        foreach ($variation['attributes'] as $key => $value) {
                                            $attr_name = str_replace('attribute_', '', $key);
                                            $attr_name = wc_attribute_label($attr_name); 
                                            $attribute_labels[] = $attr_name . ': ' . ucfirst($value);
                                        }
                                        $attributes_text = implode(', ', $attribute_labels);
                                        ?>
                                        <p>
                                            <input 
                                                type="checkbox" 
                                                name="reducing_agent_products[<?php echo esc_attr($variation_id); ?>]" 
                                                value="<?php echo esc_attr($variation_id); ?>" 
                                                <?php checked($is_checked, true); ?> 
                                                onchange="initProduct('reducing_agent');"
                                            />
                                            <?php echo esc_html($product->get_title()) . ' (' . esc_html(urldecode($attributes_text)) . ')'; ?>
                                        </p>
                                        <?php
                                    }
                                } else {
                                    $is_checked = false;
                                    if (!empty($reducing_agent_product_ids) && in_array($product->get_id(), $reducing_agent_product_ids)) {
                                        $is_checked = true;
                                    }
                                ?>
                                    <p><input type="checkbox" name="reducing_agent_products[<?=$product->get_id()?>]" value="<?=$product->get_id()?>" <?php if($is_checked) { echo "checked"; } ?> onchange="initProduct('reducing_agent');" /><?php echo esc_html($product->get_title()); ?></p>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                        <?php submit_button('บันทึกการตั้งค่า'); ?>
                    </form>
                    <script>
                    function initProduct(type) {
                        const checkedBoxes = document.querySelectorAll(`input[type="checkbox"][name^="${type}_products["]:checked`);
                        let items = []
                        checkedBoxes.forEach(item => {
                            items.push(item.value)
                        })
                        document.getElementsByName(`${type}_product_ids`)[0].value = items.join(",");
                    }
                    </script>
                </div>
                <?php } else { ?>
                <h1>WordPress Chemical Store Manager</h1>
                <div style="padding: 0 25px 25px 25px;">
                    <h2>ระบบนี้คืออะไร ?</h2>
                    <p><strong>WordPress Chemical Store Manager</strong> เป็นปลั๊กอิน WordPress สำหรับจัดการร้านเคมีภัณฑ์</p>
                    <h2>วิธีการติดตั้ง</h2>
                    <p>
                        สามารถติดตั้งปลั้กอินนี้ได้โดยการดาวน์โหลดไฟล์นี้จาก Github หน้านี้ และอัพโหลดลงในหน้า /wp-admin/plugin-install.php หลังจากอัพโหลด 
                        และเปิดใช้งาน (Activate) ระบบจะทำการสร้างตารางและคอลัมน์ใหม่จากตารางเดิมโดยอัตโนมัติ
                    </p>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}