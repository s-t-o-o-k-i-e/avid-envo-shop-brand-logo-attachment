<?php
function brand_logo_sidebar(){
    add_menu_page(
        'Brand Logo',
        'Brand Logo',
        'manage_options',
        'brand-logo-dashboard',
        'brand_logo_dashboard',
        'dashicons-tagcloud',
        10
    );
}
add_action( 'admin_menu', 'brand_logo_sidebar' );

function brand_logo_dashboard(){
    echo '<h1>BRAND LOGO</h1>';
    echo '<form method="post">
    <input type="text" name="new_brand_name" placeholder="Brand">
    <input type="text" name="new_brand_logo_url" placeholder="Logo URL">
    <input type="submit" name="add_new_brand_info" value="Add Brand">
    </form><br>';

    $brand_logo_info = get_option('brand_logo_info', array());

    if (isset($_POST['add_new_brand_info'])){

        $new_brand_name = $_POST['new_brand_name'];
        $new_brand_logo_url = $_POST['new_brand_logo_url'];

        $new_brand_info = array(
            'brand_name' => $new_brand_name,
            'brand_logo_url' => $new_brand_logo_url
        );

        $brand_logo_info[] = $new_brand_info;
        update_option('brand_logo_info', $brand_logo_info);
    }

    if (isset($_POST['delete_brand'])) {
        $brand_to_delete = $_POST['delete_brand'];
        foreach ($brand_logo_info as $key => $brand) {
            if ($brand['brand_name'] === $brand_to_delete) {
                unset($brand_logo_info[$key]);
            }
        }
        $brand_logo_info = array_values($brand_logo_info);
        update_option('brand_logo_info', $brand_logo_info);
    }
    echo '
    <form method="post"><center>';
    foreach ($brand_logo_info as $brand){
        echo '<div class="brand-logo-wrapper">';
        echo '<div class="logo-info-container">';
        echo '<img class="brand-logo-image-preview" src="' . $brand['brand_logo_url'] . '"><span class="brand-2nd-row">';
        echo strtoupper($brand['brand_name']);
        //echo '<code class="brand-logo-url">' . $brand['brand_logo_url'] . '</code>';
        echo '<button class="brand-delete-button" name="delete_brand" value="' . $brand['brand_name'] . '">×</button></span>';
        echo '</div></div>';
    }
    echo '</center></form><details class="db-validation-wrap"><summary class="db-validation-header"><strong>Update Option Validation</strong></summary><div class="db-validation-code"><code>' . serialize($brand_logo_info) . '<br></code></div></detail>';
}
function brand_logo_dashboard_styles() {
    // Enqueue your custom stylesheet for the admin dashboard
    wp_enqueue_style('admin-custom-styles', get_template_directory_uri() . '/admin-styles.css');

    // Add your custom styles inline
    $inline_css = "
        .brand-logo-wrapper{
            background: #a9d18a;
            display: inline-block;
            margin-left: 2.5px;
            margin-right: 2.5px;
            margin-bottom: 5px;
            padding: 6px;
            color: #384a29;
            border-radius: 10px;
            cursor:default;
        }
        .brand-logo-image-preview{
            height: 30px;
            width: auto;
        }
        .brand-2nd-row{
            display: block;
        }
        .brand-delete-button{
            float: right;
            border-radius:100%;
            background: #db7075;
            color: white;
            border: 0;
        }
        .brand-delete-button:hover{
            background:#DB7D81;
            cursor:pointer;
            color:black;
        }
        .db-validation-code{
            background:black;
            color: white;
            padding-left: 5px;
            padding-right: 15px;
            box-sizing: border-box;
            border-bottom: 5px solid #2b82c9;
            border-left: 5px solid #2b82c9;
            border-right: 5px solid #2b82c9;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .db-validation-header{
            border-radius: 10px;
            background:#2b82c9;
            padding: 10px;
            color: white;
        }   

        .db-validation-wrap{
            width: 90%;
        }
        .db-validation-wrap[open] .db-validation-header{
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
    ";
    wp_add_inline_style('admin-custom-styles', $inline_css);
}
// Hook the function to the admin_enqueue_scripts action
add_action('admin_enqueue_scripts', 'brand_logo_dashboard_styles');
