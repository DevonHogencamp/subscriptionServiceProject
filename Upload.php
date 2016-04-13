<?php
    // Establish Connections and Sessions
    session_start();
    require_once ('Connect.php');
    $Success = false;

    if (@$_POST['Upload']) {
        $UserID = $_SESSION['UserID'];

        $Title = $_POST['Title'];
        $Artist = $_POST['Artist'];
        $Genre = $_POST['Genre'];

        $SongName = $_FILES['SongName'] ['name'];
        $SongSize = $_FILES['SongName'] ['size'];

        $AlbumName = $_FILES['AlbumName'] ['name'];
        $AlbumSize = $_FILES['AlbumName'] ['size'];

        if (!empty($Title) && !empty($Artist) && !empty($Genre) && !empty($SongName) && !empty($AlbumName)) {
            if (($SongSize < 10000000) && ($AlbumSize < 10000000)) {
                $SongPath = "Songs/$SongName";
                $AlbumPath = "Album/$AlbumName";

                if (move_uploaded_file($_FILES['SongName']['tmp_name'], $SongPath) && move_uploaded_file($_FILES['AlbumName']['tmp_name'], $AlbumPath)) {

                    $Query = $dbh->prepare("INSERT INTO Songs (SongID, Title, Artist, Genre, UserID, Date, SongName, AlbumName)
                    VALUES (:SongID, :Title, :Artist, :Genre, :UserID, NOW(), :SongName, :AlbumName)");

                    $Result = $Query->execute(
                        array(
                            'SongID' => 0,
                            'Title' => $Title,
                            'Artist' => $Artist,
                            'Genre' => $Genre,
                            'UserID' => $UserID,
                            'SongName' => $SongName,
                            'AlbumName' => $AlbumName
                        )
                    );

                    $Success = true;
                }

                else {
                    echo "BAD UPLOAD";
                }
            }

            else {
                echo "<p>File is to large</p>";
            }
        }

        else {
            echo "<p>Please fill out all of the fields</p>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="CSS/material.min.css">
        <script src="CSS/material.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="CSS/Stylesheet.css">
    </head>

    <body>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <a href="Index.php" style="text-decoration: none;">
                        <img src = "SiteImages/EDMTUBE.png" height="70px" width="110px"/>
                    </a>
                    <div class="mdl-layout-spacer"></div>
                    <nav class="mdl-navigation mdl-layout--large-screen-only">
                        <a class="mdl-navigation__link" href="SignIn.php">Sign In</a>
                        <a class="mdl-navigation__link" href="Upload.php">Upload</a>
                        <a class="mdl-navigation__link" href="User.php">User Name</a>
                    </nav>
                </div>
            </header>

            <div class="mdl-layout__drawer">
                <span class="mdl-layout-title">Genres</span>
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link" href="Electro.php">Electro</a>
                    <a class="mdl-navigation__link" href="Future.php">Future House</a>
                    <a class="mdl-navigation__link" href="Trap.php">Trap</a>
                    <a class="mdl-navigation__link" href="Dubstep.php">Dubstep</a>
                    <a class="mdl-navigation__link" href="Dance.php">Dance</a>
                    <a class="mdl-navigation__link" href="Rave.php">Rave</a>
                </nav>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <center>
                        <h1>Upload Your Own Music</h1>

                        <?php
                            if (!isset($_SESSION['SignIn'])) {
                                echo "<p>You must be signed in to upload music</p>";
                            }
                        ?>

                        <form enctype="multipart/form-data" method="post" class="Form" name="Upload">
                            <div class="mdl-textfield mdl-js-textfield">
                                <input class="mdl-textfield__input" type="text" name="Title">
                                <label class="mdl-textfield__label" for="sample1">Title</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield">
                                <input class="mdl-textfield__input" type="text" name="Artist">
                                <label class="mdl-textfield__label" for="sample1">Artist</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield">
                                <input class="mdl-textfield__input" type="text" name="Genre">
                                <label class="mdl-textfield__label" for="sample1">Genre</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield">
                                <input type="file" class="mdl-textfield__input" type="text" name="SongName" id="SongName">
                            </div>
                            <div class="mdl-textfield mdl-js-textfield">
                                <input type="file" class="mdl-textfield__input" type="text" name="AlbumName" id="AlbumName">
                            </div>
                            <center>
                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit" name="Upload" value="Add">Upload</button>
                            </center>
                        </form>

                        <p>
                            <?php
                                if ($Success == true) {
                                    echo "You have successfully uploaded your song";
                                }
                            ?>
                        </p>
                    </center>


                    <footer class="mdl-mini-footer" style="position: fixed; bottom: 0; width: 100%;">
                        <div class="mdl-mini-footer__left-section">
                            <div class="mdl-logo">EDM Tube</div>
                            <ul class="mdl-mini-footer__link-list">
                                <li>
                                    <a href = "SignIn.php">Sign In</a>
                                </li>
                                <li>
                                    <a href = "Upload.php">Upload</a>
                                </li>
                                <li>
                                    <a href = "Admin.php">Admin Page</a>
                                </li>
                                <li>EDM Central&copy;</li>
                            </ul>
                        </div>
                    </footer>
                </div>
            </main>
        </div>
    </body>
</html>
