<?php

namespace JcBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Admin_IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}