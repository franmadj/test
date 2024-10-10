 <?php 
		global $wpdb;
		$statesArray = array(
	    'Alabama',
	    'Alaska',
	    'American Samoa',
	    'Arizona',
	    'Arkansas',
	    'California',
	    'Colorado',
	    'Connecticut',
	    'Delaware',
	    'District Of Columbia',
	    'Federated States Of Micronesia',
	    'Florida',
	    'Georgia',
	    'Guam',
	    'Hawaii',
	    'Idaho',
	    'Illinois',
	    'Indiana',
	    'Iowa',
	    'Kansas',
	    'Kentucky',
	    'Louisiana',
	    'Maine',
	    'Marshall Islands',
	    'Maryland',
	    'Massachusetts',
	    'Michigan',
	    'Minnesota',
	    'Mississippi',
	    'Missouri',
	    'Montana',
	    'Nebraska',
	    'Nevada',
	    'New Hampshire',
	    'New Jersey',
	    'New Mexico',
	    'New York',
	    'North Carolina',
	    'North Dakota',
	    'Northern Mariana Islands',
	    'Ohio',
	    'Oklahoma',
	    'Oregon',
	    'Palau',
	    'Pennsylvania',
	    'Puerto Rico',
	    'Rhode Island',
	    'South Carolina',
	    'South Dakota',
	    'Tennessee',
	    'Texas',
	    'Utah',
	    'Vermont',
	    'Virgin Islands',
	    'Virginia',
	    'Washington',
	    'West Virginia',
	    'Wisconsin',
	    'Wyoming',
	    'United States'
	);
		$map_location = get_field('location');
		$search_lat   	= $map_location['lat'];
		$state =ucwords($_POST['address']);
		
		if($state =='usa' || $state =='USA' || $state =='Usa'){
			$state =  'United States';
		}
		
		if(in_array($state,$statesArray)){
			$search_radius = 400;
		}else{
			$search_radius = $_POST['distance'];
		}
		
    $search_long =$map_location['lng'];
		$sql = $wpdb->prepare( "SELECT $wpdb->posts.ID,

					( 3959 * acos(

						cos( radians(%s) ) *

						cos( radians( latitude.meta_value ) ) *

						cos( radians( longitude.meta_value ) - radians(%s) ) +

						sin( radians(%s) ) *

						sin( radians( latitude.meta_value ) )

					) )

					AS distance, latitude.meta_value AS latitude, longitude.meta_value AS longitude

					FROM $wpdb->posts

					INNER JOIN $wpdb->postmeta

						AS latitude

						ON $wpdb->posts.ID = latitude.post_id

					INNER JOIN $wpdb->postmeta

						AS longitude

						ON $wpdb->posts.ID = longitude.post_id

					WHERE 1=1

						AND ($wpdb->posts.post_status = 'publish' )

						AND ($wpdb->posts.post_type = 'locations' )

						AND latitude.meta_key='lat'

						AND longitude.meta_key='lng'

					HAVING distance < %s

					ORDER BY $wpdb->posts.menu_order ASC, distance ASC",

	            $search_lat,

	            $search_long,

	            $search_lat,

	            $search_radius

	        );

		$post_ids = $wpdb->get_results( $sql, OBJECT_K );

		if( $post_ids ){
			$j=1;
			foreach( $post_ids as $key => $value ) {
				$map_location = get_field('location',$key);
				$slide_images = get_field('photo',$key);
				$phone = get_field('phone_numbers',$key);

				if(get_field('entry_type',$key)){
					$entry_type = get_field('entry_type',$key);
				}else{
					$entry_type = "domestic";
				}
				if($map_location):?>
				<a href="<?php echo get_the_permalink($key);?>" class="c-locations__item <?php if($j >4) echo 'c-locations__item--hidden';?>" data-ref="location" data-index="<?= $j;?>" data-type="<?php echo $entry_type;?>">
					<meta name="location[]" value='{"lat":"<?php echo $map_location['lat'];?>","lng":"<?php echo $map_location['lng'];?>","title":"<?php echo get_the_title($key);?>","address":"<?php echo $map_location['address'];?>","phone":"<?php if($phone){echo $phone[0]['number'];} ?>","distance":"<?php echo (int)$value->distance;?> mi. away","link":"<?php echo get_the_permalink($key);?>"}'>
					<?php 
					if($slide_images):?>
						<img src="<?php echo $slide_images[0]['sizes']['homeslider_button'];?>" class="c-locations__image" alt="<?php the_title();?>" width="132px" height="69px;">
					<?php else:?>
						<img src="https://s3.amazonaws.com/texas-de-brazil-website/locations/International/Riyadh/_260x138_crop_center-center_50/KSA-Outside.jpg" class="c-locations__image" alt="<?php echo get_the_title($key);?>" >
					<?php endif;?>
					<span class="c-locations__title"><?php echo get_the_title($key);?></span>
					<span class="c-locations__state"><?php the_field('location_state',$key);?></span>
				</a>
<?php endif;
			$j++;
			}

		}
		
		?>
	