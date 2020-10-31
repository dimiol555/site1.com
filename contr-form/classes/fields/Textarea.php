<?php
namespace classes\fields;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class Textarea extends AbstractField
{
    public $placeholder;

    public function __construct($name = '', $params = [])
    {
        parent::__construct($name, $params);
        $this->placeholder = $params['placeholder'];
    }

    public function renderField()
    {
        // TODO: Implement renderField() method.
        ?>
        <textarea name="<?= $this->name ?>"
                  placeholder="<?= $this->placeholder ?>"
        ><?= htmlspecialchars($this->value) ?></textarea>
        <?php $this->displayError(); ?>
        <?php
    }

    public function sendField()
    {
        // TODO: Implement send() method.
        return $this->send . $this->value . "\r\n";
    }

}
