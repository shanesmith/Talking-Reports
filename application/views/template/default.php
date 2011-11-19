<!DOCTYPE html>
<html lang="en">
<head>
    <title>33898 template previews</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/reset.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/assets/css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/assets/css/grid.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/assets/css/superfish.css" type="text/css" media="screen"> 

    <script src="/assets/js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="/assets/js/superfish.js" type="text/javascript"></script>
    <script src="/assets/js/jquery.faded.js" type="text/javascript"></script>
    <script src="/assets/js/cufon-yui.js" type="text/javascript"></script>
    <script type="text/javascript">
		$(function(){
			$("#faded").faded({	
					speed: 500,
					crossfade: false,
					bigtarget: true,
					loading: false,
					autoheight: false,
					pagination: "pagination",
					autopagination: true,
					nextbtn: "next",
					prevbtn: "prev",
					loadingimg: false,
					autoplay: 10000,
					autorestart: false,
					random: false
				});
		});
	</script>
	<!--[if lt IE 7]>
   		<div style=' clear: both; text-align:center; position: relative;'> 
        	<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0" alt="" /></a>
        </div> 
	<![endif]-->
    <!--[if lt IE 9]>
   		<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
        <script type="text/javascript" src="js/html5.js"></script>
	<![endif]-->
</head>
<body id="page1">

<div class="bg">
<!--==============================header=================================-->
   <header class="header">
   	 <div class="main">
   	   <div class="row-1">
              <h1><a class="logo" href="#">BusinessBox</a></h1>
                <form id="form-top" action="" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-top">					
                            <span><input name="name" value="" onBlur="if(this.value=='') this.value=''" onFocus="if(this.value =='' ) this.value=''" /></span>
                            <a href="#" onClick="document.getElementById('form-top').submit()"></a>                        </div>
                    </fieldset>
                </form>
                <nav>
      <ul class="sf-menu">
                        <li class="current"><a href="#">Home</a></li>
                        <li><a href="#">Company</a>
                            <ul>
                               <li><a href="#">We offer</a></li>
                               <li><a href="#">Our mission</a></li>
                               <li><a href="#">Promotion</a></li>
                               <li><a href="#">Testimonials</a></li>
                            </ul> 
                        </li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Benefits</a></li>
                        <li><a href="#">Partners</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li class="last"><a href="#">Contact info</a></li>
                  </ul>
              </nav>
         </div>    
		 </div>
         </header>

		<br />
		<br />
		<br />
		<br />
		
<!--==============================content================================-->
<div class="main">
	<?php 
		//VIEW CONTENT
		echo $content; 
	?>
</div>

<br />
<br />

<!--==============================footer=================================--> 
    <footer>
        <div class="main">
               <!-- {%FOOTER_LINK} -->
               <ul class="menu-footer">
                    <li><a class="active" href="#">Home</a></li>
                    <li><a href="#">Company</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Benefits</a></li>
                    <li><a href="#">Partners</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li class="last-item"><a href="#">Contact info</a></li>
               </ul>
               <div class="text-bot">BusinessBox &copy; 2011 <a href="#">Privacy Policy</a></div>
        </div>
    </footer>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7078796-5']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
