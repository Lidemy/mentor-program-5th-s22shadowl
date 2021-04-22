## 交作業流程

### 初始流程（僅首次繳交需要）
 　Step.1　加入課程的[ GitHub classroom](https://classroom.github.com/a/yNNrtNyW)，並產生屬於自己的 repository（資料庫）
　 Step.2　開啟 Git Bash，使用 clone 功能把剛才得到的 repository 下載下來
　　``` git clone " 你的 repository 網址 " ```

### 每次交作業流程
　 Step.1　開啟 Git Bash，切換至作業資料夾
　　``` cd "作業資料夾" ```
　 Step.2　以週數為名新增一個新的 branch 並切換至 branch
　　``` git checkout -b "週數" ```
　 Step.3　將 Branch Push 到 GitHub
　　``` git push origin "週數" ```
　 Step.4　在 GitHub 接受你的 pull request
　 Step.5　到學習平台輸入 pull request 的網址繳交作業
　 Step.6　檢查上傳作業是否有誤

### 作業批改後流程
   Step.1  收到助教批改後，將 GitHub 上的 branch merge 到 master，並刪除這周的 branch
   Step.2  將最新版本的 master 從 GitHub pull 下來
    ``` git checkout master ```
    ``` git pull origin ```
   Step.3  若有需要訂正，在修改完畢後自行創立一條新的 branch 重新 push
    ``` git checkout -b "週數corretion" ```
    ``` git push origin "週數corretion" ```
　 Step.4　在 GitHub 接受你的 pull request

   
