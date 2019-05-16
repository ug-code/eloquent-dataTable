# eloquent-dataTable

## Usage

### Step 1: Install through composer
```composer require ug-code/eloquent-datatable```

### Step 2: Add DataTables javascript and set it up
For more information check out the [datatables manual](http://datatables.net/manual/index).
```javascript
var table = $('#example').DataTable({
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": "<url to datatable route>",
    "type": "POST"
  },
  "columns": [
    { data:"user_id": name:"users.user_id" },
    { data:"mail": name:"users.mail" },
    { data:"address": name:"profiles.address" },
  ]
} )
});
```
### Step 3: PHP 
```PHP
$db        =Profiles::with(['users']);
echo json_encode(Datatable::make($db));
```
