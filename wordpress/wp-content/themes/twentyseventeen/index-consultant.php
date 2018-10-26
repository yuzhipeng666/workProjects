<?php
    /* 顾问 */
    $consultants = CONSULTANTS;
    $paged = get_query_var('page');
    if($paged==null){
       $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("numberposts=-1&category=$cat_ID");
    // 显示多少条
    $number = 100;
    $offset = $p * $number;
?>
<div>
    <div class="top-bg">
        <div class="top-bghei"></div>
        <img src="/wp-content/themes/twentyseventeen/assets/images/logo@3x.png" alt="">
    </div>
    <div class="ming">
        <div class="Ming-bg">
            <div class="" id="character-mainRight">
<!--                <ul>-->
<!--                    --><?php //$tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
<!--                    --><?php //if( $tops ) : ?>
<!--                        --><?php //foreach( $tops as $top ):  ?>
<!--                            <li>-->
<!--                                <a href="?p=--><?php //echo $top->ID?><!--">-->
<!--                                    <div class="character-mainRightImg">-->
<!--                                        <img src="--><?php //echo catch_the_image($top->ID)?><!--" alt="">-->
<!--                                    </div>-->
<!--                                    <div class="character-mainRigContent">-->
<!--                                        <div class="character-mainRigTitle">--><?php //echo $top->post_title?><!--</div>-->
<!--                                        <div class="character-mainRigText">--><?php //get_text($top) ?><!--</div>-->
<!--                                        <div class="character-mainRigLink">--><?php //echo get_content_link($top->post_content) ?><!--</div>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                        --><?php //endforeach; ?>
<!--                    --><?php //endif; ?>
<!--                </ul>-->
                <div class="management">
                    <div class="consultant">
                        <?php $tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
                        <?php if( $tops ) : ?>
                            <ul>
                                <!--获取分类和分类下的文章列表-->
                                <?php foreach( $tops as $top ):  ?>
                                    <li>
                                        <a href="?p=<?php echo $top->ID?>">
                                            <div class="consultant">
                                                <div class="consultant-listImg">
                                                    <img src="<?php echo catch_the_image($top->ID)?>" alt="">
                                                </div>
                                                <div class="consultant-content">
                                                    <div class="consultant-contentName"><?php echo $top->post_title?></div>
                                                    <div class="consultant-contentText"><?php get_text($top) ?></div>
                                                    <div class="consultant-contentLink"><?php echo get_content_link($top->post_content) ?></div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="clear"></div>
                        <?php else: ?>
                            <div class="else-data">无数据</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="pagena" style="justify-content: center;">
                    <?php echo get_pagenavi('4', $total ,$number);?>
                </div>
            </div>
    </div>
    </div>




</div>


