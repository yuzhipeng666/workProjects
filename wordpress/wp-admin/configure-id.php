<?php
/**
 * Edit Posts Administration Screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

$data = get_table_configureId()[0]->configure_id;
$data_id = get_table_configureId()[0]->id;
?>

<div class="configure">
<!--    <form name="post"  method="post" id="post">-->
        <h1>配置分类ID</h1>
        <input type="hidden" name="id" id="id" class="input" value="<?php echo $data_id ?>"/>
        <h3>分类ID:<input type="text" name="configure" id="configure" class="input" value="<?php echo $data ?>"/></h3>
        <p>
            <span>1:新闻<br/></span>
            <span>2:Dapps<br/></span>
            <span>3:活动<br/></span>
            <span>4:公链<br/></span>
            <span>5:人物<br/></span>
            <span>6:快讯<br/></span>
            <span>7:小道<br/></span>
            <span>8:明星<br/></span>
            <span>9:关于<br/></span>
            <span>10:顾问<br/></span>
            <span>11:合作<br/></span>
            <span>12:头条<br/></span>
        </p>
        <input type="submit" name="publish" id="submit"  class="button button-primary button-large" value="修改"/>
    <!--    </form>-->
<!--    </form>-->
</div>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
    $('#submit').click(function(e){
        var id = $('#id').val();
        var configure = $('#configure').val();
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:{
                'action':'myajax_submit',
                'configure': configure,
                'id': id
            },
            cache:false,
            dataType:'json',
            success:function(result){
                if(result.success === 0){
                    alert('修改成功')
                }
            },
            error:function(data){
                alert('修改失败')
            }
        });
        return false;
    });
</script>