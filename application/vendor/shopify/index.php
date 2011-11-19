<?php
  /* Sessions */
  session_id();
  session_start();  
	include('lib/shopify_api.php');
		
  if (!isset($_SESSION['shop']) || !isset($_SESSION['token'])) header("Location: login.php");
  $url = $_SESSION['shop'];
  $token = $_SESSION['token'];
	$api = new Session($url, $token, API_KEY, SECRET);
	
	//if the Shopify connection is valid
	if ($api->valid()){
	  $products = $api->product->get();
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
    <head> 
    	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
    	<meta http-equiv="imagetoolbar" content="no" /> 
    	<title>Shopify API: Login</title>
    	<link href="css/css.css" media="screen" rel="stylesheet" type="text/css" /> 
    </head>
    <body>
    	<div id="header"> 
    		<h1><a href="/">Shopify API</a></h1>
    	</div> 

    	<div id="container" class="clearfix"> 

    		<ul id="tabs"> 
    		  <li><a href="index.php" id="current">Main</a></li>
    			<li><a href="logout.php">Logout</a></li>
    		</ul>
		
    		<div id="main" class="clearfix">
          <h1>Products</h1>
          
          <?php
            foreach($products as $product){
              echo $product['title'].'<br />';
            }
          ?>
    		</div>
    	</div>
    </body>
    </html>
<?php
  }
?>