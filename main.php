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
    register_setting( 'chemicals_store_options', 'acid' );
    register_setting( 'chemicals_store_options', 'basic' );
    register_setting( 'chemicals_store_options', 'oxidizer' );
    register_setting( 'chemicals_store_options', 'reducing_agent' );
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
                <a href="admin.php?page=chemicals_store&option=create" <?php if(isset($_GET['option']) && $_GET['option'] == "create") { echo "class='active'"; } ?>>📝 สร้างบทความใหม่เลย</a>
                <a href="admin.php?page=chemicals_store&option=settings" <?php if(isset($_GET['option']) && $_GET['option'] == "settings") { echo "class='active'"; } ?>>⚙️ ตั้งค่าระบบ</a>
            </div>
            <div class="container">                
                <?php if(isset($_GET['option']) && $_GET['option'] == "settings") { ?>
                <h1>WordPress Chemical Store Manager Settings</h1>
                <div style="padding: 0 25px 25px 25px;">
                    <form method="post" action="options.php">
                        <?php settings_fields( 'chemicals_store_options' ); ?>
                        <?php do_settings_sections( 'chemicals_store_options' ); ?>
                        <?php submit_button('บันทึกการตั้งค่า'); ?>
                    </form>
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