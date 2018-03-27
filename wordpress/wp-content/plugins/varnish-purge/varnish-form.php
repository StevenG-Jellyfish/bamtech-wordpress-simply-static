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

    <?php 

    if($status_flag === true){ 
        echo '<p class="success msj">Success, Varnish cache purged.</p>';
    }

    if($error_flag === true){ 
        echo '<p class="error msj">Opps something is not right, please try again.</p>';
    }  

    ?>


    <form name="varnish_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="varnish_hidden" value="Y">
        <input type="hidden" name="varnish_enabled" value="true">
         <input type="hidden" name="varnish_aws" value="true">
     
        <p>Varnish URL: <br><input type="text" name="varnish_url" value="<?php echo $varnish_vars['SITE_URL'];?>" size="50"></p>
        <p>Varnish Path: <br><input type="text" name="varnish_path" value="<?php echo $varnish_vars['VARNISH_PATH'];?>" size="50"></p>
        <p>Varnish Token: <br><input type="text" name="varnish_token" value="<?php echo $varnish_vars['VARNISH_TOKEN'];?>" size="50"></p>
        <p>Varnish AWS LB: <br><input type="text" name="varnish_aws_lb" value="<?php echo $varnish_vars['VARNISH_AWS_LB'];?>" size="50"></p>
        <p>Varnish Region: <br><input type="text" name="varnish_aws_region" value="<?php echo $varnish_vars['VARNISH_AWS_REGION'];?>" size="50"></p>

        <hr>
        <p class="submit">
        <input type="submit" name="Purge" value="<?php _e('Purge now', 'espnplus' ) ?>" />
        </p>
    </form>
    <hr> 
</div>


