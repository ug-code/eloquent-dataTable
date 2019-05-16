<?php

require "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Ugcode\EloquentDatatable\Datatable as Datatable;

$capsule = new Capsule;
$capsule->addConnection([
    "driver"         => "mysql",
    "host"           => "127.0.0.1",
    "database"       => "",
    "username"       => "root",
    "password"       => "",
    'charset'        => 'utf8',//'utf8mb4',
    'collation'      => 'utf8_general_ci',//'utf8mb4_unicode_ci'
    'prefix'         => '',
    'prefix_indexes' => true,
    'strict'         => false,
    'engine'         => null,

]);

//Make this Capsule instance available globally.
$capsule->setAsGlobal();
// Setup the Eloquent ORM.
$capsule->bootEloquent();

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Eloquent
{
    use SoftDeletes;
    protected $fillable
                          = [
            'user_id',
            'email',
            'surname',
            'username'
        ];
    protected $table      = 'users';
    protected $primaryKey = 'user_id';


}

class Employees extends Eloquent
{
    use SoftDeletes;
    protected $fillable
        = [
            'employee_id',
            'employee_name_surname',
            'employee_tckn',
            'employee_phone_number',
            'employee_email',
            'employee_iban'
        ];

    protected $table      = 'employees';
    protected $primaryKey = 'employee_id';

    public function users()
    {
        return $this->hasOne(Users::class,  'user_id','created_by');
    }
}

header('Content-Type: application/json');

$employees = new Employees;
$db        = $employees->with(['users']);

//print_r((array_keys((array)$db->getEagerLoads()['users'])));
//print_r($db->toSql());die();

//print_r($db->get()->toArray());
//die();
$x         = Datatable::make($db);
// print_r ($x);
echo json_encode($x);
