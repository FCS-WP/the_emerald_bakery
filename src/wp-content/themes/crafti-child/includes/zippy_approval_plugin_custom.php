<?php
//Function to redirect admin after admin approve new user
add_action('new_user_approve_approve_user', 'redirect_user_after_approval');

function redirect_user_after_approval() {
    if ( is_plugin_active( 'new-user-approve/new-user-approve.php' ) ) {
        $id_users = $_GET['user'];
        $link_edit_profile = "/wp-admin/user-edit.php?user_id=" . $id_users ."#points-user";
        wp_redirect($link_edit_profile);
    } else {
        return;
    }
}