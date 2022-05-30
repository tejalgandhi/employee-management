<?php

function get_employee_no()
{
    $no = 1000;
    $emp = \App\Models\Employee::latest()->first();
    if (!empty($emp) && !empty($emp->employee_no)) {
        $no = $emp->employee_no + 1;
    }
    return $no;
}