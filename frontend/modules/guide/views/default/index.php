<h1>Yii2 最佳实践</h1>
<div class="row">
    <div class="col-lg-7">
        <h2>使用gii生成一个Module</h2>
        <img src="./imgs/giiGenerateModule.png" />
    </div>
    <div class="col-lg-5">
        <div class="MySQL-default-index">
            $this->context->action->uniqueId:<br >
            <h2><?= $this->context->action->uniqueId ?></h2>
            <br >
            <pre>
$this->context->action->id:
    "<?= $this->context->action->id ?>".
The action belongs to the controller
    "<?= get_class($this->context) ?>"
in the "<?= $this->context->module->id ?>" module.
</pre>
        </div>

    </div>