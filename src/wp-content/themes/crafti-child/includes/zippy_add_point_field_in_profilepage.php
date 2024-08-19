<?php
//Function to add points field in profile page
add_action('edit_user_profile', 'add_custom_field_point');
function add_custom_field_point(){
    $user_point = get_user_points_by_id($_GET['user_id']);
    ?>
    <table class="form-table" id="fieldset-billing">
		<tbody><tr>
		<th>
			<label for="billing_first_name">Point</label>
		</th>
		<td>
        <?php
        if(empty($user_point)){ ?>
            <input type="text" name="points-user" id="points-user" value="" class="regular-text">
		    <p class="description" style="color: red">This user currently has no points, please update their points.</p>
        <?php }else{ ?>
            <input type="text" name="points-user" id="points-user" value="<?php echo $user_point ?>" class="regular-text">
        <?php } ?>
		
		</td>
		</tr>
    </tbody></table>
<?php 

}

//Function to save and update points in profile page
add_action('edit_user_profile_update', 'save_custom_field_point');
function save_custom_field_point($user_id) {
    if ( is_plugin_active( 'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php' ) ) {
        if (class_exists('WC_Points_Rewards_Manager')) {
            WC_Points_Rewards_Manager::set_points_balance($_POST['user_id'],$_POST['points-user'], 'admin-adjustment');
        }else{
            return;
        }
    } else {
       return;
    }
    
}
