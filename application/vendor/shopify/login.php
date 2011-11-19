<?php
  /*
    Shopify PHP API Login
    
    Step 1: Create a new session.
    Step 2: If the there is no token, redirect to the application permission URL    
    Step 3: Once the application is installed and verified and no errors are returned set session params and redirect to index
  */

  /* Sessions */
  session_id();
  session_start();
  
	include('lib/shopify_api.php');
		
	/* GET VARIABLES */
	$url = (isset($_GET['shop'])) ? mysql_escape_string($_GET['shop']) : '';
	$token = (isset($_GET['t'])) ? mysql_escape_string($_GET['t']) : '';	
	$api = new Session($url, $token, API_KEY, SECRET);
	
	//if the Shopify connection is valid
	if ($api->valid()){
		if (isEmpty($token)){
			header("Location: " . $api->create_permission_url());
		}else{
		  $shop = $api->shop->get();
		  
		  if (!isset($shop['error'])){
		    $_SESSION['shop'] = $url;
		    $_SESSION['token'] = $token;
		    header("Location: index.php");
		  }
		}
	}else{
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
    <head> 
    	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
    	<meta http-equiv="imagetoolbar" content="no" /> 
    	<title>Shopify API: Install or Login</title>
    	<link href="css/css.css" media="screen" rel="stylesheet" type="text/css" /> 
    </head>
    <body>
    	<div id="header"> 
    		<h1><a href="/">Shopify API</a></h1>
    	</div> 

    	<div id="container" class="clearfix"> 

    		<ul id="tabs"> 
    			<li><a href="login.php" id="current">Login</a></li>
    		</ul>
		
    		<div id="main" class="clearfix">
          <h1>Install or Login</h1> 

          <p>Install this app in a shop to get access to its private admin data.</p> 

          <p style="padding-bottom: 1em;">
          	<span class="hint">Don&rsquo;t have a shop to install your app in handy? <a href="https://app.shopify.com/services/partners/api_clients/test_shops">Create a test shop.</a></span>
          </p> 

          <form action="login.php" method="get">
            <label for='shop'><strong>The URL of the Shop</strong> 
              <span class="hint">(or just the subdomain if it&rsquo;s at myshopify.com)</span> 
            </label> 
            <p> 
              <input id="shop" name="shop" size="45" type="text" value="" /> 
              <input type="submit" value="Install or Login" /> 
            </p> 
          </form>
    		</div>
    	</div>
    </body>
    </html>
<?php
  }
?>