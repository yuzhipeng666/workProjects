<?php
    /* 活动 */
    $activitys = ACTIVITYS;
    $paged = get_query_var('page');
    if($paged==null){
       $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("numberposts=-1&category=$cat_ID");
    // 显示多少条
    $number = 12;
    $offset = $p * $number;
?>
<div class="top-bg">
    <div class="top-bghei"></div>
    <img src="/wp-content/themes/twentyseventeen/assets/images/logo@3x.png" alt="">
</div>
<div class="ming">
    <div class="Ming-bg">
        <div class="activity-mainRight" id="dapps-mainRight">
<!--            <ul>-->
<!--                --><?php //$tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
<!--                --><?php //if( $tops ) : ?>
<!--                    --><?php //foreach( $tops as $top ):  ?>
<!--                        <li>-->
<!--                            <div class="activity-mainRightImg">-->
<!--                                <img src="--><?php //echo catch_the_image($top->ID)?><!--" alt="">-->
<!--                            </div>-->
<!--                            <div class="activity-mainRigContent">-->
<!--                                <a href="?p=--><?php //echo $top->ID?><!--">-->
<!--                                    <div class="dapps-mainRigTitle dapps-mainRigTitleApp">--><?php //echo $top->post_title?><!--</div>-->
<!--                                 activity-mainRight   <div class="activity-mainRigDate activity-mainRigDateApp">--><?php //echo get_content_strong($top->post_content) ?><!--</div>-->
<!--                                    <div class="activity-mainRigAddress activity-mainRigAddressApp" >--><?php //echo get_content_strong($top->post_content) ?><!--</div>-->
<!--                                    <div class="activity-mainRigText">--><?php //get_text($top) ?><!--</div>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="activity-mainRigAug">-->
<!--                                <div class="activity-mainRigDate">--><?php //echo date("m-d", strtotime($top->post_date_gmt))?><!--</div>-->
<!--                                <div class="activity-mainRigYear">--><?php //echo date("Y", strtotime($top->post_date_gmt))?><!--</div>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                    --><?php //endforeach; ?>
<!--                --><?php //endif; ?>
<!--            </ul>-->
            <div class="container-warpper">
                    <?php $tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
                    <?php if( $tops ) : ?>
                        <?php foreach( $tops as $top ):  ?>
                    <div class="item-list ng-scope" ng-repeat="item in categoryListData">
                    <a href="?p=<?php echo $top->ID?>" target="_blank">
                        <div class="header">
                            <div class="img-bg" style="background-image:url('<?php echo catch_the_image($top->ID)?>')"></div>
                        </div>
                        <div class="center">
                            <div class="top">
                                <span class="item-title ng-binding"><?php echo $top->post_title?></span>
<!--                                <span class="item-status ng-binding blueColor" ng-class="{'yellowColor': item.statusText == '活动中', 'blueColor': item.statusText == '报名中', 'grayColor': item.statusText == '已结束'}">报名中</span>-->
                            </div>
                            <div class="item-desc ng-binding"><?php get_text($top) ?></div>
                        </div>

                        <div class="bottom">
                            <span class="address">
                                <span class="ng-binding"><?php echo get_content_strong($top->post_content) ?></span></span>
                            <span class="times">
                                    <span>
                                        <span class="ng-binding"><?php echo get_content_ol($top->post_content) ?></span>
                                    </span>
                                </span>
                        </div>
                    </a>
                </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <div class="else-data">无数据</div>
                <?php endif; ?>
                <div class="clear"></div>
                </div>
            </div>
            <div class="pagena">
                <?php echo get_pagenavi('4', $total ,$number);?>
            </div>
        </div>
    </div>
</div>
