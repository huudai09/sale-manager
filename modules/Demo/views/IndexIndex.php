<div class="aform-box">
    <form class="aform">
        <div class="aform-row">
            <h5>{@lang:Tieu.de}</h5>
            <input placeholder="Nhập tiêu đề" class="aform-inp inp-txt" />
        </div>
        <div class="aform-row">
            <h5>Bắt đầu từ ngày {@id:date.picker}</h5>
            <input placeholder="Nhập ngày" class="aform-inp inp-date" />
        </div>
        <div class="aform-row">
            <h5>Kết thúc vào ngày</h5>
            <input placeholder="Nhập ngày" class="aform-inp inp-date" />
        </div>
        <div class="aform-row af2">
            <div class="aform-col">
                <h5>Từ lúc</h5>
                <input placeholder="Nhập ngày" class="aform-inp inp-date" />
            </div>
            <div class="aform-col">
                <h5>Tới lúc</h5>
                <input placeholder="Nhập ngày" class="aform-inp inp-date" />
            </div>
        </div>
        <div class="aform-row">
            <h5>Tài file</h5>
            <input type="file" />
        </div>
        <div class="aform-row aform-implement">
            <button class="aform-accept btn">Xác nhận</button>
        </div>
    </form>
</div>

<?php
h2('1. Form Element');

$f = new Form();
$f
        ->addField(array(
            'label' => 'Nhập tiêu đề',
            'content' => Tag::input('title')
        ))
        ->addField(array(
            'label' => 'Bắt đầu từ ngày',
            'content' => Tag::input('title')
        ))
        ->addField(array(
            'label' => 'Loại sự kiện',
            'content' => '<select><option>1</option></select>'
        ))
        ->addField(array(
            array(
                'label' => 'Từ lúc',
                'content' => Tag::input('title')
            ),
            array(
                'label' => 'Tới lúc',
                'content' => Tag::input('title')
            )
                ), true)
        ->addField(array(
            'label' => '{@lang: Bắt đầu từ ngày}',
            'content' => Tag::input('title')
        ))
        ->addButtons()
        ->bang();

h2('2. Table Element');
$tb = new Table();
$tb->addCap('TT, Tên, Năm sinh, Quê quán, Bằng cấp, Đánh giá');
for ($i = 0; $i < 10; $i++):
    $tb->addRow($i, 'Nguyễn Hữu Đại', '10/01/1991', 'Hà Nội', 'Đại học', 'Tốt');
endfor;
$tb->bang();
?>