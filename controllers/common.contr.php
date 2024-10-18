<?php
require "../models/common.model.php";

class CommonContr extends Common
{
    private $commonModel;
    public function __construct(Common $commonModel)
    {
        $this->commonModel = $commonModel;
    }
    public function generatePassword($charLen)
    {
        $common = new Common;
        $fetch = $common->createPassword($charLen);
        return $fetch;
    }

    public function viewRoles()
    {
        $common = new Common;
        $fetch = $common->getRoles();
        return $fetch;
    }
}
