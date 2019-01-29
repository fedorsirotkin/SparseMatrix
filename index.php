<?php
    require_once 'lib/SparseMatrix.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CSR</title>
    </head>
    <body>
        <p>- - - Example - Compressed Sparse Rows - - -</p>
        <?php
        $testData = [
                [10, 0, 0, 0, -2,   0],
                [3,  9, 0, 0,  0,   3],
                [0,  7, 8, 7,  0,   0],
                [3,  0, 8, 7,  5,   0],
                [0,  8, 0, 9,  9,  13],
                [0,  4, 0, 0,  2,  -1]
        ];

        $matrix = new SparseMatrix(6, 6);
        $matrix->readMatrix($testData);
        $matrix->printMatrix();
        $matrix->printA();
        $matrix->printLI();
        $matrix->printLJ();
        ?>
        <p>- - - - - - - - - - end - - - - - - - - - -</p>
    </body>
</html>