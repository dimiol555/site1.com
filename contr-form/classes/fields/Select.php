<?php
namespace classes\fields;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class Select extends AbstractVariationField
{
    public function renderField()
    {
        //TODO: Implement renderField() method.
        ?>
        <select name="<?= $this->name ?>" size="1">
            <?php foreach ($this->variants as $elem => $item) : ?>
                <?php if ($elem == $this->value) : ?>
                    <option value="<?= $elem ?>" selected><?= $item ?></option>
                <?php else : ?>
                    <option value="<?= $elem ?>"><?= $item ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <?php $this->displayError(); ?>
        <?php
    }

    public function sendField()
    {
        // TODO: Implement send() method.
        return $this->send . $this->variants[$this->value]  . "\r\n";
    }


}
