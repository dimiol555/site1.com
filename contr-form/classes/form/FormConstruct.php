<?php
namespace classes\form;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class FormConstruct
{
    public $form = [];
    public $idForm;
    public $messageID;

    /*
     * in private function __construct(array $array, string $nameForm)
     * $array == $arrayForm and $nameForm == $id from public static function createForm ($id)
     */

    private function __construct(array $array, string $nameForm, $messageID = 0)
    {
        $this->idForm = $nameForm;
        $this->messageID = $messageID;

        foreach ($array as  $field) {
            $key= $field['NameField'];
            $className = '\\classes\\fields\\' . $field['type'];
            $field['value'] = key_exists('Value', $field) ? unserialize($field['Value']) :'';
            //print_r($field['Value']);

            if (count($_POST) && $_POST['idForm'] == $this->idForm) {
                $field['value'] = isset($_POST[$key]) ? $_POST[$key] : '';
            }
            $this->form[$key] = new $className($key, $field);
        }

        if (key_exists('downLoadForm', $_GET ) && $_GET['downLoadForm'] == $this->idForm) {

            $this->downLoadForm();
        }

        $this->sendLetter();
    }

    public static function createForm($id)
    {
        $query = '
        SELECT *
        FROM fields
        WHERE fields.FormID = ' . $id;

        $dataBase = \classes\db\ConnectionDB::getInstance();
        $arrayForm = $dataBase->getResult($query);
        return new self($arrayForm, $id);
    }

    public static function showMessage($idMessage)
    {
        $query = '
        SELECT *
        FROM fields
        INNER JOIN fields_message
        ON fields.ID_field = fields_message.FieldID 
        WHERE fields_message.MessageID = ' . $idMessage;

        $dataBase = \classes\db\ConnectionDB::getInstance();
        $arrayForm = $dataBase->getResult($query);
        return new self($arrayForm,  $arrayForm[0]['FormID'], $arrayForm[0]['MessageID']);
    }

    public function controlForm()
    {
        $control = 0;
        if (count($_POST) && $_POST['idForm'] == $this->idForm) {
            foreach ($this->form as $object) {
                if (!$object->controlObject()) {
                    $control++;
                }
            }
        } else {
            return 1; // для формы, которая еще не отправлялась!!!
        }
        if ($control != 0) {
            echo "Внимание! Письмо не может быть отправлено!" . '<br />';
            echo "Заполните ВСЕ поля формы для отправки!!!";
        }
        return $control;
    }

    public function sendLetter()
    {
        $total = $this->controlForm();

        $msg = '';
        if ($total == 0) {
            $msg .= "\r\n" . "Date: " . date('D, d M Y h:i:s') . "\r\n";
            foreach ( $this->form as $object ) {
                $msg .= $object->sendField();
            }

            $this->writeFile($msg);

            if ($this->messageID) {
//                echo '<pre>';
//                print_r($this);
//                echo '<br>';
                $this->updateMessageToDB();
                //die;
            } else {
                $this->writeMessageToDB($msg);
            }
       }
    }

    public function updateMessageToDB()
    {
        $dataBase = \classes\db\ConnectionDB::getInstance();

        foreach ($this->form as $object) {
            $query = '
                UPDATE fields_message
                SET Value = \'' . serialize($object->value) . '\'
                WHERE MessageID = ' . $this->messageID . ' and FieldID = ' . $object->ID_field;

//            echo '<pre>';
//            print_r($query);
//            echo '<br>';
            $res = $dataBase->sendQuery($query);

        }
    }

    public function writeMessageToDB($message)
    {
        $query = '
        INSERT INTO message (FormID, Message)
        VALUES ('. $this->idForm .', "' . $message . '")';
        //echo $query;

        $dataBase = \classes\db\ConnectionDB::getInstance();
        $res = $dataBase->sendQuery($query);

        $lastID = $dataBase->getLastID();
        echo '<br />' . 'Последняя запись номер ' . $lastID;

        $query2 = 'INSERT INTO fields_message (MessageID, FieldID, Value) VALUES';
        $fieldsTemp = [];
        foreach ( $this->form as $object ) {
            $fieldsTemp[] = '('. $lastID . ',' . $object->ID_field . ',' . "'". serialize($object->value)."')";
        }
        $query2.= join(',',$fieldsTemp).';';
        //print_r($query2);
        $res = $dataBase->sendQuery($query2);
    }

    public function writeFile($content)
    {
        // Get real path for our folder = Получите реальный путь к нашей папке
        $dir = \__MY_BASE__.'/form-file/'. $this->idForm . '/';

        if(!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        //echo $dir;

        $nameFile = $dir . $this->form['email']->value;

        $modeWrite = file_exists($nameFile) ? "a" : "w";
        $fp = fopen($nameFile, $modeWrite);
        $text = fwrite($fp, $content);
        fclose($fp);
    }

    public function downLoadForm()
    {
        // Get real path for our folder = Получите реальный путь к нашей папке
        $dir = \__MY_BASE__.'/form-file/'. $this->idForm;
        $zipFileDir = \__MY_BASE__.'/form-file/';

        $zip = new \ZipArchive();
        $zip->open($zipFileDir . "/archive" . $this->idForm . ".zip", \ZipArchive::CREATE|\ZipArchive::OVERWRITE);

        // Create recursive directory iterator = Создать рекурсивный итератор каталогов
        /** @var SplFileInfo[] $files */
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir),
            \RecursiveIteratorIterator::LEAVES_ONLY);

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically) = Пропустить каталоги (они будут добавлены автоматически)
            if (!$file->isDir())
            {
                // Get real path for current file = Получить реальный путь к текущему файлу
                $filePath = $file->getRealPath();
                // Get relative path for current file = Получить относительный путь для текущего файла
                $relativePath = substr($filePath, strlen($dir) + 1);

                // Add current file to archive = Добавить текущий файл в архив
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object = Zip-архив будет создан только после закрытия объекта
        $zip->close();
        file_force_download($zipFileDir . "/archive" . $this->idForm . ".zip", true);

    }

    public function printForm()
    {
        ?>
        <h3>Form for Letter!!!</h3>
        <form action="" method="post">
            <table>
                <?php foreach ($this->form as $object) : ?>
                    <tr>
                        <td>
                            <?php $object->renderField() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>
                        <input type="hidden" name="idForm" value="<?= $this->idForm ?>">
                        <input type="submit" value="SEND MESSAGE!!!">
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/contr-form/?downLoadForm=<?= $this->idForm;?>">Скачать ZIP-архив</a>
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }
}

    function file_force_download($file, $remove = false)
    {
        if (file_exists($file)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            // читаем файл и отправляем его пользователю
            readfile($file);
            // удаляем файл после отправки его пользователю
            if ($remove) {
                unlink($file);
            }
            exit;
        }
    }