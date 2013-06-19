<?php
/*
 * Plugin Name: Social Media Followers Counter
 * Version: 1.0
 * Plugin URI: #
 * Description: Display Likes of Facebook page, Followers of Twitter, Circles of Google Plus and Subscribers of Youtube.
 * Author: Manesh Timilsina
 * Author URI: http://manesh.com.np/
 * License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
class FollowerCounterWidget extends WP_Widget
{
	/**
	* Declares the FollowerCounterWidget class.
	*
	*/
	function FollowerCounterWidget(){
		add_action('wp_enqueue_scripts', array(&$this, 'scEnqueueStyles'));
		$widget_ops = array('classname' => 'widget_FollowerCounter', 'description' => __( "Display Followers of Facebook, Twitter and Google Plus") );
		
		$this->WP_Widget('FollowerCounter', __('Social Media Followers Widget'), $widget_ops, $control_ops);
	}
	
	/**
	* Displays the Widget
	*
	*/
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$facebook = $instance['facebook_page_url'];		
		$gplus = $instance['gplus_id'];
		$yt = $instance['yt_id'];
		
		$facebook_text = $instance['facebook_text'];
		$twitter_text = $instance['twitter_text'];
		$gplus_text = $instance['gplus_text'];
		$yt_text = $instance['yt_text'];
		
		/*for twitter*/
		$twitter_id = $instance['twitter_id'];
		$consumer_key = $instance['consumer_key'];
		$consumer_secret = $instance['consumer_secret'];
		$access_token = $instance['access_token'];
		$access_token_secret = $instance['access_token_secret'];
		
		
		?>
	
        
         <div class="side-socials">
         				<h2><?php echo $title; ?></h2>
                        <ul>   
                            <?php if(function_exists(curl_init) && !empty($facebook)){ ?>               
                            <li>
                            	<a class="side-fb" href="<?php echo $facebook; ?>" target="_blank"><?php echo facebook_like_count($facebook);?></a>							<p><?php echo $facebook_text; ?></p>
                           </li>
                            <?php } ?>
                            <?php if(!empty($twitter_id)){ ?>
                            <li>
                            
                            <a class="side-twit" href="https://twitter.com/<?php echo $twitter_id; ?>" target="_blank"><?php echo tweet_count($twitter_id, $consumer_key, $consumer_secret, $access_token, $access_token_secret);?></a>
                            <p><?php echo $twitter_text; ?></p>
                            </li>
                             <?php } ?>
                            <?php if(function_exists(file_get_contents) && !empty($gplus)){?> 
                            <li>
                            <a class="side-plus" href="https://plus.google.com/<?php echo $gplus; ?>/posts" target="_blank"><?php echo google_plus_count($gplus);?></a>
                            <p><?php echo $gplus_text; ?></p>
                            </li>
                            <?php } ?>
                                <?php if(function_exists(file_get_contents) && !empty($yt)){?> 
                            <li>
                            <a class="side-yt" href="http://www.youtube.com/user/<?php echo $yt; ?>" target="_blank"><?php echo get_yt_subs($yt);?></a>
                            <p><?php echo $yt_text; ?></p>
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
		
		
		$title = htmlspecialchars($instance['title']);	
		$facebook = htmlspecialchars($instance['facebook_page_url']);
		$twitter = htmlspecialchars($instance['twitter_id']);
		$gplus = htmlspecialchars($instance['gplus_id']);
		$yt = htmlspecialchars($instance['yt_id']);
		
		$facebook_text = htmlspecialchars($instance['facebook_text']);
		$twitter_text = htmlspecialchars($instance['twitter_text']);
		$gplus_text = htmlspecialchars($instance['gplus_text']);
		$yt_text = htmlspecialchars($instance['yt_text']);
		
		# Output the options
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 220px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';		
		
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('facebook_page_url') . '">' . __('Facebook Page Url:') . ' <input style="width: 220px;" id="' . $this->get_field_id('facebook_page_url') . '" name="' . $this->get_field_name('facebook_page_url') . '" type="text" value="' . $facebook . '" /></label>
	<span style="font-size:10px; font-style: italic;">'.__('Example: http://www.facebook.com/micropeak ').'</span>
	</p>';
	
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('facebook_text') . '">' . __('Facebook Counter Text:') . ' <input style="width: 220px;" id="' . $this->get_field_id('facebook_text') . '" name="' . $this->get_field_name('facebook_text') . '" type="text" value="' . $facebook_text . '" /></label>
	<span style="font-size:10px; font-style: italic;">'.__('Example: fans, recommendations, followers, etc ').'</span>
	</p>';
	
	echo '<hr></hr>';
	?>
    <p>
	<label for="<?php echo $this->get_field_id('twitter_id'); ?>">Twitter Username:</label>
	<input class="widefat" style="width: 220px;" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php echo $instance['twitter_id']; ?>" />	
	<span style="font-size:10px; font-style: italic;"><?php echo __('Example: micropeak '); ?></span>
	</p>
	
    <p>
			<label for="<?php echo $this->get_field_id('consumer_key'); ?>">Consumer Key:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_key'); ?>" value="<?php echo $instance['consumer_key']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('consumer_secret'); ?>">Consumer Secret:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('consumer_secret'); ?>" name="<?php echo $this->get_field_name('consumer_secret'); ?>" value="<?php echo $instance['consumer_secret']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>">Access Token:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" value="<?php echo $instance['access_token']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('access_token_secret'); ?>">Access Token Secret:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('access_token_secret'); ?>" name="<?php echo $this->get_field_name('access_token_secret'); ?>" value="<?php echo $instance['access_token_secret']; ?>" />
		</p>
		
		
    <?php
	
	echo '<p style="text-align:left;"><label for="' . $this->get_field_name('twitter_text') . '">' . __('Twitter Counter Text:') . ' <input style="width: 220px;" id="' . $this->get_field_id('twitter_text') . '" name="' . $this->get_field_name('twitter_text') . '" type="text" value="' . $twitter_text . '" /></label>
	<span style="font-size:10px; font-style: italic;">'.__('Example: fans, recommendations, followers, etc ').'</span>
	</p>';
	
	echo '<hr></hr>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('gplus_id') . '">' . __('Google+ ID:') . ' <input style="width: 220px;" id="' . $this->get_field_id('gplus_id') . '" name="' . $this->get_field_name('gplus_id') . '" type="text" value="' . $gplus . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: 113470637409102089159').'</span>
		</p>';
		
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('gplus_text') . '">' . __('Google+ Counter Text:') . ' <input style="width: 220px;" id="' . $this->get_field_id('gplus_text') . '" name="' . $this->get_field_name('gplus_text') . '" type="text" value="' . $gplus_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: fans, circles, followers, etc ').'</span>
		</p>';
		
		echo '<hr></hr>';
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('yt_id') . '">' . __('Youtube Username:') . ' <input style="width: 220px;" id="' . $this->get_field_id('yt_id') . '" name="' . $this->get_field_name('yt_id') . '" type="text" value="' . $yt . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: maneshtimilsina').'</span>
		</p>';
		
		echo '<p style="text-align:left;"><label for="' . $this->get_field_name('yt_text') . '">' . __('Youtube Counter Text:') . ' <input style="width: 220px;" id="' . $this->get_field_id('yt_text') . '" name="' . $this->get_field_name('yt_text') . '" type="text" value="' . $yt_text . '" /></label>
		<span style="font-size:10px; font-style: italic;">'.__('Example: fans, Subscriptions, Subscribers, etc ').'</span>
		</p>';
		
	
	} //end of form

	/**
	* Saves the widgets settings.
	*
	*/
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		
		$instance['facebook_page_url'] = strip_tags(stripslashes($new_instance['facebook_page_url']));
		$instance['twitter_id'] = strip_tags(stripslashes($new_instance['twitter_id']));
		$instance['gplus_id'] = strip_tags(stripslashes($new_instance['gplus_id']));
		$instance['yt_id'] = strip_tags(stripslashes($new_instance['yt_id']));
		
		$instance['facebook_text'] = strip_tags(stripslashes($new_instance['facebook_text']));
		$instance['twitter_text'] = strip_tags(stripslashes($new_instance['twitter_text']));
		$instance['gplus_text'] = strip_tags(stripslashes($new_instance['gplus_text']));	
		$instance['yt_text'] = strip_tags(stripslashes($new_instance['yt_text']));	
		
		$instance['consumer_key'] = $new_instance['consumer_key'];
		$instance['consumer_secret'] = $new_instance['consumer_secret'];
		$instance['access_token'] = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
		$instance['twitter_id'] = $new_instance['twitter_id'];
		
		return $instance;
	}
	
	

public function scEnqueueStyles()
		{
			wp_register_style('SC_styles', plugins_url('/css/style.css', __FILE__), array(), $this->version, 'all');
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
		
		$link = "https://plus.google.com/u/0/".$id."/posts?hl=en";
		$data = file_get_contents("$link");
		
		preg_match('/<span role="button" class="a-n S1xjN" tabindex="0">(.*?)<\/span>/s', $data, $followers);
 
		if (isset($followers) && !empty($followers))
		{
			$count = $followers[1];
			$circles1 = preg_replace('/[^0-9_]/', '', $count);
		}
		if (empty($circles))
		{
			$circles = 0;
		}
 
		// 'in x circles' element
		preg_match('/<span role="button" class="a-n Cl7aRc" tabindex="0">(.*?)<\/span>/s', $data, $following);
 
		if (isset($following) && !empty($following))
		{
			$count = $following[1];
			$circles2 = preg_replace('/[^0-9_]/', '', $count);
		}
		if (empty($circles))
		{
			$circles = 0;
		}
 
 
 
		$return = array('followers' => @$circles1, 
				'following' => @$circles2
				);
		return $circles1;
	}
	
function get_yt_subs($uname) { 
	
	$link = "http://gdata.youtube.com/feeds/api/users/".$uname;
		$xmlData = file_get_contents("$link");
 
$xmlData = str_replace('yt:', 'yt', $xmlData); 

$xml = new SimpleXMLElement($xmlData); 

$subs = $xml->ytstatistics['subscriberCount']; 

return($subs);
 }
?>