<?php
include "config.php";

$filelist = array();
if ($handle = opendir("../wp-content/video_files")) {
    while ($entry = readdir($handle)) {
        if ($entry != '.' && $entry != '..')
            $filelist[$entry] = '/wp-content/video_files/' . $entry;
    }
    closedir($handle);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <title>Videos Admin</title>
</head>
<body>

<main>
    <section>
        <div id="dropzone">
            <form action="/api/uploader.php"
                  class="dropzone" method="post" enctype="multipart/form-data"
                  id="my-awesome-dropzone">
                <div class="fallback">
                    <input name="file" type="file"/>
                </div>
            </form>
            <div id="output" style="display: none;">
                This is the url for the video:
                <a href=""></a>
            </div>
            <div class="files-list" style="margin-top: 3rem;">
                <span>Uploaded Files:</span>
                <ul>
                    <?php foreach ($filelist as $file => $uri) { ?>
                        <li style="display: flex;">
                            <a href="<?= $uri ?>"><?= $file ?></a>
                            <a href="/api/uploader.php?delete=<?= $file ?>" style="margin-left: auto;"><small>Delete</small></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </section>
</main>

<script src="./js/dropzone.js"></script>
<script>
    const output = document.querySelector('#output');
    const link = output.querySelector('a');
    Dropzone.options.myAwesomeDropzone = {
        init: function () {
            this.on("success", function (file, res) {
                const data = JSON.parse(res);
                if (data && data.success) {
                    link.href = data.success;
                    link.innerHTML = window.location.hostname + data.success;
                    output.style.removeProperty('display');
                }
            });
        }
    };
</script>
</body>
</html>