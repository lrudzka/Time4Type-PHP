<?php

class NewPassword {
    public function setNewPassword()  {
       $newPass = "";
        for ($i=0; $i<10; $i++) {
            $newPass.=chr(rand(97,122));
        }
        return rand(100,999).$newPass.rand(1000,9999);
    }
}
