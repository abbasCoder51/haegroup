<!DOCTYPE html><html>
<head><meta charset="UTF-8"></head>

<style type="text/css">
    <?php
    print file_get_contents(__DIR__ . '/css/style.css');
    ?>
</style>
<body>

<?php
require ( __DIR__ . "/dbconnect.php");
require ( __DIR__ . "/queryString.php");

if($result) {
    foreach ($row as $value) {
        echo "<table class='haegroup-content'><tr>";
        echo "<th><b>ID:</b> " . htmlentities($value["ID"]) . "</th>"
            . "<th><b>Title:</b> " . htmlentities($value["post_title"]) . "</th>"
            . "<th><b>Type:</b> " . htmlentities($value["post_type"]) . "</th>"
            .  "<th><b>Link:</b> " . htmlentities($value["guid"]) . "</th></tr>";

        $content = $value["post_content"];

        // html
        $content = preg_replace(['@<[^/][^<]+?/>@', '@</.+?>@', '@<[^/][^<]+?>@'], '{{{span class="html-tag"}}}$0{{{/span}}}', $content);

        // shortcode
        $content = preg_replace(['@\[[^/][^\[]+?/]@', '@\[/.+?\]@', '@\[[^/][^\[]+?\]@'], '{{{span class="shortcode-tag"}}}$0{{{/span}}}', $content);

        // clean up
        $content = htmlentities($content, ENT_IGNORE);

        $content = str_replace(['{{{', '}}}'], ['<', '>'], $content);

        $content = nl2br($content);

        echo "<tr><td colspan='4'><b>Content:</b><br/>" . $content . "</td></tr>";
        echo "</table>";
    }
}

$conn = null;
?>

</body>
</html>