<?php
    /* 人物 */
    $characters = CHARACTERS;
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

    $details = $_GET['details'];
    $details_data = get_post($details);
    if($paged==null) {

    }
    $information_data = get_table_title_posts($details_data->post_title, $number ,$offset);
    $information_count = get_table_count_posts($details_data->post_title);
?>
<div>
    <div class="top-bg">
        <div class="top-bghei"></div>
        <img src="/wp-content/themes/twentyseventeen/assets/images/logo@3x.png" alt="">
    </div>
    <div class="ming">
        <div class="Ming-bg">
            <?php if( $details === null ) : ?>
                <div class="evaluate evaluate-characters" id="character-mainRight">
<!--                    <ul>-->
<!--                        --><?php //$tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
<!--                        --><?php //if( $tops ) : ?>
<!--                            --><?php //foreach( $tops as $top ):  ?>
<!--                                 <li>-->
<!--                                     <div class="character-mainRightImg">-->
<!--                                         <img src="--><?php //echo catch_the_image($top->ID)?><!--" alt="">-->
<!--                                     </div>-->
<!--                                     <a href="?cat=--><?php //echo $characters ?><!--&details=--><?php //echo $top->ID ?><!--">-->
<!--                                         <div class="celebrity-content">-->
<!--                                             <div class="celebrity-contentTitle">--><?php //echo get_content_strong($top->post_content) ?><!--</div>-->
<!--                                             <div class="celebrity-contentText">--><?php //echo get_text($top) ?><!--</div>-->
<!--                                             <div class="celebrity-contentName">--><?php //echo $top->post_title?><!--</div>-->
<!--                                         </div>-->
<!--                                     </a>-->
<!--                                         <div class="celebrity-link">-->
<!--                                             <div class="celebrity-button"><div class="commonBut-link"><a href="?cat=--><?php //echo $characters ?><!--&details=--><?php //echo $top->ID ?><!--">More</a></div></div>-->
<!--                                         </div>-->
<!--                                 </li>-->
<!--                            --><?php //endforeach; ?>
<!--                        --><?php //endif; ?>
<!--                    </ul>-->
                    <ul>
                        <?php $tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
                        <?php if( $tops ) : ?>
                            <?php foreach( $tops as $top ):  ?>
                                <li>
                                    <a href="?cat=<?php echo $characters ?>&details=<?php echo $top->ID ?>">
                                        <div class="content-border">
                                            <div class="left-img">
                                                <img  src="<?php echo catch_the_image($top->ID)?>">
                                            </div>
                                            <div class="content-outer">
                                                <div class="p-outer"><p class="p1"><?php echo $top->post_title?></p>
                                                    <p class="p3"><?php echo get_content_strong($top->post_content) ?></p>
                                                    <p class="p4"><?php get_text($top) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="else-data">无数据</div>
                        <?php endif; ?>
                        <div style="clear: both;"></div>
                    </ul>
                    <div class="clear"></div>
                    <div class="pagena">
                        <?php echo get_pagenavi('4', $total ,$number);?>
                    </div>
                </div>
            <?php else: ?>
                <div class="details-mainRight" id="character-mainRight">
                    <div class="details-introduction">
                        <div class="details-introductionImg">
                            <img src="<?php echo catch_the_image($details_data->ID) ?>" alt="">
                        </div>
                        <div class="details-introductionCon">
                            <div class="details-introductionTitle"><?php echo $details_data->post_title ?></div>
                            <div class="details-introductionText"><?php echo get_content_strong($details_data->post_content) ?></div>
                            <div class="details-introductionLord"><?php echo get_text($details_data) ?></div>
                        </div>
                    </div>
                    <div class="span-title"><span>相关信息</span></div>
                    <?php if( $information_data ) : ?>
                    <div class="related-information">
                        <ul>
                                <?php foreach( $information_data as $data ):  ?>
                                    <a  href="?p=<?php echo $data->ID?>">
                                        <li>
                                            <div class="related-informationImg">
                                                <img src="<?php echo catch_the_image($data->ID)?>" alt="">
                                            </div>
                                            <div class="related-informationCon">
                                                <div class="related-informationTiele"><?php echo $data->post_title?></div>
                                                <div class="related-informationText"><?php get_text($data) ?></div>
                                            </div>
    <!--                                        <a class="related-mainRigLink" href="?p=--><?php //echo $data->ID?><!--">-->
<!--                                            <img src="/wp-content/themes/twentyseventeen/assets/images/btn_content_more_normal@3x.png" alt="">-->
                                         </li>
                                    </a>

                                <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="pagena" style="justify-content: center">
                        <?php echo get_pagenavi('4', $information_count ,$number);?>
                    </div>
                    <?php else: ?>
                        <div class="else-data">无数据</div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>

    </div>


</div>



