<?php

namespace Markese\Datatables;
use Psr\Http\Message\ServerRequestInterface as Request;


class DTRequest
{
    public $sort;
    public $sortCol;
    public $sortDir;
    public $paginate;
    public $page;
    public $start;
    public $length;
    public $search;
    public $searchTerms;
    public $searchColumns;
    public $columns;
    public $draw;

    public function __construct(Request $request)
    {
        $request = (object)$request->getParams();

        $this->sort = !empty($request->columns[$request->order[0]['column']]);

        $col = $request->columns[$request->order[0]['column']];

        $this->sortCol = (!empty($col['name'])) ? $col['name'] : $col['data'];

        $this->sortDir = ($request->order[0]['dir'] === 'asc') ? 'asc' : 'desc';

        $this->paginate = (isset($request->start) && isset($request->length) && (int) $request->length !== -1);

        $this->page = ($this->paginate) ? ($request->start / $request->length) + 1 : 1;

        $this->start = $request->start;

        $this->length = $request->length;

        $this->draw = (int) $request->draw;

        $this->search = !empty($request->search['value']);

        $this->searchTerms = explode(" ", strtolower($request->search['value']));

        $this->columns = collect($request->columns)
            ->map(function ($col) {
                return !empty($col['name']) ? $col['name'] : $col['data'];
            });

        $this->searchColumns = collect($request->columns)
            ->filter(function($col){
                return $col['searchable'] === 'true';
            })
            ->map(function ($col) {
                return !empty($col['name']) ? $col['name'] : $col['data'];
            });
    }

}
