<?php

    // ===================================================================================
    //
    // SQL TABLES FUNCTIONS
    //
    //====================================================================================

    // All data from a table function
    if ( ! function_exists('dbTable')) {
        function dbTable($type, $table) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table");
            $stmt->execute();
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with a WHERE condtion function
    if ( ! function_exists('dbTableW')) {
        function dbTableW($type, $table, $column, $match) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column=:match");
            $stmt->execute(['match'=>$match]);
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with a WHERE condtion function
    if ( ! function_exists('dbTableWO')) {
        function dbTableWO($type, $table, $column, $match, $order) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column=:match ORDER BY $order");
            $stmt->execute(['match'=>$match]);
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with a WHERE condtion function
    if ( ! function_exists('dbTableWOL1')) {
        function dbTableWOL1($type, $table, $column, $match, $order, $L1) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column=:match ORDER BY $order LIMIT $L1");
            $stmt->execute(['match'=>$match]);
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with a WHERE condtion function
    if ( ! function_exists('dbTableWOL1L2')) {
        function dbTableWOL1L2($type, $table, $column, $match, $order, $L1, $L2) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column=:match ORDER BY $order LIMIT $L1,$L2");
            $stmt->execute(['match'=>$match]);
            return $stmt;

            $pdo->close();
        }
    }

    //Count / Give total
    if ( ! function_exists('countTotal')) {
        function countTotal($type, $table){ 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT COUNT($type) FROM $table");
            $stmt->execute();
            $table_rows = $stmt->fetch();
            $get_total = array_shift($table_rows); 
            
            return $get_total;
            $pdo->close();  
        }
    }

    //Count / Give total
    if ( ! function_exists('countTotalW')) {
        function countTotalW($type, $table, $column, $match){ 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT COUNT($type) FROM $table WHERE $column=:match");
            $stmt->execute(['match'=>$match]);
            $table_rows = $stmt->fetch();
            $get_total = array_shift($table_rows); 
            
            return $get_total;
            $pdo->close();  
        }
    }