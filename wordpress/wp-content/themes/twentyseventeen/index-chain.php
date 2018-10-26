<?php
    /* 公链 */
    $chains = CHAINS;
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
<div>
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
                        <?php $cates = get_categories("child_of=$ab&hide_empty=0")?>
                        <?php foreach( $cates as $c ):  ?>
                            <li id="<?php echo $c->term_id ?>">
                                <a href="jacascript::void(0)" ><?php echo $c->name ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                </div>
                <div class="dap-recommend miniapp-list-content--main" id="chain-mainRight">
                    <div class="content-main">
                    <ul>
                        <?php $tops = get_posts("category=$cat_ID&numberposts=$number&offset=$offset"); ?>
                        <?php if( $tops ) : ?>
                            <?php foreach( $tops as $top ):  ?>
                                <li>
                                    <a href="?p=<?php echo $top->ID?>">
                                    <div class="left-font"><p class="p1"><?php echo $top->post_title?></p>
                                        <p class="p2"><?php get_text($top) ?></p>
                                        <div class="p3">
                                            <div class="score">项目评分 ：
                                                <div class="cleanfloat">
                                                    <?php
                                                    $score_data = get_content_score($top->post_content);
                                                    ?>
                                                    <?php if( $score_data <= 0) : ?>
                                                        <span>无</span>
                                                    <?php else:  ?>
                                                        <?php for( $i=0; $i<$score_data; $i++ ):  ?>
                                                            <div class="cleanfloat-li">&#9733;</div>
                                                        <?php endfor; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="right-img"
                                             style="background-image: url(&quot;<?php echo catch_the_image($top->ID)?>&quot;);"></div>
                                    </div>
                                   </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div style="clear: both;"></div>
                    </ul>
                    <div class="clear"></div>
                    <div class="pagena">
                        <?php echo get_pagenavis('4', $total ,$number,$paged);?>
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
                action : 'get_ajax_chains',
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
                action : 'get_ajax_chains',
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
                if(document.documentElement.scrollTop > 340) {
                    $(".dat-hidden").addClass("dat-hidden-scroll");
                    $(".miniapp-list-content--main").addClass("miniapp-list-content-scroll");
                } else {
                    $(".dat-hidden").removeClass("dat-hidden-scroll");
                    $(".miniapp-list-content--main").removeClass("miniapp-list-content-scroll");
                }
            });
        });


    </script>



