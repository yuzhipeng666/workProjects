<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="wrap">
                <div class="wrap-content">
                    © 2018 XBlockchain All rights reserved.
                </div>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->


<?php wp_footer(); ?>
<script>
    // $('.dap-mainLeft ul li').on('touchstart',function(event){
    //     //screenWidth:屏幕分辨率宽度
    //     var screenWidth = $(window).width();
    //     var that = this;
    //     //获取ul下的li总数
    //     var liCount = $('.dap-mainLeft ul li').length;
    //     //index:获取当前被点击的图片的索引值
    //     var index = $(that).index();
    //     //最小滑动距离，当左右滑动距离小于这个值时，图片返回原位置，不产生向左或者向右切换图片的效果
    //     var minMoveDis = 100;
    //     //获取点击x坐标
    //     var _touch = event.originalEvent.targetTouches[0];
    //     console.log(_touch)
    //     var clickX = _touch.pageX;
    //     $(".dap-mainLeft ul li").on('touchmove',function(event){
    //         //移动过程中，距离最开始点击位置的X距离
    //         var _sectouch = event.originalEvent.targetTouches[0];
    //         var distance = _sectouch.pageX - clickX ;
    //         // var moveX = distance*(-1) + screenWidth * index * (-1);
    //         $('.dap-mainLeft ul').css("transform","translate3d("+distance+"px,0,0)");
    //         //滑动事件结束时
    //         $('.dap-mainLeft ul li').on('touchend',function(){
    //             // if (0 < distance < minMoveDis ) {
    //             //     moveX = index *screenWidth*(-1);
    //             // }
    //             // if(distance >=minMoveDis ){
    //             //     moveX = (index+1) *screenWidth*(-1);
    //             // }
    //             // if(distance <=0){
    //             //     moveX = (index-1) *screenWidth*(-1);
    //             // }
    //             // console.log(moveX)
    //             $('.dap-mainLeft ul').css("transform","translate3d("+distance+"px,0,0)");
    //             $('.dap-mainLeft ul').off('touchmove',function(e){
    //                 e.preventDefault();
    //             });
    //         });
    //     });
    // });

</script>
</body>
</html>
