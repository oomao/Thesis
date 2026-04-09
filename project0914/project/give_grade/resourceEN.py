import re
from pyapa import pyapa

# 初始化 ApaCheck
apa_checker = pyapa.ApaCheck()

# 中文參考文獻格式的正則表達式，允許中英混合
chinese_pattern = re.compile(
    r'^(?P<author>[\u4e00-\u9fa5A-Za-z\s]+)\.\s*\((?P<year>\d{4})\)\.\s*(?P<title>[\u4e00-\u9fa5A-Za-z\s]+)\.\s*(?P<city>[\u4e00-\u9fa5A-Za-z\s]+):\s*(?P<publisher>[\u4e00-\u9fa5A-Za-z\s]+)\.$'
)

def generate_apa_reference(author, year, title, publisher, location):
    """
    根據提供的信息生成 APA 格式的參考文獻。

    :param author: 作者名字 (例如 "Smith, J. A." 或 "王明")
    :param year: 發表年份 (例如 "2020")
    :param title: 書名 (例如 "Understanding programming" 或 "编程入门")
    :param publisher: 出版社 (例如 "Coding Press" 或 "机械工业出版社")
    :param location: 出版地 (例如 "New York" 或 "北京")
    :return: 格式化的 APA 參考文獻字符串
    """
    return f"{author} ({year}). {title}. {location}: {publisher}."

def check_reference(ref):
    """
    檢查參考文獻是否符合 APA 格式。

    :param ref: 參考文獻字符串
    :return: 檢查結果
    """
    # 判斷是否為中文
    if re.search('[\u4e00-\u9fa5]', ref):
        # 去除多餘空格再進行匹配
        cleaned_ref = re.sub(r'\s+', ' ', ref).strip()
        match = chinese_pattern.match(cleaned_ref)
        if match:
            return "符合: " + ref
        else:
            result = "不符合: " + ref + "\n"
            # 檢查每一部分是否匹配
            author_match = re.match(r'^[\u4e00-\u9fa5A-Za-z\s]+$', match.group('author') if match else '')
            year_match = re.match(r'^\d{4}$', match.group('year') if match else '')
            title_match = re.match(r'^[\u4e00-\u9fa5A-Za-z\s]+$', match.group('title') if match else '')
            city_match = re.match(r'^[\u4e00-\u9fa5A-Za-z\s]+$', match.group('city') if match else '')
            publisher_match = re.match(r'^[\u4e00-\u9fa5A-Za-z\s]+$', match.group('publisher') if match else '')
            
            # if not author_match:
            #     result += "作者部分格式不正確\n"
            # if not year_match:
            #     result += "年份部分格式不正確\n"
            # if not title_match:
            #     result += "標題部分格式不正確\n"
            # if not city_match:
            #     result += "出版地部分格式不正確\n"
            # if not publisher_match:
            #     result += "出版社部分格式不正確\n"
            return result.strip()
    else:
        apa_checker.match(ref)
        found_error = False
        result = "檢查英文文本: " + ref + "\n"
        if len(apa_checker.Matches) > 0:
            for match in apa_checker.Matches:
                # 去掉目標中的首尾括號
                target_without_parentheses = match.target.strip("()")
                feedback = match.feedback
                # 忽略 "If this is an article title, consider using lowercase." 的反饋
                if "If this is an article title, consider using lowercase." not in feedback:
                    found_error = True
                    result += f"匹配範圍: {match.start} 到 {match.end}\n"
                    result += f"目標: {target_without_parentheses}\n"
                    result += f"反饋: {feedback}\n"
                    result += f"建議: {match.suggestions}\n"
        if not found_error:
            result += "符合 APA 格式"
        return result.strip()

def get_user_input():
    """
    獲取用戶輸入的參考文獻信息。

    :return: 用戶輸入的參考文獻信息
    """
    author = input("請輸入作者名字（格式：Smith, J. A. 或 王明）：")
    year = input("請輸入發表年份（格式：2020）：")
    title = input("請輸入書名（格式：Understanding programming 或 编程入门）：")
    publisher = input("請輸入出版社（格式：Coding Press 或 机械工业出版社）：")
    location = input("請輸入出版地（格式：New York 或 北京）：")
    return author, year, title, publisher, location

def main():
    print("APA 參考文獻格式生成器")
    author, year, title, publisher, location = get_user_input()
    apa_reference = generate_apa_reference(author, year, title, publisher, location)
    print("生成的 APA 參考文獻格式：")
    print(apa_reference)
    print("\n檢查結果：")
    print(check_reference(apa_reference))

if __name__ == "__main__":
    main()
