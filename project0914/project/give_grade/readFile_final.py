import filetype
import re
from PyPDF2 import PdfReader
from ai_detection.predict import ai_detector_for


def remove_footnotes(text, currentNumber):
    tempnumber = 0
    lines = text.split("\n")
    cleaned_lines = []
    uncleaned_lines = []
    firstnum = False  # 去掉頁碼
    clean = False
    for line in lines:
        if clean:  # 後面都是腳註
            if (line.lstrip().startswith(tuple("0123456789"))):
                nextNumber = int(''.join(filter(str.isdigit, line.split()[0])))
                if nextNumber == currentNumber + 1:
                    currentNumber = nextNumber
            if line:
                uncleaned_lines.append(line)
        else:
            if line.strip() and line.lstrip().startswith(tuple("0123456789")) and firstnum == False:
                firstnum = True
            elif line.strip() and not line.lstrip().startswith(tuple("0123456789")):
                cleaned_lines.append(line)
            elif line.strip() and line.lstrip().startswith(tuple("0123456789")) and firstnum == True:
                nextNumber = int(''.join(filter(str.isdigit, line.split()[0])))
                if nextNumber == currentNumber + 1:
                    currentNumber = nextNumber
                    clean = True
                    uncleaned_lines.append(line)
                else:
                    clean = False
    tempnumber = currentNumber
    return "\n".join(cleaned_lines), "\n".join(uncleaned_lines), tempnumber


def readPDF(fileurl):
    reader = PdfReader(fileurl)
    number_of_pages = len(reader.pages)
    abstract = [0, 0]

    for i in range(number_of_pages):
        page = reader.pages[i]
        text = page.extract_text()
        if text and "目錄" in text:
            abstract[0] = i
        if text and "參考文獻" in text:
            abstract[1] = i
            break

    firstpage = 0
    for i in range(number_of_pages):
        page = reader.pages[i]
        text = page.extract_text()
        if text and text.strip():
            first_char = text.strip()[0]
            if first_char == "1":
                firstpage = i
                break

    text = ""
    if abstract[0] == abstract[1] or abstract[1] == 0:
        page = reader.pages[abstract[0]]
        text += page.extract_text()
    else:
        for i in range(abstract[0], abstract[1]+1):
            page = reader.pages[i]
            text += page.extract_text()

    lines = text.strip().split('\n')
    sections = []

    for line in lines:
        line = line.replace('.', '')
        line = line.split('、', 1)[-1].strip()
        match = re.match(r'^(.*?)(\s+)(\S+)$', line)
        if match:
            section_title = match.group(1).strip()
            page_number = match.group(3).strip()
            sections.append([section_title, page_number])

    values_list = [section[1] for section in sections]
    subject_list = [section[0] for section in sections]

    Arabic = False
    data = []
    currentNumber = 0
    equal = False
    for i in range(len(values_list)):
        if values_list[i] == "1":
            Arabic = True
        if Arabic:
            if i+1 < len(values_list):
                start_page = int(values_list[i])
                end_page = int(values_list[i + 1])
                if start_page != end_page:
                    end_page -= 1
                else:
                    equal = True
                text = ""
                footnote = ""
                for y in range(start_page, end_page+1):
                    page = reader.pages[y+firstpage-1]
                    temp = remove_footnotes(page.extract_text(), currentNumber)
                    text += temp[0] + "\n"
                    footnote += temp[1] + "\n"
                    if equal:
                        equal = False
                    else:
                        currentNumber = temp[2]
                data.append([subject_list[i], text, start_page,
                            end_page, footnote, 0, 0,0.0, False])
            else:
                start_page = int(values_list[i])
                end_page = number_of_pages-firstpage
                text = ""
                footnote = ""
                for y in range(start_page, end_page+1):
                    page = reader.pages[y+firstpage-1]
                    text += page.extract_text()
                data.append([subject_list[i], text, start_page,
                            end_page, footnote, 0,0,0.0, False])
    # data[0]:標題 data[1]:內文 data[2]:起始頁數 data[3]:結束頁數 data[4]:腳註 data[5]:相似度總句數 data[6]:相似度ai句數 data[7]:ai機率 data[8]:是否要查詢
    return data


def runModels(data):
    for i in range(len(data)):
        if data[i][8]==True:
            if data[i][0] != "參考文獻":
                reData=ai_detector_for(data[i][1])
                print(reData[0])
                print(reData[1])
                print(reData[2])
                # print(data[i][1])
                data[i][5] = reData[0]
                data[i][6] = reData[1]
                data[i][7] = reData[2]
            else:
                break


def evaluate_paper(file_path):
    kind = filetype.guess(file_path)
    if kind is not None:
        if kind.mime == 'application/pdf':
            return readPDF(file_path)
        elif kind.mime == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            return 'This is a DOCX File'
    return 'Unknown file type'
