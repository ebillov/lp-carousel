<?php
    global $listingpro_options;
    $lp_review_switch = $listingpro_options['lp_review_switch'];
?>
<style>
    #carousel-lp-shortcode {
        display: none;
        margin: 30px 0;
    }
    #carousel-lp-shortcode .slick-list {
        margin: 0 -15px;
    }
    #carousel-lp-shortcode .slick-slide {
        margin: 0 15px;
    }
    #carousel-lp-shortcode .slick-prev {
        left: -46px;
    }
    #carousel-lp-shortcode .slick-prev:before,
    #carousel-lp-shortcode .slick-next:before {
        -webkit-box-shadow: 0 1px 14px 0 rgba(0, 0, 0, 0.3);
        -moz-box-shadow: 0 1px 14px 0 rgba(0, 0, 0, 0.3);
        box-shadow: 0 1px 14px 0 rgba(0, 0, 0, 0.3);
    }
    #carousel-lp-shortcode .carousel-item {
        border: 1px solid #e3e3e3;
        border-radius: 8px;
        background: #ffffff;
    }
    #carousel-lp-shortcode .carousel-item .item-content {
        padding: 10px 15px;
        border-top: 1px solid #e3e3e3;
    }
    #carousel-lp-shortcode .carousel-item .item-content h4 {
        font-weight: bold;
    }
    /*
    #carousel-lp-shortcode .carousel-item .item-img {
        position: relative;
    }
    #carousel-lp-shortcode .carousel-item .item-img .overlay-gradient {
        background: rgba(0, 0, 0, 0) linear-gradient(0deg, rgba(0, 0, 0, .9) 8%, rgba(0, 0, 0, 0) 94%) repeat scroll 0 0;
        height: 50px;
        width: 100%;
        position: absolute;
        bottom: 0;
    }
    */
    #carousel-lp-shortcode .carousel-item .item-content ul {
        border-top: 1px solid #dddddd;
        margin-top: 10px;
    }
    #carousel-lp-shortcode .carousel-item .item-content ul li {
        padding: 10px 0;
        border-bottom: 1px solid #dddddd;
    }
    #carousel-lp-shortcode .carousel-item .item-content ul li:last-child {
        border-bottom: none;
    }
    #carousel-lp-shortcode .carousel-item .item-content .address_section img {
        width: 17px;
        display: inline-block;
    }
</style>
<div id="carousel-lp-shortcode" class="default-carousel-lp-template">

    <?php foreach($listings as $listing): ?>
    <div class="carousel-item">
        <div class="item-img">
            <?php
                if ( has_post_thumbnail()) {
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $listing->ID ), 'listingpro-blog-grid2' );
                    if(!empty($image[0])){
                        echo '<a href="'. get_the_permalink($listing->ID) . '">
                                <img src="' . $image[0] . '" />
                            </a>';
                    }else {
                        echo '
                        <a href="'. get_the_permalink($listing->ID) .'" >
                            <img src="'.esc_html__('https://via.placeholder.com/372x400', 'listingpro').'" alt="">
                        </a>';
                    }	
                } elseif(!empty( lp_default_featured_image_listing() )){
                    echo '<a href="'. get_the_permalink($listing->ID) . '" >
                        <img src="' . lp_default_featured_image_listing() . '" />
                    </a>';
                } else {
                    echo '
                    <a href="'. get_the_permalink($listing->ID) . '" >
                        <img src="'.esc_html__('https://via.placeholder.com/372x400', 'listingpro').'" alt="">
                    </a>';
                }
            ?>
            <div class="overlay-gradient"></div>
        </div>
        <div class="item-content">
            <h4><a href="<?php echo get_the_permalink($listing->ID); ?>"><?php echo $listing->post_title; ?></a></h4>
            <?php
                $a = get_post_meta($listing->ID, 'listing_plan_data');
                $b = 'price';

                    
                if(empty($a)){
                    $a = get_post_meta($listing->ID, 'lp_listingpro_options');
                    $b = 'Plan_id';
                    if(array_key_exists($b, $a[0])){
                        if($a[0]['Plan_id'] == ''){
                            $b = 'changed_planid';
                            if(array_key_exists($b, $a[0])){
                                if($a[0]['changed_planid'] == ''){
                                    $b = 'lp_purchase_price';
                                }
                            }
                        }
                    }
                }

                $color = '';
                if(array_key_exists($b, $a[0])){
                    if($b == 'changed_planid' || $b == 'Plan_id'){
                        if($a[0][$b] == '1255' || $a[0][$b] == '211'){
                            $color = '#9b111e';
                        } elseif($a[0][$b] == '1256' || $a[0][$b] == '205'){
                            $color = "#0f52ba";
                        } elseif($a[0][$b] == '1257' || $a[0][$b] == '208'){
                            $color = '#dd9933';
                        } else {
                            $color = 'gray';
                        }
                    }else{
                        if($a[0][$b] == '448' || $a[0][$b] == '45'){
                            $color = '#9b111e';
                        } elseif($a[0][$b] == '77' || $a[0][$b] == '785'){
                            $color = '#0f52ba';
                        } elseif($a[0][$b] == '2244' || $a[0][$b] == '220'){
                            $color = '#dd9933';
                        } else {
                            $color = 'gray';
                        }
                    }
                } else {
                    $color = 'gray';
                }
            ?>
            <span style="color: <?php echo $color; ?>">
            <?php
                if(array_key_exists($b, $a[0])){
                    if($b == 'changed_planid' || $b == 'Plan_id'){
                        if($a[0][$b] == '1255' || $a[0][$b] == '211'){
                            echo 'Ruby';
                        } else if($a[0][$b] == '1256' || $a[0][$b] == '205'){
                            echo 'Sapphire';
                        } else if($a[0][$b] == '1257' || $a[0][$b] == '208'){
                            echo 'Diamond';
                        } else {
                            echo 'Free';
                        }
                    } else {
                        if($a[0][$b] == '448' || $a[0][$b] == '45'){
                            echo 'Ruby';
                        } else if($a[0][$b] == '77' || $a[0][$b] == '785'){
                            echo 'Sapphire';
                        } else if($a[0][$b] == '2244' || $a[0][$b] == '220'){
                            echo 'Diamond';
                        } else {
                            echo 'Free';
                        }
                    }
                } else {
                    echo 'Free';
                }
            ?>
            </span>
            <ul>
                <!--
                <?php if($lp_review_switch ==1 ): ?>
                <li>
                    <?php
                    $NumberRating = listingpro_ratings_numbers($listing->ID);
                    if($NumberRating != 0):
                        if($NumberRating <= 1){
                            $review = esc_html__('Rating', 'listingpro');
                        }else{
                            $review = esc_html__('Ratings', 'listingpro');
                        }
                        echo lp_cal_listing_rate($listing->ID);
                    ?>
                    <span>
                        <?php echo $NumberRating; ?>
                        <?php echo $review; ?>
                    </span>
                    <?php else: echo lp_cal_listing_rate($listing->ID); endif; ?>
                </li>
                <?php endif; ?>
                -->

                <!-- <li class="middle tester">
                    <?php //echo listingpro_price_dynesty_text($listing->ID); ?>
                </li> -->
                <li class="cattest">
                    <?php
                        $cats = get_the_terms( $listing->ID, 'listing-category' );
                        
                        if(!empty($cats)){
                            $catCount = 1;
                            foreach ( $cats as $cat ) {

                                $category_image = listing_get_tax_meta($cat->term_id, 'category', 'image');
                                if(!empty($category_image)){
                                    echo '<span class="cat-icon"><img class="icon icons8-Food" src="' . $category_image . '" alt="cat-icon"></span>';
                                }
                                $term_link = get_term_link( $cat );
                                echo '
                                    <a class="cat_link" link="'. $term_link. '">
                                        '.$cat->name.'
                                    </a>
                                ';
                                if($catCount < count($cats)){
                                    echo '| ';
                                }
                                $catCount++;

                            }
                        }
                    ?>
                </li>
            </ul>
            <?php
                $countlocs = 1;
                $cats = get_the_terms( $listing->ID, 'location' );
                if(!empty($cats)){
                    echo '<div class="address_section">';
                    echo listingpro_icons('mapMarkerGrey');
                    foreach ( $cats as $cat ) {
                        if($countlocs == 1){
                            $term_link = get_term_link( $cat );
                            echo '
                            <a href="' . $term_link . '">
                                ' . $cat->name . '
                            </a>';
                        }
                        $countlocs ++;
                    }
                    echo '</div>';
                }
            ?>
        </div>
    </div>
    <?php endforeach; ?>

</div>
<script>
jQuery(document).ready(function(){
    jQuery('#carousel-lp-shortcode').show().slick({
        autoplay: true,
        autoplaySpeed: 3000,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 601,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    arrows: false
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                }
            }
        ]
    });
});
</script>