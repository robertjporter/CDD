jQuery(document).ready(function() {
RJP_press_count = 0;
    jQuery(".dev-vote").click(function(){
        heart = jQuery(this);
		RJP_press_count++;
		console.log("Press count= "+RJP_press_count);
		
        // Retrieve post ID from data attribute
        post_id = heart.data("post_id");
		vote_count = heart.data("vote_count")+RJP_press_count;
        user_dev_points = heart.data("user_dev_points")-RJP_press_count;
		
        // Ajax call
        jQuery.ajax({
            type: "post",
            url: ajax_var.url,
            data: "action=dev-vote&nonce="+ajax_var.nonce+"&dev_vote=&post_id="+post_id,
            success: function(count){
				console.log("pre vote_count= "+vote_count);
				console.log("pre user_dev_points= "+user_dev_points);
				
				jQuery(".vote_count").text(vote_count);
				jQuery(".user_dev_points").text(user_dev_points);
            }
        });
         
        return false;
    })
	
	jQuery(".dev-remove").click(function(){
		console.log("dev-remove");
		heart = jQuery(this);
		RJP_press_count--;
		console.log("Press count= "+RJP_press_count);
		
        // Retrieve post ID from data attribute
        post_id = heart.data("post_id");
		vote_count = heart.data("vote_count")+RJP_press_count;
        user_dev_points = heart.data("user_dev_points")-RJP_press_count;
		console.log("test");
		
		// Ajax call
        jQuery.ajax({
            type: "post",
            url: ajax_var.url,
            data: "action=dev-vote&nonce="+ajax_var.nonce+"&dev_remove=&post_id="+post_id,
            success: function(count){
				console.log("vote_count= "+vote_count);
				console.log("user_dev_points= "+user_dev_points);
				
				jQuery(".vote_count").text(vote_count);
				jQuery(".user_dev_points").text(user_dev_points);
			}
        });
         
        return false;
    })
})





















