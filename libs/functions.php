<?php
/**
 * All the yield sections
 */
$sections = [];
/**
 * Get the last part of the URL
 * @return string Last part of the URL
 */
function getLUrl () : string {
    $url = $_SERVER['REQUEST_URI'];
    if (strpos($url, '?') !== false) {
        $url = explode('?', $url);
        $url = $url[0];
    }
    if (strpos($url, '/') !== false) {
        $url = explode('/', $url);
        $url = array_filter($url);
        $url = array_values($url);
        if (count($url) > 1) {
            $url = $url[count($url) - 1];
        } else {
            $url = "";
        }
    } 
    if (strpos($url, '.') !== false) {
        $url = explode('.', $url);
        $url = $url[0];
    }
    return $url;
}
/**
 * Get the URL
 * @return string URL
 */
function getUrl () : string {
    $main = $_SERVER['REQUEST_URI'];
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $url = str_replace(SUBDIR != "" ? SUBDIR . "/" : "", "", $main);
    } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $post = arrayEscapeSecurity($_POST);
        $url = str_replace(SUBDIR != "" ? SUBDIR . "/" : "", "", $main);
        foreach ($post as $value) {
            $url .= '/' . $value;
        }
    }
    return $url;
}
/**
 * Array escape security
 * @param array $arr Array to escape
 * @return array Escaped array
 */
function arrayEscapeSecurity(array $arr): array {
    $newArr = [];
    foreach ($arr as $key => $value) {
        $newArr[$key] = htmlspecialchars($value);
    }
    return $newArr;
}
/**
 * Get the Asset URL
 * @param string $asset_dir Asset directory
 * @return string URL
 */
function asset(string $asset_dir) : string {
    return PROTOCOL . SITE_ROOT . '/public/' . $asset_dir . (DEBUG ? "?v=" . time() : "");
}
/**
 * Extend a layout
 * @param string $layout_file Layout file
 * @return string Extended content
 */
function ext($layout_file) : void {
    $actual_file = str_replace(".", "/", $layout_file);
    $actual_file = __DIR__ . '/../' . $actual_file . ".zisunal.php";  
    if (file_exists($actual_file)) {
        $file_content = file_get_contents($actual_file);
        $engine = new App\Core\ZisunalEngine();
        $file_content = $engine->filterContent($file_content);
        $render_content = eval("?>" . $file_content);
        echo $render_content;
    } else {
        throw new \Exception("File not found: " . $actual_file);
    }  
}
/**
 * Get the list of themes
 * @return array List of themes
 */
function getThemes() : array {
    $all_themes = [];
    $theme_parser = new App\Core\ThemeParser();
    $themes = scandir($theme_parser->theme_dir);
    foreach ($themes as $theme) {
        if ($theme != "." && $theme != "..") {
            $theme_parser->parse($theme);
            $all_themes[] = [
                "name" => $theme_parser->theme_name,
                "uri" => $theme_parser->theme_uri,
                "author" => $theme_parser->author,
                "author_uri" => $theme_parser->author_uri,
                "description" => $theme_parser->description,
                "version" => $theme_parser->version,
                "license" => $theme_parser->license,
                "license_uri" => $theme_parser->license_uri,
                "text_domain" => $theme_parser->text_domain,
                "tags" => $theme_parser->tags
            ];
            if (file_exists($theme_parser->theme_dir . $theme . "/preview.png")) {
                $all_themes[count($all_themes) - 1]["preview"] = str_replace('/public/', '', asset('/contents/themes/' . $theme . "/preview.png"));
            } else {
                $all_themes[count($all_themes) - 1]["preview"] = "";
            }
        }
    }
    return $all_themes;
}