<h1>Yii2 Gii 自动生成代码</h1>
<div class="row">
    <div class="col-lg-6">
        <h2>使用gii生成一个Module</h2>
        <img src="./imgs/giiGenerateModule.png"/>
    </div>
    <div class="col-lg-6">
        <div class="MySQL-default-index">
            $this->context->action->uniqueId:<br>
            <h2><?= $this->context->action->uniqueId ?></h2>
            <br>
            <pre>
$this->context->action->id:
    "<?= $this->context->action->id ?>".
The action belongs to the controller
    "<?= get_class($this->context) ?>"
in the "<?= $this->context->module->id ?>" module.
</pre>
        </div>

    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-6">
        <h2>使用gii生成一个model</h2>
        <img src="./imgs/giiGenerateModel.png"/>
    </div>
    <div class="col-lg-6">
        Database Connection ID
            使用 common\config\main-local.php 下的 components 配置的 dsn 组件名称
    </div>
</div>
<hr />