<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use File;

class DataBaseBackupController extends Controller
{
  
    public function index()
    {
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        
        //dd($DbName);
        return view('backupandrestor.index', compact('mysqlHostName', 'mysqlUserName', 'mysqlPassword', 'DbName'));
    }
    public function Backup()
    {

        //ENTER THE RELEVANT INFO BELOW
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $backup_name        = "mybackup.sql";
        $tables             = array(
            "banks",
            "bank_names",
            "barcode_configarations",
            "barcode_details",
            "barcode_types",
            "branches",
            "card_payments",
            "cash_drawers",
            "cash_in_cash_outs",
            "categories", "cities",
            "companies",
            "countries",
            "customers",
            "customer_debts",
            "customer_documents",
            "customer_payment_recieves",
            "day_closes",
            "expenses",
            "expenses_types",
            "invoices",
            "invoice_details",
            "model_has_permissions",
            "model_has_roles",
            "multiselect_categories",
            "number_formats",
            "opening_stocks",
            "paypal_payments",
            "permissions",
            "products",
            "purchasedetails",
            "purchases",
            "purchase_payments",
            "purchase_recieveds",
            "purchase_returns",
            "purchase_return_details",
            "requriment_files",
            "roles",
            "role_has_permissions",
            "sale_configs",
            "sale_returns",
            "sale_return_details",
            "states",
            "subcategories",
            "subscriptions",
            "subscription_items",
            "suppliers",
            "supplier_debts",
            "supplier_documents",
            "supplier_payments",
            "units",
            "users",
            "user_types",
            "vat_collections",
            "vat_payments",
            "vat_settings",
            "wastages",
            "wastage_details"
        ); //here your tables...

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();


        $output = '';
        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach ($show_table_result as $show_table_row) {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for ($count = 0; $count < $total_row; $count++) {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
        unlink($file_name);
    }

    public function restore()
    {
        return view('backupandrestor.restore');
    }
    public function Backuprestore(Request $request)
    {

        /* 
        dd($filename); */
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $templine = '';
        // Read in entire file
        /*  if ($request->hasFile('database_file')) { */
        $lines = $request->File('database_file');
        /* dd($lines); */
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                $statement = $connect->prepare($templine);
                $statement->execute();
                $templine = '';
            }
        }
        Session()->flash('success', 'Tables imported successfully');
        return redirect()->Route('database.restore');
        /*   } else {
           
        } */
        /*  Session()->flash('error', 'Faild To Import Sql file');
        return redirect()->Route('database.restore'); */
    }
}
