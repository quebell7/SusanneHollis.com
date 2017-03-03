
    <nav role="navigation" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        
        <!-- Title -->
        <div class="navbar-header pull-left">
          <a href="/" class="navbar-brand">Susanne Hollis</a>
        </div>
        
        <!-- 'Sticky' (non-collapsing) right-side menu item(s) -->
        <div class="navbar-header pull-right">
          <ul class="nav navbar-nav pull-left">
            <!-- This works well for static text, like a username -->
            <li class="visible-xs pull-left foo<?php echo ($contentFile == 'search.php' ? 'active' : '') ?>"><a href="search.php" class="" >Search</a></li>

          </ul>

          <!-- Required bootstrap placeholder for the collapsed menu -->
	  		<button type="button" class="navbar-toggle navbar-right collapsed navMiniButton" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>    
        </div>



		<div id="navbar" class="collapse navbar-collapse navbar-left">
			
			<ul class="nav navbar-nav">

				<li class="dropdown<?php echo ($contentFile == 'list.php' && array_key_exists($subCat,$furnitureArray) ? ' active' : ''); ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Furniture<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php
							foreach($furnitureArray as $x => $y){
								$isActive = ($subCat == $x ? 'active' : '');
								echo '<li class="' . $isActive . '"><a href="list.php?subCat=' . $x . '">' . $y . '</a></li>';
							}
						?>
					</ul>
				</li>
	
				<li class="<?php echo ($contentFile == 'list.php' && $subCat == 'LIGHTING' ? 'active' : '') ?>"><a href="list.php?subCat=LIGHTING">Lighting</a></li>
				<li class="<?php echo ($contentFile == 'list.php' && $subCat == 'PICTURES' ? 'active' : '') ?>"><a href="list.php?subCat=PICTURES">Art</a></li>
				<li class="<?php echo ($contentFile == 'list.php' && $subCat == 'Collections' ? 'active' : '') ?>"><a href="list.php?subCat=Collections">Collections</a></li>
				
				<li class="dropdown<?php echo ($contentFile == 'list.php' && array_key_exists($subCat,$otherCategoryArray) ? ' active' : ''); ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">All Others<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php
							foreach($otherCategoryArray as $x => $y){
								$isActive = ($subCat == $x ? 'active' : '');
								echo '<li class="' . $isActive . '"><a href="list.php?subCat=' . $x . '">' . $y . '</a></li>';
							}
						?>
					</ul>
				</li>
				
				<li class="hidden-xs <?php echo ($contentFile == 'search.php' ? 'active' : '') ?>"><a href="search.php">Search</a></li>
           
					
				<li class="<?php echo ($contentFile == 'about.php' ? 'active' : '') ?>"><a href="about.php">About</a></li>
				<li class="<?php echo ($contentFile == 'press.php' ? 'active' : '') ?>"><a href="press.php">Press</a></li>
				<li class="<?php echo ($contentFile == 'contact_us.php' ? 'active' : '') ?>"><a href="contact_us.php">Get in Touch</a></li>
				
				<?php 
					if(!$logedin){
						echo '<li class="'. ($contentFile == 'login.php' ? 'active' : '') . '"><a href="login.php">Login</a></li>';
					}
				?>

			</ul>
			
		</div>


      </div>
    </nav>


