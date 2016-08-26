<script>
   /* var $j = jQuery.noConflict();
    $j(function(){
        $j("#iframe_wordpress").load(function () {
            $j(this.contentDocument).find('#wpcontent').css('margin-left', '0px');
            $j(this.contentDocument).find('#adminmenuwrap').remove();
            $j(this.contentDocument).find('#adminmenuback').remove();
            $j(this.contentDocument).find('#wpadminbar').remove();
        });
    });  */  
</script>
<?php if (isset($contacts[0]->id_wp)): ?>
    <iframe id="iframe_wordpress" src="<?= admin_url('user-edit.php?user_id='. $contacts[0]->id_wp .'&wp_http_referer=%2Ftunegocioweb%2Fcrm_base%2Fwp-admin%2Fusers.php') ?>" style="width: 100%; height: 420px;border: 4px solid #ffffff;"></iframe>
<?php endif ?>