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

    <!-- สคริปต์ AJAX สำหรับส่งข้อมูล -->
    <script>
    jQuery(document).ready(function($) {
        $('#btn_generate').on('click', function(e) {
            e.preventDefault();
            
            var topic = $('#gemini_topic').val();
            var language = $('#gemini_language').val();

            if(!topic) {
                alert('กรุณาระบุหัวข้อบทความ');
                return;
            }

            if(!language) {
                alert('กรุณาระบุภาษาของบทความ')
                return;
            }

            var $btn = $(this);
            var $status = $('#gemini_status');
            var $result = $('#gemini_result');

            $btn.prop('disabled', true);
            $status.text('กำลังประมวลผล... (อาจใช้เวลา 15-30 วินาที)').css('color', '#2271b1');
            $result.hide();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'gemini_generate_post_ajax',
                    topic: topic,
                    language: language,
                    security: '<?php echo wp_create_nonce("gemini_generate_nonce"); ?>'
                },
                success: function(response) {
                    $btn.prop('disabled', false);
                    if(response.success) {
                        $status.text('✅ สร้างบทความสำเร็จ!').css('color', 'green');
                        var image_notice = response.data.image_warning
                            ? '<br><span style="color:#996800;">' + $('<div>').text(response.data.image_warning).html() + '</span><br>'
                            : response.data.image_created
                                ? '<br><span style="color:green;">สร้างภาพปกและตั้งเป็น Featured Image แล้ว</span><br>'
                                : '<br><span>ไม่ได้สร้างภาพปก</span><br><span style="color:#996800;">(หากต้องการสร้างภาพปก กรุณาเลือกโมเดล Image Model ในหน้า Settings)</span><br>';
                        $result.html(
                            '<strong>สถานะ:</strong> สร้างเป็น Draft เรียบร้อย<br>' +
                            image_notice +
                            '<a href="' + response.data.edit_url + '" target="_blank" class="button button-primary" style="margin-top:10px;">ไปที่หน้าแก้ไขบทความ (Edit Post)</a>'
                        ).show();
                    } else {
                        $status.text('❌ เกิดข้อผิดพลาด').css('color', 'red');
                        $result.html('Error: ' + response.data).show();
                    }
                },
                error: function(xhr, status, error) {
                    $btn.prop('disabled', false);
                    $status.text('❌ เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์').css('color', 'red');
                    console.log(error);
                }
            });
        });
    });
    </script>
    <?php
}

// 5. ฟังก์ชั่นจัดการ AJAX สร้างโพสต์
add_action( 'wp_ajax_gemini_generate_post_ajax', 'gemini_generate_post_handler' );
function gemini_generate_post_handler() {
    // 1. ตรวจสอบความปลอดภัยและสิทธิ์ผู้ใช้
    check_ajax_referer( 'gemini_generate_nonce', 'security' );

    if ( ! current_user_can( 'publish_posts' ) ) {
        wp_send_json_error( 'คุณไม่มีสิทธิ์สร้างบทความ' );
    }

    $api_key = get_option( 'gemini_api_key' );
    $model_name = get_option( 'gemini_model_name' );
    $image_model_name = get_option( 'gemini_image_model_name', '' );
    
    if ( empty( $api_key ) || empty($model_name ) ) {
        wp_send_json_error( 'กรุณาตั้งค่า API Key และเลือกโมเดลก่อน' );
    }

    $topic = isset( $_POST['topic'] ) ? sanitize_text_field( wp_unslash( $_POST['topic'] ) ) : '';
    $language = isset( $_POST['language'] ) ? sanitize_text_field( wp_unslash( $_POST['language'] ) ) : 'ภาษาไทย';

    if ( empty( $topic ) ) {
        wp_send_json_error( 'กรุณาระบุหัวข้อบทความ' );
    }

    // เงื่อนไขการเลือก Call To Action
    $cta = get_option('call_to_action');
    if($language == "ภาษาอังกฤษ") {
        $cta = get_option('call_to_action_en');
    }

    $site_context = get_option('site_context');

    $text_endpoint = 'https://generativelanguage.googleapis.com/v1beta/' . $model_name . ':generateContent?key=' . $api_key;
    
    $prompt_text = "เขียนบทความบล็อก {$language} ที่มีคุณภาพสูงและอ่านง่าย สำหรับเว็บไซต์ที่เน้นเนื้อหาหมวดหมู่ {$site_context} มีการ Optimize สำหรับ SEO และ AEO เกี่ยวกับหัวข้อ: '{$topic}' 
    โดยจัดรูปแบบเป็น HTML ให้พร้อมใช้งาน ใช้อย่างน้อย <h2>, <h3>, <p>, <ul> ไม่ต้องครอบด้วยแท็ก <html> <body> หรือ markdown code block และเนื้อหามีความยาวอย่างน้อย 600 คำ 
    สามารถใช้ตารางเปรียบเทียบข้อมูลได้ (Optional) ตามความเหมาะสมของข้อมูล มีการอ้างอิงข้อมูลท้ายบทความแบบ APA6";

    $text_body = [
        'contents' => [ ['parts' => [ ['text' => $prompt_text] ] ] ]
    ];

    $text_response = wp_remote_post($text_endpoint, [
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => wp_json_encode( $text_body ),
        'timeout' => 60, // เผื่อเวลาให้ AI คิดสัก 60 วินาที
    ]);

    if ( is_wp_error( $text_response ) ) {
        wp_send_json_error( 'การเชื่อมต่อขัดข้อง: ' . $text_response->get_error_message() );
    }

    $text_data = json_decode( wp_remote_retrieve_body($text_response ), true );
    
    if ( isset( $text_data['error'] ) ) {
        wp_send_json_error( 'Gemini API Error: ' . $text_data['error']['message'] );
    }

    // ดึงข้อความออกมาและทำความสะอาด (ลบ ```html ที่ AI ชอบแถมมา)
    $generated_content = $text_data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    $generated_content = preg_replace('/^```html\s*|```\s*$/i', '', trim($generated_content));

    if(empty($generated_content)) {
        wp_send_json_error( 'API ส่งค่าว่างกลับมา ลองเปลี่ยนโมเดลดูนะครับ' );
    }

    // 3. สร้างบทความลง WordPress (บันทึกเป็น Draft)
    $post_data = [
        'post_title'   => $topic,
        'post_content' => $generated_content . "\n\n" . $cta,
        'post_status'  => 'draft', // แนะนำให้เป็น draft ไว้ก่อน เพื่อให้เราเข้าไปใส่ภาพปกเองแล้วค่อยกด Publish
        'post_author'  => get_current_user_id(),
        'post_type'    => 'post'
    ];

    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( 'บันทึกบทความลง WordPress ไม่สำเร็จ' );
    }

    $image_error = '';
    $image_created = false;

    if ( ! empty( $image_model_name ) ) {
        $image_endpoint = 'https://generativelanguage.googleapis.com/v1beta/' . $image_model_name . ':generateContent?key=' . rawurlencode( $api_key );
        $image_response = wp_remote_post( $image_endpoint, [
            'headers' => [ 'Content-Type' => 'application/json' ],
            'body'    => wp_json_encode([
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => 'Create a professional editorial cover image for a blog article titled "' . $topic . '". No text, letters, logos, watermarks, or UI elements. Match the subject and language-neutral visual meaning of the topic. Clean composition, suitable for a WordPress featured image.',
                            ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'responseModalities' => [ 'TEXT', 'IMAGE' ],
                ],
            ]),
            'timeout' => 120,
        ]);

        if ( is_wp_error( $image_response ) ) {
            $image_error = 'เชื่อมต่อ Gemini Image API ไม่สำเร็จ: ' . $image_response->get_error_message();
        } else {
            $image_data = json_decode( wp_remote_retrieve_body( $image_response ), true );
            $image_part = [];

            foreach ( $image_data['candidates'][0]['content']['parts'] ?? [] as $part ) {
                if ( ! empty( $part['inlineData']['data'] ) ) {
                    $image_part = $part['inlineData'];
                    break;
                }
            }

            if ( isset( $image_data['error']['message'] ) ) {
                $image_error = 'Gemini Image API Error: ' . $image_data['error']['message'];
            } elseif ( ! empty( $image_part['data'] ) ) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/media.php';
                require_once ABSPATH . 'wp-admin/includes/image.php';

                $mime_type = $image_part['mimeType'] ?? 'image/png';
                $file_extension = 'image/jpeg' === $mime_type ? 'jpg' : ( 'image/webp' === $mime_type ? 'webp' : 'png' );
                $temporary_file = wp_tempnam( $topic . '.' . $file_extension );
                $decoded_image = base64_decode( $image_part['data'], true );
                $image_saved = $temporary_file && false !== $decoded_image && file_put_contents( $temporary_file, $decoded_image ) !== false;

                if ( ! $image_saved ) {
                    $image_error = 'ถอดรหัสหรือบันทึกภาพจาก Gemini ไม่สำเร็จ';
                    if ( $temporary_file ) {
                        @unlink( $temporary_file );
                    }
                } else {
                    $image_file = [
                        'name'     => sanitize_file_name( $topic ) . '.' . $file_extension,
                        'type'     => $mime_type,
                        'tmp_name' => $temporary_file,
                        'error'    => 0,
                        'size'     => filesize( $temporary_file ),
                    ];
                    $attachment_id = media_handle_sideload( $image_file, $post_id, $topic );

                    if ( is_wp_error( $attachment_id ) ) {
                        $image_error = 'นำภาพเข้า Media Library ไม่สำเร็จ: ' . $attachment_id->get_error_message();
                        @unlink( $temporary_file );
                    } else {
                        set_post_thumbnail( $post_id, $attachment_id );
                        $image_created = true;
                    }
                }
            } else {
                $image_error = 'Gemini ไม่ได้ส่งข้อมูลภาพกลับมา หรือโมเดลนี้ไม่รองรับการสร้างภาพ';
            }
        }
    }

    // 4. ส่งค่าความสำเร็จและ URL สำหรับให้ User กดเข้าไปหน้าแก้ไข
    $result = [
        'post_id'  => $post_id,
        'edit_url' => admin_url( 'post.php?post=' . $post_id . '&action=edit' ),
        'image_created' => $image_created,
    ];

    if ( ! empty( $image_error ) ) {
        $result['image_warning'] = $image_error;
    }

    wp_send_json_success( $result );
}