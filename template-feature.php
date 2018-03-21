<?php 
/*
Template Name: Feature
*/

get_header(); ?>

<?php
	global $wpdb;
	$customers = $wpdb->get_results("SELECT * FROM customers;");
	echo "<table>";
	foreach($customers as $customer){
	echo "<tr>";
	echo "<td>".$customer->name."</td>";
	echo "<td>".$customer->email."</td>";
	echo "<td>".$customer->phone."</td>";
	echo "<td>".$customer->address."</td>";
	echo "</tr>";
	}
	echo "</table>";
?>

	<form type="post" action="" id="newCustomerForm">

	<label for="name">Name:</label>
	<input name="name" type="text" />

	<label for="email">Email:</label>
	<input name="email" type="text" />

	<label for="phone">Phone:</label>
	<input name="phone" type="text" />

	<label for="address">Address:</label>
	<input name="address" type="text" />

	<input type="hidden" name="action" value="addCustomer"/>
	<input class="btn btn-success" type="submit">
	</form>
	<br/><br/>
	<div id="feedback"></div>
	<br/><br/>
	
	<script type="text/javascript">
		jQuery('#newCustomerForm').submit(ajaxSubmit);

		function ajaxSubmit(){

		var newCustomerForm = jQuery(this).serialize();

		jQuery.ajax({
		type:"POST",
		url: ajax_var.url,
		data: newCustomerForm,
		success:function(data){
		jQuery("#feedback").html(data);
		}
		});

		return false;
		}
	</script>
	<?php //NEW Stuff ?>
	<?php
	$user_ID = get_current_user_id();
	$user_dev_points = get_user_meta($user_ID, 'user_points', true);
	$vote_count = count (get_post_meta($post_id, "supporter_id", false));
	?>
	<br>This Feature has <span class='vote_count'><? echo $vote_count;?></span> Dev-points<br>
	<?php
	if($user_ID){?>
		You are user <?php echo $user_ID; ?> and you have <span class='user_dev_points'><?php echo $user_dev_points; ?></span> Dev-points.
		
		<br><button data-post_id='<?php echo $post_id;?>' 
		data-vote_count='<?php echo $vote_count;?>' 
		data-user_dev_points='<?php echo $user_dev_points;?>' 
		type='button' 
		class='btn btn-success dev-vote'>
			Support With Dev Point.
		</button>
		
		<br><button data-post_id='<?php echo $post_id;?>' 
		data-vote_count='<?php echo $vote_count;?>' 
		data-user_dev_points='<?php echo $user_dev_points;?>' 
		type='button' 
		class='btn btn-info dev-vote'>
			Add Another Dev-Point.
		</button>
		
		<button data-post_id='<?php echo $post_id;?>' 
		data-vote_count='<?php echo $vote_count;?>' 
		data-user_dev_points='<?php echo $user_dev_points;?>' 
		type='button' 
		class='btn btn-danger dev-remove'>
			Remove One Dev-Point.
		</button>
	<?php } else { ?>
		"Please Login or Signup to vote."
	<?php } ?>



<?php get_footer(); ?>