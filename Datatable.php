<?php

namespace Libraries\Helper;

use App\Models\ModelBase;

class Datatable
{
    public static $request;
    /** @var ModelBase */
    public static $query;
    public static $records_total;
    public static $records_filtered;

    static function make($model)
    {
        self::$request = $_POST;
        /** @var $model ModelBase */
        self::$query = $model;

        self::setRecordsTotal();
        self::filter();
        self::setRecordsFiltered();
        self::orderLimit();

        return self::renderJson();
    }

    // set total record count
    static function setRecordsTotal()
    {
        self::$records_total = self::$query->count();
    }

    // filter by search query
    static function filter()
    {
        if (!empty(self::$request['search']['value'])) {
            self::$query->where(function($query) {
                foreach (self::$request['columns'] as $column) {
                    if ($column['searchable'] == 'true') {
                        /** @var ModelBase $query */
                        $query->orWhere($column['name'], 'like', '%' . self::$request['search']['value'] . '%');
                    }
                }
            });
        }
    }

    // set filtered record count
    static function setRecordsFiltered()
    {
        self::$records_filtered = self::$query->count();
    }

    // apply order by & limit
    static function orderLimit()
    {
        self::$query->orderBy(self::$request['columns'][self::$request['order'][0]['column']]['name'], self::$request['order'][0]['dir']);
        self::$query->skip(self::$request['start'])
                    ->take(self::$request['length']);
    }


    // render json output
    static function renderJson()
    {
        $array                    = [];
        $array['draw']            = self::$request['draw'];
        $array['recordsTotal']    = self::$records_total;
        $array['recordsFiltered'] = self::$records_filtered;
        $array['data']            = [];

       // pr(self::$query->toSql(), 1);

        $results = self::$query->get();
       // pr($results->toArray(), 1);
        //pr(self::$query->getBindings());
        //pr(self::$query->toSql(),1);
        foreach ($results as $result) {
            $array['data'][] = $result;
        }

        return ($array);
    }
}
