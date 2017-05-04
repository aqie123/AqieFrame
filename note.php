git 使用
- 测试推送整个repository
1.cd
2.git add -A
3.git commit -m "推送整个目录"
4.git push origin master

- 创建新的repository
1.git init
2. git add -A
3.git commit -m "创建新的repository"
4.git remote add origin git@github.com:aqie123/test.git
5.git push -u origin master

- 删除远程文件
1.git rm 九型人格
2.git commit -m "删除九型人格"
3.git push origin master

- 创建分支
1.git checkout -b dev    #创建并切换到分支
3.echo "# create a new repository" >> README.md
4.git add README.md
5.git commit -m "branch dev"
6.git push origin dev

- 分支常见操作
1.git branch   #查看分支
2.git branch test # 创建分支
3.git checkout test #切换分支
4.git merge dev        #命令用于合并指定分支到当前分支
5.git branch -d test   # 删除本地分支
6.git push origin :test #删除远程分支
7.git push origin local_branch:remote_branch    #分支推送到远程