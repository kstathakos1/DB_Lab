<?php
include('../config/database.php');
if (!isset($_SERVER["HTTP_USER_AGENT"])) {
    die;
}
$query = "select if(school_number>0,concat(school_number,' ',school_type,' ',city),concat(school_type,' ',city)) as name
from school_unit;";
$conn = getDb();
$result1 = mysqli_query($conn, $query);

?>

<html>
<head>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.css"
            rel="stylesheet"
    />

</head>
<?php include('navbar.php') ?>
<body>
<div class="container" id="background">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-xl-9 justify-content-center">
            <div class="card "
                 style="border-radius: 2rem; margin-top: 5%; margin-bottom: 5%; text-align: center; vertical-align: center;justify-items: center">
                <div class="card-body">
                    <form id="addbook" method="POST" action="addbook.php" enctype="multipart/form-data" autocomplete="off">
                        <div class="container-xxl">
                            <img src="../library.jpg"
                                 vspace="15"
                                 hspace="15"
                                 width="60">

                            <div class="row" id="row1" style="margin-top: 2% ;margin-bottom: 3%;">
                                <div class="col-md-6 form-outline" style="width: 47.1%;">
                                    <input type="text"
                                           autocomplete="off"
                                           id="ISBN"
                                           name='ISBN'
                                           class="form-control form-control-lg align-self-center"
                                           required="required"
                                    />
                                    <label class="form-label" for="ISBN">ISBN</label>
                                </div>
                                <div class="col-md-6 form-outline" >
                                    <input type="text"
                                           autocomplete="off"
                                           id="title"
                                           name='title'
                                           class="form-control form-control-lg align-self-center"
                                           required="required"
                                    />
                                    <label class="form-label" for="title">Title of Book</label>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 3%">
                                <div class="col-md-6 form-outline" >
                                    <input type="text"
                                           autocomplete="off"
                                           id="authors"
                                           name='authors'
                                           class="form-control form-control-lg align-self-center"
                                           value=""
                                           required="required"
                                    /><label class="form-label" for="title">Authors</label></div>
                                <div class="col-md-6 form-outline" ">
                                    <input type="text"
                                           autocomplete="off"
                                           id="categories"
                                           name='categories'
                                           class="form-control form-control-lg align-self-center"
                                           value=""
                                           required="required"
                                    /><label class="form-label" for="title">Categories of Book</label>
                            </div>
                            </div>
                            <div class="row" style="margin-bottom: 3%">
                                <div class="col-md-6 form-outline" >
                                    <input type="text"
                                           autocomplete="off"
                                           id="publisher"
                                           name='publisher'
                                           class="form-control form-control-lg align-self-center"
                                           value=""
                                           required="required"
                                    /><label class="form-label" for="title">Publisher of Book</label>
                                </div>
                                <div class="col-md-6 form-outline">
                                    <input type="text"
                                           autocomplete="off"
                                           id="language"
                                           name='language'
                                           class="form-control form-control-lg align-self-center"
                                           value=""
                                           required="required"
                                    /><label class="form-label" for="title">Language of Book</label>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 3%">
                                <div class="col-md-6 form-outline">
                                    <input type="number"
                                           autocomplete="off"
                                           id="pages"
                                           name='pages'
                                           class="form-control form-control-lg align-self-center"
                                           value=""
                                           required="required"
                                    />
                                    <label class="form-label" for="title">Number of pages of Book</label>
                                </div>
                                <div class="col-md-6 form-outline">
                                    <input type="number"
                                           autocomplete="off"
                                           id="copies"
                                           name='copies'
                                           class="form-control form-control-lg align-self-center"
                                           value=""
                                           required="required"
                                    />
                                    <label class="form-label" for="title">Number of Copies</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group mb-4">
                                    <label class="input-group-text" for="image">Book Image</label>
                                    <input type="file" class="form-control" id="image" name="image" required="required">
                                </div>

                                <div class="form-group" style="display: grid">
                                    <label style="margin-bottom: 0;text-align: left;" for="comment">Book Summary:</label>
                                    <textarea class="form-control" id="comment" required="required" rows="3"
                                              id="summary" name="summary"></textarea>
                                </div>
                            </div>
                            <button class="button btn btn-outline-success btn-lg " type="submit">Add Book</button>
                            <a href="../index.php" class="btn btn-outline-danger btn-lg" role="button"
                               aria-disabled="true">Cansel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js"
></script>
</body>
</html>
