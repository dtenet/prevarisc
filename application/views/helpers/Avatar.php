<?php

    class View_Helper_Avatar extends Zend_Controller_Action_Helper_Abstract
    {
        public function avatar($id, $size="small")
        {
            $src = DATA_PATH . "/uploads/avatars/$size/";
            echo "<img src='" . $src . ( file_exists($_SERVER['DOCUMENT_ROOT'].$src.$id.".jpg") ? $id : "default" ) . ".jpg' alt='Avatar' />";
        }
    }
