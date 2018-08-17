<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

    <!--<div class="site-about">-->
    <!--    <h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->
    <!---->
    <!--    <p>-->
    <!--        This is the About page. You may modify the following file to customize its content:-->
    <!--    </p>-->
    <!---->
    <!--    <code>--><?php //= __FILE__ ?><!--</code>-->
    <!--</div>-->

<?= Html::beginForm('', 'post', []) ?>

    <h3 class="text-center">Шаблон для вывода новостей</h3>
    <table id="templates" class="table">
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>

    </table>

    <div class="text-center">
        <br/>
        <?= Html::submitInput('Сохранить', ['class' => 'btn btn-primary', 'style' => 'width: 150px;']) ?>
    </div>
<?= Html::endForm() ?>


    <!-- Шаблоны для добавления в таблицу -->
    <div id="hidden_templates" style="display: none;" disabled="disabled">
        <!-- Кнопка Добавить блок (добавляем в таблицу новый td) -->
        <div class="btn-group btn_add_block_cnt">
            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-plus"></i> Добавить блок <span class="caret"></span>
            </button>

            <ul class="dropdown-menu"></ul>
        </div>

        <!-- Кнопка + (добавляем новый пункт в уже имеющийся td) -->
        <div class="btn-group btn_add_item_cnt text-center">
            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                + Добавить блок
            </button>

            <ul class="dropdown-menu"></ul>
        </div>
    </div>


<?php
$templatesCss = <<< CSS
#templates {width: 750px; margin: 0 auto; }
#templates th {width: 25%; }
#templates tr {height: 50px; }
#templates tr:first-child { height: 1px; } 
#templates td {width: 100%; }
CSS;

$templatesJs = <<< JS

var tpl = {
    // Внутри <tr> можно разместить 3 блока с takeColumns=1 
    // или 1 блок с takeColumns=2 + 1 блок с takeColumns=1
    maxColumnsInTr: 3, 
    maxRowsInTr: 2, 
    templates: {
        'tpl4x2': {
            label: 'Большой прямоугольник, фото по центру и текст',
            tdHtml: '<td data-key="tpl4x2" colspan="2"><img data-key="tpl4x2" src="/img/tpl4x2.png" /></td>',
            imgHtml: '<img data-key="tpl4x2" src="/img/tpl4x2.png" />',
            //tdHtml: '<td data-key="tpl4x2" colspan="2">' + this.imgHtml + '</td>',
            takeRows: 2,
            takeColumns: 2,
            btnAddBlock: false,
            btnAddItem: false
        },
        'tpl2x2': {
            label: 'Большой квадрат, фото по центру и текст',
            tdHtml: '<td data-key="tpl2x2"><img data-key="tpl2x2" src="/img/tpl2x2.png" /></td>',
            imgHtml: '<img data-key="tpl2x2" src="/img/tpl2x2.png" />',
            takeRows: 2,
            takeColumns: 1,
            btnAddBlock: false,
            btnAddItem: false
        },
        'tpl4x1': {
            label: 'Средний прямоугольник, фото по краю и текст',
            tdHtml: '<td data-key="tpl4x1" colspan="2"><img data-key="tpl4x1" src="/img/tpl4x1.png" /></td>',
            imgHtml: '<img data-key="tpl4x1" src="/img/tpl4x1.png" />',
            takeRows: 1,
            takeColumns: 2,
            btnAddBlock: false,
            btnAddItem: true
        },
        'tpl2x1': {
            label: 'Средний квадрат, фото по центру и текст',
            tdHtml: '<td data-key="tpl2x1"><img data-key="tpl2x1" src="/img/tpl2x1.png" /></td>',
            imgHtml: '<img data-key="tpl2x1" src="/img/tpl2x1.png" />',
            takeRows: 1,
            takeColumns: 1,
            btnAddBlock: false,
            btnAddItem: true
        },
        'tpl2x05': {
            label: 'Маленький прямоугольник, фото по краю и текст',
            tdHtml: '<td data-key="tpl2x05"><img data-key="tpl2x05" src="/img/tpl2x05.png" /></td>',
            imgHtml: '<img data-key="tpl2x05" src="/img/tpl2x05.png" />',
            takeRows: 0.5,
            takeColumns: 1,
            btnAddBlock: false,
            btnAddItem: true
        },
        'tpl2x05_textonly': {
            label: 'Маленький прямоугольник, только текст',
            tdHtml: '<td data-key="tpl2x05_textonly"><img data-key="tpl2x05_textonly" src="/img/tpl2x05_textonly.png" /></td>',
            imgHtml: '<img data-key="tpl2x05_textonly" src="/img/tpl2x05_textonly.png" />',
            takeRows: 0.5,
            takeColumns: 1,
            btnAddBlock: false,
            btnAddItem: true
        },
        'empty': {
            label: '',
            tdHtml: '<td data-key="empty"></td>',
            imgHtml: false,
            takeRows: 0,
            takeCols: 0,
            btnAddBlock: true,
            btnAddItem: false
        }
    },
    // Добавляем новый блок (новый <td> в существующий или новый <tr>)
    // Html нового блока определен в this.templates[templateKey].tdHtml
    addNewBlock: function(templateKey, tr) {
        if (this.newTrIsRequired(tr)) {
            $("<tr></tr>").appendTo("#templates");
            var tr = $("#templates tr:last-child");
        } 
     
        var td = $(this.templates[templateKey].tdHtml);
        if (this.templates[templateKey].btnAddBlock) {
            var btn = $("#hidden_templates div.btn_add_block_cnt").clone();
            this.getBtnAddBlockMenu(btn.find("ul"), tr);
            btn.appendTo(td);
        }
        
        if (this.templates[templateKey].btnAddItem) {
            var btn = $("#hidden_templates div.btn_add_item_cnt").clone();
            this.getBtnAddItemMenu(btn.find("ul"), td, tr);
            td.append($("<span>").attr("class", "clearfix")).append(btn); 
        }
        
        td.appendTo(tr);
    },
    // Формируем меню, выпадающее при нажатии кнопки "Добавить блок"
    // Вычисляем к-во свободных колонок внутри <tr> и выводим только те
    // пункты меню, у которых this.templates[key]['takeColumns'] <= freeColumns
    getBtnAddBlockMenu: function(menu_container, tr) {
        var freeColumns = this.maxColumnsInTr - this.getColumnsInTr(tr);

        for (key in this.templates) {
            if (this.templates[key]['takeColumns'] <= freeColumns) {
                // <li><a href="#" data-tpl-key="tpl4x2">Большой прямоугольник, фото по центру и текст</a></li>
                var a = $("<a></a>").attr({"href": "#", "data-tpl-key": key}).text(this.templates[key]["label"]);
                var li = $("<li></li>").append(a);
                menu_container.append(li);
            }
        }
    },
    // Вычисляем к-во занятых колонок внутри <tr>
    // tpl4x2 занимает 2 колонки, tpl2x05 одну (см.this.templates[key]['takeColumns'])
    getColumnsInTr: function(tr) {
        if (tr == undefined) {
            return 0;
        }
          
        var tds = tr.find("td");
        var numColumns = 0*1;
        tds.each(function(indx, el) {
            numColumns += parseInt(($(el).attr("colspan") == undefined) ? 1 : $(el).attr("colspan"));
        });
    
        return numColumns;
    },
    newTrIsRequired: function(tr) {
        return (tr == undefined) ? true : this.getColumnsInTr(tr) >= this.maxColumnsInTr;
    },
    // Добавляем новый пункт в существующий блок (новый <img> в существующий <td>)
    // Html нового блока определен в this.templates[templateKey].imgHtml
    // Вызывается только для блоков, у которых templates[templateKey].btnAddItem=true
    addNewItem: function(templateKey, td) {
        var img = $(this.templates[templateKey].imgHtml);
        var lastImg = td.find("img").last();
        img.insertAfter(lastImg);
        
        this.getBtnAddItemMenu(cnt, td, td.parent('tr'));
    },
    // Формируем меню, выпадающее при нажатии кнопки "Добавить новый пункт"
    // Вычисляем к-во свободных рядов внутри <td> и выводим только те
    // пункты меню, у которых this.templates[key]['takeRows'] <= freeRows
    // и this.templates[key]['takeCols'] <= td.takeColumns
    getBtnAddItemMenu: function(menu_container, td, tr) {
        var tplKey = td.data('key');
        var takeCols = this.templates[tplKey]['takeColumns'];
        //var freeRows = this.getMaxRowsInTr(tr) - this.getRowsInTd(td);
        var freeRows = this.maxRowsInTr - this.getRowsInTd(td);
        menu_container.empty();

        for (key in this.templates) {
            if (this.templates[key]['takeRows'] <= freeRows && this.templates[key]['takeColumns'] <= takeCols) {
                // <li><a href="#" data-tpl-key="tpl4x2">Большой прямоугольник, фото по центру и текст</a></li>
                var a = $("<a></a>").attr({"href": "#", "data-tpl-key": key}).text(this.templates[key]["label"]);
                var li = $("<li></li>").append(a);
                menu_container.append(li);
            }
        }
    },
    // getMaxRowsInTr: function(tr) {
    //     var max = 0*1;
    //     var tds = tr.find("td");
    //     var tpl = this.templates;
    //    
    //     if (tds.length == 0) {
    //         return this.maxRowsInTr;
    //     }
    //    
    //     tds.each(function(indx, el) {
    //         var key = $(el).data("key");
    //         var takeRows = parseInt(tpl[key]["takeRows"]);
    //         max = (takeRows > max) ? takeRows : max;
    //     });
    // 
    //     return max;
    // },
    getRowsInTd: function(td) {
        var imgs = td.find("img");
        var numRows = 0*1;
        var tpl = this.templates;
        
        imgs.each(function(indx, el) {
            var key = $(el).data("key");
            numRows += parseInt(tpl[key]["takeRows"]);
        });

        return numRows;
    }
};

$(document).ready(function () {
    tpl.addNewBlock("empty");
    
    // Добавить новый блок
    $("#templates").on("click", ".btn_add_block_cnt a", function(e) {
        e.preventDefault();
        var td = $(this).closest("td");
        var tr = td.parent("tr");
        var templateKey = $(this).data("tpl-key");
        
        if (td.data("key") == "empty") {
            td.remove();
        }
        tpl.addNewBlock(templateKey, tr);
        tpl.addNewBlock("empty", tr);
    });
    
    // Добавить новый пункт в существующий блок
    $("#templates").on("click", ".btn_add_item_cnt a", function(e) {
        e.preventDefault();
        var templateKey = $(this).data("tpl-key");
        var td = $(this).closest("td");
        tpl.addNewItem(templateKey, td);
    });
});
JS;


$this->registerCss($templatesCss);
$this->registerJs($templatesJs);
