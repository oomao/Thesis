# -*- coding: utf-8 -*-
from transformers import pipeline, AutoTokenizer, AutoModelForCausalLM, AutoModelForSeq2SeqLM
from ckip_transformers.nlp import CkipWordSegmenter
from keybert import KeyBERT
from sklearn.feature_extraction.text import CountVectorizer
import mysql.connector

# 提取关键字的函数
def extract_keywords(text):
    stopwords = set("""
    的 了 和 是 在 也 不 有 這 我 就 你 他 她 之 都 而
    等 於 及 以 啊 哦 嗯 吧 呀 嘛 嘿 嗨 喂 與 或 又
    """.split())
    
    ws_driver = CkipWordSegmenter(model="bert-base")
    
    def tokenize_text(text):
        ws_result = ws_driver([text])
        chinese_words = ws_result[0]
        filtered_words = [word for word in chinese_words if (
            len(word) > 1 or word.isalnum()) and word not in stopwords]
        return filtered_words

    vectorizer = CountVectorizer(tokenizer=tokenize_text)
    kw_model = KeyBERT(model='intfloat/multilingual-e5-small')
    keywords = kw_model.extract_keywords(text, vectorizer=vectorizer)
    keyword_list = [keyword[0] for keyword in keywords]
    return keyword_list

# 生成关键字的函数
def generate_keywords(text):
    model_name = "p208p2002/llama-keyword-generator-zh2zh-120M"
    tokenizer = AutoTokenizer.from_pretrained(model_name, legacy=False)
    model = AutoModelForCausalLM.from_pretrained(model_name, use_safetensors=True)
    inputs = tokenizer(text, return_tensors="pt", max_length=1024, truncation=True)
    generate_ids = model.generate(inputs.input_ids, max_new_tokens=10)
    keywords = tokenizer.batch_decode(generate_ids, skip_special_tokens=True, clean_up_tokenization_spaces=False)[0]
    print("生成的文本：", keywords)
    keywords_parts = keywords.split("</s>")
    keywords_only = keywords_parts[0].strip()
    remaining_text = keywords_only.replace(text, '')
    unique_keywords = list(set(remaining_text.split('、')))
    cleaned_keywords = '、'.join(unique_keywords)
    return cleaned_keywords
