from flask import Flask, request, jsonify
from find_keyword import generate_keywords
from flask_cors import CORS  # 引入CORS

app = Flask(__name__)
CORS(app)  # 允許所有來源訪問，可以根據需要進行細節配置
@app.route('/search_back', methods=['POST'])
def find_keywords():
    data = request.get_json()
    text = data.get('text', '')
    keywords = generate_keywords(text)
    return jsonify({'keywords': keywords})

if __name__ == '__main__':
    app.run(debug=True)
