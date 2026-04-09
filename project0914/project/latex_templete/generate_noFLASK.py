import re

def is_english(text):
    """檢查是否是英文（只包含英文字母、數字和常用標點符號）"""
    return bool(re.match(r'^[A-Za-z0-9\s,.\-:;()\'&]+$', text))

def is_chinese(text):
    """檢查是否是中文（只包含中文字符）"""
    return bool(re.match(r'^[\u4e00-\u9fa5\s]+$', text))

def process_references(references):
    formatted_references = []
    
    for ref in references:
        language = ref.get('language', '').lower()
        author = ref.get('author', '')
        year = ref.get('year', '')
        title = ref.get('title', '')
        publisher = ref.get('publisher', '')
        city = ref.get('city', '')
        url = ref.get('url', '')

        if language == '英文':
            # 生成APA格式的英文參考文獻
            reference = f"{author} ({year}). {title}. {city}: {publisher}."
            if url:
                reference += f" {url}"
        elif language == '中文':
            # 生成APA格式的中文參考文獻
            reference = f"{author} ({year}). {title}. {city}: {publisher}."
        else:
            reference = "無效的語言類型"

        formatted_references.append(reference)

    return formatted_references
