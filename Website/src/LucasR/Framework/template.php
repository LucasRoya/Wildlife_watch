<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $this->parts['title']; ?></title>
        <!-- Imports zone (Bootstrap) -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="skin/style.css" rel="stylesheet">

        <script src="script/script.js"></script> 
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNFHppa9XdJedGjzvXLIvOlVOMFf-aF2E&libraries=visualization"></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-sm bg-dark">
                <div class="container-fluid">
                    <?php
                    foreach($this->parts['header'] as $elem){
                        echo $elem;
                    }
                    ?>
                </div>
            </nav>
        </header>
        <main>
            <div class="container-fluid text-center">
                <?php
                foreach($this->parts['content'] as $item){
                    echo $item;
                }
                ?>
            </div>
        </main>
        <footer class="footer">
            <?php
            echo $this->parts['footer'];
            ?>
        </footer>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>