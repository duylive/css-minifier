<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minify & Combine CSS</title>
</head>
<body>
<div class="" style="text-align: center;color: green">
    <h1>Minify & Combine code CSS</h1>
</div>
<div class="" style="text-align: center;color: aqua">
    <h3>Paste URL file CSS below !</h3>
    <h3>If you want to combine code from multiple URls CSS, separate the URls by comma</h3>
</div>
<form action="" method="post" style="text-align: center;">
    <div class="input" style="padding-bottom: 20px">
        <input type="text" name="input" id="input" size="100" placeholder="URL"
               value="<?php if (isset($_POST['input'])) {
                   echo $_POST['input'];
               } ?>">
    </div>
    <input id="minifyCSS" name="minifyCSS" class="minifyCSS" type="submit" value="Minify CSS">
</form>
<div class="" style="padding-top: 20px"></div>
<div class="" style="text-align: center;color: aqua">
    <h3>Result:</h3>
</div>
<hr>
<div class="output" style="padding-top: 20px;text-align: center;">
    <textarea name="output" id="output" cols="100" rows="50" placeholder="output">
<?php
// setup the URL and read the CSS from a file
$arrays = explode(',', $_POST['input']);
$url = 'https://cssminifier.com/raw';
foreach ($arrays as $array) {
    $css = file_get_contents($array);

// init the request, set various options, and send it
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
        CURLOPT_POSTFIELDS => http_build_query(["input" => $css])
    ]);

    $minified = curl_exec($ch);

// finally, close the request
    curl_close($ch);

// output the $minified css
//    echo $minified;

    $path = parse_url($_POST['input']);
    $name = $path['path'];
    $base = pathinfo($name);
    $dir = $base['dirname'];
    $newDir = substr($dir, 1);
    if (!is_dir($newDir)) {
        mkdir($newDir, 0700, true);
    }
    $newName = $base['filename'] . '.' . 'css';
    $newFile = fopen($newDir . '/' . $newName, 'w');
    fwrite($newFile, $minified);
    fclose($newFile);
}
?>
    </textarea>
</div>
</body>
</html>
