<?php

class Table {

    private $row = array();

    public function addCap() {
        $c = func_get_args();
        if (is_string($c[0])) {
            $this->row['header'] = explode(',', $c[0]);
        }
    }

    public function addRow() {
        $r = func_get_args();
        if (count($r) > 2) {
            $this->row[] = $r;
        }
    }

    public function getCap() {
        $caption = '';

        if (isset($this->row['header'])) {
            $caption .= "<div class='dl-row'>";
            foreach ($this->row['header'] as $h) {
                $caption .= "<div class='dl-cell dl-th'>$h</div>";
            }
            $caption .= "</div>";
        }

        array_shift($this->row);

        return $caption;
    }

    public function getHTML() {
        $table = $this->getCap();

        if (count($this->row)) {
            foreach ($this->row as $row) {
                $table .= "<div class='dl-row'>";
                $i = -1;
                while ($i++ < count($row) && $row[$i]) {
                    $table .= "<div class='dl-cell'>{$row[$i]}</div>";
                }
                $table .= "</div>";
            }
        }

        return '<div class="dl-table">' . $table . '</div>';
    }

    public function bang() {
        e($this->getHTML());
    }

}

/*
<div class="dl-table">
	<div class="dl-row">
		<div class="dl-cell dl-th">TT</div>
		<div class="dl-cell dl-th">Tên</div>
		<div class="dl-cell dl-th">Năm sinh</div>
		<div class="dl-cell dl-th">Quê quán</div>
		<div class="dl-cell dl-th">Bằng cấp</div>
		<div class="dl-cell dl-th">Đánh giá</div>
	</div>

	<?php for($i = 0; $i < 10; $i++): ?>
	<div class="dl-row">
		<div class="dl-cell"> <?php e($i + 1); ?></div>
		<div class="dl-cell"> Nguyễn Hữu Đại</div>
		<div class="dl-cell"> 10/01/1991</div>
		<div class="dl-cell"> Hà nội</div>
		<div class="dl-cell"> Đại học</div>
		<div class="dl-cell"> Tốt</div>
	</div>
	<?php endfor; ?>
</div>
*/