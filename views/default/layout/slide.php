<?php
 $image = $ci->Core->show_all('slides');
?>
   <section class="stripe homepageslider">
                                <ul class="bxslider">
                                <?php  foreach ($image as $images): ?>
                              		<li><img src="<?php echo SITE_DIR ?>thumb.php?src=<?php echo $images['s_link'] ?>&w=1423&h=478" /></li>
                              	<?php endforeach; ?>
                            </ul>
                          </section> 