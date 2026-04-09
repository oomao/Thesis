# 📝 THESIS - Tool for Holistic Editing and Study Information System

> 一個整合 AI 技術的論文寫作輔助平台，提供論文推薦、AI 偵測、排版輔助、評分分析、聊天機器人及學術社群等六大功能。

## 🌐 Live Demo

👉 **[Live Demo 線上展示](https://oomao.github.io/Thesis/demo/)**

## 📺 系統介紹影片

[![System Introduction Video](https://img.youtube.com/vi/tMbL237XrwU/maxresdefault.jpg)](https://www.youtube.com/watch?v=tMbL237XrwU)

---

## ✨ 功能介紹

| 功能 | 說明 |
|------|------|
| 🔍 **論文推薦** | 輸入文章片段，利用 NLP 提取關鍵字並推薦相關文獻 |
| 🤖 **AI 偵測** | 偵測文章是否由 AI 生成，標記可疑段落 |
| 📄 **排版輔助** | 多步驟表單輸入論文資訊，一鍵生成符合格式的 PDF |
| ⭐ **論文評分** | 上傳 PDF 論文，分析各章節 AI 生成比例 |
| 💬 **聊天機器人** | 論文寫作問題即時解答 |
| 👥 **學術社群** | 好友系統、即時聊天室，促進學術交流 |

---

## 🏗️ 系統架構

```
┌─────────────────────────────────────────────────┐
│                   Frontend (PHP)                │
│  Bootstrap 5 · 登入/註冊 · 導覽列 · 社群系統    │
├─────────────────────────────────────────────────┤
│                                                 │
│  ┌──────────┐  ┌──────────┐  ┌──────────────┐   │
│  │ AI 偵測  │  │ 關鍵字   │  │ 論文排版     │   │
│  │ MacBERT  │  │ KeyBERT  │  │ LaTeX        │   │
│  └──────────┘  └──────────┘  └──────────────┘   │
│  ┌──────────┐  ┌──────────┐  ┌──────────────┐   │
│  │ 論文評分 │  │ 聊天機器 │  │ 社群系統     │   │
│  │ PDF+AI   │  │ GPT-4    │  │ WebSocket    │   │
│  └──────────┘  └──────────┘  └──────────────┘   │
│                                                 │
│                Backend (Flask)                  │
├─────────────────────────────────────────────────┤
│              MySQL Database (XAMPP)              │
└─────────────────────────────────────────────────┘
```

---

## 📁 專案結構

```
Thesis/
├── project0914/project/        # Flask 後端
│   ├── app.py                  # 主程式入口
│   ├── ai_detection/           # AI 偵測模組 (MacBERT)
│   ├── ai_chat/                # GPT-4 聊天機器人
│   ├── keyword_recommendation/ # 關鍵字推薦
│   ├── give_grade/             # 論文評分
│   ├── latex_templete/         # LaTeX PDF 生成
│   └── templates/              # Flask 模板
│
├── thesis/thesis/              # PHP 前端
│   ├── index.php               # 首頁
│   ├── login1.php              # 登入頁面
│   ├── register.php            # 註冊頁面
│   ├── navbar.php              # 導覽列
│   ├── test.php                # 排版輔助表單
│   ├── friend/                 # 社群好友系統
│   │   ├── db/friend.sql       # 資料庫 Schema
│   │   ├── chatroom.php        # 即時聊天室
│   │   └── profile.php         # 個人檔案
│   └── function1/              # 論文推薦搜尋
│
└── demo/                       # Live Demo (GitHub Pages)
    └── index.html              # 展示型靜態網站
```

---

## 🚀 本機安裝與執行

### 環境需求
- Python 3.8+
- PHP 7.2+ (XAMPP)
- MySQL / MariaDB
- Node.js (社群聊天功能)

### 步驟

1. **Clone 專案**
```bash
git clone https://github.com/oomao/Thesis.git
cd Thesis
```

2. **安裝 Python 依賴**
```bash
pip install flask flask-cors transformers torch ckip-transformers keybert scikit-learn mysql-connector-python PyPDF2 filetype openai
```

3. **設定 MySQL 資料庫**
```bash
# 匯入資料庫 Schema
mysql -u root < thesis/thesis/friend/db/friend.sql
```

4. **下載 AI 模型** (未包含在 repo 中，約 409MB)
   - 將 `model.safetensors` 放到 `project0914/project/ai_detection/checkpoint-best/`

5. **啟動服務**
```bash
# 啟動 XAMPP (Apache + MySQL)
# 啟動 Flask 後端
cd project0914/project
python app.py
```

---

## 🛠️ 技術棧

| 類別 | 技術 |
|------|------|
| 前端 | PHP · Bootstrap 5 · HTML/CSS/JS |
| 後端 | Python Flask · Flask-CORS |
| AI/ML | Hugging Face Transformers · MacBERT · KeyBERT · CKIP |
| 資料庫 | MySQL (MariaDB) · XAMPP |
| NLP | GPT-4 API · CKIP 中文斷詞 |
| 文件處理 | LaTeX · PyPDF2 |
| 即時通訊 | Node.js · WebSocket |

---

---

## 🚀 未來展望 — AI Agent 整合

本計畫未來將從現有的「輔助系統」延伸為「人工智慧代理 (AI Agent)」系統，進一步強化對學生的研究創作支援：

1. **主動式寫作輔助**：從被動的工具轉向主動的 AI 代理，協助學生進行文獻深入導讀、摘要生成及寫作改進建議。
2. **自動化流程優化**：自動處理文獻整理、格式檢查等繁瑣任務，讓研究者能專注於學術創新。
3. **個性化學術導師**：根據學生的寫作風格與研究領域，提供量身定制的內容建議與學習資源。

---

## 👥 開發團隊

本系統為畢業專題作品。

- **指導教師**：張朝旭 教授
- **團隊成員**：黃柏瑜、陳盛茂、林士庭、羅珮綺、陳芊慈、李佳軒
- **榮譽紀錄**：Innoserve 第 29 屆全國大專校院資訊應用服務創新競賽 - 教育開放資料組 **佳作**

## 📄 License

This project is for academic purposes.
