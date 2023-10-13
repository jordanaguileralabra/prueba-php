<?php 
    function deleteMessage(){
        $borrado = false;

        if(isset( $_SESSION['error_save'])){
            $_SESSION['error_save'] = null;
            $borrado = $_SESSION['error_save']; 
            $borrado = session_unset();
        }

        if(isset( $_SESSION['success_save'])){
            $_SESSION['success_save'] = null;
            $borrado = $_SESSION['success_save']; 
            $borrado = session_unset();
        }
        return $borrado;
    }
?>