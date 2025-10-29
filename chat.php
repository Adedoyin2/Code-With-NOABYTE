<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$message = $data["message"] ?? "";

$apiKey = "sk-e06100f22c1b420cb891b97d99970a31"; <!----------- Insert Deepseek API -------->

$payload = json_encode([
  "model" => "deepseek-chat",
  "messages" => [
    ["role" => "system", "content" => "You are a helpful assistant."],
    ["role" => "user", "content" => $message]
  ],
  "temperature" => 0.7
]);
<!----------------------------------- Deepseek API ---------------------------------->
$ch = curl_init("https://api.deepseek.com/v1/chat/completions"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Authorization: Bearer $apiKey",
  "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);
<!----------------------------------- NOTIFICATION ---------------------------------->
$responseData = json_decode($response, true);
$reply = $responseData["choices"][0]["message"]["content"] ?? "No response from NOABYTE right now.";

echo json_encode(["reply" => $reply]);
?>
