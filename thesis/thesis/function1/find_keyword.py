# -*- coding: utf-8 -*-
from transformers import pipeline, AutoTokenizer, AutoModelForCausalLM

# text = """氣體感測器是用於檢測和量化周圍環境中各種氣體存在的重要設備。它們在許多產業中扮演及其關鍵的角色，包含了環境汙染氣體的監測、工業安全、交通工具廢氣排出控制、室內空氣品質評估和醫療保健。氣體感測器提供氣體濃度的即時數據，從而能夠及時採取行動以減輕潛在危險並確保安全並符合氣體監控標準。氣體感測器依據不同的感測方式及技術又分類成不同種類，包括化學電阻、紅外線、光學等等。
# 　　在化學電阻感測器中，有一類被稱作是金屬氧化物半導體感測器，其為透過金屬氧化物與測量的目標氣體結合時所產生的電阻變化率來檢測周遭環境的特定目標氣體濃度大小。因金屬氧化半導體感測器雖然對特定氣體的反應時間較為迅速以及較高靈敏度，不過其仍舊極度容易受到周圍環境的溼度、溫度等等影響，且其需要定期校準才能夠維持此標準。本次研究即是以二氧化錫為前驅物感測材料，將其以硒化機與硒粒進行反應後，檢測層主要以硒化錫為材料，檢測其在四吋晶圓上初期的電阻值、四個象限的電阻分布、及其在不同溫度硒化的情況下初始電阻值的差異，以展示本論文整合半導體製程技術與在製程可控之硒化溫度區間內，所大量且低成本的製備氣體感測器元件陣列，在室溫下於晶圓上的初始電阻值的均一性極佳，提供新穎二維材料感測器商業化的解決方案。"""
text = ""
def generate_keywords(text):
    # 加載模型和分詞器，設置 legacy=False
    model_name = "p208p2002/llama-keyword-generator-zh2zh-120M"
    tokenizer = AutoTokenizer.from_pretrained(model_name, legacy=False)
    model = AutoModelForCausalLM.from_pretrained(model_name)
    inputs = tokenizer(text, return_tensors="pt",
                       max_length=1024, truncation=True)
    generate_ids = model.generate(inputs.input_ids, max_new_tokens=50)
    keywords = tokenizer.batch_decode(
        generate_ids, skip_special_tokens=True, clean_up_tokenization_spaces=False)[0]

    # 分割生成的文本
    keywords_parts = keywords.split("</s>")

    # 選取第一個部分，這是包含關鍵詞的部分
    keywords_only = keywords_parts[0].strip()

    # 去除 text 中的部分
    remaining_text = keywords_only.replace(text, '')

    # 返回生成的關鍵詞
    return remaining_text
# questions=input("請輸入text：")
# keywords = generate_keywords(questions)


keywords = generate_keywords(text)
print("生成的關鍵詞：", keywords)
