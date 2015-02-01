<?php

$tb = new Table();
$tb->addCap('TT, Tên, Năm sinh, Quê quán, Bằng cấp, Đánh giá');
for ($i = 0; $i < 10; $i++):
    $tb->addRow($i, 'Nguyễn Hữu Đại', '10/01/1991', 'Hà Nội', 'Đại học', 'Tốt');
endfor;
$tb->bang();
?>