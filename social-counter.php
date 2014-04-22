<?php
/*
 * Plugin Name: WEN's Social Media Followers Counter
 * Version: 2.0.0
 * Plugin URI: http://wordpress.org/plugins/social-media-followers-counter
 * Description: A social media follower counter and custom text display plugin : this plugin currently fetch likes of Facebook page, followers of Twitter, circles of Google Plus and subscribers of Youtube . Comes packed with icon sprites and offers a neat display of the statistics . It is easy to setup and convenient to use.
 * Author: Web Experts Nepal, Manesh Timilsina
 * Author URI: http://webexpertsnepal.com
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
class FollowerCounterWidget extends WP_Widget
{
	/**
	* Declares the FollowerCounterWidget class.
	*
	*/
	function FollowerCounterWidget(){
		global $control_ops;
		add_action('wp_enqueue_scripts', array(&$this, 'scEnqueueStyles'));
		$widget_ops = array(
						'version' =>'2.0.0', 
						'classname' => 'widget_FollowerCounter', 
						'description' => __( "Display Followers of Facebook, Twitter and Google Plus") 
						);
		
		$this->WP_Widget('FollowerCounter', __('Social Media Followers Widget'), $widget_ops, $control_ops);
	}
	
	/**
	* Displays the Widget
	*
	*/
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$facebook 	= $instance['facebook_page_url'];		
		$gplus 		= $instance['gplus_id'];
		$yt 		= $instance['yt_id'];
		$dribbble 	= $instance['dribbble_url'];
		
		$facebook_text 	= $instance['facebook_text'];
		$twitter_text 	= $instance['twitter_text'];
		$gplus_text 	= $instance['gplus_text'];
		$yt_text 		= $instance['yt_text'];
		$dribbble_text 	= $instance['dribbble_text'];
		
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
						<a class="side-fb" href="<?php echo $facebook; ?>" target="_blank"><?php echo facebook_like_count($facebook);?></a>							
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
				<?php if(function_exists('file_get_contents') && !empty($yt)){?> 
					<li>
						<a class="side-yt" href="http://www.youtube.com/user/<?php echo $yt; ?>" target="_blank"><?php echo get_yt_subs($yt);?></a>
						<p><?php echo $yt_text; ?></p>
					</li>
				<?php } ?>
				<?php if(!empty($dribbble)){?> 
					<li>
						<a class="side-dribbble" href="<?php echo $dribbble; ?>" target="_blank"><?php echo get_dribbble_subs($dribbble);?></a>
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
		
		$instance = wp_parse_args( (array) $instance, array('title'=>'', 'facebook_page_url'=>'', 'twitter_id'=>'', 'gplus_id'=>'') );
		
		
		$title 			= htmlspecialchars($instance['title']);	
		$facebook 		= htmlspecialchars($instance['facebook_page_url']);
		$twitter 		= htmlspecialchars($instance['twitter_id']);
		$gplus 			= htmlspecialchars($instance['gplus_id']);
		$yt 			= htmlspecialchars($instance['yt_id']);
		$dribbble		= htmlspecialchars($instance['dribbble_url']);
		
		
		$facebook_text 	= htmlspecialchars($instance['facebook_text']);
		$twitter_text 	= htmlspecialchars($instance['twitter_text']);
		$gplus_text 	= htmlspecialchars($instance['gplus_text']);
		$yt_text 		= htmlspecialchars($instance['yt_text']);
		$dribbble_text 	= htmlspecialchars($instance['dribbble_text']);
		
		# Output the options
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 100%;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';		
		
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('facebook_page_url') . '">' . __('Facebook Page Url:') . ' <input style="width: 100%;" id="' . $this->get_field_id('facebook_page_url') . '" name="' . $this->get_field_name('facebook_page_url') . '" type="text" value="' . $facebook . '" /></label>
	<span style="font-size:10px; font-style: italic;">'.__('Example: http://www.facebook.com/webexpertsnepal ').'</span>
	</p>';
	
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('facebook_text') . '">' . __('Facebook Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('facebook_text') . '" name="' . $this->get_field_name('facebook_text') . '" type="text" value="' . $facebook_text . '" /></label>
	<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , etc ').'</span>
	</p>';
	
	echo '<hr></hr>';
	
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('twitter_id') . '">' . __('Twitter Username:') . ' <input style="width: 100%;" id="' . $this->get_field_id('twitter_id') . '" name="' . $this->get_field_name('twitter_id') . '" type="text" value="' . $instance['twitter_id'] . '" /></label>
	<span style="font-size:10px; font-style: italic;">'.__('Example: webexpertsnepal ').'</span>
	</p>';
	
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('consumer_key') . '">' . __('Consumer Key:') . ' <input style="width: 100%;" id="' . $this->get_field_id('consumer_key') . '" name="' . $this->get_field_name('consumer_key') . '" type="text" value="' . $instance['consumer_key'] . '" /></label>
	</p>';
	
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('consumer_secret') . '">' . __('Consumer Secret:') . ' <input style="width: 100%;" id="' . $this->get_field_id('consumer_secret') . '" name="' . $this->get_field_name('consumer_secret') . '" type="text" value="' . $instance['consumer_secret'] . '" /></label>
	</p>';
	
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('access_token') . '">' . __('Access Token:') . ' <input style="width: 100%;" id="' . $this->get_field_id('access_token') . '" name="' . $this->get_field_name('access_token') . '" type="text" value="' . $instance['access_token'] . '" /></label>
	</p>';
	
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('access_token_secret') . '">' . __('Access Token Secret:') . ' <input style="width: 100%;" id="' . $this->get_field_id('access_token_secret') . '" name="' . $this->get_field_name('access_token_secret') . '" type="text" value="' . $instance['access_token_secret'] . '" /></label>
	</p>';
	
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('twitter_text') . '">' . __('Twitter Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('twitter_text') . '" name="' . $this->get_field_name('twitter_text') . '" type="text" value="' . $twitter_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , etc').'</span>
		</p>';
	
		echo '<hr></hr>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('gplus_id') . '">' . __('Google+ ID:') . ' <input style="width: 100%;" id="' . $this->get_field_id('gplus_id') . '" name="' . $this->get_field_name('gplus_id') . '" type="text" value="' . $gplus . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: 1119803292890650').'</span>
		</p>';
		
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('gplus_text') . '">' . __('Google+ Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('gplus_text') . '" name="' . $this->get_field_name('gplus_text') . '" type="text" value="' . $gplus_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , etc').'</span>
		</p>';
		
		echo '<hr></hr>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('yt_id') . '">' . __('Youtube Username:') . ' <input style="width: 100%;" id="' . $this->get_field_id('yt_id') . '" name="' . $this->get_field_name('yt_id') . '" type="text" value="' . $yt . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: bZYue9JEA0aa0ekaNvA').'</span>
		</p>';
		
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('yt_text') . '">' . __('Youtube Counter Text:') . ' <input style="width: 100%;" id="' . $this->get_field_id('yt_text') . '" name="' . $this->get_field_name('yt_text') . '" type="text" value="' . $yt_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: Fans , Followers , Subscribers , etc').'</span>
		</p>';
		
		echo '<hr></hr>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('dribbble_url') . '">' . __('Dribbble Url:') . ' <input style="width: 100%;" id="' . $this->get_field_id('dribbble_url') . '" name="' . $this->get_field_name('dribbble_url') . '" type="text" value="' . $dribbble . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: https://dribbble.com/maneshtimilsina').'</span>
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
		$instance 						= $old_instance;
		$instance['title'] 				= strip_tags(stripslashes($new_instance['title']));
		
		$instance['facebook_page_url'] 	= strip_tags(stripslashes($new_instance['facebook_page_url']));
		$instance['twitter_id'] 		= strip_tags(stripslashes($new_instance['twitter_id']));
		$instance['gplus_id'] 			= strip_tags(stripslashes($new_instance['gplus_id']));
		$instance['yt_id'] 				= strip_tags(stripslashes($new_instance['yt_id']));
		$instance['dribbble_url'] 		= strip_tags(stripslashes($new_instance['dribbble_url']));
		
		$instance['facebook_text'] 		= strip_tags(stripslashes($new_instance['facebook_text']));
		$instance['twitter_text'] 		= strip_tags(stripslashes($new_instance['twitter_text']));
		$instance['gplus_text'] 		= strip_tags(stripslashes($new_instance['gplus_text']));	
		$instance['yt_text'] 			= strip_tags(stripslashes($new_instance['yt_text']));

		$instance['dribbble_text'] 		= strip_tags(stripslashes($new_instance['dribbble_text']));	
		
		$instance['consumer_key'] 		= $new_instance['consumer_key'];
		$instance['consumer_secret'] 	= $new_instance['consumer_secret'];
		$instance['access_token'] 		= $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
		$instance['twitter_id'] 		= $new_instance['twitter_id'];
		
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
	
	function facebook_like_count($page_link){
		$url = str_replace('https://www.facebook.com/', '', $page_link);
	
		$curl_url = 'https://graph.facebook.com/' . $url;
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
		if(array_key_exists( 'error', $results)){
		$flc_message = 'Error - '.$results['error']['message'];
		return $flc_message;
	}
	else{
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
	$twitter_id = $twitter_id;		
	$consumer_key = $consumer_key;
	$consumer_secret = $consumer_secret;
	$access_token = $access_token;
	$access_token_secret = $access_token_secret;


	if($twitter_id && $consumer_key && $consumer_secret && $access_token && $access_token_secret) { 

		$transName = 'list_tweets_'.$args['widget_id'];
		$cacheTime = 10;
		delete_transient($transName);
		if(false === ($twitterData = get_transient($transName))) {
		     // require the twitter auth class
		     @require_once 'twitteroauth/twitteroauth.php';
		     $twitterConnection = new TwitterOAuth(
							$consumer_key,	// Consumer Key
							$consumer_secret,   	// Consumer secret
							$access_token,       // Access token
							$access_token_secret    	// Access token secret
							);
		    $twitterData = $twitterConnection->get(
							  'statuses/user_timeline',
							  array(
							    'screen_name'     => $twitter_id,
							    'count'           => $count,
							    'exclude_replies' => false
							  )
							);
		     if($twitterConnection->http_code != 200)
		     {
		          $twitterData = get_transient($transName);
		     }

		     // Save our new transient.
		     set_transient($transName, $twitterData, 60 * $cacheTime);
		};
		$twitter = get_transient($transName);
		
		if($twitter && is_array($twitter)) {
			$count = $twitter[0]->user->followers_count;
			return $count;
		 }}
	}



	function google_plus_count($id)

		{

			$link = "https://plus.google.com/".$id;

			$gplus = array(
	                'method'    => 'POST',
	                'sslverify' => false,
	                'timeout'   => 30,
	                'headers'   => array( 'Content-Type' => 'application/json' ),
	                'body'      => '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $link . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]'
	            );

	           
	        $remote_data = wp_remote_get( 'https://clients6.google.com/rpc', $gplus );            

	        $json_data = json_decode( $remote_data['body'], true );

	        foreach($json_data[0]['result']['metadata']['globalCounts'] as $gcount){
	                	
	        $gresult .= $gcount;

	        }

	        if( 0 != $gcount){

	        	return $gcount; 

	        } else {

	        $link = "https://plus.google.com/".$id."/posts";		

			$page = file_get_contents($link);

			if (preg_match('/>([0-9,]+) people</i', $page, $matches)) {
			
			return str_replace(',', '', $matches[1]);

			}

	        }

		}
	
	function get_yt_subs($uname) { 
		
		$link = "http://gdata.youtube.com/feeds/api/users/".$uname;
		
		$xmlData = file_get_contents("$link");
		 
		$xmlData = str_replace('yt:', 'yt', $xmlData); 
		
		$xml = new SimpleXMLElement($xmlData); 
		
		$subs = $xml->ytstatistics['subscriberCount']; 
		
		return($subs);
	 }

	 function get_dribbble_subs($page_link){

	 	$dribbble = @parse_url($page_link);

		if( $dribbble['host'] == 'www.dribbble.com' || $dribbble['host']  == 'dribbble.com' ){	

			$page_name = substr(@parse_url($page_link, PHP_URL_PATH), 1);

			@$data = @json_decode( wp_remote_retrieve_body(wp_remote_get('http://api.dribbble.com/' . $page_name)) );

			$dribbble_count = $data->followers_count;

		} else {
			$dribbble_count = _e('Please enter correct Dribbble page url!', 'SC');
		}

		return $dribbble_count;
	}
	 
?>