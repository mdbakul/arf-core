<?php


// user profile
function tp_user_custom_social_fields( $profileuser ) {
?>
    <h3><?php _e('Social Profile Information', 'seomy'); ?></h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="user_fb"><?php _e( 'Facebook URL', 'seomy'); ?></label>
            </th>
            <td>
                <input type="url" name="user_fb" id="user_fb" value="<?php echo esc_attr( get_the_author_meta( 'user_fb', $profileuser->ID ) ); ?>" class="regular-text" />
                <br><span class="description"><?php _e( 'enter your facebook profile url.', 'seomy' ); ?></span>
            </td>
        </tr>
        <tr>
            <th>
                <label for="user_tw"><?php _e( 'Twitter URL', 'seomy'); ?></label>
            </th>
            <td>
                <input type="url" name="user_tw" id="user_tw" value="<?php echo esc_attr( get_the_author_meta( 'user_tw', $profileuser->ID ) ); ?>" class="regular-text" />
                <br><span class="description"><?php _e( 'enter your twitter profile url.', 'seomy' ); ?></span>
            </td>
        </tr>
        <tr>
            <th>
                <label for="user_ld"><?php _e( 'Linkedin URL', 'seomy'); ?></label>
            </th>
            <td>
                <input type="url" name="user_ld" id="user_ld" value="<?php echo esc_attr( get_the_author_meta( 'user_ld', $profileuser->ID ) ); ?>" class="regular-text" />
                <br><span class="description"><?php _e( 'enter your linkedin profile url.', 'seomy' ); ?></span>
            </td>
        </tr>
        <tr>
            <th>
                <label for="user_in"><?php _e( 'Instagram URL', 'seomy'); ?></label>
            </th>
            <td>
                <input type="url" name="user_in" id="user_in" value="<?php echo esc_attr( get_the_author_meta( 'user_in', $profileuser->ID ) ); ?>" class="regular-text" />
                <br><span class="description"><?php _e( 'enter your instagram profile url.', 'seomy' ); ?></span>
            </td>
        </tr>
    </table>
<?php
}
add_action( 'show_user_profile', 'tp_user_custom_social_fields' );
add_action( 'edit_user_profile', 'tp_user_custom_social_fields' );

function save_custom_user_profile_fields($user_id) {
    if (current_user_can('edit_user', $user_id)) {
        update_user_meta($user_id, 'user_fb', sanitize_text_field($_POST['user_fb']));
        update_user_meta($user_id, 'user_tw', sanitize_text_field($_POST['user_tw']));
        update_user_meta($user_id, 'user_ld', sanitize_text_field($_POST['user_ld']));
        update_user_meta($user_id, 'user_in', sanitize_text_field($_POST['user_in']));
    }
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');