<?php
    /* 快讯 */
    $newsletters = NEWSLETTERS;
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
<div class="top-bg">
    <div class="top-bghei"></div>
    <img src="/wp-content/themes/twentyseventeen/assets/images/logo@3x.png" alt="">
</div>
<div class="ming">
    <div class="Ming-bg">
        <div class="newsletter-mainRight" id="dapps-mainRight">
        <?php $trails_data = get_posts("category=$newsletters&numberposts=$number&offset=$offset"); ?>
        <?php if( $trails_data ) : ?>
<!--            <div class="newsletter-list">-->
<!--                --><?php //foreach( $trails_data as $trail ):  ?>
<!--                <div class="newsletter-link">-->
<!--                        <div class="headline-listarticle trailhang-list">-->
<!--                            <a href="?p=--><?php //echo $trail->ID?><!--">-->
<!--                            <div class="newsletter-content">-->
<!--                                <div class="newsletter-contentTitle">--><?php //echo $trail->post_title?><!--</div>-->
<!--                                <div class="newsletter-contentText">--><?php //echo get_text($trail) ?><!--</div>-->
<!--                            </div>-->
<!--                            </a>-->
<!--                            <div class="newsletter-aug">-->
<!--                                <div class="newsletter-augDate">--><?php //echo date("m-d", strtotime($trail->post_date_gmt))?><!--</span></div>-->
<!--                                <div class="newsletter-augLink"><span>--><?php //echo get_content_link($trail->post_content) ?><!--</span></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                </div>-->
<!--                --><?php //endforeach; ?>
<!--                <div class="clear"></div>-->
<!--            </div>-->
        <div class="newsletter-listCon">
            <ul>
            <?php foreach( $trails_data as $trail ):  ?>
                    <li>
                        <a href="?p=<?php echo $trail->ID?>">
                            <div class="newsletter-listCon-date">
                                <?php echo date("m-d", strtotime($trail->post_date_gmt))?>
                            </div>
                            <div class="newsletter-listCon-title">
                                <?php echo $trail->post_title?>
                            </div>
                            <div class="newsletter-listCon-text">
                                <?php echo get_text($trail) ?>
                            </div>
                            <div class="newsletter-listCon-link">
                                <?php echo get_content_link($trail->post_content) ?>
                            </div>
                        </a>
                    </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php else: ?>
            <div class="else-data">无数据</div>
        <?php endif; ?>
        <div class="pagena">
            <?php echo get_pagenavi('4', $total ,$number);?>
        </div>
    </div>
    </div>
</div>
