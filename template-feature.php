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
	$vote_count = count (get_post_meta($post_id, "supporter_id", false));
	$post_id = get_the_ID();
	
	?>
	<br>Feature (post_id: <?php echo $post_id; ?>) has <span class='vote_count'><? echo $vote_count;?></span> Dev-points<br>
	<?php
	if($user_ID){?>
		You are user <?php echo $user_ID; ?> and you have <span class='user_dev_points'><?php echo $user_dev_points; ?></span> Dev-points.
		
		<br><button id="dev-vote" type='button' class='dev-vote2 btn btn-info'
		data-post_id=<?php echo $post_id; ?> 
		data-user_id=<?php echo $user_ID; ?> 
		data-user_dev_points=<?php echo $user_dev_points; ?> 
		data-vote_count=<?php echo $vote_count; ?>
		data-press_type="add">
			Add Another Dev-Point.
		</button>
		
		<br><button id="dev-vote" type='button' class='dev-vote2 btn btn-info'
		data-post_id=<?php echo $post_id; ?> 
		data-user_id=<?php echo $user_ID; ?> 
		data-user_dev_points=<?php echo $user_dev_points; ?> 
		data-vote_count=<?php echo $vote_count; ?>
		data-press_type="remove">
			Take Back One Dev-Point.
		</button>
		
	<?php } else { ?>
		"Please Login or Signup to vote."
	<?php } ?>

	<script type="text/javascript">
		press_count = 0;
		
		post_id = 0;
		user_id = 0;
		user_dev_points = 0;
		vote_count = 0;
	
		jQuery(".dev-vote2").click(function(){
			heart = jQuery(this);
			
			test_data = "hey you!";
			
			post_id = heart.data("post_id");
			user_id = heart.data("user_id");
			user_dev_points = heart.data("user_dev_points");
			vote_count = heart.data("vote_count");
			
			press_type = heart.data("press_type");;
			
			console.log("post_id: "+post_id);
			console.log("user_id: "+user_id);
			console.log("user_dev_points: "+user_dev_points);
			console.log("vote_count: "+vote_count);
			console.log("press_type: "+press_type);
			
			if (press_type == "add"){
				jQuery.ajax({
					type:"POST",
					url: ajax_var.url,
					data: "action=dev-vote-add&post_id="+post_id+"&user_id="+user_id+"&user_dev_points="+user_dev_points+"&vote_count="+vote_count+"&press_type="+press_type+"&test_data="+test_data,
					success:function(data){
						console.log("ajax sucess");
					}
				});
			} else if (press_type == "remove"){
				jQuery.ajax({
					type:"POST",
					url: ajax_var.url,
					data: "action=dev-vote-remove&post_id="+post_id+"&user_id="+user_id+"&user_dev_points="+user_dev_points+"&vote_count="+vote_count+"&press_type="+press_type+"&test_data="+test_data,
					success:function(data){
						console.log("ajax sucess");
						//UPDATE 
					}
				});
			} else {
				//ERROR!
				console.log("Error: Button press invalid");
			}
		})
	</script>

<?php get_footer(); ?>




















