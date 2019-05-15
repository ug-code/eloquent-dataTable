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
    { "user_id": "users.user_id" },
    { "mail": "users.mail" },
    { "address": "profiles.address" },
  ]
} )
});
```
