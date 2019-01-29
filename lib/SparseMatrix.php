<?php

class SparseMatrix {

    private $m;  // число строк в матрице
    private $n;  // число столбцов в матрице
    private $a;  // ненулевые элементы
    private $lj; // j-индексы (столбцы) ненулевых элементов
    private $li; // i-индексы (строки) первых ненулевых элементов

    /**
     * Создание объекта - разреженная матрица
     * 
     * @param int $rows
     *   Число строк в матрице
     * 
     * @param int $columns
     *   Число столбцов в матрице
     */

    function __construct($rows, $columns) {
        $this->m = $rows;
        $this->n = $columns;

        $this->a = array();
        $this->li = array();
        $this->lj = array_fill(0, $rows + 1, 0);
    }

    /**
     * Проверка индексов
     * 
     * @param int $row
     *   Номер строки
     * 
     * @param int $col
     *   Номер столбца
     */
    private function validateCoordinates($row, $col) {
        try {
            if ($row < 1 || $col < 1 || $row > $this->m || $col > $this->n) {
                throw new Exception('Ошибка в индексах');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Формирование элементов разреженной матрицы
     * в виде трех массивов
     * 
     * @param int $row
     *   Номер строки
     * 
     * @param int $col
     *   Номер столбца
     * 
     * @param double $val
     *   Добавляемое значение
     */
    private function insert($row, $col, $val) {
        if ($this->a === NULL) {
            $this->a = array();
            $this->li = array();
        } else {
            $this->a[] = $val;
            $this->li[] = $col;
        }

        for ($i = $row; $i <= $this->m; $i++) {
            $this->lj[$i] = $this->lj[$i] + 1;
        }
    }

    /**
     * Если с в строке все элементы нулевые
     * 
     * @param int $row
     *   Строка матрицы
     */
    private function remove($row) {
        for ($i = $row; $i <= $this->m; $i++) {
            $this->lj[i] = $this->lj[i] + 1;
        }
    }

    /**
     * Добавление значения в разреженную матрицу
     * 
     * @param double $val
     *   Добавляемое значение
     * 
     * @param int $row
     *   Номер строки
     * 
     * @param int $col
     *   Номер столбца
     */
    public function set($val, $row, $col) {
        $this->validateCoordinates($row, $col);

        $pos = $this->lj[$row - 1];
        $currCol = 0;

        for (; $pos < $this->lj[$row]; $pos++) {
            $currCol = $this->li[$pos];
            if ($currCol >= $col) {
                break;
            }
        }
        if ($currCol !== $col) {
            if (!($val === 0)) {
                $this->insert($row, $col, $val);
            }
        } elseif ($val === 0) {
            $this->remove($row);
        } else {
            $this->a[$pos] = $val;
        }
    }

    /**
     * Получение значения элемента матрицы по индексам
     * 
     * @param int $row
     *   Номер строки
     * 
     * @param int $col
     *   Номер столбца
     * 
     */
    public function get($row, $col) {
        $this->validateCoordinates($row, $col);
        $currCol = NULL;

        for ($pos = $this->lj[$row - 1]; $pos < $this->lj[$row]; $pos++) {
            $currCol = $this->li[$pos];
            if ($currCol === $col) {
                return $this->a[$pos];
            } elseif ($currCol > $col) {
                break;
            }
        }
    }

    /**
     * Конвертация матрицы в разреженную матрицу  
     * 
     * @param array $matrix
     *   Входная матрица
     */
    public function readMatrix($matrix) {
        $rows = count($matrix);
        for ($i = 0; $i < $rows; $i++) {
            $cols = count($matrix[$i]);
            for ($j = 0; $j < 6; $j++) {
                $this->set($matrix[$i][$j], $i + 1, $j + 1);
            }
        }
    }

    /**
     * Вывод разреженной матрицы
     */
    public function printMatrix() {
        echo 'Sparse Matrix show:<br>';
        for ($i = 1; $i <= $this->m; $i++) {
            for ($j = 1; $j <= $this->n; $j++) {
                echo $this->get($i, $j) . ' ';
            }
            echo '<br>';
        }
    }

    /**
     * Вывод массива A
     */
    public function printA() {
        echo '<br>Vector A show:<br>';
        foreach ($this->a as $val) {
            echo $val . ' ';
        }
        echo '<br>';
    }

    /**
     * Вывод массива LI
     */
    public function printLI() {
        echo '<br>Vector LI show:<br>';
        foreach ($this->li as $val) {
            echo $val . ' ';
        }
        echo '<br>';
    }

    /**
     * Вывод массива LJ
     */
    public function printLJ() {
        echo '<br>Vector LJ show:<br>';
        foreach ($this->lj as $val) {
            echo $val . ' ';
        }
        echo '<br>';
    }

}
