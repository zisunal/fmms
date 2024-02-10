<?php
namespace App\Core;
/**
 * Theme parser
 * @package App\Core
 * @version 1.0.0
 * @since 1.0.0
 */
class ThemeParser {
    /**
     * @var string Theme directory
     */
    public string $theme_dir = __DIR__ . "/../../contents/themes/";
    /**
     * @var string Theme name
     */
    public string $theme_name;
    /**
     * @var string Theme URI
     */
    public string $theme_uri;
    /**
     * @var string Author
     */
    public string $author;
    /**
     * @var string Author URI
     */
    public string $author_uri;
    /**
     * @var string Description
     */
    public string $description;
    /**
     * @var string Version
     */
    public string $version;
    /**
     * @var string License
     */
    public string $license;
    /**
     * @var string License URI
     */
    public string $license_uri;
    /**
     * @var string Text domain
     */
    public string $text_domain;
    /**
     * @var string Tags
     */
    public string $tags;
    /**
     * Parse the theme
     * @param string $theme_dir Theme directory
     * @return array Theme data
     */
    public function parse(string $theme_dir) : void {
        if (file_exists($this->theme_dir . $theme_dir . "/" . $theme_dir . ".php")) {
            $theme = file_get_contents($this->theme_dir . $theme_dir . "/" . $theme_dir . ".php");
            $theme = explode("\n", $theme);
            foreach ($theme as $line) {
                if (strpos($line, "Theme Name:") !== false) {
                    $this->theme_name = str_replace("* Theme Name: ", "", $line);
                } else if (strpos($line, "Theme URI:") !== false) {
                    $this->theme_uri = str_replace("* Theme URI: ", "", $line);
                } else if (strpos($line, "Author:") !== false) {
                    $this->author = str_replace("* Author: ", "", $line);
                } else if (strpos($line, "Author URI:") !== false) {
                    $this->author_uri = str_replace("* Author URI: ", "", $line);
                } else if (strpos($line, "Description:") !== false) {
                    $this->description = str_replace("* Description: ", "", $line);
                } else if (strpos($line, "Version:") !== false) {
                    $this->version = str_replace("* Version: ", "", $line);
                } else if (strpos($line, "License:") !== false) {
                    $this->license = str_replace("* License: ", "", $line);
                } else if (strpos($line, "License URI:") !== false) {
                    $this->license_uri = str_replace("* License URI: ", "", $line);
                } else if (strpos($line, "Text Domain:") !== false) {
                    $this->text_domain = str_replace("* Text Domain: ", "", $line);
                } else if (strpos($line, "Tags:") !== false) {
                    $this->tags = str_replace("* Tags: ", "", $line);
                }
            }
        } else {
            throw new \Exception("Theme file not found");
        }
    }
}