<?php
/*
 * Plugin Name: Social Media Followers Counter
 * Version: 4.0.1
 * Plugin URI: http://wordpress.org/plugins/social-media-followers-counter
 * Description: A social media follower counter and custom text display plugin : This plugin currently fetch likes of Facebook page, followers of Twitter, circles of Google Plus, subscribers of Youtube and followers of Dribbble. Comes packed with icon sprites and offers a neat display of the statistics . It is easy to setup and convenient to use.
 * Author: Manesh Timilsina
 * Author URI: http://manesh.com.np
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
class FollowerCounterWidget extends WP_Widget
{
	/**
	* Declares the FollowerCounterWidget class.
	*
	*/

	public function __construct() {

		global $control_ops;

		add_action('wp_enqueue_scripts', array(&$this, 'scEnqueueStyles'));

		$widget_ops = array(
						'version' =>'4.0.1', 
						'classname' => 'widget_FollowerCounter', 
						'description' => __( "Display Followers of Facebook, Twitter and Google Plus") 
						);
		parent::__construct('FollowerCounter', __('Social Media Followers Widget'), $widget_ops, $control_ops);
		$this->alt_option_name = 'widget_follower_counter';		
	}
	
	/**
	* Displays the Widget
	*
	*/
	function widget($args, $instance){
		extract($args);
		$title 					= apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);

		$facebook 				= $instance['facebook_page_url'];
		$facebook_access_token 	= $instance['facebook_access_token'];
		$gplus 					= $instance['gplus_id'];
		$yt 					= $instance['yt_id'];
		$yt_ch 					= $instance['yt_ch'];
		$yt_key					= $instance['yt_key'];
		$dribbble 				= $instance['dribbble_url'];
		$dribbble_access_token	= $instance['dribbble_access_token'];

		
		$facebook_text 			= $instance['facebook_text'];
		$twitter_text 			= $instance['twitter_text'];
		$gplus_text 			= $instance['gplus_text'];
		$yt_text 				= $instance['yt_text'];
		$dribbble_text 			= $instance['dribbble_text'];
		
		/*for twitter*/
		$twitter_id 			= $instance['twitter_id'];
		$consumer_key 			= $instance['consumer_key'];
		$consumer_secret 		= $instance['consumer_secret'];
		$access_token 			= $instance['access_token'];
		$access_token_secret 	= $instance['access_token_secret'];
		
		?>        
		<div class="side-socials">
			<h2><?php echo $title; ?></h2>
			<ul>   
				<?php if(function_exists('curl_init') && !empty($facebook)){ ?>               
					<li>

						<a class="side-fb" href="<?php echo $facebook; ?>" target="_blank"><?php echo facebook_like_count($facebook, $facebook_access_token);?></a>							

						<p><?php echo $facebook_text; ?></p>
					</li>
				<?php } ?>
				<?php if(!empty($twitter_id)){ ?>
					<li>
						<a class="side-twit" href="https://twitter.com/<?php echo $twitter_id; ?>" target="_blank"><?php echo tweet_count($twitter_id, $consumer_key, $consumer_secret, $access_token, $access_token_secret);?></a>
						<p><?php echo $twitter_text; ?></p>
					</li>
				<?php } ?>
				<?php if(function_exists('file_get_contents') && !empty($gplus)){?> 
					<li>
						<a class="side-plus" href="https://plus.google.com/<?php echo $gplus; ?>/posts" target="_blank"><?php echo google_plus_count($gplus);?></a>
						<p><?php echo $gplus_text; ?></p>
					</li>
				<?php } ?>
				<?php if( !empty( $yt ) ){?> 
					<li>
						<a class="side-yt" href="http://www.youtube.com/user/<?php echo $yt; ?>" target="_blank"><?php echo get_yt_subs( $yt, $yt_ch, $yt_key );?></a>
						<p><?php echo $yt_text; ?></p>
					</li>
				<?php } ?>
				<?php if(!empty($dribbble)){?> 
					<li>
						<a class="side-dribbble" href="<?php echo $dribbble; ?>" target="_blank"><?php echo get_dribbble_subs($dribbble, $dribbble_access_token);?></a>
						<p><?php echo $dribbble_text; ?></p>
					</li>
				<?php } ?>

			</ul>
		</div>
	<?php
	}	
	
	/**
	* Creates the edit form for the widget.
	*
	*/
	function form($instance){

		$form_args = array(
						'title'						=>	'', 

						'facebook_page_url'			=>	'', 
						'facebook_access_token'		=>	'',
						'facebook_text'				=>	'',

						'twitter_id'				=>	'', 
						'consumer_key'				=>	'',
						'consumer_secret'			=>	'',
						'access_token'				=>	'',
						'access_token_secret'		=>	'',
						'twitter_text'				=>	'',


						'gplus_id'					=>	'',
						'gplus_text'				=>	'',

						'yt_id'						=>	'',
						'yt_ch' 					=> 	'',
						'yt_key'					=> 	'',
						'yt_text'					=>	'',

						'dribbble_url'				=>	'',		
						'dribbble_access_token'		=>	'',				
						'dribbble_text'				=>	'',

					);
		
		$instance 				= wp_parse_args( (array) $instance, $form_args );
		
		
		$title 					= htmlspecialchars($instance['title']);	

		$facebook 				= htmlspecialchars($instance['facebook_page_url']);
		$facebook_access_token 	= htmlspecialchars($instance['facebook_access_token']);
		$facebook_text 			= htmlspecialchars($instance['facebook_text']);


		$twitter 				= htmlspecialchars($instance['twitter_id']);
		$consumer_key 			= htmlspecialchars($instance['consumer_key']);
		$consumer_secret 		= htmlspecialchars($instance['consumer_secret']);
		$access_token 			= htmlspecialchars($instance['access_token']);
		$access_token_secret 	= htmlspecialchars($instance['access_token_secret']);
		$twitter_text 			= htmlspecialchars($instance['twitter_text']);

		$gplus 					= htmlspecialchars($instance['gplus_id']);
		$gplus_text 			= htmlspecialchars($instance['gplus_text']);

		$yt 					= htmlspecialchars($instance['yt_id']);	
		$yt_ch 					= htmlspecialchars($instance['yt_ch']);
		$yt_key					= htmlspecialchars($instance['yt_key']);	
		$yt_text 				= htmlspecialchars($instance['yt_text']);

		$dribbble				= htmlspecialchars($instance['dribbble_url']);
		$dribbble_access_token	= htmlspecialchars($instance['dribbble_access_token']);
		$dribbble_text 			= htmlspecialchars($instance['dribbble_text']);
		
		# Output the options
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 100%;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';		
		
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('facebook_page_url') . '">' . __('Facebook Page Url:') . ' <input style="width: 100%;" id="' . $this->get_field_id('facebook_page_url') . '" name="' . $this->get_field_name('facebook_page_url') . '" type="text" value="' . $facebook . '" /></label>
			<span style="font-size:10px; font-style: italic;">'.__('Example: https://www.facebook.com/maneshtimilsina ').'</span>
			</p>';

		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('facebook_access_token') . '">' . __('Facebook Access Token:') . ' <input style="width: 100%;" id="' . $this->get_field_id('facebook_access_token') . '" name="' . $this->get_field_name('facebook_access_token') . '" type="text" value="' . $facebook_access_token. '" /></label>

			</p>';

	
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('facebook_text') . '">' . __('Facebook Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('facebook_text') . '" name="' . $this->get_field_name('facebook_text') . '" type="text" value="' . $facebook_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , etc ').'</span>
		</p>';
	
		echo '<hr></hr>';
	
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('twitter_id') . '">' . __('Twitter Username:') . ' <input style="width: 100%;" id="' . $this->get_field_id('twitter_id') . '" name="' . $this->get_field_name('twitter_id') . '" type="text" value="' . $twitter. '" /></label>
			<span style="font-size:10px; font-style: italic;">'.__('Example: maneshtimilsina ').'</span>
			</p>';
	
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('consumer_key') . '">' . __('Consumer Key:') . ' <input style="width: 100%;" id="' . $this->get_field_id('consumer_key') . '" name="' . $this->get_field_name('consumer_key') . '" type="text" value="' . $consumer_key . '" /></label>
			</p>';
	
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('consumer_secret') . '">' . __('Consumer Secret:') . ' <input style="width: 100%;" id="' . $this->get_field_id('consumer_secret') . '" name="' . $this->get_field_name('consumer_secret') . '" type="text" value="' . $consumer_secret. '" /></label>
			</p>';
	
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('access_token') . '">' . __('Access Token:') . ' <input style="width: 100%;" id="' . $this->get_field_id('access_token') . '" name="' . $this->get_field_name('access_token') . '" type="text" value="' . $access_token. '" /></label>
			</p>';
	
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('access_token_secret') . '">' . __('Access Token Secret:') . ' <input style="width: 100%;" id="' . $this->get_field_id('access_token_secret') . '" name="' . $this->get_field_name('access_token_secret') . '" type="text" value="' . $access_token_secret . '" /></label>
			</p>';
	
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('twitter_text') . '">' . __('Twitter Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('twitter_text') . '" name="' . $this->get_field_name('twitter_text') . '" type="text" value="' . $twitter_text . '" /></label>
			<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , etc').'</span>
			</p>';
	
		echo '<hr></hr>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('gplus_id') . '">' . __('Google+ ID:') . ' <input style="width: 100%;" id="' . $this->get_field_id('gplus_id') . '" name="' . $this->get_field_name('gplus_id') . '" type="text" value="' . $gplus . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: If your page url is: https://plus.google.com/+ManeshTimilsina/posts <br/> Use +ManeshTimilsina').'</span>
		</p>';
		
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('gplus_text') . '">' . __('Google+ Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('gplus_text') . '" name="' . $this->get_field_name('gplus_text') . '" type="text" value="' . $gplus_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , etc').'</span>
		</p>';
		
		echo '<hr></hr>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('yt_id') . '">' . __('Youtube User URL:') . ' <input style="width: 100%;" id="' . $this->get_field_id('yt_id') . '" name="' . $this->get_field_name('yt_id') . '" type="text" value="' . $yt . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: https://www.youtube.com/user/maneshtimilsina').'</span>
		</p>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('yt_ch') . '">' . __('Youtube Chanel ID:') . ' <input style="width: 100%;" id="' . $this->get_field_id('yt_ch') . '" name="' . $this->get_field_name('yt_ch') . '" type="text" value="' . $yt_ch . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: UCngCAkQslIBDm1MvwHVwKsw').'</span>
		</p>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('yt_key') . '">' . __('API Key:') . ' <input style="width: 100%;" id="' . $this->get_field_id('yt_key') . '" name="' . $this->get_field_name('yt_key') . '" type="text" value="' . $yt_key . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Get your API key creating a project/app in <a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a>, then inside your project go to "APIs &amp; auth &gt; APIs" and turn on the "YouTube API", finally go to "APIs &amp; auth &gt; APIs &gt; Credentials &gt; Public API access" and click in the "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, now just copy your API key and paste here.').'</span>
		</p>';
		
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('yt_text') . '">' . __('Youtube Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('yt_text') . '" name="' . $this->get_field_name('yt_text') . '" type="text" value="' . $yt_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , etc').'</span>
		</p>';
		
		echo '<hr></hr>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('dribbble_url') . '">' . __('Dribbble Url:') . ' <input style="width: 100%;" id="' . $this->get_field_id('dribbble_url') . '" name="' . $this->get_field_name('dribbble_url') . '" type="text" value="' . $dribbble . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: https://dribbble.com/maneshtimilsina').'</span>
		</p>';

		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('dribbble_access_token') . '">' . __('Dribbble Access Token:') . ' <input style="width: 100%;" id="' . $this->get_field_id('dribbble_access_token') . '" name="' . $this->get_field_name('dribbble_access_token') . '" type="text" value="' . $dribbble_access_token. '" /></label>

			</p>';
		
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('dribbble_text') . '">' . __('Dribbble Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('dribbble_text') . '" name="' . $this->get_field_name('dribbble_text') . '" type="text" value="' . $dribbble_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , Listed, etc').'</span>
		</p>';
	
	} //end of form

	/**
	* Saves the widgets settings.
	*
	*/
	function update($new_instance, $old_instance){
		$instance 							= $old_instance;
		$instance['title'] 					= strip_tags(stripslashes($new_instance['title']));
		
		$instance['facebook_page_url'] 		= strip_tags(stripslashes($new_instance['facebook_page_url']));

		$instance['facebook_access_token'] 	= strip_tags(stripslashes($new_instance['facebook_access_token']));

		$instance['twitter_id'] 			= strip_tags(stripslashes($new_instance['twitter_id']));
		$instance['gplus_id'] 				= strip_tags(stripslashes($new_instance['gplus_id']));

		$instance['yt_id'] 					= strip_tags(stripslashes($new_instance['yt_id']));
		$instance['yt_ch'] 					= strip_tags(stripslashes($new_instance['yt_ch']));
		$instance['yt_key'] 				= strip_tags(stripslashes($new_instance['yt_key']));
		$instance['yt_text'] 				= strip_tags(stripslashes($new_instance['yt_text']));

		$instance['dribbble_url'] 			= strip_tags(stripslashes($new_instance['dribbble_url']));
		$instance['dribbble_access_token'] 	= strip_tags(stripslashes($new_instance['dribbble_access_token']));
		
		$instance['facebook_text'] 			= strip_tags(stripslashes($new_instance['facebook_text']));
		$instance['twitter_text'] 			= strip_tags(stripslashes($new_instance['twitter_text']));
		$instance['gplus_text'] 			= strip_tags(stripslashes($new_instance['gplus_text']));	
		

		$instance['dribbble_text'] 			= strip_tags(stripslashes($new_instance['dribbble_text']));	
		
		$instance['consumer_key'] 			= $new_instance['consumer_key'];
		$instance['consumer_secret'] 		= $new_instance['consumer_secret'];
		$instance['access_token'] 			= $new_instance['access_token'];
		$instance['access_token_secret']	= $new_instance['access_token_secret'];
		$instance['twitter_id'] 			= $new_instance['twitter_id'];
		
		return $instance;
	}
	
	

	public function scEnqueueStyles() {
		
		wp_register_style('SC_styles', plugins_url('/css/style.css', __FILE__), array(), $this->widget_options['version'], 'all');
		wp_enqueue_style('SC_styles');
	}
	
	}// END class
	
	/**
	* Register  widget.
	*
	* Calls 'widgets_init' action after widget has been registered.
	*/
	function FollowerCounterInit() {
		register_widget('FollowerCounterWidget');
	}	
	add_action('widgets_init', 'FollowerCounterInit');
	

	function facebook_like_count($page_link, $facebook_access_token){		
		
		$f_id 		= $page_link;

		$f_access 	= $facebook_access_token;

		$url 		= str_replace('https://www.facebook.com/', '', $page_link);

		$curl_url 	= 'https://graph.facebook.com/v2.2/'.$url.'?access_token='.$f_access;

		

		try{

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $curl_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$result = curl_exec($ch);

			$results = json_decode($result, true);

			curl_close($ch);

			if( array_key_exists( 'error', $results) ){
				$flc_message = 'Error - '.$results['error']['message'];
				return $flc_message;
			} else{
				update_option('flc_fb_like_count', $results['likes']);
				$flc_message = 'Like count updated';
				return (int)$results['likes'];
			}
		}
		catch( Exception $e){

			$flc_message = $e->getMessage();

		} 

	}
	
	function tweet_count($twitter_id, $consumer_key, $consumer_secret, $access_token, $access_token_secret ){
		$twitter_id 			= 	$twitter_id;		
		$consumer_key 			= 	$consumer_key;
		$consumer_secret 		= 	$consumer_secret;
		$access_token 			= 	$access_token;
		$access_token_secret 	= 	$access_token_secret;


		if($twitter_id && $consumer_key && $consumer_secret && $access_token && $access_token_secret) { 

			// some variables
		    $consumerKey 		= 	$consumer_key;
		    $consumerSecret 	= 	$consumer_secret;
		    $token 				= 	get_option('cfTwitterToken');    
 
    		// cache version does not exist or expired
  
        	// getting new auth bearer only if we don't have one
        	if(!$token) {
	            // preparing credentials
	            $credentials 	= 	$consumerKey . ':' . $consumerSecret;
	            $toSend 		= 	base64_encode($credentials);
	 
	            // http post arguments
	            $args = array(
			                'method' 		=> 'POST',
			                'httpversion' 	=> '1.1',
			                'blocking' 		=> true,
			                'headers' 		=> array(
							                    'Authorization' => 'Basic ' . $toSend,
							                    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
								                ),
	                		'body' 			=> array( 'grant_type' => 'client_credentials' )
	            		);
	 
	            add_filter('https_ssl_verify', '__return_false');

	            $response 	= 	wp_remote_post('https://api.twitter.com/oauth2/token', $args);
	 
	            $keys 		= 	json_decode(wp_remote_retrieve_body($response));
	 
	            if( $keys ) {
	                // saving token to wp_options table
	                update_option('cfTwitterToken', $keys->access_token);
	                $token 	= 	$keys->access_token;
	            }
        	}
	        // we have bearer token wether we obtained it from API or from options
	        $args = array(
			            'httpversion' 	=> '1.1',
			            'blocking' 		=> true,
			            'headers' 		=> array(
								            'Authorization' => "Bearer $token"
								           )
	        		);
 
	        add_filter('https_ssl_verify', '__return_false');

	        $api_url 	= 	"https://api.twitter.com/1.1/users/show.json?screen_name=$twitter_id";

	        $response 	= 	wp_remote_get($api_url, $args);


 
	        if (!is_wp_error($response)) {

	            $followers 			= 	json_decode(wp_remote_retrieve_body($response));

	            $numberOfFollowers 	= 	$followers->followers_count;

	        } else {
	            // get old value and break
	            $numberOfFollowers 	= 	get_option('cfNumberOfFollowers');
	           
	            // uncomment below to debug
	            //die($response->get_error_message());
	        }
 
        	// cache for an hour

    		return $numberOfFollowers;
		}
	}



	function google_plus_count($id) {

		$link 	= 	"https://plus.google.com/".$id."/posts";

		$page 	= 	file_get_contents($link);

		if (preg_match_all('/>([0-9,]+) people</i', $page, $matches)) {			

			return str_replace(',', '', $matches[1][1]);

		}   

	}
	
	function get_yt_subs( $uname, $channel, $api_key ) { 

		$id 		= $channel;

		$key 		= $api_key;			

		$url 		= "https://www.googleapis.com/youtube/v3/channels?part=statistics&id=".$id."&key=".$key;

		$connection = wp_remote_get( $url, array( 'timeout' => 60 ) );
		
		if ( is_wp_error( $connection ) || 400 <= $connection['response']['code'] ) {

				$total = 0;

			} else {

				$_data = json_decode( $connection['body'], true );
				

				if ( isset( $_data['items'][0]['statistics']['subscriberCount'] ) ) {
					$count = intval( $_data['items'][0]['statistics']['subscriberCount'] );

					$total = $count;
				} else{

					$total = 0;

				}

			}

		
		
		return($total);
	 }

	 function get_dribbble_subs( $page_link, $dribbble_access_token ){

	 	$dribbble 			= @parse_url($page_link);

	 	$dribbble_at 		= $dribbble_access_token;

		if( $dribbble['host'] == 'www.dribbble.com' || $dribbble['host']  == 'dribbble.com' ){	

			$page_name 		= substr(@parse_url($page_link, PHP_URL_PATH), 1);
			
			@$data_all 		= "https://api.dribbble.com/v1/user?access_token=".$dribbble_at;

			@$data_count 	= file_get_contents($data_all);

			@$d_data 		= json_decode( $data_count, true );					

			$dribbble_count = $d_data['followers_count'];

		} else {
			$dribbble_count = _e('Please enter correct Dribbble page url and access token!', 'SC');
		}

		return $dribbble_count;
	}
	 
?>