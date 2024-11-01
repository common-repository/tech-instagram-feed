jQuery(document).ready(function($) {

	//Autofill the token and id
	var hash = window.location.hash,
        token = hash.substring(14),
        id = token.split('.')[0];
		
		var access_token = jQuery('#tech_insta_access_token');
		var user_id = jQuery('#tech_insta_user_id');
		if(!access_token.val() || !user_id.val())
		{
			if(access_token.val()!=token || user_id.val()!=id)
			{
				access_token.val(token);
				user_id.val(id);
				
			}
			
		}
		
		
		
		
});