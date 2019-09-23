![avatar](../../resource/img/yii2/request-lifecycle.png)
# Download Code
  compoer

# 初始化
  php init
  配置environments
    配置数据库
    配置gii
    配置debug
  
# Migration
  前置条件：创建数据库
  常见数据库迁移脚本
  
# gii
  自动生成Model、Search、Controller、View、Module文件
# Model
  model extends yii\db\ActiveRecord 
  映射一个数据表 tableName()、attributeLabels()、behaviors()、 beforeSave()、afterSave()、beforeDelete()、afterDelete()
  
  common/models/
  定义常量
  定义rules 验证规则
  定义关联关系
  定义公共属性
  
  app/models/
  定义场景
  定义私有属性
  fields() 分场景返回数据
  
# Controller
  actionABC 的ActionID是 a-b-c
  $form = new Form();
  $form->分配参数;
  $form->validate();
  数据处理
  返回结果|渲染页面

# View
  路径：views/ControllerID/视图名.php 
  建议：视图名 与 ActionID保持关联性，ActionId_xx.php
  警告： 客户端验证是提高用户体验的手段。 无论它是否正常启用，服务端验证则都是必须的，请不要忽略它。
  
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  <?= Html::encode($message) ?> //   防止跨站脚本（XSS）攻击
  <?php $form = ActiveForm::begin(); ?>
  
  <?php ActiveForm::end(); ?>
  
  use yii\grid\GridView;
  
  use kartik\grid\GridView;

# From
  form extends yii\base\Model
  与数据表无关
  定义表单的入参，数据校验，数据处理
