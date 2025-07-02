<?php
// JSONとして受け取る
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['image'])) {
    http_response_code(400);
    echo '画像データがありません';
    exit;
}

$imageData = $data['image'];
$userinfo = $data['userinfo'];

// "data:image/png;base64,..." を分離
if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
    $imageType = $matches[1]; // png, jpegなど
    $base64 = substr($imageData, strpos($imageData, ',') + 1);
    $base64 = base64_decode($base64);

    if ($base64 === false) {
        http_response_code(400);
        echo 'Base64デコードに失敗しました';
        exit;
    }

    $fileName = 'uploads/' . $userinfo . '.' . $imageType;
    file_put_contents($fileName, $base64);

    echo '画像保存完了: ' . $fileName;
} else {
    http_response_code(400);
    echo '画像データ形式が不正です';
}
?>
