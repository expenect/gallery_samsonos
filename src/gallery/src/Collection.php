<?php
namespace gallery;

use samsonos\cms\collection\Generic;

class Collection extends Generic
{
    protected $sorter;

    protected $currentPage;

    protected $direction;

    protected $pagesize;

    protected $indexView = 'www/list';

    protected $itemView = 'www/items';

    public $pager;

    public function __construct($renderer, $sorter, $direction, \samson\pager\Pager $pager, $currentPage)
    {
        parent::__construct($renderer);

        $this->sorter = $sorter;
        $this->direction = $direction;
        $this->pager = & $pager;
        $this->currentPage = $currentPage;

        $this->fill();
    }

    public function renderItem($item)
    {
        return $this->renderer
            ->view($this->itemView)
            ->img($item)
            ->sorter($this->sorter)
            ->direction($this->direction)
            ->currentPage($this->currentPage)
            ->output();
    }

    public function fill()
    {
        $query = dbQuery('gallery\Img');

        $this->pager->update($query->count());

        $query->order_by($this->sorter, $this->direction)->limit($this->pager->start, $this->pager->end);

        $this->query = $query;

        return $this->collection = $query->exec();
    }
}