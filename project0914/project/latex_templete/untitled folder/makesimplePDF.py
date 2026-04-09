# import shutil
# import subprocess
# import os
# from jinja2 import Template

# # 主文件的数据
# main_data = {
#     "dept": "{XXX研究所}",
#     "degree": "{碩/博士}",
#     "title": "中文論文名稱",
#     "subtitle": "English Thesis Title",
#     "author": "{Santwei}",
#     "mprof": "指導教授",
#     "sprofi": "共同指導教授",
#     "sprofii": "共同指導教授2",
#     "degreedate": "中~華~民~國~一百零五~年~六~月",
#     "copyyear": "2016-2017"
# }

# abstract_data = {
#     "abstract1": "{中文摘要123}",
#     "abstract2": "{英文摘要123}"
# }

# acknowledge_data = {
#     "acknowledge": "{致謝123}"
# }

# # 波魚新增的部分
# introduction_data = {
#     "introduction": "{壓哈哈}"
# }

# relateWork_data = {
#     "relateWork": "{相關餔餔}"
# }

# approach_data = {
#     "approach": "{研究的方法ㄚㄚ}"
# }

# conclusion_data = {
#     "conclusion": "{趕快結束拉}"
# }
# # 波魚新增的部分
# # 读取 Main.tex 文件内容
# main_path = r'D:\\project\\latex_templete\\untitled folder\\Main.tex'
# with open(main_path, 'r', encoding='utf-8') as file:
#     main_template_content = file.read()
# main_template = Template(main_template_content)
# main_latex_content = main_template.render(main_data)

# abstractcn_path = r'D:\\project\\latex_templete\\untitled folder\\abstractcn.tex'
# with open(abstractcn_path, 'r', encoding='utf-8') as file:
#     abstractcn_template_content = file.read()
# abstractcn_template = Template(abstractcn_template_content)
# abstractcn_latex_content = abstractcn_template.render(abstract_data)

# abstracten_path = r'D:\\project\\latex_templete\\untitled folder\\abstracten.tex'
# with open(abstracten_path, 'r', encoding='utf-8') as file:
#     abstracten_template_content = file.read()
# abstracten_template = Template(abstracten_template_content)
# abstracten_latex_content = abstracten_template.render(abstract_data)

# acknowledge_path = r'D:\\project\\latex_templete\\untitled folder\\acknowledge.tex'
# with open(acknowledge_path, 'r', encoding='utf-8') as file:
#     acknowledge_template_content = file.read()
# acknowledge_template = Template(acknowledge_template_content)
# acknowledge_latex_content = acknowledge_template.render(acknowledge_data)

# lists_path = r'D:\\project\\latex_templete\\untitled folder\\lists.tex'
# with open(lists_path, 'r', encoding='utf-8') as file:
#     list_template_content = file.read()
#     list_template = Template(list_template_content)
#     list_template_content = list_template.render(acknowledge_data)

# introduction_path = r'D:\\project\\latex_templete\\untitled folder\\introduction.tex'
# # 波魚增加的部分
# with open(introduction_path, 'r', encoding='utf-8') as file:
#     introduction_template_content = file.read()
#     introduction_template = Template(introduction_template_content)
#     introduction_template_content = introduction_template.render(introduction_data)

# relateWork_path = r'D:\\project\\latex_templete\\untitled folder\\relateWork.tex'
# with open(relateWork_path, 'r', encoding='utf-8') as file:
#     relateWork_template_content = file.read()
#     relateWork_template = Template(relateWork_template_content)
#     relateWork_template_content = relateWork_template.render(relateWork_data)

# approach_path = r'D:\\project\\latex_templete\\untitled folder\\approach.tex'
# with open(approach_path, 'r', encoding='utf-8') as file:
#     approach_template_content = file.read()
#     approach_template = Template(approach_template_content)
#     approach_template_content = approach_template.render(approach_data)

# conclusion_path = r'D:\\project\\latex_templete\\untitled folder\\conclusion.tex'
# with open(conclusion_path, 'r', encoding='utf-8') as file:
#     conclusion_template_content = file.read()
#     conclusion_template = Template(conclusion_template_content)
#     conclusion_template_content = conclusion_template.render(conclusion_data)

# mypreamble_path = r'D:\\project\\latex_templete\\untitled folder\\mypreamble.tex'
# with open(mypreamble_path, 'r', encoding='utf-8') as file:
#     mypreamble_template_content = file.read()
#     # conclusion_template = Template(conclusion_template_content)
#     # conclusion_template_content = conclusion_template.render(conclusion_data)    
# # with open('ncuthesisXe.cls', 'r', encoding='utf-8') as file:
# #     ncuthesisXe_template_content = file.read()
# #     ncuthesisXe_template = Template(ncuthesisXe_template_content)
# # 波魚增加的部分

# # 将新的摘要内容写入新的文件到 output_folder
# output_folder = 'output_folder'
# if not os.path.exists(output_folder):
#     os.makedirs(output_folder)

# source_file = r'D:\\project\\latex_templete\\untitled folder\\ncuthesisXe.cls'
# destination_folder = 'output_folder'
# os.makedirs(destination_folder, exist_ok=True)
# destination_file = os.path.join(destination_folder, 'ncuthesisXe.cls')
# shutil.copy2(source_file, destination_file)

# with open(os.path.join(output_folder, 'abstractcn.tex'), 'w', encoding='utf-8') as file:
#     file.write(abstractcn_latex_content)

# with open(os.path.join(output_folder, 'abstracten.tex'), 'w', encoding='utf-8') as file:
#     file.write(abstracten_latex_content)

# with open(os.path.join(output_folder, 'acknowledge.tex'), 'w', encoding='utf-8') as file:
#     file.write(acknowledge_latex_content)

# with open(os.path.join(output_folder, 'lists.tex'), 'w', encoding='utf-8') as file:
#     file.write(list_template_content)

# #波魚新增的部分
# with open(os.path.join(output_folder, 'introduction.tex'), 'w', encoding='utf-8') as file:
#     file.write(introduction_template_content) 

# with open(os.path.join(output_folder, 'relateWork.tex'), 'w', encoding='utf-8') as file:
#     file.write(relateWork_template_content) 

# with open(os.path.join(output_folder, 'approach.tex'), 'w', encoding='utf-8') as file:
#     file.write(approach_template_content) 

# with open(os.path.join(output_folder, 'conclusion.tex'), 'w', encoding='utf-8') as file:
#     file.write(conclusion_template_content) 

# with open(os.path.join(output_folder, 'mypreamble.tex'), 'w', encoding='utf-8') as file:
#     file.write(mypreamble_template_content) 
# #波魚新增的部分

# with open(os.path.join(output_folder, 'Main.tex'), 'w', encoding='utf-8') as file:
#     file.write(main_latex_content)    
# # 生成 PDF 文件
# try:
#     # subprocess.run(['xelatex', '-output-directory', output_folder, '-jobname=simple', os.path.join(output_folder, 'Main.tex')], check=True)
#     os.chdir(output_folder)
#     subprocess.run(['xelatex', '-jobname=simple', 'Main.tex'], check=True)
#     print('PDF generated successfully.')

#     # 打开生成的 PDF 文件
#     # pdf_file = os.path.join(output_folder, 'simple.pdf')
#     # if os.path.exists(output_folder):
#     os.startfile('simple.pdf')  # macOS 打开 PDF 文件的命令
#     # else:
#     #     print(f"PDF file {pdf_file} not found.")
        
# except subprocess.CalledProcessError as e:
#     print(f"Error occurred while generating PDF: {e}")

#     # 读取并打印日志文件内容
#     log_file = 'Main.log'
#     if os.path.exists(log_file):
#         with open(log_file, 'r', encoding='utf-8') as log_file:
#             log_content = log_file.read()
#             print(log_content)
#     else:
#         print(f"Log file {log_file} not found.")

import shutil
import subprocess
import os
from jinja2 import Template

def render_template(template_path, data):
    with open(template_path, 'r', encoding='utf-8') as file:
        template_content = file.read()
    template = Template(template_content, variable_start_string='<<', variable_end_string='>>')
    return template.render(data)

def generate_pdf(main_data, abstract_data, acknowledge_data, introduction_data, relateWork_data, approach_data, result_data, conclusion_data, reference_data):
    templates_dir = r'D:\\project\\latex_templete\\untitled folder'
    
    # 渲染 LaTeX 文件內容
    main_latex_content = render_template(os.path.join(templates_dir, 'Main.tex'), main_data)
    abstractcn_latex_content = render_template(os.path.join(templates_dir, 'abstractcn.tex'), abstract_data)
    abstracten_latex_content = render_template(os.path.join(templates_dir, 'abstracten.tex'), abstract_data)
    acknowledge_latex_content = render_template(os.path.join(templates_dir, 'acknowledge.tex'), acknowledge_data)
    introduction_latex_content = render_template(os.path.join(templates_dir, 'introduction.tex'), introduction_data)
    relateWork_latex_content = render_template(os.path.join(templates_dir, 'relateWork.tex'), relateWork_data)
    approach_latex_content = render_template(os.path.join(templates_dir, 'approach.tex'), approach_data)
    result_latex_content = render_template(os.path.join(templates_dir, 'result.tex'),  result_data)
    conclusion_latex_content = render_template(os.path.join(templates_dir, 'conclusion.tex'), conclusion_data)
    reference_latex_content = render_template(os.path.join(templates_dir, 'reference.tex'), reference_data)

    # 讀取 list 和 mypreamble 的模板內容
    lists_path = os.path.join(templates_dir, 'lists.tex')
    mypreamble_path = os.path.join(templates_dir, 'mypreamble.tex')
    
    with open(lists_path, 'r', encoding='utf-8') as file:
        list_template_content = file.read()
        
    with open(mypreamble_path, 'r', encoding='utf-8') as file:
        mypreamble_template_content = file.read()

    # 創建輸出目錄
    output_folder = r'D:\\project\\latex_templete\\output folder'
    if not os.path.exists(output_folder):
        os.makedirs(output_folder)

    # 複製所需的 cls 文件
    source_file = os.path.join(templates_dir, 'ncuthesisXe.cls')
    destination_file = os.path.join(output_folder, 'ncuthesisXe.cls')
    shutil.copy2(source_file, destination_file)

    # 將渲染後的內容寫入文件
    def write_to_file(output_path, content):
        with open(output_path, 'w', encoding='utf-8') as file:
            file.write(content)

    write_to_file(os.path.join(output_folder, 'Main.tex'), main_latex_content)
    write_to_file(os.path.join(output_folder, 'abstractcn.tex'), abstractcn_latex_content)
    write_to_file(os.path.join(output_folder, 'abstracten.tex'), abstracten_latex_content)
    write_to_file(os.path.join(output_folder, 'acknowledge.tex'), acknowledge_latex_content)
    write_to_file(os.path.join(output_folder, 'lists.tex'), list_template_content)
    write_to_file(os.path.join(output_folder, 'introduction.tex'), introduction_latex_content)
    write_to_file(os.path.join(output_folder, 'relateWork.tex'), relateWork_latex_content)
    write_to_file(os.path.join(output_folder, 'approach.tex'), approach_latex_content)
    write_to_file(os.path.join(output_folder, 'result.tex'), result_latex_content)
    write_to_file(os.path.join(output_folder, 'conclusion.tex'), conclusion_latex_content)
    write_to_file(os.path.join(output_folder, 'reference.tex'), reference_latex_content)
    write_to_file(os.path.join(output_folder, 'mypreamble.tex'), mypreamble_template_content)
    

    # 生成 PDF 文件
    try:
        os.chdir(output_folder)
        subprocess.run(['xelatex', '-jobname=simple', 'Main.tex'], check=True)
        print('PDF generated successfully.')
        pdf_file = os.path.join(output_folder, 'simple.pdf')
        if os.path.exists(pdf_file):
            os.startfile('simple.pdf')  # windows 打开 PDF 文件的命令
        else:
            print(f"PDF file {pdf_file} not found.")
        return os.path.join(output_folder, 'simple.pdf')

    except subprocess.CalledProcessError as e:
        print(f"Error occurred while generating PDF: {e}")
        return None
