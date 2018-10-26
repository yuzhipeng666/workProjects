<?php
    /* 新闻 */
    $newss = NEWSS;
    /* DApps */
    $dapps = DAPPS;
    /* 活动 */
    $activitys = ACTIVITYS;
    /* 公链 */
    $chains = CHAINS;
    /* 人物 */
    $characters = CHARACTERS;
    /* 快讯 */
    $newsletters = NEWSLETTERS;
    /* 小道 */
    $trails = TRAILS;
    /* 明星 */
    $celebritys = CELEBRITYS;
    /* 关于 */
    $on = ON;
    /* 顾问 */
    $consultants = CONSULTANTS;
    /* 合作 */
    $cooperations = COOPERATIONS;
    /* 头条 */
    $tops = TOPS;
    $paged = get_query_var('page');
    if($paged==null){
       $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("category=$cat_ID");
    // 显示多少条
    $number = 1;

?>

<style>
    .active{
        color: #00b9eb;
    }
</style>

<div>
        <div class="dapps-ming">
            <div class="dapps-main">
                <div class="dapps-mainLeft" id="container-async">
                    <ul>
                        <li>
                            <a href="?cat=<?php echo $activitys ?>" class="<?php if($activitys == $cat_ID) echo 'active'?>">全部</a>
                        </li>
                        <?php $ab = get_category_root_id($cat_ID) ?>
                        <?php $cates = get_categories("child_of=$ab&hide_empty=0")?>
                        <?php foreach( $cates as $c ):  ?>
                        <li>
<!--                            <a href="?cat=--><?php //echo $c->term_id?><!--">--><?php //echo $c->name?><!--</a>-->
                            <a href="?cat=<?php echo $c->term_id?>" class="<?php if($c->term_id == $cat_ID) echo 'active'?>"><?php echo $c->name?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
            </div>
                <div class="dapps-mainRight" id="dapps-mainRight">
                    <ul>
                        <?php $tops = get_posts("category=$cat_ID&numberposts=$number&offset=$p"); ?>
                        <?php var_dump(count($total)) ?>
                        <?php if( $tops ) : ?>
                            <div>
                                <?php foreach( $tops as $top ):  ?>
                                    <div>
                                        <a href="<?php echo get_permalink( $top->ID ) ?>">
                                            <img src="<?php echo catch_the_image($top->ID)?>" alt="">
                                        </a>
                                        <h3><?php echo $top->post_title?></h3>
                                        <p><?php get_text($top) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </ul>
                    <?php echo get_pagenavi('4', $total ,$number);?>
                </div>
        </div>



</div>



