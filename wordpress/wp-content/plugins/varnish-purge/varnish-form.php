<style>
.wrap form .submit input{
    height: 30px;
    width: 150px;
    font-size: 17px;
    padding: 0px 20px;
    background-color: #0073aa;
    color: #fff;
    font-weight: 200;
    cursor: pointer;
}
.wrap p.success{color:green;}
.wrap p.error{color:red;}
.wrap p.msj{background:#fff;height:30px;width:100%;padding: 15px 0 0 10px;line-height: 15px;}


</style>
<div class="wrap">
    <?php    echo "<h2>" . __( 'Varnish Purge', 'espnplus' ) . "</h2>"; ?>
   
    <hr>
    <p>Click here to purge Varnish cache.</p> 

    <?php 

    if($status_flag === true){ 
        echo '<p class="success msj">Success, Varnish cache purged.</p>';
    }

    if($error_flag === true){ 
        echo '<p class="error msj">Opps something happened, please try again.</p>';
    }  

    ?>


    <form name="varnish_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="varnish_hidden" value="Y">
     
        <p class="submit">
        <input type="submit" name="Purge" value="<?php _e('Purge now', 'espnplus' ) ?>" />
        </p>
    </form>
    <hr> 
</div>