# 命令行界面查看git提交日志
  git log --graph --oneline


# 修改本地git log 的date 格式 为本地格式
  git config log.date iso-local             2018-11-03 03:30:04 +0000

  git config log.date iso-strict-local      2018-11-03T03:30:04+00:00


# 查看某人在某段时间段内的提交
  git log --since=2019-08-30 --until=2019-08-31 --author="Clark" --pretty=format:"%h - %an, %ad : %s"

# 仓库提交者排名前 n名
  git log --pretty='%aN' | sort | uniq -c | sort -k1 -n -r | head -n 5

# 查看指定文件的提交记录
  git log file
