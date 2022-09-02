<?php
$setups = \Spatie\Permission\Models\Permission::where('type', 'setup')->get();
$items = \Spatie\Permission\Models\Permission::where('type', 'item')->get();
$suppliers = \Spatie\Permission\Models\Permission::where('type', 'supplier')->get();
$customers = \Spatie\Permission\Models\Permission::where('type', 'customer')->get();
$purchases = \Spatie\Permission\Models\Permission::where('type', 'purchase')->get();
$grns = \Spatie\Permission\Models\Permission::where('type', 'grn')->get();
$purchasepayments = \Spatie\Permission\Models\Permission::where('type', 'purchase_pay')->get();
$credits = \Spatie\Permission\Models\Permission::where('type', 'credit')->get();
$invoices = \Spatie\Permission\Models\Permission::where('type', 'invoice')->get();
$cashdrawer = \Spatie\Permission\Models\Permission::where('type', 'cashdrawer')->get();
$users = \Spatie\Permission\Models\Permission::where('type', 'user')->get();
?>