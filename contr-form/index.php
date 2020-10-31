<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

const __MY_BASE__ = __DIR__;
require_once 'connection.php';
require_once 'loader.php';

?>
<html>
<head>
    <title>Форма Лентяя!</title>
    <style>
        a {
            color: #FFFFFF;
        }

        table {
            width: 40%; /* Ширина таблицы */
            background: white; /* Цвет фона таблицы */
            color: white; /* Цвет текста */
        }

        table table {
            width: 100%;
            border: none;
        }

        td {
            background: #541d80; /* Цвет фона ячеек */
            padding: 5px 10px; /* Поля вокруг текста */
            vertical-align: top;
            border: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
        }
        .list a{
            color: blue;
        }
        .list a:hover{
            color: red;
        }
    </style>
</head>
<body>

<?php if(!count($_GET)) :?>
<h1>Уважаемый lol!</h1>
    <?php
    $queryForm = '
    SELECT *
    FROM form';

    $dataBase = \classes\db\ConnectionDB::getInstance();
    $arrayForm = $dataBase->getResult($queryForm);

    ?>
    <ul class="list">
        <?php foreach ($arrayForm as $key => $item) : ?>
        <li><a href="/contr-form/?showForm=<?= $item['ID_form']; ?>">ВЫБЕРИТЕ ФОРМУ <?= $item['NameForm']; ?></a></li>
        <?php endforeach; ?>
    </ul>

<?php elseif (!empty($_GET['showForm'])):?>
<table cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <?php
            $form = \classes\form\FormConstruct::createForm($_GET['showForm']);
            $form->printForm();
            ?>
        </td>
    </tr>
</table>
    <?php
    $queryMsg = '
    SELECT *
    FROM message
    WHERE message.FormID = ' . $_GET['showForm'];

    $dataBase = \classes\db\ConnectionDB::getInstance();
    $arrayMsg = $dataBase->getResult($queryMsg);
    ?>
    <ul class="list">
        <?php foreach ($arrayMsg as $key => $item) : ?>
            <li><a href="/contr-form/?showMassage=<?= $item['ID']; ?>">Сообщение от <?= $item['Data']; ?></a></li>
        <?php endforeach; ?>
    </ul>

<?php elseif (!empty($_GET['showMassage'])):?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <?php
                $showMsg = \classes\form\FormConstruct::showMessage($_GET['showMassage']);
                $showMsg->printForm();
                ?>
            </td>
        </tr>
    </table>
<?php endif;?>
</body>
</html>

