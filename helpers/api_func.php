<?php



function respond_json($data, $status = 200)
{
  http_response_code($status);
  header('Content-Type: application/json');
  echo json_encode($data);
  exit;
}

function input_JSON()
{
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);
  if ($data === null) respond_json(['status' => 'error', 'message' => 'Invalid JSON'], 400);
  return $data;
}
