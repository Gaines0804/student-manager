<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
	<?php include './view/header.php' ?>
    <div class="container">
        <div class="row">
			<?php include './view/left.php' ?>

            <div class="col-lg-9">
                <div class="jumbotron">
                    <div class="container">
                        <h1>Hello, you are my bestfriends!</h1>
                        <p>G Frame always love you...</p>
                        <p>
                            <a href="<?php echo u('home/entry/index') ?>" class="btn btn-primary btn-lg">首页</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>

	    <?php include './view/footer.php' ?>

        </body>
</html>