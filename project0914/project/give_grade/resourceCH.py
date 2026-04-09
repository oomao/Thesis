import re
from pyapa import pyapa

# 初始化 ApaCheck
apa_checker = pyapa.ApaCheck()

# 中文參考文獻格式的正則表達式
chinese_pattern = re.compile(
    r'^(?P<author>[\u4e00-\u9fa5A-Za-z\s]+)\.\s*\((?P<year>\d{4})\)\.\s*(?P<title>[\u4e00-\u9fa5A-Za-z\s]+)\.\s*(?P<city>[\u4e00-\u9fa5A-Za-z\s]+):\s*(?P<publisher>[\u4e00-\u9fa5A-Za-z\s]+)\.$'
)

def check_references(references):
    for ref in references:
        # 判斷是否為中文
        if re.search('[\u4e00-\u9fa5]', ref):
            # 去除多餘空格再進行匹配
            cleaned_ref = re.sub(r'\s+', ' ', ref).strip()
            match = chinese_pattern.match(cleaned_ref)
            if match:
                print(f"符合: {ref}")
            else:
                print(f"不符合: {ref}")
                # 檢查每一部分是否匹配
                author_match = re.match(r'^[\u4e00-\u9fa5]+$', match.group('author') if match else '')
                year_match = re.match(r'^\d{4}$', match.group('year') if match else '')
                title_match = re.match(r'^[\u4e00-\u9fa5]+$', match.group('title') if match else '')
                city_match = re.match(r'^[\u4e00-\u9fa5]+$', match.group('city') if match else '')
                publisher_match = re.match(r'^[\u4e00-\u9fa5]+$', match.group('publisher') if match else '')
  
        else:
            print(f"檢查英文文本: {ref}")
            apa_checker.match(ref)
            
            found_error = False
            if len(apa_checker.Matches) > 0:
                for match in apa_checker.Matches:
                    # 去掉目標中的首尾括號
                    target_without_parentheses = match.target.strip("()")
                    feedback = match.feedback
                    # 忽略 "If this is an article title, consider using lowercase." 的反饋
                    if "If this is an article title, consider using lowercase." not in feedback:
                        found_error = True
                        print(f"匹配範圍: {match.start} 到 {match.end}")
                        print(f"目標: {target_without_parentheses}")
                        print(f"反饋: {feedback}")
                        print(f"建議: {match.suggestions}")

            if not found_error:
                print("符合 APA 格式")
        
        print()  # 空行分隔不同的檢查結果

# 範例參考文獻列表
references = [
    # u"Smith, J. A. (2020). Understanding programming. New York: Coding Press.",
    # u"王明. (1234). programing编程入门. 北京: 机械工业出版社.",
    # u"李四. (2018). 学习. 上海: 华东理工大学出版社.",
    u"不正确的格式 2020, 错误城市: 错误出版社.",
    u"Kim, A. (2020, August 28). How I Became a Full-Time Freelance Editor (and How You Can, Too). Medium. https://medium.com/wordviceediting/how-i-became-a-full-time-freelance-editor-and-how-you-can-too-7e694d1792bc"
    u"Tshitoyan, V., Dagdelen, J., Weston, L., Dunn, A., Rong, Z., Kononova, O., Persson, K. A., Cedar, G., & Jain, A. (2019). Unsupervised word embeddings capture latent knowledge from material science literature. Nature, 571, 95-98. https://www.nature.com/articles/s41586-019-1335-8",
]

check_references(references)
