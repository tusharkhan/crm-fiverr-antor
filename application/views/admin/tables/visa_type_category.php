<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 11/3/2023
 */


defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['name', 'active', 'created_at', 'id'];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'visa_type_category';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $ind => $aRow) {
    $row = [];
    $row[] = $ind + 1;
    $row[] = '<a href="#" data-toggle="modal" data-target="#customer_group_modal" data-id="' . $aRow['id'] . '">' . $aRow['name'] . '</a>';

    $activeStatus = '<span class="badge badge-'. (($aRow['active'] == 1) ? 'primary' : 'danger') .'">';
    $activeStatus .= ($aRow['active'] == 1) ? _l('leads_email_active') : _l('inactive');
    $activeStatus .= '</span>';


    $createdAt = date('Y-m-d', strtotime($aRow['created_at']));

    $row[] = $activeStatus;
    $row[] = $createdAt;

    $output['aaData'][] = $row;
}
