<?php
    /* 明星 */
    $celebritys = CELEBRITYS;
    $paged = get_query_var('page');
    if($paged==null){
       $paged = 1;
    }
    $p = $paged - 1;
    // 总条数
    $total = get_posts("numberposts=-1&category=$cat_ID");
    // 显示多少条
    $number = 1;
    $offset = $p * $number;
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
                            <a href="?cat=<?php echo $celebritys ?>" class="<?php if($celebritys == $cat_ID) echo 'active'?>">全部</a>
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
                        <?php $tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
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



