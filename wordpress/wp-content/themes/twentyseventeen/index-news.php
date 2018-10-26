<?php
    /* 新闻 */
    $newss = NEWSS;
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
<div class="news-listImg">
    <?php $topping = get_posts("category=$newss&numberposts=4");?>
    <?php if( $topping ) : ?>
        <div class="dapps-mingTop">
            <a href="?p=<?php echo $topping[0]->ID?>">
                <div class="news-topTitle">
                    <p><?php echo $topping[0]->post_title?></p>
                </div>
                <img src="<?php echo catch_the_image($topping[0]->ID)?>" alt="">
            </a>
        </div>
        <div class="dapps-mingTopImg">
            <ul>
                <li>
                    <a href="?p=<?php echo $topping[1]->ID?>">
                        <div class="news-bottTitle">
                            <p><?php echo $topping[1]->post_title?></p>
                        </div>
                        <img src="<?php echo catch_the_image($topping[1]->ID)?>" alt="">
                    </a>
                </li>
                <li>
                    <a href="?p=<?php echo $topping[2]->ID?>">
                        <div class="news-bottTitle">
                            <p><?php echo $topping[2]->post_title?></p>
                        </div>
                        <img src="<?php echo catch_the_image($topping[2]->ID)?>" alt="">
                    </a>
                </li>
                <li>
                    <a href="?p=<?php echo $topping[3]->ID?>">
                        <div class="news-bottTitle">
                            <p><?php echo $topping[3]->post_title?></p>
                        </div>
                        <img src="<?php echo catch_the_image($topping[3]->ID)?>" alt="">
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>
<div class="ming">
    <div class="Ming-bg">
    <div class="dap-main">
        <div class="dat-hidden">
        <div class="dap-mainLeft" id="container-async">
            <ul>
                <li class="Active" id="<?php echo  $cat_ID?> ">
                    <a href="jacascript::void(0)" class="dapActive">全部</a>
                </li>
                <?php $ab = get_category_root_id($cat_ID) ?>
                <?php $cates = get_categories("child_of=$ab&hide_empty=0") ?>
                <?php foreach ($cates as $c): ?>
                    <li id="<?php echo $c->term_id ?>">
                        <a href="jacascript::void(0)" ><?php echo $c->name ?></a>
                    </li>
                <?php endforeach; ?>
                <div class="clear"></div>
            </ul>
        </div>
        </div>
        <div class=" miniapp-list-content--main" id="dap-mainRight">
            <div class="content-main">
                <div id="collectionList" class="collection-list" style="margin-top: 0px;">
                    <?php $tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
                    <?php if( $tops ) : ?>
                        <?php foreach( $tops as $top ):  ?>
                            <div class="article-item article-item--list ">
                                <div class="article-image cover-image">
                                    <a href="?p=<?php echo $top->ID?>"
                                       class="article-link cover-block"
                                       style="background-image:url('<?php echo catch_the_image($top->ID)?>')">
                                    </a>
                                </div>
                                <div class="article-info js-transform">
                                    <h3><a class="js-title-transform" href="?p=<?php echo $top->ID?>"><?php echo $top->post_title?></a></h3>
                                    <div class="article-summary"><?php get_text($top) ?></div>
                                    <div class="article-meta" >
                                        <time data-timestamp="1536664103"> <span><?php echo date("m-d", strtotime($top->post_date_gmt))?></span>
                                            <?php $tt = wp_get_post_tags($top->ID); foreach ($tt as $t): ?>
                                                <span><?php echo $t->name ?></span>
                                            <?php endforeach; ?>
                                        </time>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <div class="else-data">无数据</div>
                    <?php endif; ?>
                </div>
                <div class="pagena">
                    <?php echo get_pagenavis('4', $total, $number ,$paged); ?>
                </div>
          </div>
        </div>
        </div>
    </div>
    </div>
    </div>
</div>

<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
    $(".dap-mainLeft ul li").on("click", function (){
        var _this = this;
        var id = $(this).attr("id");
        var data={
            tape:id,
            action : 'get_ajax_news',
        }
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:data,
            cache:false,
            dataType:'html',
            success:function(result){
                $(".dap-mainLeft ul li ").removeClass("Active")
                $(_this).addClass("Active");
                $(".dap-mainLeft ul li a").removeClass("dapActive")
                $(_this).find("a").addClass("dapActive");
                $('.content-main').empty();
                $(".content-main").append(result);
            },
            error:function(data){
                alert("err");
            }
        });
        return false;

    });

    $(".content-main").on("click", ".page-numbers", function (){
        var paged_id = $(this).attr("id");
        var id = $(".dap-mainLeft ul .Active").attr("id");
        var data={
            tape:id,
            page:paged_id,
            action : 'get_ajax_news',
        }
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:data,
            cache:false,
            dataType:'html',
            success:function(result){
                $('.content-main').empty();
                $(".content-main").append(result);
            },
            error:function(data){
                alert("err");
            }
        });
        return false;

    });
    $(document).ready(function(){
        $(window).scroll(function(event){
            if(document.documentElement.scrollTop > 720) {
                $(".dat-hidden").addClass("dat-hidden-scroll");
                $(".miniapp-list-content--main").addClass("miniapp-list-content-scroll");
            } else {
                $(".dat-hidden").removeClass("dat-hidden-scroll");
                $(".miniapp-list-content--main").removeClass("miniapp-list-content-scroll");
            }
        });
    });




</script>




