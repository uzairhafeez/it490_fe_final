<?php
function html_table($data = array())
{
    $rows = array();
    foreach ($data as $row) {
        $cells = array();
        foreach ($row as $cell) {
            $cells[] = "<td>{$cell}</td>";
        }
        $rows[] = "<tr>" . implode('', $cells) . "</tr>";
    }
    return "<table class='hci-table'>" . implode('', $rows) . "</table>";
}
$data = array(
    array('genericName' => 'GGGGG', 'id' => 'aaaaa', 'status' => 'test')
    );
echo html_table($data);
