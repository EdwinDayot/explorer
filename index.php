<?php
    
    $start = microtime(true);
    define('NAME', 'Edwin Dayot');
    define('FOLDER', 'explorer/');
    $dirname = 'public/';
    $thumbs = array(
        'CV',
        'Template-Correction - TP4'
        );

    $language = 'fr';

    $en = array(
        'refresh'       => 'Refresh',
        'foldercontent' => 'Content of folder',
        'folder'        => 'Folder',
        'file'          => 'File',
        'tablecontent'  => 'Content of table',
        'server'        => 'Server',
        'client'        => 'Client',
        'loadtime'      => 'Loaded in',
        'seconds'       => 'seconds'
        );

    $fr = array(
        'refresh'       => 'Actualiser',
        'foldercontent' => 'Contenu du dossier',
        'folder'        => 'Dossier',
        'file'          => 'Fichier',
        'tablecontent'  => 'Contenu du tableau',
        'server'        => 'Serveur',
        'client'        => 'Client',
        'loadtime'      => 'Chargé en',
        'seconds'       => 'secondes'
        );

    $lang = ${$language};

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo NAME; ?></title>
        <link rel="stylesheet" href="<?php echo FOLDER ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo FOLDER ?>css/rewrite.css">
        <style>

            body{
                padding-top: 70px;
            }

        </style>
        <script type="text/javascript">

            var start = (new Date()).getTime();

        </script>
    </head>
    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container" id="nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand"><?php echo NAME; ?></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="#server">Server</a></li>
                        <li><a href="#session">Session</a></li>
                        <li><a href="#cookie">Cookie</a></li>
                    </ul>
                    <form class="navbar-form navbar-left">
                      <button type="button" data-toggle="modal" data-target="#phpinfo" class="btn btn-default">phpinfo()</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="http://ns366377.ovh.net/phpMyAdmin">phpMyAdmin</a></li>
                        <li><a href="<?php $_SERVER['PHP_SELF'] ?>"><?php echo $lang['refresh'] ?> <span class="glyphicon glyphicon-refresh"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="phpinfo" tabindex="-1" role="dialog" aria-labelledby="phpinfoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><a href="<?php echo FOLDER ?>mods/phpinfo.php">phpinfo()</a></h4>
                    </div>
                    <div class="modal-body">
                        <iframe src="<?php echo FOLDER ?>mods/phpinfo.php" frameborder="0" width="100%" height="1080px"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <?php foreach ($thumbs as $key => $value): ?>
                    <div class="col-md-6">
                        <a href="<?php echo $dirname . $value; ?>" class="thumbnail">
                            <img src="<?php echo FOLDER ?>img/thumb<?php echo $key + 1; ?>.jpg" alt="">
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="container" id="home">

            <?php

                if (!file_exists($dirname)) {
                    $dirname = './';
                }

                try {
                    $dir = opendir($dirname);
                } catch (Exception $e) {
                    die($e->getMessage());
                }

                $files = array();
                $folders = array();

                while ($element = readdir($dir)) {
                    if ($element != '.' && $element != '..') {
                        if (!is_dir($dirname . '/' . $element)) {
                            $files[] = $element;
                        } else {
                            $folders[] = $element;
                        }
                    }
                }

                closedir($dir);
            ?>

            <ol class="breadcrumb">
                <li class="active"><?php echo $lang['foldercontent'] ?> <code><?php echo dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $dirname; ?></code></li>
            </ol>

            <div class="list-group">
            <?php

                if (!empty($folders)) {
                    sort($folders);

                    foreach ($folders as $folder) {
                        echo '<a href="' . $dirname . $folder . '" class="list-group-item"><span class="glyphicon glyphicon-folder-open"></span> ' . $folder . '</a>';
                    }
                }

                if (!empty($files)) {
                    sort($files);

                    foreach ($files as $file) {
                        echo '<a href="' . $dirname . $file . '" class="list-group-item"><span class="glyphicon glyphicon-file"></span> ' . $file . '</a>';
                    }
                }

                $folders = count($folders);
                $files = count($files);
                $count = $folders + $files;

                if ($folders == 0) {
                    $folder = 1;
                } else {
                    $folder = $folders;
                }

                if ($files == 0) {
                    $file = 1;
                } else {
                    $file = $files;
                }

                $percentfiles = ($files * 100) / $count;
                $percentfolders = 100 - $percentfiles;

            ?>
            </div>
            <table class="table">
                <thead>
                    <th><?php echo $lang['folder'] ?><?php echo $folders > 1 ? 's' : ''; ?></th>
                    <th><?php echo $lang['file'] ?><?php echo $files > 1 ? 's' : ''; ?></th>
                </thead>
                <tbody>
                    <td><span class="label label-primary"><?php echo $folders; ?></span></td>
                    <td><span class="label label-warning"><?php echo $files; ?></span></td>
                </tbody>
            </table>

            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percentfolders ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentfolders ?>%;">
                    <span class="sr-only"><?php echo $percentfolders ?>%</span>
                </div>
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $percentfiles ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentfiles ?>%;">
                    <span class="sr-only"><?php echo $percentfiles ?>%</span>
                </div>
            </div>
        </div>

        <div class="container" id="server">
            <ol class="breadcrumb">
                <li class="active"><?php echo $lang['tablecontent'] ?> <code>$_SERVER</code></li>
                <span class="badge pull-right"><?php echo count($_SERVER); ?></span>
            </ol>
            <pre><?php print_r($_SERVER); ?></pre>
        </div>

        <div class="container" id="session">
            <?php if (isset($_SESSION)): ?>
                <ol class="breadcrumb">
                    <li class="active"><?php echo $lang['tablecontent'] ?> <code>$_SESSION</code></li>
                    <span class="badge pull-right"><?php echo count($_SESSION); ?></span>
                </ol>
                <pre><?php print_r($_SESSION); ?></pre>
            <?php endif ?>
        </div>

        <div class="container" id="cookie">
            <?php if (isset($_COOKIE)): ?>
                <ol class="breadcrumb">
                    <li class="active"><?php echo $lang['tablecontent'] ?> <code>$_COOKIE</code></li>
                    <span class="badge pull-right"><?php echo count($_COOKIE); ?></span>
                </ol>
                <pre><?php print_r($_COOKIE); ?></pre>
            <?php endif ?>
        </div>
        <div class="footer">
            <div class="container">
                <span class="text-muted credit"><?php echo $lang['server'] ?> : <?php echo $lang['loadtime'] ?> 
                    <a href="#"><?php echo round(microtime(true) - $start,4) ?></a> 
                    <?php echo $lang['seconds'] ?>.
                </span>
                <span class="text-muted credit pull-right">
                    <?php echo $lang['client'] ?> : <?php echo $lang['loadtime'] ?> <a href="#"><span id="load"></span></a> <?php echo $lang['seconds'] ?>.
                </span>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="explorer/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        var end = (new Date()).getTime();
        var diff = (end - start)/1000;

        document.getElementById('load').innerHTML = diff;



    </script>
</html>