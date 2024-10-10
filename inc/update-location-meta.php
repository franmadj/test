<?php
function update_map_data_post( $post_id ) {
    if(get_post_type(  $post_id ) == "locations"):
	    // get new value
	    $map_location = get_field('location',$post_id);
	    $server_key='AIzaSyAR0JcTIISM1lfgw7BDmHe97lva61zGKKY';
	    $latlng =$map_location['lat'].','.$map_location['lng'];
	    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latlng.'&key='.$server_key.'&sensor=true';
			
			// make the HTTP request
			$data = @file_get_contents($url);
			// parse the json response

			$jsondata = json_decode($data,true);
			
			if(is_array($jsondata )&& $jsondata ['status']=='OK') // this piece of code is looping through each component in ['address_components']
			{
				foreach ($jsondata['results'][0]['address_components'] as $comp) {
					foreach ($comp['types'] as $currType){
						// Here I get all the information I need and store it into vars
						if($currType == 'administrative_area_level_1'){
							$state = $comp['long_name'];
							update_field('location_state',$state,$post_id);
						}
						if($currType == 'locality'){
							$locality = $comp['long_name'];
							update_field('location_locality',$locality,$post_id);
						}
						if($currType == 'country'){
							$country = $comp['long_name'];
							update_field('location_country',$country,$post_id);
						}
						if($currType == 'postal_code'){
							$postal_code = $comp['long_name'];
							update_field('location_postal_code',$postal_code,$post_id);
						}
						
					}
				}
				update_field('lat',$jsondata['results'][0]['geometry']['location']['lat']);
				update_field('lng',$jsondata['results'][0]['geometry']['location']['lng']);
			}
		endif;
   
    
}

add_action('acf/save_post', 'update_map_data_post', 20);