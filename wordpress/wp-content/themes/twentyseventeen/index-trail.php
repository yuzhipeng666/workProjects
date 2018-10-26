<?php
    /* 小道 */
    $trails = TRAILS;
    $paged = get_query_var('page');
    if($paged==null){
       $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("numberposts=-1&category=$cat_ID");
    // 显示多少条
    $number = 10;
    $offset = $p * $number;
?>

<div class="trail-mingTop"></div>
<div class="dapps-ming">
    <div class="newsletter-mainRight" id="dapps-mainRight">
        <div class="span-title"><span><?php  $cat = get_category($trails);echo $cat->name;?></span></div>
        <?php $trails_data = get_posts("category=$trails&numberposts=$number&offset=$offset"); ?>
        <?php if( $trails_data ) : ?>
            <div class="newsletter-list">
                <!--获取分类和分类下的文章列表-->
                <?php foreach( $trails_data as $trail ):  ?>
                    <div class="newsletter-link">
                        <div class="headline-listarticle trailhang-list">
                            <a href="?p=<?php echo $trail->ID?>">
                                <div class="newsletter-content">
                                    <div class="newsletter-contentTitle"><?php echo $trail->post_title?></div>
                                    <div class="newsletter-contentText"><?php echo get_text($trail) ?></div>
                                </div>
                            </a>
                            <div class="newsletter-aug">
                                <div class="newsletter-augDate"><?php echo date("m-d", strtotime($trail->post_date_gmt))?></span></div>
                                <div class="newsletter-augLink"><span><?php echo get_content_link($trail->post_content) ?></span></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>
        <?php endif; ?>
        <div class="pagena">
            <?php echo get_pagenavi('4', $total ,$number);?>
        </div>
    </div>
</div>