from transformers import AutoModelForSequenceClassification, AutoTokenizer, TextClassificationPipeline
import torch
import re
import json

# 要切割的文本
def ai_detector(text):
        # 使用正則表達式根據句號、問號和感嘆號進行切割
        sentences = re.split(r'(?<=[。！？])\s*', text)
        
        # 移除可能出現的空字符串
        sentences = [sentence for sentence in sentences if sentence]
        grouped_sentences = [''.join(sentences[i:i+1]) for i in range(0, len(sentences), 2)]
        print(grouped_sentences)
        # 輸出切割後的句子列表
        #print(sentences)

        device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
        model = AutoModelForSequenceClassification.from_pretrained(
                'D:/project/ai_detection/checkpoint-best'
        ).to(device)
        tokenizer = AutoTokenizer.from_pretrained('hfl/chinese-macbert-base')
        predictor = TextClassificationPipeline(
                        model=model, tokenizer=tokenizer,
                        device=-1 if model.device.type == 'cpu' else model.device.index
                )
        return_data = {}
        for sentence in grouped_sentences:
                output_data = predictor(sentence)
                if output_data[0]['label'] == 'LABEL_0':
                        return_data[sentence] = round(1 - output_data[0]['score'], 4)
                else:
                        return_data[sentence] = round(output_data[0]['score'], 4)

        for setence in return_data:
                print(setence, return_data[setence])
        return return_data

def ai_detector_for(text):
        # 使用正則表達式根據句號、問號和感嘆號進行切割
        sentences = re.split(r'(?<=[。！？])\s*', text)
        
        # 移除可能出現的空字符串
        sentences = [sentence for sentence in sentences if sentence]
        grouped_sentences = [''.join(sentences[i:i+1]) for i in range(0, len(sentences), 2)]
        # print(grouped_sentences)
        # 輸出切割後的句子列表
        #print(sentences)

        device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
        model = AutoModelForSequenceClassification.from_pretrained(
                'D:/project/ai_detection/checkpoint-best'
        ).to(device)
        tokenizer = AutoTokenizer.from_pretrained('hfl/chinese-macbert-base')
        predictor = TextClassificationPipeline(
                        model=model, tokenizer=tokenizer,
                        device=-1 if model.device.type == 'cpu' else model.device.index
                )
        isai = 0
        noai = 0
        for sentence in grouped_sentences:
                output_data = predictor(sentence)
                if output_data[0]['label'] == 'LABEL_0':
                        noai += 1
                else:
                        isai += 1

        print(noai, isai)
        flor = noai + isai
        if(flor == 0):
                flor += 1
        # return float(isai/(flor))
        return isai,flor,float(isai/(flor))
