<?php 
/*
Template Name: Feature
*/

get_header(); ?>

	</script>
	<?php //NEW Stuff ?>
	<?php
	$user_ID = get_current_user_id();
	$user_dev_points = get_user_meta($user_ID, 'user_points', true);
	$post_id = get_the_ID();
	$vote_count = count (get_post_meta($post_id, "supporter_id", false));
	$raw_user_support = array_count_values(get_post_meta($post_id, "supporter_id", false));
	$user_support = $raw_user_support[$user_ID];
	
	//Just fxing a bug (blank user support wreaks buttons data passing over to AJAX)
	if (empty($user_support)) {
		$user_support=0;
	}
	
	?>
	<br>Feature (post_id: <?php echo $post_id; ?>) has <span class='vote_count'><?php echo $vote_count;?></span> Dev-points<br>
	<?php
	if($user_ID){?>
		You are user <?php echo $user_ID; ?> and you have <span class='user_dev_points'><?php echo $user_dev_points; ?></span> Dev-points. <span class='user_support'><?php echo $user_support; ?></span> of these were added by you.
		
		<button id="dev-vote-add-one" type='button' 
		class='dev-vote btn btn-success <?php if ($user_support > 0){echo ' hidden';}?>'
		data-post_id=<?php echo $post_id; ?> 
		data-user_id=<?php echo $user_ID; ?> 
		data-user_dev_points=<?php echo $user_dev_points; ?> 
		data-vote_count=<?php echo $vote_count; ?>
		data-user_support=<?php echo $user_support; ?>
		data-press_type="add">
			Add One of Your Dev-Points!
		</button>
		
		<button id="dev-vote-add-another" type='button' 
		class='dev-vote btn btn-info <?php if ($user_support < 1){echo ' hidden';}?>'
		data-post_id=<?php echo $post_id; ?> 
		data-user_id=<?php echo $user_ID; ?> 
		data-user_dev_points=<?php echo $user_dev_points; ?> 
		data-vote_count=<?php echo $vote_count; ?>
		data-user_support=<?php echo $user_support; ?>
		data-press_type="add">
			Add Another Dev-Point.
		</button>
		
		<button id="dev-vote-remove" type='button' 
		class='dev-vote btn btn-danger <?php if ($user_support < 1){echo ' hidden';}?>'
		data-post_id=<?php echo $post_id; ?> 
		data-user_id=<?php echo $user_ID; ?> 
		data-user_dev_points=<?php echo $user_dev_points; ?> 
		data-vote_count=<?php echo $vote_count; ?>
		data-user_support=<?php echo $user_support; ?>
		data-press_type="remove">
			Take Back All Dev-Points.
		</button>
		
		<br><br><button type='button' class='dev-vote btn btn-warning'>
			Get Dev-Points.
		</button>
		
	<?php } else { ?>
		"Please Login or Signup to vote."
	<?php } ?>

	<script type="text/javascript">
		press_count = 1;
		
		post_id = 0;
		user_id = 0;
		user_dev_points = 0;
		vote_count = 0;
		
		jQuery(".dev-vote").click(function(){
			heart = jQuery(this);
			
			test_data = "hey you!";
			
			post_id = heart.data("post_id");
			user_id = heart.data("user_id");
			user_dev_points = heart.data("user_dev_points");
			vote_count = heart.data("vote_count");
			user_support = heart.data("user_support");
			press_type = heart.data("press_type");;
			
			console.log("--NEW PRESS--");
			console.log("post_id: "+post_id);
			console.log("user_id: "+user_id);
			console.log("user_dev_points: "+user_dev_points);
			console.log("vote_count: "+vote_count);
			console.log("user_support: "+user_support);
			console.log("press_type updated to: "+press_type);
			
			if (user_dev_points > 0){
				console.log("User has dev points");
				if (press_type == "add"){
					jQuery.ajax({
						type:"POST",
						url: "../wp-admin/admin-ajax.php",
						data: "action=dev-vote-add&post_id="+post_id+"&user_id="+user_id+"&user_dev_points="+user_dev_points+"&vote_count="+vote_count+"&press_type="+press_type+"&press_count="+press_count,
						success:function(data){
							console.log("ajax send-off to add successful");
							console.log("press_count "+press_count);
							//update status bar
							jQuery('.vote_count').text(vote_count+press_count);
							jQuery('.user_dev_points').text(user_dev_points-press_count);
							jQuery('.user_support').text(user_support+press_count);
							//step up press_count
							press_count++
							console.log("press_count after edit"+press_count);
							//switch hide class if needed
							if (user_dev_points = 1){
								jQuery( "#dev-vote-add-one" ).addClass( "hidden" );
								jQuery( "#dev-vote-add-another" ).removeClass( "hidden" );
								jQuery( "#dev-vote-remove" ).removeClass( "hidden" );
							}
						}
					});
				} else if (press_type == "remove"){
					jQuery.ajax({
						type:"POST",
						url: "../wp-admin/admin-ajax.php",
						data: "action=dev-vote-remove&post_id="+post_id+"&user_id="+user_id+"&user_dev_points="+user_dev_points+"&vote_count="+vote_count+"&press_type="+press_type+"&press_count="+press_count,
						success:function(data){
							console.log("ajax send-off to remove sucess");
							console.log("press_count "+press_count);
							
							//update status bar
							jQuery('.vote_count').text(vote_count-user_support);
							jQuery('.user_dev_points').text(user_dev_points+user_support);
							jQuery('.user_support').text(0);
							//step up press_count
							press_count = 1;
							console.log("press_count after edit "+press_count);
							//reset button hide classes
							jQuery( "#dev-vote-add-one" ).removeClass( "hidden" );
							jQuery( "#dev-vote-add-another" ).addClass( "hidden" );
							jQuery( "#dev-vote-remove" ).addClass( "hidden" );
						}
					});
				} else {
					//ERROR!
					console.log("Error: Button press invalid");
				}
			} else {
				console.log("User does NOT have dev points");
			}
		})
	</script>

<?php get_footer(); ?>




















