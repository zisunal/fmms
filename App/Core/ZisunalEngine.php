<?php
namespace App\Core;
/**
 * ZisunalEngine class is a template engine for fmms framework
 * @package App\Core
 * @version 1.0.0
 * @since 1.0.0
 */
class ZisunalEngine {
    /**
     * Render a zisunal file
     * @param string $zisunal_file
     * @param array $args
     * @return void
     */
    public function render(string $zisunal_file, ...$args) : void {
        $actual_file = str_replace(".", "/", $zisunal_file);
        $actual_file = __DIR__ . '/../../' . $actual_file . ".zisunal.php";
        try {
            if (file_exists($actual_file)) {
                $args = array_map(function($arg) {
                    return htmlspecialchars($arg);
                }, $args);
                
                $file_content = file_get_contents($actual_file);
                $file_content = $this->filterContent($file_content);
                
                $render_content = eval("?>" . $file_content);
                echo $render_content;
            } else {
                throw new \Exception("File not found: " . $actual_file);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function filterContent($file_content) : string {
        $file_content = str_replace("{{", "<?php echo htmlspecialchars(", $file_content);
        $file_content = str_replace("}}", "); ?>", $file_content);
        $file_content = str_replace("{!!", "<?php echo ", $file_content);
        $file_content = str_replace("!!}", "; ?>", $file_content);
        $file_content = preg_replace("/{{\s*(\w+)\s*}}/", "<?= htmlspecialchars($1) ?>", $file_content);
        $file_content = preg_replace("/{{\s*(\w+)\s*}}/", "<?= $1 ?>", $file_content);
        $file_content = preg_replace("/@if\((.*)\)/", "<?php if($1): ?>", $file_content);
        $file_content = preg_replace("/x@xxxxx/", "<?php else: ?>", $file_content);
        $file_content = preg_replace("/x@xxxxxx/", "<?php endif; ?>", $file_content);
        $file_content = preg_replace("/@foreach\((.*)\)/", "<?php foreach($1): ?>", $file_content);
        $file_content = preg_replace("/x@xxxxxxxxxxx/", "<?php endforeach; ?>", $file_content);
        $file_content = preg_replace("/@for\((.*)\)/", "<?php for($1): ?>", $file_content);
        $file_content = preg_replace("/x@xxxxxxxx/", "<?php endfor; ?>", $file_content);
        $file_content = preg_replace("/@while\((.*)\)/", "<?php while($1): ?>", $file_content);
        $file_content = preg_replace("/x@xxxxxxxxx/", "<?php endwhile; ?>", $file_content);
        $file_content = preg_replace("/@switch\((.*)\)/", "<?php switch($1): ?>", $file_content);
        $file_content = preg_replace("/x@xxxxxxxxxxxx/", "<?php endswitch; ?>", $file_content);
        $file_content = preg_replace("/@case\((.*)\)/", "<?php case $1: ?>", $file_content);
        $file_content = preg_replace("/x@xxxxxxxxxxxxx/", "<?php break; ?>", $file_content);
        $file_content = preg_replace("/x@xxxxxxxx/", "<?php default: ?>", $file_content);
        $file_content = preg_replace("/@extends\((.*)\)/", "<?php ext($1); ?>", $file_content);
        $file_content = preg_replace("/@include\((.*)\)/", "<?php include($1); ?>", $file_content);
        $file_content = preg_replace("/@component\((.*)\)/", "<?php component($1); ?>", $file_content);
        $file_content = preg_replace("/x@xxxxxxxxxxxxx/", "<?php endcomponent; ?>", $file_content);
        return $file_content;        
    }
}