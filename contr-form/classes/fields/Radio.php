<?php
namespace classes\fields;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class Radio extends AbstractVariationField
{
    public function renderField()
    {
        // TODO: Implement renderField() method.
        foreach ($this->variants as $elem => $item) : ?>
            <?php if ($elem == $this->value) : ?>
                <input type="radio" name="<?= $this->name ?>" value="<?= $elem ?>" checked ><?= $item ?>
            <?php else : ?>
                <input type="radio" name="<?= $this->name ?>" value="<?= $elem ?>"><?= $item ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?= $this->displayError() ?>
        <?php
    }
    public function sendField()
    {
        // TODO: Implement send() method.
        if ($this->value != '') {
            return $this->send . $this->variants[$this->value] . "\r\n";
        }
    }


}
