<?php

namespace JcBlog\Grid;

use AtDataGrid\DataGrid\Filter\Sql as SqlFilter;
use AtDataGrid\DataGrid\DataGrid;

class Post extends DataGrid
{
    public function init()
    {
        parent::init();
        
        $columns = $this->getColumns();
        
        //las oculto todas de golpe
        foreach($columns as $column) {
            $column->setVisible(false);
        }
        
        $this->setTitleColumnName($this->getColumn('title'));
        
        
        $this->getColumn('created_at')
        ->setVisible(false)
        ->setVisibleInForm(false)
        ->setLabel('Fecha de creación')
        ->setSortable(true);
        
        // uri
        $this->getColumn('slug')
        ->setVisible(true)
             ->setLabel('Url')
             ->addFilter(new SqlFilter\Like())
             ->setSortable(true);
        
        $this->getColumn('title')
        ->setVisible(true)
        ->setLabel('Titulo')
        ->addFilter(new SqlFilter\Like())
        ->setSortable(true);
        
        $content = $this->getColumn('content');
        $content->getFormElement()->setOptions(array('ckeditor' => array()) + $content->getFormElement()->getOptions());
        
   }
}