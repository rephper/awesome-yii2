# strtotime month 计算不准确
## 原因：每个月的天数不同
## 常规写法 strtotime('-1 month', $timestamp);

## 计算方法：当前时间戳 - 当前月的天数
## 改进写法：$days = date('t', $timestamp);  strtotime('-' . $days . ' day', $timestamp);

# realpath修改文件路径为绝对路径
## 场景假设：上传文件存储前处理路径为绝对路径
## 文图：未存储的文件路径不存在，realpath 将返回 false 而不是 绝对路径
## 改进写法：使用realpath处理文件夹路径 并 判定返回是否为空
