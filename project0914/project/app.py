from flask import Flask, request, jsonify, send_from_directory, render_template, redirect, url_for
from flask_cors import CORS
from ai_detection.predict import ai_detector
from keyword_recommendation.find_keyword import generate_keywords, extract_keywords
from give_grade.readFile_final import evaluate_paper, runModels, readPDF
from ai_chat.gpt_api import get_gpt_response
from ai_chat.test_chat import get_canned_response
from latex_templete.generate_noFLASK import process_references
import subprocess
import os
import mysql.connector
import sys
# 將 makesimplePDF.py 所在的目錄添加到 Python 路徑中
sys.path.append(r'D:\\project\\latex_templete\\untitled folder')

# 導入 makesimplePDF 模塊
import makesimplePDF
app = Flask(__name__)
CORS(app)

@app.route('/')
def index():
    return render_template('index.php')

@app.route('/ai_detector')
def ai_detector_page():
    return render_template('ai_detector.php')

@app.route('/AI_Detector', methods=['POST'])
def ai_detection():
    try:
        input_text = request.json.get('text', '')
    except ValueError:
        return jsonify({'error': 'Invalid input'}), 400

    result = ai_detector(input_text)
    return jsonify(result)

@app.route('/keyword_recommendation')
def keyword_recommendation_page():
    return render_template('search.php')

def query_database(keywords):
    cnx = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="paper"
    )
    cursor = cnx.cursor()

    results = []

    for keyword in keywords:
        query = """
            SELECT paper_zh, paper_en, keywords_zh, url 
            FROM paper_data 
            WHERE paper_zh LIKE %s 
               OR paper_en LIKE %s 
               OR keywords_zh LIKE %s
        """
        params = (f'%{keyword}%', f'%{keyword}%', f'%{keyword}%')
        cursor.execute(query, params)
        
        for row in cursor.fetchall():
            results.append({
                'paper_zh': row[0],
                'paper_en': row[1],
                'keywords_zh': row[2],
                'url': row[3]
            })

    cursor.close()
    cnx.close()
    
    return results
@app.route('/search_back', methods=['POST'])
def find_keywords():
    data = request.get_json()
    text = data.get('text', '')
    mode = data.get('mode', 'precise')  # 默認為精準模式
    keywords = extract_keywords(text)
    
    # 根據模式選擇適當數量的關鍵字
    if mode == 'precise':
        search_keywords = keywords[:1]  # 精準查詢，只使用第一個關鍵字
    elif mode == 'moderate':
        search_keywords = keywords[:3]  # 適中查詢，使用前三個關鍵字
    elif mode == 'fuzzy':
        search_keywords = keywords[:5]  # 模糊查詢，使用全部五個關鍵字
    else:
        search_keywords = keywords  # 默認為全部關鍵字

    search_results = query_database(search_keywords)
    return jsonify({'keywords': search_keywords, 'results': search_results})

@app.route('/upload')
def upload_page():
    return render_template('upload.php')

@app.route('/evaluate_paper', methods=['POST'])
def evaluate_paper_route():
    global global_sections_data  # 使用全局變量

    if 'file' not in request.files:
        return jsonify({'error': 'No file part'}), 400

    file = request.files['file']
    if file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    if not file.filename.endswith('.pdf'):
        return jsonify({'error': 'File is not a PDF'}), 400

    if not os.path.exists('uploads'):
        os.makedirs('uploads')

    file_path = os.path.join('uploads', 'temp.pdf')
    file.save(file_path)

    # 使用 readPDF 函數提取章節數據
    global_sections_data = readPDF(file_path)
    
    # 只返回章節的標題和初始狀態（未選中）
    titles = [{'title': section[0], 'selected': False} for section in global_sections_data]

    return jsonify({'message': 'Upload successful', 'titles': titles})

@app.route('/run_models', methods=['POST'])
def run_models_route():
    global global_sections_data  # 使用全局變量

    sections = request.json.get('sections', [])

    # 將 sections 列表轉換為數據格式以符合 runModels 的要求
    data = []
    for section in sections:
        # 只處理用戶勾選的章節
        if section['selected']:
            # 查找對應的內文
            matching_section = next((s for s in global_sections_data if s[0] == section['title']), None)
            if matching_section:
                data.append([
                    matching_section[0],  # data[0]: 標題
                    matching_section[1],  # data[1]: 內文
                    matching_section[2],  # data[2]: 起始頁數
                    matching_section[3],  # data[3]: 結束頁數
                    matching_section[4],  # data[4]: 腳註
                    0,                    # data[5]: 相似度總句數 (初始為0)
                    0,                    # data[6]: 相似度ai句數 (初始為0)
                    0.0,                  # data[7]: ai機率 (初始為0.0)
                    section['selected']   # data[8]: 是否選中
                ])

    # 針對選中的章節運行模型
    runModels(data)

    # 只返回勾選的章節及其 AI 率
    results = [{'title': item[0], 'ai_probability': item[7]} for item in data if item[8]]

    return jsonify({'message': 'Models executed successfully', 'results': results})

@app.route('/form')
def form_page():
    return render_template('form.html')

@app.route('/generate_pdf', methods=['POST'])
def generate_pdf():
    data = request.form.to_dict()

    # Convert form data into the format expected by makesimplePDF.py
    main_data = {
        "school": data.get("school", ""),
        "dept": data.get("dept", ""),
        "degree": data.get("degree", ""),
        "title": data.get("title", ""),
        "subtitle": data.get("subtitle", ""),
        "author": data.get("author", ""),
        "mprof": data.get("mprof", ""),
        "sprofi": data.get("sprofi", ""),
        "sprofii": data.get("sprofii", ""),
        "degreedate": data.get("degreedate", ""),
        "copyyear": data.get("copyyear", "")
    }

    abstract_data = {
        "abstract1": data.get("abstract1", ""),
        "abstract2": data.get("abstract2", "")
    }

    acknowledge_data = {
        "acknowledge": data.get("acknowledge", "")
    }

    introduction_data = {
        "introduction": data.get("introduction", "")
    }

    relateWork_data = {
        "relateWork": data.get("relateWork", "")
    }

    approach_data = {
        "approach": data.get("approach", "")
    }

    result_data = {
        "result": data.get("result", "")
    }

    conclusion_data = {
        "conclusion": data.get("conclusion", "")
    }
    
    data = request.form.to_dict()

    # 解析並處理參考文獻資料
    references_data = []
    reference_count = 1
    while True:
        reference = {
            'language': data.get(f'references[{reference_count}][language]'),
            'author': data.get(f'references[{reference_count}][author]'),
            'year': data.get(f'references[{reference_count}][year]'),
            'title': data.get(f'references[{reference_count}][title]'),
            'city': data.get(f'references[{reference_count}][city]'),
            'publisher': data.get(f'references[{reference_count}][publisher]'),
            'url': data.get(f'references[{reference_count}][url]', '')
        }

        if not reference['language']:
            break

        references_data.append(reference)
        reference_count += 1

    # 呼叫 `process_references` 函數處理參考文獻
    formatted_references = process_references(references_data)

    # 格式化為 LaTeX 格式
    formatted_references_latex = "\\chapter{參考文獻}\n"
    for i, reference in enumerate(formatted_references, start=1):
        formatted_references_latex += f"{i}. {reference}\n\n"

    # 渲染至 reference.tex
    reference_data = {
        "reference": formatted_references_latex
    }
    # 在 makesimplePDF.generate_pdf 中傳遞 reference_data
    pdf_path = makesimplePDF.generate_pdf(
        main_data, abstract_data, acknowledge_data, 
        introduction_data, relateWork_data, approach_data, 
        result_data, conclusion_data, reference_data
    )

    if pdf_path:
        return jsonify({'message': 'PDF generated successfully', 'pdf_path': pdf_path})
    else:
        return jsonify({'error': 'Failed to generate PDF'}), 500
    
@app.route('/ai_chat')
def chat_page():
    return render_template('chat.html')

@app.route("/ai_chat", methods=["POST"])
def chat():
    user_input = request.json.get("message")
    if not user_input:
        return jsonify({"error": "No input provided"}), 400

    # 根据不同页面或用户输入，提供不同的系统提示
    gpt_response = get_gpt_response(user_input)
    return jsonify({"response": gpt_response})

@app.route("/testchat", methods=['POST'])
def testchat():
    data = request.json
    user_input = data.get('message', '')  # 获取用户的输入
    response = get_canned_response(user_input)  # 根据输入获取罐头回复
    return jsonify({"response": response})  # 返回 JSON 响应



if __name__ == '__main__':
    app.run(debug=True)
