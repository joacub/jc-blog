<?php

namespace JcBlog\Controller;

use AtAdmin\Controller\AbstractDataGridController;

class Admin_PostController extends AbstractDataGridController
{
	/**
	 * @return array|mixed|object
	 */
	public function getGridManager()
	{
		return $this->getServiceLocator()->get('jcblog_grid_manager');
	}
	
    
}