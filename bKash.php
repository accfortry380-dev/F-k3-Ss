<?php
// api.php
// PHP (GD + FreeType) required. Place fonts and ss.jpg in same directory (or adjust paths).

// output as PNG
header('Content-Type: image/png');

// Simple helper to safely get a GET param and trim it
function get_param($name, $default = '') {
    return isset($_GET[$name]) ? trim(htmlspecialchars($_GET[$name], ENT_QUOTES, 'UTF-8')) : $default;
}

// Fetch params
$number = get_param('number', '01986833907');
$transactionId = get_param('transaction', '730MGQG6GH');

// amount may be numeric; allow commas/dots — normalize to float
$amount_raw = get_param('amount', '10000');
$amount_numeric = floatval(str_replace(',', '', $amount_raw)); // fallback to 0.0 if not numeric
if ($amount_numeric <= 0) {
    // keep default if nonsense provided
    $amount_numeric = 10000.0;
}

// total: if you want total different from amount, allow GET param 'total'; otherwise use amount
$total_raw = get_param('total', $amount_raw);
$total_numeric = floatval(str_replace(',', '', $total_raw));
if ($total_numeric <= 0) {
    $total_numeric = $amount_numeric;
}

// extra charge (you used +17 in code and also display +17.39 string). adjust here:
$extra = 17.39;
$totalWithExtra = $total_numeric + $extra;

// timezone and date/time
date_default_timezone_set('Asia/Dhaka');
$time = date('h:i A');         // e.g. 09:45 PM
$dayMonthYear = date('d/m/y'); // e.g. 14/11/25

// background image path
$bgPath = __DIR__ . '/ss.jpg';
if (file_exists($bgPath)) {
    $background = @imagecreatefromjpeg($bgPath);
} else {
    // create fallback blank canvas if ss.jpg missing
    $background = imagecreatetruecolor(1200, 2000);
    $white = imagecolorallocate($background, 255, 255, 255);
    imagefill($background, 0, 0, $white);
}

// colors
$black = imagecolorallocate($background, 90, 90, 90);
$black2 = imagecolorallocate($background, 80, 80, 80);

// fonts - ensure these TTF files exist in same dir or change paths
$font1 = __DIR__ . '/roboto.ttf';
$font2 = __DIR__ . '/roboto2.ttf';

// fallback: if fonts missing, use built-in fonts by using imagettftext only if font exists
if (!file_exists($font1)) $font1 = null;
if (!file_exists($font2)) $font2 = null;

// sizes
$fontSize = 50;
$fontSizeBold = 55;
$fontSizeBold2 = 60;
$trim = 47;

$imageWidth = imagesx($background);

// safe text to draw (format numbers nicely)
$display_amount = number_format($total_numeric, 2, '.', ',');           // e.g. 10,000.00
$display_total_with_extra = number_format($totalWithExtra, 2, '.', ','); // e.g. 10017.39

$textStyles = [
    'number1' => ['x' => 400, 'y' => 850, 'size' => $fontSizeBold, 'font' => $font1, 'color' => $black],
    'number2' => ['x' => 400, 'y' => 950, 'size' => $fontSizeBold, 'font' => $font2, 'color' => $black],
    'transactionId' => ['x' => $imageWidth - 384, 'y' => 1430, 'size' => $fontSizeBold2, 'font' => $font1, 'color' => $black, 'align' => 'right'],
    'total' => ['x' => 175, 'y' => 1880, 'size' => $fontSize, 'font' => $font2, 'color' => $black],
    'totalWithExtra' => ['x' => 170, 'y' => 1768, 'size' => $fontSize, 'font' => $font1, 'color' => $black2],
    'time' => ['x' => 135, 'y' => 1421, 'size' => $fontSize, 'font' => $font1, 'color' => $black],
    'dayMonthYear' => ['x' => 439, 'y' => 1420, 'size' => $fontSize, 'font' => $font1, 'color' => $black],
    'timeeee' => ['x' => 50, 'y' => 109, 'size' => $trim, 'font' => $font2, 'color' => $black],
];

$texts = [
    'number1' => $number,
    'number2' => $number,
    'transactionId' => $transactionId,
    'total' => $display_amount . ' +17.39', // kept as in original
    'totalWithExtra' => $display_total_with_extra,
    'time' => $time,
    'dayMonthYear' => $dayMonthYear,
    'timeeee' => $time
];

// renderer: use TTF when font available, otherwise use imagestring as fallback
foreach ($textStyles as $key => $style) {
    if (!isset($texts[$key])) continue;
    $text = $texts[$key];

    // choose renderer
    if (!empty($style['font']) && file_exists($style['font'])) {
        // right-align support
        if (isset($style['align']) && $style['align'] === 'right') {
            $bbox = imagettfbbox($style['size'], 0, $style['font'], $text);
            if ($bbox !== false) {
                $textWidth = abs($bbox[2] - $bbox[0]);
                $x = max(0, $style['x'] - $textWidth);
            } else {
                $x = $style['x'];
            }
        } else {
            $x = $style['x'];
        }
        imagettftext($background, $style['size'], 0, $x, $style['y'], $style['color'], $style['font'], $text);
    } else {
        // fallback to built-in font sizes (very rough)
        $fontIndex = 5; // built-in font (1-5)
        imagestring($background, $fontIndex, $style['x'], $style['y'] - 12, $text, $style['color']);
    }
}

// send PNG to client
imagepng($background);
imagedestroy($background);
exit;    'totalWithExtra' => ['x' => 170, 'y' => 1768, 'size' => $fontSize, 'font' => $Antik, 'color' => $black2],
    
    'time' => ['x' => 135, 'y' => 1421, 'size' => $fontSize, 'font' => $Antik, 'color' => $black],
    
    'dayMonthYear' => ['x' => 439, 'y' => 1420, 'size' => $fontSize, 'font' => $Antik, 'color' => $black],
    
    'timeeee' => ['x' => 50, 'y' => 109, 'size' => $trim, 'font' => $Antik2, 'color' => $black],
];

$texts = [
    'number1' => $number,
    'number2' => $number,
    'transactionId' => $transactionId,
    'total' => $total.' +17.39',
    'totalWithExtra' => $totalWithExtra,
    'time' => $time,
    'dayMonthYear' => $dayMonthYear,
    'timeeee' => $time
];

foreach ($textStyles as $key => $style) {
    if (isset($texts[$key])) {
        if (isset($style['align']) && $style['align'] == 'right') {
            $bbox = imagettfbbox($style['size'], 0, $style['font'], $texts[$key]);
            $textWidth = abs($bbox[2] - $bbox[0]);
            $x = $style['x'] - $textWidth;
        } else {
            $x = $style['x'];
        }
        imagettftext($background, $style['size'], 0, $x, $style['y'], $style['color'], $style['font'], $texts[$key]);
    }
}
imagepng($background);
imagedestroy($background);
?>
