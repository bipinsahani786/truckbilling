<?php

use Illuminate\Support\Facades\DB;

$duplicates = DB::select("
    SELECT owner_id, name, MIN(id) as keep_id 
    FROM expense_categories 
    GROUP BY owner_id, name 
    HAVING COUNT(*) > 1
");

$removed = 0;
foreach($duplicates as $dup) {
    $deleted = DB::table('expense_categories')
        ->where('owner_id', $dup->owner_id)
        ->where('name', $dup->name)
        ->where('id', '!=', $dup->keep_id)
        ->delete();
    $removed += $deleted;
}

echo "Removed {$removed} duplicate expense categories.\n";

$duplicatesDealer = DB::select("
    SELECT pan_number, MIN(id) as keep_id 
    FROM dealers 
    WHERE pan_number IS NOT NULL AND pan_number != ''
    GROUP BY pan_number 
    HAVING COUNT(*) > 1
");

foreach($duplicatesDealer as $dup) {
    DB::table('dealers')
        ->where('pan_number', $dup->pan_number)
        ->where('id', '!=', $dup->keep_id)
        ->delete();
}

$duplicatesDealerGst = DB::select("
    SELECT gstin, MIN(id) as keep_id 
    FROM dealers 
    WHERE gstin IS NOT NULL AND gstin != ''
    GROUP BY gstin 
    HAVING COUNT(*) > 1
");

foreach($duplicatesDealerGst as $dup) {
    DB::table('dealers')
        ->where('gstin', $dup->gstin)
        ->where('id', '!=', $dup->keep_id)
        ->delete();
}

$duplicatesWallets = DB::select("
    SELECT driver_id, MIN(id) as keep_id 
    FROM wallets 
    GROUP BY driver_id 
    HAVING COUNT(*) > 1
");

foreach($duplicatesWallets as $dup) {
    DB::table('wallets')
        ->where('driver_id', $dup->driver_id)
        ->where('id', '!=', $dup->keep_id)
        ->delete();
}

echo "Done cleaning all duplicates.\n";

