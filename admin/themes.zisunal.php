@extends('admin.layout.header')
    <div class="zs-main__content__header">
        <h1>Themes</h1>
        <div class="hamburger">
            <div class="hamburger__line">
                <a href="./">admin</a>
            </div>
            <div class="hamburger__line">
                <a href="themes">themes</a>
            </div>
        </div>
    </div>
<?php
$themes = getThemes();
?>
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Preview</th>
                    <th>Author</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($themes as $theme) { ?>
                <tr>
                    <td>{{ $theme['name'] }}</td>
                    <td>
                    <?php 
                    if ($theme['preview']) {
                        echo "<img src='" . $theme['preview'] . "' alt='" . $theme['name'] . " theme preview'>";
                    } else {
                        echo "No Preview Available";
                    }
                    ?>
                    </td>
                    <td>{{ $theme['author'] }}</td>
                    <td>
                        <a href="javascript:;">Details</a>
                        <a href="edit-theme">Edit</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
@extends('admin.layout.footer')