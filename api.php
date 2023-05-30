<?php

// 加载历史事件数据
$events = json_decode(file_get_contents('history_in_today.json'), true);

// 获取请求参数中的类型、月份和日期
$type = $_GET['type'] ?? null;
$month = $_GET['month'] ?? null;
$day = $_GET['day'] ?? null;

// 获取分页参数中的每页返回事件数量和页码
$page_size = $_GET['page_size'] ?? 20;
$page_number = $_GET['page_number'] ?? 1;

// 根据请求参数过滤历史事件列表
if ($type !== null) {
    $events = array_filter($events, function($event) use ($type) {
        return $event['type'] == $type;
    });
}
if ($month !== null) {
    $events = array_filter($events, function($event) use ($month) {
        return $event['month'] == $month;
    });
}
if ($day !== null) {
    $events = array_filter($events, function($event) use ($day) {
        return $event['day'] == $day;
    });
}

// 对历史事件列表进行分页处理
$total = count($events);
$start = ($page_number - 1) * $page_size;
$end = $start + $page_size - 1;
$events = array_slice($events, $start, $page_size);

// 设置响应头，指定返回的数据格式为JSON
header('Content-Type: application/json');

// 将历史事件列表转换成JSON字符串并输出到客户端
echo json_encode([
    'total' => $total,
    'events' => $events
]);
