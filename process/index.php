<?php

    // $path = preg_replace("/wp_content.*$/", "", __DIR__);
    // $path = preg_replace("/wp_content.*$/", "", "");
    // $path = "/wordpress/";
    // echo $path;
    // // $path = __DIR__;
    // require_once($path ."wp-load.php");

    require("../js/cnp_valid.php");
   
    if ( isset($_POST['form_submit']) && $_POST['form_submit'] == '1' ) {

        // get data from submitted form
        // $cnp = sanitize_text_field($_POST['cnp']);

        $cnp = $_POST['cnp'];

        $return = [];
        $return['success'] = 1;
        $return['cnp'] = $cnp;

        $return['isCnpValid'] = isCnpValid($cnp);

        echo json_encode($return);
    }