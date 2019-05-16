<?php

namespace Ugcode\EloquentDatatable;


class Datatable
{
    public static $request;
    /** @var \Illuminate\Database\Eloquent\Builder $query */
    public static $query;
    public static $records_total;
    public static $records_filtered;
    public static $debug = true;

    static function make($model)
    {
        self::$request = $_REQUEST;
        self::$query   = $model;
        self::setRecordsTotal();
        self::filter();
        self::setRecordsFiltered();
        self::order();
        self::limit();

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
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                foreach (self::$request['columns'] as $column) {
                    if ($column['searchable'] == 'true') {

                        if (self::isWithRelation($column)) {
                            $rel = self::isWithRelation($column);
                            $query->whereHas($rel[0], function($q) use ($column) {
                                /** @var \Illuminate\Database\Eloquent\Builder $q */
                                $q->orWhere($column['name'], 'like', '%' . self::$request['search']['value'] . '%');
                            });

                        } else {
                            $query->orWhere($column['name'], 'like', '%' . self::$request['search']['value'] . '%');


                        }


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


    static function order()
    {
        $dt_order_column = self::$request['order'][0]['column'];
        $dt_columns      = self::$request['columns'][$dt_order_column];
        $dt_field        = $dt_columns['name'] ? $dt_columns['name'] : $dt_columns['data'];


        $dt_direction = self::$request['order'][0]['dir'];


        self::$query->orderBy($dt_field, $dt_direction);
    }

    static function isWithRelation($column)
    {
        $explode = explode('.', $column['data']);
        if (isset($explode[1])) {
            return in_array($explode[0], self::getRealationList(), true) ? $explode : false;

        }

        return false;
    }

    // apply order by & limit
    static function limit()
    {

        self::$query->skip(self::$request['start'])
                    ->take(self::$request['length']);
    }

    static function getRealationList()
    {
        return (array_keys((array)self::$query->getEagerLoads()));

    }

    static function debug()
    {
        return true;
    }

    static function getSqlWithBinding($query)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $sql = $query->toSql();
        foreach ($query->getBindings() as $binding) {
            $value = is_numeric($binding) ? $binding : '\'' . $binding . '\'';
            $sql   = preg_replace('/\?/', $value, $sql, 1);
        }

        return $sql;
    }

    // render json output
    static function renderJson()
    {
        $array                    = [];
        $array['draw']            = self::$request['draw'];
        $array['recordsTotal']    = self::$records_total;
        $array['recordsFiltered'] = self::$records_filtered;
        $array['data']            = [];

        if (self::debug()) {
            $array['sql'] = self::getSqlWithBinding(self::$query);
        }
        //print_r(self::$query->toSql());die();

        $results = self::$query->get()
                               ->toArray();

        //                       ->toArray();

        // pr($results->toArray(), 1);
        //pr(self::$query->getBindings());
        //pr(self::$query->toSql(),1);
        foreach ($results as $result) {
            $array['data'][] = $result;
        }

        return ($array);
    }
}
