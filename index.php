<?php 
    /*
        Copyright Sujevo Software, 2012. All Rights Reserved.
        http://sujevo.com
        
        Usage of this software is allowed with expressed written
        permission of the owner. This source may not be modified
        or built upon without expressed written permission from
        the copyright holder.
        This software is provided "AS IS" and at no time is the
        developer or distributor of this software liable for
        any damage caused by the use or misuse of the this
        software.
    */
    session_start();
    
    include("includes/header.php");
    include("includes/menubar.php");
?>
            <div id="featured">
                <img src="http://www.italian-food.us/vealsaltimboccalarge.jpg">
                
                <div class="description">
                    <a href="#"><h1>Some Amazing Salad</h1></a>
                    by <a href="#">allejo</a>
                    <br />
                    <br />
                    <p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ut posuere tellus. In non quam a orci pellentesque varius. Integer vitae ligula id urna imperdiet lacinia sit amet sed diam. Sed eu turpis pretium libero dignissim hendrerit quis in urna. Aenean nec nulla neque. Phasellus sit amet mauris nibh, vel dapibus velit. Integer vulputate bibendum felis consectetur pretium. Nulla et enim mi. Phasellus elementum enim et tellus tincidunt suscipit ultricies leo feugiat. Maecenas enim tortor.
                    </p>
                    
                    <div class="recipeBtn">
                        <a href="#" class="download_button orange">See the recipe</a>
                    </div>
                </div>
            </div>
            
            <div id="content">
                <?php echo $row[2]; ?>
            </div>
<?php
    include("includes/footer.php");
?>